<?php

namespace App\Service\String;

use App\Service\Slug\SlugService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class Slugger
{
    public function __construct(
        private SluggerInterface $slugger,
        private EntityManagerInterface $entityManager,
        private SlugService $slugService,
    ) {
    }

    /**
     * Will add a numbered suffix if built one already exists
     * you can choose the suffix separator if you want, default _
     *
     * @param string $name
     * @param string $className
     * @param string $suffixSeparator
     * @return string
     */
    public function slug(string $strToSlug, string $className, string $suffixSeparator = '_'): string
    {
        $baseSlug = $this->slugger->slug(strtolower($strToSlug));

        $objectRepo = $this->entityManager->getRepository($className);
        $isExistingInDb = $objectRepo->findOneBy(['slug' => $baseSlug]);

        if (!$isExistingInDb) {
            $slug = $baseSlug;
        } else {
            $maxSuffixInDb = $this->slugService->findMaxSuffixValue($baseSlug, $className, $suffixSeparator);
            $suffix = $maxSuffixInDb ? strval($maxSuffixInDb + 1) : '2';
            $slug = $baseSlug . $suffixSeparator. $suffix;
        }

        return $slug;
    }
}
