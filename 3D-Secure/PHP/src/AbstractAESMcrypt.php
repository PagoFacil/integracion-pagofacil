<?php

namespace PagoFacil\ThreeDSecure;

use PagoFacil\ThreeDSecure\Interfaces\SynchronousCryptography;
use PagoFacil\ThreeDSecure\Traits\Pkcs5;

/**
 * Class AbstractAESMcrypt
 * @package PagoFacil\ThreeDSecure
 */
abstract class AbstractAESMcrypt implements SynchronousCryptography
{
    use Pkcs5;

    /** @var string $initializationVector  */
    private $initializationVector = null;
    /** @var string $secretKey  */
    private $secretKey = null;

    /**
     * AbstractAESMcrypt constructor.
     * @param string $key
     */
    public function __construct($key)
    {
        $this->secretKey = $key;
        $this->initializationVector = $key;
        $this->getBlockSize();
    }

    /**
     * @param string $plainText
     * @return string
     */
    public function encrypt($plainText)
    {
        $plainText = $this->pkcsPadding($plainText);
        $cipherText = mcrypt_encrypt(
            MCRYPT_RIJNDAEL_128,
            $this->secretKey,
            $plainText,
            MCRYPT_MODE_CBC,
            $this->initializationVector
        );

        return base64_encode($cipherText);
    }

    /**
     * @param string $encryptedText
     * @return string
     * @throws Exceptions\CipherTextException
     */
    public function decrypt($encryptedText)
    {
        $encryptedText = base64_decode($encryptedText);
        $encryptedText = mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $this->secretKey,
            $encryptedText,
            $this->initializationVector
        );

        return $this->pkcsUnPadding($encryptedText);
    }
}
