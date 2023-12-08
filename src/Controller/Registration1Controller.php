<?php

namespace App\Controller;

use App\Entity\User1;
use App\Form\Registration1FormType;
use App\Security\CustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class Registration1Controller extends AbstractController
{
    #[Route('/register1', name: 'app_register1')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, CustomAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user1 = new User1();
        $form = $this->createForm(Registration1FormType::class, $user1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user1->setPassword(
                $userPasswordHasher->hashPassword(
                    $user1,
                    $form->get('plainPassword')->getData()
                )
            );

            $selectedRole = $form->get('role')->getData();
            switch ($selectedRole) {
                case 'entreprise':
                    $user1->setRoles([User1::ROLE_ENTREPRISE]);
                    break;
                case 'investisseur':
                    $user1->setRoles([User1::ROLE_INVESTISSEUR]);
                    break;
                case 'livreur':
                    $user1->setRoles([User1::ROLE_LIVREUR]);
                    break;
                default:
                    // If nothing is selected or an unknown role is selected, set it to ROLE_USER
                    $user1->setRoles([User1::ROLE_USER]);
                    break;
            }

            $entityManager->persist($user1);
            $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $user1,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registration1Form' => $form->createView(),
        ]);
    }

}
