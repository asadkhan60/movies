<?php

namespace App\Controller;

use App\Services\MovieAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tmdb\Model\Movie;

class BaseController extends AbstractController
{
    private $movieAPI;
    private $serializer;

    public function __construct(MovieAPI $movieAPI)
    {
        $this->movieAPI = $movieAPI;
    }


    /**
     * @Route("/", name="base")
     */
    public function index()
    {
        $popularMovies = $this->movieAPI->getPopularMovies()->toArray();
        $popularMovies = array_values($popularMovies);
        $popularMovies = array_slice($popularMovies,0,8);

        return $this->render('base/index.html.twig', [
            'popularMovies' => $popularMovies
        ]);
    }

    public function movieFeatured($movieId){
        $movie = $this->movieAPI->getMovie($movieId);

        return $this->render('includes/movies/movie_featured.html.twig', [
            'movie' => $movie
        ]);
    }
}
