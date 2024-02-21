<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Item;
use App\Entity\Project;
use App\Form\Type\CategoryType;
use App\Form\Type\ItemType;
use App\Form\Type\ProjectContributorsType;
use App\Form\Type\ProjectType;
use App\Security\ProjectVoter;
use App\Service\String\SluggerService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProjectController extends AbstractController
{
    #[Route('/project/create', name: 'app_project_create')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerService $slugger,
        LoggerInterface $logger,
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CONTRIBUTOR');

        $project = new Project();
        $projectForm = $this->createForm(ProjectType::class, $project);
        $projectForm->handleRequest($request);

        if ($projectForm->isSubmitted() && $projectForm->isValid()) {
            try {
                $project->setCreatedBy($this->getUser());
                $slug = $slugger->slug($project->getName(), Project::class, '_');
                $project->setSlug($slug);

                $entityManager->persist($project);
                $entityManager->flush();

            } catch (\Exception $e) {
                $logger->error($e->getMessage());
                $logger->error($e->getTraceAsString());
                $this->addFlash('error', 'Un problème est survenu pendant l\'enregistrement');
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('project/create.html.twig', [
            'projectForm' => $projectForm,
        ]);
    }

    #[Route('/project/show/{slug}', name: 'app_project_show', methods: ['GET'])]
    #[IsGranted(ProjectVoter::VIEW, 'project', 'Tu n\'as pas accès à cette page', 403)]
    public function show(Project $project): Response
    {
        $userCanEditProject = $this->isGranted('edit', $project);
        $contributorsForm = $this->createForm(ProjectContributorsType::class, $project, [
            'action' => $this->generateUrl('app_project_edit_contributors'),
            'method' => 'POST',
        ]);

        $addCategoryForm = $this->createForm(CategoryType::class, null, [
            'action' => $this->generateUrl('app_project_add_category', ['slug' => $project->getSlug()]),
            'method' => 'POST',
        ]);

        $item = new Item();
        $addItemForm = $this->createForm(ItemType::class, $item, [
            'action' => $this->generateUrl('app_item_create'),
            'method' => 'POST',
        ]);

        return $this->render(('project/show.html.twig'), [
            'project' => $project,
            'contributorsForm' => $contributorsForm,
            'addCategoryForm' => $addCategoryForm,
            'addItemForm' => $addItemForm,
            'userCanEditProject' => $userCanEditProject,
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
                $logger->warning('l\'utilisateur '.$this->getUser()->getUserIdentifier().'tente de modifier les participants du projet '.$contributorsForm->get('slug')->getData()).'. Ce projet n\'a pas été trouvé en BDD !';
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

        // Good practice is certainly to redirect to the page where the form was sent (project show page), but if form isn't valid, user must have made something really bad to brake it ...
        return $this->redirectToRoute('app_home');
    }

    #[Route('/project/{slug}/add-category', name: 'app_project_add_category', methods: ['POST'])]
    public function addCategory(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        Project $project,
        SluggerService $slugger,
    ): Response
    {
        $category = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            try {
                $slug = $slugger->slug($category->getName(), Category::class, '_');
                $category->setSlug($slug);
                $category->setCreatedBy($this->getUser());
                $category->setProject($project);
                $entityManager->persist($category);

                $entityManager->flush();
                $this->addFlash('success', 'La catégorie '.$category->getName().' a bien été enregistrée.');

                return $this->redirectToRoute('app_project_show', [
                    'slug' => $project->getSlug(),
                    '_fragment' =>$category->getName() // Will redirect to the wanted page's anchor
                ]);
            } catch (\Exception $e) {
                $logger->error($e->getMessage());
                $logger->Error($e->getTraceAsString());
                $this->addFlash('error', 'Un problème est survenu pendant l\'enregistrement');
            }
        }

        return $this->redirectToRoute('app_project_show', [
            'slug' => $project->getSlug(),
            '_fragment' => 'category'
        ]);
    }
}
