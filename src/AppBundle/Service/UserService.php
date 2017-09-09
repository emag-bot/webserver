<?php

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;

class UserService
{
    const ID = 'user.service';

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function checkUser(int $facebookId = 0):bool
    {
    }

    public function addUser(int $facebookId = 0):bool
}
