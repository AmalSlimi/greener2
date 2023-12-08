<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CategorieController extends AbstractController{

    
    #[Route('/showCategorie', name: 'app_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('Back/Categorie/index.html.twig', [
            'Categories' => $categorieRepository->findAll(),
        ]);
    }
    #[Route('/newcat', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response{
    $categorie = new Categorie();
    $form = $this->createForm(CategorieType::class, $categorie);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($categorie);
        $entityManager->flush();

        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Back/Categorie/new.html.twig', [
        'categorie' => $categorie,
        'form' => $form,
    ]);
    }


    #[Route('/{idCategorie}/edit', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
    #[ParamConverter("categorie")]
    public function edit(CategorieRepository $rep,Request $request, Categorie $idCategorie, EntityManagerInterface $entityManager): Response
    {   
        $form = $this->createForm(CategorieType::class, $idCategorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/Categorie/_edit.html.twig', [
            'categorie' => $idCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{idCategorie}/delete', name: 'app_categorie_delete', methods: ['POST'])]
    #[ParamConverter("categorie")]
    public function delete(Request $request, Categorie $idCategorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $idCategorie->getIdCategorie(), $request->request->get('_token'))) {
            $entityManager->remove($idCategorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
