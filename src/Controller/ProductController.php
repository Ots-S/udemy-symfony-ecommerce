<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\SearchType;
use App\Classe\Search;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function showProduct(Product $product): Response
    {
        if (!$product) {
            return $this->redirectToRoute('products');
        }

        return $this->render('product/view.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/nos-produits", name="products")
     */
    public function showProducts(HttpFoundationRequest $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }

        $products = $this->entityManager->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }
}
