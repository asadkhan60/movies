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
        $nowMovies = $this->movieAPI->getNowPlayingMovies();

        $movieIds = $this->getRandomMovie($nowMovies->toArray(), 8, true);

        return $this->render('base/index.html.twig', [
            'movieIds' => $movieIds
        ]);
    }


    private function getRandomMovie(array $movies = [], int $number = 1, bool $movieIds = false){
        if(!$movies || count($movies) === 0)
            return $movies;

        if(count($movies) < $number){
            $number = count($movies);
        }

        $movies = array_values($movies);
        $randomMovieIndexes = array_rand($movies, $number);
        $randomMovies = [];

        foreach ($randomMovieIndexes as $index){
            $randomMovies[] = ($movieIds) ? $movies[$index]->getId() : $movies[$index];
        }

        return $randomMovies;
    }

    public function movieFeatured($movieId){
        $movie = $this->movieAPI->getMovie($movieId);

        return $this->render('includes/movies/movie_featured.html.twig', [
            'movie' => $movie
        ]);
    }
}
