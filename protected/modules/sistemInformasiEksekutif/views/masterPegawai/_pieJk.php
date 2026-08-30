<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
<script>
    //========== PIE =========
    var chart_pie_jk;
    var jklegend;

    var chartDataPieJk = <?= json_encode($dataPieChartJk) ?>;
    AmCharts.ready(function () {
        // PIE CHART
        chart_pie_jk = new AmCharts.AmPieChart();
        chart_pie_jk.dataProvider = chartDataPieJk;
        chart_pie_jk.titleField = "jenis";
        chart_pie_jk.valueField = "jumlah";
		chart_pie_jk.colors = ["#0081D1","#FF334B"];
		chart_pie_jk.depth3D = 10;
		chart_pie_jk.angle = 10;
		chart_pie_jk.labelRadius = -30;
		chart_pie_jk.labelText = "[[percents]]%";
		chart_pie_jk.titles = [
            {
                "text": "Grafik Jumlah Pegawai Berdasarkan Jenis Kelamin",
                "size": 15
            }
        ];
        
        // LEGEND
        jklegend = new AmCharts.AmLegend();
        jklegend.align = "center";
        jklegend.markerType = "circle";
        chart_pie_jk.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart_pie_jk.addLegend(jklegend);

        // WRITE
        chart_pie_jk.write("pieJk");
    });
    //========== END PIE =========

</script>
<div class="white-container">
    <div id="pieJk" style="width: 100%; height: 400px;"></div>
</div>




