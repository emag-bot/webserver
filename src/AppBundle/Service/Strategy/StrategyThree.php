<?php

namespace AppBundle\Service\Strategy;


use AppBundle\Entity\User;

class StrategyThree extends AbstractStrategy
{
    const STATE_ID = 3;

    public function process(User $user, $text, $quickReplies, $attachments)
    {
        $user->setConverstationStateId(StrategyOne::STATE_ID);
        $this->entityManager->flush($user);
        if (!empty($quickReplies['0']['payload'])) {
            $payload = $quickReplies['0']['payload'];
            switch ($payload) {
                case 1:
                    $this->fbApiService->sendMessage($user->getFacebookId(), 'Thank you :D! Send me a greeting when you want to search for a new product!');
                    break;
                case 2:
                    $this->fbApiService->sendMessage($user->getFacebookId(), 'I am sorry :(! You can try a new search, I hope I will be able to provide better results.');
                    break;
            }
        }
    }

    public function canProcess($senderId, $conversationStateId, $text, $quickReplies, $attachments)
    {
        return $conversationStateId === static::STATE_ID && !empty($text);
    }
}