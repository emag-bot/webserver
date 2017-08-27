<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25.08.2017
 * Time: 22:25
 */

namespace AppBundle\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class FbRequestDto implements DtoInterface
{
    protected $object;

    /** @var  ArrayCollection */
    protected $entries;

    public function export(): array
    {

    }

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