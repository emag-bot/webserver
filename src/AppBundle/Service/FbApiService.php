<?php

namespace AppBundle\Service;

use AppBundle\Dto\FbAttachmentDto;
use AppBundle\Dto\FbMessageDto;
use AppBundle\Dto\FbMessagingDto;
use AppBundle\Dto\FbQuickReplyDto;
use AppBundle\Dto\FbRecipientDto;
use GuzzleHttp\Client;

class FbApiService
{
    const ID = 'fb.api.service';

    /**
     * @var  Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $facebookUri;

    /**
     * FbApiService constructor.
     */
    public function __construct($token, $facebookUri)
    {
        $this->token = $token;
        $this->facebookUri = $facebookUri;
        $this->client = new Client(
            [
                'base_uri' => $this->facebookUri,
                'http_errors' => false
            ]
        );
    }

    /**
     * @param int $recipientId
     * @param string $text
     * @param array $quickReplies
     */
    public function sendMessage(int $recipientId, string $text = '', $quickReplies = [], $attachments = [])
    {
        $request = new FbMessagingDto();

        $recipient = new FbRecipientDto();
        $recipient->setId($recipientId);

        $message = new FbMessageDto();
        if (!empty($text)) {
            $message->setText($text);
        }

        if (!empty($quickReplies)) {
            $quickRepliesDtos = [];
            foreach ($quickReplies as $quickReply) {
                $quickReplyDto = new FbQuickReplyDto();
                $quickReplyDto->create($quickReply);
                $quickRepliesDtos[] = $quickReplyDto;
            }
            $message->setQuickReplies($quickRepliesDtos);
        }

        if (!empty($attachments)) {
            $attachmentsDtos = [];
            foreach ($attachments as $attachment) {
                $attachmentDto = new FbAttachmentDto();
                $attachmentDto->create($attachment);
                $attachmentsDtos[] = $attachmentDto;
            }
            $message->setAttachments($attachmentsDtos);
        }

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