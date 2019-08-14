<?php

namespace App\Controller;

use App\Document\Movie;
use App\Enum\MovieEnum;
use App\Repository\MovieRepository;
use App\Services\MovieHelper;
use App\Services\Redis;
use App\Services\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    private $movieHelper;
    private $movieRepository;
    private $serializer;
    private $redis;

    public function __construct(MovieHelper $movieHelper, MovieRepository $movieRepository, Serializer $serializer, Redis $redis)
    {
        $this->movieHelper = $movieHelper;
        $this->movieRepository = $movieRepository;
        $this->serializer = $serializer;
        $this->redis = $redis;
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

        //$nowPlayingMoviesSerialized = $this->serializer->serialize($nowPlayingMovies, 'json');
        //dump($nowMovies); die;
        //$newNowMovies = $this->serializer->deserialize($nowPlayingMoviesSerialized, \App\Entity\Movie::class . '[]', 'json');

        return $this->render('base/index.html.twig', [
            'nowPlayingMovies' => $nowPlayingMovies,
            'recentMovies' => $recentMovies,
            'upcomingMovies' => $upcomingMovies,
            'popularMovies' => $popularMovies,
            'topRatedMovies' => $topRatedMovies
        ]);
    }

    /**
     * @Route("/movies/details", name="movies-details")
     */
    public function getMoviesDetails(Request $request)
    {
        $datas = [];

        if($request->isXmlHttpRequest()) {
            $movies = $request->request->get('movies');
            foreach ($movies as $movie){
                $movieId = intval($movie['id']);
                $dataMovie = $this->movieRepository->getMovie($movieId);

                $data = [
                    "id" => $dataMovie->getId(),
                    "title" => $dataMovie->getTitle(),
                    "adult" => $dataMovie->getAdult(),
                    "backdropPath" => $dataMovie->getBackdropPath(),
                    "budget" => $dataMovie->getBudget(),
                    "homepage" => $dataMovie->getHomepage(),
                    "originalTitle" => $dataMovie->getOriginalTitle(),
                    "overview" => $dataMovie->getOverview(),
                    "popularity" => $dataMovie->getPopularity(),
                    "posterPath" => $dataMovie->getPosterPath(),
                    "voteAverage" => $dataMovie->getVoteAverage(),
                    "releaseDate" => $dataMovie->getReleaseDate(),
                    "genres" => [],
                    "videos" => []
                    //"videos" => $dataMovie->getVideos(),
                    //"genres" => $dataMovie->getGenres()
                ];

                if($this->redis->exists("movie:".$data["id"])){
                    $data = $this->redis->hGetAll("movie:".$data["id"]);
                    $data['releaseDate'] = new \DateTime($data['releaseDate']);
                    $data['genres'] = $this->redis->hGetAll("movie:" . $data["id"] . ":genres:*");
                }

                $this->redis->hmSet("movie:".$data["id"], $data);
                $this->redis->hmSet("movie:".$data["id"], [
                   "releaseDate" => $data["releaseDate"]->format('Y-m-d H:i:s')
                ]);

                foreach ($dataMovie->getGenres() as $genre){
                    $data["genres"][] = [
                        "id" => $genre->getId(),
                        "name" => $genre->getName()
                    ];
                }

                $dataMovieVideos = $this->movieRepository->getMovieVideos($movieId);
                foreach ($dataMovieVideos as $dataMovieVideo){
                    $data["videos"][] = [
                        "id" => $dataMovieVideo->getId(),
                        "iso_639_1" => $dataMovieVideo->getIso6391(),
                        "key" => $dataMovieVideo->getKey(),
                        "name" => $dataMovieVideo->getName(),
                        "site" => $dataMovieVideo->getSite(),
                        "size" => $dataMovieVideo->getSize(),
                        "type" => $dataMovieVideo->getType(),
                    ];
                }

                $datas[] = $data;
            }
        }

        return new JsonResponse($datas);
    }
}
