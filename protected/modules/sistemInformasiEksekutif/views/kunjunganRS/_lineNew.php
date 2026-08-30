<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/labels/chartjs-plugin-labels.js', CClientScript::POS_END);
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Kunjungan Ke Rumah Sakit
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <canvas id="garis"></canvas>
    </div>
</div>
<script>
    $(document).ready(function() {
        var lineChart = <?= json_encode($dataLine) ?>;
        generateGrafik($("#garis"), 'line', lineChart.bar, '');
        //console.log(lineChart.bar);
    });

    function generateGrafik(id, tipe, getdata, jenis, legend) {
        var dtset = getdata;
        var display_tick_xaxes = true;
        var display_tick_yaxes = true;
        var stacked_yaxes = false;
        var legend_display = true;
        var posisi = 'border';
        var padding = 4;
        var margin = 4;
        var tampil = true;
        if (tipe == 'pie') {
            display_tick_xaxes = false;
            display_tick_yaxes = false;
            posisi = 'outside';
            padding = 45;
            margin = 45;
            tampil = false;
        }
        if (jenis == 'stacked') {
            stacked_yaxes = true;
        }
        if (legend == 'off') {
            legend_display = false;
        }
        setTimeout(function() {
            var grafikTiga = new Chart(id, {
                type: tipe,
                data: dtset,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: ''
                    },
                    legend: {
                        display: legend_display,
                        position: 'bottom'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        labels: {
                            render: function(args) {
                                if (tipe == 'pie') {
                                    return args.label + '\n' + args.percentage + '%';
                                } else {
                                    return args.value;
                                }
                            },
                            fontColor: '#333',
                            fontStyle: 'bold',
                            position: posisi,
                            outsidePadding: padding,
                            textMargin: margin,
                        }
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                display: display_tick_xaxes
                            },
                            stacked: stacked_yaxes,
                            gridLines: {
                                display: tampil
                            }
                        }],
                        yAxes: [{
                            display: display_tick_yaxes,
                            stacked: stacked_yaxes,
                            gridLines: {
                                display: tampil
                            },
                            ticks: {
                                min: 0,
                            }
                        }]
                    },
                }
            });
        }, 300);
    }
</script>