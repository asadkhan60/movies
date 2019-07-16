<?php


namespace App\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class MovieImportCommand extends Command
{
    protected static $defaultName = 'app:import-movies';
    private const DOWNLOAD_URL = "http://files.tmdb.org/p/exports";

    private $container;

    public function __construct(string $name = null, ContainerInterface $container)
    {
        parent::__construct($name);
        $this->container = $container;
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
        $this->downloadFile();
    }

    private function downloadFile($typeFile = "json"){
        $nowDate = new \DateTime();
        $dateFormat = $nowDate->format('m_d_Y');

        $mongoDir = $this->container->getParameter('data_dir') . "/mongodb";


        $file = "$mongoDir/movies_$dateFormat.$typeFile.gz";

        file_put_contents($file, fopen(self::DOWNLOAD_URL . "/movie_ids_$dateFormat.$typeFile.gz", 'r'));
        $this->unzipFile($file);

        $filesystem = new Filesystem();
        $filesystem->remove($file);

        //$this->container->get('devmachine_mongoimport')->import($file, 'movies');
    }


    private function unzipFile($file){
        $buffer_size = 4096; // read 4kb at a time
        $out_file_name = str_replace('.gz', '', $file);

        // Open our files (in binary mode)
        $file = gzopen($file, 'rb');
        $out_file = fopen($out_file_name, 'wb');

        // Keep repeating until the end of the input file
        while(!gzeof($file)) {
            fwrite($out_file, gzread($file, $buffer_size));
        }

        // Files are done, close files
        fclose($out_file);
        gzclose($file);
    }

}