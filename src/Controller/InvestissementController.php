<?php

namespace App\Controller;

use App\Entity\Investissement;
use App\Form\InvestissementType;
use App\Repository\InvestissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/investissement')]
class InvestissementController extends AbstractController
{
    #[Route('/', name: 'app_investissement_index', methods: ['GET'])]
    public function index(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('investissement/index.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }

    #[Route('/user', name: 'app_investissement_user', methods: ['GET'])]
    public function indexhad(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('Front/investissement/index.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }

    #[Route('/download-pdf', name: 'app_investissement_download_pdf', methods: ['GET'])]
    public function downloadPdf(InvestissementRepository $investissementRepository): Response
    {
        // Logic to generate or fetch the HTML content you want to convert to PDF
        $investissements = $investissementRepository->findAll();
        $htmlContent = $this->renderView('investissement/pdf_template.html.twig', [
            'investissements' => $investissements,
        ]);

        // Generate the PDF file
        $pdfFile = $this->generatePdf($htmlContent);

        // Set up the Response object
        $response = new Response(file_get_contents($pdfFile));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="downloaded_file.pdf"');

        return $response;
    }

    private function generatePdf($htmlContent): string
    {
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

    #[Route('/new', name: 'app_investissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $investissement = new Investissement();
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($investissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('investissement/new.html.twig', [
            'investissement' => $investissement,
            'form' => $form,
        ]);
    }

    #[Route('/{idInvestissement}', name: 'app_investissement_show', methods: ['GET'])]
    public function show(Investissement $investissement): Response
    {
        return $this->render('investissement/show.html.twig', [
            'investissement' => $investissement,
        ]);
    }

    //front user 
    #[Route('/user/{idInvestissement}', name: 'app_investissement_showUser', methods: ['GET'])]
    public function showhad(Investissement $investissement): Response
    {
        return $this->render('Front/investissement/show.html.twig', [
            'investissement' => $investissement,
        ]);
    }

    #[Route('/{idInvestissement}/edit', name: 'app_investissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('investissement/edit.html.twig', [
            'investissement' => $investissement,
            'form' => $form,
        ]);
    }

    #[Route('/{idInvestissement}', name: 'app_investissement_delete', methods: ['POST'])]
    public function delete(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$investissement->getIdInvestissement(), $request->request->get('_token'))) {
            $entityManager->remove($investissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_investissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
