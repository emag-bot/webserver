<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25.08.2017
 * Time: 22:44
 */

namespace AppBundle\Dto;

class FbMessageDto implements DtoInterface
{
    protected $text;

    public function export(): array
    {
        // TODO: Implement export() method.
    }

    public function create(array $data)
    {
        $this->text = $data['text'];
    }

    public function getText()
    {
        return $this->text;
    }
}