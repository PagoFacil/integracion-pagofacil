<?php
/**
 * Description of encriptacionAES
 * Clase para encriptar y desencriptar cadenas de texto con formato AES 128
 * @author www.pagofacil.net
 */
class encriptacionAES {

    private $_key;

    /**
     * Inicilizar la clase con el idUsuario
     * @param string $key 'idUsuario' Dato proporcionado por PagoFacil al Cliente
     */
    public function __construct($key) {
        $this->_key = md5($key);
    }

    /**
     * Recibe la cadena a encriptar y la retorna encriptada
     * @param string $plaintext
     * @return string
     */
    public function encriptar($plaintext)
    {
        $plaintext = self::pkcs5_pad($plaintext, mcrypt_get_block_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_CBC));

        $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        $iv_size = mcrypt_enc_get_iv_size($cipher);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_RANDOM);
        //$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');

        if (mcrypt_generic_init($cipher, self::hextoBin($this->_key), $iv) != -1)
        {
            $cipherText = mcrypt_generic($cipher, $plaintext );
            mcrypt_generic_deinit($cipher);
            $b64ciphertext = base64_encode($iv.$cipherText);
            return $b64ciphertext;
        }

        return "";
    }

    /**
     * Recibe la cadena encriptada y la retorna desencriptada
     * @param string $encodedInitialData Cadena a desencriptar
     * @return string
     */
    public function desencriptar($encodedInitialData)
    {
        $encodedInitialData =  base64_decode($encodedInitialData);

        if (strlen($encodedInitialData) < 16) {
            $encodedInitialData = base64_encode($encodedInitialData);
            $encodedInitialData = $encodedInitialData . $encodedInitialData;
            $encodedInitialData =  base64_decode($encodedInitialData);
        }

        $iv = substr($encodedInitialData,0,16);

        if (strlen($iv) < 16) {
            $iv = str_pad($iv,  16, '0');
        }

        $encodedInitialData = mb_substr($encodedInitialData,16);

        $cypher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');

        if (mcrypt_generic_init($cypher, self::hexToBin($this->_key), $iv) != -1)
        {
            $decrypted = mdecrypt_generic($cypher, $encodedInitialData);
            mcrypt_generic_deinit($cypher);
            mcrypt_module_close($cypher);
            return self::pkcs5_unpad($decrypted);
        }

        return "";
    }


    private static function pkcs5_pad ($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }


    private static function pkcs5_unpad($text)
    {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        return substr($text, 0, -1 * $pad);
    }


    /**
     * This class uses by default hex2bin function, but it is only available since 5.4, because the current php version
     * is 5.2 this function was created with the purpose to replace the default function.
     *
     * @param $hex_string
     *
     * @return string
     */
    private static function hexToBin($hex_string)
    {
        $pos = 0;
        $result = '';
        while ($pos < strlen($hex_string)) {
            if (strpos(" \t\n\r", $hex_string{$pos}) !== FALSE) {
                $pos++;
            } else {
                $code = hexdec(substr($hex_string, $pos, 2));
                $pos = $pos + 2;
                $result .= chr($code);
            }
        }
        return $result;
    }


}//End Class
