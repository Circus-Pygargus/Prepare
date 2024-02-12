<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $projetRepo = $entityManager->getRepository(Project::class);
        $ownedProjets = [];
        $availableProjects = [];

        if ($this->isGranted('IS_AUTHENTICATED_FULLY'))  {
            $ownedProjets = $projetRepo->findBy(['createdBy' => $this->getUser()]);
            $availableProjects = $projetRepo->findAvailableForUser($this->getUser());
        }

        return $this->render('home/index.html.twig', [
            'ownedProjects' => $ownedProjets,
            'availableProjects' => $availableProjects,
        ]);
    }
}
