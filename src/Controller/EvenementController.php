<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\User1;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use BaconQrCode\Encoder\QrCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AppAuthenticator;

use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {

        $events = $evenementRepository->findAll();
        $eventStatus = []; 

        foreach ($events as $event) {
            $eventDate = $event->getDateEvenementt();
            $currentDate = new \DateTime();
            $eventStatus[$event->getId()] = $eventDate < $currentDate;

            $qrCodeContent = sprintf(
                'Event ID: %d, Title: %s, Date: %s',
                $event->getId(),
                $event->getTitreEvenement(),
                $event->getDateEvenementt()->format('Y-m-d')
            );
            $event->setQrCode($qrCodeContent);
            

        }
    
    
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'eventStatus' => $eventStatus,

        ]);
    }

    #[Route('/user', name: 'app_evenement_user', methods: ['GET'])]
    public function indexU(EvenementRepository $evenementRepository): Response
    {

        $events = $evenementRepository->findAll();
        $eventStatus = []; 

        foreach ($events as $event) {
            $eventDate = $event->getDateEvenementt();
            $currentDate = new \DateTime();
            $eventStatus[$event->getId()] = $eventDate < $currentDate;

            $qrCodeContent = sprintf(
                'Event ID: %d, Title: %s, Date: %s',
                $event->getId(),
                $event->getTitreEvenement(),
                $event->getDateEvenementt()->format('Y-m-d')
            );
            $event->setQrCode($qrCodeContent);
            

        }
    
    
        return $this->render('Front/evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'eventStatus' => $eventStatus,

        ]);
    }
   
    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserInterface $currentUser): Response
    {
        $evenement = new Evenement();

        if ($currentUser instanceof User1) {
            $evenement->setEntreprise($currentUser);
        }

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                // Générer un nom de fichier unique basé sur le hachage MD5 et l'extension du fichier
                $fileName = md5(uniqid()) . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('upload_directory'),
                    $fileName
                );

                $evenement->setImageEvenement('uploads/' . $fileName);
            }

            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }


    #[Route('/download-pdf', name: 'app_evenement_download_pdf', methods: ['GET'])]
    public function downloadPdf(EvenementRepository $evenementRepository): Response
    {
        $evenements = $evenementRepository->findAll();
        $htmlContent = $this->renderView('evenement/pdf_template.html.twig', [
            'evenements' => $evenements,
        ]);

        $pdfFile = $this->generatePdf($htmlContent);

        //lire le contenu du fichie PDF généré.
        $response = new Response(file_get_contents($pdfFile));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="downloaded_file.pdf"');

        return $response;
    }

    private function generatePdf($htmlContent): string
    {
        // Créer une instance d'options pour Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $outputFile = tempnam(sys_get_temp_dir(), 'pdf_');
        file_put_contents($outputFile, $dompdf->output());

        return $outputFile;
    }
    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/user/{id}', name: 'app_evenement_showUser', methods: ['GET'])]
    public function showUser(Evenement $evenement): Response
    {
        return $this->render('Front/evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getid(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/participate', name: 'app_evenement_participate', methods: ['POST'])]
    public function participate(Request $request, int $id, EntityManagerInterface $entityManager, UserInterface $currentUser): Response
    {
        $evenement = $entityManager->getRepository(Evenement::class)->find($id);
        if (!$evenement) {
            throw $this->createNotFoundException('Evenement not found');
        }

        if ($currentUser instanceof User1) {
            $evenement->addParticipant($currentUser);
            $currentUser->addParticipatedEvenement($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_show', ['id' => $evenement->getid()]);
    }

    #[Route('/user/{id}/participate', name: 'app_evenement_participateUser', methods: ['POST'])]
    public function participatehadil(Request $request, int $id, EntityManagerInterface $entityManager, UserInterface $currentUser): Response
    {
        $evenement = $entityManager->getRepository(Evenement::class)->find($id);
        if (!$evenement) {
            throw $this->createNotFoundException('Evenement not found');
        }

        if ($currentUser instanceof User1) {
            $evenement->addParticipant($currentUser);
            $currentUser->addParticipatedEvenement($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_showUser', ['id' => $evenement->getid()]);
    }

}
