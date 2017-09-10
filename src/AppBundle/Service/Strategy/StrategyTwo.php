<?php

namespace AppBundle\Service\Strategy;


use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use GuzzleHttp\Client;

class StrategyTwo extends AbstractStrategy
{
    const STATE_ID = 2;
    const TYPE = 'image';
    protected $quickReplies = [['title' => 'This was helpful, thanks :D!', 'payload' => 1, "content_type" => "text"], ['title' => 'My product was not listed :(' , 'payload' => 2, "content_type" => "text"]];

    public function process(User $user, $text, $quickReplies, $attachments)
    {
        foreach ($attachments as $attachment) {
            if (!empty($attachment['type']) && $attachment['type'] === static::TYPE && !empty($attachment['payload']['url'])) {
                $url = $this->downloadLocal($attachment['payload']['url']);
                $labels = $this->visionApiService->getLabels($url);
//                error_log("Got labels: " . json_encode($labels));
                $ids = $this->gearmanService->getProductsByLabels($url, $labels);
//                $ids = [306];
//                error_log("Got ids: " . json_encode($ids));

                $top = array_splice($ids, 0 , 3);
                $this->fbApiService->sendProducts($user->getFacebookId(), $this->getProducts($top), $this->quickReplies);
            }
        }error_log(StrategyThree::STATE_ID);
        $user->setConverstationStateId(StrategyThree::STATE_ID);
        $this->entityManager->flush($user);
    }

    public function canProcess($senderId, $conversationStateId, $text, $quickReplies, $attachments)
    {
        return $conversationStateId === static::STATE_ID && !empty($attachments);
    }

    /**
     * @param array $ids
     * @return Product[]
     */
    public function getProducts(array $ids = [])
    {
        $products = [];
        $repo = $this->entityManager->getRepository(Product::class);

        foreach($ids as $id) {
            $products[] = $repo->find($id);
        }

        return $products;
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