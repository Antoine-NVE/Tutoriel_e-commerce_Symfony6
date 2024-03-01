<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories', name: 'app_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/{slug}', name: 'list')]
    public function details(Categories $category): Response
    {
        $products = $category->getProducts();

        return $this->render('categories/liste.html.twig', [
            "category" => $category,
            "products" => $products
        ]);
    }
}
