package com.example;

import org.json.simple.JSONObject;
import net.pagofacil.token.AES;
import net.pagofacil.token.Token;

/**
 *
 * @author https://www.pagofacil.net
 */
public class Test {
    //Datos Proporcionados por PagoFacil
    private static final String key = "";
    private static final String idUsuario = "";
    private static final String idSucursal = "";
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        try {
            Token objPF = new Token(idUsuario, key);
            AES objAES = new AES();
            //Alta Token
            JSONObject objAlta = new JSONObject();
            objAlta.put("idSucursal", idSucursal);
            objAlta.put("idUsuario", idUsuario);
            objAlta.put("nombre", "XXXXXXXXXX");
            objAlta.put("apellidos", "XXXXX XXXXX");
            objAlta.put("calleyNumero", "XXXXX XXXXX XXXX");
            objAlta.put("colonia", "XXXXXXXXXX");
            objAlta.put("municipio", "XXXXXXXXXX");
            objAlta.put("estado", "XXXXXXXXXX");
            objAlta.put("cp", "XXXXX");
            objAlta.put("telefono", "XXXXXXXXXX");
            objAlta.put("celular", "XXXXXXXXXX");
            objAlta.put("email", "XXXXXXXXXX");
            objAlta.put("numeroTarjeta", "XXXXXXXXXXXXXXXX");
            objAlta.put("cvt", "XXXX");
            objAlta.put("mesExpiracion", "XX");
            objAlta.put("anyoExpiracion", "XX");

//            String response = objPF.altaToken(objAlta);
//            String strDesencriptada = objAES.desencripta(response, key);


            //Cobro Token
            JSONObject objCobro = new JSONObject();
            objCobro.put("idSucursal", idSucursal);
            objCobro.put("idUsuario", idUsuario);
            objCobro.put("token", "XXXXXXXXXX");
            objCobro.put("monto", "XXXXXXXXXX");
            objCobro.put("idPedido", "XXXXXXXXXX");
            objCobro.put("param1", "XXXXXXXXXX");
            objCobro.put("param2", "XXXXXXXXXX");

            String responseCobro = objPF.cobroToken(objCobro);
            String decodeCobro = objAES.desencripta(responseCobro, key);

            //Baja Token
            JSONObject objBaja = new JSONObject();
            objBaja.put("idSucursal", idSucursal);
            objBaja.put("idUsuario", idUsuario);
            objBaja.put("token", "XXXXXXXXXX");
            objBaja.put("autorizacion", "XXXXXXXXXXXXXXXX");

//            String responseBaja = objPF.bajaToken(objBaja);
//            String decodeBaja = objAES.desencripta(responseBaja, key);

        } catch (Exception e) {
            e.getMessage();
        }
    }

}
