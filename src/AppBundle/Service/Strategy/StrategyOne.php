<?php

namespace AppBundle\Service\Strategy;


class StrategyOne extends AbstractStrategy
{
    const STATE_ID = 1;
    private $state = [static::STATE_ID = 'Please send us a picture of what you want to buy :)'];
    private $childStates = [StrategyTwo::STATE_ID];

    public function process($quickReply)
    {
        // TODO: Implement process() method.
    }

    public function canProcess($quickReply)
    {
        return $quickReply === $this->state[static::STATE_ID];
    }
}