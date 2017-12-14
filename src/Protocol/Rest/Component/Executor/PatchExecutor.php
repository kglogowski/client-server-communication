<?php

namespace CSC\Protocol\Rest\Component\Executor;

use CSC\Component\Executor\AbstractDoctrineExecutor;
use CSC\Component\Provider\EntityManagerProvider;
use CSC\Protocol\Rest\Server\DataObject\RestSimpleDataObject;
use CSC\Protocol\Rest\Server\Provider\RestGetElementProvider;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Component\Translate\TranslateDictionary;
use CSC\Server\Response\Model\ServerResponseModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Util\Inflector;

/**
 * Class PatchExecutor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PatchExecutor extends AbstractDoctrineExecutor
{
    /**
     * @var RestGetElementProvider
     */
    protected $provider;

    /**
     * PatchExecutor constructor.
     *
     * @param EntityManagerProvider  $entityManagerProvider
     * @param RestGetElementProvider $provider
     */
    public function __construct(EntityManagerProvider $entityManagerProvider, RestGetElementProvider $provider)
    {
        $this->provider = $provider;

        parent::__construct($entityManagerProvider);
    }

    /**
     * @param object               $changesObject
     * @param RestSimpleDataObject $dataObject
     *
     * @return ServerResponseModel
     */
    public function resolve($changesObject, RestSimpleDataObject $dataObject): ServerResponseModel
    {
        $object = $this->provider->getElement($dataObject);

        $this->fillObject($object, $changesObject, json_decode($dataObject->getFields(), true));

        return $object;
    }

    /**
     * @param object $object
     * @param bool   $flushAll
     */
    public function execute($object, bool $flushAll = false)
    {
        $this->getEntityManager()->persist($object);

        if (true === $flushAll) {
            $this->getEntityManager()->flush();
        } else {
            $this->getEntityManager()->getUnitOfWork()->commit($object);
        }
    }

    /**
     * @param mixed $object
     * @param mixed $changesObject
     * @param array $keyValueMap
     *
     * @throws ServerRequestException
     */
    public function fillObject($object, $changesObject, array $keyValueMap)
    {
        foreach ($keyValueMap as $key => $value) {
            $setMethodName = sprintf('set%s', Inflector::classify($key));
            $getMethodName = sprintf('get%s', Inflector::classify($key));

            if (false === method_exists($object, $setMethodName)) {
                continue;
            }

            if ($this->isAvailableToRecursive($changesObject->$getMethodName(), $value)) {
                $this->fillObject($object->$getMethodName(), $changesObject->$getMethodName(), $value);
            } else {
                $object->$setMethodName($changesObject->$getMethodName());
            }
        }
    }

    /**
     * @param $element
     * @param $value
     *
     * @return bool
     */
    private function isAvailableToRecursive($element, $value): bool
    {
        return is_object($element) && !($element instanceof Collection) && is_array($value);
    }
}