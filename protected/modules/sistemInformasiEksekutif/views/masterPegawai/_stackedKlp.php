<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
    var chart_stacked_klp;

    var chartDataStackedKlp = <?= json_encode($dataStackChartKlp) ?>;
    var models = <?= json_encode($model) ?>;

    AmCharts.ready(function () {

        // SERIAL CHART
        chart_stacked_klp = new AmCharts.AmSerialChart();

        chart_stacked_klp.dataProvider = chartDataStackedKlp;
        chart_stacked_klp.categoryField = "periode";
        chart_stacked_klp.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
        // AXES
        // category
        var categoryAxis = chart_stacked_klp.categoryAxis;
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
        chart_stacked_klp.addValueAxis(valueAxis);

        // GRAPHS
        chart_stacked_klp.graphs = <?= json_encode($graphsStackKlp) ?>;

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = false;
        chart_stacked_klp.addChartCursor(chartCursor);

        // LEGEND
        var legend = new AmCharts.AmLegend();
        legend.marginLeft = 110;
//        legend.useGraphSettings = true;
        legend.align = "center";
        legend.equalWidths = false;
        legend.periodValueText = "Total: [[value.sum]]";
        legend.valueAlign = "left";
        legend.valueText = "[[value]] ([[percents]]%)";
        legend.valueWidth = 100;
        chart_stacked_klp.addLegend(legend);

        // WRITE
        chart_stacked_klp.write("stackedKlp");
    });

</script>
<div class="white-container">
    <div id="stackedKlp" style="width: 100%; height: 450px;"></div>
</div>


