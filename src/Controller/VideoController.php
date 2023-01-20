<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    /**
     * @Route("/video", name="video_index")
     */
    public function index(): Response
    {


        return $this->render('video/index.html.twig', []);
    }

    /**
     * @Route("/video/subscribe", name="video_subscribe")
     * @IsGranted("ROLE_USER")
     */
    public function subscribe(Request $request): Response
    {
        $session = $request->getSession();

        $finishAt = new \DateTime();
        $finishAt->add( new \DateInterval('PT24H') );

        $session->set('subscribe', $finishAt);

        return $this->render('video/subscribe.html.twig', [
            'finish_at' => $finishAt
        ]);
    }
}
