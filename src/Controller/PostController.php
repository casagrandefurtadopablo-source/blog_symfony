<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class PostController extends AbstractController
{
    #[Route('/cad/post/', name: 'app_post_new')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        CategoryRepository $categoryRepository
    ): Response {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setSlug(
                strtolower(
                    $slugger->slug($post->getTitle())->toString()
                )
            );

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
