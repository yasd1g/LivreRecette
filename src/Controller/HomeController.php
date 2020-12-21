<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @param RecipeRepository   $repo
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @Route("/", name="homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(RecipeRepository $repoR , UserRepository $repoU, PaginatorInterface $paginator, Request $request)
    {
//        // affichage avec pagination
//        $recipes = $paginator->paginate(
//            $repo->findAll(), /* la query sans getResult() */
//            $request->query->getInt('page', 1), /* le numéro de page par defaut on met 1 */
//            6 /* la limite par page*/
//        );

        $recipes = $repoR->findBestRecipes(3);
        $users = $repoU->findBestUsers(2);

        return $this->render('home.html.twig', [
            'recipes' => $recipes,
            'users' => $users
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/contact", name="contact")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        return $this->render('partials/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
