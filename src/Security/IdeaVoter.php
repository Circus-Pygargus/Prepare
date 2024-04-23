<?php

namespace App\Security;

use App\Entity\Idea;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class IdeaVoter extends Voter
{
    const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Idea) {
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

        $idea = $subject;

        return match($attribute) {
            self::EDIT => $this->canEdit($idea, $currentUser),
            default => throw new \LogicException('This code should not be reached !!'),
        };
    }

    private function canEdit(Idea $idea, User $user): bool
    {
        return $user === $idea->getCreatedBy() || $user === $idea->getProject()->getCreatedBy();
    }
}
