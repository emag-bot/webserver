<?php

namespace AppBundle\Controller;

use AppBundle\Dto\FbMessageDto;
use AppBundle\Dto\FbMessagingDto;
use AppBundle\Dto\FbRecipientDto;
use AppBundle\Dto\FbRequestDto;
use AppBundle\Dto\FbSenderDto;
use AppBundle\Entity\Image;
use AppBundle\Entity\Label;
use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use AppBundle\Exception\QuickReplyException;
use AppBundle\Service\FbApiService;
use AppBundle\Service\VisionApiService;
use GuzzleHttp\Client;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function webHookAction(Request $request)
    {
        /** @var Logger $logger */
        $logger = $this->get('monolog.logger.api');

        /** @var FbApiService $fbApiService */
        $fbApiService = $this->get(FbApiService::ID);

        $data = json_decode($request->getContent(), true);
        $fbRequest = new FbRequestDto();
        $fbRequest->create($data);

        /** @var FbMessagingDto $message */
        foreach ($fbRequest->getAllMessages() as $message) {
            $senderId = $message->getSender()->getId();
            if (empty($senderId)) {
                return new JsonResponse();
            }
            $this->get('user.service')->checkUser($senderId);
            $text = $message->getMessage()->getText();
            $quickReplies = $message->getMessage()->export();
            $quickReplies = !empty($quickReplies['quick_replies']) ? $quickReplies['quick_replies'] : [];
            $attachments = $message->getMessage()->export();
            $attachments = !empty($attachments['attachments']) ? $attachments['attachments'] : [];
            try {
                $this->get('quick.reply.service')->handle($senderId, $text, $quickReplies, $attachments);
            } catch (QuickReplyException $e) {
                $logger->addCritical($e->getMessage());
            }
        }
        return new JsonResponse();
    }

    public function createProductAction(Request $request)
    {
        /** @var VisionApiService $service */
        $service = $this->get(VisionApiService::ID);
        $data = json_decode($request->getContent(), true);
        return new JsonResponse(
            [
                "id" => $this->get('product.service')->createProduct($data)->getId()
            ]
        );
    }
}