<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
 


class ChercherController extends AbstractController
{
    #[Route('/chercher', name: 'app_chercher')]
    public function index(): Response
    {
        return $this->render('chercher/index.html.twig');
    }

    

    #[Route('/chercher-commandes', name: 'app_chercher_commandes')]
    public function searchCommandes(Request $request, CommandeRepository $CommandeRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');

        if (!$searchTerm) {
            $Commandes = [];
        } else {
            $commandes = $CommandeRepository->searchCommandes($searchTerm);
        }

        return $this->render('chercher/results.html.twig', [
            'searchTerm' => $searchTerm,
            'commandes' => $commandes,
        ]);
    }

   

   
}

