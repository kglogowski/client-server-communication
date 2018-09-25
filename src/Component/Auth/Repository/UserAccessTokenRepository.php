<?php

namespace CSC\Auth\Repository;

use CSC\Component\Decorator\DateTime\PlainDateTimeDecorator;
use CSC\Model\Interfaces\UserInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class UserAccessTokenRepository
 */
abstract class UserAccessTokenRepository extends EntityRepository implements UserAccessTokenRepositoryInterface
{
    /**
     * @return QueryBuilder
     */
    public function getBaseQuery(): QueryBuilder
    {
        return $this->createQueryBuilder(self::ALIAS_ACCESS_TOKEN)
            ->select([self::ALIAS_ACCESS_TOKEN])
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    public function joinWithUser(QueryBuilder $queryBuilder)
    {
        $joinTable = sprintf('%s.user', self::ALIAS_ACCESS_TOKEN);
        $queryBuilder->join($joinTable, self::ALIAS_USER);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByUserAndValidDate(UserInterface $user)
    {
        $queryBuilder = $this->getBaseQuery();
        $this->joinWithUser($queryBuilder);

        $queryBuilder
            ->andWhere(sprintf('%s.%s = :username', self::ALIAS_USER, static::FIELD_USERNAME))
            ->setParameter(':username', $user->getUsername())
        ;

        $this->addValidationDateCondition($queryBuilder);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByTokenAndValidDate(string $token)
    {
        $queryBuilder = $this->getBaseQuery();

        $this->addTokenCondition($queryBuilder, $token);
        $this->addValidationDateCondition($queryBuilder);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    protected function addValidationDateCondition(QueryBuilder $queryBuilder): QueryBuilder
    {
        $dateTimeDecorator = new PlainDateTimeDecorator();
        $queryBuilder
            ->andWhere(sprintf('%s.validTo > :now', self::ALIAS_ACCESS_TOKEN))
            ->setParameter(':now', $dateTimeDecorator->format(new \DateTime()))
        ;

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $token
     *
     * @return QueryBuilder
     */
    protected function addTokenCondition(QueryBuilder $queryBuilder, string $token): QueryBuilder
    {
        $queryBuilder
            ->andWhere(sprintf('%s.%s = :token', self::ALIAS_ACCESS_TOKEN, static::FIELD_TOKEN))
            ->setParameter(':token', $token)
        ;

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $type
     *
     * @return QueryBuilder
     */
    protected function addTypeCondition(QueryBuilder $queryBuilder, string $type): QueryBuilder
    {
        $queryBuilder
            ->andWhere(sprintf('%s.%s = :type', self::ALIAS_ACCESS_TOKEN, static::FIELD_TYPE))
            ->setParameter(sprintf(':%s', static::FIELD_TYPE), $type)
        ;

        return $queryBuilder;
    }
}
