<?php

namespace CSC\Component\Doctrine\Generator;

use CSC\Component\Doctrine\Provider\EntityManagerProvider;
use CSC\Model\Interfaces\LinkToken;
use CSC\Model\Interfaces\UserInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class LinkTokenGenerator
 */
class LinkTokenGenerator
{
    const SALT_TOKEN = '0f1bc7e9c9f808a6c2c3801e4222d5c4';

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $type;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @param bool $save
     *
     * @return LinkToken
     * @throws \Exception
     */
    public function generate(bool $save = true)
    {
        $entity = $this->getEntityName();

        /** @var LinkToken $token */
        $token = new $entity();

        if (!$token instanceof LinkToken) {
            throw new \LogicException(sprintf('Class "%s" must implement "%s"', $entity, LinkToken::class));
        }

        $token
            ->setStatus(LinkToken::STATUS_ACTIVE)
            ->setType($this->getType())
            ->setUser($this->getUser())
            ->setToken($this->getUniqueToken())
        ;

        if (true === $save) {
            $this->entityManager->persist($token);
            $this->entityManager->flush($token);
        }

        return $token;
    }

    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     *
     * @return LinkTokenGenerator
     */
    public function setEntityName(string $entityName): LinkTokenGenerator
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * @return string
     */
    protected function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return LinkTokenGenerator
     */
    public function setType(string $type): LinkTokenGenerator
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return UserInterface
     */
    protected function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     *
     * @return LinkTokenGenerator
     */
    public function setUser(UserInterface $user): LinkTokenGenerator
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param EntityManagerProvider $entityManagerProvider
     *
     * @return LinkTokenGenerator
     */
    public function setEntityManager(EntityManagerProvider $entityManagerProvider): LinkTokenGenerator
    {
        $this->entityManager = $entityManagerProvider->getEntityManager();

        return $this;
    }

    /**
     * @return string
     */
    protected function getUniqueToken()
    {
        $repository = $this->entityManager->getRepository($this->getEntityName());

        for ($i = 0; $i < 300; $i++) {
            $token = md5(crypt(microtime(), self::SALT_TOKEN));

            $linkToken = $repository->findOneBy(['token' => $token]);

            if (!$linkToken instanceof LinkToken) {
                return $token;
            }
        }

        throw new \LogicException('Cannot generate token');
    }
}