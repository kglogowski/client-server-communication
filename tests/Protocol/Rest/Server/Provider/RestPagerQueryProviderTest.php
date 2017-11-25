<?php

namespace CSC\Tests\Protocol\Rest\Server\Provider;

use CSC\Component\Resolver\QueryParameterResolver;
use CSC\Component\Resolver\SortResolver;
use CSC\Model\PagerRequestModel;
use CSC\Tests\Model\ModelMock;
use CSC\Tests\Protocol\Rest\Server\DataObject\RestDataObjectPager;
use CSC\Tests\Repository\AbstractTestRepository;
use CSC\Tests\Repository\ModelMockRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class RestPagerQueryProviderTest
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPagerQueryProviderTest extends TestCase
{
    /**
     * testPager
     */
    public function testPager()
    {
        $dataObject = new RestDataObjectPager();
        $dataObject->setMethodName(AbstractTestRepository::TEST_METHOD_NAME);

        $pagerModel = new PagerRequestModel();
        $pagerModel
            ->setFilter($this->getTestFilter())
            ->setSort($this->getTestSort())
            ->setLimit(1)
            ->setPage(1)
            ->setRoutingParameters([])
            ->setEntityName($dataObject->getEntityName())
            ->setMethodName($dataObject->getMethodName())
        ;

        $pagerProvider = RestPagerQueryProviderTestFactory::create();

        try {
            $pagerProvider->generateQuery($pagerModel, $dataObject);
        } catch (\Exception $e) {

            $expectedMessage = sprintf('SELECT %s FROM %s %s WHERE %s.id IN (:id) AND %s.name = :name ORDER BY %s.id asc',
                ModelMockRepository::ALIAS,
                ModelMock::class,
                ModelMockRepository::ALIAS,
                ModelMockRepository::ALIAS,
                ModelMockRepository::ALIAS,
                ModelMockRepository::ALIAS
            );

            $this->assertEquals(
                $expectedMessage,
                $e->getMessage()
            );
        }
    }

    /**
     * @return array|null
     */
    public function getTestFilter(): ?array
    {
        return (new QueryParameterResolver())->resolveParams('[id{in}1],[name{eq}HelloWorld]');
    }

    /**
     * @return array|null
     */
    public function getTestSort(): ?array
    {
        return (new SortResolver())->resolveParams('id{ASC}');
    }
}