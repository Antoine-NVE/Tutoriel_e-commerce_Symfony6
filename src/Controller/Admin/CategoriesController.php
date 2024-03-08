<?php

namespace App\Controller\Admin;

use App\Repository\CategoriesRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route("/admin/categories", name: "admin_categories_")]
class CategoriesController extends AbstractController
{
    #[Route("/", name: "index")]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $categories = $categoriesRepository->findBy([], orderBy: [
            "categoryOrder" => "ASC"
        ]);

        return $this->render("admin/categories/index.html.twig", [
            "categories" => $categories
        ]);
    }
}
