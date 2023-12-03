<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Panier;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Swift_Mailer;
use Swift_Message;
use \Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface ;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    #[Route('/user/', name: 'app_commande_user', methods: ['GET'])]
    public function index2(CommandeRepository $commandeRepository): Response
    {
        return $this->render('Front/user/commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

   /* #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }*/
    private $entityManager;
    private $swiftMailer;
    private $session;

    public function __construct(EntityManagerInterface $entityManager, Swift_Mailer $swiftMailer, SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->swiftMailer = $swiftMailer;
        $this->session = $session;
    }

    #[Route('/new/{panierid}', name: 'app_commande_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, $panierid): Response
{
    // Récupérer le panier associé à l'ID
    $panier = $entityManager->getRepository(Panier::class)->find($panierid);

    $clientid = 1;

    // Créez une nouvelle commande associée à ce panier
    $commande = new Commande();
    $commande->setClientId($clientid);
    $commande->setPanier($panier);

     // Set the montantTotal of the commande to the total of the panier
     $commande->setMontantTotal($panier->getTotal());

    // Utilisez le formulaire pour la création de la commande
    $form = $this->createForm(CommandeType::class, $commande);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($commande);
        $entityManager->flush();
    
        // Vérifier le nombre de commandes pour le client
        $clientId = $commande->getClientId();
        $commandeRepository = $entityManager->getRepository(Commande::class);
    
        $nombreCommandes = $commandeRepository->countCommandesByClientId($clientId);
    
        if ($nombreCommandes === 3 || $nombreCommandes === 5) {
            // Envoyer un e-mail avec Swift Mailer
            $this->sendEmailForSpecialOrder($commande, $nombreCommandes);
    
            // Stocker le message dans la variable de session
            $this->session->set('special_order_message', 'Félicitation ! Vous avez recu un code promo. Un e-mail a été envoyé.');
        }
    
       
    
        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('commande/new.html.twig', [
        'commande' => $commande,
        'form' => $form,
    ]);
}
private function sendEmailForSpecialOrder(Commande $commande, int $nombreCommandes)
{
    $clientEmail = 'achrefghribi8@gmail.com'; // Remplacez cela par l'e-mail du client

    $subject = 'Code Promo !';
    $messageBody = 'Un nouveau code promo a été généré pour votre commande.';

    // Ajoutez des codes promotionnels spécifiques en fonction du nombre de commandes
    if ($nombreCommandes === 3) {
        $codePromo = 'CODE_PROMO_3';
    } elseif ($nombreCommandes === 5) {
        $codePromo = 'CODE_PROMO_5';
    } else {
        // Aucun code promo pour d'autres cas
        $codePromo = null;
    }

    if ($codePromo !== null) {
        $messageBody .= ' Votre code promo est : ' . $codePromo;
    }

    $message = (new Swift_Message($subject))
        ->setFrom('achref.ghribi@esprit.tn')
        ->setTo($clientEmail)
        ->setBody($messageBody);

    $this->swiftMailer->send($message);
}

#[Route('/user/new/{panierid}', name: 'app_commande_new2', methods: ['GET', 'POST'])]
public function new2(Request $request, EntityManagerInterface $entityManager, $panierid): Response
{
    // Récupérer le panier associé à l'ID
    $panier = $entityManager->getRepository(Panier::class)->find($panierid);

    $clientid = 1;

    // Créez une nouvelle commande associée à ce panier
    $commande = new Commande();
    $commande->setClientId($clientid);
    $commande->setPanier($panier);

     // Set the montantTotal of the commande to the total of the panier
     $commande->setMontantTotal($panier->getTotal());

    // Utilisez le formulaire pour la création de la commande
    $form = $this->createForm(CommandeType::class, $commande);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($commande);
        $entityManager->flush();
    
        // Vérifier le nombre de commandes pour le client
        $clientId = $commande->getClientId();
        $commandeRepository = $entityManager->getRepository(Commande::class);
    
        $nombreCommandes = $commandeRepository->countCommandesByClientId($clientId);
    
        if ($nombreCommandes === 3 || $nombreCommandes === 5) {
            // Envoyer un e-mail avec Swift Mailer
            $this->sendEmailForSpecialOrder($commande, $nombreCommandes);
    
            // Stocker le message dans la variable de session
            $this->session->set('special_order_message', 'Félicitation ! Vous avez recu un code promo. Un e-mail a été envoyé.');
        }
    
       
    
        return $this->redirectToRoute('app_commande_user', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('Front/user/commande/new.html.twig', [
        'commande' => $commande,
        'form' => $form,
    ]);
}

#[Route('/apply-promo/{commandeId}', name: 'app_apply_promo', methods: ['POST'])]
public function applyPromo(Request $request, Commande $commande, SessionInterface $session): Response
{
    $codePromo = $request->request->get('code_promo');

    // Initialize the array of applied codes in the session if it's not set
    $appliedCodes = $session->get('applied_codes', []);

    
    // Vérifiez si le code promo a déjà été appliqué
if (in_array($codePromo, $appliedCodes)) {
    // Si le code promo a déjà été appliqué, retournez une réponse JSON avec un avertissement
    $this->addFlash('warning', 'Le code promo a déjà été appliqué.');
            return $this->redirectToRoute('app_commande_index');
    }

    // Ajoutez ici la logique pour vérifier le code promo et appliquer la réduction si nécessaire
    if ($codePromo === 'CODE_PROMO_3') {
        // Appliquer une réduction de 5%
        $montantTotal = $commande->getMontantTotal();
        $nouveauMontantTotal = $montantTotal - ($montantTotal * 0.05);
        $commande->setMontantTotal($nouveauMontantTotal);
        $this->addFlash('success', 'Le code promo a été appliqué avec succès.');
    } elseif ($codePromo === 'CODE_PROMO_5') {
        // Appliquer une réduction de 10%
        $montantTotal = $commande->getMontantTotal();
        $nouveauMontantTotal = $montantTotal - ($montantTotal * 0.10);
        $commande->setMontantTotal($nouveauMontantTotal);
        $this->addFlash('success', 'Le code promo a été appliqué avec succès.');
    } else {
        // Code promo invalide, retournez une réponse JSON avec un message d'erreur
        $this->addFlash('error', 'Code promo invalide.');
   
    }

    // Marquez le code promo comme appliqué en ajoutant à la session
    $appliedCodes[] = $codePromo;
    $session->set('applied_codes', $appliedCodes);

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->flush(); // Enregistrez les modifications en base de données

    return $this->redirectToRoute('app_commande_index');
}


#[Route('/user/apply-promo/{commandeId}', name: 'app_apply_promo2', methods: ['POST'])]
public function applyPromo2(Request $request, Commande $commande, SessionInterface $session): Response
{
    $codePromo = $request->request->get('code_promo');

    // Initialize the array of applied codes in the session if it's not set
    $appliedCodes = $session->get('applied_codes', []);

    // Vérifiez si le code promo a déjà été appliqué
   
if (in_array($codePromo, $appliedCodes)) {
    // Si le code promo a déjà été appliqué, retournez une réponse JSON avec un avertissement
    $this->addFlash('warning', 'Le code promo a déjà été appliqué.');
            return $this->redirectToRoute('app_commande_user');
    }

    // Ajoutez ici la logique pour vérifier le code promo et appliquer la réduction si nécessaire
    if ($codePromo === 'CODE_PROMO_3') {
        // Appliquer une réduction de 5%
        $montantTotal = $commande->getMontantTotal();
        $nouveauMontantTotal = $montantTotal - ($montantTotal * 0.05);
        $commande->setMontantTotal($nouveauMontantTotal);
        $this->addFlash('success', 'Le code promo a été appliqué avec succès.');
    } elseif ($codePromo === 'CODE_PROMO_5') {
        // Appliquer une réduction de 10%
        $montantTotal = $commande->getMontantTotal();
        $nouveauMontantTotal = $montantTotal - ($montantTotal * 0.10);
        $commande->setMontantTotal($nouveauMontantTotal);
        $this->addFlash('success', 'Le code promo a été appliqué avec succès.');
    } else {
        // Code promo invalide, retournez une réponse JSON avec un message d'erreur
        $this->addFlash('error', 'Code promo invalide.');
        return $this->redirectToRoute('app_commande_user');
   
    }

    // Marquez le code promo comme appliqué en ajoutant à la session
    $appliedCodes[] = $codePromo;
    $session->set('applied_codes', $appliedCodes);

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->flush(); // Enregistrez les modifications en base de données

    return $this->redirectToRoute('app_commande_user');
}



    #[Route('/{commandeId}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/user/{commandeId}', name: 'app_commande_show2', methods: ['GET'])]
    public function show2(Commande $commande): Response
    {
        return $this->render('Front/user/commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{commandeId}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/user/{commandeId}/edit', name: 'app_commande_edit2', methods: ['GET', 'POST'])]
    public function edit2(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Front/user/commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    

    #[Route('/{commandeId}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getCommandeId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
   

}
