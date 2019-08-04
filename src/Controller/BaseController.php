<?php

namespace App\Controller;

use App\Document\Movie;
use App\Enum\MovieEnum;
use App\Repository\MovieRepository;
use App\Services\MovieHelper;
use App\Services\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    private $movieHelper;
    private $movieRepository;
    private $serializer;

    public function __construct(MovieHelper $movieHelper, MovieRepository $movieRepository, Serializer $serializer)
    {
        $this->movieHelper = $movieHelper;
        $this->movieRepository = $movieRepository;
        $this->serializer = $serializer;
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

        $nowPlayingMoviesSerialized = $this->serializer->serialize($nowPlayingMovies, 'json');
//        dump($nowMovies); die;
        $newNowMovies = $this->serializer->deserialize($nowPlayingMoviesSerialized, \App\Entity\Movie::class . '[]', 'json');

        return $this->render('base/index.html.twig', [
            'nowPlayingMovies' => $nowPlayingMovies,
            'recentMovies' => $recentMovies,
            'upcomingMovies' => $upcomingMovies,
            'popularMovies' => $popularMovies,
            'topRatedMovies' => $topRatedMovies
        ]);
    }
}
