<?php
/**
 * Description of PagofacilToken
 *
 * @author Johnatan Ayala 
 */
include_once './PagoFacilAES.php';
class PagoFacilToken {

    private $idUsuario = NULL;
    private $llaveEncriptacion = NULL;
    public static $modoProduccion = FALSE;
    //Endpoint´s
    private static $WS_ALTA;
    private static $WS_COBRO;
    private static $WS_BAJA;


    /**
     * Datos proporcionados por PagoFacil
     * @param string $strIdUsuario
     * @param string $strLlave 
     * @throws Exception
     */
    public function __construct($strIdUsuario, $strLlave) {
        try {
            if(empty($strIdUsuario) || empty($strLlave)){
                 throw new Exception('Faltan Datos idUsuario o ApiSecret');
            }

            if(!self::$modoProduccion){//Desarrollo
                self::$WS_ALTA = 'https://www.pagofacil.net/st/public/CobroToken/Altatoken';
                self::$WS_BAJA = 'https://www.pagofacil.net/st/public/CobroToken/Bajatoken';
                self::$WS_COBRO = 'https://www.pagofacil.net/st/public/CobroToken/Transacciontoken';
            }
            else {//Produccion
                self::$WS_ALTA = 'https://www.pagofacil.net/ws/public/CobroToken/Altatoken';
                self::$WS_BAJA = 'https://www.pagofacil.net/ws/public/CobroToken/Bajatoken';
                self::$WS_COBRO = 'https://www.pagofacil.net/ws/public/CobroToken/Transacciontoken';
            }
            $this->setIdUsuario($strIdUsuario);
            $this->setLlaveEncriptacion($strLlave);
        } catch (Exception $exc) {
            echo $exc->getMessage();  exit();
        }
    }
    

    /**
     * Genera una instancia y la retorna
     * Datos proporcionados por PagoFacil
     * @param string $strIdUsuario
     * @param string $strLlave 
     * @throws Exception
     */
    public static function obtenInstancia($strIdUsuario, $strLlave) {
            $instance = new PagofacilToken($strIdUsuario, $strLlave);
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
        return $this->peticionWS($params, self::$WS_ALTA);
    }
    /**
     * Realiza la peticion al WS para el Cobro con Token
     * @param array $params
     * @return string Retorna un array encriptado en cadena
     */
    public function cobroToken($params) {
        return $this->peticionWS($params, self::$WS_COBRO);
    }
    /**
     * Realiza la peticion al WS para el Baja de Token
     * @param array $params
     * @return string Retorna un array encriptado en cadena
     */
    public function bajaToken($params) {
        return $this->peticionWS($params, self::$WS_BAJA);
    }

    
    
    private function setIdUsuario($strIdUsuario) {
        $this->idUsuario = $strIdUsuario;
    }

    private function setLlaveEncriptacion($strLlave) {
        $this->llaveEncriptacion = $strLlave;
    }

    /**
     * Hace la peticion correspondiente al WS
     * @param array $data
     * @param string-url $endPoint
     * @return string respuesta del WS
     */
    private function peticionWS($data, $endPoint) {
        $strArray = json_encode($data);

        $datosEncrip = $this->encriptacion($strArray);
        $dataPost['idUsuario'] = $this->getIdUsuario();
        $dataPost['data'] = $datosEncrip;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endPoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * Encripta una cadena
     * @param string $strData
     * @return string Cadena encriptada
     */
    private function encriptacion($strData) {
        $enc = new PagoFacilAES($this->llaveEncriptacion);
        $datoEnc = $enc->encrypt($strData);
        return $datoEnc;
    }

    /**
     * Desencripta cadena
     * @param string $strEncriptado
     * @return string Cadena desencriptada
     */
    public function desencripta($strEncriptado) {
        $desenc = new PagoFacilAES($this->llaveEncriptacion);
        return $desenc->decrypt($strEncriptado);
    }
    
    
}
