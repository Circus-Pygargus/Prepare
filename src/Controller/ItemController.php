<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\Type\ItemType;
use App\Service\String\SluggerService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ItemController extends AbstractController
{
    #[Route('/item/create', name: 'app_item_create')]
    #[Route('/item/edit/{id<\d+>}', name: 'app_item_edit')]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        SluggerService $slugger,
        int $id = null,
    ): Response
    {
        $itemRepo = $entityManager->getRepository(Item::class);
        /** @var Item $item */
        $item = $id === null ?  new Item() : $itemRepo->findOneBy(['id' => $id]);

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
                /** TODO !!! slug IS NOT rebuilt on edit !!! */
                if ($id === null) {
                    $slug = $slugger->slug($item->getName(), Item::class, '_');
                    $item->setSlug($slug);
                }

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
}
