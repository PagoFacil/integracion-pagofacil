<?php

namespace PagoFacil\ThreeDSecure\Traits;

use PagoFacil\ThreeDSecure\Exceptions\CipherTextException;

trait Pkcs5
{
    /** @var int $blockSize */
    protected $blockSize = null;

    protected function getBlockSize()
    {
        $this->blockSize = mcrypt_get_block_size(
            MCRYPT_RIJNDAEL_128,
            MCRYPT_MODE_CBC
        );
    }

    /**
     * @param string $plainText
     * @return string
     */
    public function pkcsPadding($plainText)
    {
        $pad = $this->blockSize - (strlen($plainText) % $this->blockSize);

        return $plainText . str_repeat(chr($pad), $pad);
    }

    /**
     * @param string $encodeText
     * @return string
     * @throws CipherTextException
     */
    public function pkcsUnPadding($encodeText)
    {
        $pad = ord($encodeText{strlen($encodeText) - 1});

        switch (true) {
            case ($pad > strlen($encodeText)):
                throw CipherTextException::format();
            case (strspn($encodeText, chr($pad), strlen($encodeText) - $pad) != $pad):
                throw CipherTextException::format();
        }

        return substr($encodeText, 0, -1 * $pad);
    }
}
