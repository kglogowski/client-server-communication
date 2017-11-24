<?php

namespace CSC\Server\Request\Processor;

use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ValidationServerRequestException;
use CSC\Component\Translate\TranslateDictionary;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractServerRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractServerRequestProcessor
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return Request
     */
    protected function getCurrentRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param object $model
     * @param array  $validationGroups
     * @param array  $supportedValidationGroups
     *
     * @throws ValidationServerRequestException
     */
    protected function validate($model, array $validationGroups = [], array $supportedValidationGroups = [])
    {
        $intersectValidationGroups = array_intersect($validationGroups, $supportedValidationGroups);

        if (count($validationGroups) !== count($intersectValidationGroups)) {
            throw new \InvalidArgumentException('Model "%s" contains not supported validation groups', get_class($model));
        }

        $validateResponse = $this->validator->validate($model, null, $validationGroups);

        if (0 < $validateResponse->count()) {
            throw new ValidationServerRequestException(
                ServerException::ERROR_TYPE_VALIDATION_FAILED,
                TranslateDictionary::KEY_VALIDATION_ERROR,
                $validateResponse
            );
        }
    }

    /**
     * @param Logger $logger
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }
}