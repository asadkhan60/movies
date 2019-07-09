<?php

namespace App\Controller;

use App\Document\Movie;
use App\Enum\MovieEnum;
use App\Repository\MovieRepository;
use App\Services\MovieHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager;

class BaseController extends AbstractController
{
    private $movieHelper;
    private $movieRepository;

    public function __construct(MovieHelper $movieHelper, MovieRepository $movieRepository)
    {
        $this->movieHelper = $movieHelper;
        $this->movieRepository = $movieRepository;
    }


    /**
     * @Route("/", name="base")
     */
    public function index(DocumentManager $dm)
    {
/*        $nowPlayingMovies = $this->movieHelper->getMovies(MovieEnum::NOW_MOVIES);
//        $nowPlayingMovies = $this->movieRepository->getMoviesByVote($nowPlayingMovies, "DESC");

        $recentMovies = $this->movieHelper->getMovies(MovieEnum::RECENT_MOVIES);
        $upcomingMovies = $this->movieHelper->getMovies(MovieEnum::UPCOMING_MOVIES);
        $popularMovies = $this->movieHelper->getMovies(MovieEnum::POPULAR_MOVIES);
        $topRatedMovies = $this->movieHelper->getMovies(MovieEnum::TOP_RATED_MOVIES);*/

/*        $movie = new Movie();
        $movie->setTitle("Test");
        $dm->persist($movie);
        $dm->flush();*/

        $nowPlayingMovies = [];
        $recentMovies = [];
        $upcomingMovies = [];
        $popularMovies = [];
        $topRatedMovies = [];

        return $this->render('base/index.html.twig', [
            'nowPlayingMovies' => $nowPlayingMovies,
            'recentMovies' => $recentMovies,
            'upcomingMovies' => $upcomingMovies,
            'popularMovies' => $popularMovies,
            'topRatedMovies' => $topRatedMovies
        ]);
    }
}
