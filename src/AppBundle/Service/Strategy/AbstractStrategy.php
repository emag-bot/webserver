<?php

namespace AppBundle\Service\Strategy;


use AppBundle\Service\FbApiService;
use AppBundle\Service\GearmanService;
use AppBundle\Service\VisionApiService;
use Doctrine\ORM\EntityManager;

abstract class AbstractStrategy implements QuickReplyStrategyInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var FbApiService
     */
    protected $fbApiService;

    /**
     * @var VisionApiService
     */
    protected $visionApiService;

    /**
     * @var GearmanService
     */
    protected $gearmanService;

    /**
     * AbstractStrategy constructor.
     * @param EntityManager $entityManager
     * @param FbApiService $fbApiService
     */
    public function __construct(EntityManager $entityManager, FbApiService $fbApiService, VisionApiService $visionApiService, GearmanService $gearmanService)
    {
        $this->entityManager = $entityManager;
        $this->fbApiService = $fbApiService;
        $this->visionApiService = $visionApiService;
        $this->gearmanService = $gearmanService;
    }

//    protected function post($recipientFacebookId, )
}