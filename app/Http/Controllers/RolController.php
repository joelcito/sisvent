<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolController extends Controller
{
    
    public function listado(Request $request){
        //hola ya estoy en el listado
       return view('rol.listado');

    }
    public function ajaxListado(Request $request){
        if($request->ajax()){

            $roles = Rol::all();

            $data['listado'] = view('rol.ajaxListado')->with(compact('roles'))->render();
            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }
     
    public function guardarRol(Request $request){
        if($request->ajax()){

            $rol_id = $request->input('rol_id');
            
            if($rol_id === "0"){
                $rol                          = new Rol();
                $rol->usuario_creador_id      = Auth::user()->id;
            }else{
                $rol                         = Rol::find($rol_id);
                $rol->usuario_modificador_id = Auth::user()->id;
            }

            $rol->nombres           = $request->input('nombres');
            $rol->descripcion       = $request->input('descripcion');
            $rol->save();

            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

    public function eliminarRol(Request $request){
        if($request->ajax()){

            $rol_id = $request->input('rol');

            $rol                             = Rol::find($rol_id);
            $rol->usuario_eliminador_id      = Auth::user()->id;
            $rol->save();

            Rol::destroy($rol_id);
            
            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }
    
}

    
    
    
    
    
    
    
    
