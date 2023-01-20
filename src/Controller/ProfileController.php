<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile_index")
     */
    public function index(): Response
    {

        return $this->render('profile/index.html.twig', []);
    }

    // @Security("is_granted('ROLE_ADMIN')")
    // @IsGranted("ROLE_ADMIN", statusCode=404, message="Not Found")
    /**
     * @Route("/profile/private", name="profile_private")
     */
    public function private(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('profile/private.html.twig', []);
    }
}
