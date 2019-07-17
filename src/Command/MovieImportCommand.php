<?php


namespace App\Command;


use App\Services\FileHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

ini_set("memory_limit", -1);

class MovieImportCommand extends Command
{
    protected static $defaultName = 'app:import-movies';
    private const DOWNLOAD_URL = "http://files.tmdb.org/p/exports";

    private $fileHelper;
    private $container;
    private $mongo;

    public function __construct(FileHelper $fileHelper, ContainerInterface $container)
    {
        parent::__construct("movieimportcommand");
        $this->fileHelper = $fileHelper;
        $this->container = $container;
        $this->mongo = $this->container->get('doctrine_mongodb.odm.default_connection');
    }

    protected function configure()
    {
        $this
            ->setDescription("Download tomorrow's movies and import on mongodb")
            ->setHelp('This command allows you to add movies from json file')
            ->addArgument('typefile', InputArgument::OPTIONAL, 'file json, xml or csv')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $mongo = $this->container->get('doctrine_mongodb.odm.default_connection');
//        $db = $mongo->selectDatabase("movies");
//        $collection = $db->selectCollection("Movie");
//
//        $movies = [
//            0 => [
//                "test" => "yo"
//            ],
//            1 => [
//                "testtwo" => "yoyo"
//            ]
//        ];
//
//        $data =
//
//        $collection->batchInsert($movies);
//
//        dump($collection);
//        die;

        $mongodbDir = $this->container->getParameter('mongodb_dir');
        //$date = (new \DateTime())->format("m_d_Y");
        $url = self::DOWNLOAD_URL . "/movie_ids_07_16_2019.json.gz";
        $filePath = $mongodbDir . "/movies.json.gz";

        $this->fileHelper->downloadFileFromUrl($url, $filePath);
        $jsonFile = $this->fileHelper->uncompressGzFile($filePath);

        $this->fileHelper->removeFile($filePath);

        $strData = file_get_contents($jsonFile);
        $str = str_replace("\n", ",", $strData);
        $str = "[" . $str . "]";


        if( ( $pos = strrpos( $str , "," ) ) !== false ) {
            $search_length  = strlen( "," );
            $str    = substr_replace( $str , "" , $pos , $search_length );
        }

        $data = json_decode($str,true);

        $db = $this->mongo->selectDatabase("movies");
        $collection = $db->selectCollection("Movie");
        $collection->batchInsert($data);

        dump($data);
        die;
    }
}