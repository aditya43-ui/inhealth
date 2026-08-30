<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);


$axis_1 = array();
$axis_2 = array();

$sub = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);


$res_1 = array();
$res_suhu = array();
$res_nadi = array();
$res_napas = array();
$res_sistolik = array();
$res_diastolik = array();

$tgl_min = array();

if (count($riwayat) > 0) {
    foreach ($riwayat as $item) {
        if (empty($tgl_min[$item->tgl_monitoring])) {
            $tgl_min[$item->tgl_monitoring] = $item->tgl_monitoring;
        }
    }
}


if (count($tgl_min) > 0) {
    $tgl_min = array_values($tgl_min);
    $min = new DateTime($tgl_min[0]);
    $max = new DateTime($tgl_min[count($tgl_min) - 1]);

    $max->add(new DateInterval('P1D'));

    $period = new DatePeriod(
        $min,
        new DateInterval('P1D'),
        $max
    );

    foreach ($period as $item) {
        $res_1[$item->format('Y-m-d')] = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);
    }

}

foreach ($res_1 as $tgl=>$item) {
    foreach ($item as $jam) {
        if (empty($res_suhu[$tgl."_".$jam])) {
            $res_suhu[$tgl."_".$jam] = null;
        }
        if (empty($res_nadi[$tgl."_".$jam])) {
            $res_nadi[$tgl."_".$jam] = null;
        }
        if (empty($res_napas[$tgl."_".$jam])) {
            $res_napas[$tgl."_".$jam] = null;
        }
        if (empty($res_sistolik[$tgl."_".$jam])) {
            $res_sistolik[$tgl."_".$jam] = null;
        }
        if (empty($res_diastolik[$tgl."_".$jam])) {
            $res_diastolik[$tgl."_".$jam] = null;
        }
        if (empty($axis_1[$tgl."_".$jam])) {
            $axis_1[$tgl."_".$jam] = $jam;
        }
        if (empty($axis_2[$tgl."_".$jam])) {
            $axis_2[$tgl."_".$jam] = $jam == 6 ? (array($jam, date('d', strtotime($tgl))." ".MyFormatter::getMonthId(date('m', strtotime($tgl))))) : $jam;
        }
    }
}

foreach ($riwayat as $item) {
    $res_suhu[$item->tgl_monitoring."_".$item->jam_monitoring] = $item->suhu;
    $res_nadi[$item->tgl_monitoring."_".$item->jam_monitoring] = $item->nadi;
    $res_napas[$item->tgl_monitoring."_".$item->jam_monitoring] = $item->pernapasan;
    $res_sistolik[$item->tgl_monitoring."_".$item->jam_monitoring] = $item->td_systolic;
    $res_diastolik[$item->tgl_monitoring."_".$item->jam_monitoring] = $item->td_dyastolic;
}

$axis_1 = array_values($axis_1);
$axis_2 = array_values($axis_2);
$res_suhu = array_values($res_suhu);
$res_nadi = array_values($res_nadi);
$res_napas = array_values($res_napas);
$res_sistolik = array_values($res_sistolik);
$res_diastolik = array_values($res_diastolik);

// var_dump($axis_1, $axis_2, $res_suhu); die;

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Grafik Tanda Vital</div>
    </div>
    <div class="panel-body">
        <canvas id="chart_grafik_bayi">

        </canvas>
    </div>
</div>

<script>


var imgPA = new Image(12, 12);
imgPA.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/panah_atas.png'; ?>';

var imgDA = new Image(12, 12);
imgDA.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/panah_bawah.png'; ?>';

var imgS = new Image(12, 12);
imgS.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/silang.png'; ?>';

var imgPlus = new Image(12, 12);;
imgPlus.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/plus.png'; ?>';




$(document).ready(function() {

    var chart_grafik_bayi = $("#chart_grafik_bayi");

    var lineChart1 = new Chart(chart_grafik_bayi, {
        type: 'line',
        data: {
            labels: <?php echo CJSON::encode($axis_2); ?>,
            datasets: [
                {
                    label: 'Nadi',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($res_nadi); ?>,
                    backgroundColor: 'red',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: 'red',
                    fill: false,
                    borderColor: "red",
                },
                {
                    label: 'Pernapasan',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($res_napas); ?>,
                    backgroundColor: 'blue',
                    pointStyle: imgPlus,
                    pointRadius: 3,
                    pointBorderColor: 'blue',
                    fill: false,
                    borderColor: "blue",
                },
                {
                    label: 'Suhu',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($res_suhu); ?>,
                    backgroundColor: 'green',
                    pointStyle: imgS,
                    pointRadius: 3,
                    pointBorderColor: 'green',
                    fill: false,
                    borderColor: "green",
                },
                {
                    label: 'Systolic',
                    lineTension: 0,
                    display: false,
                    fill: false,
                    showLine: false,
                    data: <?php echo CJSON::encode($res_sistolik); ?>,
                    backgroundColor: 'black',
                    pointStyle: imgPA,
                    pointRadius: 3,
                    pointBorderColor: 'black',
                    fill: false,
                    borderColor: "black",
                },
                {
                    label: 'Diastolic',
                    lineTension: 0,
                    display: false,
                    fill: false,
                    showLine: false,
                    data: <?php echo CJSON::encode($res_diastolik); ?>,
                    backgroundColor: 'black',
                    pointStyle: imgDA,
                    pointRadius: 3,
                    pointBorderColor: 'black',
                    fill: false,
                    borderColor: "black",
                }
            ]
        },
        options: {
            animation: {
                duration: 0
            },
            spanGaps: true,
            bezierCurve: false,
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            legend: {
                display: true,
                labels: {
                    usePointStyle: true,
                },
            },
            scales: {
                xAxes: [{
                    ticks: {
                        callback: function(value, index, values) {
                            return value;
                        },
                        fontSize: 10
                    },
                    gridLines: {
                        zeroLineWidth: 4,
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, .5)'
                    }
                }],
                yAxes: [{
                    gridLines: {
                        color: 'rgba(0, 0, 0, .5)'
                    },
                    ticks: {
                        min: 0,
                        max: 220,
                        stepSize: 20,
                        beginAtZero: true,
                        fontSize: 10,
                        padding: 5
                    }
                }],
            },
            // responsive: false,
            /*
             tooltips: {
             mode: 'nearest',
             intersect: false,
             },
             responsive: true,

             */

        }
        /*
        ,
        plugins: [{
            beforeInit: function (chart) {
              chart.data.labels.forEach(function (e, i, a) {
                if (/\n/.test(e)) {
                  a[i] = e.split(/\n/);
                }
              })
            }
        }]
        *
         */
    });
});

</script>
