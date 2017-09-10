<?php

namespace AppBundle\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class FbMessageDto implements DtoInterface
{
    /**
     * @var  string
     */
    protected $text;

    /**
     * @var array
     */
    protected $quickReplies;

    /**
     * @var array
     */
    protected $attachments;

    /**
     * @return array
     */
    public function export(): array
    {
        $data = [];

        if (!empty($this->text)) {
            $data['text'] = $this->text;
        }

        if (!empty($this->quickReplies)) {
            /** @var FbQuickReplyDto $quickReply */
            foreach ($this->quickReplies as $quickReply) {
                $data['quick_replies'][] = $quickReply;
            }
        }

        if (!empty($this->attachments)) {
            /** @var FbAttachmentDto $quickReply */
            foreach ($this->attachments as $attachment) {
                $data['attachments'][] = $attachment;
            }
        }

        return $data;
    }

    /**
     * @param array $data
     */
    public function create(array $data)
    {
        if (!empty($data['text'])) {
            $this->text = $data['text'];
        }

        if (!empty($data['quick_replies'])) {
            $this->quickReplies = $data['quick_replies'];
        } elseif (!empty($data['quick_reply'])) {
            $this->quickReplies[] = $data['quick_reply'];
        }

        if (!empty($data['attachments'])) {
            $this->attachments = $data['attachments'];
        }
    }

    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getQuickReplies()
    {
        return $this->quickReplies;
    }

    /**
     * @param mixed $quickReplies
     * @return FbMessageDto
     */
    public function setQuickReplies($quickReplies)
    {
        $this->quickReplies = $quickReplies;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param array $attachments
     * @return FbMessageDto
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
        return $this;
    }
}