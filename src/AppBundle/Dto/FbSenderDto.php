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
    protected $id;

    public function export(): array
    {
        // TODO: Implement export() method.
    }

    public function create(array $data)
    {
        $this->id = $data['id'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}