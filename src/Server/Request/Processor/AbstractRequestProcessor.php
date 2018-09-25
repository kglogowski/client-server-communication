<?php

namespace CSC\Server\Request\Processor;

use CSC\Component\Translate\TranslateDictionary;
use CSC\Server\DataObject\DataObject;
use CSC\Component\Provider\EntityManagerProvider;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ValidationServerRequestException;
use CSC\Server\Response\Model\ServerResponseModel;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use CSC\Component\Checker\SecurityChecker;
use Symfony\Bridge\Monolog\Logger;

/**
 * Class AbstractRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractRequestProcessor implements RequestProcessor
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Serializer
     */
    protected $serializer;

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
     * @var SecurityChecker
     */
    protected $securityChecker;

    /**
     * {@inheritdoc}
     */
    public function setupDataObject(DataObject $dataObject): DataObject
    {
        $dataObject->setHttpMethod($this->getCurrentRequest()->getMethod());

        return $dataObject;
    }

    /**
     * @param object         $model
     * @param DataObject $dataObject
     */
    public function validateExternalObject($model, DataObject $dataObject)
    {
        $this->validate($model, $dataObject->getValidationGroups(), $dataObject->supportedValidationGroups());
    }

    /**
     * @param DataObject $dataObject
     */
    public function validateDataObject(DataObject $dataObject)
    {
        $this->validate($dataObject, $dataObject->getValidationGroups(), $dataObject->supportedValidationGroups());
    }

    /**
     * @param EntityManagerProvider $entityManagerProvider
     */
    public function setEntityManager(EntityManagerProvider $entityManagerProvider)
    {
        $this->entityManager = $entityManagerProvider->getEntityManager();
    }

    /**
     * @param Serializer $serializer
     */
    public function setSerializer(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param string $modelString
     * @param string $classType
     *
     * @return mixed
     */
    public function deserialize(string $modelString, string $classType)
    {
        return $this->serializer->deserialize($modelString, $classType, 'json');
    }

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
            throw new \InvalidArgumentException(sprintf(
                'Model "%s" contains not supported validation groups',
                get_class($model)
            ));
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

    /**
     * @param SecurityChecker $securityChecker
     */
    public function setSecurityChecker(SecurityChecker $securityChecker)
    {
        $this->securityChecker = $securityChecker;
    }

    /**
     * @return SecurityChecker
     */
    protected function getSecurityChecker(): SecurityChecker
    {
        return $this->securityChecker;
    }

    /**
     * @param array               $voters
     * @param ServerResponseModel $object
     */
    protected function checkVoters(array $voters, ServerResponseModel $object)
    {
        foreach ($voters as $voter) {
            $this->checkVoter($voter, $object);
        }
    }

    /**
     * @param string              $voter
     * @param ServerResponseModel $object
     */
    protected function checkVoter(string $voter, ServerResponseModel $object)
    {
        $this->getSecurityChecker()->denyAccessUnlessGranted($voter, $object);
    }
}