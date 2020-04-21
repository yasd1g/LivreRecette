<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * permet d'afficher le formulaire de login et de se connecter
     *
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        //$error sera égale à null s'il n'ya pas d'erreur
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig',[
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'inscription et de s'inscrire
     *
     * @param Request                      $request
     * @param EntityManagerInterface       $manager
     * @param UserPasswordEncoderInterface $encoder
     *
     * @Route("/register", name="account_register")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $user->setHash($encoder->encodePassword($user,$user->getHash()));
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte utilisateur a bien été créé"
            );

            return $this->redirectToRoute('account_login');

        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier les données de l'utilisateur connecté
     *
     * @param Request                $request
     * @param EntityManagerInterface $manager
     *
     * @Route("/account/profile", name="account_profile")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editProfile(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du profil ont été enregistrées avec succès"
            );

            return $this->redirectToRoute('account_myAccount');

        }
        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * permet de se deconnecter
     *
     * @Route("/logout", name="account_logout")
     */
    public function logout()
    {
        //rien à ecrire tout se passe derriere le rideau grace a symfony et le security.yaml
    }


    /**
     * Permet d'afficher la liste des recettes ajoutées par l'utilisateur
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/account/recipes", name="account_recipes")
     */
    public function myRecipes()
    {
        return $this->render('account/recipes.html.twig');
    }

    /**
     * Permet d'afficher le profil de l'utilisateur connecté
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/account", name="account_myAccount")
     */
    public function myAccount()
    {
        return $this->render('user/account.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}
