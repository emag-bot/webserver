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
}
