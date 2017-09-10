<?php

namespace AppBundle\Service\Strategy;


use AppBundle\Entity\User;

class StrategyThree extends AbstractStrategy
{
    const STATE_ID = 3;
//    private $state = [static::STATE_ID => 'Please send us a picture of what you want to buy :)'];
    private $childStates = [StrategyTwo::STATE_ID];

    public function process(User $user, $text, $quickReplies, $attachments)
    {
        // TODO: Implement process() method.
    }

    public function canProcess($senderId, $conversationStateId, $text, $quickReplies, $attachments)
    {
        // TODO: Implement canProcess() method.
    }
}