<style>

    .tab_partograf td {
        border: 1px solid black;
    }
    
    .tab_partograf_sub td {
        border: none !important;
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
$model = new MonitoringjalanlahirT;
$model->unsetAttributes();
$model->partografpasien_id = $partograf->partografpasien_id;

$waktu = array();
$kontraksi = array();

$prov = $model->searchRiwayat();
$prov->pagination = false;

$data = array(
    'serviks' => array(),
    'kepala' => array(),
);

foreach ($prov->data as $idx => $item) {

    if ($idx == 0) {
        $selisih = $item->pembukaanserviks - 4;
        for ($i = 0; $i < $selisih; $i++) {
            $data['serviks'][] = null;
            $data['serviks'][] = null;
            $data['kepala'][] = null;
            $data['kepala'][] = null;
            $kontraksi[] = null;
            $kontraksi[] = null;
            $waktu[] = null;
            $waktu[] = null;
        }
    }


    //$waktu[] = $item->jam_pemeriksaan;
    //$data['serviks'][] = $item->pembukaanserviks;
    //$data['kepala'][] = $item->turunnyakepalajanin;
}


// set pembulatan
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
        $waktu[] = $item->jam_pemeriksaan;
        $data['serviks'][] = $item->pembukaanserviks;
        $data['kepala'][] = $item->turunnyakepalajanin;
    } else {
        $waktu[] = null;
        $data['serviks'][] = null;
        $data['kepala'][] = null;
    }
}

// kontraksi
$model = new MonitoringkontraksiT;
$model->unsetAttributes();
$model->partografpasien_id = $partograf->partografpasien_id;

$prov = $model->searchRiwayat();
$prov->pagination = false;

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
        $kontraksi[] = array(
            'jumlah' => $item->jml_kontraksi,
            'durasi' => $item->durasikontraksi,
        );
    } else {
        $kontraksi[] = null;
    }
}
?>

        <div style="width: 1000px; height: 200px">
            <canvas id="grafik_kemajuanpersalinan"></canvas>

        </div>
        <div style="width: 993px; padding-left: 236px;">
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
        <div style="width: 1000px;">
            <div style="padding-right: 8px; padding-left: 16px;">
                <?php
                $class_kontraksi = array(
                    '<20' => 'kontraksi_biru',
                    '20-40' => 'kontraksi_merah',
                    '>40' => 'kontraksi_abu',
                );
                ?>
                <table width="100%" class="tab_partograf">
                    <tr>
                        <td rowspan="5" style="padding: 5px; border: none;">Kontraksi tiap 10 menit</td>
                        <td rowspan="5" style="padding: 5px; border: none;">
                            <table class="tab_partograf_sub">
                            <tr>
                                <td style="width: 50px;" class="kontraksi_biru"></td>
                                <td style="width: 50px;">< 20</td>
                            </tr>
                            <tr>
                                <td style="width: 50px;" class="kontraksi_merah"></td>
                                <td style="width: 50px;">20 - 40</td>
                                
                            </tr>
                            <tr>
                                <td style="width: 50px;" class="kontraksi_abu"></td>
                                <td style="width: 50px;">> 40</td>
                                
                            </tr>
                        </table>
                        </td>
                        <td style="border: none; text-align: right; padding-right: 5px;">5</td>
                        <?php for ($i = 0; $i < 32; $i++): ?>
                            <td style="width: calc(100% / 41.3);" class="<?php echo (!empty($kontraksi[$i]['jumlah']) && !empty($kontraksi[$i]['durasi']) && $kontraksi[$i]['jumlah'] == 5) ? $class_kontraksi[$kontraksi[$i]['durasi']] : ""; ?>">&nbsp;</td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td style="border: none; text-align: right; padding-right: 5px;">4</td>
                        <?php for ($i = 0; $i < 32; $i++): ?>
                            <td class="<?php echo (!empty($kontraksi[$i]['jumlah']) && !empty($kontraksi[$i]['durasi']) && $kontraksi[$i]['jumlah'] >= 4) ? $class_kontraksi[$kontraksi[$i]['durasi']] : ""; ?>">&nbsp;</td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td style="border: none; text-align: right; padding-right: 5px;">3</td>
                        <?php for ($i = 0; $i < 32; $i++): ?>
                            <td class="<?php echo (!empty($kontraksi[$i]['jumlah']) && !empty($kontraksi[$i]['durasi']) && $kontraksi[$i]['jumlah'] >= 3) ? $class_kontraksi[$kontraksi[$i]['durasi']] : ""; ?>">&nbsp;</td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td style="border: none; text-align: right; padding-right: 5px;">2</td>
                        <?php for ($i = 0; $i < 32; $i++): ?>
                            <td class="<?php echo (!empty($kontraksi[$i]['jumlah']) && !empty($kontraksi[$i]['durasi']) && $kontraksi[$i]['jumlah'] >= 2) ? $class_kontraksi[$kontraksi[$i]['durasi']] : ""; ?>">&nbsp;</td>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <td style="border: none; text-align: right; padding-right: 5px;">1</td>
                        <?php for ($i = 0; $i < 32; $i++): ?>
                            <td class="<?php echo (!empty($kontraksi[$i]['jumlah']) && !empty($kontraksi[$i]['durasi']) && $kontraksi[$i]['jumlah'] >= 1) ? $class_kontraksi[$kontraksi[$i]['durasi']] : ""; ?>">&nbsp;</td>
                        <?php endfor; ?>
                    </tr>
                </table>
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
        
        Chart.defaults.font.size = 9;
        
        var ctx = document.getElementById('grafik_kemajuanpersalinan').getContext('2d');
        ctx.height = 200
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: lableTicker,
                datasets: [
                    {
                        label: "WASPADA",
                        data: [
                            4, null, null, null, null, null, null, null, null, null, null, null, 10
                        ],
                        borderColor: "black",
                        backgroundColor: "black",
                        borderWidth: 1,
                        spanGaps: true,
                        pointRadius: 0

                    },
                    {
                        label: "BERTINDAK",
                        data: [
                            null, null, null, null, null, null, null, null, 4, null, null, null, null, null, null, null, null, null, null, null, 10
                        ],
                        borderColor: "blue",
                        backgroundColor: "blue",
                        borderWidth: 1,
                        spanGaps: true,
                        pointRadius: 0

                    },
                    {
                        label: 'Pembukaan Serviks',
                        data: <?php echo CJSON::encode($data['serviks']); ?>,
                        backgroundColor: "red",
                        borderColor: "red",
                        borderWidth: 1,
                        spanGaps: true,
                        yAxisID: "y",
                        pointStyle: "crossRot",
                        pointRadius: 5,
                        pointBorderWidth: 3,
                    },
                    {
                        label: 'Turunnya Kepala',
                        data: <?php echo CJSON::encode($data['kepala']); ?>,
                        backgroundColor: "white",
                        borderColor: "pink",
                        borderWidth: 1,
                        spanGaps: true,
                        yAxisID: "y",
                        pointStyle: "circle",
                        pointRadius: 5,
                        pointBorderWidth: 3,
                    }

                ]},
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: "left",
                    },
                    title: {
                        display: true,
                        text: 'Pembukaan Serviks dan Penurunan Kepala',
                        position: "left",
                    }
                },
                maintainAspectRatio: false,
                scales: {
                    xAxes: {
                        ticks: {
                            display: false
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        max: 10,
                        display: true,
                        title: {
                            display: true,
                            text: "Turunnya Kepala"
                        },
                        ticks: {
                            callback: function (v, i, va) {
                                if (v <= 5) {
                                    return v;
                                }
                                return "";
                            },
                        },
                    },
                    y: {
                        beginAtZero: true,
                        max: 10,
                        display: true,
                        title: {
                            display: true,
                            text: "Pembukaan Serviks"
                        }
                    }
                }
            }
        });

    });

</script>