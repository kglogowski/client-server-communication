<?php

namespace CSC\Protocol\Rest\Server\Provider;

use CSC\Model\Interfaces\UserInterface;
use CSC\Protocol\Rest\Auth\Interfaces\GuardUserAware;
use CSC\Protocol\Rest\Component\Builder\PagerQueryBuilderAware;
use CSC\Protocol\Rest\Component\Builder\RestPagerQueryBuilder;
use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Model\PagerRequestModel;
use CSC\Component\Provider\UserProvider;
use CSC\Component\Provider\EntityManagerProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

/**
 * Class RestPagerQueryProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPagerQueryProvider implements RestQueryProvider
{
    const
        METHODS_DATA_OBJECT_CONFIGURATION_INDEX = 'methods',
        FILTER_DATA_OBJECT_CONFIGURATION_INDEX = 'filter',
        SORT_DATA_OBJECT_CONFIGURATION_INDEX = 'sort'
    ;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var RestPagerQueryBuilder
     */
    protected $pagerOrderedQueryBuilder;

    /**
     * @var array
     */
    protected $userProvider;

    /**
     * @var array
     */
    protected $pagerDataObjectConfiguration;

    /**
     * PagerOrderedQueryProvider constructor.
     *
     * @param EntityManagerProvider $entityManagerProvider
     * @param RestPagerQueryBuilder $pagerOrderedQueryBuilder
     * @param UserProvider          $userProvider
     * @param array                 $pagerDataObjectConfiguration
     */
    public function __construct(
        EntityManagerProvider $entityManagerProvider,
        RestPagerQueryBuilder $pagerOrderedQueryBuilder,
        UserProvider $userProvider,
        array $pagerDataObjectConfiguration
    )
    {
        $this->em = $entityManagerProvider->getEntityManager();
        $this->pagerOrderedQueryBuilder = $pagerOrderedQueryBuilder;
        $this->userProvider = $userProvider;
        $this->pagerDataObjectConfiguration = $pagerDataObjectConfiguration;
    }

    /**
     * @param PagerRequestModel   $requestModel
     * @param RestPagerDataObject $dataObject
     *
     * @return Query
     *
     * @throws \Exception
     */
    public function generateQuery(PagerRequestModel $requestModel, RestPagerDataObject $dataObject): Query
    {
        $methodName = $dataObject->getMethodName();
        $entityName = $requestModel->getEntityName();

        $repository = $this->em->getRepository($entityName);

        if (!$repository instanceof PagerQueryBuilderAware) {
            throw new \LogicException(sprintf('"%s" must implement PagerQueryBuilderAware', get_class($repository)));
        }

        $repository->setPagerQueryBuilder($this->pagerOrderedQueryBuilder);

        if ($repository instanceof GuardUserAware) {
            $user = $this->userProvider->getUser();

            if ($user instanceof UserInterface) {
                $repository->setUser($this->userProvider->getUser());
            }
        }

        $dataObjectClass = get_class($dataObject);

        if (!array_key_exists($dataObjectClass, $this->pagerDataObjectConfiguration)) {
            throw new \LogicException(sprintf('Undefined data object configuration: %s', $dataObjectClass));
        }

        $methodsConfiguration = $this->pagerDataObjectConfiguration[$dataObjectClass][self::METHODS_DATA_OBJECT_CONFIGURATION_INDEX];

        if (!array_key_exists($methodName, $methodsConfiguration)) {
            throw new \LogicException(sprintf('Undefined method (%s) for configuration data object: %s', $methodName, $dataObjectClass));
        }

        $methodConfiguration = $methodsConfiguration[$methodName];

        $this->pagerOrderedQueryBuilder->setSupportFilterParameters($methodConfiguration[self::FILTER_DATA_OBJECT_CONFIGURATION_INDEX]);
        $this->pagerOrderedQueryBuilder->setSupportSortParameters($methodConfiguration[self::SORT_DATA_OBJECT_CONFIGURATION_INDEX]);

        return $repository->$methodName($requestModel);
    }
}