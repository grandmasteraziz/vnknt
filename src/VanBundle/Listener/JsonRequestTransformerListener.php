<?php

/**
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VanBundle\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class JsonRequestTransformerListener
 *
 * @package AdminBundle\Listener
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class JsonRequestTransformerListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $content = $request->getContent();

        /**
         * Empty
         */
        if (empty($content)) {
            return;
        }

        /**
         * Check Json Request
         */
        if (!$this->checkRequestType($request)) {
            return;
        }

        /**
         * Transform JSON Data
         */
        if (!$this->transformJsonBody($content, $request)) {
            $response = Response::create('Invalid JSON Request.', 400);
            $event->setResponse($response);
        }
    }

    /**
     * Check JSON Request
     *
     * @param Request $request
     * @param string $type
     * @return bool
     */
    private function checkRequestType(Request $request, $type = 'json')
    {
        return $type === $request->getContentType();
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function transformJsonBody($content, Request $request)
    {
        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        if ($data === null) {
            return true;
        }
        $request->request->replace($data);
        return true;
    }
}
