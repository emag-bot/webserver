<?php

namespace AppBundle\Service\Strategy;


class StrategyThree extends AbstractStrategy
{
    const STATE_ID = 3;
    private $state = [static::STATE_ID = 'Please send us a picture of what you want to buy :)'];
    private $childStates = [StrategyTwo::STATE_ID];

    public function process($method, $context, $subContext, $data)
    {
        // TODO: Implement process() method.
    }
}