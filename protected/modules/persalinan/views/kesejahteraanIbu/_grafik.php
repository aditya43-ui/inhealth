<style>

    .tab_partograf td {
        border: 1px solid black;
    }

    .kontraksi_biru {
        background-color: blue;
    }
    .kontraksi_merah {
        background-color: red;
    }
    .kontraksi_abu {
        background-color: grey;
    }

</style>



<?php
// serviks
$model = new KesejahteraanibuT();
$model->unsetAttributes();
$model->partografpasien_id = $partograf->partografpasien_id;

$waktu = array();
$suhu = array();
$kontraksi = array();

$prov = $model->search();
$prov->pagination = false;
$prov->sort->defaultOrder = 'tgl_pemeriksaan, jam_pemeriksaan';



$model2 = new MonitoringjalanlahirT;
$model2->unsetAttributes();
$model2->partografpasien_id = $partograf->partografpasien_id;


$prov2 = $model2->searchRiwayat();
$prov2->pagination = false;


$data = array(
    'denyut' => array(),
    'systolic' => array(),
    'diastolic' => array(),
    'arrAnno' => array(),
);

foreach ($prov2->data as $idx => $item) {
    if ($idx == 0) {
        $selisih = $item->pembukaanserviks - 4;
        for ($i = 0; $i < $selisih; $i++) {
            $data['denyut'][] = null;
            $data['denyut'][] = null;
            $data['systolic'][] = null;
            $data['systolic'][] = null;
            $data['diastolic'][] = null;
            $data['diastolic'][] = null;
            $kontraksi[] = null;
            $kontraksi[] = null;
            $waktu[] = null;
            $waktu[] = null;
            $suhu[] = null;
            $suhu[] = null;
        }
    }
}


$res_data = array();
$min_waktu = null;
$max_waktu = null;

foreach ($prov->data as $idx => $item) {
    $menit = date('i', strtotime($item->tgl_pemeriksaan." ".$item->jam_pemeriksaan));
    $menit = $menit - ($menit % 30);
    
    $tgl_akhir = $item->tgl_pemeriksaan." ".date('H', strtotime($item->jam_pemeriksaan)).":".str_pad($menit, 2, "0", STR_PAD_RIGHT).":00";
    $tgl_akhir_waktu = strtotime($tgl_akhir);
    
    if (empty($max_waktu) || $max_waktu < $tgl_akhir_waktu) {
        $max_waktu = $tgl_akhir_waktu;
    }
    
    if (empty($min_waktu) || $min_waktu >= $tgl_akhir_waktu) {
        $min_waktu = $tgl_akhir_waktu;
    }
    
    // var_dump($item->jam_pemeriksaan, $tgl_akhir);
    
    $res_data[$tgl_akhir] = $item;
    
}

$min_tgl = new DateTime(date('Y-m-d H:i:s', $min_waktu));
$max_tgl = new DateTime(date('Y-m-d H:59:59', $max_waktu));
$period = new DatePeriod($min_tgl, new DateInterval('PT30M'), $max_tgl);

foreach ($period as $date) {
    if (!empty($res_data[$date->format('Y-m-d H:i:s')])) {
        $item = $res_data[$date->format('Y-m-d H:i:s')];
        
        
        $base = count($data['denyut']);
    
        $denyut = KesejahteraanibunaditdT::model()->findByAttributes(array(
            'kesejahteraanibu_id'=>$item->kesejahteraanibu_id,
        ));
        $suhuD = KesejahteraanibusuhuT::model()->findByAttributes(array(
            'kesejahteraanibu_id'=>$item->kesejahteraanibu_id,
        ));

    //    if ($idx == 0) {
    //        for ($i = 0; $i < $selisih; $i++) {
    //            $data['denyut'][] = null;
    //            $data['denyut'][] = null;
    //            $kontraksi[] = null;
    //            $kontraksi[] = null;
    //            $waktu[] = null;
    //        }
    //    }


        $waktu[] = $item->jam_pemeriksaan;
        $suhu[] = empty($suhuD) ? "-" : $suhuD->suhutubuh;
    
    
    
        $data['denyut'][] = empty($denyut) ? null : $denyut->nadi;
        $data['systolic'][] = empty($denyut) ? null : $denyut->td_systolic;
        $data['diastolic'][] = empty($denyut) ? null : $denyut->td_diastolic;
        
        
    } else {
        $waktu[] = null;
        $suhu[] = null;
    
        $data['denyut'][] = null;
        $data['systolic'][] = null;
        $data['diastolic'][] = null;
    }
}




//vaR_dump($data['arrAnno']); die;

?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chart.min.js', CClientScript::POS_END); ?>
<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END); ?>

    <div style="overflow-x: auto;">
        <div style="width: 1000px; height: 300px; padding-left: 63px; padding-right: 2px;">
            <canvas id="grafik"></canvas>

        </div>
        <div style="width: 992px; padding-left: 96px;">
            <table class="tab_partograf" width="100%">
                <tbody>
                    <tr>
                        <?php for ($i = 0; $i < 32; $i++): ?>
                            <td style="text-align: right; width: calc(100% / 32); padding: 2px;"><?php echo $i + 1 ?></td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <?php for ($i = 0; $i < 32; $i++): ?>
                            <td style="height: 40px; padding: 2px; text-align: center; writing-mode: tb-rl;"><?php echo empty($waktu[$i]) ? "" : $waktu[$i]; ?></td>
                        <?php endfor; ?>
                    </tr>
                </tbody>
            </table>
        </div>
        <br/>
        <br/>
        <br/>
        <div style="width: 1000px;">
            <div style="padding-right: 8px; padding-left: 40px;">
                <table width="100%" class="tab_partograf">
                    <tr>
                        <td style="padding: 5px; border: none;">Suhu (&deg;C)</td>
                        <?php for ($i = 0; $i < 32; $i++): ?>
                            <td style="width: calc(100% / 34); text-align: center; writing-mode: tb-rl;" ><?php echo empty($suhu[$i]) ? "" : $suhu[$i]; ?></td>
                        <?php endfor; ?>
                    </tr>
                </table>
            </div>


        </div>
    </div>


<script>

    var lableTicker = [""];
    for (i = 0; i < 16; i++) {
        lableTicker[(i * 2) + 1] = "";
        lableTicker[(i * 2) + 2] = i + 1;
    }
    ;




    $(document).ready(function () {
        var ctx = document.getElementById('grafik').getContext('2d');
        ctx.height = 300
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: lableTicker,
                datasets: [
                    {
                        label: 'Nadi',
                        data: <?php echo CJSON::encode($data['denyut']); ?>,
                        backgroundColor: "black",
                        borderColor: "black",
                        borderWidth: 1,
                        spanGaps: true,
                        yAxisID: "y",
                        pointStyle: "circle",
                        pointRadius: 5,
                        pointBorderWidth: 3,
                    },
                    {
                        label: 'Sistolik',
                        data: <?php echo CJSON::encode($data['systolic']); ?>,
                        backgroundColor: "red",
                        borderColor: "red",
                        showLine: false,
                        yAxisID: "y",
                        pointStyle: "triangle",
                        pointRadius: 5,
                        pointBorderWidth: 3,
                    },
                    {
                        label: 'Diastolik',
                        data: <?php echo CJSON::encode($data['diastolic']); ?>,
                        backgroundColor: "red",
                        borderColor: "red",
                        showLine: false,
                        yAxisID: "y",
                        pointStyle: "triangle",
                        pointRadius: 5,
                        pointBorderWidth: 3,
                        pointRotation: 180,
                    }

                ]},
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Tekanan Darah & Nadi'
                    },
                    legend: {
                        labels: {
                            usePointStyle: true,
                        }
                    },
                    annotation: {        
                        drawTime: 'afterDatasetsDraw', 
                        events: ['click'],
                        dblClickSpeed: 350, // ms (default)
                        annotations: <?php echo CJSON::encode($data['arrAnno']); ?>
                    }
                },
                maintainAspectRatio: false,
                scales: {
                    xAxes: {
                        ticks: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 180,
                        min: 60,
                        display: true
                    }
                }
                
            }
        });

    });

</script>