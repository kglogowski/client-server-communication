<?php

namespace CSC\Component\Rest\Response\Generator;

use CSC\Exception\Normalizer\ExceptionNormalizerInterface;
use CSC\Exception\Normalizer\Normalizer;
use FOS\RestBundle\View\View;

/**
 * Class ExceptionResponseGenerator
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class ExceptionResponseGenerator
{
    /**
     * @var ExceptionNormalizerInterface
     */
    public $normalizer;

    /**
     * ExceptionResponseGenerator constructor.
     *
     * @param ExceptionNormalizerInterface $normalizer
     */
    public function __construct(ExceptionNormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @param \Exception $exception
     * @param string|int $status
     *
     * @return View
     */
    public function generate(\Exception $exception, $status): View
    {
        if ($exception instanceof Normalizer) {
            $normalizedException =  $exception->normalize();
        } else {
            $normalizedException = $this->normalizer->normalize($exception);
        }

        $response = new View($normalizedException, $status);

        $data = $response->getData();
        $data['status'] = $status;

        return $response->setData($data);
    }
}