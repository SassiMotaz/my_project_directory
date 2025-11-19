<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $confirmPassword = $form->get('confirmPassword')->getData();

            if ($plainPassword !== $confirmPassword) {
                $form->get('confirmPassword')->addError(new FormError('Les mots de passe ne correspondent pas.'));
            } else {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            
                // ⚡ Set roles based on accountType
                switch ($user->getAccountType()) {
                    case 'etudiant':
                        $user->setRoles(['ROLE_ETUDIANT']);
                        break;
                    case 'professeur':
                        $user->setRoles(['ROLE_PROFESSEUR']);
                        break;
                    case 'administration':
                        $user->setRoles(['ROLE_ADMIN']);
                        break;
                    default:
                        $user->setRoles(['ROLE_USER']);
                        break;
                }
            
                $entityManager->persist($user);
                $entityManager->flush();
            
                $this->addFlash('success', 'Votre compte a été créé !');
                return $this->redirectToRoute('app_login');
            }
            
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
