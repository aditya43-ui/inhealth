<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
<?php
if ($model->jns_periode == "bulan") {
    $awal = $model->bln_awal;
    $akhir = $model->bln_akhir;
} elseif ($model->jns_periode == "tahun") {
    $awal = $model->thn_awal;
    $akhir = $model->thn_akhir;
} else {
    $awal = $model->tgl_awal;
    $akhir = $model->tgl_akhir;
}
?>
<script>
    //========== PIE =========
    var chart_pie;
    var legend;
    var chartDataPie = <?= json_encode($dataPieChart) ?>;
    AmCharts.ready(function() {
        // PIE CHART
        chart_pie = new AmCharts.AmPieChart();
        chart_pie.dataProvider = chartDataPie;
        chart_pie.titleField = "jenis";
        chart_pie.valueField = "jumlah";
        chart_pie.labelRadius = 30;
        chart_pie.labelText = "[[title]]: [[percents]]%";
        // WRITE
        chart_pie.write("pie");
    });
    // changes label position (labelRadius)
    function setLabelPosition() {
        if (document.getElementById("rb1").checked) {
            chart_pie.labelRadius = 30;
            chart_pie.labelText = "[[title]]: [[value]]";
        } else {
            chart_pie.labelRadius = -30;
            chart_pie.labelText = "[[percents]]%";
        }
        chart_pie.validateNow();
    }
    // makes chart 2D/3D
    function set3D() {
        if (document.getElementById("rb3").checked) {
            chart_pie.depth3D = 10;
            chart_pie.angle = 10;
        } else {
            chart_pie.depth3D = 0;
            chart_pie.angle = 0;
        }
        chart_pie.validateNow();
    }
    // changes switch of the legend (x or v)
    function setSwitch() {
        if (document.getElementById("rb5").checked) {
            legend.switchType = "x";
        } else {
            legend.switchType = "v";
        }
        legend.validateNow();
    }
    //========== END PIE =========
</script>
<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Pemakaian Obat dan Alkes
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div id="pie" style="width: 100%; height: 400px;"></div>
        <style>
            tr:last-child td input {
                margin: 0 5px 0 0 !important;
            }
        </style>
        <table style="width: 100%; color: #333;">
            <tr>
                <td style="width: 25%;">
                    <input type="radio" checked="true" name="group" id="rb1" onclick="setLabelPosition()">
                    <label for="rb1">Label di luar</label>
                </td>
                <td>
                    <input type="radio" name="group2" id="rb3" onclick="set3D()">
                    <label for="rb3">3D</label>
                </td>
                <td style="width: 125px;">
                    Legend switch type :
                </td>
                <td style="width: 45%;">
                    <input type="radio" checked="true" name="group3" id="rb5" onclick="setSwitch()">
                    <label for="rb5">X</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="radio" name="group" id="rb2" onclick="setLabelPosition()">
                    <label for="rb2">Label di dalam</label>
                </td>
                <td>
                    <input type="radio" checked="true" name="group2" id="rb4" onclick="set3D()">
                    <label for="rb4">2D</label>
                </td>
                <td>
                    &nbsp;
                </td>
                <td>
                    <input type="radio" name="group3" id="rb6" onclick="setSwitch()">
                    <label for="rb6">Y</label>
                </td>
            </tr>
        </table>
    </div>
</div>