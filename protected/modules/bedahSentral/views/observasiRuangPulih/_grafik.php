<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
$model = ObservasiruangpulihT::model()->findAllByAttributes(array(
    'pasienmasukpenunjang_id' => $base_model->pasienmasukpenunjang_id,
));
$pasienmasukpenunjang_id = $base_model->pasienmasukpenunjang_id;
$nadi = array();
$nafas = array();
$suhu = array();
$systolic = array();
$diastolic = array();
$time_x = array();
$counter = array();
if (count((array)$model) > 0) {
    $jam_akhir_proto = strtotime($model[count((array)$model) - 1]->observasijam);
    $jam_awal = new DateTime(date('H:i:s', floor(strtotime($model[0]->observasijam) / (15 * 60)) * (15 * 60)));
    $jam_akhir = new DateTime(date('H:i:s', (15 * 60) + (floor($jam_akhir_proto / (15 * 60)) * (15 * 60))));
    $interval = DateInterval::createFromDateString('15 minutes');
    $period = new DatePeriod($jam_awal, $interval, $jam_akhir);
    // var_dump($jam_mulai_anestesi, $jam_selesai_anestesi, $jam_mulai_tindakan, $jam_selesai_tindakan); die;
    $cnt = 0;
    foreach ($period as $item) {
        $counter[$item->format('H:i')] = $cnt;
        $time_x[$cnt] = $item->format('H:i');
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
        $item->mualmuntah_status = $item->mualmuntah_status ? "+" : "-";
        $item->perdarahan_status = $item->perdarahan_status ? "+" : "-";
        $waktu = new DateTime(date('H:i:s', floor(strtotime($item->observasijam) / (15 * 60)) * (15 * 60)));
        $nadi[$counter[$waktu->format('H:i')]] = $item->detaknadi;
        $nafas[$counter[$waktu->format('H:i')]] = $item->pernapasan;
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
        padding: 5px;
        text-align: center;
        width: 25%;
    }
</style>
<h4 style="text-align: center; font-weight: bold;">Grafik Observasi Intra Operasi</h4>
<canvas id="chart_durante">
</canvas>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Observasi Perawatan Ruang Pulih</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Pemeriksaan Ke-</th>
                    <th>Jam Observasi</th>
                    <th>SpO2</th>
                    <th>O2 L/menit</th>
                    <th>Suhu</th>
                    <th>Skala Nyeri</th>
                    <th>Mual/Muntah</th>
                    <th>Pendarahan</th>
                    <th>Pernapasan</th>
                    <th>Tekanan Darah</th>
                    <th>Nadi</th>
                    <th>Ubah</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model as $item) :
                    //$status = CJSON::decode($item->keterangan_jamobservasi);
                ?>
                    <tr>
                        <td><?php echo $item->pemeriksaanke; ?></td>
                        <td><?php echo $item->observasijam; ?></td>
                        <td><?php echo $item->spo2_nilai; ?></td>
                        <td><?php echo $item->o2_nilai; ?></td>
                        <td><?php echo $item->suhubadan; ?></td>
                        <td><?php echo $item->skalanyeri; ?></td>
                        <td style="text-align: center;"><?php echo $item->mualmuntah_status . "<br>" . $item->mualmuntah_ket; ?></td>
                        <td style="text-align: center;"><?php echo $item->perdarahan_status . "<br>" . $item->perdarahan_ket; ?></td>
                        <td><?php echo $item->pernapasan; ?></td>
                        <td><?php echo $item->td_systolic . "/" . $item->td_dyastolic; ?></td>
                        <td><?php echo $item->detaknadi; ?></td>
                        <td><?php echo CHtml::link('<i class="icon-form-ubah"></i>', $this->createUrl('create', array(
                                'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
                                'id' => $item->observasiruangpulih_id
                            ))); ?></td>
                        <td><?php
                            echo CHtml::link('<i class="icon-form-silang"></i>', '#', array(
                                'onclick' => 'hapusItem(' . $item->observasiruangpulih_id . '); return false;'
                            ));
                            ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
//        echo CHtml::htmlButton('<i class="entypo-print"></i> Print', array(
//            'class'=>'btn btn-info', 'onclick'=>'print('.$pasienmasukpenunjang_id.')',
//        )); 
//        
//        echo " ";
//        echo CHtml::link('Kembali', $this->createUrl('create', array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id)), array(
//            'class' => 'btn btn-default',
//        ));
?>
<script>
    var imgPA = new Image(12, 12);
    imgPA.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/panah_atas.png'; ?>';
    var imgDA = new Image(12, 12);
    imgDA.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/panah_bawah.png'; ?>';
    var imgS = new Image(12, 12);
    imgS.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/silang.png'; ?>';
    var imgPlus = new Image(12, 12);;
    imgPlus.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/plus.png'; ?>';

    function print(id) {
        window.open("<?php
                        echo $this->createUrl('print');
                        ?>&id=" + id + "&caraPrint=PRINT", "", 'location=_new, width=900px');
    }
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
                        pointRadius: 5,
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
                    }
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
                            fontSize: 10,
                            padding: 5
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 10
                        }
                    }]
                }
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
                    });
                }
            }]
        });
    });

    function hapusItem(id) {
        myConfirm("Anda yakin untuk menghapus observasi ini?", "Peringatan!", function(b) {
            if (b) {
                $.post('<?php echo $this->createUrl('delete'); ?>', {
                    id: id
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        location.reload();
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>