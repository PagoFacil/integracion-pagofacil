<?php

namespace PagoFacil\ThreeDSecure\Interfaces;

use PagoFacil\ThreeDSecure\Exceptions\CipherTextException;

interface SynchronousCryptography
{
    /**
     * @param string $plainText
     * @return string
     */
    public function encrypt($plainText);

    /**
     * @param string $encryptedText
     * @return string
     */
    public function decrypt($encryptedText);

    /**
     * @param string $plainText
     * @return string
     * @throws CipherTextException
     */
    public function pkcsPadding($plainText);

    /**
     * @param string $encodeText
     * @return string
     * @throws CipherTextException
     */
    public function pkcsUnPadding($encodeText);
}
