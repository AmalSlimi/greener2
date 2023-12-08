<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EvenementRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Search1Controller extends AbstractController
{
    #[Route('/search1', name: 'app_search1')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig');
    }

    #[Route('/search-evenements', name: 'app_search_evenements')]
    public function searchEvenements(Request $request, EvenementRepository $evenementRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');

        if (!$searchTerm) {
            $evenements = [];
        } else {
            $evenements = $evenementRepository->searchEvenements($searchTerm);
        }

        return $this->render('search/results.html.twig', [
            'searchTerm' => $searchTerm,
            'evenements' => $evenements,
        ]); 
    }
}
