<?php


namespace App\Repository;

class MovieRepository
{
    public function getMoviesByVote($movies){

    }

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
}