<?php

namespace AppBundle\Service;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class UserService
{
    const ID = 'user.service';

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * UserService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $facebookId
     * @return bool
     */
    public function checkUser(int $facebookId = 0):bool
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['facebookId' => $facebookId]);

        if ($user instanceof User) {
            return true;
        } else {
            $this->addUser($facebookId);
            return false;
        }

    }

    /**
     * @param int $facebookId
     */
    public function addUser(int $facebookId = 0)
    {
        $user = new User();
        $user->setFacebookId($facebookId);
        $this->entityManager->persist();
        $this->entityManager->flush();
    }
}
