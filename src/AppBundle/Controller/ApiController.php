<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25.08.2017
 * Time: 13:10
 */

namespace AppBundle\Controller;

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

        return new JsonResponse();
    }
}