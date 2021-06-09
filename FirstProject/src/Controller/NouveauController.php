<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NouveauController extends AbstractController
{
    /**
     * @Route("/nouveau", name="nouveau")
     */
    public function index(): Response
    {
        $response = new Response("<h1> Hello World </h1>", Response::HTTP_OK);
        return $response;
    }
    /**
     * @Route("/nouveau2", name="nouveau2")
     */
    public function index2(): Response
    {
        return $this->json(['Hello' => 'World']);
    }

    /**
     * @Route("/nouveau3", name="nouveau3")
     */
    public function index3(): Response
    {
        return $this->render('nouveau/index.html.twig', [
            'controller_name' => 'Mohamed',
        ]);
    }
}
