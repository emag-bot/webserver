<?php

namespace AppBundle\Service\Strategy;
use AppBundle\Entity\User;

/**
 * Interface QuickReplyStrategyInterface
 */
interface QuickReplyStrategyInterface
{
    public function canProcess($senderId, $conversationStateId, $text, $quickReplies, $attachments);

    public function process(User $user, $text, $quickReplies, $attachments);
}