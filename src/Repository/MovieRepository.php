<?php


namespace App\Repository;

use App\Document\Movie;
use App\Services\MovieAPI;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Symfony\Component\Validator\Constraints\Date;
use Tmdb\Model\Query\Discover\DiscoverMoviesQuery;

class MovieRepository extends DocumentRepository
{
    private $qb;
    private $movieApi;

    public function __construct(DocumentManager $dm, MovieAPI $movieApi)
    {
        $uow = $dm->getUnitOfWork();
        $classMetaData = $dm->getClassMetadata(Movie::class);
        parent::__construct($dm, $uow, $classMetaData);

        $this->qb = $this->dm->createQueryBuilder(Movie::class);
        $this->movieApi = $movieApi;
    }

    public function getPopularMovies($limit = 20){
        $page = 1;
        $popularMovies = [];

        while (count($popularMovies) < $limit){
            $movies = $this->movieApi->getPopularMovies(["page" => $page]);
            foreach ($movies as $movie){
                //$movie = $this->movieApi->getMovie($movie->getId());
                $popularMovies[] = $movie;
                if(count($popularMovies) === $limit) break;
            }
            $page++;
        }

        return $popularMovies;
    }

    public function getUpcomingMovies($limit = 20){
        $page = 1;
        $upcomingMovies = [];
        $nowDate = new \DateTime();

        while (count($upcomingMovies) < $limit){
            $movies = $this->movieApi->getUpcomingMovies(["page" => $page]);
            foreach ($movies as $movie){
                if($nowDate < $movie->getReleaseDate()){
                    //$movie = $this->movieApi->getMovie($movie->getId());
                   $upcomingMovies[] = $movie;
                   if(count($upcomingMovies) === $limit) break;
                }
            }
            $page++;
        }

        usort($upcomingMovies, function ($movieA, $movieB){
           return $movieA->getReleaseDate() > $movieB->getReleaseDate();
        });

        return $upcomingMovies;
    }

    public function getTopRatedMovies($limit = 20){
        $page = 1;
        $topRated = [];

        while (count($topRated) < $limit){
            $movies = $this->movieApi->getTopRatedMovies(["page" => $page]);
            foreach ($movies as $movie){
                //$movie = $this->movieApi->getMovie($movie->getId());
                $topRated[] = $movie;
                if(count($topRated) === $limit) break;
            }
            $page++;
        }

        return $topRated;
    }

    public function getNowPlayingMovies($limit = 20){
        $page = 1;
        $nowPlaying = [];

        while (count($nowPlaying) < $limit){
            $movies = $this->movieApi->getNowPlayingMovies(["page" => $page]);
            foreach ($movies as $movie){
                //$movie = $this->movieApi->getMovie($movie->getId());
                $nowPlaying[] = $movie;
                if(count($nowPlaying) === $limit) break;
            }
            $page++;
        }

        return $nowPlaying;
    }

    public function getRecentMovies($limit = 20){
        $page = 1;
        $recentMovies = [];
        $nowDate = new \DateTime();
        $previousMonthDate = clone $nowDate;
        $previousMonthDate->sub(new \DateInterval('P1M'));

        $discoverQuery = new DiscoverMoviesQuery();
        $discoverQuery->page($page);
        $discoverQuery->primaryReleaseDateLte($nowDate->format("Y-m-d"));
        $discoverQuery->primaryReleaseDateGte($previousMonthDate->format("Y-m-d"));
        $discoverQuery->sortBy("popularity.desc");


        while (count($recentMovies) < $limit){
            $movies = $this->movieApi->getDiscoverMovies($discoverQuery)->toArray();
            foreach ($movies as $movie){
                //$movie = $this->movieApi->getMovie($movie->getId());
                $recentMovies[] = $movie;
                if(count($recentMovies) === $limit) break;
            }
            $discoverQuery->page(++$page);
        }

        return $recentMovies;
    }

    public function getMovie(int $id){
        return $this->movieApi->getMovie($id);
    }

    public function getMovieVideos(int $id){
        return $this->movieApi->getMovieVideos($id);
    }
}