<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Type\ChangeUserIsActiveType;
use App\Form\Type\ChangeUserRoleType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/admin/user/list', name: 'admin_user_list')]
    public function list(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $userRepository->findAll();
        $roleForm = $this->createForm(ChangeUserRoleType::class, null, [
            'action' => $this->generateUrl('admin_user_role_edit'),
            'method' => 'POST',
        ]);
        $isActiveForm = $this->createForm(ChangeUserIsActiveType::class, null, [
            'action' => $this->generateUrl('admin_user_is_active_edit'),
            'method' => 'POST',
        ]);

        return $this->render('admin/user/list.html.twig', [
            'users' => $users,
            'userRoleForm' => $roleForm,
            'userIsActiveForm' => $isActiveForm,
        ]);
    }

    #[Route('/admin/user/role/edit', name:"admin_user_role_edit")]
    public function editUserRole(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $roleForm = $this->createForm(ChangeUserRoleType::class, null);
        $roleForm->handleRequest($request);

        if ($roleForm->isSubmitted() && $roleForm->isValid()) {
            try {
                $userRepository = $entityManager->getRepository(User::class);
                /** @var User $userToEdit */
                $userToEdit = $userRepository->findOneBy(['username' => $roleForm->get('username')->getData()]);
                if ($userToEdit === null) {
                    $logger->warning('User "'.$this->getUser()->getUserIdentifier().'" is trying to play with hidden field username of userRoleForm');
                } else {
                    $wantedRole = $roleForm->get('wantedBiggestRole')->getData();
                    if ($wantedRole === 'ADMIN') {
                        $logger->warning('User "'.$this->getUser()->getUserIdentifier().'" just tryed to set ADMIN role to user "'.$userToEdit.'"');
                    } else {
                        $wantedRole !== 'USER' ? $userToEdit->setRoles(['ROLE_'.$wantedRole]) : $userToEdit->setRoles([]);
                        $entityManager->persist($userToEdit);
                        $entityManager->flush();
                        $this->addFlash('success', $userToEdit->getUserIdentifier().' à maintenant le rôle '.$wantedRole);
                    }
                }
            } catch (\Exception $exception) {
                $logger->error($exception->getMessage());
                $logger->Error($exception->getTraceAsString());
                $this->addFlash('error', 'Un problème est survenu pendant l\'enregistrement');
            }
        }

        return $this->redirectToRoute('admin_user_list');
    }

    #[Route('/admin/user/is-active/edit', name:"admin_user_is_active_edit")]
    public function editIsActive(
        Request $request,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
    ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $isActiveForm = $this->createForm(ChangeUserIsActiveType::class, null);
        $isActiveForm->handleRequest($request);

        if ($isActiveForm->isSubmitted() && $isActiveForm->isValid()) {
            try {
                $userRepository = $entityManager->getRepository(User::class);
                /** @var User $userToEdit */
                $userToEdit = $userRepository->findOneBy(['username' => $isActiveForm->get('username')->getData()]);
                if ($userToEdit === null) {
                    $logger->warning('User "'.$this->getUser()->getUserIdentifier().'" is trying to play with hidden field username of userRoleForm');
                } else {
                    $isActive = $isActiveForm->get('wantedIsActive')->getData() === 'true';
                    $userToEdit->setIsActive($isActive);
                    $value = $isActive ? 'activé' : 'désactivé';
                    $message = 'Le compte de '.$userToEdit->getUserIdentifier().' est maintenant '.$value.'.';

                    $entityManager->persist($userToEdit);
                    $entityManager->flush();
                    $this->addFlash('success', $message);
                }
            } catch (\Exception $exception) {
                $logger->error($exception->getMessage());
                $logger->Error($exception->getTraceAsString());
                $this->addFlash('error', 'Un problème est survenu pendant l\'enregistrement');
            }
        }

        return $this->redirectToRoute('admin_user_list');
    }
}
