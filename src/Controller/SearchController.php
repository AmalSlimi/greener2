<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig');
    }

    #[Route('/search-posts', name: 'app_search_posts')]
    public function searchPosts(Request $request, PostRepository $postRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');

        if (!$searchTerm) {
            $posts = [];
        } else {
            $posts = $postRepository->searchPosts($searchTerm);
        }

        return $this->render('search/results.html.twig', [
            'searchTerm' => $searchTerm,
            'posts' => $posts,
        ]);
    }

    #[Route('/user/search', name: 'app_search1')]
    public function index1(): Response
    {
        return $this->render('Front/user/index.html.twig');
    }

    #[Route('/user/search-posts', name: 'app_search_posts1')]
    public function searchPosts1(Request $request, PostRepository $postRepository): Response
    {
        $searchTerm = $request->query->get('searchTerm');

        if (!$searchTerm) {
            $posts = [];
        } else {
            $posts = $postRepository->searchPosts($searchTerm);
        }

        return $this->render('Front/user/results.html.twig', [
            'searchTerm' => $searchTerm,
            'posts' => $posts,
        ]);
    }
}

