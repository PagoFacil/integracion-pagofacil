<?php

namespace PagoFacil\ThreeDSecure\Interfaces;

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
     */
    public function pkcsPadding($plainText);

    /**
     * @param string $encodeText
     * @return string
     */
    public function pkcsUnPadding($encodeText);
}
