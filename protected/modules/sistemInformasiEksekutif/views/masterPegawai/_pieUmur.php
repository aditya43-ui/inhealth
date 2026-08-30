<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
<script>
	//========== PIE =========
	var chart_pie_umur;
	var legend;

	var chartDataPieUmur = <?= json_encode($dataPieChartUmur) ?>;
	var chartDataPieUmurDet = <?= json_encode($dataPieChartUmurDet) ?>;
	AmCharts.ready(function () {
		// PIE CHART
		chart_pie_umur = new AmCharts.AmPieChart();
		chart_pie_umur.dataProvider = chartDataPieUmurDet;
		chart_pie_umur.titleField = "jenis";
		chart_pie_umur.valueField = "jumlah";
		chart_pie_umur.labelRadius = -30;
		chart_pie_umur.labelText = "[[percents]]%";
		chart_pie_umur.depth3D = 10;
		chart_pie_umur.angle = 10;
		chart_pie_umur.titles = [
            {
                "text": "Persentase Jumlah Pegawai Berdasarkan Kelompok Umur",
                "size": 15
            }
        ];
//		chart_pie_umur.pulledField = "pulled";
//		// AN EVENT TO HANDLE SLICE CLICKS
//		chart_pie_umur.addListener("clickSlice", function (event) {
//			if (event.dataItem.dataContext.id != undefined) {
//				selected = event.dataItem.dataContext.id;
//			}
//			else {
//				selected = undefined;
//			}
//			chart_pie_umur.dataProvider = chartDataPieUmurDet;
//			chart_pie_umur.validateData();
//		});

		// LEGEND
		legend = new AmCharts.AmLegend();
		legend.align = "center";
		legend.markerType = "circle";
		chart_pie_umur.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
		chart_pie_umur.addLegend(legend);

		// WRITE
		chart_pie_umur.write("pieUmur");
	});

	// changes label position (labelRadius)
	function setLabelPosition() {
		if (document.getElementById("rb1").checked) {
			chart_pie_umur.labelRadius = 30;
			chart_pie_umur.labelText = "[[title]]: [[value]]";
		} else {
			chart_pie_umur.labelRadius = -30;
			chart_pie_umur.labelText = "[[percents]]%";
		}
		chart_pie_umur.validateNow();
	}


	// makes chart 2D/3D
	function set3D() {
		if (document.getElementById("rb3").checked) {
			chart_pie_umur.depth3D = 10;
			chart_pie_umur.angle = 10;
		} else {
			chart_pie_umur.depth3D = 0;
			chart_pie_umur.angle = 0;
		}
		chart_pie_umur.validateNow();
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
<div class="white-container">
	<div id="pieUmur" style="width: 100%; height: 400px;"></div>
</div>




