<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OnDriveController extends Controller
{
    public function upload(Request $request)
    {
        /*

        if (!session('oauth2state')) {
        // if (!session('accessToken')) {
            // oauth2state
            // dd("si", session('accessToken'));
            return redirect('onedrive/auth/redirect');
        }else{
            // dd("no");
        }

        // Verifica si el archivo se ha enviado correctamente
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No se ha proporcionado un archivo'], 400);
        }

        // Obtiene el archivo del formulario
        $file = $request->file('file');

        // Verifica si el archivo es válido
        if (!$file->isValid()) {
            return response()->json(['error' => 'El archivo no es válido'], 400);
        }

        // Abre el archivo y obtiene su contenido
        $content = file_get_contents($file->getRealPath());

        // URL de la API de Microsoft Graph para cargar un archivo
        $url = 'https://graph.microsoft.com/v1.0/me/drive/root:/' . $file->getClientOriginalName() . ':/content';

        // Token de acceso para autorizar la solicitud
        $accessToken = session('accessToken');

        // Realiza la solicitud HTTP para cargar el archivo
        $client = new Client();
        $response = $client->request('PUT', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'text/plain' // Cambiar según el tipo de archivo
            ],
            'body' => $content
        ]);

        // Verifica el estado de la respuesta
        if ($response->getStatusCode() == 201) {
            return response()->json(['message' => 'Archivo cargado con éxito']);
        } else {
            return response()->json(['error' => 'Error al cargar el archivo'], $response->getStatusCode());
        }
        */


        if (!session('oauth2state')) {
        // if (!session('accessToken')) {
            // oauth2state
            // dd("si", session('accessToken'));
            return redirect('onedrive/auth/redirect');
        }else{
            // dd("no");
        }

        $accessToken = session('accessToken');
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $file = $request->file('file');
        $content = file_get_contents($file->getRealPath());

        $upload = $graph->createRequest("PUT", "/me/drive/root:/{$file->getClientOriginalName()}:/content")
                        ->upload($content);

        // dd($upload);



        return response()->json(['message' => 'File uploaded successfully']);

    }
}
