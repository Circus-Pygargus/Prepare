<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\Type\ItemType;
use App\Security\ItemVoter;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ItemController extends AbstractController
{
    #[Route('/item/create', name: 'app_item_create')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
    ): Response
    {
        $item = new Item();
        $itemForm = $this->createForm(ItemType::class, $item);
        $itemForm->handleRequest($request);

        $project = $item->getProject();
        $this->denyAccessUnlessGranted('view', $project, 'Tu n\'as les droits suffisants pour ceci !');
        $userCanEditProject = $this->isGranted('edit', $project);

        if ($itemForm->isSubmitted() && $itemForm->isValid()) {
            try {
                $item->setCreatedBy($this->getUser());
                if ($item->isProposed() === null) {
                    $item->setProposed(false);
                }
                if ($item->isOwned() === null) {
                    $item->setOwned(false)
                        ->setValidated(false);
                }

                $entityManager->persist($item);
                $entityManager->flush();
                $this->addFlash('success', 'L\'objet '.$item->getName().' a bien été créé.');

                return $this->redirectToRoute('app_project_show', [
                    'slug' => $item->getProject()->getSlug(),
                    'userCanEditProject' => $userCanEditProject,
                    '_fragment' => $item->getCategory()->getName().'-'.$item->getName(),
                ]);
            } catch (\Exception $e) {
                $logger->error($e->getMessage());
                $logger->error($e->getTraceAsString());
                $this->addFlash('error', 'Un problème est survenu pendant l\'enregistrement');
            }
        }

        return $this->render('/item/edit.html.twig', [
            'item' => $item,
            'editItemForm' => $itemForm,
            'userCanEditProject' => $userCanEditProject,
            'projectSlug' => $project->getSlug(),
        ]);
    }

    #[Route('/item/edit/{slug}', name: 'app_item_edit')]
    #[IsGranted(ItemVoter::EDIT, 'item', 'Tu n\'as les droits suffisants pour ceci !', 403)]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        Item $item,
    ): Response
    {
        if (!$item) {
            $this->addFlash('error', 'Quelque chose d\'étrange vient d\'arriver, l\'objet que tu veux éditer n\existe pas ! Parles en à l\'admin');
            return $this->redirectToRoute('app_home');
        }

        $itemForm = $this->createForm(ItemType::class, $item);
        $itemForm->handleRequest($request);

        $project = $item->getProject();
        $userCanEditProject = $this->isGranted('edit', $project);

        if ($itemForm->isSubmitted() && $itemForm->isValid()) {
            try {
                $entityManager->persist($item);
                $entityManager->flush();
                $this->addFlash('success', 'L\'objet '.$item->getName().' a bien été modifié.');

                return $this->redirectToRoute('app_project_show', [
                    'slug' => $item->getProject()->getSlug(),
                    'userCanEditProject' => $userCanEditProject,
                    '_fragment' => $item->getCategory()->getName().'-'.$item->getName(),
                ]);
            } catch (\Exception $e) {
                $logger->error($e->getMessage());
                $logger->error($e->getTraceAsString());
                $this->addFlash('error', 'Un problème est survenu pendant l\'enregistrement');
            }
        }

        return $this->render('/item/edit.html.twig', [
            'item' => $item,
            'editItemForm' => $itemForm,
            'userCanEditProject' => $userCanEditProject,
            'projectSlug' => $project->getSlug(),
        ]);
    }
}
