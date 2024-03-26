<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    
    public function listado(Request $request){
         //hola ya estoy en el listado
        return view('venta.listado');
        
    }

    public function ajaxListado(Request $request){
        if($request->ajax()){

            $ventas = Venta::all();

            $data['listado'] = view('venta.ajaxListado')->with(compact('ventas'))->render();
            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }
     
    public function guardarVenta(Request $request){
        if($request->ajax()){

            dd($request->all());
            $venta_id = $request->input('venta_id');
            
            if($venta_id === "0"){
                $venta                     = new Venta();
                $venta->usuario_creador_id = Auth::user()->id;
            }else{
                $venta                         = Venta::find($venta_id);
                $venta->usuario_modificador_id = Auth::user()->id;
            }

            $venta->fecha_venta           = $request->input('fecha');
            // $venta->descripcion     = $request->input('descripcion');
            // $venta->cantidad        = $request->input('cantidad');
            $venta->total_venta     = $request->input('total_venta');
            $venta->save();

            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

    public function eliminarVenta(Request $request){
        if($request->ajax()){

            $venta_id = $request->input('venta');

            $venta                       = Venta::find($venta_id);
            $venta->usuario_eliminador_id = Auth::user()->id;
            $venta->save();

            Venta::destroy($venta_id);
            
            $data['estado'] = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

    
};

