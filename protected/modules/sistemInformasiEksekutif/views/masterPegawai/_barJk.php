<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
    var chart_bar_jk;

    var chartDataBarJk = <?= json_encode($dataBarLineChartJk) ?>;
    var models = <?= json_encode($model) ?>;

    AmCharts.ready(function () {
        // generate some random data first

        // SERIAL CHART
        chart_bar_jk = new AmCharts.AmSerialChart();

        chart_bar_jk.dataProvider = chartDataBarJk;
        chart_bar_jk.categoryField = "periode";
		chart_bar_jk.startDuration = 1;
        chart_bar_jk.plotAreaBorderColor = "#DADADA";
        chart_bar_jk.plotAreaBorderAlpha = 1;
        chart_bar_jk.dataDateFormat = "YYYY-MM-DD";
        // listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
        chart_bar_jk.addListener("dataUpdated", zoomChartJk);
		chart_bar_jk.titles = [
            {
                "text": "Grafik Jumlah Pegawai Berdasarkan Jenis Kelamin",
                "size": 15
            }
        ];

        // AXES
        // category
        var categoryAxis = chart_bar_jk.categoryAxis;
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
        chart_bar_jk.addValueAxis(valueAxis1);

        // GRAPHS
        // first graph
        var graph1 = new AmCharts.AmGraph();
        graph1.type = "column"; 
        graph1.title = "Laki - laki";
        graph1.valueField = "jumlah_lakilaki";
        graph1.balloonText = "[[title]]:[[value]]";
        graph1.lineAlpha = 0;
        graph1.fillColors = "#B5D100";
        graph1.fillAlphas = 1;
        chart_bar_jk.addGraph(graph1);

        // second graph
        var graph2 = new AmCharts.AmGraph();
        graph2.type = "column";
        graph2.title = "Perempuan";
        graph2.valueField = "jumlah_perempuan";
        graph2.balloonText = "[[title]]:[[value]]";
        graph2.lineAlpha = 0;
        graph2.fillColors = "#1C00D1";
        graph2.fillAlphas = 1;
        chart_bar_jk.addGraph(graph2);

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0.1;
        chartCursor.fullWidth = true;
        chart_bar_jk.addChartCursor(chartCursor);

        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart_bar_jk.addChartScrollbar(chartScrollbar);

        // LEGEND
        var legend = new AmCharts.AmLegend();
        chart_bar_jk.addLegend(legend);

        chart_bar_jk.creditsPosition = "top-right";

        // WRITE
        chart_bar_jk.write("barJk");
    });

    // this method is called when chart is first inited as we listen for "dataUpdated" event
    function zoomChartJk() {
        // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
        chart_bar_jk.zoomToIndexes(0, 30);
    }
</script>

    <div class="white-container">
        <div id="barJk" style="width: 100%; height: 400px;"></div>
    </div>


