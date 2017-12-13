<?php

namespace CSC\Protocol\Rest\Component\Provider;

use CSC\Component\Provider\EntityManagerProvider;
use CSC\DependencyInjection\Configuration;
use CSC\Model\Interfaces\LinkToken;
use CSC\Protocol\Rest\Server\Provider\RestGetElementProvider;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;
use Doctrine\ORM\EntityManager;

/**
 * Class LinkTokenProvider
 */
class LinkTokenProvider
{
    /**
     * @var RestGetElementProvider
     */
    protected $provider;

    /**
     * @var string|null
     */
    protected $alias = null;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var int
     */
    protected $lifetime;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * LinkTokenProvider constructor.
     *
     * @param RestGetElementProvider $provider
     * @param array                  $config
     * @param EntityManagerProvider  $entityManagerProvider
     */
    public function __construct(
        array $config,
        RestGetElementProvider $provider,
        EntityManagerProvider $entityManagerProvider
    )
    {
        $this->lifetime = $config[Configuration::INDEX_LINK_TOKEN_LIFETIME];
        $this->provider = $provider;
        $this->entityManager = $entityManagerProvider->getEntityManager();
    }

    /**
     * @return LinkToken
     *
     * @throws ServerRequestException
     */
    public function provide(): LinkToken
    {
        /** @var LinkToken $token */
        $token = $this->provider->getElementByParameters(
            $this->getEntityName(),
            $this->getParameters(),
            $this->getAlias()
        );

        if (LinkToken::STATUS_ACTIVE !== $token->getStatus()) {
            throw new ServerRequestException(ServerException::ERROR_NO_ACTIVE);
        }

        $tokenTime = $token->getCreatedAt()->getTimestamp() + $this->lifetime < time();

        if ($tokenTime < time()) {
            $token->setStatus(LinkToken::STATUS_EXPIRED);
            $this->entityManager->flush($token);

            throw new ServerRequestException(ServerException::ERROR_EXPIRED);
        }

        return $token;
    }

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     *
     * @return LinkTokenProvider
     */
    public function setEntityName(string $entityName): LinkTokenProvider
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     *
     * @return LinkTokenProvider
     */
    public function setParameters(array $parameters): LinkTokenProvider
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return LinkTokenProvider
     */
    public function setAlias(string $alias): LinkTokenProvider
    {
        $this->alias = $alias;

        return $this;
    }
}