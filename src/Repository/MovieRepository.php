<?php


namespace App\Repository;

class MovieRepository
{
    public function getNextReleasesMovies($movies){
        return from($movies)
            ->where(function ($movie){
                return $movie->getReleaseDate() > new \DateTime();
            })->toArrayDeep();
    }

    public function getReleasedMovies($movies){
        return from($movies)
            ->where(function ($movie){
                return $movie->getReleaseDate() <= new \DateTime();
            })->toArrayDeep();
    }

    public function getMoviesByVote($movies, string $order = "DESC"){
        $query = from($movies)
            ->where(function ($movie){
                return $movie->getVoteCount() > 0;
            });

        if(strtoupper($order) === "DESC"){
            $movies = $query->orderByDescending(function($movie) {
                return $movie->getVoteAverage();
            })->toArrayDeep();
        }else{
            $movies = $query->orderBy(function($movie) {
                return $movie->getVoteAverage();
            })->toArrayDeep();
        }

        return $movies;
    }

    public function getMoviesByDate($movies, string $order = "DESC"){
        $query = from($movies);

        if(strtoupper($order) === "DESC"){
            $movies = $query->orderByDescending(function($movie) {
                return $movie->getReleaseDate();
            })->toArrayDeep();
        }else{
            $movies = $query->orderBy(function($movie) {
                return $movie->getReleaseDate();
            })->toArrayDeep();
        }

        return $movies;
    }
}