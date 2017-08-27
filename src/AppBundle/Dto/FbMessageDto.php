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
    /** @var  string */
    protected $text;

    public function export(): array
    {
        $data = [];

        if (!empty($this->text)) {
            $data['text'] = $this->text;
        }

        return $data;
    }

    public function create(array $data)
    {
        $this->text = $data['text'];
    }

    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }
}