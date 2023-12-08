<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EnergieRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Energie;
use App\Form\EnergieType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class EnergieController extends AbstractController{

    
    #[Route('/showEnergie', name: 'app_energie_index', methods: ['GET'])]
    public function index(EnergieRepository $energieRepository): Response
    {
        return $this->render('Back/Energie/index.html.twig', [
            'Energies' => $energieRepository->findAll(),
        ]);
    }
    #[Route('/newen', name: 'app_energie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response{
    $energie = new Energie();
    $form = $this->createForm(EnergieType::class, $energie);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($energie);
        $entityManager->flush();

        return $this->redirectToRoute('app_energie_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Back/energie/new.html.twig', [
        'energie' => $energie,
        'form' => $form,
    ]);
    }


    #[Route('/{idEnergie}/editen', name: 'app_energie_edit', methods: ['GET', 'POST'])]
    #[ParamConverter("energie")]
    public function edit(Request $request, Energie $idEnergie, EntityManagerInterface $entityManager): Response
    {   
        $form = $this->createForm(EnergieType::class, $idEnergie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_energie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/Energie/_edit.html.twig', [
            'energie' => $idEnergie,
            'form' => $form,
        ]);
    }

    #[Route('/{idEnergie}/deleteen', name: 'app_energie_delete', methods: ['POST'])]
    #[ParamConverter("energie")]
    public function delete(Request $request, Energie $idEnergie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $idEnergie->getIdEnergie(), $request->request->get('_token'))) {
            $entityManager->remove($idEnergie);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_energie_index', [], Response::HTTP_SEE_OTHER);
    }
}
