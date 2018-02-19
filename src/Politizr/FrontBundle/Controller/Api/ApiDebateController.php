<?php

namespace Politizr\FrontBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Politizr\Exception\InconsistentDataException;

use Politizr\Model\PDDebate;

use Politizr\Model\PDDebateQuery;

/**
 * API controller
 *
 * @author Lionel Bouzonville
 */
class ApiDebateController extends Controller
{
    /**
     * 
     */
    public function listAction()
    {
        $debates = PDDebateQuery::create()->online()->find();

        $data = $this->get('jms_serializer')->serialize($debates, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * 
     */
    public function showAction($id)
    {
        $debate = PDDebateQuery::create()->findPk($id);

        $data = $this->get('jms_serializer')->serialize($debate, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * 
     */
    public function createAction(Request $request)
    {
        $data = $request->getContent();
        $apiDebate = $this->get('jms_serializer')->deserialize($data, 'Politizr\Model\PDDebate', 'json');

        $debate = $this->get('politizr.manager.document')->createDebate(1);

        // Debate
        $debate->setTitle($apiDebate->getTitle());
        $debate->setDescription($apiDebate->getDescription());

        $debate->save();

        return new Response('', Response::HTTP_CREATED);
    }
}