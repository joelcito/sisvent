<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Table;

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





        // Configuración del token de acceso
        $accessToken = session('oauth2state');


        if (!session('oauth2state')) {
            // if (!session('accessToken')) {
                // oauth2state
                // dd("si", session('accessToken'));
                return redirect('onedrive/auth/redirect');
            }else{
                // dd("no");
            }

        // $apiUrl = 'https://graph.microsoft.com/v1.0/me/drive/root:/<nombre de la carpeta en OneDrive>:/<nombre del archivo>';
        // $apiUrl = 'https://graph.microsoft.com/v1.0/me/drive/root:/Aplicaciones/nu.txt';
        $apiUrl = 'https://graph.microsoft.com/v1.0/me/drive/root:/Aplicaciones/nu.xlsx:/content';
        $file = $request->file('file');

        // Configuración de la solicitud HTTP
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/octet-stream'
        ]);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, file_get_contents($file->getRealPath()));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            return response()->json(['message' => 'File uploaded successfully']);
        } else {
            return response()->json(['message' => 'File upload failed']);
        }





        /*
        //ESTE DA PERO NO DA EL GRAPH
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
        */

    }

    public function generaArchivo(Request $request){



        $fileName = 'DASHBAORD FINANCIERO POWER BI_test.xlsx';
$filePath = 'C:/Users/JOELCITO/OneDrive/' . $fileName;

if (!file_exists($filePath)) {
    return response()->json(['message' => 'El archivo no existe o no es accesible'], 400);
}

try {
    // Cargar el archivo Excel existente
    $spreadsheet = IOFactory::load($filePath);

    // Crear una nueva instancia de Spreadsheet si no se carga desde un archivo existente
    if (!$spreadsheet instanceof Spreadsheet) {
        $spreadsheet = new Spreadsheet();
    }

    // Obtener la hoja de cálculo en la que se encuentra la tabla (supongamos que es la primera hoja)
    $sheet = $spreadsheet->getActiveSheet();

    // Definir las nuevas filas a agregar
    $newRows = [
        ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 1', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 1', 'Electrodoméstico', '4221', '2375'],

        ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 2', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 2', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 2', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 2', 'Electrodoméstico', '4221', '2375'],


        ['1/2/2020', 'Celular', 'Salamanca', 'Tienda 3', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Celular', 'Salamanca', 'Tienda 3', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Celular', 'Salamanca', 'Tienda 3', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Celular', 'Salamanca', 'Tienda 3', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Celular', 'Salamanca', 'Tienda 3', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Celular', 'Salamanca', 'Tienda 3', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Celular', 'Salamanca', 'Tienda 3', 'Electrodoméstico', '4221', '2375'],
        ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 3', 'Electrodoméstico', '4221', '2375']
    ];

    $datas = Detalle::join('productos', 'detalles.producto_id', '=', 'productos.id')
    ->join('sucursales', 'productos.sucursal_id', '=', 'sucursales.id')
    ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
    ->select('productos.nombre as nomProducto', 'productos.precio as preProducto', 'sucursales.nombres as nomSucursal', 'categorias.nombres as catNombre', 'detalles.fecha as detFecha')
    ->whereNull('productos.deleted_at')
    ->whereNull('sucursales.deleted_at')
    ->whereNull('categorias.deleted_at')
    ->whereNull('detalles.deleted_at')
    ->get();

    // dd($datas);

    // Obtener el nombre de la tabla
    $tableName = 'Table1'; // Asegúrate de que este es el nombre de la tabla

    // Obtener la tabla por su nombre
    $table = $sheet->getTableByName($tableName);

    if ($table === null) {
        return response()->json(['message' => 'La tabla no existe en la hoja de cálculo'], 400);
    }

    // Obtener el rango de la tabla
    $tableRange = $table->getRange();

    // Dividir la cadena en partes usando ':' como delimitador
    $parts = explode(':', $tableRange);

    // Obtener la segunda parte que contiene la celda del extremo derecho inferior (por ejemplo, "G134")
    $lastCell = $parts[1];

    // Extraer el número de fila de la celda
    $lastRowNumber = (int) preg_replace('/[^0-9]/', '', $lastCell);

    // Eliminar todas las filas existentes de la tabla (excepto la primera fila de encabezados)
    $sheet->removeRow(2, $lastRowNumber);

    $lastRowNumber = 1;

    // Agregar las nuevas filas después de la última fila de la tabla existente
    // foreach ($newRows as $rowData) {
    foreach ($datas as $rowData) {

        // dd($rowData);

        // $lastRowNumber++;
        // $sheet->insertNewRowBefore($lastRowNumber + 1, 1);
        // $sheet->fromArray($rowData, null, 'A' . $lastRowNumber);

        // Incrementamos el número de fila para la nueva fila
            $lastRowNumber++;
            // Convertir la cadena de fecha y hora a un objeto DateTime
            $fecha = new DateTime($rowData->detFecha);

            // Asignamos el valor para cada celda individualmente
            $sheet->setCellValue('A' . $lastRowNumber, $fecha->format('j/n/Y'));
            $sheet->setCellValue('B' . $lastRowNumber, $rowData->nomProducto);
            $sheet->setCellValue('C' . $lastRowNumber, "La Paz");
            $sheet->setCellValue('D' . $lastRowNumber, $rowData->nomSucursal);
            $sheet->setCellValue('E' . $lastRowNumber, $rowData->catNombre);
            $sheet->setCellValue('F' . $lastRowNumber, $rowData->preProducto);
            $sheet->setCellValue('G' . $lastRowNumber, 15);

    }

    // Asignar un nombre a la tabla
    $table->setName('Table1');

    // Actualizar el rango de la tabla para incluir las nuevas filas
    $newTableRange = 'A1:G' . $lastRowNumber;
    $table->setRange($newTableRange);


   // Crear la definición de nombre y establecer su visibilidad en falso
    $name = '_xlnm._FilterDatabase';
    $data = 'Ventas!$A$1:$G$' . $lastRowNumber; // Ajusta "Sheet1" al nombre de tu hoja si es diferente
    $hidden = true; // Establecer la visibilidad en falso
    $kind = $sheet; // Usar el objeto Worksheet como tipo

    // Agregar el rango de nombre al libro de trabajo
    $namedRange = new NamedRange($name, $kind, $data, $hidden);
    $spreadsheet->addNamedRange($namedRange);

   // Guardar los cambios en el archivo Excel original
   $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
   $writer->save($filePath);

    return response()->json(['message' => 'Definición de nombre creada correctamente y filas agregadas a la tabla']);
} catch (\Exception $e) {
    return response()->json(['message' => 'Error al procesar el archivo: ' . $e->getMessage()], 500);
}






        /*
// ERROR CON ALFO DEL DIFF
        $fileName = 'DASHBAORD FINANCIERO POWER BI_test.xlsx';
        $filePath = 'C:/Users/JOELCITO/OneDrive/' . $fileName;

        if (!file_exists($filePath)) {
            return response()->json(['message' => 'El archivo no existe o no es accesible'], 400);
        }

        try {
            // Cargar el archivo Excel existente
            $spreadsheet = IOFactory::load($filePath);

            // Obtener la hoja de cálculo en la que se encuentra la tabla (supongamos que es la primera hoja)
            $sheet = $spreadsheet->getActiveSheet();

            // Definir las nuevas filas a agregar
            $newRows = [
                ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 7', 'Electrodoméstico', '4221', '2375'],
                ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 7', 'Electrodoméstico', '4221', '2375']
            ];


            // Obtener el rango de la tabla
            // $tableName = 'Ventas'; // Asegúrate de que este es el nombre de la tabla
            $tableName = 'Tabla1'; // Asegúrate de que este es el nombre de la tabla
            $table = $sheet->getTableByName($tableName);

            // dd($table, $sheet->getTableNames(), $sheet->getTableByName("Tabla1"));

            if ($table === null) {
                return response()->json(['message' => 'La tabla no existe en la hoja de cálculo'], 400);
            }

            // Obtener la fila donde se encuentra la última fila de la tabla
            // dd($table->getRange());

            // Dividir la cadena en partes usando ':' como delimitador
            $parts = explode(':', $table->getRange());

            // Obtener la segunda parte que contiene la celda del extremo derecho inferior (por ejemplo, "G134")
            $lastCell = $parts[1];

            // Extraer el número de fila de la celda
            $lastRowNumber = (int) preg_replace('/[^0-9]/', '', $lastCell);

            // $lastRow = $table->getRange()->getLastRow();
            $lastRow = $lastRowNumber;

            // Agregar las nuevas filas dentro de la tabla existente
            foreach ($newRows as $rowData) {
                $sheet->insertNewRowBefore($lastRow + 1, 1);
                $sheet->fromArray($rowData, null, 'A' . ($lastRow + 1));
                $lastRow++;
            }

            // Actualizar el rango de la tabla
            $table->setRange('A1:G' . $lastRow);

            // Guardar los cambios en el archivo Excel
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);

            return response()->json(['message' => 'Archivo actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar el archivo: ' . $e->getMessage()], 500);
        }

        */




        /*

        // me lo inserta pero da error en el power bi
        $fileName = 'DASHBAORD FINANCIERO POWER BI_test.xlsx';
        $filePath = 'C:/Users/JOELCITO/OneDrive/' . $fileName;

        try {
            // Cargar el archivo Excel existente
            $spreadsheet = IOFactory::load($filePath);

            // Obtener la hoja de cálculo en la que se encuentra la tabla (supongamos que es la primera hoja)
            $sheet = $spreadsheet->getActiveSheet();

            // Definir las nuevas filas a agregar
            $newRows = [
                ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 7', 'Electrodoméstico TEST 1', '4221', '2375'],
                ['1/2/2020', 'Televisión 50', 'Salamanca', 'Tienda 7', 'Electrodoméstico TEST 2', '4221', '2375'],
                ['1/2/2020', 'Televisión 60', 'Salamanca', 'Tienda 7', 'Electrodoméstico TEST 3', '4221', '2375']
                // Puedes agregar tantas filas como necesites
            ];

            // Determinar la fila donde deseas insertar las nuevas filas (por ejemplo, después de la primera fila de encabezados)
            $insertPosition = 4; // Aquí, 2 significa que las nuevas filas se insertarán comenzando en la segunda fila

            // Insertar nuevas filas
            $sheet->insertNewRowBefore($insertPosition, count($newRows));

            // Agregar los datos a las filas insertadas
            foreach ($newRows as $index => $rowData) {
                // echo $index ."<br>";
                // $sheet->fromArray($rowData, null, 'A' . ($insertPosition + ($index+1)));
                $sheet->fromArray($rowData, null, 'A' . ($insertPosition + $index));
            }

            // Guardar los cambios en el archivo Excel
            $writer = new Xlsx($spreadsheet);
            $writer->save($filePath);

            return response()->json(['message' => 'Archivo actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar el archivo: ' . $e->getMessage()], 500);
        }
        */





        /*

        //INSERTA LAS FILAS AL FINAL PERO NO RECORRE LA TABLA

        $fileName = 'DASHBAORD FINANCIERO POWER BI_test.xlsx';
        $filePath = 'C:/Users/JOELCITO/OneDrive/' . $fileName;

        // $filePath = 'ruta/a/tu/archivo/excel.xlsx';

        // Cargar el archivo Excel existente
        $spreadsheet = IOFactory::load($filePath);

        // Obtener la hoja de cálculo en la que se encuentra la tabla (supongamos que es la primera hoja)
        $sheet = $spreadsheet->getActiveSheet();

        // Agregar nuevas filas a la tabla
        $newRows = [
            ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 7', 'Electrodoméstico', '4221', '2375,5991134622'],
            ['1/2/2020', 'Televisión 40', 'Salamanca', 'Tienda 7', 'Electrodoméstico', '4221', '2375,5991134622']
            // Puedes agregar tantas filas como necesites
        ];

        // Obtener el rango de celdas de la tabla existente
        $tableRange = 'A1:C5'; // Esto es un ejemplo, debes reemplazarlo con el rango de celdas de tu tabla

        // Determinar la fila donde se encuentra la última fila de la tabla
        $lastRow = $sheet->getHighestRow() + 1;

        // Agregar las nuevas filas debajo de la tabla existente
        foreach ($newRows as $rowData) {
            $sheet->fromArray($rowData, null, 'A' . $lastRow);
            $lastRow++;
        }

        // Guardar los cambios en el archivo Excel
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);


        */



        /*
        //GENERA PERO NO CON TABLAS
        $fileName = 'DASHBAORD FINANCIERO POWER BI_test.xlsx';
        $filePath = 'C:/Users/JOELCITO/OneDrive/' . $fileName;

        if (file_exists($filePath)) {
            // Intenta eliminar el archivo utilizando un contexto de flujo
            $context = stream_context_create(['http' => ['ignore_errors' => true]]);
            unlink($filePath, $context);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Definir los datos como un arreglo bidimensional
        $data = [
            ['Nombre', 'Correo Electrónico', 'Teléfono'],
            ['John Doe', 'john@example.com', '123456789'],
            ['Jane Doe', 'jane@example.com', '987654321'],
        ];

        // Agregar los datos a la hoja desde el arreglo
        $sheet->fromArray($data, null, 'A1');

        // Ajustar el ancho de las columnas automáticamente
        foreach (range('A', 'C') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Guardar el archivo
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return response()->json(['message' => 'Archivo exportado correctamente']);

        */

        /*
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nombre');
        $sheet->setCellValue('B1', 'Correo Electrónico');
        $sheet->setCellValue('C1', 'Teléfono');

        $sheet->setCellValue('A2', 'John Doe');
        $sheet->setCellValue('B2', 'john@example.com');
        $sheet->setCellValue('C2', '123456789');

        $sheet->setCellValue('A3', 'Jane Doe');
        $sheet->setCellValue('B3', 'jane@example.com');
        $sheet->setCellValue('C3', '987654321');

        $writer   = new Xlsx($spreadsheet);
        $fileName = 'DASHBAORD FINANCIERO POWER BI_test.xlsx';
        $filePath = 'C:/Users/JOELCITO/OneDrive/' . $fileName;  // Reemplaza '/ruta/a/tu/directorio/' con la ruta deseada
        // $filePath = 'E:/' . $fileName;  // Reemplaza '/ruta/a/tu/directorio/' con la ruta deseada
        // OneDrive

        $writer->save($filePath);

        // Opcional: Devolver una respuesta HTTP con un mensaje de éxito o redireccionar a otra página
        return response()->json(['message' => 'Archivo exportado correctamente']);
        */
    }
}
