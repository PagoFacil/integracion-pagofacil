<?php
include_once '../source/PagoFacil_Descifrado_Descifrar.php';

// Respuesta del web service y enviada a la url de redirección
$respuestaWS = 'nu+81UQjTbn6oW6KFGS+UUDwC+9DtL0v0LsWVRQvBQ9Rn5BCfKB94D0ibJlUzs6ZOxkBRY1P/od7PkEM59E71DAa30viidJSUZPpYanhA7FP4D1a+toTdJlrYnaXSQ6vKfjw6k8Qel+v4qzNYghYl582LhnBpS6myPARiJk9JJzmN0BWScPSHcc9U3GEo47BwJrmFAEG3avaqlnCJYcPsPXwizGB7H4W/mxZQbxcf+CothvT8L3lM8SHGTasB7uz9eiZISxe/dnzbxDJecg7r+einaFkCdF/gIjJ8/tfyf9yl5XCJk/BRTIltbPlTszbDK/TJRSU0QZPgo2ErcyuQ0fmaFNycb4igrGEAhmnXABXRBiHHiY9XQSL7rb5lD2Pk4sEUgJkjC+Bew/ueC3VBj6TnHlQ1SdMLllUOthXzEkioMqLGLH93dRr1wJ34L6QDP0mQtlDX1zpTzNdGamqmlyMnkpOGwiYyPUc2RZWOD1zmEHy/gbDYwCJQu2mRete2EBvvsAqH+QXVwDsF8mRrpC2p7Nh2aMTKvYkaX8VcifpfOcfuC0DmvFI/gHsUNHKmKiOAxM9njrBlJ+3/IhJKvqI5A5BkJ+j8jsnI79j8UHkEpIL4hcY2T+4wLs6D9c8tnkMbcnbgny+/kfdk7owXg==';

// Proporcionada por Pago Facil al momento de registrarse
$apiKey = '123123123123';

$objDesencriptar = new PagoFacil_Descifrado_Descifrar();

$responseEncode = $objDesencriptar->desencriptar($respuestaWS, $apiKey);

$response = json_decode($responseEncode);

echo '<pre>';
var_dump($response);
echo '</pre>';
