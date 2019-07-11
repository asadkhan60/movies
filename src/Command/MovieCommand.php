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
                    $data = [];

                    $data['id'] = $movie->getId();
                    $data['title'] = $movie->getTitle();
                    $data['adult'] = $movie->getAdult();
                    $data['backdropImage'] = $movie->getBackdropImage()->getFilePath();
                    //$backdrop = $movie->getBackdropImage();
                    //$belongsToCollection = $movie->getBelongsToCollection();
                    $data['budget'] = $movie->getBudget();

                    $genres = [];
                    foreach ($movie->getGenres() as $genre){
                        $genres[] = $genre->getName();
                    }
                    $data['genres'] = $genres;

                    $data['homepage'] = $movie->getHomepage();
                    $data['imdbId'] = $movie->getImdbId();
                    $data['originalTitle'] = $movie->getOriginalTitle();
                    $data['originalLanguage'] = $movie->getOriginalLanguage();
                    $data['overview'] = $movie->getOverview();
                    $data['popularity'] = $movie->getPopularity();
                    //$poster = $movie->getPosterImage();
                    $data['posterPath'] = $movie->getPosterPath();

                    $productionCompanies = [];
                    foreach ($movie->getProductionCompanies() as $productionCompany){
                        $productionCompanies[] = $productionCompany->getName();
                    }
                    $data['productionCompanies'] = $productionCompanies;

                    $productionCountries = [];
                    foreach ($movie->getProductionCountries() as $productionCountry){
                        $productionCountries[] = $productionCountry->getName();
                    }
                    $data['productionCountries'] = $productionCountries;

                    $data['releaseDate'] = $movie->getReleaseDate();
                    $data['revenue'] = $movie->getRevenue();
                    $data['runtime'] = $movie->getRuntime();

                    $spokenLanguages = [];
                    foreach ($movie->getSpokenLanguages() as $spokenLanguage){
                        $spokenLanguages[] = $spokenLanguage->getName();
                    }
                    $data['spokenLanguages'] = $spokenLanguages;

                    $data['status'] = $movie->getStatus();
                    $data['tagline'] = $movie->getTagline();
                    $data['voteAverage'] = $movie->getVoteAverage();
                    $data['voteCount'] = $movie->getVoteCount();

                    $alternativeTitles = [];
                    foreach ($movie->getAlternativeTitles() as $alternativeTitle){
                        $alternativeTitles[] = $alternativeTitle->getTitle();
                    }
                    $data['alternativeTitles'] = $alternativeTitles;

                    //$changes = $movie->getChanges(); // ??
                    //$credits = $movie->getCredits(); // Directeurs, Producteurs ...
                    //$images = $movie->getImages(); // Liste d'images

                    $keywords = [];
                    foreach ($movie->getKeywords() as $keyword){
                        $keywords[] = $keyword->getName();
                    }
                    $data['keywords'] = $keywords;

                    //$lists = $movie->getLists(); // ??
                    //$releases = $movie->getReleases();
                    //$releaseDates = $movie->getReleaseDates();
                    //$similar = $movie->getSimilar(); // films du meme genre
                    //$recommendations = $movie->getRecommendations(); // films recommandés

                    $translations = [];
                    foreach ($movie->getTranslations() as $translation){
                        $translations[] = $translation->getName();
                    }
                    $data['translations'] = $translations;

                    //$reviews = $movie->getReviews();
                    $videos = [];
                    foreach ($movie->getVideos() as $video){
                        $videos[$video->getType()][] = [
                            'id' => $video->getId(),
                            'key' => $video->getKey(),
                            'name' => $video->getName(),
                            'site' => $video->getSite(),
                            'type' => $video->getType(),
                            'url_format' => $video->getUrlFormat()
                        ];
                    }
                    $data['videos'] = $videos;

                    $data['updated'] = new \DateTime();

                    $m = $this->dm->getRepository(Movie::class)->findOneBy([
                        'numberId' => $movie->getId()
                    ]);

                    if($m){
                        $now_date = date_format($data['updated'], 'Y-m-d');
                        $movie_date = date_format($m->getUpdated(), 'Y-m-d');

                        if($now_date > $movie_date){
                            $movie = $this->generateMovie($m, $data);
                            $output->writeln([
                                $m->getNumberId() . " - Le film " . $m->getTitle() . " a été édité",
                                '=============================================='
                            ]);
                        }else{
                            $output->writeln([
                                $m->getNumberId() . " - Le film " . $m->getTitle() . " a déjà été édité",
                                '=============================================='
                            ]);
                        }
                    }else{
                        $newMovie = new Movie();
                        $movie = $this->generateMovie($newMovie, $data);
                        $output->writeln([
                            $movie->getNumberId() . " - Le film " . $movie->getTitle() . " a été créé",
                            "=============================================="
                        ]);
                    }
                }catch (\Exception $e){
                    dump($e->getMessage());
                    die;
                }
            }
        }
    }

    private function generateMovie(Movie $movie, array $data){
        $movie->setNumberId($data['id']);
        $movie->setAdult($data['adult']);
        $movie->setTitle($data['title']);
        $movie->setAlternativeTitles($data['alternativeTitles']);
        $movie->setBackdropImage($data['backdropImage']);
        $movie->setBudget($data['budget']);
        $movie->setGenres($data['genres']);
        $movie->setHomepage($data['homepage']);
        $movie->setImdbId($data['imdbId']);
        $movie->setOriginalTitle($data['originalTitle']);
        $movie->setOriginalLanguage($data['originalLanguage']);
        $movie->setOverview($data['overview']);
        $movie->setPopularity($data['popularity']);
        $movie->setPosterPath($data['posterPath']);
        $movie->setProductionCompanies($data['productionCompanies']);
        $movie->setProductionCountries($data['productionCountries']);
        $movie->setReleaseDate($data['releaseDate']);
        $movie->setRevenue($data['revenue']);
        $movie->setRuntime($data['runtime']);
        $movie->setSpokenLanguages($data['spokenLanguages']);
        $movie->setStatus($data['status']);
        $movie->setTagline($data['tagline']);
        $movie->setVoteAverage($data['voteAverage']);
        $movie->setVoteCount($data['voteCount']);
        $movie->setKeywords($data['keywords']);
        $movie->setTranslations($data['translations']);
        $movie->setVideos($data['videos']);
        $movie->setUpdated($data['updated']);

        $this->dm->persist($movie);
        $this->dm->flush();
        return $movie;
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