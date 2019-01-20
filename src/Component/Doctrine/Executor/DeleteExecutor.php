<?php

namespace CSC\Component\Doctrine\Executor;

/**
 * Class DeleteExecutor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class DeleteExecutor extends AbstractDoctrineExecutor
{
    /**
     * @param object $object
     *
     * @return bool
     */
    public function execute($object)
    {
        $this->getEntityManager()->remove($object);
        $this->getEntityManager()->flush();

        return true;
    }
}