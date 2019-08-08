<?php


namespace App\Controller;


use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * @Route("/movies/{movieId}", name="movie_details")
     * @param int $movieId
     * @return Response
     */
    public function movieDetail(int $movieId)
    {
        $movie = $this->movieRepository->getMovie($movieId);

        return $this->render('movies/movie_detail.html.twig', [
            'movie' => $movie,
        ]);
    }
}