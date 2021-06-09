<?php

namespace App\Service;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ProduitService
{
    private $produitRepository;
    private $manager;

    public function __construct(ProduitRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->produitRepository = $repository;
        $this->manager = $entityManager;
    }

    public function findAll()
    {
        return $this->produitRepository->findAll();
    }

    public function detail($id): Produit
    {

        return $this->produitRepository->find($id);
    }

    public function delete(Produit $produit)
    {
        $this->manager->remove($produit);
        $this->manager->flush();
    }

    public function find($id): Produit
    {
        return $this->produitRepository->find($id);
    }

    public function add(Produit $produit)
    {
        $this->manager->persist($produit);
        $this->manager->flush();
    }

    public function addOrUpdateProduct(Produit $prod)
    {
        $this->manager->persist($prod);
        $this->manager->flush();
    }
}
