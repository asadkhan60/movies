<?php


namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class RandomArrayDataExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('random_array_data', [RandomArrayDataRuntime::class, 'random_array_data']),
        ];
    }
}