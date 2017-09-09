<?php

namespace AppBundle\Service\Strategy;


abstract class AbstractStrategy implements QuickReplyStrategyInterface
{
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

//    protected function post($recipientFacebookId, )
}