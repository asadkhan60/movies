<?php


namespace App\Entity;

class Movie
{
    /**
     * @var bool
     */
    private $adult = false;

    /**
     * @var string
     */
    private $backdropPath;

    /**
     * @var int
     */
    private $budget;

    /**
     * @var string
     */
    private $homepage;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $imdbId;

    /**
     * @var string
     */
    private $originalTitle;

    /**
     * @var string
     */
    private $originalLanguage;

    /**
     * @var string
     */
    private $overview;

    /**
     * @var float
     */
    private $popularity;

    /**
     * @var string
     */
    private $posterPath;

    /**
     * @var \DateTime
     */
    private $releaseDate;

    /**
     * @var int
     */
    private $revenue;

    /**
     * @var int
     */
    private $runtime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $tagline;

    /**
     * @var string
     */
    private $title;

    /**
     * @var float
     */
    private $voteAverage;

    /**
     * @var int
     */
    private $voteCount;


    /**
     * @param  boolean $adult
     * @return \Tmdb\Model\Movie
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
     * @param  string $backdropPath
     * @return $this
     */
    public function setBackdropPath($backdropPath)
    {
        $this->backdropPath = $backdropPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getBackdropPath()
    {
        return $this->backdropPath;
    }

    /**
     * @param  string $homepage
     * @return $this
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * @return string
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @param  mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  string $imdbId
     * @return $this
     */
    public function setImdbId($imdbId)
    {
        $this->imdbId = $imdbId;

        return $this;
    }

    /**
     * @return string
     */
    public function getImdbId()
    {
        return $this->imdbId;
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
     * @param  string $originalLanguage
     * @return $this
     */
    public function setOriginalLanguage($originalLanguage)
    {
        $this->originalLanguage = $originalLanguage;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage()
    {
        return $this->originalLanguage;
    }

    /**
     * @param  string $overview
     * @return $this
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
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
     * @param  string $posterPath
     * @return $this
     */
    public function setPosterPath($posterPath)
    {
        $this->posterPath = $posterPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getPosterPath()
    {
        return $this->posterPath;
    }

    /**
     * @param  string $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        if ($releaseDate['timestamp']) {
            $date = new \DateTime();
            $date->setTimestamp($releaseDate['timestamp']);
            $this->releaseDate = $date;
        }else{
            $this->releaseDate = $releaseDate;
        }
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param  mixed $revenue
     * @return $this
     */
    public function setRevenue($revenue)
    {
        $this->revenue = (int) $revenue;

        return $this;
    }

    /**
     * @return integer
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    /**
     * @param  mixed $runtime
     * @return $this
     */
    public function setRuntime($runtime)
    {
        $this->runtime = (int) $runtime;

        return $this;
    }

    /**
     * @return integer
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * @param  string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param  string $tagline
     * @return $this
     */
    public function setTagline($tagline)
    {
        $this->tagline = $tagline;

        return $this;
    }

    /**
     * @return string
     */
    public function getTagline()
    {
        return $this->tagline;
    }

    /**
     * @param  string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param  mixed $voteAverage
     * @return $this
     */
    public function setVoteAverage($voteAverage)
    {
        $this->voteAverage = (float) $voteAverage;

        return $this;
    }

    /**
     * @return double
     */
    public function getVoteAverage()
    {
        return $this->voteAverage;
    }

    /**
     * @param  mixed $voteCount
     * @return $this
     */
    public function setVoteCount($voteCount)
    {
        $this->voteCount = (int) $voteCount;

        return $this;
    }

    /**
     * @return integer
     */
    public function getVoteCount()
    {
        return $this->voteCount;
    }

    /**
     * @param  int   $budget
     * @return $this
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * @return int
     */
    public function getBudget()
    {
        return $this->budget;
    }
}