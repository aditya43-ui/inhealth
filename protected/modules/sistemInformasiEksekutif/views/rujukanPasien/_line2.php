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
        var arrSatu = [];
        var arrDua = [];
        var arrTiga = [];
        var arrEmpat = [];
        var arrBulan = [];
        var a = 0;
        $("#table-grafikTAT > tbody > tr").each(function() {
            console.log($(this).find(".periode").val());
            //1
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_rs").val() != '') {
                arrSatu[o] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah_rs").val(),
                };
                o++;
            }
            //2
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_klinik").val() != '') {
                arrDua[q] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah_klinik").val(),
                };
                q++;
            }
            //3
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_dokter").val() != '') {
                arrTiga[p] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah_dokter").val(),
                };
                p++;
            }
            //4
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_puskesmas").val() != '') {
                arrEmpat[r] = {
                    x: $(this).find(".periode").val(),
                    y: $(this).find(".jumlah_puskesmas").val(),
                };
                r++;
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
                    label: 'Rumah Sakit',
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
                    label: 'Klinik',
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
                    label: 'Dokter',
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
                    label: 'Puskesmas',
                    yAxisID: 'A',
                    display: false,
                    fill: false,
                    data: arrEmpat,
                    backgroundColor: '#00c0ef',
                    borderColor: '#00c0ef',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: '#00c0ef',
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
                            display: false,
                            labelString: '',
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
            <i class="fas fa-chart-pie"></i> Grafik Rujukan Pasien
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <table id="table-grafikTAT" class="table table-striped table-bordered table-condensed hide">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Rumah Sakit</th>
                    <th>Klinik</th>
                    <th>Dokter</th>
                    <th>Puskesmas</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                <?php foreach ($grafik as $value) : ?>
                    <?php $periode = date('M Y', strtotime($value->periode)) ?>
                    <tr>
                        <td><?php echo CHtml::activeHiddenField($value, '[' . $i . ']periode', array('readonly' => true, 'class' => 'periode', 'value' => $periode)); ?></td>
                        <td><?php echo CHtml::activeHiddenField($value, '[' . $i . ']jumlah_rs', array('readonly' => true, 'class' => 'jumlah_rs')); ?></td>
                        <td><?php echo CHtml::activeHiddenField($value, '[' . $i . ']jumlah_klinik', array('readonly' => true, 'class' => 'jumlah_klinik')); ?></td>
                        <td><?php echo CHtml::activeHiddenField($value, '[' . $i . ']jumlah_dokter', array('readonly' => true, 'class' => 'jumlah_dokter')); ?></td>
                        <td><?php echo CHtml::activeHiddenField($value, '[' . $i . ']jumlah_puskesmas', array('readonly' => true, 'class' => 'jumlah_puskesmas')); ?></td>
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