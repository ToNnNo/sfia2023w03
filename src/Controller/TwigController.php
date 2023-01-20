<?php

namespace App\Controller;

use App\Useless\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    /**
     * @Route("/twig", name="twig_index")
     */
    public function index(): Response
    {
        $this->addFlash('success', "Vous voulez un whisky ? Oui juste un doigt. Vous voulez pas un whisky d'abord ?");
        $this->addFlash('info', "Les miroirs feraient bien de réfléchir un peu plus avant de renvoyer les images.");
        $this->addFlash('info', "Si vous n’aimez pas la mer… Si vous n’aimez pas la montagne… Si vous n’aimez pas la ville… Allez vous faire foutre !");

        $person = (new Person())
            ->setFirstname("Eduard")
            ->setLastname("Doe")
            ->setEmail("eduard.doe@gmail.com");

        $address = [
            "city" => "Lille",
            "street" => "46 rue des canonniers",
            "zip" => "59800",
        ];

        $fruits = ["Pomme", "Poire", "Orange", "Cerise", "Kiwi", "Banane", "Pastèque"];

        return $this->render('twig/index.html.twig', [
            'name' => "John Smith",
            'person' => $person,
            'address' => $address,
            'fruits' => $fruits,
            'vegetables' => [],
            'now' => new \DateTime()
        ]);
    }

    public function subRequest(): Response
    {

        return $this->render('twig/sub_request.html.twig', []);
    }
}
