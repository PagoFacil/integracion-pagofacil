<?php
//Ejemplo de implementacion para consumo de servicios Tokenizados de PagoFacil
include_once '../source/PagoFacilToken.php';

//Datos Proporcionados por PagoFacil
$idUsuario = '';
$apiSecret = '';
$idSucursal = '';

//Activacion de los endpoint's del ambiente de produccion, por default FALSE
//---PagofacilToken::ambienteProduccionActivo(TRUE);

//Se puede instanciar de 2 formas la Clase PagofacilToken, para ambos casos deberas
//de proporcionar tus credenciales, que te proporciona PagoFacil
//---1)
$pf = PagofacilToken::obtenInstancia($idUsuario, $apiSecret);
//---2)
//$pf = new PagofacilToken($idUsuario, $apiSecret);


////////////////////////
//     Alta token     //
////////////////////////
$data = array(
    'idSucursal' => $idSucursal,
    'idUsuario' => $idUsuario, 'nombre' => 'Makaria',
    'apellidos' => 'Borjez Perez', 'calleyNumero' => 'Av de las Tunas No 19',
    'colonia' => 'Los arboles', 'municipio' => 'Milpa Alta', 'estado' => 'CDMX',
    'cp' => '11000', 'telefono' => '6789543210',
    'celular' => '5565434504', 'email' => 'makaria@mail.com',
    'numeroTarjeta' => '4111111111111111', 'cvt' => '314',
    'mesExpiracion' => '12', 'anyoExpiracion' => '21',
);

//$resp = $pf->altaToken($data);
//echo 'Resp. AltaToken:<br/>'.$resp;
//echo '<br/>';
//$respDesencrip = $pf->desencripta($resp);
//echo 'Decod:<br/>'.$respDesencrip;

////////////////////////
//     Cobro token    //
////////////////////////
$dataCobro = array('idSucursal' => $idSucursal, 
        'idUsuario' => 'f541b3f11f0f9b3fb33499684f22f6d711f2af58',
    'token' => '', 'monto' => 999.99, 'idPedido' => 'Venta-197',
    'param1' => 'Probando Param one-one');

//$resp = $pf->cobroToken($dataCobro);
//echo 'Resp. CobroToken:<br/>'.$resp;
//echo '<br/>';
//$respDesencrip = $pf->desencripta($resp);
//echo 'Decod:<br/>'.$respDesencrip;


////////////////////////
//   Baja de Token    //
////////////////////////
$dataBaja['idSucursal'] = $idSucursal;
$dataBaja['idUsuario'] = $idUsuario;
$dataBaja['token'] = '';
$dataBaja['autorizacion'] = '';

$resp = $pf->bajaToken($dataBaja);
echo 'Resp. BajaToken:<br/>'.$resp;
echo '<br/>';
$respDesencrip = $pf->desencripta($resp);
echo 'Decod:<br/>'.$respDesencrip;
