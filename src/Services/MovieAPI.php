<?php


namespace App\Services;


use Tmdb\Client;
use Tmdb\Model\Query\Discover\DiscoverMoviesQuery;
use Tmdb\Repository\DiscoverRepository;
use Tmdb\Repository\MovieRepository;

class MovieAPI
{
    private $client;
    private $movieRepository;
    private $discoverRepository;

    public function __construct($client)
    {
        $this->client = $client;
        $this->discoverRepository = new DiscoverRepository($client);
        $this->movieRepository = new MovieRepository($client);
    }

    public function getLatestMovies($params = []){
        return $this->movieRepository->getLatest($params);
    }

    public function getPopularMovies($params = []){
        return $this->movieRepository->getPopular($params);
    }

    public function getNowPlayingMovies($params = []){
        return $this->movieRepository->getNowPlaying($params);
    }

    public function getUpcomingMovies($params = []){
        return $this->movieRepository->getUpcoming($params);
    }

    public function getTopRatedMovies($params = []){
        return $this->movieRepository->getTopRated($params);
    }

    public function getMovieVideos($id, $params = [], $headers = []){
        if(!$id)
            return [];

        return $this->movieRepository->getVideos($id, $params, $headers);
    }

    public function getMovie($id, $params = [], $headers = []){
        if(!$id) return null;

        return $this->movieRepository->load($id, $params, $headers);
    }

    public function getAllMovies(DiscoverMoviesQuery $discoverMoviesQuery){
        return $this->discoverRepository->discoverMovies($discoverMoviesQuery);
    }
}