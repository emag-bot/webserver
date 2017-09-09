<?php

namespace AppBundle\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class FbRequestDto implements DtoInterface
{
    protected $object;

    /** @var
     * ArrayCollection
     */
    protected $entries;

    /**
     * @return array
     */
    public function export(): array
    {
        $data = [];

        if (!empty($this->object)) {
            $data['object'] = $this->object;
        }

        if (!empty($this->entries)) {
            foreach ($this->entries as $entry) {
                $data['entry'][] = $entry;
            }
        }

        return $data;
    }

    /**
     * @param array $data
     */
    public function create(array $data)
    {
        $this->object = $data['object'];
        $this->entries = new ArrayCollection();

        foreach ($data['entry'] as $entryData) {
            $entry = new FbEntryDto();
            $entry->create($entryData);
            $this->entries->add($entry);
        }
    }

    /**
     * @return \Generator
     */
    public function getAllMessages()
    {
        /** @var FbEntryDto $entry */
        foreach ($this->entries as $entry) {
            /** @var FbMessagingDto $messaging */
            foreach ($entry->getMessaging() as $messaging) {
                yield $messaging;
            }
        }
    }
}