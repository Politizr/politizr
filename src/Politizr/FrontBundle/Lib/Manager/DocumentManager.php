<?php
namespace Politizr\FrontBundle\Lib\Manager;

use Politizr\Exception\InconsistentDataException;

use Politizr\Constant\ObjectTypeConstants;
use Politizr\Constant\ReputationConstants;

use Politizr\Model\PDDebate;
use Politizr\Model\PDReaction;
use Politizr\Model\PDRTaggedT;

use Politizr\Model\PDDebateQuery;
use Politizr\Model\PDReactionQuery;

/**
 * DB manager service for document.
 *
 * @author Lionel Bouzonville
 */
class DocumentManager
{
    private $globalTools;

    private $logger;

    /**
     *
     * @param @politizr.tools.global
     * @param @logger
     */
    public function __construct($globalTools, $logger)
    {
        $this->globalTools = $globalTools;
        
        $this->logger = $logger;
    }

    /* ######################################################################################################## */
    /*                                                  RAW SQL                                                 */
    /* ######################################################################################################## */

   /**
     * Debate feed timeline
     *
     * @see app/sql/debateFeed.sql
     * @return string
     */
    public function createDebateFeedRawSql()
    {
        // Préparation requête SQL
        $sql = "
( SELECT p_d_reaction.id as id, p_d_reaction.title as title, p_d_reaction.description as summary, p_d_reaction.published_at as published_at, 'Politizr\\\Model\\\PDReaction' as type
FROM p_d_reaction
WHERE
    p_d_reaction.published = 1
    AND p_d_reaction.online = 1
    AND p_d_reaction.p_d_debate_id = :p_d_debate_id
    AND p_d_reaction.tree_level > 0
)

UNION DISTINCT

( SELECT p_d_d_comment.id as id, \"commentaire\" as title, p_d_d_comment.description as summary, p_d_d_comment.published_at as published_at, 'Politizr\\\Model\\\PDDComment' as type
FROM p_d_d_comment
WHERE
    p_d_d_comment.online = 1
    AND p_d_d_comment.p_d_debate_id = :p_d_debate_id2
    AND p_d_d_comment.p_user_id IN (:inQueryUserIds)
)

UNION DISTINCT

( SELECT p_d_r_comment.id as id, \"commentaire\" as title, p_d_r_comment.description as summary, p_d_r_comment.published_at as published_at, 'Politizr\\\Model\\\PDRComment' as type
FROM p_d_r_comment
WHERE 
    p_d_r_comment.online = 1
    AND p_d_r_comment.p_d_reaction_id IN (
        # Requête \"Réactions descendantes au débat courant\"
        SELECT p_d_reaction.id as id
        FROM p_d_reaction
        WHERE
            p_d_reaction.published = 1
            AND p_d_reaction.online = 1
            AND p_d_reaction.p_d_debate_id = :p_d_debate_id3
            AND p_d_reaction.tree_level > 0
            )
            AND p_d_r_comment.p_user_id IN (:inQueryUserIds2)
    )

ORDER BY published_at ASC
    ";

        return $sql;
    }

   /**
     * My documents (drafts / publications)
     *
     * @see app/sql/myDocuments.sql
     *
     * @param string $orderBy
     * @return string
     */
    private function createMyDocumentsRawSql($orderBy = 'published_at')
    {
        $sql = "
( SELECT p_d_reaction.id as id, p_d_reaction.title as title, p_d_reaction.published_at as published_at, p_d_reaction.updated_at as updated_at, 'Politizr\\\Model\\\PDReaction' as type
FROM p_d_reaction
WHERE
    p_user_id = :p_user_id
    AND p_d_reaction.published = :published
    AND p_d_reaction.online = 1
)

UNION DISTINCT

( SELECT p_d_debate.id as id, p_d_debate.title as title, p_d_debate.published_at as published_at, p_d_debate.updated_at as updated_at, 'Politizr\\\Model\\\PDDebate' as type
FROM p_d_debate
WHERE
    p_user_id = :p_user_id2
    AND p_d_debate.published = :published2
    AND p_d_debate.online = 1
)

ORDER BY $orderBy DESC
LIMIT :offset, :count
    ";

        return $sql;
    }

    /**
     * Document's notes evolution group by date
     *
     * @see app/sql/stats.sql
     *
     * @return string
     */
    private function createNotesByDateRawSql()
    {
        $sql = "
SELECT
    DATE(p_u_reputation.id) as ID,
    p_u_reputation.id,
    DATE(p_u_reputation.created_at) as DATE,
    COUNT(CASE WHEN p_u_reputation.p_r_action_id = :notePosReputationId THEN 1 END) AS COUNT_NOTE_POS,
    COUNT(CASE WHEN p_u_reputation.p_r_action_id = :noteNegReputationId THEN 1 END) AS COUNT_NOTE_NEG
FROM `p_u_reputation` LEFT JOIN `p_r_action` ON p_u_reputation.p_r_action_id = p_r_action.id
WHERE
p_u_reputation.p_object_name = :documentType
AND p_u_reputation.p_object_id = :documentId
AND (p_u_reputation.p_r_action_id = :notePosReputationId2 OR p_u_reputation.p_r_action_id = :noteNegReputationId2)
AND p_u_reputation.created_at >= :startAt
AND p_u_reputation.created_at < :endAt
GROUP BY DATE(p_u_reputation.created_at)
        ";

        return $sql;
    }

    /**
     * Document's notes sum until date
     *
     * @see app/sql/stats.sql
     *
     * @return string
     */
    private function createSumOfNotesRawSql()
    {
        $sql = "
SELECT
    COUNT(CASE WHEN p_u_reputation.p_r_action_id = :notePosReputationId THEN 1 END) AS COUNT_NOTE_POS,
    COUNT(CASE WHEN p_u_reputation.p_r_action_id = :noteNegReputationId THEN 1 END) AS COUNT_NOTE_NEG
FROM `p_u_reputation` LEFT JOIN `p_r_action` ON p_u_reputation.p_r_action_id = p_r_action.id
WHERE
p_u_reputation.p_object_name = :documentType
AND p_u_reputation.p_object_id = :documentId
AND (p_u_reputation.p_r_action_id = :notePosReputationId2 OR p_u_reputation.p_r_action_id = :noteNegReputationId2)
AND p_u_reputation.created_at < :untilAt
        ";

        return $sql;
    }

    /* ######################################################################################################## */
    /*                                            RAW SQL OPERATIONS                                            */
    /* ######################################################################################################## */

    /**
     * My documents paginated listing
     *
     * @param integer $userId
     * @param integer $published
     * @param string $orderBy
     * @param integer $offset
     * @param integer $count
     * @return string
     */
    public function generateMyDocumentsPaginatedListing($userId, $published, $orderBy, $offset, $count)
    {
        $this->logger->info('*** generateMyDocumentsPaginatedListing');
        $this->logger->info('$userId = ' . print_r($userId, true));
        $this->logger->info('$published = ' . print_r($published, true));
        $this->logger->info('$orderBy = ' . print_r($orderBy, true));
        $this->logger->info('$offset = ' . print_r($offset, true));
        $this->logger->info('$count = ' . print_r($count, true));

        $con = \Propel::getConnection('default', \Propel::CONNECTION_READ);
        $stmt = $con->prepare($this->createMyDocumentsRawSql($orderBy));

        $stmt->bindValue(':p_user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':p_user_id2', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':published', $published, \PDO::PARAM_INT);
        $stmt->bindValue(':published2', $published, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':count', $count, \PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetchAll();

        $documents = new \PropelCollection();
        $i = 0;
        foreach ($result as $row) {
            $type = $row['type'];

            if ($type == ObjectTypeConstants::TYPE_DEBATE) {
                $document = PDDebateQuery::create()->findPk($row['id']);
            } elseif ($type == ObjectTypeConstants::TYPE_REACTION) {
                $document = PDReactionQuery::create()->findPk($row['id']);
            } else {
                throw new InconsistentDataException(sprintf('Object type %s unknown.', $type));
            }
            
            $documents->set($i, $document);
            $i++;
        }

        return $documents;
    }
    
    /**
     * My documents listing
     *
     * @param integer $userId
     * @param integer $offset
     * @param integer $count
     * @return string
     */
    public function generateDebateFeedTimeline($debateId, $inQueryUserIds)
    {
        $this->logger->info('*** generateDebateFeedTimeline');
        $this->logger->info('$debateId = ' . print_r($debateId, true));
        $this->logger->info('$inQueryUserIds = ' . print_r($inQueryUserIds, true));

        $con = \Propel::getConnection('default', \Propel::CONNECTION_READ);
        $stmt = $con->prepare($this->createDebateFeedRawSql());

        $stmt->bindValue(':p_d_debate_id', $debateId, \PDO::PARAM_INT);
        $stmt->bindValue(':p_d_debate_id2', $debateId, \PDO::PARAM_INT);
        $stmt->bindValue(':p_d_debate_id3', $debateId, \PDO::PARAM_INT);
        $stmt->bindValue(':inQueryUserIds', $inQueryUserIds, \PDO::PARAM_STR);
        $stmt->bindValue(':inQueryUserIds2', $inQueryUserIds, \PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchAll();

        $timeline = $this->globalTools->hydrateTimelineRows($result);

        return $timeline;
    }
    
    /**
     * Get document's notes evolution as array of (created_at, nb_note_pos, nb_note_neg)
     *
     * @param int $documentId
     * @param string $documentType
     * @param int $notePosReputationId
     * @param int $noteNegReputationId
     * @param string $startAt
     * @param string $endAt
     * @return array
     */
    public function generateNotesByDate($documentId, $documentType, $notePosReputationId, $noteNegReputationId, $startAt, $endAt)
    {
        $this->logger->info('*** generateNotesByDate');
        $this->logger->info('$documentId = ' . print_r($documentId, true));
        $this->logger->info('$documentType = ' . print_r($documentType, true));
        $this->logger->info('$notePosReputationId = ' . print_r($notePosReputationId, true));
        $this->logger->info('$noteNegReputationId = ' . print_r($noteNegReputationId, true));
        $this->logger->info('$startAt = ' . print_r($startAt, true));
        $this->logger->info('$endAt = ' . print_r($endAt, true));

        $con = \Propel::getConnection('default', \Propel::CONNECTION_READ);
        $stmt = $con->prepare($this->createNotesByDateRawSql());

        $stmt->bindValue(':notePosReputationId', $notePosReputationId, \PDO::PARAM_INT);
        $stmt->bindValue(':notePosReputationId2', $notePosReputationId, \PDO::PARAM_INT);
        $stmt->bindValue(':noteNegReputationId', $noteNegReputationId, \PDO::PARAM_INT);
        $stmt->bindValue(':noteNegReputationId2', $noteNegReputationId, \PDO::PARAM_INT);
        $stmt->bindValue(':documentType', $documentType, \PDO::PARAM_STR);
        $stmt->bindValue(':documentId', $documentId, \PDO::PARAM_INT);
        $stmt->bindValue(':startAt', $startAt, \PDO::PARAM_STR);
        $stmt->bindValue(':endAt', $endAt, \PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchAll();

        $statsNotesEvolution = array();
        foreach ($result as $row) {
            $notesByDates = array();

            $notesByDates['id'] = $row['id'];
            $notesByDates['created_at'] = $row['DATE'];
            $notesByDates['sum_notes'] = $row['COUNT_NOTE_POS'] - $row['COUNT_NOTE_NEG'];

            $statsNotesEvolution[] = $notesByDates;
        }

        return $statsNotesEvolution;
    }

    /**
     * Get document's sum of positive - negative notes until a date
     *
     * @param int $documentId
     * @param string $documentType
     * @param int $notePosReputationId
     * @param int $noteNegReputationId
     * @param string $untilAt
     * @return int
     */
    public function generateSumOfNotes($documentId, $documentType, $notePosReputationId, $noteNegReputationId, $untilAt)
    {
        $this->logger->info('*** generateSumOfNotes');
        $this->logger->info('$documentId = ' . print_r($documentId, true));
        $this->logger->info('$documentType = ' . print_r($documentType, true));
        $this->logger->info('$notePosReputationId = ' . print_r($notePosReputationId, true));
        $this->logger->info('$noteNegReputationId = ' . print_r($noteNegReputationId, true));
        $this->logger->info('$untilAt = ' . print_r($untilAt, true));

        $con = \Propel::getConnection('default', \Propel::CONNECTION_READ);
        $stmt = $con->prepare($this->createSumOfNotesRawSql());

        $stmt->bindValue(':notePosReputationId', $notePosReputationId, \PDO::PARAM_INT);
        $stmt->bindValue(':notePosReputationId2', $notePosReputationId, \PDO::PARAM_INT);
        $stmt->bindValue(':noteNegReputationId', $noteNegReputationId, \PDO::PARAM_INT);
        $stmt->bindValue(':noteNegReputationId2', $noteNegReputationId, \PDO::PARAM_INT);
        $stmt->bindValue(':documentType', $documentType, \PDO::PARAM_STR);
        $stmt->bindValue(':documentId', $documentId, \PDO::PARAM_INT);
        $stmt->bindValue(':untilAt', $untilAt, \PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->fetchAll();

        $sumOfNotes = 0;
        if (isset($result[0])) {
            $sumOfNotes = $result[0]['COUNT_NOTE_POS'] - $result[0]['COUNT_NOTE_NEG'];
        }

        return $sumOfNotes;
    }

    /* ######################################################################################################## */
    /*                                            CRUD OPERATIONS                                               */
    /* ######################################################################################################## */

    /**
     * Create a new PDDebate associated with userId
     *
     * @param int $userId
     * @return PDDebate
     */
    public function createDebate($userId)
    {
        $debate = new PDDebate();
        
        $debate->setPUserId($userId);

        $debate->setNotePos(0);
        $debate->setNoteNeg(0);

        $debate->setOnline(true);
        $debate->setPublished(false);
        
        $debate->save();

        return $debate;
    }

    /**
     * Publish debate
     *
     * @param PDDebate $debate
     * @return PDDebate
     */
    public function publishDebate(PDDebate $debate)
    {
        if ($debate) {
            $description = $this->globalTools->removeEmptyParagraphs($debate->getDescription());

            $debate->setDescription($description);
            $debate->setPublished(true);
            $debate->setPublishedAt(time());

            $debate->save();
        }

        return $debate;
    }

    /**
     * Delete debate
     *
     * @param PDDebate $debate
     * @return integer
     */
    public function deleteDebate(PDDebate $debate)
    {
        $result = $debate->delete();

        return $result;
    }

    /**
     * Create a new PDReaction associated with userId, debateId and optionnaly parentId
     *
     * @param int $userId
     * @param int $debateId
     * @param int $parentId
     * @return PDReaction
     */
    public function createReaction($userId, $debateId, $parentId = null)
    {
        $reaction = new PDReaction();

        $reaction->setPDDebateId($debateId);
        
        $reaction->setPUserId($userId);

        $reaction->setNotePos(0);
        $reaction->setNoteNeg(0);
        
        $reaction->setOnline(true);
        $reaction->setPublished(false);

        $reaction->setParentReactionId($parentId);

        $reaction->save();

        return $reaction;
    }

    /**
     * Init reaction's tags by default = parent's ones
     *
     * @param PDReaction $reaction
     * @return PDReaction
     */
    public function initReactionTaggedTags(PDReaction $reaction)
    {
        $parentReactionId = $reaction->getParentReactionId();
        if ($parentReactionId) {
            $parent = PDReactionQuery::create()->findPk($parentReactionId);
        } else {
            $parent = $reaction->getDebate();
        }

        $tags = $parent->getTags();
        foreach ($tags as $tag) {
            $pdrTaggedT = new PDRTaggedT();

            $pdrTaggedT->setPTagId($tag->getId());
            $pdrTaggedT->setPDReactionId($reaction->getId());

            $pdrTaggedT->save();
        }

        return $reaction;
    }

    /**
     * Publish reaction w. relative nested set update
     *
     * @param PDReaction $reaction
     * @return PDReaction
     */
    public function publishReaction(PDReaction $reaction)
    {
        if ($reaction) {
            // get associated debate
            $debate = PDDebateQuery::create()->findPk($reaction->getPDDebateId());
            if (!$debate) {
                throw new InconsistentDataException('Debate n°'.$debateId.' not found.');
            }

            // nested set management
            if ($parentId = $reaction->getParentReactionId()) {
                $parent = PDReactionQuery::create()->findPk($parentId);
                if (!$parent) {
                    throw new InconsistentDataException('Parent reaction n°'.$parentId.' not found.');
                }
                $reaction->insertAsLastChildOf($parent);
            } else {
                $rootNode = PDReactionQuery::create()->findRoot($debate->getId());
                if (!$rootNode) {
                    $rootNode = $this->createReactionRootNode($debate->getId());
                }

                if ($nbReactions = $debate->countReactions() == 0) {
                    $reaction->insertAsFirstChildOf($rootNode);
                } else {
                    $reaction->insertAsNextSiblingOf($debate->getLastPublishedReaction(1));
                }
            }

            $description = $this->globalTools->removeEmptyParagraphs($reaction->getDescription());

            $reaction->setDescription($description);

            $reaction->setPublished(true);
            $reaction->setPublishedAt(time());
            $reaction->save();
        }

        return $reaction;
    }

    /**
     * Reaction nested set root node
     *
     * @param integer $debateId
     * @return PDReaction
     */
    public function createReactionRootNode($debateId)
    {
        $rootNode = new PDReaction();

        $rootNode->setPDDebateId($debateId);
        $rootNode->setTitle('ROOT NODE');
        $rootNode->setOnline(false);
        $rootNode->setPublished(false);

        $rootNode->makeRoot();
        $rootNode->save();

        return $rootNode;
    }

    /**
     * Delete reaction
     *
     * @param PDDebate $reaction
     * @return integer
     */
    public function deleteReaction(PDReaction $reaction)
    {
        $result = $reaction->delete();

        return $result;
    }
}
