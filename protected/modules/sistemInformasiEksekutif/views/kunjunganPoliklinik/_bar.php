<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
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
    //========== BAR ========
    var chart_bar;
    var chartDataBar = <?= json_encode($dataBarLineChart) ?>;
    var models = <?= json_encode($model) ?>;
    AmCharts.ready(function() {
        // SERIAL CHART
        chart_bar = new AmCharts.AmSerialChart();
        chart_bar.dataProvider = chartDataBar[1];
        chart_bar.categoryField = "periode";
        chart_bar.startDuration = 1;
        chart_bar.plotAreaBorderColor = "#DADADA";
        chart_bar.plotAreaBorderAlpha = 1;
        chart_bar.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
        // this single line makes the chart a bar chart
        //                chart_bar.rotate = true;
        // AXES
        // Category
        var categoryAxis = chart_bar.categoryAxis;
        categoryAxis.gridPosition = "start";
        categoryAxis.gridAlpha = 0.1;
        categoryAxis.axisAlpha = 0;
        categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
        if (models.jns_periode == "hari") {
            categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
        }
        if (models.jns_periode == "bulan") {
            categoryAxis.minPeriod = "MM"; // our data is daily, so we set minPeriod to DD
        }
        if (models.jns_periode == "tahun") {
            categoryAxis.minPeriod = "YYYY"; // our data is daily, so we set minPeriod to DD
        }
        categoryAxis.gridPosition = "start";
        categoryAxis.gridAlpha = 0.1;
        categoryAxis.axisAlpha = 0;
        categoryAxis.dateFormats = [{
            period: 'fff',
            format: 'JJ:NN:SS'
        }, {
            period: 'ss',
            format: 'JJ:NN:SS'
        }, {
            period: 'mm',
            format: 'JJ:NN'
        }, {
            period: 'hh',
            format: 'JJ:NN'
        }, {
            period: 'DD',
            format: 'DD'
        }, {
            period: 'WW',
            format: 'DD'
        }, {
            period: 'MM',
            format: 'MMM'
        }, {
            period: 'YYYY',
            format: 'YYYY'
        }];
        // Value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.axisAlpha = 0;
        valueAxis.gridAlpha = 0.1;
        valueAxis.position = "bottom";
        chart_bar.addValueAxis(valueAxis);
        // GRAPHS
        // first graph
        var graph = new AmCharts.AmGraph();
        graph.valueField = "jumlah";
        graph.type = "column";
        graph.balloonText = "[[value]]";
        graph.lineAlpha = 0;
        graph.fillAlphas = 1;
        chart_bar.addGraph(graph);
        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0.1;
        chartCursor.fullWidth = true;
        chart_bar.addChartCursor(chartCursor);
        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart_bar.addChartScrollbar(chartScrollbar);
        chart_bar.creditsPosition = "top-right";
        // WRITE
        chart_bar.write("chartdiv");
    });

    function setDataSet(pelayanan_id) {
        chart_bar.dataProvider = chartDataBar[pelayanan_id];
        chart_bar.validateData();
    }
</script>
<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Kunjungan Poliklinik - Periode <?php echo $awal; ?> sd <?php echo $akhir; ?>
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="form-group" style="float: left;
             text-align: left;
             font-weight: normal;">
            <label for="pelayanan">Poliklinik:</label>
            <select class="" id="pelayanan" onchange="setDataSet(this.options[this.selectedIndex].value);" style="display: inline-block;
                    width: auto;">
                <?php
                foreach ($dataRuangan as $data) {
                    $id = $data['id'];
                    $nama = $data['nama'];
                ?>
                    <option value="<?php echo $id; ?>"><?php echo $nama; ?></option>
                <?php } ?>
            </select>
        </div>
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
    </div>
</div>