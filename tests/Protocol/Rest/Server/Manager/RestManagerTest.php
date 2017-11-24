<?php

namespace CSC\Tests\Protocol\Rest\Server\Manager;

use CSC\Protocol\Rest\Server\Manager\RestDataObjectManager;
use CSC\Protocol\Rest\Server\Response\Factory\RestDefaultResponseModelFactory;
use CSC\Component\Provider\HttpSuccessStatusProvider;
use CSC\Protocol\Rest\Server\Provider\RestGetElementProvider;
use CSC\Protocol\Rest\Server\Request\Processor\RestGetRequestProcessor;
use CSC\Protocol\Rest\Server\Response\Processor\RestResponseProcessor;
use CSC\Tests\Model\ModelMock;
use CSC\Tests\ORM\EntityManagerProviderMock;
use CSC\Tests\Protocol\Rest\Server\DataObject\RestDataObjectSimple;
use CSC\Tests\Repository\ModelMockRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DataObjectTest
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class DataObjectTest extends TestCase
{
    /**
     * testRestGetElementProvider
     */
    public function testRestGetElementProvider()
    {
        $dataObject = new RestDataObjectSimple(null, ['id' => 2, 'name' => 'test']);

        $restProvider = $this->getRestGetElementProvider();

        /** @var ModelMock $model */
        $model = $restProvider->getElement($dataObject);

        $this->assertInstanceOf(ModelMock::class, $model);
        $this->assertEquals(2, $model->getId());
        $this->assertEquals('test', $model->getName());
    }

    /**
     * testRestGetManager
     */
    public function testRestGetManager()
    {
        $dataObject = new RestDataObjectSimple(null, []);

        $requestProcessor = new RestGetRequestProcessor(
            $this->getRestGetElementProvider(),
            new RestDefaultResponseModelFactory()
        );

        $responseProcessor = new RestResponseProcessor(new HttpSuccessStatusProvider());

        $manager = new RestDataObjectManager($requestProcessor, $responseProcessor);

        $response = $manager->process($dataObject);

        /** @var ModelMock $model */
        $model = $dataObject->getResponseModel();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(ModelMock::class, $response->getData());
        $this->assertEquals($dataObject->getResponseModel(), $response->getData());
        $this->assertEquals(ModelMock::DEFAULT_ID, $model->getId());
        $this->assertEquals(ModelMock::DEFAULT_NAME, $model->getName());
    }

    /**
     * @return RestGetElementProvider
     */
    private function getRestGetElementProvider(): RestGetElementProvider
    {
        return new RestGetElementProvider((new EntityManagerProviderMock())->getEntityManagerProvider(
            new ModelMockRepository()
        ));
    }
}