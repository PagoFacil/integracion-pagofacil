<?php

namespace PagoFacil\ThreeDSecure\Traits;

use PagoFacil\ThreeDSecure\Exceptions\CipherTextException;

trait Pkcs7
{
    /** @var  integer $blockSize the block size of the cipher in bytes*/
    protected $blockSize;

    protected function getBlockSize()
    {
    }

    /**
     * Right-pads the data string with 1 to n bytes according to PKCS#7,
     * where n is the block size.
     * The size of the result is x times n, where x is at least 1.
     *
     * The version of PKCS#7 padding used is the one defined in RFC 5652 chapter 6.3.
     * This padding is identical to PKCS#5 padding for 8 byte block ciphers such as DES.
     *
     * @param string $plainText the plaintext encoded as a string containing bytes
     * @return string the padded plaintext
     */
    public function pkcsPadding($plainText)
    {
    }

    /**
     * @param string $encodeText
     * @return string
     */
    /**
     * Validates and unpads the padded plaintext according to PKCS#7.
     * The resulting plaintext will be 1 to n bytes smaller depending on the amount of padding,
     * where n is the block size.
     *
     * The user is required to make sure that plaintext and padding oracles do not apply,
     * for instance by providing integrity and authenticity to the IV and ciphertext using a HMAC.
     *
     * Note that errors during uppadding may occur if the integrity of the ciphertext
     * is not validated or if the key is incorrect. A wrong key, IV or ciphertext may all
     * lead to errors within this method.
     *
     * The version of PKCS#7 padding used is the one defined in RFC 5652 chapter 6.3.
     * This padding is identical to PKCS#5 padding for 8 byte block ciphers such as DES.
     *
     * @param string $encodeText padded the padded plaintext encoded as a string containing bytes
     * @return string the unpadded plaintext
     * @throws CipherTextException if the unpadding failed
     */
    public function pkcsUnPadding($encodeText)
    {
    }
}
