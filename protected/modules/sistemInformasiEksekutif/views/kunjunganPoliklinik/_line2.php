<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/html2canvas/html2canvas.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/html2canvas/html2canvas.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jsPDF/jspdf.min.js', CClientScript::POS_END);
?>
<script>
    $(document).ready(function() {
        var tensi = $("#chart_line");
        var o = 0;
        var arrSatu = [];
        var arrBulan = [];
        var a = 0;
        $("#table-grafik-garis > tbody > tr").each(function() {
            console.log($(this).find(".periode").val());
            //1
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah").val() != '') {
                arrSatu[o] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah").val(),
                };
                o++;
            }
            //bulan
            if ($(this).find(".periode").val() != '') {
                arrBulan[a] = $(this).find(".periode").val();
            }
            a++;
        });
        var lineTensi = new Chart(tensi, {
            type: 'line',
            data: {
                labels: arrBulan,
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    yAxisID: 'A',
                    display: false,
                    fill: false,
                    data: arrSatu,
                    backgroundColor: '#f56954',
                    borderColor: '#f56954',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: '#f56954',
                }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                },
                legend: {
                    labels: {
                        usePointStyle: true
                    },
                },
                responsive: true,
                title: {
                    display: false,
                    text: ''
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: false,
                            labelString: 'Jumlah Kunjungan'
                        },
                        ticks: {
                            fontSize: 11
                        },
                        categoryPercentage: .1,
                        barPercentage: 1,
                        gridLines: {
                            offsetGridLines: true,
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Jumlah Kunjungan',
                        },
                        id: 'A',
                        type: 'linear',
                        position: 'left',
                    }],
                },
            },
        });
    });
</script>
<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Kunjungan Poli Klinik
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <table id="table-grafik-garis" class="table table-striped table-bordered table-condensed hide">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                <?php foreach ($dataLineChart as $value) : ?>
                    <?php $periode = date('M Y', strtotime($value['periode'])) ?>
                    <tr>
                        <td><?php echo CHtml::hiddenField('periode', $periode, array('readonly' => true, 'class' => 'periode')); ?></td>
                        <td><?php echo CHtml::hiddenField('jumlah', $value['jumlah'], array('readonly' => true, 'class' => 'jumlah')); ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="inichart">
            <canvas id="chart_line" width="1200" height="600"> </canvas>
        </div>
    </div>
</div>