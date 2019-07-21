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
        $mongodbDir = $this->container->getParameter('mongodb_dir');
        $now = new \DateTime();
        $date = $now->format("m_d_Y");
        $url = self::DOWNLOAD_URL . "/movie_ids_$date.json.gz";
        $filePath = $mongodbDir . "/movies_$date.json.gz";

        $output->writeln([
            ">>> " . $now->format("d/m/Y"),
            "Starting..."
        ]);

        $downloaded = $this->fileHelper->downloadFileFromUrl($url, $filePath);
        if(!$downloaded){
            $output->writeln("Aucune données à télécharger");
            return;
        }

        $jsonFile = $this->fileHelper->uncompressGzFile($filePath);
        $this->fileHelper->removeFile($filePath);

        $strData = file_get_contents($jsonFile);
        $jsonData = $this->convertDataToJson($strData);

        $this->saveData($jsonData);

        $output->writeln("Success !");
    }

    private function convertDataToJson($data){
        $jsonData = "[" . str_replace("}\n{", "},{", $data) . "]";
        return json_decode($jsonData, true);
    }

    private function saveData($data){
        $db = $this->mongo->selectDatabase("movies");
        $collection = $db->selectCollection("Movie");

        if($collection->count() > 0)
            $collection->remove([]);

        $collection->batchInsert($data);
    }
}