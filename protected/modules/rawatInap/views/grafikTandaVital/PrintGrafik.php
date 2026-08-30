<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
    @page {
        /*   size: 7in 9.25in;*/




    }
    @media print {
        html, body {


        }
        .headerclass{
            right: 0; top: 10; position: fixed; font-weight: bold;
        }
        .table-monitoring {
            width: 700px;
        }

        .table-header {
            width: 700px;
        }

        .grafik-bayi {
            margin-right:10px;
        }


    }
    .headerclass{
        right: 0; top: 0; float: right; font-weight: bold;
    }
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }

    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }

    p {
        text-align: justify;
    }


    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }

    .padding5{
        padding: 5px;
    }


    .wrapper {
        height: 100vh;
        display: flex;

        flex-direction: column;
    }

    header, footer {
        height: 30px;
    }

    main {
        flex: 1;
    }

    body {
        margin: 0;
    }

    .tablefont td{
        color: black;
        padding: 5px;
    }

    .classbraketr{
        page-break-after: always;
    }

    .fa{
        font-size: 12pt;
    }
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:96%;width:97%;
    }

    select[disabled]{
        background:#eeeeee;
    }

    .textbold {
        font-weight: bold;
    }
    .textcenter {
        text-align: center;
    }

    .tableBorder th, .tableBorder td {
        border:1px solid #000;
        padding: 5px;
    }

    .tab_page{

    }

    /* content table { page-break-inside:auto }
   content table tr    { page-break-inside:avoid; page-break-after:auto } */
</style>


<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
?>

<table width="100%"class="tab_page" >
    <thead>
        <tr>
            <td >
                <div class="header"><div style="text-align:right;font-weight: bold" class=""></div></div>

            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content" >
                    <table class="table-header" table width="100%">
                        <tr>
                            <td style="width: 40%" valign="top">
                                <table>
                                    <tr>
                                        <td width="30%" align="center" class="bordertopclass borderbottomclass borderleftclass">
                                            <div style="padding:5px"><img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 100px"/></div>
                                        </td>
                                        <td width="1%" class="bordertopclass borderbottomclass">
                                        </td>
                                        <td  class="bordertopclass borderrightclass borderbottomclass">
                                            <font style="font-size:12px;"><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></font><br><br>
                                            <font style="font-size:12px;"><?php echo ucwords($modProfilRs->alamatlokasi_rumahsakit) . ' ' . ucwords(strtolower($modProfilRs->kecamatan->kecamatan_nama)) . ' ' . ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?></font><br>
                                            <font style="font-size:12px;">Phone. <?php echo $modProfilRs->no_telp_profilrs; ?></font> <br>
                                            <font style="font-size:12px;">FAX : <?php echo $modProfilRs->no_faksimili; ?></font>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 25%" valign="bottom">
                            </td>
                            <td style="width: 35%;">
                                <table class="borderclass" style="float:right; width: 100%">
                                    <tr>
                                        <td style="" width="120px">Nama Pasien</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo $modPasien->nama_pasien; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">Tanggal Lahir</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">Jenis Kelamin</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo $modPasien->jeniskelamin; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">No. RM</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php echo $modPasien->no_rekam_medik; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="" width="120px">Dokter DPJP</td>
                                        <td style="" width="10px">:</td>
                                        <td style="">
                                            <?php
                                            $dokter = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
                                            $nama = "";

                                            if (isset($dokter)) {
                                                $nama = $dokter->namaLengkap;
                                            }
                                            echo $nama;
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <center>
                        <p class="textcenter">
                            <span  style="font-weight: bold; font-size: 14pt">
                                Grafik Monitoring Tanda Vital
                            </span><br />
                        </p>
                    </center>
                    <br/>
                    <div class="grafik-bayi">
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

                        foreach ($res_1 as $tgl => $item) {
                            foreach ($item as $jam) {
                                if (empty($res_suhu[$tgl . "_" . $jam])) {
                                    $res_suhu[$tgl . "_" . $jam] = null;
                                }
                                if (empty($res_nadi[$tgl . "_" . $jam])) {
                                    $res_nadi[$tgl . "_" . $jam] = null;
                                }
                                if (empty($res_napas[$tgl . "_" . $jam])) {
                                    $res_napas[$tgl . "_" . $jam] = null;
                                }
                                if (empty($res_sistolik[$tgl . "_" . $jam])) {
                                    $res_sistolik[$tgl . "_" . $jam] = null;
                                }
                                if (empty($res_diastolik[$tgl . "_" . $jam])) {
                                    $res_diastolik[$tgl . "_" . $jam] = null;
                                }
                                if (empty($axis_1[$tgl . "_" . $jam])) {
                                    $axis_1[$tgl . "_" . $jam] = $jam;
                                }
                                if (empty($axis_2[$tgl . "_" . $jam])) {
                                    $axis_2[$tgl . "_" . $jam] = $jam == 6 ? (array($jam, date('d', strtotime($tgl)) . " " . MyFormatter::getMonthId(date('m', strtotime($tgl))))) : $jam;
                                }
                            }
                        }

                        foreach ($riwayat as $item) {
                            $res_suhu[$item->tgl_monitoring . "_" . $item->jam_monitoring] = $item->suhu;
                            $res_nadi[$item->tgl_monitoring . "_" . $item->jam_monitoring] = $item->nadi;
                            $res_napas[$item->tgl_monitoring . "_" . $item->jam_monitoring] = $item->pernapasan;
                            $res_sistolik[$item->tgl_monitoring . "_" . $item->jam_monitoring] = $item->td_systolic;
                            $res_diastolik[$item->tgl_monitoring . "_" . $item->jam_monitoring] = $item->td_dyastolic;
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

                        <canvas id="chart_grafik_bayi">

                        </canvas>
                    </div>

                    <br/>
                    <div class="table-monitoring">
                        <center>
                            <p class="textcenter">
                                <span  style="font-weight: bold; font-size: 14pt">
                                    Table Monitoring
                                </span><br />
                            </p>
                        </center>
                        <div class="panel panel-success">

                            <div class="panel-body">
                                <table class="tableBorder" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tanggal Monitoring</th>
                                            <th>Jam Monitoring</th>
                                            <th>Pernapasan<br/>(x/Menit)</th>
                                            <th>Suhu Tubuh<br/>(&deg;C)</th>
                                            <th>Nadi<br/>(x/Menit)</th>
                                            <th>Tekanan Darah<br/>(mm/Hg)</th>
                                            <!-- <th>Infeksi Mosokomial</th> -->
                                            <th>Berat Badan</th>
                                            <th>Tinggi Badan</th>
                                            <!-- <th>BAB</th> -->
                                            <th>Cairan Masuk</th>
                                            <th>Cairan Keluar</th>
                                            <th>Petugas Pengisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($riwayat as $idx => $item): ?>
                                            <tr>
                                                <td><?php echo $idx + 1; ?></td>
                                                <td><?php echo MyFormatter::formatDateTimeForUser($item->tgl_monitoring); ?></td>
                                                <td><?php echo $item->jam_monitoring; ?></td>
                                                <td><?php echo $item->pernapasan; ?></td>
                                                <td><?php echo $item->suhu; ?></td>
                                                <td><?php echo $item->nadi; ?></td>
                                                <td><?php echo $item->td_systolic . "/" . $item->td_dyastolic; ?></td>
                                                <!-- <td><?php //echo $item->mosokomial; ?></td> -->
                                                <td><?php echo $item->berat_badan; ?></td>
                                                <td><?php echo $item->tinggi_badan; ?></td>
                                                <!-- <td><?php //echo $item->bab; ?></td> -->
                                                <td><?php echo $item->cairan_masuk; ?></td>
                                                <td><?php echo $item->cairan_keluar; ?></td>
                                                <td><?php echo empty($item->petugaspengisi) ? "-" : $item->petugaspengisi->namaLengkap; ?></td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>


<script>



    var imgPA = new Image(12, 12);
    imgPA.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/panah_atas.png'; ?>';

    var imgDA = new Image(12, 12);
    imgDA.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/panah_bawah.png'; ?>';

    var imgS = new Image(12, 12);
    imgS.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/silang.png'; ?>';

    var imgPlus = new Image(12, 12);;
    imgPlus.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/plus.png'; ?>';


    $(document).ready(function () {

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
                        bottom: 0,

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
                                callback: function (value, index, values) {
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
