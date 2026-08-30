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
        var p = 0;
        var q = 0;
        var r = 0;
        var s = 0;
        var t = 0;
        var arrSatu = [];
        var arrDua = [];
        var arrTiga = [];
        var arrEmpat = [];
        var arrLima = [];
        var arrEnam = [];
        var arrBulan = [];
        var a = 0;
        $("#table-grafik-kunjunganpenunjang > tbody > tr").each(function() {
            console.log($(this).find(".periode").val());
            //1
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_labpa").val() != '') {
                arrSatu[o] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah_labpa").val(),
                };
                o++;
            }
            //2
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_laboratorium").val() != '') {
                arrDua[q] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah_laboratorium").val(),
                };
                q++;
            }
            //3
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_mikro").val() != '') {
                arrTiga[p] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah_mikro").val(),
                };
                p++;
            }
            //4
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_radiologi").val() != '') {
                arrEmpat[r] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah_radiologi").val(),
                };
                r++;
            }
            //5
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_rehabilitasi").val() != '') {
                arrLima[s] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah_rehabilitasi").val(),
                };
                s++;
            }
            //6
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_mcu").val() != '') {
                arrEnam[t] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah_mcu").val(),
                };
                t++;
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
                    label: 'Lab PA',
                    yAxisID: 'A',
                    display: false,
                    fill: false,
                    data: arrSatu,
                    backgroundColor: '#f56954',
                    borderColor: '#f56954',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: '#f56954',
                }, {
                    label: 'Lab Patologi Klinik',
                    yAxisID: 'A',
                    display: false,
                    fill: false,
                    data: arrDua,
                    backgroundColor: '#00a65a',
                    borderColor: '#00a65a',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: '#00a65a',
                }, {
                    label: 'Mikrobilogi Klinik',
                    yAxisID: 'A',
                    display: false,
                    fill: false,
                    data: arrTiga,
                    backgroundColor: '#ffa812',
                    borderColor: '#ffa812',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: '#ffa812',
                }, {
                    label: 'Radiologi',
                    yAxisID: 'A',
                    display: false,
                    fill: false,
                    data: arrEmpat,
                    backgroundColor: '#00c0ef',
                    borderColor: '#00c0ef',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: '#00c0ef',
                }, {
                    label: 'Rehabilitasi Medik',
                    yAxisID: 'A',
                    display: false,
                    fill: false,
                    data: arrLima,
                    backgroundColor: '#b454f5',
                    borderColor: '#b454f5',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: '#b454f5',
                }, {
                    label: 'MCU',
                    yAxisID: 'A',
                    display: false,
                    fill: false,
                    data: arrEnam,
                    backgroundColor: '#a66969',
                    borderColor: '#a66969',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: '#a66969',
                }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                showAllTooltips: true,
                responsive: true,
                legend: {
                    display: true,
                    position: 'right'
                },
                maintainAspectRatio: true,
                title: {
                    display: true,
                    text: ''
                },
                legendCallback: function(chart) {
                    var ul = document.createElement('ul');
                    if (typeof chart.data.datasets[0] !== 'undefined') {
                        var backgroundColor = chart.data.datasets[0].backgroundColor;
                        var dataChart = chart.data.datasets[0].data;
                    }
                    return ul.outerHTML;
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: false,
                            labelString: 'Bulan'
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
                            labelString: 'Jumlah Pasien',
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
            <i class="fas fa-chart-pie"></i> Grafik Kunjungan ke Penunjang
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <table id="table-grafik-kunjunganpenunjang" class="table table-striped table-bordered table-condensed hide">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Lab PA</th>
                    <th>Lab Patologi Klinik</th>
                    <th>Mikrobiologi Klinik</th>
                    <th>Radiologi</th>
                    <th>Rehabilitasi Medik</th>
                    <th>MCU</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                <?php foreach ($grafik as $value) : ?>
                    <?php $periode = date('M Y', strtotime($value->periode)) ?>
                    <?php $satu = !empty($value->jumlah_labpa) ? $value->jumlah_labpa : 0; ?>
                    <?php $dua = !empty($value->jumlah_laboratorium) ? $value->jumlah_laboratorium : 0; ?>
                    <?php $tiga = !empty($value->jumlah_mikro) ? $value->jumlah_mikro : 0; ?>
                    <?php $empat = !empty($value->jumlah_radiologi) ? $value->jumlah_radiologi : 0 ?>
                    <?php $lima = !empty($value->jumlah_rehabilitasi) ? $value->jumlah_rehabilitasi : 0; ?>
                    <?php $enam = !empty($value->jumlah_mcu) ? $value->jumlah_mcu : 0; ?>
                    <tr>
                        <td><?php echo CHtml::activeTextField($value, '[' . $i . ']periode', array('readonly' => true, 'class' => 'periode', 'value' => $periode)); ?></td>
                        <td><?php echo CHtml::activeTextField($value, '[' . $i . ']jumlah_labpa', array('readonly' => true, 'class' => 'jumlah_labpa', 'value' => $satu)); ?></td>
                        <td><?php echo CHtml::activeTextField($value, '[' . $i . ']jumlah_laboratorium', array('readonly' => true, 'class' => 'jumlah_laboratorium', 'value' => $dua)); ?></td>
                        <td><?php echo CHtml::activeTextField($value, '[' . $i . ']jumlah_mikro', array('readonly' => true, 'class' => 'jumlah_mikro', 'value' => $tiga)); ?></td>
                        <td><?php echo CHtml::activeTextField($value, '[' . $i . ']jumlah_radiologi', array('readonly' => true, 'class' => 'jumlah_radiologi', 'value' => $empat)); ?></td>
                        <td><?php echo CHtml::activeTextField($value, '[' . $i . ']jumlah_rehabilitasi', array('readonly' => true, 'class' => 'jumlah_rehabilitasi', 'value' => $lima)); ?></td>
                        <td><?php echo CHtml::activeTextField($value, '[' . $i . ']jumlah_mcu', array('readonly' => true, 'class' => 'jumlah_mcu', 'value' => $enam)); ?></td>
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