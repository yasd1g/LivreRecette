<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="admin_users_index")
     */
    public function index(PaginatorInterface $paginator, UserRepository $repo, Request $request)
    {
        $users = $paginator->paginate(
            $users = $repo->findAll(), /* la query sans getResult() */
            $request->query->getInt('page', 1), /* le numéro de page par defaut on met 1 */
            5 /* la limite par page*/
        );


        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }
}
