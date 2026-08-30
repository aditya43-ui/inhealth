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

    var chart_bar_klp;
    var chartDataBarKlp = <?= json_encode($dataLineChartKlp) ?>;
    var models = <?= json_encode($model) ?>;

    AmCharts.ready(function () {
        // generate some random data first

        // SERIAL CHART
        chart_bar_klp = new AmCharts.AmSerialChart();
        chart_bar_klp.dataProvider = chartDataBarKlp;
        chart_bar_klp.categoryField = "periode";
		chart_bar_klp.startDuration = 1;
        chart_bar_klp.plotAreaBorderColor = "#DADADA";
        chart_bar_klp.plotAreaBorderAlpha = 1;
        chart_bar_klp.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
        // listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
        chart_bar_klp.addListener("dataUpdated", zoomChart);
        // AXES
        // category
        var categoryAxis = chart_bar_klp.categoryAxis;
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
        // first value axis (on the left)
        var valueAxis1 = new AmCharts.ValueAxis();
        valueAxis1.axisAlpha = 0;
        valueAxis1.gridAlpha = 0.1;
        valueAxis1.position = "left";
        chart_bar_klp.addValueAxis(valueAxis1);

        // GRAPHS
        chart_bar_klp.graphs = <?= json_encode($graphsLineKlp) ?>;



        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0.1;
        chartCursor.fullWidth = true;
        chart_bar_klp.addChartCursor(chartCursor);
        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart_bar_klp.addChartScrollbar(chartScrollbar);
        // LEGEND
        var legend = new AmCharts.AmLegend();
        chart_bar_klp.addLegend(legend);
		
		chart_bar_klp.creditsPosition = "top-right";
        // WRITE
        chart_bar_klp.write("barKlp");
    });
    // this method is called when chart is first inited as we listen for "dataUpdated" event
    function zoomChart() {
        // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
        chart_bar_klp.zoomToIndexes(0, 30);
    }
</script>
<div class="white-container">
    <div id="barKlp" style="width: 100%; height: 400px;"></div>
</div>





