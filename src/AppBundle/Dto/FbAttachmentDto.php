<?php

namespace AppBundle\Dto;


class FbAttachmentDto
{
    /**
     * @var string
     */
    protected $type = 'template';

    /**
     * @var FbPayloadDto
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
            $this->payload = new FbPayloadDto();
            $this->payload->create($data['payload']);
        }

    }

    /**
     * @return array
     */
    public function export(): array
    {
        $data = [];

        if (!empty($this->type)) {
            $data['type'] = $this->type;
        }

        if (!empty($this->type)) {
            $data['payload'] = $this->payload->export();
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