<?php

declare(strict_types=1);

namespace Ethantechnology\JWK;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Math\BigInteger;
use Ethantechnology\JWK\Key\KeyInterface;
use Ethantechnology\JWK\Key\Rsa as RsaKey;
use Ethantechnology\JWK\Util\Base64UrlConverter;
use Ethantechnology\JWK\Util\Base64UrlConverterInterface;

/**
 * @author  Juha Jantunen <info@ethantech.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @see    https://github.com/Ethantechnology/php-jwk
 * @since 1.0.0
 */
class KeyConverter
{
    /**
     * @var Base64UrlConverterInterface
     */
    private $base64UrlConverter;

    /**
     * KeyConverter constructor.
     */
    public function __construct()
    {
        $this->base64UrlConverter = new Base64UrlConverter();
    }

    /**
     * @since 1.0.0
     */
    public function keyToPem(KeyInterface $key): string
    {
        if (!$key instanceof RsaKey) {
            throw new \InvalidArgumentException();
        }

        $modulus = $this->base64UrlConverter->decode($key->getModulus(), true);

        $rsa = PublicKeyLoader::load([
            'e' => new BigInteger(\base64_decode($key->getExponent(), true), 256),
            'n' => new BigInteger($modulus, 256),
        ]);

        return $rsa->__toString();
    }
}
