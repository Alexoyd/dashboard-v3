<?php

namespace App\Services;

class Ga4ServiceFactory
{
    public function make(string $propertyId): Ga4Service
    {
        return new Ga4Service($propertyId);
    }
}