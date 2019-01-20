<?php

namespace CSC\Controller;

use CSC\Server\Response\Generator\ExceptionResponseGenerator;
use FOS\RestBundle\Controller\ExceptionController as BaseController;
use FOS\RestBundle\Util\ExceptionValueMap;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use FOS\RestBundle\View\View;

/**
 * Class ExceptionController
 */
class ExceptionController extends BaseController
{
    /**
     * @var ExceptionResponseGenerator
     */
    protected $generator;

    /**
     * ExceptionController constructor.
     *
     * @param ExceptionResponseGenerator $generator
     * @param ViewHandlerInterface       $viewHandler
     * @param ExceptionValueMap          $exceptionCodes
     * @param mixed|null                 $showException
     */
    public function __construct(
        ExceptionResponseGenerator $generator,
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
