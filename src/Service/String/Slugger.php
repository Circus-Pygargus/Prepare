<?php

namespace App\Service\String;

use Symfony\Component\String\Slugger\SluggerInterface;

class Slugger
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function slug(String $string): string
    {
        return $this->slugger->slug(strtolower($string));
    }
}
