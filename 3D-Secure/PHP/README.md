Elemplos
========

# 3D secure
## javascript

Esta implementación no depende de de librerias de terceros, pero es necesario que el navegador
 soporte las especificaciones actuales de emacscript y web API.

```html
<script src='https://pagofacil.net/resources/js/pagoFacil3ds.js' type='text/javascript' ></script> 
	<form method="POST" id="3ds-form" name="3ds-form">
	<input name="idSucursal" type="hidden" value="ApiKeySucursal" />
	<input name="idUsuario" type="hidden" value="ApiKeyUsuario" />
	<input name="idPedido" type="hidden" value="X" />
	<input name="idServicio" type="hidden" value="3" />
	Nombre: <input id="nombre" name="nombre" type="text" value="" />
	Apellidos: <input id="apellidos" name="apellidos" type="text" value="" />
	Email: <input id="email" name="email" type="text" value="" />
	Calle y Num.: <input id="calleyNumero" name="calleyNumero" type="text" value="" />
	CP: <input id="cp" name="cp" type="text" value="" />
	Colonia: <input id="colonia" name="colonia" type="text" value="" />
	Municipio: <input id="municipio" name="municipio" type="text" value="" />
	Estado: <input id="estado" name="estado" type="text" value="" />
	Pais: <input id="pais" name="pais" type="text" value="" />
	Telefono: <input id="telefono" name="telefono" type="text" value="" />
	Celular: <input id="celular" name="celular" type="text" value="" />
	No. Tarjeta: <input id="numeroTarjeta" name="numeroTarjeta" type="text" value="" />
	Mes Exp. <input id="mesExpiracion" name="mesExpiracion" type="text" value="" />
	Año Exp. <input id="anyoExpiracion" name="anyoExpiracion" type="text" value="" />
	CVV: <input id="cvt" name="cvt" type="text" value="" />
	Monto: <input id="monto" name="monto" type="text" value="" />
	Plan: <input id="plan" name="plan" type="text" value="" />
	Menualidades: <input id="mensualidades" name="mensualidades" type="text" value="" />
	Param1: <input id="param1" name="param1" type="hidden" value="" />
	Param2: <input id="param2" name="param2" type="hidden" value="" />
	Param3: <input id="param3" name="param3" type="hidden" value="" />
	 
	<input type="submit" name="Enviar" />
	</form>
<script src='https://pagofacil.net/resources/js/onsubmitForm.js' type='text/javascript' ></script> 
```

## php 

Si se desea hacer uso de una respuesta por parte de `PagoFacil.net` por medio de un webhook, 
necesitará decifrar la respuesta, la misma se ha cifrado bajo AES de 128 en modo 
`Cipher Block Chaining`. A continuación se muestra el uso propuesto de la implementación.

```php
use PagoFacil\ThreeDSecure\AbstractAESMcrypt;

final class MyCipherClass extends AbstractAESMcrypt
{
    /**
    * @return array
    */
    public function jsonToArray($text)
    {
        return json_decode($text);
    }
}

$respuestaWS = 'nu+81UQjTbn6oW6KFGS+UUDwC+9DtL0v0LsWVRQvBQ9Rn5BCfKB94D0ibJlUzs6ZOxkBRY1P/od7PkEM59E71DAa30viidJSUZPpYanhA7FP4D1a+toTdJlrYnaXSQ6vKfjw6k8Qel+v4qzNYghYl582LhnBpS6myPARiJk9JJzmN0BWScPSHcc9U3GEo47BwJrmFAEG3avaqlnCJYcPsPXwizGB7H4W/mxZQbxcf+CothvT8L3lM8SHGTasB7uz9eiZISxe/dnzbxDJecg7r+einaFkCdF/gIjJ8/tfyf9yl5XCJk/BRTIltbPlTszbDK/TJRSU0QZPgo2ErcyuQ0fmaFNycb4igrGEAhmnXABXRBiHHiY9XQSL7rb5lD2Pk4sEUgJkjC+Bew/ueC3VBj6TnHlQ1SdMLllUOthXzEkioMqLGLH93dRr1wJ34L6QDP0mQtlDX1zpTzNdGamqmlyMnkpOGwiYyPUc2RZWOD1zmEHy/gbDYwCJQu2mRete2EBvvsAqH+QXVwDsF8mRrpC2p7Nh2aMTKvYkaX8VcifpfOcfuC0DmvFI/gHsUNHKmKiOAxM9njrBlJ+3/IhJKvqI5A5BkJ+j8jsnI79j8UHkEpIL4hcY2T+4wLs6D9c8tnkMbcnbgny+/kfdk7owXg==';

$objectCipher = new MyCipherClass('123123123123');
$message = $objectCipher->decrypt($respuestaWS);
$array = $objectCipher->jsonToArray($message);

var_dump($array);
```