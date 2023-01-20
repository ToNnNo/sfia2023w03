<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post_")
 */
class PostController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        if( $request->query->has('author') ) {
            $idAuthor = $request->query->getInt('author');
            $posts = $postRepository->findAllFromAuthor($idAuthor);
        } else {
            $posts = $postRepository->findAllWithAuthor();
        }

        dump($posts);

        return $this->render('post/index.html.twig', [
            "posts" => $posts
        ]);
    }

    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail(int $id, PostRepository $postRepository): Response
    {
        $post = $postRepository->findWithAuthor($id);

        return $this->render('post/detail.html.twig', [
            "post" => $post
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ) {
            // $form->getData();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash("success", "L'article a bien été enregistré");
            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Post $post, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ) {
            $entityManager->flush();

            $this->addFlash("success", "L'article a bien été enregistré");
            return $this->redirectToRoute('post_edit', ['id' => $post->getId()]);
        }

        return $this->renderForm('post/edit.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/save", name="save")
     */
    public function save(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = (new Post())
            ->setTitle("Article de présentation de doctrine")
            ->setBody("<p>Pour insérer notre entité <b class='text-primary'>Post</b> en base de données, 
nous allons utiliser l'objet <b class='text-primary'>Doctrine Entity Manager</b>.</p>");

        if( $request->query->has("save") ) {
            $entityManager->persist($post); // met l'entité dans la mémoire de doctrine
            $entityManager->flush();        // enregistre l'entité en base

            $this->addFlash("success", "L'article a bien été enregistré");
            return $this->redirectToRoute("post_save");
        }

        return $this->render('post/save.html.twig', [
            'post' => $post
        ]);
    }

}
