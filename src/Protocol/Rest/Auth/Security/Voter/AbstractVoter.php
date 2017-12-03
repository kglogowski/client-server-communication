<?php

namespace CSC\Protocol\Rest\Auth\Security\Voter;

use CSC\Component\Provider\EntityManagerProvider;
use CSC\Model\Interfaces\UserInterface;
use CSC\Server\Exception\ServerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

abstract class AbstractVoter extends Voter
{
    CONST VOTER_PERMISSION_TYPE = 'PERMISSION_TYPE';

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param EntityManagerProvider $entityManagerProvider
     */
    public function setEntityManager(EntityManagerProvider $entityManagerProvider)
    {
        $this->entityManager = $entityManagerProvider->getEntityManager();
    }
    /**
     * @param TokenInterface $token
     *
     * @return UserInterface
     *
     * @throws ServerException
     */
    protected function getUser(TokenInterface $token): UserInterface
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            throw new ServerException(ServerException::ERROR_TYPE_ACCESS_FORBIDDEN, 'Access forbidden');
        }

        return $user;
    }
}