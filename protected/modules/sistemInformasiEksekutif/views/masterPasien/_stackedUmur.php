<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
    var chart_stacked_umur;

    var chartDataStackedUmur = <?= json_encode($dataStackChartUmur) ?>;
    var models = <?= json_encode($model) ?>;

    AmCharts.ready(function () {

        // SERIAL CHART
        chart_stacked_umur = new AmCharts.AmSerialChart();

        chart_stacked_umur.dataProvider = chartDataStackedUmur;
        chart_stacked_umur.categoryField = "periode";
        chart_stacked_umur.plotAreaBorderAlpha = 0;
        chart_stacked_umur.marginLeft = 0;
        chart_stacked_umur.marginBottom = 0;
        chart_stacked_umur.startDuration = 1;
        chart_stacked_umur.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
        chart_stacked_umur.titles = [
            {
                "text": "Grafik Pertumbuhan Jumlah Pasien Berdasarkan Usia",
                "size": 15
            }
        ];
        // AXES
        // category
        var categoryAxis = chart_stacked_umur.categoryAxis;
        categoryAxis.startOnAxis = true;
        categoryAxis.axisColor = "#DADADA";
        categoryAxis.gridAlpha = 0.07;
        categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
        if(models.jns_periode == "hari"){
                    categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
        }
        if(models.jns_periode == "bulan"){
                    categoryAxis.minPeriod = "MM"; // our data is daily, so we set minPeriod to DD
        }
        if(models.jns_periode == "tahun"){
                    categoryAxis.minPeriod = "YYYY"; // our data is daily, so we set minPeriod to DD
        }
        categoryAxis.minorGridEnabled = true;
        categoryAxis.axisColor = "#DADADA";
        categoryAxis.twoLineMode = true;
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
                format: 'MM'
            }, {
                period: 'YYYY',
                format: 'YYYY'
            }];

        // first value axis (on the left)
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.stackType = "regular";
        valueAxis.gridAlpha = 0;
        valueAxis.position = "left";
        chart_stacked_umur.addValueAxis(valueAxis);

        // GRAPHS
        chart_stacked_umur.graphs = <?= json_encode($graphsStackUmur) ?>;

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = false;
        chart_stacked_umur.addChartCursor(chartCursor);

        // LEGEND
        var umurStacklegend = new AmCharts.AmLegend();
        umurStacklegend.marginLeft = 110;
//        legend.useGraphSettings = true;
        umurStacklegend.align = "center";
        umurStacklegend.equalWidths = false;
        umurStacklegend.periodValueText = "Total: [[value.sum]]";
        umurStacklegend.valueAlign = "left";
        umurStacklegend.valueText = "[[value]] ([[percents]]%)";
        umurStacklegend.valueWidth = 100;
        chart_stacked_umur.addLegend(umurStacklegend);

        // WRITE
        chart_stacked_umur.write("stackedUmur");
    });

</script>
<div class="white-container">
    <div id="stackedUmur" style="width: 100%; height: 400px;"></div>
</div>


