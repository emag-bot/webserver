<?php

namespace AppBundle\Service\Strategy;


use AppBundle\Entity\User;

class StrategyTwo extends AbstractStrategy
{
    const STATE_ID = 2;
    const TYPE = 'image';

    public function process(User $user, $text, $quickReplies, $attachments)
    {
        foreach ($attachments as $attachment) {
            if (!empty($attachment['type']) && $attachment['type'] === static::TYPE && !empty($attachment['payload']['url'])) {
                $labels = $this->visionApiService->getLabels($attachment['payload']['url'], true);
            }
        }
        var_dump($labels);die;
    }

    public function canProcess($senderId, $conversationStateId, $text, $quickReplies, $attachments)
    {
        return $conversationStateId === static::STATE_ID && !empty($attachments);
    }
}