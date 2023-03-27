<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class CacheController extends AbstractController
{
    // @Cache(public=true, maxage="3600")

    /**
     * @Route("/cache", name="cache_index")
     *
     */
    public function index(): Response
    {
        $response = $this->render('cache/index.html.twig', []);

        /*$response->setPublic();
        $response->setMaxAge(3600);*/

        $date = new \DateTime();
        $date->modify('+120 seconds');

        $response->setExpires($date);

        return $response;
    }
}
