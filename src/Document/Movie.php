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
    private $id;

    /**
     * @MongoDB\Field(type="boolean")
     */
    private $adult = false;

    /**
     * @MongoDB\Field(type="string")
     */
    private $backdropPath;

    /**
     * @MongoDB\Field(type="string")
     */
    private $backdrop;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $belongsToCollection;

    /**
     * @MongoDB\Field(type="int")
     */
    private $budget;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $genres;

    /**
     * @MongoDB\Field(type="string")
     */
    private $homepage;

    /**
     * @MongoDB\Field(type="string")
     */
    private $imdbId;

    /**
     * @MongoDB\Field(type="string")
     */
    private $originalTitle;

    /**
     * @MongoDB\Field(type="string")
     */
    private $originalLanguage;

    /**
     * @MongoDB\Field(type="string")
     */
    private $overview;

    /**
     * @MongoDB\Field(type="float")
     */
    private $popularity;

    /**
     * @MongoDB\Field(type="string")
     */
    private $poster;

    /**
     * @MongoDB\Field(type="string")
     */
    private $posterPath;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $productionCompanies;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $productionCountries;

    /**
     * @MongoDB\Field(type="date")
     */
    private $releaseDate;

    /**
     * @MongoDB\Field(type="int")
     */
    private $revenue;

    /**
     * @MongoDB\Field(type="int")
     */
    private $runtime;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $spokenLanguages;

    /**
     * @MongoDB\Field(type="string")
     */
    private $status;

    /**
     * @MongoDB\Field(type="string")
     */
    private $tagline;

    /**
     * @MongoDB\Field(type="string")
     */
    private $title;

    /**
     * @MongoDB\Field(type="float")
     */
    private $voteAverage;

    /**
     * @MongoDB\Field(type="int")
     */
    private $voteCount;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $alternativeTitles;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $changes;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $credits;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $images;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $keywords;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $lists;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $releases;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $release_dates;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $similar;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $recommendations;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $translations;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $reviews;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $videos;

    public function __construct()
    {
        $this->genres              = [];
        $this->productionCompanies = [];
        $this->productionCountries = [];
        $this->spokenLanguages     = [];
        $this->alternativeTitles   = [];
        $this->changes             = [];
        $this->credits             = [];
        $this->images              = [];
        $this->keywords            = [];
        $this->lists               = [];
        $this->releases            = [];
        $this->release_dates       = [];
        $this->similar             = [];
        $this->recommendations     = [];
        $this->translations        = [];
        $this->videos              = [];
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
     * @param  null  $belongsToCollection
     * @return $this
     */
    public function setBelongsToCollection($belongsToCollection)
    {
        $this->belongsToCollection = $belongsToCollection;

        return $this;
    }

    /**
     * @return array
     */
    public function getBelongsToCollection()
    {
        return $this->belongsToCollection;
    }

    /**
     * @param  array $changes
     * @return $this
     */
    public function setChanges(array $changes)
    {
        $this->changes = $changes;

        return $this;
    }

    /**
     * @return mixed
     * @return array
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param  array $genres
     * @return $this
     */
    public function setGenres(array $genres)
    {
        $this->genres = $genres;

        return $this;
    }

    /**
     * @return array
     */
    public function getGenres()
    {
        return $this->genres;
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
     * @param  array
     * @return $this
     */
    public function setImages(array $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
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
     * @param  array $productionCompanies
     * @return $this
     */
    public function setProductionCompanies(array $productionCompanies)
    {
        $this->productionCompanies = $productionCompanies;

        return $this;
    }

    /**
     * @return array
     */
    public function getProductionCompanies()
    {
        return $this->productionCompanies;
    }

    /**
     * @param  array $productionCountries
     * @return $this
     */
    public function setProductionCountries(array $productionCountries)
    {
        $this->productionCountries = $productionCountries;

        return $this;
    }

    /**
     * @return array
     */
    public function getProductionCountries()
    {
        return $this->productionCountries;
    }

    /**
     * @param string $releaseDate
     * @return $this
     */
    public function setReleaseDate($releaseDate)
    {
        if (!$releaseDate instanceof \DateTime) {
            $releaseDate = new \DateTime($releaseDate);
        }

        $this->releaseDate = $releaseDate;

        return $this;
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
     * @param  array $spokenLanguages
     * @return $this
     */
    public function setSpokenLanguages(array $spokenLanguages)
    {
        $this->spokenLanguages = $spokenLanguages;

        return $this;
    }

    /**
     * @return array
     */
    public function getSpokenLanguages()
    {
        return $this->spokenLanguages;
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
     * @param  array $alternativeTitles
     * @return $this
     */
    public function setAlternativeTitles($alternativeTitles)
    {
        $this->alternativeTitles = $alternativeTitles;

        return $this;
    }

    /**
     * @return array
     */
    public function getAlternativeTitles()
    {
        return $this->alternativeTitles;
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

    /**
     * @param  array $credits
     * @return $this
     */
    public function setCredits(array $credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * @return array
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * @param  array $keywords
     * @return $this
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param  array $lists
     * @return $this
     */
    public function setLists($lists)
    {
        $this->lists = $lists;

        return $this;
    }

    /**
     * @return array
     */
    public function getLists()
    {
        return $this->lists;
    }

    /**
     * @param  array $releases
     * @return $this
     * @deprecated Use the setReleaseDates instead.
     */
    public function setReleases(array $releases)
    {
        $this->releases = $releases;

        return $this;
    }

    /**
     * @return array
     * @deprecated Use the getReleaseDates instead
     */
    public function getReleases()
    {
        return $this->releases;
    }

    /**
     * @param  array $release_dates
     * @return $this
     */
    public function setReleaseDates(array $release_dates)
    {
        $this->release_dates = $release_dates;

        return $this;
    }

    /**
     * @return array
     */
    public function getReleaseDates()
    {
        return $this->release_dates;
    }

    /**
     * @param  array $similar
     * @return $this
     */
    public function setSimilar($similar)
    {
        $this->similar = $similar;

        return $this;
    }

    /**
     * @param  array $recommendations
     * @return $this
     */
    public function setRecommendations($recommendations)
    {
        $this->recommendations = $recommendations;

        return $this;
    }

    /**
     * @return array
     */
    public function getSimilar()
    {
        return $this->similar;
    }

    /**
     * @return array
     */
    public function getRecommendations()
    {
        return $this->recommendations;
    }

    /**
     * @return array
     * @deprecated Use getSimilar instead
     */
    public function getSimilarMovies()
    {
        return $this->getSimilar();
    }

    /**
     * @param  array $translations
     * @return $this
     */
    public function setTranslations($translations)
    {
        $this->translations = $translations;

        return $this;
    }

    /**
     * @return array
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param  string $backdrop
     * @return $this
     */
    public function setBackdropImage($backdrop)
    {
        $this->backdrop = $backdrop;

        return $this;
    }

    /**
     * @return string
     */
    public function getBackdropImage()
    {
        return $this->backdrop;
    }

    /**
     * @param  string $poster
     * @return $this
     */
    public function setPosterImage($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * @return string
     */
    public function getPosterImage()
    {
        return $this->poster;
    }

    /**
     * @param  array $reviews
     * @return $this
     */
    public function setReviews($reviews)
    {
        $this->reviews = $reviews;

        return $this;
    }

    /**
     * @return array
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @param  array $videos
     * @return $this
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;

        return $this;
    }

    /**
     * @return array
     */
    public function getVideos()
    {
        return $this->videos;
    }
}