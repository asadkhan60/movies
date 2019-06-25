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


    private function nowMoviesData(){
        $page = 1;
        $nowMovies = $this->movieApi->getNowPlayingMovies(['page' => $page]);

        $jsonData = $this->serializer->serialize($nowMovies, 'json');

        $data = file_get_contents($this->dataUploadDir . '/now-movies.json');
        $data = $this->serializer->deserialize($data, 'Tmdb\Model\Movie[]', 'json');
        var_dump($data);die;

  /*      try {
            $this->fileSystem->dumpFile($this->dataUploadDir . '/now-movies.json', $jsonData);
        }
        catch(IOException $e) {
        }*/
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->nowMoviesData();

        $output->writeln('User successfully generated!');
    }
}