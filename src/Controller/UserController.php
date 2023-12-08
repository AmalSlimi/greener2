<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Entreprise;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Form\User1Type;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\EntrepriseRepository;


#[Route('/user')]
class UserController extends AbstractController
{



    #[Route('/cnxx', name: 'app_cnx')]
    public function Cnxx(EntrepriseRepository $entrRepository, UserRepository $userrepo, Request $request): Response
    {
        $mail = "";
        $user = new User();

        if ($request->isMethod('POST')) {
            //get mail + mdp
            $mail = $request->request->get('email');
            $password = $request->request->get('mdp');
            $user = $userrepo->getUserByEmail($mail);
            $entreprise = $entrRepository->getUserByEmail($mail);
            // var_dump($mail);
            // var_dump($user);
            // die();
            if (!($user == null)) {

                if (strtolower($user->getRole()) === "client") {
                    return $this->redirectToRoute('app_user_profile', ['id' => $user->getIdUser()]);
                }
                if (strtolower($user->getRole()) === "investisseur") {
                    return $this->redirectToRoute('app_inv_profile', ['id' => $user->getIdUser()]);
                }
            }
            if (!($entreprise == null)) {
                if (strtolower($entreprise->getRole()) === "agent_entreprise" || strtolower($entreprise->getRole()) === "agent") {
                    $file=fopen(__DIR__."/pnt.txt","w");
                    fwrite($file,$entreprise->getIdEntrprise());
                    fclose($file);
                    return $this->redirectToRoute('app_entreprise_profile', ['id' => $entreprise->getIdEntreprise()]);
                }
            }
            if ($mail === "admin" && $password === "admin") {
                return $this->redirectToRoute('app_user_index');
            }
            if ($user == null  && $entreprise == null) {

                // Le mot de passe est incorrect
                // Affichez une alerte
                echo "<script>alert('Aucun compte associer a ce mail.');</script>";
            }
        }
        return $this->renderForm('Front/cnx.html.twig');
    }
    #[Route('/cnxx77', name: 'app_cnx_')]
    public function Cnxx77(EntrepriseRepository $entrRepository, UserRepository $userrepo, Request $request): Response
    {
        $mail = "";
        $user = new User();

        if ($request->isMethod('POST')) {
            //get mail + mdp
            $mail = $request->request->get('email');
            $password = $request->request->get('mdp');
            var_dump($mail);
            die();
            if ($mail === "admin" && $password === "admin") {
                return $this->redirectToRoute('app_user_index');
            }
        }
        return $this->renderForm('Front/cnx.html.twig');
    }


    //stat de genre (ux_jschart)
    #[Route('/gender_statistics', name: 'gender_statistics')]
    public function genre_stat(UserRepository $userRepository, EntrepriseRepository $entrRepository): Response
    {
        $hommes = $userRepository->countMen()  + $entrRepository->countMen();;

        $femmes = $userRepository->countWomen()  + $entrRepository->countWomen();

        // Render the chart and return the response
        return $this->render('Back/genre.html.twig', [
            'hommes' => $hommes,
            'femmes' => $femmes
        ]);
    }

    //stat des roles  (pie chart)
    #[Route('/role_counts', name: 'role_counts', methods: ['GET'])]
    public function roleCounts(UserRepository $userRepository, EntrepriseRepository $entrprise): Response
    {
        $numberOfClients = $userRepository->countByRole('client');
        $numberOfInvestors = $userRepository->countByRole('investisseur');
        $numberOfCompanyAgents = $entrprise->countByRole('agent_entreprise');

        // Render the chart view with the counts
        return $this->render('Back/role_counts.html.twig', [
            'numberOfClients' => $numberOfClients,
            'numberOfInvestors' => $numberOfInvestors,
            'numberOfCompanyAgents' => $numberOfCompanyAgents
        ]);
    }

    #[Route('/contact', name: 'app_user_contact', methods: ['GET'])]
    public function contact(): Response
    {
        return $this->render('Back/AdminHome.html.twig');
    }


    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {  
        return $this->render('Back/user/index.html.twig', [
            'users' => $userRepository->findLatestUsers(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userrepo): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);


        $query = $userrepo->createQueryBuilder('a')
            ->select('MAX(a.id) as max')
            ->getQuery();
        $result = $query->getSingleScalarResult();

        $result  = $result + 1;
        $user->setIdUser($result);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('Back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(UserPasswordHasherInterface $passwordHasher, Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);
        $formData = $form->getData();

        $password = $formData->getMdp1();

        $user->setMdp1($passwordHasher->hashPassword($user, $password));


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getIdUser(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }


    //front user 

    //home client
    #[Route('/profile/{id}', name: 'app_user_profile', methods: ['GET'])]
    public function profile(User $user): Response
    {
        return $this->render('Front/user/UserHome.html.twig', [
            'user' => $user,
        ]);
    }
    //edit profile
    #[Route('/{id}/Meedit', name: 'app_user_Meedit', methods: ['GET', 'POST'])]
    public function Meedit(UserPasswordHasherInterface $passwordHasher, Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);
        $formData = $form->getData();

        $password = $formData->getMdp1();

        $user->setMdp1($passwordHasher->hashPassword($user, $password));



        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_profile', [
                'id' => $user->getIdUser()
            ]);
        }

        return $this->renderForm('Front/user/Meedit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    //front inv
    #[Route('/profileinv/{id}', name: 'app_inv_profile', methods: ['GET'])]
    public function profileinv(User $user): Response
    {
        return $this->render('Front/user/invHome.html.twig', [
            'user' => $user,
        ]);
    }
}
