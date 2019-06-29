<?php


namespace App\Services;


use App\Enum\MovieEnum;

class MovieHelper
{
    private $movieApi;

    public function __construct(MovieAPI $movieApi)
    {
        $this->movieApi = $movieApi;
    }

    public function getMovies(string $movieEnum = null, int $total = 8){
        $data = [];
        switch ($movieEnum){
            case MovieEnum::NOW_MOVIES:
                $data = $this->getNowMoviesData($total);
                break;
            case MovieEnum::POPULAR_MOVIES:
                $data = $this->getPopularMoviesData($total);
                break;
            case MovieEnum::UPCOMING_MOVIES:
                $data = $this->getUpcomingMoviesData($total);
                break;
            case MovieEnum::TOP_RATED_MOVIES:
                $data = $this->getTopRatedMoviesData($total);
                break;
            default:
                break;
        }

        return $data;
    }

    private function getNowMoviesData(int $total): array {
        $data = [];
        $page = 1;

        while(count($data) < $total){
            $nowMovies = $this->movieApi->getNowPlayingMovies(['page' => $page]);
            foreach ($nowMovies as $movie){
                if(count($data) == $total) break;
                $movieDetail = $this->movieApi->getMovie($movie->getId());
                $data[] = $movieDetail;
            }
            $page++;
        }

        return $data;
    }

    private function getPopularMoviesData(int $total): array {
        $data = [];
        $page = 1;

        while(count($data) < $total){
            $popularMovies = $this->movieApi->getPopularMovies(['page' => $page]);
            foreach ($popularMovies as $movie){
                if(count($data) == $total) break;
                $movieDetail = $this->movieApi->getMovie($movie->getId());
                $data[] = $movieDetail;
            }
            $page++;
        }

        return $data;
    }

    private function getUpcomingMoviesData(int $total): array {
        $data = [];
        $page = 1;

        while(count($data) < $total){
            $upcomingMovies = $this->movieApi->getUpcomingMovies(['page' => $page]);
            foreach ($upcomingMovies as $movie){
                if(count($data) == $total) break;
                $movieDetail = $this->movieApi->getMovie($movie->getId());
                $data[] = $movieDetail;
            }
            $page++;
        }

        return $data;
    }

    private function getTopRatedMoviesData(int $total): array {
        $data = [];
        $page = 1;

        while(count($data) < $total){
            $topRatedMovies = $this->movieApi->getTopRatedMovies(['page' => $page]);
            foreach ($topRatedMovies as $movie){
                if(count($data) == $total) break;
                $movieDetail = $this->movieApi->getMovie($movie->getId());
                $data[] = $movieDetail;
            }
            $page++;
        }

        return $data;
    }
}