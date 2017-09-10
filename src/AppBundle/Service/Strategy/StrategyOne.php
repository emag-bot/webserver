<?php

namespace AppBundle\Service\Strategy;


use AppBundle\Entity\User;

class StrategyOne extends AbstractStrategy
{
    const STATE_ID = 1;

    private $childStates = [StrategyTwo::STATE_ID];

    protected $greetings = ['Please send us a picture of what you want to buy :)', 'Can i help you with some products?', "Don't be shy, send me a picture and i'll find you the product :D"];

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
        $this->fbApiService->sendMessage($user->getFacebookId(), $this->greetings[rand(0,2)], [], []);
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