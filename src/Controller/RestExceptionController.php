<?php

namespace CSC\Controller;

use CSC\Generator\RestExceptionResponseGenerator;
use FOS\RestBundle\Controller\ExceptionController as BaseController;
use FOS\RestBundle\Util\ExceptionValueMap;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use FOS\RestBundle\View\View;

/**
 * Class RestExceptionController
 */
class RestExceptionController extends BaseController
{
    /**
     * @var RestExceptionResponseGenerator
     */
    protected $generator;

    /**
     * ExceptionController constructor.
     *
     * @param RestExceptionResponseGenerator $generator
     * @param ViewHandlerInterface           $viewHandler
     * @param ExceptionValueMap              $exceptionCodes
     * @param mixed|null                     $showException
     */
    public function __construct(
        RestExceptionResponseGenerator $generator,
        ViewHandlerInterface $viewHandler,
        ExceptionValueMap $exceptionCodes,
        $showException = null
    )
    {
        $this->generator = $generator;

        parent::__construct($viewHandler, $exceptionCodes, $showException);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param Request                   $request
     * @param \Exception|\Throwable     $exception
     * @param DebugLoggerInterface|null $logger
     *
     * @throws \InvalidArgumentException
     *
     * @return View
     */
    public function showAction(Request $request, $exception, DebugLoggerInterface $logger = null): View
    {
        return $this->generator->generate($exception, $this->getStatusCode($exception));
    }
}
