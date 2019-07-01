<?php


namespace App\Tests\Controller;


use App\Services\MovieAPI;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tmdb\Model\Movie;

class BaseControllerTest extends WebTestCase
{
    private $client = null;
    private $movieApi = null;

    public function setUp()
    {
        self::bootKernel();
        $this->movieApi = self::$container->get('movie.api');
        $this->client = static::createClient();
    }

    public function testPopularMovies()
    {
        $popularMovies = $this->movieApi->getPopularMovies();
        $popularMovies = [];

        $crawler = $this->client->request('GET', '/');

        $this->assertGreaterThanOrEqual(0, count($popularMovies));
        $this->assertContainsOnlyInstancesOf(Movie::class, $popularMovies);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}