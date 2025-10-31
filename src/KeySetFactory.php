<?php

declare(strict_types=1);

namespace Ethantechnology\JWK;

/**
 * @author  Juha Jantunen <info@ethantech.com>
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @see    https://github.com/Ethantechnology/php-jwk
 * @since 1.0.0
 */
class KeySetFactory
{
    /**
     * @var KeyFactory
     */
    private $keyFactory;

    /**
     * KeySet constructor.
     */
    public function __construct()
    {
        $this->setKeyFactory(new KeyFactory());
    }

    /**
     * @since 1.0.0
     */
    public function setKeyFactory(KeyFactory $keyFactory): self
    {
        $this->keyFactory = $keyFactory;

        return $this;
    }

    /**
     * @since 1.0.0
     */
    public function createFromJSON(string $json): KeySet
    {
        $assoc = \json_decode($json, true);

        $instance = new KeySet();

        if (! is_array($assoc) || ! array_key_exists('keys', $assoc)) {
            return $instance;
        }

        foreach ($assoc['keys'] as $keyData) {
            $key = $this->keyFactory->createFromJson(\json_encode($keyData));

            $instance->addKey($key);
        }

        return $instance;
    }
}
