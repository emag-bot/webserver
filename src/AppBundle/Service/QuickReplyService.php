<?php

namespace AppBundle\Service;

use AppBundle\Service\Strategy\QuickReplyStrategyInterface;

class QuickReplyService
{
    const ID = 'quick.reply.service';

    /**
     * @var array
     */
    private $strategies = [];

    public function addStrategy(QuickReplyStrategyInterface $strategy)
    {
        $this->strategies[] = $strategy;
    }

    /**
     * @param $quickReply
     * @return mixed
     * @throws \QuickReplyException
     */
    public function handle($quickReply)
    {
        /** @var QuickReplyStrategyInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->canProcess($quickReply)) {
                return $strategy->process($quickReply);
            }
        }

        throw new \QuickReplyException("UserService unable to handle quickReply:  {$quickReply}");
    }
}