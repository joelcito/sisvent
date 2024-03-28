<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SucursalController extends Controller
{
   
    public function listado(Request $request){
        //hola ya estoy en el listado
       return view('sucursal.listado');

    }
    public function ajaxListado(Request $request){
        if($request->ajax()){

            $sucursales = Sucursal::all();

            $data['listado'] = view('sucursal.ajaxListado')->with(compact('sucursales'))->render();
            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }
     
    public function guardarSucursal(Request $request){
        if($request->ajax()){

            $sucursal_id = $request->input('sucursal_id');

            // dd($request->all());
            
            if($sucursal_id === "0"){
                $sucursal                     = new Sucursal();
                $sucursal->usuario_creador_id = Auth::user()->id;
            }else{
                $sucursal                        = Sucursal::find($sucursal_id);
                $sucursal->usuario_modificador_id = Auth::user()->id;
            }

            $sucursal->nombres       = $request->input('nombres');
            $sucursal->descripcion  = $request->input('descripcion');
            $sucursal->direccion    = $request->input('direccion');
            $sucursal->save();

            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

    public function eliminarSucursal(Request $request){
        if($request->ajax()){

            $sucursal_id = $request->input('sucursal');

            $sucursal                        = Sucursal::find($sucursal_id);
            $sucursal->usuario_eliminador_id = Auth::user()->id;
            $sucursal->save();

            Sucursal::destroy($sucursal_id);
            
            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }
    
}
