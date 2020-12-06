<?php

namespace App\Twig;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CategorieExtension extends AbstractExtension
{
    private  $repo;

    public function __construct(CategorieRepository  $categorieRepository)
    {
        $this->repo = $categorieRepository;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('categorie', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('categorie', [$this, 'categorie']),
        ];
    }

    public function doSomething($value)
    {
        return "International";
    }

    function categorie (){
        $categories = $this->repo->findAll();
        return $categories;
    }
}
