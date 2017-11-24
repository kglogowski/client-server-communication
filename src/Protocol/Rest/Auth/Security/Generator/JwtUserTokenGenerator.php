<?php

namespace CSC\Protocol\Rest\Auth\Security\Generator;

use Lcobucci\JWT\Signer\Hmac\Sha512;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Lcobucci\JWT\Builder;

/**
 * Class JwtUserTokenGenerator
 */
class JwtUserTokenGenerator implements TokenGeneratorInterface
{
    /**
     * @var string
     */
    protected $jwtSecret;

    /**
     * @var string[]
     */
    protected $data;

    /**
     * @var int
     */
    protected $tokenLifetime;

    /**
     * JwtUserTokenGenerator constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->data = [];
        $this->jwtSecret = $config['token_secret'];
        $this->tokenLifetime = (int) $config['token_lifetime'];
    }

    /**
     * @param string[] $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function generateToken(): string
    {
        $signer = new Sha512();


        $token = (new Builder())->setIssuedAt(time());

        foreach ($this->data as $key => $value) {
            $token->set($key, $value);
        }

        $token->sign($signer, $this->jwtSecret);

        return $token->getToken();
    }
}
