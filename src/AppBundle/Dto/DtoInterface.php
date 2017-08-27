<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25.08.2017
 * Time: 22:24
 */

namespace AppBundle\Dto;

interface DtoInterface
{
    public function export(): array;

    public function create(array $data);
}