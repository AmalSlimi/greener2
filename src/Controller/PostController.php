<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\CommentairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;

/*use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Bridge\Symfony\Mailer\TransportFactory as MailerTransportFactory;
use Symfony\Component\Notifier\Bridge\Symfony\Mailer\SentMessageTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Notifier\Recipient\EmailRecipient;*/





#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

// front user : 
    #[Route('/user', name: 'app_post_user', methods: ['GET'])]
    public function index2(PostRepository $postRepository): Response
    {
        return $this->render('Front/user/postUserHome.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }
// front entreprise 

    #[Route('/entreprise', name: 'app_post_entreprise', methods: ['GET'])]
    public function indexE(PostRepository $postRepository): Response
    {
        return $this->render('Front/entreprise/postEntreprise.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /*private $notifier;
    private $mailer;

    public function __construct(NotifierInterface $notifier, MailerInterface $mailer)
    {
    $this->notifier = $notifier;
    $this->mailer = $mailer;
    }*/

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setIdEntreprise(1);

            $imageFile = $form->get('image')->getData();
            if ($imageFile instanceof UploadedFile) {
                
                $generatedImageURL = $imageFile->getClientOriginalName(); 
    
                $post->setImage($generatedImageURL);
            }
            
            $entityManager->persist($post);
            $entityManager->flush();

            /*$email = (new Email())
                ->from(new Address('amal.as6060@gmail.com'))
                ->to(new Address('slimi.amal@esprit.tn'))
                ->subject('New Post Added')
                ->text('A new post has been added to the system.');

            // Send the email notification
            
            $this->mailer->send($email);*/

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    // front user 
    #[Route('/entreprise/new', name: 'app_post_newE', methods: ['GET', 'POST'])]
    public function newE(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $imageFile = $form->get('image')->getData();
            if ($imageFile instanceof UploadedFile) {
                // If you want to use the same image path without moving it
                $generatedImageURL = $imageFile->getClientOriginalName(); // You can adjust this based on how you store the image path or name
    
                // Set the image property of your Post entity with the URL
                $post->setImage($generatedImageURL);
            }
            
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_post_entreprise', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/entreprise/newPostEntreprise.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{idPost}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    

    // front entreprise
    #[Route('/entreprise/{idPost}', name: 'app_post_showE', methods: ['GET'])]
    public function showE(Post $post): Response
    {
        return $this->render('Front/entreprise/showPostEntreprise.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{idPost}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    // front entreprise
    #[Route('/entreprise/{idPost}/edit', name: 'app_post_editE', methods: ['GET', 'POST'])]
    public function editE(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_post_entreprise', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/entreprise/editPostEntreprise.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{idPost}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getIdPost(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }

    // front entreprise
    #[Route('/entreprise/{idPost}', name: 'app_post_deleteE', methods: ['POST'])]
    public function deleteE(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getIdPost(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_post_entreprise', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{idPost}/commentaires', name: 'app_post_comments', methods: ['GET'])]
    public function showComments(Post $post, CommentaireRepository $commentaireRepository): Response
    {
        $comments = $commentaireRepository->findCommentsByPost($post);

        return $this->render('post/comments.html.twig', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    
}
