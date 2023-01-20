<?php

namespace App\Controller;

use App\Service\Crypto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    private $crypto;

    public function __construct(Crypto $crypto)
    {
        $this->crypto = $crypto;
    }

    /**
     * @Route("/service", name="service_index")
     */
    public function index(): Response
    {
        $message = "Quand je retire mes lunettes, je suis superman!";

        $ciphertext = $this->crypto->encode($message);

        return $this->render('service/index.html.twig', [
            'cipher_text' => $ciphertext
        ]);
    }

    /**
     * @Route("/service/decode", name="service_decode")
     */
    public function decode(Request $request): Response
    {
        $fb = $this->createFormBuilder();
        $form = $fb->add('ciphertext', TextType::class, [
                'label' => 'Message à décrypter',
                'attr' => ['class' => 'form-control']
            ])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $data = $form->getData();
            $message = $this->crypto->decode($data['ciphertext']);
        }

        return $this->render('service/decode.html.twig', [
            'form' => $form->createView(),
            'message' => $message ?? null
        ]);
    }
}
