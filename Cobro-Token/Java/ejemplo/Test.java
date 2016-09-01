package com.example;

import org.json.simple.JSONObject;
import net.pagofacil.token.AES;
import net.pagofacil.token.Token;

/**
 *
 * @author https://www.pagofacil.net
 */
public class Test {

    private static final String key = "deac77327a4e3683";
    private static final String idUsuario = "f541b3f11f0f9b3fb33499684f22f6d711f2af58";
    private static final String idSucursal = "e147ee31531d815e2308d6d6d39929ab599deb98";
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        try {
            //Alta
            JSONObject objAlta = new JSONObject();
            objAlta.put("idSucursal", "e147ee31531d815e2308d6d6d39929ab599deb98");
            objAlta.put("idUsuario", "f541b3f11f0f9b3fb33499684f22f6d711f2af58");
            objAlta.put("nombre", "Karmela");
            objAlta.put("apellidos", "Pelayo Java");
            objAlta.put("calleyNumero", "Roma Sur 23");
            objAlta.put("colonia", "Roma");
            objAlta.put("municipio", "MH");
            objAlta.put("estado", "CDMX");
            objAlta.put("cp", "18293");
            objAlta.put("telefono", "5555453422");
            objAlta.put("celular", "3412345678");
            objAlta.put("email", "karmela@mail.com");
            objAlta.put("numeroTarjeta", "5555555555554444");
            objAlta.put("cvt", "289");
            objAlta.put("mesExpiracion", "10");
            objAlta.put("anyoExpiracion", "21");
            
            Token objPF = new Token(idUsuario, key);
            AES objAES = new AES();

//
//System.out.println("AltaToken : ");
//            String response = objPF.altaToken(objAlta);
//            String strDesencriptada = objAES.decrypta(response, key);
//System.out.println("response DecodeAlta: " + strDesencriptada);

            //Cobro
            JSONObject objCobro = new JSONObject();
            objCobro.put("idSucursal", idSucursal);
            objCobro.put("idUsuario", idUsuario);
            objCobro.put("token", "PFTE2692S2720I182");
            objCobro.put("monto", "167.99");
            objCobro.put("idPedido", "Venta-19701");
            objCobro.put("param1", "Desde Java");
            objCobro.put("param2", "TestJohn");
System.out.println("CobroToken : ");
            String responseCobro = objPF.cobroToken(objCobro);
System.out.println("response : " + responseCobro);
            String decodeCobro = objAES.decrypta(responseCobro, key);
System.out.println("response Cobro Decode : " + decodeCobro);

            //BajaToken
            JSONObject objBaja = new JSONObject();
            objBaja.put("idSucursal", idSucursal);
            objBaja.put("idUsuario", idUsuario);
            objBaja.put("token", "PFTE2692S2720I182");
            objBaja.put("autorizacion", "4727486589976572301018");

//System.out.println("BajaToken : ");
//            String responseBaja = objPF.bajaToken(objBaja);
//System.out.println("response Baja: " + responseBaja);
//            String decodeBaja = objAES.decrypta(responseBaja, key);
//System.out.println("response Baja Decode : " + decodeBaja);
        } catch (Exception e) {
        }
    }

}
