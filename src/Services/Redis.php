<?php


namespace App\Services;


use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class Redis
{
    private $client;

    public function __construct(ParameterBagInterface $params)
    {
        $this->client = RedisAdapter::createConnection(
            $params->get('redis_client')
        );
    }

    public function hmSet(string $key, array $hashKeys){
        return $this->client->hMSet($key, $hashKeys);
    }

    public function hGetAll(string $key){
        return $this->client->hGetAll($key);
    }

    public function exists(string $key){
        return $this->client->exists($key);
    }
}