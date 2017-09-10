<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Service\Strategy\QuickReplyStrategyInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Exception\QuickReplyException;

class QuickReplyService
{
    const ID = 'quick.reply.service';

    /**
     * @var array
     */
    private $strategies = [];

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function addStrategy(QuickReplyStrategyInterface $strategy)
    {
        $this->strategies[] = $strategy;
    }

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $quickReply
     * @return mixed
     * @throws \QuickReplyException
     */
    public function handle($senderId, $text, $quickReplies, $attachments)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['facebookId' => $senderId]);
        $conversationStateId = 0;
        if ($user instanceof User) {
            $conversationStateId = $user->getConverstationStateId();
        }
        /** @var QuickReplyStrategyInterface $strategy */
        foreach ($this->strategies as $strategy) {
            if ($strategy->canProcess($senderId, $conversationStateId, $text, $quickReplies, $attachments)) {
                return $strategy->process($user, $text, $quickReplies, $attachments);
            }
        }

        throw new QuickReplyException("UserService unable to handle request:  {$quickReply}");
    }
}