<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\FlareClient\Http\Client;

class ClienteController extends Controller
{

    public function listado(Request $request){
        // dd("HOLA YA ESTOY EN EL LISTADO");
        return view('cliente.listado');
    }

    public function ajaxListado(Request $request){
        if($request->ajax()){

            $clientes = Cliente::all();

            $data['listado'] = view('cliente.ajaxListado')->with(compact('clientes'))->render();
            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

    public function guardarCliente(Request $request){
        if($request->ajax()){

            $cliente_id = $request->input('cliente_id');
            
            if($cliente_id === "0"){
                $cliente                     = new Cliente();
                $cliente->usuario_creador_id = Auth::user()->id;
            }else{
                $cliente                         = Cliente::find($cliente_id);
                $cliente->usuario_modificador_id = Auth::user()->id;
            }

            $cliente->nombres            = $request->input('nombre');
            $cliente->ap_paterno         = $request->input('ap_paterno');
            $cliente->ap_materno         = $request->input('ap_materno');
            $cliente->cedula             = $request->input('cedula');
            $cliente->celular            = $request->input('celular');
            $cliente->correo             = $request->input('correo');
            $cliente->save();

            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

    public function eliminarCliente(Request $request){
        if($request->ajax()){

            $cliente_id = $request->input('cliente');

            $cliente                        = Cliente::find($cliente_id);
            $cliente->usuario_eliminador_id = Auth::user()->id;
            $cliente->save();

            Cliente::destroy($cliente_id);
            
            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

}
 