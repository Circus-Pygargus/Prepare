<?php

namespace App\Security;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Project) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $currentUser = $token->getUser();

        if (!$currentUser instanceof User) {
            return false;
        }

        /** @var Project $project */
        $project = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($project, $currentUser);
            case self::EDIT:
                return $this->canEdit($project, $currentUser);
            default:
                return throw new \LogicException('This code should not be reached!');
        }
    }

    private function canView(Project $project, User $user): bool
    {
        // if user can edit a project then he can see it
        if ($this->canEdit($project, $user)) {
            return true;
        }

        return $project->getContributors()->contains($user);
    }

    private function canEdit(Project $project, User $user): bool
    {
        return $user === $project->getCreatedBy();
    }
}
