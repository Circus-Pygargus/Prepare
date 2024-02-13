<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\Type\ProjectType;
use App\Service\String\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    #[Route('/project/create', name: 'app_project_create')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        Slugger $slugger
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CONTRIBUTOR');

        $project = new Project();
        $projectForm = $this->createForm(ProjectType::class, $project);
        $projectForm->handleRequest($request);

        if ($projectForm->isSubmitted() && $projectForm->isValid()) {
            $project->setCreatedBy($this->getUser());
            $project->setSlug($slugger->slug($project->getName()));

            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('project/create.html.twig', [
            'projectForm' => $projectForm,
        ]);
    }

    /* TODO lors de l'ajout des forms de la page (création de catégorie, ajout d'item ...)
        penser à créer un id html sur le nouvel élément qui s'afiche dans cette page
        et depuis la gestion du formulaire faire un
            return  $this->redirectToRoute('app_login', ['_fragment' => 'password']);
        ici password correspond à l'id de la balise que l'on veut afficher en haut de page */
    #[Route('/project/show/{slug}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render(('project/show.html.twig'), [
            'project' => $project
        ]);
    }
}
