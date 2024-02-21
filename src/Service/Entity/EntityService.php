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
    public function handleCommonProperties(object $updatedObject, object $originalObject, array $params): object
    {
        if ($updatedObject->getId() === null) {
            $updatedObject = $this->handleSlug($updatedObject, $originalObject, $params);

            $user = $this->security->getUser();
            $updatedObject->setCreatedBy($user);
        }

        return $updatedObject;
    }

    private function handleSlug(object $updatedObject, object $originalObject, array $params): object
    {
        if ($this->slugger->isSlugNeeded($originalObject, $originalObject, $params['slugSource'])) {
            $objectClassName = get_class($updatedObject);
            $slug = $this->slugger->slug($updatedObject->getName(), $objectClassName, '_');
            $updatedObject->setSlug($slug);
        }

        return $updatedObject;
    }
}
