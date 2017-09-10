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
use AppBundle\Entity\Image;
use AppBundle\Entity\Label;
use AppBundle\Entity\Product;
use AppBundle\Entity\User;
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
            $this->get('quick.reply.service')->handle($senderId, $text, $quickReplies, $attachments);
            $logger->addInfo("Got message: [{$message->getMessage()->getText()}] from [{$message->getSender()->getId()}]");
        }


        return new JsonResponse();
    }

    public function createProductAction(Request $request)
    {
        /** @var VisionApiService $service */
        $service = $this->get(VisionApiService::ID);

        $data = json_decode($request->getContent(), true);
        $client = new Client();

        $product = new Product();

        $product->setLink($data['link']);
        $product->setBrand($data['brand']);
        $product->setCategory($data['category']);
        $product->setName($data['name']);

        foreach ($data["images"] as $url) {
            $image = new Image();

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

            $image->setUrl('http://static.emag-bot.com/' . $guid . '.png');

            foreach ($service->getLabels($image->getUrl()) as $label) {
                $image->addLabel($label);
            }

            $product->addImage($image);
        }

        $this->getDoctrine()->getManager()->persist($product);
        $this->getDoctrine()->getManager()->flush();


        return new JsonResponse(
            [
                "id" => $product->getId()
            ]
        );
    }

    public function generateGuid()
    {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}