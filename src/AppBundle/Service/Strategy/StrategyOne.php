<?php

namespace AppBundle\Service\Strategy;


use AppBundle\Entity\User;

class StrategyOne extends AbstractStrategy
{
    const STATE_ID = 1;

    private $childStates = [StrategyTwo::STATE_ID];

    /**
     * @param User $user
     * @param $text
     * @param $quickReplies
     * @param $attachments
     */
    public function process(User $user, $text, $quickReplies, $attachments)
    {
        $user->setConverstationStateId(StrategyTwo::STATE_ID);
        $this->entityManager->flush();
        $this->fbApiService->sendMessage($user->getFacebookId(), 'Please send us a picture of what you want to buy :)', [], []);
    }

    /**
     * @param $senderId
     * @param $conversationStateId
     * @param $text
     * @param $quickReplies
     * @param $attachments
     * @return bool
     */
    public function canProcess($senderId, $conversationStateId, $text, $quickReplies, $attachments)
    {
        return $conversationStateId === static::STATE_ID;
    }
}