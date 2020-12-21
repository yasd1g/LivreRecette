<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * Permet d'afficher tous les commentaires
     *
     * @Route("/admin/comments", name="admin_comments_index")
     */
    public function index(PaginatorInterface $paginator, CommentRepository $repo, Request $request)
    {
        $comments = $paginator->paginate(
            $comments = $repo->findAll(), /* la query sans getResult() */
            $request->query->getInt('page', 1), /* le numéro de page par defaut on met 1 */
            15 /* la limite par page*/
        );

        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments
        ]);
    }
}
