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
     * @MongoDB\Field(type="string", name="original_title")
     */
    private $originalTitle;

    /**
     * @MongoDB\Field(type="float")
     */
    private $popularity;

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
}