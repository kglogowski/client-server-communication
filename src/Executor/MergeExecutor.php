<?php

namespace CSC\Executor;

use CSC\Model\ExternalAccessibleEntity;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Translate\TranslateDictionary;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class MergeExecutor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class MergeExecutor extends AbstractDoctrineExecutor
{
    /**
     * @param object $object
     * @param bool   $unique
     *
     * @return object
     *
     * @throws ServerRequestException
     */
    public function execute($object, bool $unique = false)
    {
        $className = get_class($object);

        $this->getEntityManager()->detach($object);
        try {
            $object = $this->getEntityManager()->merge($object);
        } catch (\Exception $exception) {
            throw new ServerRequestException(TranslateDictionary::KEY_MERGE_GENERAL_ERROR);
        }

        $unitOfWork = $this->getEntityManager()->getUnitOfWork();
        if (true === $unique && false === empty($unitOfWork->getOriginalEntityData($object))) {
            throw new ServerRequestException(TranslateDictionary::KEY_ID_ALREADY_EXISTS);
        }

        $metaData = $this->getEntityManager()->getClassMetadata($className);

        $this->refreshSubobjects($metaData, $object);

        $callbacks = $metaData->getLifecycleCallbacks(Events::prePersist);
        foreach ($callbacks as $callback) {
            $object->$callback();
        }

        $insertions = $unitOfWork->getScheduledEntityInsertions();
        foreach ($insertions as $insertion) {
            if (!$insertion instanceof $className && !$insertion instanceof ExternalAccessibleEntity) {
                throw new \LogicException(sprintf(
                    'Item "%s" must implement "%s"',
                    $className,
                    ExternalAccessibleEntity::class
                ));
            }
        }

        return $object;
    }

    /**
     * @param ClassMetadata $metaData
     * @param object        $object
     *
     * @throws ServerRequestException
     * @throws \TypeError
     */
    private function refreshSubobjects(ClassMetadata $metaData, $object)
    {
        $associationMappings = array_filter(
            $metaData->associationMappings,
            function ($assoc) {
                return $assoc['isCascadeRefresh'];
            }
        );

        foreach ($associationMappings as $assoc) {
            if (ClassMetadata::MANY_TO_MANY === $assoc['type']) {
                $relatedEntities = $metaData->reflFields[$assoc['fieldName']]->getValue($object);

                foreach ($relatedEntities as $relatedEntity) {
                    $this->refresh($relatedEntity);
                }
            } else {
                $relatedEntity = $metaData->reflFields[$assoc['fieldName']]->getValue($object);

                $this->refresh($relatedEntity);
            }
        }
    }

    /**
     * @param $relatedEntity
     *
     * @throws ServerRequestException
     * @throws \TypeError
     */
    private function refresh($relatedEntity)
    {
        if (null === $relatedEntity) {
            return;
        }

        if (!$relatedEntity instanceof ExternalAccessibleEntity) {
            throw new \LogicException(sprintf(
                'Item "%s" must implement "%s"',
                get_class($relatedEntity),
                ExternalAccessibleEntity::class
            ));
        }

        try {
            $id = $relatedEntity->getId();

            if (null !== $id) {
                $this->getEntityManager()->refresh($relatedEntity);
            }
        } catch (\TypeError $e) {
            $relatedReflection = new \ReflectionObject($relatedEntity);
            $idProperty = $relatedReflection->getProperty('id');

            $idProperty->setAccessible(true);

            if (null !== $idProperty->getValue($relatedEntity)) {
                throw $e;
            }
        }
    }
}