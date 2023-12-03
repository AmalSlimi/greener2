<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier_index', methods: ['GET'])]
    public function index(PanierRepository $panierRepository): Response
    {
        return $this->render('panier/index.html.twig', [
            'paniers' => $panierRepository->findAll(),
        ]);
    }
    #[Route('/user', name: 'app_panier_user', methods: ['GET'])]
    public function index1(PanierRepository $panierRepository): Response
    {
        return $this->render('Front/user/panierUserHome.html.twig', [
            'paniers' => $panierRepository->findAll(),
        ]);
    }

  

    #[Route('/new', name: 'app_panier_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $clientid = 1;
    $produitid = 1;

    $panier = new Panier();
    $panier->setClientId($clientid);
    $panier->setProduitId($produitid);

    $form = $this->createForm(PanierType::class, $panier);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Calculate total based on price and quantity
        $total = $panier->getPrix() * $panier->getQuantite();
        $panier->setTotal($total);


        $entityManager->persist($panier);
        $entityManager->flush();

        return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('panier/new.html.twig', [
        'panier' => $panier,
        'form' => $form,
    ]);
}
#[Route('/user/new', name: 'app_panier_new1', methods: ['GET', 'POST'])]
public function new1(Request $request, EntityManagerInterface $entityManager): Response
{
    $clientid = 1;
    $produitid = 1;

    $panier = new Panier();
    $panier->setClientId($clientid);
    $panier->setProduitId($produitid);

    $form = $this->createForm(PanierType::class, $panier);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Calculate total based on price and quantity
        $total = $panier->getPrix() * $panier->getQuantite();
        $panier->setTotal($total);


        $entityManager->persist($panier);
        $entityManager->flush();

        return $this->redirectToRoute('app_panier_user', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Front/user/panier/new.html.twig', [
        'panier' => $panier,
        'form' => $form,
    ]);
}


    #[Route('/{panierid}', name: 'app_panier_show', methods: ['GET'])]
    public function show(Panier $panier): Response
    {
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    #[Route('/user/{panierid}', name: 'app_panier_show1', methods: ['GET'])]
    public function show1(Panier $panier): Response
    {
        return $this->render('Front/user/panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    #[Route('/{panierid}/edit', name: 'app_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/user/{panierid}/edit', name: 'app_panier_edit1', methods: ['GET', 'POST'])]
    public function edit1(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/user/panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{panierid}', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getPanierid(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/user/{panierid}', name: 'app_panier_delete1', methods: ['POST'])]
    public function delete1(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getPanierid(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panier_user', [], Response::HTTP_SEE_OTHER);
    }

   
}
