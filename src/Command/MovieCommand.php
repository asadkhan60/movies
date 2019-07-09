<?php


namespace App\Command;

use App\Document\Movie;
use App\Enum\MovieEnum;
use App\Services\MovieAPI;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MovieCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:update-movies';

    private $movieApi;
    private $dm;

    public function __construct(MovieAPI $movieApi, DocumentManager $dm)
    {
        parent::__construct();
        $this->movieApi = $movieApi;
        $this->dm = $dm;
    }

    protected function configure()
    {
        $this
            ->setDescription('Update movies on mongodb.')
            ->setHelp('This command allows you to update movies from The Movie DB API to mongo database.')
            ->addArgument('type', InputArgument::OPTIONAL, 'now | upcoming | popular | toprated');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('type');

        switch ($type){
            case 'now':
                $this->loadNowMovies($output);
                break;
            case 'upcoming':
                $this->loadUpcomingMovies($output);
                break;
            case 'popular':
                $this->loadPopularMovies($output);
                break;
            case 'toprated':
                $this->loadTopRatedMovies($output);
                break;
            default:
                $this->loadAllMovies($output);
                break;
        }
    }

    private function getData(string $type, array $params){
        $data = [];

        switch ($type){
            case MovieEnum::NOW_MOVIES:
                $data = $this->movieApi->getNowPlayingMovies($params);
                break;
            case MovieEnum::UPCOMING_MOVIES:
                $data = $this->movieApi->getUpcomingMovies($params);
                break;
            case MovieEnum::POPULAR_MOVIES:
                $data = $this->movieApi->getPopularMovies($params);
                break;
            case MovieEnum::TOP_RATED_MOVIES:
                $data = $this->movieApi->getTopRatedMovies($params);
                break;
            default:
                break;
        }

        return $data;
    }

    private function generateData(string $type, int $totalPages, OutputInterface $output){
        $movies = [];
        for ($page = 1; $page<=$totalPages; $page++){
            if($page > 1){
                $movies = $this->getData($type, ['page' => $page]);
            }

            foreach ($movies as $movie){
                try{
                    $movie = $this->movieApi->getMovie($movie->getId());
                    $m = $this->dm->getRepository(Movie::class)->find($movie->getId());

                    $id = $movie->getId();
                    $title = $movie->getTitle();
                    $adult = $movie->getAdult();
                    $backdropPath = $movie->getBackdropImage()->getFilePath();
                    //$backdrop = $movie->getBackdropImage();
                    //$belongsToCollection = $movie->getBelongsToCollection();
                    $budget = $movie->getBudget();

                    $genres = [];
                    foreach ($movie->getGenres() as $genre){
                        $genres[] = $genre->getName();
                    }

                    $homepage = $movie->getHomepage();
                    $imdbId = $movie->getImdbId();
                    $originalTitle = $movie->getOriginalTitle();
                    $originalLanguage = $movie->getOriginalLanguage();
                    $overview = $movie->getOverview();
                    $popularity = $movie->getPopularity();
                    //$poster = $movie->getPosterImage();
                    $posterPath = $movie->getPosterPath();

                    $productionCompanies = [];
                    foreach ($movie->getProductionCompanies() as $productionCompany){
                        $productionCompanies[] = $productionCompany->getName();
                    }

                    $productionCountries = [];
                    foreach ($movie->getProductionCountries() as $productionCountry){
                        $productionCountries[] = $productionCountry->getName();
                    }

                    $releaseDate = $movie->getReleaseDate();
                    $revenue = $movie->getRevenue();
                    $runtime = $movie->getRuntime();

                    $spokenLanguages = [];
                    foreach ($movie->getSpokenLanguages() as $spokenLanguage){
                        $spokenLanguages[] = $spokenLanguage->getName();
                    }

                    $status = $movie->getStatus();
                    $tagline = $movie->getTagline();
                    $voteAverage = $movie->getVoteAverage();
                    $voteCount = $movie->getVoteCount();

                    $alternativeTitles = [];
                    foreach ($movie->getAlternativeTitles() as $alternativeTitle){
                        $alternativeTitles[] = $alternativeTitle->getTitle();
                    }

                    //$changes = $movie->getChanges(); // ??
                    //$credits = $movie->getCredits(); // Directeurs, Producteurs ...
                    //$images = $movie->getImages(); // Liste d'images

                    $keywords = [];
                    foreach ($movie->getKeywords() as $keyword){
                        $keywords[] = $keyword->getName();
                    }


                    //$lists = $movie->getLists(); // ??
                    //$releases = $movie->getReleases();
                    //$releaseDates = $movie->getReleaseDates();
                    //$similar = $movie->getSimilar(); // films du meme genre
                    //$recommendations = $movie->getRecommendations(); // films recommandés

                    $translations = [];
                    foreach ($movie->getTranslations() as $translation){
                        $translations[] = $translation->getName();
                    }


                    //$reviews = $movie->getReviews();
                    $videos = $movie->getVideos(); // Créer entité et faire une relation

                    dump($videos);
                    die;

                    if($m){
                        continue;
                    }else{
                        $newMovie = new Movie();
                        $newMovie->setId($m->getId());
                        $newMovie->setTitle($m->getTitle());
                        $newMovie->setAdult($m->getAdult());
                    }
                }catch (\Exception $e){

                }
            }
        }
    }

    private function loadNowMovies(OutputInterface $output){
        $nowMovies = $this->movieApi->getNowPlayingMovies();
        $totalPages = $nowMovies->getTotalPages();

        $this->generateData(MovieEnum::NOW_MOVIES, $totalPages, $output);
    }

    private function loadUpcomingMovies(OutputInterface $output){
        $upcomingMovies = $this->movieApi->getUpcomingMovies();
        $totalPages = $upcomingMovies->getTotalPages();

        $this->generateData(MovieEnum::UPCOMING_MOVIES, $totalPages, $output);
    }

    private function loadPopularMovies(OutputInterface $output){
        $popularMovies = $this->movieApi->getPopularMovies();
        $totalPages = $popularMovies->getTotalPages();

        $this->generateData(MovieEnum::POPULAR_MOVIES, $totalPages, $output);
    }

    private function loadTopRatedMovies(OutputInterface $output){
        $topRatedMovies = $this->movieApi->getTopRatedMovies();
        $totalPages = $topRatedMovies->getTotalPages();

        $this->generateData(MovieEnum::TOP_RATED_MOVIES, $totalPages, $output);
    }

    private function loadAllMovies(OutputInterface $output){
        $this->loadNowMovies($output);
        $this->loadUpcomingMovies($output);
        $this->loadPopularMovies($output);
        $this->loadTopRatedMovies($output);
    }
}