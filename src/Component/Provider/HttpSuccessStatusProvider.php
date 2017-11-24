<?php

namespace CSC\Component\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HttpSuccessStatusProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class HttpSuccessStatusProvider
{
    /**
     * @param string $httpMethod
     * @param bool   $isAsync
     * @return int
     */
    public function getSuccessStatus(string $httpMethod, bool $isAsync)
    {
        if (true === $isAsync) {
            $status = Response::HTTP_ACCEPTED;
        } else {

            switch ($httpMethod) {
                case Request::METHOD_POST:
                    $status = Response::HTTP_CREATED;
                    break;
                case Request::METHOD_DELETE:
                    $status = Response::HTTP_NO_CONTENT;
                    break;
                default:
                    $status = Response::HTTP_OK;
                    break;
            }

        }

        return $status;
    }
}