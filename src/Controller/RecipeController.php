<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    /**
     * Permet d'afficher la liste des recettes
     *
     * @param RecipeRepository $repo
     *
     * @Route("/recipes", name="recipe_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(RecipeRepository $repo)
    {

        $recipes = $repo->findAll();
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }


    /**
     * Permet de créer une nouvelle recette
     *
     * @param Request                $request
     * @param EntityManagerInterface $manager
     * @Route("/recipes/new", name="recipe_create")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            foreach ($recipe->getImages() as $image){

                $image->setRecipe($recipe);
                $manager->persist($image);
            }

            $recipe->setAuthor($this->getUser());

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$recipe->getTitle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('recipe_show', [
                'slug' => $recipe->getSlug()
            ]);
        }

        return $this->render('recipe/new.html.twig',
            [
               'form' => $form->createView()
            ]);
    }


    /**
     * Permet de modifier une recette
     *
     * @param Request                $request
     * @param EntityManagerInterface $manager
     * @param Recipe                 $recipe
     *
     * @Route("/recipes/{slug}/edit", name="recipe_edit")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, Recipe $recipe)
    {
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            foreach ($recipe->getImages() as $image){
                $image->setRecipe($recipe);
                $manager->persist($image);
            }

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'danger',
                "Votre recette <strong>{$recipe->getTitle()}</strong> a bien été modifiée."
            );

            return $this->redirectToRoute('recipe_show', [
                'slug' => $recipe->getSlug()
            ]);

        }


        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView(),
            'recipe' =>$recipe
        ]);
    }

    /**
     * Permet d'afficher une seule recette
     *
     * @param Recipe $recipe
     * @Route("/recipes/{slug}", name="recipe_show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Recipe $recipe)
    {

        return $this->render('recipe/show.html.twig', [
               'recipe' => $recipe
            ]);
    }

    /**
     * @param EntityManagerInterface $manager
     * @param Recipe                 $recipe
     *
     * @Route("/recipes/{slug}/delete", name="recipe_delete")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(EntityManagerInterface $manager, Recipe $recipe)
    {
        $manager->remove($recipe);
        $manager->flush();

        $this->addFlash(
            'success',
            "Votre recette a bien été supprimée."
        );

        return $this->redirectToRoute('recipe_index');
    }
}
