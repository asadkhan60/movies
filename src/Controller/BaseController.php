<?php

namespace App\Controller;

use App\Document\Movie;
use App\Enum\MovieEnum;
use App\Repository\MovieRepository;
use App\Services\MovieHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index()
    {
        $nowPlayingMovies = $this->movieRepository->getNowPlayingMovies(8);
        $popularMovies = $this->movieRepository->getPopularMovies(8);
        $upcomingMovies = $this->movieRepository->getUpcomingMovies(8);
        $topRatedMovies = $this->movieRepository->getTopRatedMovies(8);
        $recentMovies = $this->movieRepository->getRecentMovies(8);

        return $this->render('base/index.html.twig', [
            'nowPlayingMovies' => $nowPlayingMovies,
            'recentMovies' => $recentMovies,
            'upcomingMovies' => $upcomingMovies,
            'popularMovies' => $popularMovies,
            'topRatedMovies' => $topRatedMovies
        ]);
    }
}
