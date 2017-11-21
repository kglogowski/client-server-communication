<?php

namespace CSC\Protocol\Rest\Executor;

use CSC\Executor\AbstractDoctrineExecutor;
use CSC\Protocol\Rest\Server\DataObject\RestSimpleDataObject;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Translate\TranslateDictionary;
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
     * @param object               $changesObject
     * @param RestSimpleDataObject $dataObject
     *
     * @return object
     */
    public function resolve($changesObject, RestSimpleDataObject $dataObject)
    {
        $object = $this->findObject($dataObject);

        $this->fillObject($object, $changesObject, json_decode($dataObject->getFields(), true));

        return $object;
    }

    /**
     * @param RestSimpleDataObject $dataObject
     *
     * @return object
     *
     * @throws ServerRequestException
     */
    public function findObject(RestSimpleDataObject $dataObject)
    {
        $repository = $this->getEntityManager()->getRepository($dataObject->getEntityName());

        $object = $repository->findOneBy($dataObject->getRoutingQuery());

        if (null === $object) {
            throw new ServerRequestException(
                ServerException::ERROR_TYPE_RESOURCE_NOT_FOUND,
                TranslateDictionary::KEY_PARAMETER_DOES_NOT_EXIST
            );
        }

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