<?php

namespace AppBundle\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class FbEntryDto implements DtoInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $time;

    /** @var
     * ArrayCollection
     */
    protected $messaging;

    /**
     * @return array
     */
    public function export(): array
    {
        $data = [];

        if (!empty($this->contentType)) {
            $data['id'] = $this->id;
        }

        if (!empty($this->time)) {
            $data['time'] = $this->time;
        }

        if (!empty($this->messaging)) {
            foreach ($this->messaging as $message) {
                $data['messaging'][] = $message;
            }
        }

        return $data;
    }

    /**
     * @param array $data
     */
    public function create(array $data)
    {
        $this->id = $data['id'];
        $this->time = $data['time'];
        $this->messaging = new ArrayCollection();

        foreach ($data['messaging'] as $messagingData) {
            $messaging = new FbMessagingDto();
            $messaging->create($messagingData);

            $this->messaging->add($messaging);
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return FbEntryDto
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param int $time
     * @return FbEntryDto
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessaging()
    {
        return $this->messaging;
    }

    /**
     * @param mixed $messaging
     * @return FbEntryDto
     */
    public function setMessaging($messaging)
    {
        $this->messaging = $messaging;
        return $this;
    }
}