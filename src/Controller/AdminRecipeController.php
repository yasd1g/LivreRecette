<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminRecipeController extends AbstractController
{
    /**
     * Permet d'afficher la liste des recettes
     *
     * @Route("/admin/recipes", name="admin_recipes_index")
     */
    public function index(PaginatorInterface $paginator, RecipeRepository $repo, Request $request)
    {


        $recipes = $paginator->paginate(
            $recipes = $repo->findAll(), /* la query sans getResult() */
            $request->query->getInt('page', 1), /* le numéro de page par defaut on met 1 */
            9 /* la limite par page*/
        );


        return $this->render('admin/recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }
}
