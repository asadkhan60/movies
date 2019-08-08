<?php


namespace App\Twig;


use App\Services\Serializer;
use Twig\Extension\RuntimeExtensionInterface;

class SerializerRuntime implements RuntimeExtensionInterface
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

   public function deserialize(string $json, $class, $encoder){
        return $this->serializer->deserialize($json, $class, $encoder);
   }

    public function serialize($data, $encoder){
        return $this->serializer->serialize($data, $encoder);
    }
}