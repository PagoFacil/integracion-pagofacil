package implementtoken;


import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.security.GeneralSecurityException;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.KeyException;
import java.security.NoSuchAlgorithmException;
import java.util.Map;
import java.util.HashMap;
import javax.crypto.BadPaddingException;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;
import net.pagofacil.token.PagoFacilAES;
import net.pagofacil.token.PagoFacilToken;
import net.pagofacil.token.validacionPfException;
import org.json.simple.JSONObject;

/**
 *
 * @author johnatan
 */
public class ImplementToken {

    private static final String key = "XXXXXXXXXXXX";
    private static final String idUsuario = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
    private static final String idSucursal = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXX";


    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws UnsupportedEncodingException, InvalidKeyException, NoSuchAlgorithmException, NoSuchPaddingException, InvalidAlgorithmParameterException, IllegalBlockSizeException, BadPaddingException, GeneralSecurityException, KeyException, IOException, validacionPfException {
        //Activacion de modo produccion
        //PagoFacilToken.ambienteProduccionActivo(true);
        
        //Inicializar Obj PagoFacilToken
        PagoFacilToken objtoken = new PagoFacilToken(idUsuario, key);
        //Inicializar obj AES para desencriptar la respuesta obtenida
        PagoFacilAES objAes = new PagoFacilAES();

////////////////////////
//     Alta token     //
////////////////////////
        //Creando array asociativo, con parametros para AltaToken
        Map<String, String> dataAlta = new HashMap<String, String>();
        dataAlta.put("idSucursal", idSucursal);
        dataAlta.put("idUsuario", idUsuario);
        dataAlta.put("nombre", "Cliente");
        dataAlta.put("apellidos", "Molina Vera");
        dataAlta.put("calleyNumero", "Av Torres No 45");
        dataAlta.put("colonia", "Las Torres");
        dataAlta.put("municipio", "Izcalli");
        dataAlta.put("estado", "Estado de Mexico");
        dataAlta.put("cp", "12349");
        dataAlta.put("telefono", "5555555555");
        dataAlta.put("celular", "5555555555");
        dataAlta.put("email", "cliente@mail.com");
        dataAlta.put("numeroTarjeta", "4111111111111111");
        dataAlta.put("cvt", "281");
        dataAlta.put("mesExpiracion", "12");
        dataAlta.put("anyoExpiracion", "21");

        String resp = objtoken.altaToken(dataAlta);
        System.out.println("RespAlta: "+resp);
        System.out.println("RespAlta-Decode: "+objAes.decrypt(resp, key));
        
////////////////////////
//     Cobro token    //
////////////////////////
        //Creando array asociativo, con parametros para AltaToken
        Map<String, String> dataCobro = new HashMap<String, String>();
        dataCobro.put("idSucursal", idSucursal);
        dataCobro.put("idUsuario", idUsuario);
        dataCobro.put("token", "XXXXXXXXXXXXXXXXX");
        dataCobro.put("monto", "59.99");
        dataCobro.put("idPedido", "TestPf890a1");
        dataCobro.put("param1", "Probando Param one-one-1");
        
//        String respCobro = objtoken.cobroToken(dataCobro);
//        System.out.println("RespCobro: "+respCobro);
//        System.out.println("RespCobro-Decode: "+objAes.decrypt(respCobro, key));

////////////////////////
//   Baja de Token    //
////////////////////////
        Map<String, String> dataBaja = new HashMap<String, String>();
        dataBaja.put("idSucursal", idSucursal);
        dataBaja.put("idUsuario", idUsuario);
        dataBaja.put("token", "PFTE2692S2720I268");
        dataBaja.put("autorizacion", "4763781740256038804007");

//        String respBaja = objtoken.bajaToken(dataBaja);
//        System.out.println("RespBaja: "+respBaja);
//        System.out.println("RespBaja-Decode: "+objAes.decrypt(respBaja, key));
    }

}
