<?php
/**
 * Description of PagofacilToken
 *
 * @author www.pagofacil.net
 */
include_once 'encriptacionAES.php';
class PagofacilToken {
    //EndPoints
    private static $ALTATOKEN;
    private static $BAJATOKEN;
    private static $COBROTOKEN;

    private $endPoint = NULL;
    private $idUsuario = NULL;
    private $apiSecret = NULL;

    public static $productionMode = FALSE;

    /**
     * Datos proporcionados por PagoFacil
     * @param string $idUsuario
     * @param string $apiSecret 
     * @throws Exception
     */
    public function __construct($idUsuario, $apiSecret) {
        try {
            if(empty($idUsuario) || empty($apiSecret)){
                 throw new Exception('Faltan Datos idUsuario o ApiSecret');
            }

            if(!self::$productionMode){//Desarrollo
                self::$ALTATOKEN = 'http://pagofacil.dev/CobroToken/Altatoken?';
                self::$BAJATOKEN = 'http://pagofacil.dev/CobroToken/Bajatoken?';
                self::$COBROTOKEN = 'http://pagofacil.dev/CobroToken/Transacciontoken?';
            }
            else {//Produccion
                self::$ALTATOKEN = 'https://pagofacil.com/CobroToken/Altatoken?';
                self::$BAJATOKEN = 'https://pagofacil.com/CobroToken/Bajatoken?';
                self::$COBROTOKEN = 'https://pagofacil.com/CobroToken/Transacciontoken?';
            }
            $this->setIdUsuario($idUsuario);
            $this->setApiSecret($apiSecret);
        } catch (Exception $exc) {
            echo $exc->getMessage();
            exit();
        }
    }

    /**
     * Genera una instancia y la retorna
     * Datos proporcionados por PagoFacil
     * @param string $idUsuario
     * @param string $apiSecret 
     * @throws Exception
     */
    public static function obtenInstancia($idUsuario, $apiSecret) {
            $instance = new PagofacilToken($idUsuario, $apiSecret);
            return $instance;
    }

    /**
     * Activa el ambiente de produccion, por default esta desactivado (FALSE)
     * @param bool $param
     */
    public static function ambienteProduccionActivo($param) {
        self::$productionMode = $param;
    }

    /**
     * Realiza la peticion al WS para el Alta de Token
     * @param array $params
     * @return string Retorna un array encriptado en cadena
     */
    public function altaToken(array $params) {
        $this->endPoint = self::$ALTATOKEN;
        return $this->peticion($params);
    }
    /**
     * Realiza la peticion al WS para el Cobro con Token
     * @param array $params
     * @return string Retorna un array encriptado en cadena
     */
    public function cobroToken($params) {
        $this->endPoint = self::$COBROTOKEN;
        return $this->peticion($params);
    }
    /**
     * Realiza la peticion al WS para el Baja de Token
     * @param array $params
     * @return string Retorna un array encriptado en cadena
     */
    public function bajaToken($params) {
        $this->endPoint = self::$BAJATOKEN;
        return $this->peticion($params);
    }

    private function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    private function setApiSecret($apiSecret) {
        $this->apiSecret = $apiSecret;
    }

    public function getApiSecret() {
        return $this->apiSecret;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    private function peticion($data) {
        $strArray = json_encode($data);
        $datosEncrip = $this->encriptacion($strArray);
        $dataPost['idUsuario'] = $this->getIdUsuario();
        $dataPost['data'] = $datosEncrip;

        $url = $this->endPoint;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function encriptacion($strArray) {
        //Este dato corresponde al ApiSecret del usuario proporcionado por PagoFacil
        $enc = new encriptacionAES($this->getApiSecret());
        $datoEnc = $enc->encriptar($strArray);
        return $datoEnc;
    }

    public function desencripta($parametroEncriptado) {
        //$parametroEncriptado = json_decode($parametroEncriptado);
        $desenc = new encriptacionAES($this->getApiSecret());
        return $desenc->desencriptar($parametroEncriptado);
    }


}//End Class
