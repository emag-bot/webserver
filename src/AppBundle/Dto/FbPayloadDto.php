<?php
/**
 * Created by PhpStorm.
 * User: laurentiu
 * Date: 9/10/17
 * Time: 5:11 AM
 */

namespace AppBundle\Dto;


class FbPayloadDto implements DtoInterface
{
    private $templateType = "list";

    private $topElementStyle = "large";

    /** @var  FbElementDto[] */
    private $elements;

    public function export(): array
    {
        $elements = [];

        foreach ($this->elements as $element) {
            $elements[] = $element->export();
        }

        return [
            'template_type' => $this->templateType,
            'top_element_style' => $this->topElementStyle,
            'elements' => $elements
        ];
    }

    public function create(array $data)
    {
        if (isset($data['elements'])) {
            foreach ($data['elements'] as $elementData) {
                $element = new FbElementDto();
                $this->elements[] = $element;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param mixed $elements
     */
    public function setElements($elements)
    {
        $this->elements = $elements;
    }

    public function addElement(FbElementDto $element)
    {
        if (is_null($this->elements)) {
            $this->elements = [];
        }

        $this->elements [] = $element;
    }
}