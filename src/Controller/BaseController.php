<?php

namespace App\Controller;

use App\Enum\MovieEnum;
use App\Services\MovieAPI;
use App\Services\MovieHelper;
use App\Services\SerializerData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    private $movieHelper;
    private $serializer;

    public function __construct(MovieHelper $movieHelper, SerializerData $serializer)
    {
        $this->movieHelper = $movieHelper;
        $this->serializer = $serializer;
    }


    /**
     * @Route("/", name="base")
     */
    public function index()
    {
        $nowMovies = $this->movieHelper->getMovies(MovieEnum::NOW_MOVIES);
        $upcomingMovies = $this->movieHelper->getMovies(MovieEnum::UPCOMING_MOVIES);
        $popularMovies = $this->movieHelper->getMovies(MovieEnum::POPULAR_MOVIES);
        $topRatedMovies = $this->movieHelper->getMovies(MovieEnum::TOP_RATED_MOVIES);

/*        $nowMoviesByVote = from($nowMovies)
            ->where(function ($movie){
                return $movie->getVoteCount() > 0;
            })
            ->where(function ($movie){
                return $movie->getReleaseDate() <= new \DateTime();
            })
            ->orderByDescending(function($movie) {
                return $movie->getVoteAverage();
            })->toArrayDeep();

        $nowMovies = from($nowMovies)
            ->where(function ($movie){
                return $movie->getReleaseDate() <= new \DateTime();
            })->toArrayDeep();

        $upcomingMovies = from($upcomingMovies)
            ->where(function ($movie){
                return $movie->getReleaseDate() > new \DateTime();
            })->toArrayDeep();

        $nowMoviesByVote = array_slice($nowMoviesByVote,0,8);
        $nowMovies = array_slice($nowMovies,0,8);
        $upcomingMovies = array_slice($upcomingMovies,0,8);
        $popularMovies = array_slice($popularMovies->toArray(),0,8);
        $topRatedMovies = array_slice($topRatedMovies->toArray(),0,8);*/


        return $this->render('base/index.html.twig', [
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
