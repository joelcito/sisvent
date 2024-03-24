<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    public function listado(Request $request){
   //hola ya estoy en el listado
    return view('categoria.listado');
        
}
   

    public function ajaxListado(Request $request){
        if($request->ajax()){

            $categorias = Categoria::all();

            $data['listado'] = view('categoria.ajaxListado')->with(compact('categorias'))->render();
            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }
     
    public function guardarCategoria(Request $request){
        if($request->ajax()){

            $categoria_id = $request->input('categoria_id');
            
            if($categoria_id === "0"){
                $categoria                     = new Categoria();
                $categoria->usuario_creador_id = Auth::user()->id;
            }else{
                $categoria                   = Categoria::find($categoria_id);
                $categoria->usuario_modificador_id = Auth::user()->id;
            }

            $categoria->nombre         = $request->input('nombre');
            $categoria->descripcion    = $request->input('descripcion');
            $categoria->save();

            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

    public function eliminarCategoria(Request $request){
        if($request->ajax()){

            $categoria_id = $request->input('categoria');

            $categoria                       = Categoria::find($categoria_id);
            $categoria->usuario_eliminador_id = Auth::user()->id;
            $categoria->save();

            Categoria::destroy($categoria_id);
            
            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }
}

