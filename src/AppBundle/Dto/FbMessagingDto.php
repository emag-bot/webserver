<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25.08.2017
 * Time: 22:38
 */

namespace AppBundle\Dto;

class FbMessagingDto implements DtoInterface
{
    /** @var FbSenderDto  */
    protected $sender;

    /** @var FbRecipientDto  */
    protected $recipient;

    /** @var FbMessageDto  */
    protected $message;

    /**
     * FbMessagingDto constructor.
     */
    public function __construct()
    {
        $this->sender = new FbSenderDto();
        $this->recipient = new FbRecipientDto();
        $this->message = new FbMessageDto();
    }


    public function export(): array
    {
        $data = [];

        if (!empty($this->message)) {
            $data['message'] = $this->message->export();
        }

        if (!empty($this->recipient)) {
            $data['recipient'] = $this->recipient->export();
        }

        return $data;
    }

    public function create(array $data)
    {
        $this->sender->create($data['sender']);
        $this->recipient->create($data['recipient']);
        $this->message->create($data['message']);
    }

    /**
     * @return FbMessageDto
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return FbSenderDto
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return FbRecipientDto
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param FbSenderDto $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param FbRecipientDto $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @param FbMessageDto $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}