<?php
/**
 * Created by PhpStorm.
 * User: laurentiu
 * Date: 9/10/17
 * Time: 5:13 AM
 */

namespace AppBundle\Dto;


class FbElementDto implements DtoInterface
{
    private $title;

    private $imageUrl;

    /** @var  FbDefaultActionDto */
    private $defaultAction;

    public function export(): array
    {
        $data = [];

        if (!is_null($this->title)) {
            $data['title'] = $this->title;
        }

        if (!is_null($this->imageUrl)) {
            $data['image_url'] = $this->imageUrl;
        }

        if (!is_null($this->defaultAction)) {
            $data['default_action'] = $this->defaultAction->export();
        }

        return$data;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @param FbDefaultActionDto $defaultAction
     */
    public function setDefaultAction($defaultAction)
    {
        $this->defaultAction = $defaultAction;
    }



    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

}