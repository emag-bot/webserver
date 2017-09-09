<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25.08.2017
 * Time: 22:40
 */

namespace AppBundle\Dto;

class FbRecipientDto implements DtoInterface
{
    /** @var  int */
    protected $id;

    /**
     * @return array
     */
    public function export(): array
    {
        $data = [];

        if (!empty($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }

    public function create(array $data)
    {
        $this->id = $data['id'];
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
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}