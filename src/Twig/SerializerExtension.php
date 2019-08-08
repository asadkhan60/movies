<?php


namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SerializerExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('deserialize', [SerializerRuntime::class, 'deserialize']),
            new TwigFilter('serialize', [SerializerRuntime::class, 'serialize'])
        ];
    }
}