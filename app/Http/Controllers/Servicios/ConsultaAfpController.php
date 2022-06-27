<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ConsultaAfpController extends Controller
{
    //VARIEBLES GLOBALES
    //protected $seguridad;

    public function __construct(
        Request $request
    ){
        //CONTROL - PERFILES
        /*
        $value = $this->middleware( function ($request, $next) {
            $dt['formulario_controlador'] = 'AformularioController';

            //OBTENIEDO FORUMLARIO_ID - CONTROL DE PERMISOS
            $this->seguridad = fun_verificarAccesoControlador($dt,$request,$next);
            return $next($request);
        });
        */
    }

    /***************************************************************/
    // INDEX
    /***************************************************************/

    public function index(Request $request){
        $dt["titulo"] = "Consulta de Afp";
        $dt["modulo"] = "Afp";
        $dt["mes_actual"] = date("m");
        $dt["anio_actual"] = date("Y");

        //dd($dt);
        return view('Servicio_Consulta_Afp/v_servicio_consulta_afp', $dt);    
    }

    /***************************************************************/
    // CONSULTAR AFP 
    /***************************************************************/

    public function fun_obtener_afp(Request $request){
        
        $dt["dni"] = $request->dni;

        
        $validator = Validator::make($request->all(),[
            'dni'               => 'required|min:8',
        ]);
        if($validator -> fails()){
            $dt['resp'] ='Error';
            $a['resp'] = $validator->messages()->messages();
            
            foreach($a['resp'] as $key=>$value){
                if($key =='dni' ){ $msg ="<b>Documento de identidad</b>";$a['resp'][$key][0] = str_replace(str_replace("_"," ",$key), $msg, $a['resp'][$key][0]);} 
            }
            
            $dt['messages'] = $a['resp'];
            return $dt;
            return back()->with('ban',$dt);
        }

        //CONSULTA DE AFP
        $url = "https://www.afpnet.com.pe/AFPnet/Afiliado/Datos?CodigoTipoDocumento=0&NumeroDocumento=".$dt["dni"]."&__RequestVerificationToken=CfDJ8FJUIQQAbhBGpDmg5dBoWpFlqEQfHx08RJ6jkHVEUvFGoUP9Hf7VZkvRH1cDGv-80hV9amSvqwxvgGXoH6-j37dKHtqOUdCeatJO1-64Q67sF17Zc17hDO17NedDjrQUJobhzQKTpcEHlwVfxlZzx6w";

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_USERAGENT, 'PHP/' . phpversion());
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($c, CURLOPT_POSTFIELDS, $json);
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        $result = curl_exec($c);
        if (curl_errno($c)) {
            return trigger_error('CURL error [' . curl_errno($c) . '] ' . curl_error($c));
        }
        curl_close($c);
        //var_dump(json_encode($result));
        echo $result;

        //return back()->with('vFormData',$result);
    }
    
}
