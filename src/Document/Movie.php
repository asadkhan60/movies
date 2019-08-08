<?php


namespace App\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @MongoDB\Id
     */
    private $_id;

    /**
     * @MongoDB\Field(type="int", name="id")
     * @MongoDB\UniqueIndex
     */
    private $id;

    /**
     * @MongoDB\Field(type="boolean")
     */
    private $adult = false;

    /**
     * @MongoDB\Field(type="string", name="title")
     */
    private $title;

    /**
     * @MongoDB\Field(type="string", name="original_title")
     */
    private $originalTitle;

    /**
     * @MongoDB\Field(type="string", name="original_language")
     */
    private $originalLanguage;

    /**
     * @MongoDB\Field(type="string", name="overview")
     */
    private $overview;

    /**
     * @MongoDB\Field(type="string", name="backdrop_path")
     */
    private $backdropPath;

    /**
     * @MongoDB\Field(type="string", name="poster_path")
     */
    private $posterPath;

    /**
     * @MongoDB\Field(type="float", name="popularity")
     */
    private $popularity;

    /**
     * @MongoDB\Field(type="float", name="vote_average")
     */
    private $voteAverage;

    /**
     * @MongoDB\Field(type="int", name="vote_count")
     */
    private $voteCount;

    /**
     * @MongoDB\Field(type="date", name="release_date")
     */
    private $releaseDate;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  boolean $adult
     * @return $this
     */
    public function setAdult($adult)
    {
        $this->adult = (bool) $adult;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getAdult()
    {
        return $this->adult;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @param  string $originalTitle
     * @return $this
     */
    public function setOriginalTitle($originalTitle)
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalTitle()
    {
        return $this->originalTitle;
    }

    /**
     * @param  mixed $popularity
     * @return $this
     */
    public function setPopularity($popularity)
    {
        $this->popularity = (float) $popularity;

        return $this;
    }

    /**
     * @return double
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * @return mixed
     */
    public function getOriginalLanguage()
    {
        return $this->originalLanguage;
    }

    /**
     * @param mixed $originalLanguage
     */
    public function setOriginalLanguage($originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * @return mixed
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * @param mixed $overview
     */
    public function setOverview($overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @return mixed
     */
    public function getBackdropPath()
    {
        return $this->backdropPath;
    }

    /**
     * @param mixed $backdropPath
     */
    public function setBackdropPath($backdropPath): void
    {
        $this->backdropPath = $backdropPath;
    }

    /**
     * @return mixed
     */
    public function getPosterPath()
    {
        return $this->posterPath;
    }

    /**
     * @param mixed $posterPath
     */
    public function setPosterPath($posterPath): void
    {
        $this->posterPath = $posterPath;
    }

    /**
     * @return mixed
     */
    public function getVoteAverage()
    {
        return $this->voteAverage;
    }

    /**
     * @param mixed $voteAverage
     */
    public function setVoteAverage($voteAverage): void
    {
        $this->voteAverage = $voteAverage;
    }

    /**
     * @return mixed
     */
    public function getVoteCount()
    {
        return $this->voteCount;
    }

    /**
     * @param mixed $voteCount
     */
    public function setVoteCount($voteCount): void
    {
        $this->voteCount = $voteCount;
    }

    /**
     * @param  string $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }
}