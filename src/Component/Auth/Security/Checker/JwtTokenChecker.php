<?php

namespace CSC\Component\Auth\Security\Checker;

use CSC\DependencyInjection\Configuration;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha512;

/**
 * Class JwtTokenChecker
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class JwtTokenChecker implements TokenChecker
{
    /**
     * @var array
     */
    protected $config;

    /**
     * {@inheritdoc}
     */
    public function checkToken(string $token): bool
    {
        $parsedToken = (new Parser())
            ->parse($token)
        ;

        return $parsedToken->verify(new Sha512(), $this->config[Configuration::INDEX_TOKEN_SECRET]);
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}