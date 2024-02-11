<?php

namespace App\Controller\Admin;

use App\Form\Type\ChangeUserRoleType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/admin/user/list', name: 'admin_user_list')]
    public function list(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $userRepository->findAll();
        $roleForm = $this->createForm(ChangeUserRoleType::class, null);

        return $this->render('admin/user/list.html.twig', [
            'users' => $users,
            'userRoleForm' => $roleForm,
        ]);
    }
}
