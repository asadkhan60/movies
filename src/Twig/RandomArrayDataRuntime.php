<?php


namespace App\Twig;


use Twig\Extension\RuntimeExtensionInterface;

class RandomArrayDataRuntime implements RuntimeExtensionInterface
{
    public function random_array_data($data, int $max, bool $doublon = false){
        $randomData = [];

        if(gettype($data) == "object"){
            $data = $data->toArray();
        }

        $data = array_values($data);

        while (count($randomData) < $max){
            $key = rand(0, count($data) - 1);

            if(!$doublon && in_array($data[$key], $randomData)){
                continue;
            }
            $randomData[] = $data[$key];
        }

        return $randomData;
    }
}