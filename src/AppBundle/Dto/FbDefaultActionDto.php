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


        if (!empty($this->type)) {
            $data['type'] = $this->type;
        }

        if (!empty($this->url)) {
            $data['url'] = $this->url;
        }

        return $data;
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}