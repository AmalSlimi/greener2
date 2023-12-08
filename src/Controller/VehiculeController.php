<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VehiculeRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Vehicule;
use App\Form\VehiculeType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class VehiculeController extends AbstractController{

    
    #[Route('/showVehicule', name: 'app_vehicule_index', methods: ['GET'])]
    public function index(VehiculeRepository $vehiculeRepository): Response
    {
        return $this->render('Back/Vehicule/index.html.twig', [
            'Vehicules' => $vehiculeRepository->findAll(),
        ]);
    }
    #[Route('/newveh', name: 'app_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response{
    $vehicule = new Vehicule();
    $form = $this->createForm(VehiculeType::class, $vehicule);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($vehicule);
        $entityManager->flush();

        return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Back/vehicule/new.html.twig', [
        'vehicule' => $vehicule,
        'form' => $form,
    ]);
    }


    #[Route('/{idVehicule}/editveh', name: 'app_vehicule_edit', methods: ['GET', 'POST'])]
    #[ParamConverter("vehicule")]
    public function edit(Request $request, Vehicule $idVehicule, EntityManagerInterface $entityManager): Response
    {   
        $form = $this->createForm(VehiculeType::class, $idVehicule);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/Vehicule/_edit.html.twig', [
            'vehicule' => $idVehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{idVehicule}/deleteveh', name: 'app_vehicule_delete', methods: ['POST'])]
    #[ParamConverter("vehicule")]
    public function delete(Request $request, Vehicule $idVehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $idVehicule->getIdVehicule(), $request->request->get('_token'))) {
            $entityManager->remove($idVehicule);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }
}
