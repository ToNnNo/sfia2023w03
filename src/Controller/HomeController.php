<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        // génère l'url de la page sandbox
        $urlSandBox = $this->generateUrl('app_sandbox');
        $urlSpecial = $this->generateUrl('app_special');
        $urlExtraParam = $this->generateUrl('app_params', ["name" => "david"]);

        // render return une instance de Response
        return $this->render('home/index.html.twig', [
            'url_sandbox' => $urlSandBox,
            'url_special' => $urlSpecial,
            'url_extra_param' => $urlExtraParam
        ]);
    }

    /**
     * @Route("/hello/{name}", name="app_hello", defaults={"name": "Stéphane"}, requirements={"name": "[a-z_-]+"})
     */
    public function hello($name): Response
    {
        $name = ucfirst($name);

        return $this->render('home/hello.html.twig', [
            'name' => $name
        ]);
    }

    /**
     * @Route("/hello/{id<\d+>?0}", name="app_hello_by_id", priority="1")
     */
    public function helloById(int $id): Response
    {
        $names = ["Stéphane", "John", "Jane"];

        if( $id >= count($names) ) {
            throw $this->createNotFoundException();
        }

        return $this->render('home/hello.html.twig', [
            'name' => $names[$id]
        ]);
    }

    /**
     * @Route("/{_locale}/special.{_format}", name="app_special", defaults={"_locale": "fr", "_format": "xml"})
     */
    public function special(): Response
    {
        return new Response("<html><body><h1>Paramètres Spéciaux</h1></body></html>");
    }

    /**
     * @Route("/sandbox", name="app_sandbox")
     */
    public function sandbox(): Response
    {
        return new Response('<html><body><h1>Bienvenue dans notre bac à salle !</h1></body></html>');
    }

    /**
     * @Route("/params", name="app_params")
     */
    public function extraParam(Request $request): Response
    {
        $name = $request->query->get('name', "pierre");
        $name = ucfirst($name);

        return $this->render('home/extra_param.html.twig', [
            'name' => $name
        ]);
    }

    /**
     * @Route("/500", name="app_internal_server_error")
     */
    public function internalServerError(): Response
    {
        throw new \Exception(sprintf("Internal Server Error (code %s)", 500));

        return new Response();
    }
}
