<?php

namespace Politizr\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

use Politizr\Model\PUser;

use Politizr\FrontBundle\Form\Type\SearchType;


class NavigationController extends Controller
{
    /* ######################################################################################################## */
    /*                                                  ROUTING CLASSIQUE                                       */
    /* ######################################################################################################## */

    /**
     *  Init Recherche
     */
    public function searchInitAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** searchInitAction');

        $form = $this->createForm(
            new SearchType()
        );

        return $this->render('PolitizrFrontBundle:Navigation:searchForm.html.twig', array(
                    'form' => $form->createView(),
            ));
    }


    /**
     *  Recherche
     */
    public function searchAction(Request $request)
    {
        $logger = $this->get('logger');
        $logger->info('*** searchAction');

        $form = $this->createForm(
            new SearchType()
        );

        $results = array();
        $query = $request->query->get('recherche')['query'];
        if ($query) {
            // $finder = $this->container->get('fos_elastica.finder.politizr.p_document');
            $finder = $this->container->get('fos_elastica.finder.politizr');

            $results = $finder->find($query);
            $logger->info('$results = '.print_r($results, true));
            // var_dump($results);
            // exit();
        }

        return $this->render('PolitizrFrontBundle:Navigation:searchResult.html.twig', array(
                    'results' => $results,
            ));
    }


    /**
     *  Partage RS
     */
    public function shareAction($uri, $tweetText)
    {
        // URL de partage public
        $uri = $this->getTinyUrl($uri);

        return $this->render('PolitizrFrontBundle:Navigation:share.html.twig', array(
                    'uri' => $uri,
                    'tweetText' => $tweetText
            ));
    }

    /**
     *  Retourne les images à intégrer dans les balises Facebook og:image
     *
     */
    public function ogImageAction($fileNames = null)
    {
        // URLs photo Facebook
        $imageUrls = array();
        if ($fileNames && !empty($fileNames)) {
            foreach($fileNames as $fileName) {
                if ($fileName) {
                    $imageUrls[] = $this->getFacebookImageUrl($fileName);
                }
            }
        } else {
            $imageUrls[] = $this->getRequest()->getSchemeAndHttpHost().'/bundles/politizrfront/images/share_facebook.jpg';
        }

        if (empty($imageUrls)) {
            $imageUrls[] = $this->getRequest()->getSchemeAndHttpHost().'/bundles/politizrfront/images/share_facebook.jpg';
        }
        
        return $this->render('PolitizrFrontBundle:Navigation:ogImage.html.twig', array(
                    'imageUrls' => $imageUrls
            ));
    }

    /* ######################################################################################################## */
    /*                                                  FONCTIONS PRIVEES                                       */
    /* ######################################################################################################## */

    /**
     *  URL Shortener avec TinyURL
     *
     *  @param $url
     *  @return string url
     */
    private function getTinyUrl($url) {
        // with tinyurl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://tinyurl.com/api-create.php?url=".$url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $bookUrlShort = curl_exec($ch);
        curl_close($ch);

        return $bookUrlShort;
    }

    /*
     *  Renvoit l'url de la photo du profil optimisée pour un partage Facebook
     *
     *  @param $fileName
     *  @return string url
     */
    private function getFacebookImageUrl($fileName) {
        $logger = $this->get('logger');
        $logger->info('*** getFacebookImageUrl');

        // Resize de la photo pour partage FB
        $imagemanagerResponse = $this->container->get('liip_imagine.controller')->filterAction(
                    $this->getRequest(),
                    'uploads/'.$fileName,
                    'facebook_share'
        );

        // Récupération de la photo resizée pour FB
        $cacheManager = $this->container->get('liip_imagine.cache.manager');
        $resizeImg = $cacheManager->getBrowserPath('uploads/'.$fileName, 'facebook_share');
        $resizeImg = str_replace ('app_'.$this->container->get( 'kernel' )->getEnvironment().'.php/', '', $resizeImg);
        $logger->info('$resizeImg = '.print_r($resizeImg, true));

        $baseUrl = $this->getRequest()->getSchemeAndHttpHost();
        $logger->info('$baseUrl = '.print_r($baseUrl, true));

        $imageUrl = $baseUrl . $resizeImg;
        $logger->info('$imageUrl = '.print_r($imageUrl, true));

        return $imageUrl;        
    }

}
