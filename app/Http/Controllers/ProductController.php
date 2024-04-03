<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Product;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function listado(Request $request){

        $sucursales = Sucursal::all();
        $categorias = Categoria::all();

        return view('producto.listado')->with(compact('sucursales', 'categorias'));
    }

    public function guardarProducto(Request $request){
        if($request->ajax()){

            $producto_id = $request->input('producto_id');

            if($producto_id == "0"){
                $producto                     = new Product();
                $producto->usuario_creador_id = Auth::user()->id;
            }else{
                $producto                         = Product::find($producto_id);
                $producto->usuario_modificador_id = Auth::user()->id;
            }
            
            $producto->sucursal_id  = $request->input('sucursal_id');
            $producto->categoria_id = $request->input('categoria_id');
            $producto->nombre       = $request->input('nombres');
            $producto->descripcion  = $request->input('descripcion');
            $producto->codigo       = $request->input('codigo');
            $producto->precio       = $request->input('precio');
            $producto->stock        = $request->input('stock');

            $producto->save();
            $data['estado'] = 'success';

        }else{
            $data['estado'] = 'error';
            $data['mensaje'] = 'No Existe';
        }
        return $data;
    }

    public function ajaxListado(Request $request)
    {
        if($request->ajax()){

            $productos = Product::all();

            $data['estado'] = 'success';
            $data['listado'] = view('producto.ajaxListado')->with(compact('productos'))->render();

        }else{
            $data['estado'] = 'error';
            $data['mensaje'] = 'No Existe';
        }
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
