<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25.08.2017
 * Time: 22:40
 */

namespace AppBundle\Dto;

class FbSenderDto
{
    /** @var  int */
    protected $id;

    public function export(): array
    {
        $data = [];

        if (!empty($id)) {
            $data['id'] = $id;
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