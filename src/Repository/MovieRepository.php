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
        return $this->movieApi->getPopularMovies(["page" => $page]);
    }

    public function getUpcomingMovies($limit = 20){
        $page = 1;
        $upcomingMovies = [];
        $nowDate = new \DateTime();

        while (count($upcomingMovies) < $limit){
            $movies = $this->movieApi->getUpcomingMovies(["page" => $page]);
            foreach ($movies as $movie){
                if($nowDate < $movie->getReleaseDate()){
                   $upcomingMovies[] = $movie;
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
        return $this->movieApi->getTopRatedMovies(["page" => $page]);
    }
}