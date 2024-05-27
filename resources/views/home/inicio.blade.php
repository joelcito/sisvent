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
        <h1 class="text-center">POWE RBI</h1>
        {{--  <iframe title="Dashboard Financiero POwer BI" width="1024" height="1060" src="https://app.powerbi.com/view?r=eyJrIjoiOTVkMGI3NjctZTE0Ny00ZmQ1LWE0YTUtOWNhZGJmNGExZjdlIiwidCI6IjdkNjk1NDcyLWUwMTktNGRjNi05NTBiLTNiMzU5OGEzOGJkMiIsImMiOjl9" frameborder="0" allowFullScreen="true"></iframe>  --}}
        <hr>
        <div class="row">
            <div class="col-md-6">

                <button class="btn btn-primary btn-sm w-100" onclick="actuApriori()">Actualizar</button>

                <h3>Frequent Itemsets</h3>
                <div id="frequentItemsetsChart_1">
                    <canvas id="frequentItemsetsChart"></canvas>
                </div>

                <h3>Association Rules</h3>
                <div id="associationRulesChart_1">
                    <canvas id="associationRulesChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">

        var ctx = document.getElementById('frequentItemsetsChart').getContext('2d');
        var ctx2 = document.getElementById('associationRulesChart').getContext('2d');
        var associationRulesChart;
        var frequentItemsetsChart

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

                    console.log(data)

                    {{--  if(data.estado === 'success'){
                        Swal.fire({
                            icon:'success',
                            title: 'Exito!',
                            text:"Se registro con exito!",
                            timer:1500
                        })
                        ajaxListado();
                        $('#modal_new_rol').modal('hide')
                    }  --}}
                }
            });
        }

        function actuApriori(){
            $.ajax({
                url : "{{ url('onedrive/actuApriori') }}",
                type: 'POST',
                dataType: 'json',
                success: function(data) {

                    {{--  $('#frequentItemsetsChart_1').remove();
                    $('#associationRulesChart_1').remove();  --}}
                    $('#frequentItemsetsChart_1').val('');
                    $('#associationRulesChart_1').val('');
                    $('#frequentItemsetsChart_1').parent().append('<canvas id="frequentItemsetsChart"></canvas>');
                    $('#associationRulesChart_1').parent().append('<canvas id="associationRulesChart"></canvas>');

                    if (frequentItemsetsChart)
                        frequentItemsetsChart.destroy();

                    if (associationRulesChart)
                        associationRulesChart.destroy();

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
                        return rule[0].join(', ') + ' => ' + rule[1].join(', ');
                    });
                    var associationRulesData = data.resultado.rules.map(function(rule) {
                        return rule[2];
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

                }
            });
        }
    </script>

@endsection
