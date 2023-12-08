<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\User1Type;
use App\Security\AppAuthenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Form\FormFactoryInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private $formFactory;
    private $passwordHasher;


    public function __construct(UserPasswordHasherInterface $passwordHasher, FormFactoryInterface $formFactory, EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
        $this->formFactory = $formFactory;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/register', name: 'app_register')]
    public function register(UserRepository $userrepo, Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    { //users already reagistred do not see the reg page see the registration page


        $user = new User();
        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $num = $request->request->get('num');
            $genre = $request->request->get('genre');
            $adresse = $request->request->get('adresse');
            $role = $request->request->get('role');
            $mail = $request->request->get('mail');
            $password = $request->request->get('pass');

            $user->setNom($nom);
            $user->setprenom($prenom);
            $user->setnum($num);
            $user->setgenre($genre);
            $user->setadresse($adresse);
            $user->setrole($role);
            $user->setmail($mail);
            $user->setMdp1($this->passwordHasher->hashPassword($user, $password));
            //set id
            $query = $userrepo->createQueryBuilder('a')
                ->select('MAX(a.id) as max')
                ->getQuery();
            $result = $query->getSingleScalarResult();
            $result  = $result + 1;
            $user->setIdUser($result);
            //$user->setIsVerified("true");
            // var_dump($user);
            // die();

          
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address('shadha.nejmaoui@esprit.tn', 'ForGreenerIndustry'))
                    ->to($user->getMail())
                    ->subject('confirmer votre mail')
                    ->htmlTemplate('Front/confirmation_email.html.twig')
            );
            $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
            return $this->renderForm('Front/user/verify.html.twig');
        }

        return $this->renderForm('Front/user/cree.html.twig');
    }




    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');
        //
        return $this->redirectToRoute('app_cnx');
    }
}
