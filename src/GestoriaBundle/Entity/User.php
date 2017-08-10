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
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Yaml\Yaml;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * @ORM\Entity()
 */
class User implements UserInterface, \Serializable
{

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
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $lastName;

    /**
     * @Assert\Email()
     * @ORM\Column(type="string", length=100, unique=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=100,nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $salt;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="user_roles",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $user_roles;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updated_at;

    public function __construct()
    {
        $this->user_roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
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
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
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
     * Set lastName
     *
     * @param string lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @param string lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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

        return $this->created_at = $created_at;
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
    public function setUpdatedAt()
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

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $confg = Yaml::parse(__DIR__ . '/../../../app/config/security.yml');
        print_r($confg);
//        $params = $confg['security']['encoders']["GestoriaBundle\\Entity\\User"]; //Nombre de la clase hardcoded ya que si usas get_class($this) a veces regresa 
        $encode = new MessageDigestPasswordEncoder(
                'sha512', true, 10
        );

        $this->password = $encode->encodePassword($password, $this->salt);
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    function eraseCredentials()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    function equals(UserInterface $user)
    {
        return $user->getUsername() == $this->getUsername();
    }

    public function __toString()
    {
        return $this->name . ' ' . $this->lastName;
    }

    public function getRoles()
    {
        return $this->user_roles->toArray();
    }

    /**
     * Add user_roles
     *
     * @param GestoriaBundle\Entity\Role $userRoles
     */
    public function addRole(\GestoriaBundle\Entity\Role $userRoles)
    {
        $this->user_roles[] = $userRoles;
    }

    /**
     * Get user_roles
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUserRoles()
    {
        return $this->user_roles;
    }

    public function setUserRoles($user_roles)
    {
        $this->user_roles = $user_roles;
    }

    public function getClass()
    {
        return "GestoriaBundle:User";
    }

    /**
     * Add user_roles
     *
     * @param \GestoriaBundle\Entity\Role $userRoles
     * @return User
     */
    public function addUserRole(\GestoriaBundle\Entity\Role $userRoles)
    {
        $this->user_roles[] = $userRoles;

        return $this;
    }

    public function unserialize($data)
    {
        $this->id = unserialize($data);
    }

    public function hasRol($role)
    {
        $roles = $this->getRoles();
        foreach ($roles as $rol) {
            if ($rol->getName() == $role) {
                return true;
            }
        }
        return FALSE;
    }

    /**
     * Check if password is valid
     *
     * @param string ,password    
     *
     * @return bool
     */
    public function isValidPassword($password)
    {
        $confg = Yaml::parse(__DIR__ . '/../../../../app/config/security.yml');
        $params = $confg['security']['encoders']["GestoriaBundle\\Entity\\User"]; //Nombre de la clase hardcoded ya que si usas get_class($this) a veces regresa 
        $encode = new MessageDigestPasswordEncoder(
                $params['algorithm'], true, $params['iterations']
        );

        $pass = $encode->encodePassword($password, $this->salt);
        if ($this->getPassword() == $pass) {
            return true;
        } else {
            return false;
        }
    }

    public function serialize()
    {
        return serialize($this->id);
    }

}
