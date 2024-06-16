<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use App\Models\Product;
use App\Models\Venta;
use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Table;

class OnDriveController extends Controller
{
    // public function upload(Request $request)
    // {

    //     // Configuración del token de acceso
    //     $accessToken = session('oauth2state');


    //     if (!session('oauth2state')) {
    //             return redirect('onedrive/auth/redirect');
    //         }else{
    //             // dd("no");
    //         }

    //     $apiUrl = 'https://graph.microsoft.com/v1.0/me/drive/root:/Aplicaciones/nu.xlsx:/content';
    //     $file = $request->file('file');

    //     // Configuración de la solicitud HTTP
    //     $curl = curl_init($apiUrl);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, [
    //         'Authorization: Bearer ' . $accessToken,
    //         'Content-Type: application/octet-stream'
    //     ]);
    //     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, file_get_contents($file->getRealPath()));

    //     $response = curl_exec($curl);
    //     curl_close($curl);

    //     if ($response) {
    //         return response()->json(['message' => 'File uploaded successfully']);
    //     } else {
    //         return response()->json(['message' => 'File upload failed']);
    //     }
    // }

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

    }

    public function actuApriori(Request $request)
    {
        if($request->ajax()){
            // Obtener datos del formulario
            $data    = $this->getDatos();

            // Filtrar y persistir solo los arrays que contienen al menos un elemento
            $filteredArray = array_filter($data, function ($item) {
                return count($item) > 0;
            });

            // Procesar el algoritmo Apriori
            $result = $this->apriori($data, 0.1, 0.5);

            $linea  = $this->purchaseCounts($data);

            $producto_id = $request->input('producto_id');

            $dataPro = $this->getDatosProyeccion($producto_id);
            // Definir el array de ventas históricas
            // $historicalSales = [
            //     ['id'=> 1, 'fecha' => '2023-01-15', 'cantidad' => 10, 'producto_id' => 1],
            //     ['id'=> 2, 'fecha' => '2023-01-20', 'cantidad' => 8, 'producto_id' => 1],
            //     ['id'=> 3, 'fecha' => '2023-02-05', 'cantidad' => 12, 'producto_id' => 1],
            //     ['id'=> 4, 'fecha' => '2023-02-10', 'cantidad' => 15, 'producto_id' => 1],
            //     ['id'=> 5, 'fecha' => '2023-03-08', 'cantidad' => 18, 'producto_id' => 1],
            //     ['id'=> 6, 'fecha' => '2023-03-15', 'cantidad' => 20, 'producto_id' => 1],
            //     ['id'=> 7, 'fecha' => '2023-04-12', 'cantidad' => 22, 'producto_id' => 1],
            //     ['id'=> 8, 'fecha' => '2023-04-18', 'cantidad' => 25, 'producto_id' => 1],
            // ];

            $historicalSales = $dataPro;

            // dd($historicalSales);

            $salesProjection = $this->calculateProductProjection($historicalSales, 2);

            // Convertir los datos a un formato que Chart.js pueda entender
            $labels = array_keys($salesProjection);
            $dataF = array_values($salesProjection);

            $data['proyeccion'] = [
                'labes' => $labels,
                'datos' => $dataF
            ];


            $data['estado']           = 'success';
            $data['resultado']        = $result;
            $data['linea']            = $linea;

            // Preparar datos para el gráfico de lift
            $lifts = array_map(function($rule) {
                return $rule['lift'];
            }, $result['rules']);
            $supports = array_map(function($rule) {
                return $rule['confidence'];
            }, $result['rules']);

            $data['lift'] = [
                'lifts' => $lifts,
                'supports' => $supports
            ];
        } else {
            $data['estado'] = 'error';
        }
        return $data;
    }

    // public function actuApriori(Request $request){
    //     if($request->ajax()){
    //         // dd($request->all());



    //         // Obtener datos del formulario
    //         $data = $this->getDatos();
    //         // $data = [
    //         //             ["milk", "bread", "butter"],
    //         //             ["beer", "bread"],
    //         //             ["milk", "beer", "bread", "butter"],
    //         //             ["bread", "butter"],
    //         //             ["milk", "butter"]
    //         // ];

    //         //  $data = [
    //                     //  ["TELEVISOR 49 PLG", "SOPORTE DE TELEVISOR", "PARLANTE"],
    //                     //  ["SOPORTE DE TELEVISOR", "TELEVISOR 49 PLG"],
    //                     //  ["SOPORTE DE TELEVISOR", "PARLANTE", "SMART TV", "TELEVISOR 49 PLG"],
    //                     //  ["bread", "butter"],
    //                     //  ["bread", "butter"],
    //                     //  ["milk", "butter"]
    //         //  ];


    //         // dd($data);


    //         // Filtrar y persistir solo los arrays que contienen al menos un elemento
    //         $filteredArray = array_filter($data, function ($item) {
    //             return count($item) > 0;
    //         });

    //         // Procesar el algoritmo Apriori
    //         // $resultw = $this->apriori($data, 0.5, 0.7);
    //         $result = $this->apriori($data, 0.1, 0.5);
    //         // $result = $this->apriori($filteredArray, 0.1, 0.5);
    //         $linea = $this->purchaseCounts($data);


    //         // dd($data, $result, $linea, $filteredArray, $resultw);
    //         // dd($data, $result, $linea, $filteredArray);


    //         $data['estado']    = 'success';
    //         $data['resultado'] = $result;
    //         $data['linea']     = $linea;
    //     }else{
    //         $data['estado'] = 'error';
    //     }
    //     return $data;
    // }

    private function getDatos(){
        $array = array();
        $ventas = Venta::all();
        foreach ($ventas as $key => $v) {
            $arrayDetaller = array();
            $datelles = Detalle::where('venta_id', $v->id)->get();
            foreach ($datelles as $key => $d) {
                array_push($arrayDetaller, $d->producto->nombre);
            }
            array_push($array, $arrayDetaller);
        }
        return $array;
    }

    private function apriori($data, $min_support, $min_confidence)
    {
        $transactions = $data;

        $calculate_support = function($itemset, $transactions) {
            $count = 0;
            foreach ($transactions as $transaction) {
                if (count(array_intersect($itemset, $transaction)) == count($itemset)) {
                    $count++;
                }
            }
            return $count / count($transactions);
        };

        $itemsets = [];
        $frequent_itemsets = [];
        $rules = [];

        $items = [];
        foreach ($transactions as $transaction) {
            foreach ($transaction as $item) {
                if (!isset($items[$item])) {
                    $items[$item] = 0;
                }
                $items[$item]++;
            }
        }

        foreach ($items as $item => $count) {
            $support = $count / count($transactions);
            if ($support >= $min_support) {
                $frequent_itemsets[] = [[$item], $support];
            }
        }

        $k = 2;
        while (true) {
            $candidate_itemsets = [];
            foreach ($frequent_itemsets as $itemset) {
                foreach ($frequent_itemsets as $itemset2) {
                    if (count(array_diff($itemset[0], $itemset2[0])) == 1) {
                        $candidate_itemsets[] = array_unique(array_merge($itemset[0], $itemset2[0]));
                    }
                }
            }
            $candidate_itemsets = array_unique($candidate_itemsets, SORT_REGULAR);
            $frequent_itemsets = [];
            foreach ($candidate_itemsets as $itemset) {
                $support = $calculate_support($itemset, $transactions);
                if ($support >= $min_support) {
                    $frequent_itemsets[] = [$itemset, $support];
                }
            }
            if (empty($frequent_itemsets)) {
                break;
            }
            $itemsets = array_merge($itemsets, $frequent_itemsets);
            $k++;
        }

        foreach ($itemsets as $itemset) {
            if (count($itemset[0]) > 1) {
                $subsets = $this->generate_subsets($itemset[0]);
                foreach ($subsets as $subset) {
                    $antecedent = $subset;
                    $consequent = array_diff($itemset[0], $subset);
                    if (!empty($consequent)) {
                        $support_antecedent = $calculate_support($antecedent, $transactions);
                        $support_consequent = $calculate_support($consequent, $transactions);
                        $support_itemset = $calculate_support($itemset[0], $transactions);
                        $confidence = $support_itemset / $support_antecedent;
                        if ($confidence >= $min_confidence) {
                            $lift = $confidence / $support_consequent;
                            $rules[] = [
                                'antecedent' => $antecedent,
                                'consequent' => array_values($consequent),
                                'confidence' => $confidence,
                                'lift' => $lift
                            ];
                        }
                    }
                }
            }
        }

        return ['frequent_itemsets' => $itemsets, 'rules' => $rules];
    }

    // private function apriori($data, $min_support, $min_confidence)
    // {
    //     // $transactions = json_decode($data, true);
    //     $transactions = $data;

    //     $calculate_support = function($itemset, $transactions) {
    //         $count = 0;
    //         foreach ($transactions as $transaction) {
    //             if (count(array_intersect($itemset, $transaction)) == count($itemset)) {
    //                 $count++;
    //             }
    //         }
    //         return $count / count($transactions);
    //     };

    //     $itemsets = [];
    //     $frequent_itemsets = [];
    //     $rules = [];

    //     $items = [];
    //     foreach ($transactions as $transaction) {
    //         foreach ($transaction as $item) {
    //             if (!isset($items[$item])) {
    //                 $items[$item] = 0;
    //             }
    //             $items[$item]++;
    //         }
    //     }
    //     foreach ($items as $item => $count) {
    //         $support = $count / count($transactions);
    //         if ($support >= $min_support) {
    //             $frequent_itemsets[] = [[$item], $support];
    //         }
    //     }

    //     $k = 2;
    //     while (true) {
    //         $candidate_itemsets = [];
    //         foreach ($frequent_itemsets as $itemset) {
    //             foreach ($frequent_itemsets as $itemset2) {
    //                 if (count(array_diff($itemset[0], $itemset2[0])) == 1) {
    //                     $candidate_itemsets[] = array_unique(array_merge($itemset[0], $itemset2[0]));
    //                 }
    //             }
    //         }
    //         $candidate_itemsets = array_unique($candidate_itemsets, SORT_REGULAR);
    //         $frequent_itemsets = [];
    //         foreach ($candidate_itemsets as $itemset) {
    //             $support = $calculate_support($itemset, $transactions);
    //             if ($support >= $min_support) {
    //                 $frequent_itemsets[] = [$itemset, $support];
    //             }
    //         }
    //         if (empty($frequent_itemsets)) {
    //             break;
    //         }
    //         $itemsets = array_merge($itemsets, $frequent_itemsets);
    //         $k++;
    //     }

    //     foreach ($itemsets as $itemset) {
    //         if (count($itemset[0]) > 1) {
    //             $subsets = $this->generate_subsets($itemset[0]);
    //             foreach ($subsets as $subset) {
    //                 $antecedent = $subset;
    //                 $consequent = array_diff($itemset[0], $subset);
    //                 if (!empty($consequent)) {
    //                     $confidence = $calculate_support($itemset[0], $transactions) / $calculate_support($antecedent, $transactions);
    //                     if ($confidence >= $min_confidence) {
    //                         $rules[] = [$antecedent, array_values($consequent), $confidence];
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     return ['frequent_itemsets' => $itemsets, 'rules' => $rules];
    // }

    private function generate_subsets($items)
    {
        $subsets = [];
        $total = 1 << count($items);
        for ($i = 1; $i < $total; $i++) {
            $subset = [];
            for ($j = 0; $j < count($items); $j++) {
                if ($i & (1 << $j)) {
                    // if($j < (count($items) - 1)){
                    // if(isset($items[$j])){
                        // dd($j, count($items));
                        $subset[] = $items[$j];
                    // }
                }
            }
            $subsets[] = $subset;
        }
        return $subsets;
    }

    private function purchaseCounts($data){
        $counts = [];
        foreach ($data as $purchase) {
            foreach ($purchase as $item) {
                if (!isset($counts[$item])) {
                    $counts[$item] = 1;
                } else {
                    $counts[$item]++;
                }
            }
        }

        // Preparar datos para el gráfico
        $labels = [];
        $purchaseCounts = [];
        foreach ($counts as $item => $count) {
            $labels[] = $item;
            $purchaseCounts[] = $count;
        }

        return ['labels' => $labels, 'purchaseCounts' => $purchaseCounts];

    }

    // Definir la función calculateProductProjection
    // function calculateProductProjection(array $historicalSales, int $months)
    // {
    //     // Agrupar ventas por mes y sumar la cantidad vendida
    //     $salesByMonth = [];

    //     foreach ($historicalSales as $venta) {
    //         $monthYear = Carbon::parse($venta['fecha'])->format('Y-m');

    //         if (!isset($salesByMonth[$monthYear])) {
    //             $salesByMonth[$monthYear] = 0;
    //         }

    //         // Sumar la cantidad vendida
    //         $salesByMonth[$monthYear] += $venta['cantidad'];
    //     }

    //     // Ordenar las ventas por mes
    //     ksort($salesByMonth);

    //     // Calcular la tasa de crecimiento mensual promedio
    //     $growthRates = [];
    //     $previousSales = null;

    //     foreach ($salesByMonth as $month => $totalSales) {
    //         if ($previousSales !== null) {
    //             $growthRates[] = ($totalSales - $previousSales) / $previousSales;
    //         }
    //         $previousSales = $totalSales;
    //     }

    //     $averageGrowthRate = array_sum($growthRates) / count($growthRates);

    //     // Proyectar las ventas para los próximos meses utilizando la tasa de crecimiento promedio
    //     $lastMonth = array_key_last($salesByMonth);
    //     $lastSales = end($salesByMonth);
    //     $salesProjection = [];

    //     for ($i = 1; $i <= $months; $i++) {
    //         $nextMonth = Carbon::parse($lastMonth)->addMonths($i)->format('Y-m');
    //         $lastSales *= (1 + $averageGrowthRate);
    //         $salesProjection[$nextMonth] = round($lastSales, 2);
    //     }

    //     return $salesProjection;
    // }
    function calculateProductProjection(array $historicalSales, int $months)
    {
        // Agrupar ventas por fecha y sumar la cantidad vendida
        $salesByDate = [];

        foreach ($historicalSales as $venta) {
            $fecha = $venta['fecha'];

            if (!isset($salesByDate[$fecha])) {
                $salesByDate[$fecha] = 0;
            }

            // Sumar la cantidad vendida
            $salesByDate[$fecha] += $venta['cantidad'];
        }

        // Ordenar las ventas por fecha
        ksort($salesByDate);

        // Verificar si hay suficientes datos para calcular una proyección
        if (count($salesByDate) === 0) {
            // No hay suficientes datos para calcular la proyección
            return [];
        }

        // Obtener la última fecha y cantidad vendida
        $lastDate = array_key_last($salesByDate);
        $lastSales = end($salesByDate);

        // Proyectar las ventas para los próximos meses basándose en la última cantidad vendida
        $salesProjection = [];

        for ($i = 1; $i <= $months; $i++) {
            $nextDate = Carbon::parse($lastDate)->addMonths($i)->format('Y-m-d');
            $salesProjection[$nextDate] = $lastSales;
        }

        return $salesProjection;
    }




    private function getDatosProyeccion($producto_id)
    // private function getDatosProyeccion():array
    {
        $results = DB::table('detalles')
        ->select(DB::raw('DATE(fecha) as fecha'), DB::raw('SUM(cantidad) as cantidad'), 'producto_id')
        ->where('producto_id', $producto_id)
        ->groupBy(DB::raw('DATE(fecha)'), 'producto_id')
        ->orderBy('fecha')
        ->get();

        // Transformar la colección de objetos stdClass a un array asociativo
        $formattedSales = $results->map(function ($sale) {
            return [
                'fecha' => $sale->fecha,
                'cantidad' => (int) $sale->cantidad,   // Convertir a entero si es necesario
                'producto_id' => $sale->producto_id,
            ];
        })->toArray();

        return $formattedSales;
    }

}
