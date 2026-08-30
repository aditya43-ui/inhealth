<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
	var chart_line;
	
	var chartDataLine = <?=json_encode($dataBarLineChart)?>;

	AmCharts.ready(function () {
		// generate some random data first

		// SERIAL CHART
		chart_line = new AmCharts.AmSerialChart();

		chart_line.dataProvider = chartDataLine;
		chart_line.categoryField = "periode";

		// listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
		chart_line.addListener("dataUpdated", zoomChart);

		// AXES
		// category
		var categoryAxis = chart_line.categoryAxis;
		categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
		categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
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
			 format: 'MMM'
		 }, {
			 period: 'YYYY',
			 format: 'YYYY'
		 }];

		// first value axis (on the left)
		var valueAxis1 = new AmCharts.ValueAxis();
		valueAxis1.axisColor = "#FF6600";
		valueAxis1.axisThickness = 2;
		valueAxis1.gridAlpha = 0;
		chart_line.addValueAxis(valueAxis1);

		// GRAPHS
		// first graph
		var graph1 = new AmCharts.AmGraph();
		graph1.valueAxis = valueAxis1; // we have to indicate which value axis should be used
		graph1.title = "Rawat Inap";
		graph1.valueField = "jumlah_ri";
		graph1.bullet = "round";
		graph1.hideBulletsCount = 30;
		graph1.bulletBorderThickness = 1;
		chart_line.addGraph(graph1);

		// second graph
		var graph2 = new AmCharts.AmGraph();
		graph2.valueAxis = valueAxis1; // we have to indicate which value axis should be used
		graph2.title = "Rawat Darurat";
		graph2.valueField = "jumlah_rd";
		graph2.bullet = "square";
		graph2.hideBulletsCount = 30;
		graph2.bulletBorderThickness = 1;
		chart_line.addGraph(graph2);

		// 3 graph
		var graph3 = new AmCharts.AmGraph();
		graph3.valueAxis = valueAxis1; // we have to indicate which value axis should be used
		graph3.title = "Rawat Jalan";
		graph3.valueField = "jumlah_rj";
		graph3.bullet = "diamond";
		graph3.hideBulletsCount = 30;
		graph3.bulletBorderThickness = 1;
		chart_line.addGraph(graph3);

		// CURSOR
		var chartCursor = new AmCharts.ChartCursor();
		chartCursor.cursorAlpha = 0.1;
		chartCursor.fullWidth = true;
		chart_line.addChartCursor(chartCursor);

		// SCROLLBAR
		var chartScrollbar = new AmCharts.ChartScrollbar();
		chart_line.addChartScrollbar(chartScrollbar);

		// LEGEND
		var legend = new AmCharts.AmLegend();
		legend.marginLeft = 110;
		legend.useGraphSettings = true;
		chart_line.addLegend(legend);

		// WRITE
		chart_line.write("chartdiv");
	});

	// this method is called when chart is first inited as we listen for "dataUpdated" event
	function zoomChart() {
		// different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
		chart_line.zoomToIndexes(0, 30);
	}
 </script>
<div class="white-container">
	<div id="chartdiv" style="width: 100%; height: 400px;"></div>
</div>
		
