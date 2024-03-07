<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/produits', name: 'admin_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        // On crée un "nouveau produit"
        $product = new Products();

        // On crée le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        // On traite la requête du formulaire
        $productForm->handleRequest($request);

        // On vérifie si le formulaire est soumis ET valide
        if ($productForm->isSubmitted() && $productForm->isValid()) {
            // On génère le slug
            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);

            // On arrondit le prix
            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);

            $manager->persist($product);
            $manager->flush();

            $this->addFlash("success", "Produit ajouté avec succès");

            // On redirige
            return $this->redirectToRoute("admin_products_index");
        }

        return $this->render('admin/products/add.html.twig', [
            "productForm" => $productForm
        ]);
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Products $product, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        // On vérifie si l'utilisateur peut éditer avec le Voter
        $this->denyAccessUnlessGranted("PRODUCT_EDIT", $product);

        $product->setPrice($product->getPrice() / 100);

        // On crée le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        // On traite la requête du formulaire
        $productForm->handleRequest($request);

        // On vérifie si le formulaire est soumis ET valide
        if ($productForm->isSubmitted() && $productForm->isValid()) {
            // On génère le slug
            $slug = $slugger->slug($product->getName());
            $product->setSlug($slug);

            // On arrondit le prix
            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);

            $manager->persist($product);
            $manager->flush();

            $this->addFlash("success", "Produit modifié avec succès");

            // On redirige
            return $this->redirectToRoute("admin_products_index");
        }

        return $this->render('admin/products/edit.html.twig', [
            "productForm" => $productForm
        ]);

        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Products $product): Response
    {
        // On vérifie si l'utilisateur peut supprimer avec le Voter
        $this->denyAccessUnlessGranted("PRODUCT_DELETE", $product);
        return $this->render('admin/products/index.html.twig');
    }
}
