<?php

namespace Bfvt\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Bfvt\UserBundle\Entity\UserRepository")
 * @UniqueEntity(fields="username", message="The user name is exist.")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="User name required!")
     * @Assert\Length(min="3", minMessage="Give us at least 3 characters")
     * @ORM\Column(name="username", type="string", length=255)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json_array")
     */
    protected $roles = array();

    /**
     * Just store the plain password temporarily!
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/",
     *      message="Use 1 upper case letter, 1 lower case letter, and 1 number!"
     * )
     * @var string
     */
    protected $plainPassword;

    /**
     * @ORM\Column(name="$usernameCanonical", type="string", length=255)
     * @var string
     */
    protected $usernameCanonical;


    /**
     * @ORM\Column(name="enabled", type="boolean")
     * @var boolean
     */
    protected $enabled;

    /**
     * @var string
     */
    public function __construct(){
        parent::__construct();

        $this->enabled = true;
//        $this->roles = array('ROLE_ADMIN');
    }
}
