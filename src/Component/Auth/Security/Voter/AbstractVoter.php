<?php

namespace CSC\Component\Auth\Security\Voter;

use CSC\Component\Doctrine\Provider\EntityManagerProvider;
use CSC\Model\Interfaces\RoleInterface;
use CSC\Model\Interfaces\UserInterface;
use CSC\Exception\ServerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class AbstractVoter
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractVoter extends Voter
{
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
     * @throws \Exception
     */
    protected function getUser(TokenInterface $token): UserInterface
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            $this->accessForbidden();
        }

        return $user;
    }

    /**
     * @param string        $permission
     * @param UserInterface $user
     *
     * @return bool
     * @throws \Exception
     */
    protected function checkPermission(string $permission, UserInterface $user): bool
    {
        /** @var RoleInterface[] $roles */
        $roles = $user->getRoles();

        foreach ($roles as $role) {
            foreach ($role->getPermissions() as $internalPermission) {
                if ($internalPermission->getId() === $permission) {
                    return true;
                }
            }
        }

        return $this->accessForbidden();
    }

    /**
     * @throws ServerException
     */
    private function accessForbidden()
    {
        throw new ServerException(ServerException::ERROR_TYPE_ACCESS_FORBIDDEN, 'Access forbidden');
    }
}