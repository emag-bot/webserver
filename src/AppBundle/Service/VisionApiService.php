<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 27.08.2017
 * Time: 22:20
 */

namespace AppBundle\Service;


use GuzzleHttp\Client;

class VisionApiService
{
    const ID = 'vision.api.service';

    /** @var  Client */
    protected $client;

    /** @var string */
    protected $token = 'AIzaSyC3UnR1sH6OClvaeR8-z6-5L46iPK3KECE';

    /**
     * FbApiService constructor.
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => 'https://vision.googleapis.com/v1/images:annotate',
                'http_errors' => false
            ]
        );
    }

    public function getLabels(string $url, $download = false)
    {
        if ($download == true) {
            $url = $this->downloadLocal($url);
        }

        $request = [
            "requests" => [
                [
                    "image" => [
                        "source" => [
                            "imageUri" => $url
                        ]
                    ],
                    "features" => [
                        "type" => "LABEL_DETECTION"
                    ]
                ]
            ]
        ];

        $options = [
            'query' => [
                'key' => $this->token
            ],
            'body' => json_encode($request),
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ];

        $result = $this->client->post('', $options);

        $data = json_decode($result->getBody()->getContents(), true);

        $labels = [];
        foreach ($data['responses'][0]['labelAnnotations'] as $label) {
            $labels [] = $label['description'];
        }

        return $labels;
    }

    /**
     * @param $url
     */
    public function downloadLocal($url)
    {
        $client = new Client();

        $guid = $this->generateGuid();
        $path = '/var/www/static/' . $guid;

        $resource = fopen($path, 'w');
        $response = $client->get($url, [
            'sink' => $resource
        ]);

        $type = $response->getHeaderLine("Content-Type");

        if ($type == "image/jpeg") {
            $raw = imagecreatefromjpeg($path);
            imagepng($raw, $path . '.png');
            unlink($path);
        } else {
            rename($path, $path . '.png');
        }

        return 'http://static.emag-bot.com/' . $guid . '.png';
    }

    public function generateGuid()
    {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
