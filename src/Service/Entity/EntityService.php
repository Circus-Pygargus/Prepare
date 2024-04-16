<?php

namespace App\Service\Entity;

use App\Service\String\SluggerService;
use Symfony\Bundle\SecurityBundle\Security;

class EntityService
{
    public function __construct(
        private Security $security,
        private SluggerService $slugger,
    ) {
    }

    /**
     * Handles properties which are not in forms
     *
     * @param object $updatedObject
     * @param object $originalObject
     * @param array $params, needed keys :
     *      'slugSource' => the property used to build slug
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
