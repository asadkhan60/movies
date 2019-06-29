<?php


namespace App\Services;


use App\Enum\MovieEnum;
use App\Repository\MovieRepository;

class MovieHelper
{
    private $movieApi;
    private $movieRepository;

    public function __construct(MovieAPI $movieApi, MovieRepository $movieRepository)
    {
        $this->movieApi = $movieApi;
        $this->movieRepository = $movieRepository;
    }

    public function getMovies(string $movieEnum = null, int $total = 8){
        $data = $this->getData($movieEnum, $total);
        return $data;
    }

    private function getData(string $movieEnum, int $total): array{
        $data = [];
        $page = 1;

        while(count($data) < $total){
            $movies = $this->getMoviesData($movieEnum, ['page' => $page]);
            foreach ($movies as $movie){
                if(count($data) == $total) break;
                $movieDetail = $this->movieApi->getMovie($movie->getId());
                $data[] = $movieDetail;
            }
            $page++;
        }

        return $data;
    }

    private function getMoviesData(string $movieEnum, array $params){
        switch ($movieEnum){
            case MovieEnum::NOW_MOVIES:
                $movies = $this->movieApi->getNowPlayingMovies($params);
                $movies = $this->movieRepository->getReleasedMovies($movies);
                return $movies;
                break;
            case MovieEnum::POPULAR_MOVIES:
                return $this->movieApi->getPopularMovies($params);
                break;
            case MovieEnum::UPCOMING_MOVIES:
                $movies = $this->movieApi->getUpcomingMovies($params);
                $movies = $this->movieRepository->getNextReleasesMovies($movies);
                return $movies;
                break;
            case MovieEnum::TOP_RATED_MOVIES:
                return $this->movieApi->getTopRatedMovies($params);
                break;
            default:
                break;
        }
    }
}