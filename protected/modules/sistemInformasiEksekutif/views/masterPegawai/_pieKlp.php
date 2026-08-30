<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
<script>
    //========== PIE =========
    var chart_pie_klp;
    var legend;

    var chartDataPieKlp = <?= json_encode($dataPieChartKlp) ?>;

    AmCharts.ready(function () {
        // PIE CHART
        chart_pie_klp = new AmCharts.AmPieChart();
        chart_pie_klp.dataProvider = chartDataPieKlp;
        chart_pie_klp.titleField = "jenis";
        chart_pie_klp.valueField = "jumlah";
		chart_pie_klp.labelRadius = -30;
        chart_pie_klp.labelText = "[[percents]]%";
		chart_pie_klp.depth3D = 10;
        chart_pie_klp.angle = 10;

        // LEGEND
        legend = new AmCharts.AmLegend();
        legend.align = "center";
        legend.markerType = "circle";
        chart_pie_klp.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart_pie_klp.addLegend(legend);

        // WRITE
        chart_pie_klp.write("pieKlp");
    });

    // changes label position (labelRadius)
    function setLabelPosition() {
        if (document.getElementById("rb1").checked) {
            chart_pie_klp.labelRadius = 30;
            chart_pie_klp.labelText = "[[title]]: [[value]]";
        } else {
            chart_pie_klp.labelRadius = -30;
            chart_pie_klp.labelText = "[[percents]]%";
        }
        chart_pie_klp.validateNow();
    }


    // makes chart 2D/3D
    function set3D() {
        if (document.getElementById("rb3").checked) {
            chart_pie_klp.depth3D = 10;
            chart_pie_klp.angle = 10;
        } else {
            chart_pie_klp.depth3D = 0;
            chart_pie_klp.angle = 0;
        }
        chart_pie_klp.validateNow();
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
    <div id="pieKlp" style="width: 100%; height: 450px;"></div>
</div>




