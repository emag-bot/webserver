<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{

    /**
     * @ORM\Column(type="decimal", precision=20, scale=0, nullable=false, unique=true)
     * @ORM\Id
     */
    protected $facebookId;

    /**
     * @ORM\Column(type="smallint", nullable=false, unique=false)
     */
    protected $converstationStateId;

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param mixed $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConverstationStateId()
    {
        return $this->converstationStateId;
    }

    /**
     * @param mixed $converstationStateId
     * @return User
     */
    public function setConverstationStateId($converstationStateId)
    {
        $this->converstationStateId = $converstationStateId;
        return $this;
    }
}
