<?php


namespace App\Command;


use App\Services\MovieAPI;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class MovieJsonDataCommand extends Command
{
    protected static $defaultName = 'movie:generate-files';

    private $movieApi;

    public function __construct(MovieAPI $movieAPI)
    {
        $this->movieApi = $movieAPI;

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

        var_dump($nowMovies);
        die;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->nowMoviesData();

        $output->writeln('User successfully generated!');
    }
}