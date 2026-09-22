<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class CategoryController extends AbstractController
{
    #[Route('/category/new', name: 'app_category_new')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger,
        CategoryRepository $categoryRepository
    ): Response {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $category->setCreatedAt(new \DateTimeImmutable());

            $category->setSlug(
                strtolower(
                    $slugger->slug($category->getName())->toString()
                )
            );

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'form' => $form,
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
