<style>
    .table {
        border-radius: none;
        box-shadow: none;
        border-collapse: collapse;
        border: 1px solid black;
    }

    .table th,
    .table td {
        border: 1px solid black;
        padding: 2px;
    }
</style>
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => '20'));



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
$offset = 0;

$waktu_lama = 0;
foreach ($model as $item) {
    $item->waktu2 = strtotime($item->observasi_jam);
    $item->waktu2 += (24 * 3600) * $offset;
    if ($waktu_lama > $item->waktu2) {
        $offset++;
        $item->waktu2 += (24 * 3600) * $offset;
    }

    $waktu_lama = $item->waktu2;

    //    var_dump(date('Y-m-d H:i', $item->waktu2));
}

if (count((array)$model) > 0) {

    // $jam_akhir_proto = strtotime($model[count((array)$model) - 1]->observasi_jam);
    $jam_akhir_proto = $model[count((array)$model) - 1]->waktu2;


    $jam_mulai_anestesi = (empty($status) || empty($status->jam_mulaianestesi)) ? 0 : strtotime($status->jam_mulaianestesi);
    $jam_selesai_anestesi = (empty($status) || empty($status->jam_selesaianestesi)) ? 0 : strtotime($status->jam_selesaianestesi);
    $jam_mulai_tindakan = (empty($status) || empty($status->jam_mulaitindakanbedah)) ? 0 : strtotime($status->jam_mulaitindakanbedah);
    $jam_selesai_tindakan = (empty($status) || empty($status->jam_selesaitindakanbedah)) ? 0 : strtotime($status->jam_selesaitindakanbedah);

    if ($jam_selesai_anestesi < $jam_mulai_anestesi) {
        $jam_selesai_anestesi += (24 * 3600);
    }

    if ($jam_selesai_tindakan < $jam_mulai_tindakan) {
        $jam_selesai_tindakan += (24 * 3600);
    }


    $jam_akhir_proto = $jam_akhir_proto < $jam_mulai_anestesi ? $jam_mulai_anestesi : $jam_akhir_proto;
    $jam_akhir_proto = $jam_akhir_proto < $jam_selesai_anestesi ? $jam_selesai_anestesi : $jam_akhir_proto;
    $jam_akhir_proto = $jam_akhir_proto < $jam_mulai_tindakan ? $jam_mulai_tindakan : $jam_akhir_proto;
    $jam_akhir_proto = $jam_akhir_proto < $jam_selesai_tindakan ? $jam_selesai_tindakan : $jam_akhir_proto;


    // var_dump($status->attributes); die;

    $jam_mulai_anestesi = date('d H:i', floor(($jam_mulai_anestesi / (15 * 60)) * (15 * 60)));
    $jam_selesai_anestesi = date('d H:i', floor(($jam_selesai_anestesi / (15 * 60)) * (15 * 60)));
    $jam_mulai_tindakan = date('d H:i', floor(($jam_mulai_tindakan / (15 * 60)) * (15 * 60)));
    $jam_selesai_tindakan = date('d H:i', floor(($jam_selesai_tindakan / (15 * 60)) * (15 * 60)));


    $jam_awal = new DateTime(date('Y-m-d H:i:s', floor(strtotime($model[0]->observasi_jam) / (15 * 60)) * (15 * 60)));
    $jam_akhir = new DateTime(date('Y-m-d H:i:s', (15 * 60) + (floor($jam_akhir_proto / (15 * 60)) * (15 * 60))));

    // var_dump($jam_awal->format('d H:i'), $jam_akhir->format('d H:i')); die;

    $interval = DateInterval::createFromDateString('1 minutes');
    $period = new DatePeriod($jam_awal, $interval, $jam_akhir);

    // var_dump($jam_mulai_anestesi, $jam_selesai_anestesi, $jam_mulai_tindakan, $jam_selesai_tindakan); die;



    $cnt = 0;
    foreach ($period as $item) {

        $sym = "";
        if ($item->format('d H:i') == $jam_mulai_anestesi) {
            $sym .= "x\n▲";
        }
        if ($item->format('d H:i') == $jam_selesai_anestesi) {
            $sym .= "\nx▼";
        }
        if ($item->format('d H:i') == $jam_mulai_tindakan) {
            $sym .= "\n◯►";
        }
        if ($item->format('d H:i') == $jam_selesai_tindakan) {
            $sym .= "\n◯◄ ";
        }

        $counter[$item->format('d H:i')] = $cnt;
        $time_m[$cnt] = $sym;
        $time_x[$cnt] = $item->format('H:i'); //.$sym;

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
        $waktu = new DateTime(date('Y-m-d H:i:s', floor($item->waktu2 / (1 * 60)) * (1 * 60)));

        $nadi[$counter[$waktu->format('d H:i')]] = $item->detaknadi;
        $nafas[$counter[$waktu->format('d H:i')]] = $item->pernapasan_nilai;
        $systolic[$counter[$waktu->format('d H:i')]] = $item->td_sistolik;
        $diastolic[$counter[$waktu->format('d H:i')]] = $item->td_diastolik;
        $suhu[$counter[$waktu->format('d H:i')]] = $item->suhutubuh;
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
        padding: 5px;
        text-align: center;
        width: 25%;
    }
</style>


<canvas id="chart_durante">

</canvas>
<table class="leg_bottom" hidden>
    <tr>
        <td>x▲ Mulai Anestesi</td>
        <td>x▼ Selesai Anestesi</td>
        <td>◯► Mulai Tindakan Bedah</td>
        <td>◯◄ Selesai Tindakan Bedah</td>
    </tr>
</table>

<table class="table">
    <thead>
        <tr>
            <th rowspan="2">Pemeriksaan Ke-</th>
            <th rowspan="2">Jam Observasi</th>
            <th rowspan="2">SpO2</th>
            <th rowspan="2">End Tidal CO2</th>
            <th colspan="3">Inhalasi</th>
            <th rowspan="2">N2O</th>
            <th rowspan="2">AIR</th>
            <th rowspan="2">O2</th>
            <th rowspan="2">Pernapasan</th>
            <th rowspan="2">Suhu</th>
            <th rowspan="2">Tekanan Darah</th>
            <th rowspan="2">Nadi</th>
            <th rowspan="2">Intra Muscular (IM)<br>Cairan</th>
            <th rowspan="2">Kesadaran</th>
            <th rowspan="2">Urine</th>
            <th rowspan="2">Catatan</th>
            <th rowspan="2">Status<br>Anestesi</th>
            <th rowspan="2">Status<br>Tindakan Bedah</th>
        </tr>
        <tr>
            <th>Isofluran</th>
            <th>Sevofluran</th>
            <th>Desfluran</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($model as $item) :

            $status = CJSON::decode($item->keterangan_jamobservasi);
        ?>

            <tr>
                <td><?php echo $item->pemeriksaanke; ?></td>
                <td><?php echo $item->observasi_jam; ?></td>
                <td><?php echo $item->spo2_nilai; ?></td>
                <td><?php echo $item->endtidalco2_nilai; ?></td>
                <td><?php echo $item->isofluran_nilai; ?></td>
                <td><?php echo $item->sevofluran_nilai; ?></td>
                <td><?php echo $item->desfluran_nilai; ?></td>
                <td><?php echo $item->n2o_nilai; ?></td>
                <td><?php echo $item->air_nilai; ?></td>
                <td><?php echo $item->o2_nilai; ?></td>
                <td><?php echo $item->pernapasan_nilai; ?></td>
                <td><?php echo $item->suhutubuh; ?></td>
                <td><?php echo $item->td_sistolik . "/" . $item->td_diastolik; ?></td>
                <td><?php echo $item->detaknadi; ?></td>
                <td>
                    <?php
                    $det = CairanimduranteopT::model()->findAllByAttributes(array(
                        'anastesiduranteoperasi_id' => $item->anastesiduranteoperasi_id,
                    ));

                    if (count((array)$det) == 0) {
                        echo "-";
                    } else {
                        echo "<ul>";
                        foreach ($det as $item2) {
                            echo "<li>" . $item2->obatalkes->obatalkes_nama . '</li>';
                        }
                        echo "</ul>";
                    }
                    ?>
                </td>
                <td><?php echo $item->kesadaranpasien; ?></td>
                <td><?php echo $item->urine_jumlah; ?></td>
                <td><?php echo $item->catatan; ?></td>
                <td><?php echo empty($status['anestesi']) ? "-" : $status['anestesi']; ?></td>
                <td><?php echo empty($status['tindakan']) ? "-" : $status['tindakan']; ?></td>
            </tr>

        <?php endforeach; ?>
    </tbody>

</table>

<script>
    var imgPA = new Image(12, 12);
    imgPA.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/panah_atas.png'; ?>';

    var imgDA = new Image(12, 12);
    imgDA.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/panah_bawah.png'; ?>';

    var imgS = new Image(12, 12);
    imgS.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/silang.png'; ?>';

    var imgPlus = new Image(12, 12);;
    imgPlus.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/plus.png'; ?>';

    $(document).ready(function() {

        var durante = $("#chart_durante");

        var lineChart1 = new Chart(durante, {
            type: 'line',
            data: {
                labels: <?php echo CJSON::encode($time_x); ?>,
                datasets: [{
                        label: 'Nadi',
                        lineTension: 0,
                        display: false,
                        data: <?php echo CJSON::encode($nadi); ?>,
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
                        data: <?php echo CJSON::encode($nafas); ?>,
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
                    xAxes: [{
                        id: 'YA',
                        //                    type: "date",
                        ticks: {
                            fontSize: 10,
                            callback: function(value, index, values) {
                                if (index % 15 == 0) {
                                    return value;
                                } else {
                                    return null;
                                }
                            }
                        },
                        gridLines: {
                            zeroLineWidth: 4,
                            drawBorder: false,
                            //color: 'rgba(0, 0, 0, .5)'
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: 'rgba(0, 0, 0, .5)'
                        },
                        ticks: {
                            min: 0,
                            max: 220,
                            stepSize: 10,
                            beginAtZero: true,
                            fontSize: 10,
                            padding: 5
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
                beforeInit: function(chart) {
                    chart.data.labels.forEach(function(e, i, a) {
                        if (/\n/.test(e)) {
                            a[i] = e.split(/\n/);
                        }
                    })
                }
            }]
        });
    });
</script>