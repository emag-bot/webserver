<?php

namespace AppBundle\Service;


use AppBundle\Entity\Product;
use GuzzleHttp\Client;

class ProductService
{
    const ACCEPTED_EXTENSION = '.png';
    const AVAILABLE_EXTENSION = 'image/jpeg';
    /**
     * @var string
     */
    protected $staticPath;

    /**
     * @var string
     */
    protected $staticUrl;

    /**
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data = [])
    {
        $client = new Client();

        $product = new Product();

        $product->setLink($data['link']);
        $product->setBrand($data['brand']);
        $product->setCategory($data['category']);
        $product->setName($data['name']);

        foreach ($data["images"] as $url) {
            $image = new Image();
            $guid = $this->generateGuid();
            $path = $this->staticPath . $guid;
            $resource = fopen($path, 'w');
            $response = $client->get($url, [
                'sink' => $resource
            ]);
            $type = $response->getHeaderLine("Content-Type");
            if ($type == static::AVAILABLE_EXTENSION) {
                $raw = imagecreatefromjpeg($path);
                imagepng($raw, $path . static::ACCEPTED_EXTENSION);
                unlink($path);
            } else {
                rename($path, $path . static::ACCEPTED_EXTENSION);
            }
            $image->setUrl($this->staticUrl . $guid . static::ACCEPTED_EXTENSION);
            foreach ($service->getLabels($image->getUrl()) as $label) {
                $image->addLabel($label);
            }
            $product->addImage($image);
        }

        $this->getDoctrine()->getManager()->persist($product);
        $this->getDoctrine()->getManager()->flush();

        return $product;
    }

    /**
     * @return string
     */
    public function generateGuid()
    {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * @return string
     */
    public function getStaticPath()
    {
        return $this->staticPath;
    }

    /**
     * @param string $staticPath
     */
    public function setStaticPath($staticPath)
    {
        $this->staticPath = $staticPath;
    }

    /**
     * @return string
     */
    public function getStaticUrl()
    {
        return $this->staticUrl;
    }

    /**
     * @param string $staticUrl
     */
    public function setStaticUrl($staticUrl)
    {
        $this->staticUrl = $staticUrl;
    }
}