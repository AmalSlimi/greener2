<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/getAllbooks', name: 'book_listDB')]
        public function getAll(BookRepository $repo):Response{
            $list = $repo->findAll();/* Select * from author*/ 
            return $this->render('book/listDB.html.twig',[
                'books'=>$list,
            ]);
        }
    #[Route('/deleteBook/{ref}', name: 'book_deleteDB')]
        public function deleteBook(ManagerRegistry $manager,BookRepository $rep,$ref):Response
        {
            $em = $manager->getManager();
            $book = $rep->find($ref);
            

            $em->remove($book);
            $em->flush();
            return $this->redirectToRoute('book_listDB');
        }
        #[Route('/getOneBook/{id}', name: 'author_getOne')]
        public function getAuthor(BookRepository $repo,$id):Response{
            $book = $repo->find($id);/* Select * from author*/ 
            return $this->render('book/details.html.twig',[
                'books'=>$book,
            ]);
        }
        #[Route('/addBook', name: 'book_addDB')]
        public function addAuthorDB(Request $req, ManagerRegistry $manager): Response{
            $em = $manager->getManager();
            
            $book = new Book();
            
            $form = $this->createForm(BookType::class, $book);
            $form->handleRequest($req);
            if($form->isSubmitted()){
            
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute(('book_listDB'));

            }
            return $this->render('book/addBookDB.html.twig',
            [
                'f' => $form->createView()
            ]
        );
        }
        #[Route('/updateBook/{ref}', name: 'book_updateDB')]
        public function updateAuthorDB(Request $req, ManagerRegistry $manager,$ref,BookRepository $repo): Response{
            $em = $manager->getManager();
            
            $book = $repo->find($ref);
            
            $form = $this->createForm(BookType::class, $book);
            $form->handleRequest($req);
            if($form->isSubmitted()){
            
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute(('book_listDB'));

            }
            return $this->render('book/addBookDB.html.twig',
            [
                'f' => $form->createView()
            ]
        );
        }
}

