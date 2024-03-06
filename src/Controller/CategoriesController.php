<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories', name: 'app_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/{slug}', name: 'list')]
    public function details(Categories $category, ProductsRepository $productsRepository, Request $request): Response
    {
        // On va chercher le numéro de page dans l'URL
        $page = $request->query->getInt("page", 1);

        // On va chercher la liste des produits de la catégorie
        $products = $productsRepository->findProductsPaginated($page, $category->getSlug(), 4);

        return $this->render('categories/liste.html.twig', [
            "category" => $category,
            "products" => $products
        ]);
    }
}
