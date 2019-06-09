<?php

namespace App\Controller;

use App\Services\MovieAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    private $movieAPI;

    public function __construct(MovieAPI $movieAPI)
    {
        $this->movieAPI = $movieAPI;
    }


    /**
     * @Route("/", name="base")
     */
    public function index()
    {
        $popularMovies = $this->movieAPI->getPopularMovies();

/*        foreach ($popularMovies as $movie){
            dump($movie);
        }
        die;*/

        return $this->render('base/index.html.twig', [
            'popularMovies' => $popularMovies
        ]);
    }
}
