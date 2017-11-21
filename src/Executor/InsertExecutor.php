<?php

namespace CSC\Executor;

/**
 * Class InsertExecutor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class InsertExecutor extends AbstractDoctrineExecutor
{
    /**
     * @param object $object
     */
    public function execute($object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->getUnitOfWork()->commit($object);
    }
}