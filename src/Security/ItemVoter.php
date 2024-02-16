<?php

namespace App\Security;

use App\Entity\Item;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ItemVoter extends Voter
{
    const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Item) {
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

        $item = $subject;

        return match($attribute) {
            self::EDIT => $this->canEdit($item, $currentUser),
            default => throw new \LogicException('This code should not be reached !!'),
        };
    }

    private function canEdit(Item $item, User $user): bool
    {
        return $user === $item->getCreatedBy() || $user === $item->getProject()->getCreatedBy();
    }
}
