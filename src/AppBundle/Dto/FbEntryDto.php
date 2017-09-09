<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25.08.2017
 * Time: 22:34
 */

namespace AppBundle\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class FbEntryDto implements DtoInterface
{
    protected $id;

    protected $time;

    /** @var  ArrayCollection */
    protected $messaging;

    public function export(): array
    {
        // TODO: Implement export() method.
    }

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

    public function getMessaging()
    {
        return $this->messaging;
    }
}