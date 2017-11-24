<?php

namespace CSC\Protocol\Rest\Auth\Model;

use CSC\Model\Traits\CreatedAtTrait;
use CSC\Model\Traits\LastLoginAtTrait;
use CSC\Model\Traits\PasswordDateTrait;
use CSC\Model\Traits\UpdatedAtTrait;
use CSC\Model\Traits\UpdateTimestampsTrait;
use CSC\Protocol\Rest\Auth\Interfaces\TokenKeyAware;
use CSC\Protocol\Rest\Auth\Security\Encoder\PasswordEncoder;
use CSC\Server\Exception\ServerException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as JMS;

/**
 * Class User
 */
abstract class User implements AdvancedUserInterface, \Serializable, TokenKeyAware
{
    const TOKEN_KEY = 'TOKEN';

    use PasswordDateTrait;
    use LastLoginAtTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use UpdateTimestampsTrait;

    /**
     * ID
     *
     * @JMS\Type("integer")
     * @JMS\Groups({"Any"})
     *
     * @var int
     */
    protected $id;

    /**
     * Login
     *
     * @JMS\Type("string")
     * @JMS\Groups({"Auth", "Get"})
     *
     * @var string
     */
    protected $login;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\Accessor(setter="setPlainPassword", getter="getNullPassword")
     */
    protected $password;

    /**
     * @var string
     *
     * @JMS\Exclude()
     */
    protected $plainPassword;

    /**
     * @var string
     *
     * @JMS\Exclude()
     */
    protected $salt;

    /**
     * @var UserAccessToken
     */
    protected $accessToken;

    /**
     * Aktywny
     *
     * @var bool
     *
     * @JMS\Type("boolean")
     * @JMS\Groups({"Auth", "Get"})
     */
    protected $isActive;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->salt = $this->regenerateSalt();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getUsername();
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenKey(): string
    {
        return static::TOKEN_KEY;
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return $this->id ? true : false;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return UserInterface
     */
    public function setId(int $id): UserInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     *
     * @return UserInterface
     */
    public function setLogin(string $login): UserInterface
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $password
     *
     * @return UserInterface
     */
    public function setPassword(string $password): UserInterface
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string|null $plainPassword
     *
     * @return UserInterface
     */
    public function setPlainPassword($plainPassword): UserInterface
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @param string $salt
     *
     * @return UserInterface
     */
    public function setSalt(string $salt): UserInterface
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @param string $plainPassword
     *
     * @return UserInterface
     */
    public function setupUserPassword(string $plainPassword): UserInterface
    {
        $this->plainPassword = $plainPassword;
        $this->password = (new PasswordEncoder())->encodePassword($plainPassword, $this->getSalt());
        $this->setPasswordDate(new \DateTime());

        return $this;
    }

    /**
     * @return null
     */
    public function getNullPassword()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt ?? $this->regenerateSalt();
    }

    /**
     * @return string
     */
    public function regenerateSalt(): string
    {
        if (null !== $this->salt) {
            return $this->salt;
        }

        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);

        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return UserAccessToken
     */
    public function getAccessToken(): UserAccessToken
    {
        return $this->accessToken;
    }

    /**
     * @return bool
     */
    public function hasAccessToken(): bool
    {
        return $this->accessToken instanceof UserAccessToken;
    }

    /**
     * @param UserAccessToken|object $accessToken
     *
     * @return User
     *
     * @throws ServerException
     */
    public function setAccessToken($accessToken): User
    {
        if (!$accessToken instanceof UserAccessToken) {
            throw new ServerException(ServerException::ERROR_TYPE_INVALID_PARAMETER, 'Unexpected class of AccessToken', null, Response::HTTP_BAD_REQUEST);
        }

        $this->accessToken = $accessToken;

        return $this;
    }
}
