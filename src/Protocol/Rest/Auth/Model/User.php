<?php

namespace CSC\Protocol\Rest\Auth\Model;

use CSC\Model\Interfaces\LinkToken;
use CSC\Model\Interfaces\RoleInterface;
use CSC\Model\Interfaces\UserInterface;
use CSC\Model\Traits\CreatedAtTrait;
use CSC\Model\Traits\LastLoginAtTrait;
use CSC\Model\Traits\PasswordDateTrait;
use CSC\Model\Traits\UpdatedAtTrait;
use CSC\Model\Traits\UpdateTimestampsTrait;
use CSC\Protocol\Rest\Auth\Security\Encoder\PasswordEncoder;
use CSC\Server\Exception\ServerException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\Annotation as JMS;

/**
 * Class User
 */
abstract class User implements UserInterface
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
     * @JMS\Groups({"Any"})
     *
     * @var string
     */
    protected $login;

    /**
     * Email
     *
     * @JMS\Type("string")
     * @JMS\Groups({"Any"})
     *
     * @var string
     */
    protected $email;

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
     * @JMS\Groups({"Any"})
     */
    protected $isActive;

    /**
     * @var string
     *
     * @JMS\Type("boolean")
     * @JMS\Groups({"Any"})
     */
    protected $status;

    /**
     * @JMS\Type("ArrayCollection")
     *
     * @var Collection|null
     */
    protected $linkTokens;

    /**
     * @JMS\Type("ArrayCollection")
     *
     * @var Collection|null
     */
    protected $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->linkTokens = new ArrayCollection();
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
     * @return int|null
     */
    public function getId(): ?int
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return UserInterface
     */
    public function setEmail(string $email): UserInterface
    {
        $this->email = $email;

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

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return UserInterface
     */
    public function setStatus(?string $status): UserInterface
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return LinkToken[]|Collection
     */
    public function getLinkTokens(): Collection
    {
        return $this->linkTokens;
    }

    /**
     * @param LinkToken[]|Collection $linkTokens
     *
     * @return UserInterface
     */
    public function setLinkTokens(Collection $linkTokens): UserInterface
    {
        $this->linkTokens = $linkTokens;

        return $this;
    }

    /**
     * @param LinkToken $linkToken
     *
     * @return UserInterface
     */
    public function addLinkToken(LinkToken $linkToken): UserInterface
    {
        $this->linkTokens->add($linkToken);

        return $this;
    }

    /**
     * @param LinkToken $linkToken
     *
     * @return UserInterface
     */
    public function removeLinkToken(LinkToken $linkToken): UserInterface
    {
        $this->linkTokens->removeElement($linkToken);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->login,
            $this->password,
            $this->salt,
            $this->isActive,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->login,
            $this->password,
            $this->salt,
            $this->isActive
        ) = unserialize($serialized);
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->login;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        // TODO: Implement isAccountNonExpired() method.
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        // TODO: Implement isAccountNonLocked() method.
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        // TODO: Implement isCredentialsNonExpired() method.
        return true;
    }

    public function isEnabled()
    {
        return self::STATUS_ACTIVE === $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this;
    }

    /**
     * @return RoleInterface[]
     */
    public function getRoles(): array
    {
        return $this->roles->toArray();
    }

    /**
     * @param Collection $roles
     *
     * @return UserInterface
     */
    public function setRoles(Collection $roles): UserInterface
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param RoleInterface $role
     *
     * @return UserInterface
     */
    public function addRole(RoleInterface $role): UserInterface
    {
        $this->roles->add($role);

        return $this;
    }

    /**
     * @param RoleInterface $role
     *
     * @return UserInterface
     */
    public function removeRole(RoleInterface $role): UserInterface
    {
        $this->roles->removeElement($role);

        return $this;
    }
}
