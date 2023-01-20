<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseController extends AbstractController
{
    /**
     * @Route("/response", name="response_index")
     */
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        if( $request->query->has('save') ) {
            $session->set('name', "Stéphane");
            return $this->redirectToRoute('response_index');
        }

        if( $request->query->has('clear') ) {
            $session->remove("name");
            return $this->redirectToRoute('response_index');
        }

        return $this->render('response/index.html.twig', [
            "name" => $session->get("name", "Visiteur")
        ]);
    }

    /**
     * @Route("/response/redirection", name="response_redirection")
     */
    public function redirection(Request $request): Response
    {
        dump("Hello World");
        dump($request);

        // return $this->redirect($this->generateUrl('response_index'));

        // RedirectResponse
        return $this->redirectToRoute('response_index');
    }

    /**
     * @Route("/response/download", name="response_download")
     */
    public function download(): Response
    {
        $root = $this->getParameter('kernel.project_dir');

        // BinaryFileResponse
        return $this->file($root . "/public/download/batman.jpg");
    }

    /**
     * @Route("/response/json", name="response_json")
     */
    public function getJson(): Response
    {
        $user = ["firstname" => "John", "lastname" => "Smith", "email" => "john.smith@gmail.com"];

        return $this->json($user);
    }

    /**
     * @Route("/response/xml", name="response_xml")
     */
    public function xml(SerializerInterface $serializer): Response
    {
        $user = ["firstname" => "John", "lastname" => "Smith", "email" => "john.smith@gmail.com"];
        $xml = $serializer->encode($user, "xml");

        return new Response($xml, 200, ["Content-Type" => "text/xml"]);
    }
}
