@extends('layouts.app')
@section('css')
    {{--  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">  --}}
@endsection

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <button class="btn w-100 btn-sm btn-success" onclick="actualizar()">Actualizar reporte</button>
        {{--  <iframe title="Dashboard Financiero POwer BI" width="1024" height="804" src="https://app.powerbi.com/view?r=eyJrIjoiOTVkMGI3NjctZTE0Ny00ZmQ1LWE0YTUtOWNhZGJmNGExZjdlIiwidCI6IjdkNjk1NDcyLWUwMTktNGRjNi05NTBiLTNiMzU5OGEzOGJkMiIsImMiOjl9" frameborder="0" allowFullScreen="true"></iframe>  --}}
        <hr>
         <iframe title="Dashboard Financiero POwer BI" width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiOTVkMGI3NjctZTE0Ny00ZmQ1LWE0YTUtOWNhZGJmNGExZjdlIiwidCI6IjdkNjk1NDcyLWUwMTktNGRjNi05NTBiLTNiMzU5OGEzOGJkMiIsImMiOjl9" frameborder="0" allowFullScreen="true"></iframe>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-sm w-100" onclick="actuApriori()">Actualizar</button>
            </div>
        </div>

        <h3 class="text-center">Frecuencia de APRIORI</h3>
        <div class="row">
            <div class="col-md-12">
                <h3>Frequent Itemsets</h3>
                <div id="frequentItemsetsChart_1">
                    <canvas id="frequentItemsetsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Association Rules</h3>
                <div id="associationRulesChart_1">
                    <canvas id="associationRulesChart"></canvas>
                </div>
            </div>
        </div>
        <hr>
        <h3 class="text-center">Linea de Tiempo</h3>
        <div class="row">
            <div class="col-md-12">
                <h3>Frequent Itemsets</h3>
                <div id="myChart_1">
                    <canvas id="myChart_Linea"></canvas>
                </div>
            </div>
        </div>
        <hr>
        <h3 class="text-center">Grafica de lifit</h3>
        <div class="row">
            <div class="col-md-12">
                <h3>LIFT</h3>
                <div id="chart_lift">
                    <canvas id="chartLift" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <hr>
        <h3 class="text-center">Proyeccion de Tiempo de  producto</h3>
        <div class="row">
            <div class="col-md-12">
                <select name="producto_id" id="producto_id">
                    @foreach ( $produto as $p)
                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                    @endforeach
                </select>
                <div id="saleProyection_id" style="width: 75%; margin: auto;">
                    <canvas id="salesProjectionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">

        var ctx  = document.getElementById('frequentItemsetsChart').getContext('2d');
        var ctx2 = document.getElementById('associationRulesChart').getContext('2d');
        var ctx3 = document.getElementById('myChart_Linea').getContext('2d');
        var ctx4 = document.getElementById('chartLift').getContext('2d');
        var ctx5 = document.getElementById('salesProjectionChart').getContext('2d');

        var associationRulesChart;
        var frequentItemsetsChart;
        var myChart_Linea;
        var chartLift;
        var salesProyection;

        $.ajaxSetup({
            // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        function actualizar(){
            $.ajax({
                url : "{{ url('onedrive/generaArchivo') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                }
            });
        }

        function actuApriori(){
            $.ajax({
                url : "{{ url('onedrive/actuApriori') }}",
                type: 'POST',
                data: {
                    producto_id : $('#producto_id').val()
                },
                dataType: 'json',
                success: function(data) {

                    $('#frequentItemsetsChart_1').val('');
                    $('#associationRulesChart_1').val('');
                    $('#myChart_1').val('');
                    $('#chart_lift').val('');
                    $('#saleProyection_id').val('');

                    $('#frequentItemsetsChart_1').parent().append('<canvas id="frequentItemsetsChart"></canvas>');
                    $('#associationRulesChart_1').parent().append('<canvas id="associationRulesChart"></canvas>');
                    $('#myChart_1').parent().append('<canvas id="myChart_Linea"></canvas>');
                    $('#chart_lift').parent().append('<canvas id="liftChart" width="400" height="200"></canvas>');
                    $('#saleProyection_id').parent().append('<canvas id="salesProjectionChart"></canvas>');

                    if (frequentItemsetsChart)
                        frequentItemsetsChart.destroy();

                    if (associationRulesChart)
                        associationRulesChart.destroy();

                    if (associationRulesChart)
                        associationRulesChart.destroy();

                    if (myChart_Linea)
                        myChart_Linea.destroy();

                    if (chartLift)
                        chartLift.destroy();

                    if (salesProyection)
                        salesProyection.destroy();

                    // Data for frequent itemsets chart
                    var frequentItemsetsLabels = data.resultado.frequent_itemsets.map(function(itemset) {
                        return itemset[0].join(', ');
                    });
                    var frequentItemsetsData = data.resultado.frequent_itemsets.map(function(itemset) {
                        return itemset[1];
                    });

                    frequentItemsetsChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: frequentItemsetsLabels,
                            datasets: [{
                                label: 'Support',
                                data: frequentItemsetsData,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Data for association rules chart
                    var associationRulesLabels = data.resultado.rules.map(function(rule) {
                        return rule.antecedent.join(', ') + ' => ' + rule.consequent.join(', ');
                    });
                    var associationRulesData = data.resultado.rules.map(function(rule) {
                        return rule.confidence;
                    });

                    associationRulesChart = new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: associationRulesLabels,
                            datasets: [{
                                label: 'Confidence',
                                data: associationRulesData,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Data for line chart
                    var labels = data.linea.labels;
                    var purchaseCounts = data.linea.purchaseCounts;

                    myChart_Linea = new Chart(ctx3, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Frecuencia de compra',
                                data: purchaseCounts,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // Data for lift chart
                    var liftLabels = data.resultado.rules.map(function(rule) {
                        return rule.antecedent.join(', ') + ' => ' + rule.consequent.join(', ');
                    });
                    var liftData = data.resultado.rules.map(function(rule) {
                        return rule.lift;
                    });

                    chartLift = new Chart(ctx4, {
                        type: 'line',
                        data: {
                            labels: liftLabels,
                            datasets: [{
                                label: 'Lift',
                                data: liftData,
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1,
                                cubicInterpolationMode: 'monotone'
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });


                    {{--  PRYECCION DE VENTAS  --}}
                    salesProyection = new Chart(ctx5, {
                        type: 'line', // Puedes cambiar el tipo de gráfico según tus necesidades
                        data: {
                            labels: data.proyeccion.labes,
                            datasets: [{
                                label: 'Proyección de Ventas',
                                data: data.proyeccion.datos,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                fill: false
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Mes'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Ventas'
                                    }
                                }
                            }
                        }
                    });
                }
            });
        }

    </script>

@endsection
