<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Entity\Post;
use App\Form\CommentairesType;
use App\Repository\CommentairesRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\BadWordsFilter;
use Symfony\Component\HttpFoundation\JsonResponse;





#[Route('/commentaires')]
class CommentairesController extends AbstractController
{
    #[Route('/', name: 'app_commentaires_index', methods: ['GET'])]
    public function index(CommentairesRepository $commentairesRepository): Response
    {
        return $this->render('commentaires/index.html.twig', [
            'commentaires' => $commentairesRepository->findAll(),
        ]);
    }
// front user
    #[Route('/user', name: 'app_commentaires_user', methods: ['GET'])]
    public function index1(CommentairesRepository $commentairesRepository): Response
    {
        return $this->render('Front/user/commentairesUserHome.html.twig', [
            'commentaires' => $commentairesRepository->findAll(),
        ]);
    }

    

    #[Route('/{idPost}/new-comment', name: 'app_commentaires_new', methods: ['GET', 'POST'])]
public function new(Request $request, $idPost, EntityManagerInterface $entityManager, BadWordsFilter $badWordsFilter): Response
{
    $post = $entityManager->getRepository(Post::class)->find($idPost);

    if (!$post) {
        throw $this->createNotFoundException('The post does not exist');
    }

    $commentaire = new Commentaires();
    $commentaire->setIdPost($idPost); // Set the ID of the post for the comment

    $form = $this->createForm(CommentairesType::class, $commentaire);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Check if the comment contains inappropriate content
        $containsBadWords = $badWordsFilter->containsBadWords($commentaire->getContenu());

        if ($containsBadWords) {
            // The comment contains inappropriate content
            return $this->render('commentaires/inappropriate_comment.html.twig');
        }

        // If the comment doesn't contain inappropriate content, proceed to save it
        $commentaire->setPost($post); // Set the post for the comment
        $commentaire->setStatut('approved'); // Set status as approved
        $entityManager->persist($commentaire);
        $entityManager->flush();

        return $this->redirectToRoute('app_commentaires_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('commentaires/new.html.twig', [
        'commentaire' => $commentaire,
        'form' => $form->createView(),
        'statut' => $commentaire->getStatut(),
    ]);
}


#[Route('/user/{idPost}/new-comment', name: 'app_commentaires_new1', methods: ['GET', 'POST'])]
public function new1(Request $request, $idPost, EntityManagerInterface $entityManager, BadWordsFilter $badWordsFilter): Response
{
    $post = $entityManager->getRepository(Post::class)->find($idPost);

    if (!$post) {
        throw $this->createNotFoundException('The post does not exist');
    }

    $commentaire = new Commentaires();
    $commentaire->setIdPost($idPost); // Set the ID of the post for the comment

    $form = $this->createForm(CommentairesType::class, $commentaire);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Check if the comment contains inappropriate content
        $containsBadWords = $badWordsFilter->containsBadWords($commentaire->getContenu());

        if ($containsBadWords) {
            // The comment contains inappropriate content
            return $this->render('Front/user/inappropriate_comment.html.twig');
        }

        // If the comment doesn't contain inappropriate content, proceed to save it
        $commentaire->setPost($post); // Set the post for the comment
        $commentaire->setStatut('approved'); // Set status as approved
        $entityManager->persist($commentaire);
        $entityManager->flush();

        return $this->redirectToRoute('app_commentaires_user', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('Front/user/newCmntUser.html.twig', [
        'commentaire' => $commentaire,
        'form' => $form->createView(),
        'statut' => $commentaire->getStatut(),
    ]);
}
   

    /*#[Route('/user/{idPost}/new-comment', name: 'app_commentaires_new1', methods: ['GET', 'POST'])]
    public function new1(Request $request, $idPost, EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager->getRepository(Post::class)->find($idPost);

        if (!$post) {
            throw $this->createNotFoundException('The post does not exist');
        }

        $commentaire = new Commentaires();
        $commentaire->setIdPost($idPost); // Set the ID of the post for the comment

        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setPost($post); // Set the post for the comment
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaires_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/user/newCmntUser.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }*/

    #[Route('/{idCommentaire}', name: 'app_commentaires_show', methods: ['GET'])]
    public function show(Commentaires $commentaire): Response
    {
        return $this->render('commentaires/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

// front user

#[Route('/user/{idPost}', name: 'app_comments_show_by_post', methods: ['GET'])]
public function showCommentsByPost($idPost, CommentairesRepository $commentairesRepository): Response
{
    // Fetch comments by post ID using the repository function
    $comments = $commentairesRepository->findBy(['idPost' => $idPost]);

    return $this->render('Front/user/showCmnt_by_post.html.twig', [
        'comments' => $comments,
    ]);
}
    #[Route('/userr/{idCommentaire}', name: 'app_commentaires_show1', methods: ['GET'])]
    public function show1(Commentaires $commentaire): Response
    {
        return $this->render('Front/user/showCmntUser.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/{idCommentaire}/edit', name: 'app_commentaires_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaires $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaires/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    // front user
    #[Route('/user/{idCommentaire}/edit', name: 'app_commentaires_edit1', methods: ['GET', 'POST'])]
    public function edit1(Request $request, Commentaires $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaires_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/user/editCmntUser.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommentaire}', name: 'app_commentaires_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaires $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getIdCommentaire(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaires_index', [], Response::HTTP_SEE_OTHER);
    }
// front user

    #[Route('/user/{idCommentaire}', name: 'app_commentaires_delete1', methods: ['POST'])]
    public function delete1(Request $request, Commentaires $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getIdCommentaire(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaires_user', [], Response::HTTP_SEE_OTHER);
    }

    
    
    


     /*#[Route('/new', name: 'app_commentaires_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaires/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }*/
    
// front user
    /*#[Route('/user/new', name: 'app_commentaires_new1', methods: ['GET', 'POST'])]
    public function new1(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaires_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/user/newCmntUser.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }*/

}
