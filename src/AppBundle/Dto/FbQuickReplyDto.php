<?php

namespace AppBundle\Dto;

class FbQuickReplyDto implements DtoInterface
{
    /**
     * @var string
     */
    protected $contentType;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $payload;

    /**
     * @var string
     */
    protected $imageUrl;

    /**
     * @param array $data
     */
    public function create(array $data)
    {
        if (!empty($data['content_type'])) {
            $this->contentType = $data['content_type'];
        }

        if (!empty($data['title'])) {
            $this->title = $data['title'];
        }

        if (!empty($data['payload'])) {
             $this->payload = $data['payload'];
        }

        if (!empty($data['image_url'])) {
             $this->imageUrl = $data['image_url'];
        }
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $data = [];

        if (!empty($this->contentType)) {
            $data['content_type'] = $this->contentType;
        }

        if (!empty($this->title)) {
            $data['title'] = $this->title;
        }

        if (!empty($this->payload)) {
            $data['payload'] = $this->payload;
        }

        if (!empty($this->imageUrl)) {
            $data['image_url'] = $this->imageUrl;
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     * @return FbQuickReplyDto
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return FbQuickReplyDto
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     * @return FbQuickReplyDto
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     * @return FbQuickReplyDto
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }
}
