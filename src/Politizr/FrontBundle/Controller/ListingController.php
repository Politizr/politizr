<?php

namespace Politizr\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Politizr\Model\PDocumentInterface;

use Politizr\Model\PDDebateQuery;
use Politizr\Model\PTagQuery;
use Politizr\Model\PQOrganizationQuery;

/**
 * Listing controller
 *
 * @author Lionel Bouzonville
 */
class ListingController extends Controller
{
    /**
     * Common document "check" validity
     *
     * @param PDocument
     * @param boolean $online
     * @param boolean $published
     * @param boolean
     */
    private function checkDocument(PDocumentInterface $document = null, $online = true, $published = true)
    {
        if (!$document) {
            throw new NotFoundHttpException(sprintf('Document not found.'));
        }
        if ($online && !$document->getOnline()) {
            throw new NotFoundHttpException(sprintf('Document not online.'));
        }
        if ($published && !$document->getPublished()) {
            throw new NotFoundHttpException(sprintf('Document not published.'));
        }

        return true;
    }

    // *************************************************************************************************** //
    //                                      DOCUMENT LISTING
    // *************************************************************************************************** //

    /**
     * Top listing
     * code beta
     */
    public function recommendAction()
    {
        $logger = $this->get('logger');
        $logger->info('*** recommendAction');

        $now = new \DateTime();
        $month = $this->get('politizr.tools.global')->getLabelFromMonthNum($now->format('n'));
        $year = $now->format('Y');

        return $this->redirect($this->generateUrl('ListingByRecommendMonthYear', array('month' => $month, 'year' => $year)));
    }

    /**
     * Top listing
     * code beta
     */
    public function recommendMonthYearAction($month, $year)
    {
        $logger = $this->get('logger');
        $logger->info('*** recommendMonthYearAction');

        $numMonth = $this->get('politizr.tools.global')->getNumFromMonthLabel($month);

        $now = new \DateTime();
        $search = new \DateTime();
        $search->setDate($year, $numMonth, 1);

        if ($search > $now) {
            throw new NotFoundHttpException('Cannot recommend with future date');
        }

        return $this->render('PolitizrFrontBundle:Document:listingByRecommend.html.twig', array(
            'top' => true,
            'numMonth' => $numMonth,
            'month' => $month,
            'year' => $year,
        ));
    }

    /**
     * Tag listing
     * code beta
     */
    public function tagAction($slug)
    {
        $logger = $this->get('logger');
        $logger->info('*** tagAction');
        $logger->info('$slug = '.print_r($slug, true));

        $tag = PTagQuery::create()->filterBySlug($slug)->findOne();
        if (!$tag) {
            throw new NotFoundHttpException('Tag "'.$slug.'" not found.');
        }
        if (!$tag->getOnline()) {
            throw new NotFoundHttpException('Tag "'.$slug.'" not online.');
        }

        return $this->render('PolitizrFrontBundle:Document:listingByTag.html.twig', array(
            'tag' => $tag
        ));
    }

    /**
     * Organization listing
     * code beta
     */
    public function organizationAction($slug)
    {
        $logger = $this->get('logger');
        $logger->info('*** organizationAction');
        $logger->info('$slug = '.print_r($slug, true));

        $organization = PQOrganizationQuery::create()->filterBySlug($slug)->findOne();
        if (!$organization) {
            throw new NotFoundHttpException('Organization "'.$slug.'" not found.');
        }
        if (!$organization->getOnline()) {
            throw new NotFoundHttpException('Organization "'.$slug.'" not online.');
        }

        return $this->render('PolitizrFrontBundle:Document:listingByOrganization.html.twig', array(
            'organization' => $organization
        ));
    }

    // *************************************************************************************************** //
    //                                      USER LISTING
    // *************************************************************************************************** //
    
    /**
     * Debate followers
     * code beta
     */
    public function debateFollowersAction($slug)
    {
        $logger = $this->get('logger');
        $logger->info('*** debateFollowers');
        $logger->info('$slug = '.print_r($slug, true));

        $debate = PDDebateQuery::create()->filterBySlug($slug)->findOne();
        $this->checkDocument($debate);

        return $this->render('PolitizrFrontBundle:User:listingDebateFollowers.html.twig', array(
            'debate' => $debate,
        ));
    }
}
