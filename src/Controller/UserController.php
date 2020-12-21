<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * permet d'afficher la page profil de n'importe quel utilisateur ( non authentifié)
     *
     * @param User $user
     *
     * @Route("/user/{slug}", name="user_show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(User $user)
    {
        return $this->render('user/account.html.twig', [
            'user' => $user
        ]);
    }
}
