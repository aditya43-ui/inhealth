<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
	var chart_line2;
	var chartDataLine2 = <?= json_encode($dataBarLineChart) ?>;
	var models = <?= json_encode($model) ?>;
	AmCharts.ready(function() {
		// generate some random data first
		// SERIAL CHART
		chart_line2 = new AmCharts.AmSerialChart();
		chart_line2.dataProvider = chartDataLine2;
		chart_line2.categoryField = "periode";
		chart_line2.dataDateFormat = "YYYY-MM-DD";
		// listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
		chart_line2.addListener("dataUpdated", zoomChart2);
		// AXES
		// category
		var categoryAxis2 = chart_line2.categoryAxis;
		categoryAxis2.parseDates = true; // as our data is date-based, we set parseDates to true
		if (models.jns_periode == "hari") {
			categoryAxis2.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
		}
		if (models.jns_periode == "bulan") {
			categoryAxis2.minPeriod = "MM"; // our data is daily, so we set minPeriod to DD
		}
		if (models.jns_periode == "tahun") {
			categoryAxis2.minPeriod = "YYYY"; // our data is daily, so we set minPeriod to DD
		}
		categoryAxis2.minorGridEnabled = true;
		categoryAxis2.axisColor = "#DADADA";
		categoryAxis2.twoLineMode = true;
		categoryAxis2.dateFormats = [{
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
		var valueAxis2 = new AmCharts.ValueAxis();
		valueAxis2.axisThickness = 2;
		valueAxis2.gridAlpha = 0;
		valueAxis2.position = "left";
		chart_line2.addValueAxis(valueAxis2);
		// second graph
		var graph2 = new AmCharts.AmGraph();
		graph2.valueAxis = valueAxis2; // we have to indicate which value axis should be used
		graph2.title = "ALOS";
		graph2.valueField = "jumlah_alos";
		graph2.bullet = "square";
		graph2.hideBulletsCount = 30;
		graph2.lineColor = "#003beb";
		graph2.bulletBorderThickness = 1;
		chart_line2.addGraph(graph2);
		// 4 graph
		var graph4 = new AmCharts.AmGraph();
		graph4.valueAxis = valueAxis2; // we have to indicate which value axis should be used
		graph4.title = "TOI";
		graph4.valueField = "jumlah_toi";
		graph4.bullet = "diamond";
		graph4.hideBulletsCount = 30;
		graph4.lineColor = "#00eb3b";
		graph4.bulletBorderThickness = 1;
		chart_line2.addGraph(graph4);
		// CURSOR
		var chartCursor2 = new AmCharts.ChartCursor();
		chartCursor2.cursorAlpha = 0.1;
		chartCursor2.fullWidth = true;
		chart_line2.addChartCursor(chartCursor2);
		// SCROLLBAR
		var chartScrollbar = new AmCharts.ChartScrollbar();
		chart_line2.addChartScrollbar(chartScrollbar);
		// LEGEND
		var legend2 = new AmCharts.AmLegend();
		legend2.marginLeft = 110;
		legend2.useGraphSettings = true;
		chart_line2.addLegend(legend2);
		// WRITE
		chart_line2.write("chartdiv2");
	});
	// this method is called when chart is first inited as we listen for "dataUpdated" event
	function zoomChart2() {
		// different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
		chart_line2.zoomToIndexes(0, 30);
	}
</script>
<div class="panel panel-success" style="margin-top: 17px">
	<div class="panel-heading">
		<div class="panel-title">
			<i class="fas fa-chart-pie"></i> Grafik Efisiensi Pelayanan(ALOS dan TOI)
		</div>
		<div class="panel-options">
			<a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
		</div>
	</div>
	<div class="panel-body">
		<div id="chartdiv2" style="width: 100%; height: 400px;"></div>
	</div>
</div>