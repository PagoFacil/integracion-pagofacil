<?php
/**
 * Description of PagoFacilAES
 *
 * @author Johnatan Ayala
 */
class PagoFacilAES {

    private $_key;
    private $_iv;

    /**
     * Inicilizar la clase con llave de encriptacion
     * @param string $key 'idUsuario' Dato proporcionado por PagoFacil al Cliente
     */
    public function __construct($key) {
        $this->_key = $key;
        $this->_iv = $key;
    }

    /**
     * Encripta la cadena recibida como parametro
     * @param string $data Cadena a encriptar
     * @return string Cadena encriptada y codificada en Base64 
     */
    public function encrypt($data) {
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);//16
        if ($blockSize !== strlen($this->_key)) {
            $this->_key = hash('MD5', $this->_key, true);
        }
        if ($blockSize !== strlen($this->_iv)) {
            $this->_iv = hash('MD5', $this->_iv, true);
        }

        $padding = $blockSize - (strlen($data) % $blockSize);
        $data .= str_repeat(chr($padding), $padding);
        $encriptado = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->_key, $data, MCRYPT_MODE_CBC, $this->_iv);
        return base64_encode($encriptado);
    }


    /**
     * Desencripta la cadena recibida como parametro
     * @param string $dataEncrypt Cadena encriptada y codificada en Base64
     * @return boolean/string 
     */
    public function decrypt($dataEncrypt) {
        $data = base64_decode($dataEncrypt);
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);//16
        if ($blockSize !== strlen($this->_key)) {
            $this->_key = hash('MD5', $this->_key, true);
        }
        if ($blockSize !== strlen($this->_iv)) {
            $this->_iv = hash('MD5', $this->_iv, true);
        }
        $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->_key, $data, MCRYPT_MODE_CBC, $this->_iv);
        
        $pad = ord($data{strlen($data)-1});
        if ($pad > strlen($data)) {
            return false;
        }
        if (strspn($data, chr($pad), strlen($data) - $pad) != $pad) {
            return false;
        }
        return substr($data, 0, -1 * $pad);
    }


}//End Class
