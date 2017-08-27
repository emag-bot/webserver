<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25.08.2017
 * Time: 13:10
 */

namespace AppBundle\Controller;

use AppBundle\Dto\FbMessageDto;
use AppBundle\Dto\FbMessagingDto;
use AppBundle\Dto\FbRecipientDto;
use AppBundle\Dto\FbRequestDto;
use AppBundle\Dto\FbSenderDto;
use AppBundle\Service\FbApiService;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function webhookAction(Request $request)
    {
        /** @var Logger $logger */
        $logger = $this->get('monolog.logger.api');

        /** @var FbApiService $service */
        $service = $this->get(FbApiService::ID);

        $data = json_decode($request->getContent(), true);

        $fbRequest = new FbRequestDto();
        $fbRequest->create($data);

        /** @var FbMessagingDto $message */
        foreach ($fbRequest->getAllMessages() as $message) {
            $logger->addInfo("Got message: [{$message->getMessage()->getText()}] from [{$message->getSender()->getId()}]");

            $text = strrev($message->getMessage()->getText());
            $service->sendTextMessage($message->getSender()->getId(), $text);
        }


        return new JsonResponse();
    }
}