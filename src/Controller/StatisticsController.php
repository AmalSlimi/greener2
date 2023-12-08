<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentairesRepository;
use App\Repository\PostRepository;


class StatisticsController extends AbstractController
{
    #[Route('/post_comment_statistics', name: 'post_comment_statistics')]
    public function postCommentStatistics(PostRepository $postRepository): Response
    {
        $postCommentCounts = $postRepository->getPostsWithCommentCount();

        return $this->render('statistics/index.html.twig', [
            'postCommentCounts' => $postCommentCounts,
        ]);
    }

    #[Route('/post_comment_pie_chart', name: 'post_comment_pie_chart')]
public function postCommentPieChart(PostRepository $postRepository): Response
{
    $postCommentCounts = $postRepository->getPostsWithCommentCount();

    return $this->render('statistics/pie_chart.html.twig', [
        'postCommentCounts' => $postCommentCounts,
    ]);
}
}
