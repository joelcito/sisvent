<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Detalle;
use App\Models\Product;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\FlareClient\Http\Client;

class ClienteController extends Controller
{

    public function listado(Request $request){
        // dd("HOLA YA ESTOY EN EL LISTADO");

        $productos = Product::all();

        return view('cliente.listado')->with(compact('productos'));
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

            $cliente->nombres            = $request->input('nombres');
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

    public function  buscarProducto(Request $request){
        if($request->ajax()){
            $producto_id      = $request->input('producto');
            $producto         = Product::find($producto_id);
            $data['estado']   = "success";
            $data['producto'] = $producto;
        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

    public function  agregarProducuto(Request $request){
        if($request->ajax()){

            $detalle                     = new Detalle();
            $detalle->usuario_creador_id = Auth::user()->id;
            $detalle->cliente_id         = $request->input('cliente_id');
            $detalle->producto_id        = $request->input('producto_id');
            $detalle->cantidad           = $request->input('cantidad');
            $detalle->fecha              = date('Y-m-d H:i:s');
            $detalle->estado             = "paraPagar";
            $detalle->save();
            $data['estado']   = "success";

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

    public function  ajaxListadoProductosAgregados(Request $request) {
        if($request->ajax()){
            $cliente_id = $request->input('cliente');

            $detalles = Detalle::where('cliente_id', $cliente_id)
                                ->where('estado', 'paraPagar')
                                ->get();

            $data['estado']   = "success";
            $data['listado']   = view('cliente.ajaxListadoProductosAgregados')->with(compact('detalles'))->render();

        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

    public function guardarVenta(Request $request){
        if($request->ajax()){

            $cliente_id = $request->input('cliente_id');

            $detalles = Detalle::where('cliente_id', $cliente_id)
                                ->where('estado', 'paraPagar')
                                ->get();

            // dd(count($detalles), $cliente_id, $request->all());

            if(count($detalles) > 0){

                $venta                     = new Venta();
                $venta->usuario_creador_id = Auth::user()->id;
                $venta->fecha_venta = date('Y-m-d H:i:s');
                $venta->save();

                $total = 0;
                
                foreach ($detalles as $key => $datelle) {
                    $datelle->usuario_modificador_id = Auth::user()->id;
                    $datelle->estado                 = 'pagado';
                    $datelle->venta_id               = $venta->id;
                    $datelle->save();
                    $total = $total+ (($datelle->producto->precio) * $datelle->cantidad);
                }
                $venta->total_venta = $total;
                $venta->save();
            }else{

            }
            $data['estado']   = "success";
        }else{
            $data['estado'] = "error";
            $data['texto'] = "No Existe";
        }
        return $data;
    }

}
 