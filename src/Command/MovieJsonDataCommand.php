<?php


namespace App\Command;


use Symfony\Component\Console\Command\Command;

class MovieJsonDataCommand extends Command
{
    protected static $defaultName = 'movie:generate-files';

    protected function configure()
    {
        $this
            ->setDescription('Generate json files from movies API')
            ->setHelp('This command allows you to create json files 
            (now movies, popular movies, upcoming movies and top rated movies) which content all movies data')
        ;
    }
}