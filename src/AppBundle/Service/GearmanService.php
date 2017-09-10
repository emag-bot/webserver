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

    /**
     * @param string $url
     * @param array $labels
     * @return array
     */
    public function getProductsByLabels(string $url, array $labels = [])
    {

        $data = [
            'url' => $url,
            'labels' => $labels
        ];

        return json_decode($this->client->doNormal('imgrecon', json_encode($data, JSON_UNESCAPED_SLASHES)), true);
    }
}