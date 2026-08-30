<?php

$status = StatusbedahanastesilokalT::model()->findByAttributes(array(
    'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id
));

$model = BedahanastesilokalIntraopT::model()->findAllByAttributes(array(
    'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id,
), array(
    'order'=>'pemeriksaanke',
));




Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);

$nadi = array();
$nafas = array();
$suhu = array();
$systolic = array();
$diastolic = array();
$time_x = array();

$counter = array();

if (count((array)$model) > 0) {
    
    
    $jam_akhir_proto = strtotime($model[count((array)$model) - 1]->observasi_jam);
    
    $jam_mulai_anestesi = (empty($status) || empty($status->jam_mulaianestesi)) ? 0 : strtotime($status->jam_mulaianestesi);
    $jam_selesai_anestesi = (empty($status) || empty($status->jam_selesaianestesi)) ? 0 : strtotime($status->jam_selesaianestesi);
    $jam_mulai_tindakan = (empty($status) || empty($status->jam_mulaitindakanbedah)) ? 0 : strtotime($status->jam_mulaitindakanbedah);
    $jam_selesai_tindakan = (empty($status) || empty($status->jam_selesaitindakanbedah)) ? 0 : strtotime($status->jam_selesaitindakanbedah);
    
    
    $jam_akhir_proto = $jam_akhir_proto < $jam_mulai_anestesi ? $jam_mulai_anestesi : $jam_akhir_proto;
    $jam_akhir_proto = $jam_akhir_proto < $jam_selesai_anestesi ? $jam_selesai_anestesi : $jam_akhir_proto;
    $jam_akhir_proto = $jam_akhir_proto < $jam_mulai_tindakan ? $jam_mulai_tindakan : $jam_akhir_proto;
    $jam_akhir_proto = $jam_akhir_proto < $jam_selesai_tindakan ? $jam_selesai_tindakan : $jam_akhir_proto;
    
    // var_dump($status->attributes); die;
    
    $jam_mulai_anestesi = date('H:i', floor(($jam_mulai_anestesi / (15 * 60)) * (15 * 60)));
    $jam_selesai_anestesi = date('H:i', floor(($jam_selesai_anestesi / (15 * 60)) * (15 * 60)));
    $jam_mulai_tindakan = date('H:i', floor(($jam_mulai_tindakan / (15 * 60)) * (15 * 60)));
    $jam_selesai_tindakan = date('H:i', floor(($jam_selesai_tindakan / (15 * 60)) * (15 * 60)));
    
    
    $jam_awal = new DateTime(date('H:i:s', floor(strtotime($model[0]->observasi_jam) / (15 * 60)) * (15 * 60)));
    $jam_akhir = new DateTime(date('H:i:s', (15 * 60) + (floor($jam_akhir_proto /(15 * 60)) * (15 * 60))));
    
    $interval = DateInterval::createFromDateString('15 minutes');
    $period = new DatePeriod($jam_awal, $interval, $jam_akhir);
    
    // var_dump($jam_mulai_anestesi, $jam_selesai_anestesi, $jam_mulai_tindakan, $jam_selesai_tindakan); die;
    
    
    
    $cnt = 0;
    foreach ($period as $item) {
        $sym = "";
        if ($item->format('H:i') == $jam_mulai_anestesi) {
            $sym .= "\nx▲";
        } 
        if ($item->format('H:i') == $jam_selesai_anestesi) {
            $sym .= "\nx▼";
        }
        if ($item->format('H:i') == $jam_mulai_tindakan) {
            $sym .= "\n◯►";
        }
        if ($item->format('H:i') == $jam_selesai_tindakan) {
            $sym .= "\n◯◄ ";
        }
        
        $counter[$item->format('H:i')] = $cnt;
        $time_x[$cnt] = $item->format('H:i').$sym;
        $nadi[$cnt] = null;
        $suhu[$cnt] = null;
        $nafas[$cnt] = null;
        $systolic[$cnt] = null;
        $diastolic[$cnt] = null;
        
//        if ($item->format('H:i') == $jam_mulai_anestesi) {
//            $time_x[$cnt] .= '\nX▲';
//        }
        
        $cnt++;
    }
    
    foreach ($model as $item) {
        $waktu = new DateTime(date('H:i:s', floor(strtotime($item->observasi_jam) / (15 * 60)) * (15 * 60)));
        
        $nadi[$counter[$waktu->format('H:i')]] = $item->detaknadi;
        $nafas[$counter[$waktu->format('H:i')]] = $item->respirasi_nilai;
        $systolic[$counter[$waktu->format('H:i')]] = $item->td_systolic;
        $diastolic[$counter[$waktu->format('H:i')]] = $item->td_dyastolic;
        $suhu[$counter[$waktu->format('H:i')]] = $item->suhubadan;
    }
    
//    var_dump($time_x, $nadi, $nafas, $systolic, $diastolic);
//    die;
    
    
    
    
    
    
//    var_dump($jam_awal, $jam_akhir); die;
    
    
}



?>

<style>
    
    
    .leg_bottom {
        border: 1px solid black;
        width: 100%;
        margin-bottom: 10px;
    }
    
    .leg_bottom td {
        padding : 5px;
        text-align: center;
        width: 25%;
    }
    
</style>

<canvas id="chart_durante">

</canvas>
<table class="leg_bottom">
    <tr>
        <td>x▲ Mulai Anestesi</td>
        <td>x▼ Selesai Kegiatan Anestesi</td>
        <td>◯► Mulai Tindakan Bedah</td>
        <td>◯◄ Selesai Tindakan Bedah</td>
    </tr>
</table>


<script>

var imgPA = new Image(12, 12);
imgPA.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/panah_atas.png'; ?>';

var imgDA = new Image(12, 12);
imgDA.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/panah_bawah.png'; ?>';

var imgS = new Image(12, 12);
imgS.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/silang.png'; ?>';

var imgPlus = new Image(12, 12);;
imgPlus.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/plus.png'; ?>';


$(document).ready(function() {
    
    var durante = $("#chart_durante");
    
    var lineChart1 = new Chart(durante, {
        type: 'line',
        data: {
            labels: <?php echo CJSON::encode($time_x); ?>,
            datasets: [
                {
                    label: 'Nadi',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($nadi); ?>,
                    backgroundColor: 'black',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: 'black',
                    fill: false,
                    borderColor: "black",
                },
                {
                    label: 'Pernapasan',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($nafas); ?>,
                    backgroundColor: 'white',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: 'black',
                    fill: false,
                    borderColor: "blue",
                },
                {
                    label: 'Suhu',
                    lineTension: 0,
                    display: false,
                    data: <?php echo CJSON::encode($suhu); ?>,
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
                    data: <?php echo CJSON::encode($systolic); ?>,
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
                    data: <?php echo CJSON::encode($diastolic); ?>,
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
//                xAxes: [{
//                    type: "time",
//                    time: {
//                        parser: "HH:mm",
//                        unit: 'minute',
//                        unitStepSize: 15,
//                        displayFormats: {
//                            'hour': 'HH:mm',
//                            'minute': 'HH:mm',
//                        },
//                        //tooltipFormat: 'HH:mm'
//                    },
//                    ticks: {
//                        callback: function(value, index, values) {
//
//                            return value;
//
//
//                        }
//                    },
//                    gridLines: {
//                        zeroLineWidth: 4,
//                        drawBorder: false,
//                        color: 'rgba(0, 0, 0, .5)'
//                    }
//                }],
                yAxes: [{
                    gridLines: {
                        color: 'rgba(0, 0, 0, .5)'
                    },
                    ticks: {
                        min: 0,
                        max: 220,
                        stepSize: 10,
                        beginAtZero: true,
                        fontSize: 9,
                        padding: 5
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontSize: 9
                    }
                }]
            },
            // responsive: false,
            /*
             tooltips: {
             mode: 'nearest',
             intersect: false,
             },
             responsive: true,

             */

        },
        plugins: [{
            beforeInit: function (chart) {
              chart.data.labels.forEach(function (e, i, a) {
                if (/\n/.test(e)) {
                  a[i] = e.split(/\n/);
                }
              })
            }
        }]
    });
});

</script>