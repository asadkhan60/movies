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
        $upcomingMovies = $this->movieAPI->getUpcomingMovies();
        $popularMovies = $this->movieAPI->getPopularMovies();
        $topRatedMovies = $this->movieAPI->getTopRatedMovies();


        $nowMoviesByVote = from($nowMovies)
            ->where(function ($movie){
                return $movie->getVoteCount() > 0;
            })
            ->orderByDescending(function($movie) {
                return $movie->getVoteAverage();
            })->toArrayDeep();

        $nowMoviesByVote = array_slice($nowMoviesByVote,0,8);
        $nowMovies = array_slice($nowMovies->toArray(),0,8);
        $upcomingMovies = array_slice($upcomingMovies->toArray(),0,8);
        $popularMovies = array_slice($popularMovies->toArray(),0,8);
        $topRatedMovies = array_slice($topRatedMovies->toArray(),0,8);

        return $this->render('base/index.html.twig', [
            'nowMoviesByVote' => $nowMoviesByVote,
            'nowMovies' => $nowMovies,
            'upcomingMovies' => $upcomingMovies,
            'popularMovies' => $popularMovies,
            'topRatedMovies' => $topRatedMovies
        ]);
    }


/*    private function getRandomMovie(array $movies = [], int $number = 1, bool $movieIds = false){
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
    }*/

    public function movieFeatured($movieId){
        $movie = $this->movieAPI->getMovie($movieId);
        $videos = $movie->getVideos();


        $trailers = from($videos)
            ->where(function($m){
                return $m->getType() === "Trailer";
            })->toArrayDeep();

        $trailer = $trailers[array_key_first($trailers)];

        return $this->render('includes/movies/movie_featured.html.twig', [
            'movie' => $movie,
            'trailer' => $trailer
        ]);
    }
}
