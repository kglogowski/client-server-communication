<?php

namespace CSC\Tests\Protocol\Rest\Auth\Generator;

use CSC\DependencyInjection\Configuration;
use CSC\Protocol\Rest\Auth\Security\Generator\JwtUserTokenGenerator;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use PHPUnit\Framework\TestCase;

/**
 * Class JwtUserTokenGeneratorTest
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class JwtUserTokenGeneratorTest extends TestCase
{
    public function testGenerateToken()
    {
        $config = [
            Configuration::INDEX_TOKEN_SECRET => 'secret',
            Configuration::INDEX_TOKEN_LIFETIME => 3600
        ];

        $generator = new JwtUserTokenGenerator($config);

        $generator->setData([
            'id' => 2,
            'login' => 'test'
        ]);

        $token = $generator->generateToken();

        $parsedToken = (new Parser())
            ->parse($token);

        $this->assertEquals($parsedToken->verify(new Sha512(), $config[Configuration::INDEX_TOKEN_SECRET]), true);

    }
}