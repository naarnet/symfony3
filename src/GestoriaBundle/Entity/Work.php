<?php

/**
 * Description of User
 *
 * @author naarnet10@gmail.com
 */

namespace GestoriaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Version;
use Addressable\Bundle\Model\AddressableInterface;
use Addressable\Bundle\Model\Traits\ORM\AddressableTrait;

/**
 * @ORM\Entity()
 * @ORM\Table(name="work")
 */
class Work implements AddressableInterface
{

    use AddressableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $active;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updated_at;

    /**
     * 
     */
    public function __construct()
    {
        $this->updated_at = new \DateTime("now");
        $this->created_at = new \DateTime("now");
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    

    /**
     * Set created_at
     *
     * @param \DateTime $created_at
     * @ORM\PrePersist
     * @return Example
     */
    public function setCreatedAt($created_at)
    {

        if (!$created_at) {
            $this->created_at = new \DateTime();
        }

        return $this;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updated_at
     * @ORM\PrePersist
     * @return Example
     */
    public function setUpdatedAt($updated_at)
    {

        if (!$this->updated_at) {
            $this->updated_at = new \DateTime();
        }

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    
    
    public function __toString()
    {
        return '';
    }

}
