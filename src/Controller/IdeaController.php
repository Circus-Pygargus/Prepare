<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Form\Type\IdeaType;
use App\Security\IdeaVoter;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IdeaController extends AbstractController
{
    #[Route('/idea/create', name: 'app_idea_create')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
    ): Response
    {
        $idea = new Idea();
        $ideaForm = $this->createForm(IdeaType::class, $idea);
        $ideaForm->handleRequest($request);

        $project = $idea->getProject();
        $this->denyAccessUnlessGranted('view', $project, 'Tu n\'as les droits suffisants pour ceci !');
        $userCanEditProject = $this->isGranted('edit', $project);

        if ($ideaForm->isSubmitted() && $ideaForm->isValid()) {
            try {
                $idea->setCreatedBy($this->getUser());
                if ($idea->isProposed() === null) {
                    $idea->setProposed(false);
                }
                if ($idea->isOwned() === null) {
                    $idea->setOwned(false)
                        ->setValidated(false);
                }

                $entityManager->persist($idea);
                $entityManager->flush();
                $this->addFlash('success', 'L\'idée '.$idea->getName().' a bien été créée.');

                return $this->redirectToRoute('app_project_show', [
                    'slug' => $idea->getProject()->getSlug(),
                    'userCanEditProject' => $userCanEditProject,
                    '_fragment' => $idea->getCategory()->getName().'-'.$idea->getName(),
                ]);
            } catch (\Exception $e) {
                $logger->error($e->getMessage());
                $logger->error($e->getTraceAsString());
                $this->addFlash('error', 'Un problème est survenu pendant l\'enregistrement');
            }
        }

        return $this->render('/idea/edit.html.twig', [
            'idea' => $idea,
            'editIdeaForm' => $ideaForm,
            'userCanEditProject' => $userCanEditProject,
            'projectSlug' => $project->getSlug(),
        ]);
    }

    #[Route('/idea/edit/{slug}', name: 'app_idea_edit')]
    #[IsGranted(IdeaVoter::EDIT, 'idea', 'Tu n\'as les droits suffisants pour ceci !', 403)]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        Idea $idea,
    ): Response
    {
        if (!$idea) {
            $this->addFlash('error', 'Quelque chose d\'étrange vient d\'arriver, l\'idée que tu veux éditer n\'existe pas ! Parles en à l\'admin');
            return $this->redirectToRoute('app_home');
        }

        $ideaForm = $this->createForm(IdeaType::class, $idea);
        $ideaForm->handleRequest($request);

        $project = $idea->getProject();
        $userCanEditProject = $this->isGranted('edit', $project);

        if ($ideaForm->isSubmitted() && $ideaForm->isValid()) {
            try {
                $entityManager->persist($idea);
                $entityManager->flush();
                $this->addFlash('success', 'L\'idée '.$idea->getName().' a bien été modifiée.');

                return $this->redirectToRoute('app_project_show', [
                    'slug' => $idea->getProject()->getSlug(),
                    'userCanEditProject' => $userCanEditProject,
                    '_fragment' => $idea->getCategory()->getName().'-'.$idea->getName(),
                ]);
            } catch (\Exception $e) {
                $logger->error($e->getMessage());
                $logger->error($e->getTraceAsString());
                $this->addFlash('error', 'Un problème est survenu pendant l\'enregistrement');
            }
        }

        return $this->render('/idea/edit.html.twig', [
            'idea' => $idea,
            'editIdeaForm' => $ideaForm,
            'userCanEditProject' => $userCanEditProject,
            'projectSlug' => $project->getSlug(),
        ]);
    }
}
