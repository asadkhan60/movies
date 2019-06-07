<?php


namespace App\Services;


use Tmdb\Repository\MovieRepository;

class MovieAPI
{
    private $client;
    private $repository;

    public function __construct($client)
    {
        $this->client = $client;
        $this->repository = new MovieRepository($client);
    }

    public function getLatestMovies($params = []){
        return $this->repository->getLatest($params);
    }

    public function getPopularMovies($params = []){
        return $this->repository->getPopular($params);
    }

    public function getNowPlayingMovies($params = []){
        return $this->repository->getNowPlaying($params);
    }

    public function getUpcomingMovies($params = []){
        return $this->repository->getUpcoming($params);
    }

    public function getTopRatedMovies($params = []){
        return $this->repository->getTopRated($params);
    }

    public function getMovieVideos($id, $params = [], $headers = []){
        if(!$id)
            return [];

        return $this->repository->getVideos($id, $params, $headers);
    }
}