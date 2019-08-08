<?php


namespace App\Services;


use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as ObjectSerializer;

class Serializer
{
    private $serializer;

    public function __construct()
    {
        $dateCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
        };

        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'releaseDate' => $dateCallback,
            ],
        ];

        $encoders = [
            new XmlEncoder(),
            new JsonEncoder()
        ];
        $normalizers = [
            new ObjectNormalizer(),
            new GetSetMethodNormalizer(null, null, null, null, null, $defaultContext),
            new ArrayDenormalizer()
        ];
        $this->serializer = new ObjectSerializer($normalizers, $encoders);
    }

    public function serialize($object, string $encoder){
        return $this->serializer->serialize($object, $encoder);
    }

    public function deserialize($data, $class, $encoder, $options=[]){
        return $this->serializer->deserialize($data, $class, $encoder, $options);
    }


}