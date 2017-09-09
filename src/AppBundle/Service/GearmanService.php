<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 09.09.2017
 * Time: 13:36
 */

namespace AppBundle\Service;

class GearmanService
{
    const ID = 'gearman.service';

    /** @var  \GearmanClient */
    private $client;

    public function __construct()
    {
        $this->client = new \GearmanClient();
        $this->client->addServer('gearman.emag-bot.com');
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function getRawData(string $url)
    {
        return $this->client->doNormal('getrawdata', $url);
    }
}