<?php

namespace AppBundle\Dto;


class FbAttachmentDto
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $payload;

    /**
     * @param array $data
     */
    public function create(array $data)
    {
        if (!empty($data['type'])) {
            $this->type = $data['type'];
        }

        if (!empty($data['payload'])) {
            $this->payload = $data['payload'];
        }
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $data = [];

        if (!empty($this->contentType)) {
            $data['type'] = $this->type;
        }

        if (!empty($this->payload)) {
            $data['payload'] = $this->payload;
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return FbAttachmentDto
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return FbAttachmentDto
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }
}