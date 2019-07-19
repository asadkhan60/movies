<?php


namespace App\Services;


use Symfony\Component\Filesystem\Filesystem;

class FileHelper
{
    private $fileSystem;

    public function __construct()
    {
        $this->fileSystem = new Filesystem();
    }

    public function downloadFileFromUrl(string $url, string $filePath){
        try{
            file_put_contents($filePath, fopen($url, 'r'));
            return true;
        }catch (\Exception $e){
            dump($e);
            return false;
        }
    }

    public function uncompressGzFile(string $filePath){
        $buffer_size = 4096;
        $out_file_name = str_replace('.gz', '', $filePath);

        $file = gzopen($filePath, 'rb');
        $out_file = fopen($out_file_name, 'wb');

        while(!gzeof($file)) {
            fwrite($out_file, gzread($file, $buffer_size));
        }

        fclose($out_file);
        gzclose($file);

        return $out_file_name;
    }

    public function removeFile(string $path){
        $this->fileSystem->remove($path);
    }
}