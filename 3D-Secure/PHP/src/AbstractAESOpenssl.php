<?php

namespace PagoFacil\ThreeDSecure;

use PagoFacil\ThreeDSecure\Exceptions\CipherTextException;
use PagoFacil\ThreeDSecure\Interfaces\SynchronousCryptography;
use PagoFacil\ThreeDSecure\Traits\Pkcs5;

class AbstractAESOpenssl implements SynchronousCryptography
{
    /** @var string $method */
    private $method;
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
        $this->method = 'AES-128-CBC';
        $this->getBlockSize();
    }

    protected function getBlockSize()
    {
        $this->blockSize = openssl_cipher_iv_length($this->method);
    }

    /**
     * @param string $plainText
     * @return string
     */
    public function encrypt($plainText)
    {
        $plainText = $this->pkcsPadding($plainText);
        $cipherText = openssl_encrypt(
            $plainText,
            $this->method,
            $this->secretKey,
            OPENSSL_RAW_DATA,
            $this->initializationVector
        );

        return base64_encode($cipherText);
    }

    /**
     * @param string $encryptedText
     * @return string
     * @throws CipherTextException
     */
    public function decrypt($encryptedText)
    {
        $encryptedText = base64_decode($encryptedText);
        $this->initializationVector = substr($encryptedText, 0, $this->blockSize);
        $data = substr($encryptedText, $this->blockSize);
        $plainText = openssl_decrypt(
            $data,
            'AES-128-CBC',
            $this->secretKey,
            OPENSSL_RAW_DATA,
            $this->initializationVector
        );
        return $this->pkcsUnPadding($plainText);
    }
}
