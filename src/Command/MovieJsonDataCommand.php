<?php


namespace App\Command;


use App\Services\MovieAPI;
use App\Services\SerializerData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;

class MovieJsonDataCommand extends Command
{
    protected static $defaultName = 'movie:generate-files';

    private $movieApi;
    private $serializer;
    private $fileSystem;
    private $dataUploadDir;

    public function __construct($dataDir, MovieAPI $movieAPI, SerializerData $serializer)
    {
        $this->movieApi = $movieAPI;
        $this->serializer = $serializer;
        $this->fileSystem = new Filesystem();
        $this->dataUploadDir = $dataDir;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate json files from movies API')
            ->setHelp('This command allows you to create json files 
             for now movies, popular movies, upcoming movies and top rated movies')
            ->addArgument('now', InputArgument::OPTIONAL, 'Now movies')
            ->addArgument('popular', InputArgument::OPTIONAL, 'Popular movies')
            ->addArgument('upcoming', InputArgument::OPTIONAL, 'Upcoming movies')
            ->addArgument('toprated', InputArgument::OPTIONAL, 'Top rated movies')
        ;
    }


    private function generateData($movies){
        $data = [];

        foreach ($movies as $movie){
            $id = $movie->getId();
            $m = $this->movieApi->getMovie($id);
            $data[] = $m;
        }

        return $data;
    }


    private function nowMoviesData(){
        $page = 1;
        $nowMovies = $this->movieApi->getNowPlayingMovies(['page' => $page]);
        $totalPages = $nowMovies->getTotalPages();

        $data = $this->generateData($nowMovies);

        for($page=$page+1; $page<=2; $page++){
            $nowMovies = $this->movieApi->getNowPlayingMovies(['page' => $page]);
            $newData = $this->generateData($nowMovies);
            $data = array_merge($data, $newData);
        }

        return $data;


/*        $jsonData = $this->serializer->serialize($nowMovies, 'json');

        $data = file_get_contents($this->dataUploadDir . '/now-movies.json');
        $data = $this->serializer->deserialize($data, 'Tmdb\Model\Movie[]', 'json');
        var_dump($data);die;*/

  /*      try {
            $this->fileSystem->dumpFile($this->dataUploadDir . '/now-movies.json', $jsonData);
        }
        catch(IOException $e) {
        }*/
    }

    private function popularMoviesData(){
        $page = 1;
        $popularMovies = $this->movieApi->getPopularMovies(['page' => $page]);
        $totalPages = $popularMovies->getTotalPages();

        $data = $this->generateData($popularMovies);

        for($page=$page+1; $page<=$totalPages; $page++){
            $popularMovies = $this->movieApi->getPopularMovies(['page' => $page]);
            $newData = $this->generateData($popularMovies);
            $data = array_merge($data, $newData);
        }

        return $data;
    }

    private function upcomingMoviesData(){
        $page = 1;
        $upcomingMovies = $this->movieApi->getUpcomingMovies(['page' => $page]);
        $totalPages = $upcomingMovies->getTotalPages();

        $data = $this->generateData($upcomingMovies);

        for($page=$page+1; $page<=$totalPages; $page++){
            $upcomingMovies = $this->movieApi->getUpcomingMovies(['page' => $page]);
            $newData = $this->generateData($upcomingMovies);
            $data = array_merge($data, $newData);
        }

        return $data;
    }

    private function topRatedMoviesData(){
        $page = 1;
        $topRatedMovies = $this->movieApi->getTopRatedMovies(['page' => $page]);
        $totalPages = $topRatedMovies->getTotalPages();

        $data = $this->generateData($topRatedMovies);

        for($page=$page+1; $page<=$totalPages; $page++){
            $topRatedMovies = $this->movieApi->getTopRatedMovies(['page' => $page]);
            $newData = $this->generateData($topRatedMovies);
            $data = array_merge($data, $newData);
        }

        return $data;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = [];

        $data['nowMovies'] = $this->nowMoviesData();

//        $data['popularMovies'] = $this->popularMoviesData();
//        $data['upcomingMovies'] = $this->upcomingMoviesData();
//        $data['topRatedMovies'] = $this->topRatedMoviesData();

        $jsonData = $this->serializer->serialize($data, 'json');

        $jsonToObject = $this->serializer->deserialize($jsonData,'Tmdb\Model\Movie[]','json');

        $output->writeln('User successfully generated!');
    }
}