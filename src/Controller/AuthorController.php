<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Author;
use App\Form\AuthorType;
use Symfony\Component\HttpFoundation\Request;

class AuthorController extends AbstractController
{
    private $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/author/{name}', name: 'show_author')]
    public function showAuthor($name): Response
    {
        return $this->render('author/index.html.twig', [
            'author_name' => $name,
        ]);
    }
    #[Route('/authorlist', name: 'author_list')]
        public function list(): Response
        {
            return $this->render('author/list.html.twig', [
                'authors' => $this->authors,
            ]);
        }
        #[Route('/authordetails/{id}', name: 'app_details')]
        public function authorDetails($id): Response
        {
            return $this->render('author/showAuthor.html.twig', [
                'id' => $id,
                'image'=>$this->authors[$id-1]['picture'],
                'nom' => $this->authors[$id-1]['username'],
                'email' =>$this->authors[$id-1]['email'],
                'nbliv' => $this->authors[$id-1]['nb_books'],
            ]);
        }
        #[Route('/getAll', name: 'author_listDB')]
        public function getAll(AuthorRepository $repo):Response{
            $list = $repo->findAll();/* Select * from author*/ 
            return $this->render('author/listDB.html.twig',[
                'authors'=>$list,
            ]);
        }
        #[Route('/getOne/{id}', name: 'author_getOne')]
        public function getAuthor(AuthorRepository $repo,$id):Response{
            $author = $repo->find($id);/* Select * from author*/ 
            return $this->render('author/details.html.twig',[
                'author'=>$author,
            ]);
        }
        #[Route('/addAuthor', name: 'author_add')]
        public function addAuthor(ManagerRegistry $manager):Response{
            $em = $manager->getManager();
            $author = new Author();
            $author->setEmail("George.R.R marting@gmail.com");
            $author->setUsername("George.R.R.Martin");
            $em->persist($author);
            $em->flush();
            return new Response("Author added");
        }
        #[Route('/add', name: 'author_addDB')]
        public function addAuthorDB(Request $req, ManagerRegistry $manager): Response{
            $em = $manager->getManager();
            
            $author = new Author();
            
            $form = $this->createForm(AuthorType::class, $author);
            $form->handleRequest($req);
            if($form->isSubmitted()&&$form->isValid() ){
            
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute(('author_listDB'));

            }
            return $this->render('author/addAuthorDB.html.twig',
            [
                'f' => $form->createView()
            ]
        );
        }
        #[Route('/update/{id}', name: 'author_updateDB')]
        public function updateAuthorDB(Request $req, ManagerRegistry $manager,$id,AuthorRepository $repo): Response{
            $em = $manager->getManager();
            
            $author = $repo->find($id);
            
            $form = $this->createForm(AuthorType::class, $author);
            $form->handleRequest($req);
            if($form->isSubmitted()){
            
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute(('author_listDB'));

            }
            return $this->render('author/addAuthorDB.html.twig',
            [
                'f' => $form->createView()
            ]
        );
        }
        #[Route('/delete/{id}', name: 'author_deleteDB')]
        public function deleteAuthor(ManagerRegistry $manager,AuthorRepository $repo,$id):Response
        {
            $author = $repo->find($id);
            $em = $manager->getManager();

            $em->remove($author);
            $em->flush();
            return $this->redirectToRoute('author_listDB');
        }
}
