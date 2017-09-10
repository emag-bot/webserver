<?php
/**
 * Created by PhpStorm.
 * User: laurentiu
 * Date: 9/10/17
 * Time: 5:14 AM
 */

namespace AppBundle\Dto;


class FbDefaultActionDto implements DtoInterface
{
    private $type = "web_url";

    private $url;

    public function export(): array
    {
        $data = [];


        if (!is_null($this->type)) {
            $data['type'] = $this->type;
        }

        if (!is_null($this->url)) {
            $data['url'] = $this->url;
        }
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }
}