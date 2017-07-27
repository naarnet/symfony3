<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\EntryRepository")
 */
class Entry
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $tittle;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $image;

    /**
     * @var \BlogBundle\Entity\Category
     */
    private $category;

    /**
     * @var \BlogBundle\Entity\User
     */
    private $user;

    /**
     *
     * @var type 
     */
    protected $entryTag;

    public function __construct()
    {
        $this->entryTag = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tittle
     *
     * @param string $tittle
     *
     * @return Entry
     */
    public function setTittle($tittle)
    {
        $this->tittle = $tittle;

        return $this;
    }

    /**
     * Get tittle
     *
     * @return string
     */
    public function getTittle()
    {
        return $this->tittle;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Entry
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Entry
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Entry
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category
     *
     * @param \BlogBundle\Entity\Category $category
     *
     * @return Entry
     */
    public function setCategory(\BlogBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \BlogBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \BlogBundle\Entity\User $user
     *
     * @return Entry
     */
    public function setUser(\BlogBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BlogBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * 
     * @param \BlogBundle\Entity\Tag $tag
     * @return $this
     */
    public function addEntryTag(\BlogBundle\Entity\Tag $tag)
    {
        $this->entryTag[] = $tag;
        return $this;
    }

    /**
     * 
     * @param \BlogBundle\Entity\Tag $tag
     * @return $this
     */
    public function getEntryTag()
    {
        return $this->entryTag;
    }

}
