<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ExpEntesnsionExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('filter_name', [$this, 'doSomething2']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
            new TwigFunction('function_name2', [$this, 'doSomething2']),
        ];
    }

    public function doSomething()
    {
        return "toto";
    }

    public function doSomething2($value)
    {
        return substr($value, 0, 8)." [...]";
    }
}
