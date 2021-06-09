<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Service\ProduitService;
use App\Form\ProduitFormType;

class ProduitController extends AbstractController
{
    private $produitService;

    // PREMIERE FACON D'APPELER LES FONCTIONS DU REPO PRODUITS : INJECTION DE DEPENDANCE
    public function __construct(ProduitService $service)
    {
        $this->produitService = $service;
    }

    /**
     * @Route("/produits/update/{id}", name="produit_update")
     */
    public function updateForm(Request $request, int $id): Response
    {
        $produit = $this->produitService->detail($id);
        $form = $this->createForm(ProduitFormType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $product = $this->produitService->addOrUpdateProduct($product);
            return $this->redirectToRoute('produits');
        }
        return $this->render('produit/produit-form.html.twig', [
            "form_title" => "Ajouter un produit",
            'form_produit' => $form->createView()
        ]);
    }

    /**
     * @Route("/produits/add-form", name="add_form")
     */
    public function addProduit(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitFormType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $produit = $form->getData();
            $this->produitService->add($produit);
            return $this->redirectToRoute('produits');
        }

        return $this->render("produit/produit-form.html.twig", [
            "form_title" => "Ajouter un produit",
            "form_produit" => $form->createView(),
        ]);
    }

    /**
     * @Route("/produits", name="produits")
     */
    public function index(): Response
    {
        // DEUXIEME FACON D'APPELER LES FONCTIONS DU REPO PRODUITS : CREATION D'OBJETS PRET A L'EMPLOI PAR SYMFONY
        // $repository = $this->getDoctrine()->getRepository(Produit::class);
        // $listeProduits = $repository->findAll();

        $listeProduits = $this->produitService->findAll();
        // dd($listeProduits);
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'Gestion des produits',
            'produit' => $listeProduits,
        ]);
    }


    /**
     * @Route("/produits/{id}", name="produit_detail")
     */
    //public function detail(Produit $produit): Response
    public function detail($id): Response
    {
        $produitTrouve = $this->produitService->detail($id);

        return $this->render('produit/details.html.twig', ['produit' => $produitTrouve]);
        // return $this->render('produit/detail.html.twig', ['produit' => $produit]);

    }
    // /**
    //  * @Route("/produits/detail/{id}", name="produit_detail")
    //  * 
    //  * @return  Response
    //  */
    // public function detail($id): Response
    // {
    //     $produit = $this->produitService->find($id);
    //     return $this->render('produit/details.html.twig', [
    //         'controller_name' => 'ProduitController',
    //         'details' => $produit,
    //     ]);
    // }

    /**
     * @Route("/produits/delete/{id}", name="produit_delete")
     */
    public function deleteProduit(int $id): Response
    {
        $produit = $this->produitService->find($id);
        $this->produitService->delete($produit);

        return $this->redirectToRoute('produits');
    }
}
