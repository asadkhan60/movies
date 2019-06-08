<?php


namespace App\Tests\Controller;


use App\Services\MovieAPI;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseControllerTest extends WebTestCase
{

    public function testPopularMovies()
    {
        self::bootKernel();
        $container = self::$container;

        $client = static::createClient();

        $movieAPI = self::$container->get('movie.api');
        $popularMovies = $movieAPI->getPopularMovies();


        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}