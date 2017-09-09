<?php

namespace AppBundle\Service\Strategy;

/**
 * Interface QuickReplyStrategyInterface
 */
interface QuickReplyStrategyInterface
{
    public function canProcess($quickReply);

    public function process($quickReply);
}