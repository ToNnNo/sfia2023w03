<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController
{
    private $translate;

    public function __construct()
    {
    }

    // @Route("/{_locale}/translation", name="translation_index")
    /**
     * @Route({
     *     "fr": "/traduction",
     *     "en": "/translation"
     * }, name="translation_index")
     */
    public function index(): Response
    {

        return $this->render('translation/index.html.twig', [
            'name' => "John"
        ]);
    }
}
