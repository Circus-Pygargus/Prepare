<?php

namespace App\Service\Entity;

use Symfony\Bundle\SecurityBundle\Security;

class EntityService
{
    public function __construct(
        private Security $security,
    ) {
    }

    /**
     * Handles properties which are not in forms
     *
     * @param object $object
     * @return object
     */
    public function handleCommonProperties(object $object): object
    {
        if ($object->getId() === null) {
            $user = $this->security->getUser();
            $object->setCreatedBy($user);
        }

        return $object;
    }
}
