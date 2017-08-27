<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 27.08.2017
 * Time: 12:25
 */

namespace AppBundle\Service;

use AppBundle\Dto\FbMessageDto;
use AppBundle\Dto\FbMessagingDto;
use AppBundle\Dto\FbRecipientDto;
use GuzzleHttp\Client;

class FbApiService
{
    const ID = 'fb.api.service';

    /** @var  Client */
    protected $client;

    /** @var string */
    protected $token = 'EAABsaJb6jCABAMxX8cJRbnPYjglVes3VBxykp1GeYeWt0jDsp5p0ZCZBCvNO9klggyBVZBKYV6LObitPtYraLd7ZBZAn8i29gYOng3aZB18QuZCR9YEaWJbZAo6E5a9wFxwIRUmG5nr4OVFbL79IGyjvjxNjQS8KILnM1NsVj9ZAQ4geYZAVsabcaZB';

    /**
     * FbApiService constructor.
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => 'https://graph.facebook.com/v2.6/me/messages',
                'http_errors' => false
            ]
        );
    }

    public function sendTextMessage(int $recipientId, string $text)
    {
        $request = new FbMessagingDto();

        $recipient = new FbRecipientDto();
        $recipient->setId($recipientId);

        $message = new FbMessageDto();
        $message->setText($text);

        $request->setRecipient($recipient);
        $request->setMessage($message);

        $options = [
            'query' => [
                'access_token' => $this->token
            ],
            'body' => json_encode($request->export()),
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ];

        $result = $this->client->post('', $options);
    }
}