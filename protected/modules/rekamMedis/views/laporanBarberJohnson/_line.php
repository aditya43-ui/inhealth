<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/xy.js', CClientScript::POS_BEGIN); ?>

<?php

// var_dump(CJSON::encode($dataBarLineChart)); die;

?>

<script>
    var chart_line = [{
        "ax": 0,
        "ay": 0,
        "bx": 0,
        "by": 0,
        "cx": 0,
        "cy": 0,
        "dx": 0,
        "dy": 0,
        "ex": 12.1667,
        "ey": 0,
        "fx": 18.25,
        "fy": 0,
        "gx": 24.3333,
        "gy": 0,
        "hx": 29.2000,
        "hy": 0,
    }, {
        "ax": 32 / 9,
        "ay": 32,
        "bx": 8,
        "by": 32,
        "cx": 10,
        "cy": 70 / 3,
        "dx": 10,
        "dy": 10,
        "ex": 0,
        "ey": 12.1667,
        "fx": 0,
        "fy": 18.25,
        "gx": 0,
        "gy": 24.3333,
        "hx": 0,
        "hy": 29.2000,
    }];

    var running = <?php echo !empty($dataBarLineChart) ? CJSON::encode($dataBarLineChart) : "[]"; ?>;

    for (var ii = 0; ii < running.length; ii++) {
        chart_line[chart_line.length] = running[ii];
    }


    var chart = AmCharts.makeChart("chartdiv", {
        "type": "xy",
        // "theme": "light",
        "sequencedAnimation": false,
        "startDuration": 1,
        "autoMarginOffset": 20,
        "dataProvider": chart_line,
        "valueAxes": [{
            "position": "bottom",
            "axisAlpha": 0,
            "dashLength": 1,
            "title": "Turn Over Interval",
            "maximum": 10,
            "autoGridCount": false,
            "gridCount": 10
        }, {

            "axisAlpha": 0,
            "dashLength": 1,
            "position": "left",
            "title": "Length of Stay",
            "maximum": 32,
            //"autoGridCount": false,
            "gridCount": 32,
            "step": 2
        }],
        "startDuration": 1,
        "graphs": [{
                "balloonText": "x:[[x]] y:[[y]]",
                "lineAlpha": 1,
                "xField": "ax",
                "yField": "ay",
                "lineColor": "#FF6600",
                "fillAlphas": 0,
                "labelText": "BOR 90%",
                "labelPosition": "bottom",
            }, {
                "balloonText": "x:[[x]] y:[[y]]",
                "lineAlpha": 1,
                "xField": "bx",
                "yField": "by",
                "lineColor": "#FF6600",
                "fillAlphas": 0,
                "labelText": "BOR 80%",
                "labelPosition": "bottom",
            }, {
                "balloonText": "x:[[x]] y:[[y]]",
                "lineAlpha": 1,
                "xField": "cx",
                "yField": "cy",
                "lineColor": "#FF6600",
                "fillAlphas": 0,
                "labelText": "BOR 70%",
                "labelPosition": "left",
            }, {
                "balloonText": "x:[[x]] y:[[y]]",
                "lineAlpha": 1,
                "xField": "dx",
                "yField": "dy",
                "lineColor": "#ff6600",
                "fillAlphas": 0,
                "labelText": "BOR 50%",
                "labelPosition": "left",
            }, {
                "balloonText": "x:[[x]] y:[[y]]",
                "lineAlpha": 1,
                "xField": "ex",
                "yField": "ey",
                "lineColor": "#0000FF",
                "fillAlphas": 0,
                "labelText": "BTO 30",
                "labelPosition": "right",
            }, {
                "balloonText": "x:[[x]] y:[[y]]",
                "lineAlpha": 1,
                "xField": "fx",
                "yField": "fy",
                "lineColor": "#0000FF",
                "fillAlphas": 0,
                "labelText": "BTO 20",
                "labelPosition": "right",
            }, {
                "balloonText": "x:[[x]] y:[[y]]",
                "lineAlpha": 1,
                "xField": "gx",
                "yField": "gy",
                "lineColor": "#0000FF",
                "fillAlphas": 0,
                "labelText": "BTO 15",
                "labelPosition": "right",
            }, {
                "balloonText": "x:[[x]] y:[[y]]",
                "lineAlpha": 1,
                "xField": "hx",
                "yField": "hy",
                "lineColor": "#0000FF",
                "fillAlphas": 0,
                "labelText": "BTO 12.5",
                "labelPosition": "right",
            },
            {
                "balloonText": "[[date]]\nBOR:[[val_bor_persen]]%\nTOI:[[val_toi_format]] \nLOS:[[val_alos_format]]",
                "lineAlpha": 1,
                "bullet": "round",
                "bulletAlpha": 1,
                "xField": "val_toi",
                "yField": "val_alos",
                "lineColor": "#000000",
                "fillAlphas": 0,
                "labelText": "[[date]]",
            }
        ],
        "marginLeft": 64,
        "marginBottom": 60,
        "export": {
            "enabled": true,
            "position": "bottom-right"
        }
    });
</script>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-bar"></i> Grafik Barber-Johnson
        </div>
        <!-- <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="glyphicon glyphicon-chevron-down" style="color: #fff;"></i></a>
        </div> -->
    </div>

    <div class="panel-body">
        <div id="chartdiv" style="width: 100%; height: 500px;"></div>
    </div>
</div>