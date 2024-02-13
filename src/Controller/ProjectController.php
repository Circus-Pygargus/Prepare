<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\Type\ProjectContributorsType;
use App\Form\Type\ProjectType;
use App\Service\String\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
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
        $contributorsForm = $this->createForm(ProjectContributorsType::class, $project, [
            'action' => $this->generateUrl('app_project_edit_contributors'),
            'method' => 'POST',
        ]);

        return $this->render(('project/show.html.twig'), [
            'project' => $project,
            'contributorsForm' => $contributorsForm,
        ]);
    }

    #[Route('/project/edit/contributors', name: 'app_project_edit_contributors', methods: ['POST'])]
    public function editContributors(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
    ):Response
    {
        $contributorsForm = $this->createForm(ProjectContributorsType::class, null);
        $contributorsForm->handleRequest($request);

        if ($contributorsForm->isSubmitted() && $contributorsForm->isValid()) {
            $projectRepo = $entityManager->getRepository(Project::class);
            /** @var Project $project */
            $project = $projectRepo->findOneBy(['slug' => $contributorsForm->get('slug')->getData()]);

            if (!$project) {
                $this->addFlash('error', 'Un problème étrange est survenu, il semble que le projet que tu veux modifier n\'existe pas ! Merci de le signaler à l\'admin.');

                return $this->redirectToRoute('app_home');
            }

            try {
                $project->setContributors($contributorsForm->get('contributors')->getData());
                $entityManager->persist($project);
                $entityManager->flush();
                $this->addFlash('success', 'La liste des participants a été modifiée.');
            } catch (\Exception $e) {
                $logger->error($e->getMessage());
                $logger->Error($e->getTraceAsString());
                $this->addFlash('error', 'Un problème est survenu pendant l\'enregistrement');
            }

            return $this->redirectToRoute('app_project_show', [
                'slug' => $project->getSlug(),
            ]);
        }

        // Good practice is cerrtainly to redirect to the page where the form was sent (project show page), but if form isn't valid, user must have made something really bad to brake it ...
        return $this->redirectToRoute('app_home');
    }
}
