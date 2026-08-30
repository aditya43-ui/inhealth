<style>
    .table>thead>tr>th {
        text-align: center;
        vertical-align: middle;
    }
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Lembar Observasi Pasien
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="20%">Nama Pasien</td>
                        <td width="30%">: <?php echo $modPendaftaran->pasien->namadepan . $modPendaftaran->pasien->nama_pasien; ?></td>
                        <td width="20%">No. Rekam Medik</td>
                        <td width="30%">: <?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
                    </tr>
                    <tr>
                        <td>Tgl. Lahir</td>
                        <td>: <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir); ?></td>
                        <td>Jenis Kelamin</td>
                        <td>: <?php echo $modPendaftaran->pasien->jeniskelamin; ?></td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td>: <?php echo $modPendaftaran->umur; ?></td>
                        <td>Kelas Pelayanan</td>
                        <td>: <?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat Pasien</td>
                        <td>: <?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
                        <td>Ruangan</td>
                        <td>: <?php echo $modPendaftaran->ruangan->ruangan_nama; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-body table-responsive">
                <canvas id="chart_kardeks"></canvas>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-body table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th rowspan="2">Monitoring Jam ke-</th>
                            <th rowspan="2">Tgl & Jam Pemeriksaan</th>
                            <th colspan="8">Hemodinamik</th>
                            <th colspan="4">SSP</th>
                            <th colspan="4">Medika Mentosa</th>
                            <th colspan="2">Nutrisi</th>
                            <th colspan="16">Respirasi VENT dan AGD</th>
                            <th colspan="5">Output</th>
                            <th colspan="11">Balance Cairan</th>
                        </tr>
                        <tr>
                            <th>Irama EKG</th>
                            <th>Systol</th>
                            <th>Diastol</th>
                            <th>Nadi</th>
                            <th>RR</th>
                            <th>Suhu</th>
                            <th>SpO2</th>
                            <th>CVP</th>

                            <th>Kesadaran</th>
                            <th>GCS Eye</th>
                            <th>GCS Verbal</th>
                            <th>GCS Motorik</th>

                            <th>Bolus</th>
                            <th>Oral</th>
                            <th>Infus</th>
                            <th>Lain-Lain</th>

                            <th>Enternal</th>
                            <th>Parental</th>

                            <th>Pola/ Mode</th>
                            <th>Tidal Volume</th>
                            <th>Ps/Pa/ Pasb</th>
                            <th>PEEP</th>
                            <th>RR</th>
                            <th>FiO2</th>
                            <th>Time Ispirasi</th>
                            <th>Time Ekspirasi</th>
                            <th>Sputum</th>
                            <th>pH</th>
                            <th>pCO2</th>
                            <th>pO2</th>
                            <th>TCO2</th>
                            <th>BE</th>
                            <th>HCO3</th>
                            <th>O2 Saturasi</th>

                            <th>Urine</th>
                            <th>Muntah</th>
                            <th>BAB</th>
                            <th>Pendarahan</th>
                            <th>Drain</th>

                            <th>Konstanta</th>
                            <th>Berat Badan</th>
                            <th>Hasil IWL</th>
                            <th>Total Intake</th>
                            <th>Total Output</th>
                            <th>Balance Sekarang</th>
                            <th>Balance Sebelum</th>
                            <th>Balance Komulatif</th>
                            <th>Konstanta Suhu</th>
                            <th>Kenaikan Suhu</th>
                            <th>Hasil IWL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kardeks as $item) : ?>

                            <tr>
                                <td><?php echo $item->pemeriksaan_ke; ?></td>
                                <td><?php echo MyFormatter::formatDateTimeForUser($item->tgl_pemeriksaan); ?></td>
                                <td><?php echo $item->iramaekg; ?></td>
                                <td><?php echo $item->hemo_dewasa_sistol; ?></td>
                                <td><?php echo $item->hemo_dewasa_diastol; ?></td>
                                <td><?php echo $item->hemo_dewasa_nadi; ?></td>
                                <td><?php echo $item->hemo_dewasa_rr; ?></td>
                                <td><?php echo $item->hemo_dewasa_suhu; ?></td>
                                <td><?php echo $item->hemo_dewasa_spo2; ?></td>
                                <td><?php echo $item->hemo_dewasa_cvp; ?></td>

                                <td><?php echo $item->ssp_kesadaran; ?></td>
                                <td><?php echo $item->ssp_gcs_eye; ?></td>
                                <td><?php echo $item->ssp_gcs_verbal; ?></td>
                                <td><?php echo $item->ssp_gcs_motorik; ?></td>

                                <td><?php echo $item->medika_bolus; ?></td>
                                <td><?php echo $item->medika_oral; ?></td>
                                <td><?php echo $item->medika_infus; ?></td>
                                <td><?php echo $item->medika_lainlain; ?></td>

                                <td><?php echo $item->nutrisi_enternal; ?></td>
                                <td><?php echo $item->nutrisi_parental; ?></td>

                                <td><?php echo $item->vent_pola; ?></td>
                                <td><?php echo $item->vent_tidal; ?></td>
                                <td><?php echo $item->vent_pspapasb; ?></td>
                                <td><?php echo $item->vent_peep; ?></td>
                                <td><?php echo $item->vent_rr; ?></td>
                                <td><?php echo $item->vent_fio2; ?></td>
                                <td><?php echo $item->vent_time_infirasi; ?></td>
                                <td><?php echo $item->vent_time_eksfirasi; ?></td>
                                <td><?php echo $item->vent_sputum ? "Ya" : "Tidak"; ?></td>
                                <td><?php echo $item->vent_ph; ?></td>
                                <td><?php echo $item->vent_pco2; ?></td>
                                <td><?php echo $item->vent_po2; ?></td>
                                <td><?php echo $item->vent_tco2; ?></td>
                                <td><?php echo $item->vent_be; ?></td>
                                <td><?php echo $item->vent_hco3; ?></td>
                                <td><?php echo $item->vent_o2saturasi; ?></td>

                                <td><?php echo $item->output_urine; ?></td>
                                <td><?php echo $item->output_muntah; ?></td>
                                <td><?php echo $item->output_bab; ?></td>
                                <td><?php echo $item->output_pendarahan; ?></td>
                                <td><?php echo $item->output_drain; ?></td>

                                <td><?php echo number_format($item->balance_konstanta, 2, ",", ""); ?></td>
                                <td><?php echo number_format($item->balance_beratbadan, 2, ",", ""); ?></td>
                                <td><?php echo number_format($item->balance_iwl, 2, ",", ""); ?></td>
                                <td><?php echo number_format($item->balance_total_intake, 2, ",", ""); ?></td>
                                <td><?php echo number_format($item->balance_total_output, 2, ",", ""); ?></td>
                                <td><?php echo number_format($item->balance_total_sekarang, 2, ",", ""); ?></td>
                                <td><?php echo number_format($item->balance_total_sebelum, 2, ",", ""); ?></td>
                                <td><?php echo number_format($item->balance_total_komulatif, 2, ",", ""); ?></td>
                                <td><?php echo number_format($item->balance_konstanta_suhu, 2, ",", ""); ?></td>
                                <td><?php echo number_format($item->balance_kenaikan_suhu, 2, ",", ""); ?></td>
                                <td><?php echo number_format($item->balance_iwl_kenaikan_suhu, 2, ",", ""); ?></td>


                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::link("Kembali", $this->createUrl('create', array('pendaftaran_id' => $pendaftaran_id)), array(
                'class' => 'btn btn-default',
            ));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            ?>
        </div>

    </div>
</div>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);

$urlPrint = $this->createUrl('print', array(
    'pendaftaran_id' => $pendaftaran_id
));
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}" + "&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);

?>
<script>
    // Line Chart
    $(document).ready(function() {

        var ch_kardeks = $("#chart_kardeks");
        var ch_data = <?php echo CJSON::encode($kardeks_chart); ?>;

        ch_kardeks[0].height = 100;

        console.log(ch_data);

        var x_hijau = new Image(15, 15);
        x_hijau.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/kardeks/x_hijau.png'; ?>';


        var o_merah = new Image(15, 15);
        o_merah.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/kardeks/lingkaran_merah.png'; ?>';

        var a_hitam = new Image(15, 15);
        a_hitam.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/kardeks/segitiga_hitam.png'; ?>';

        var a_abu = new Image(15, 15);
        a_abu.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/kardeks/segitiga_abu.png'; ?>';

        var plus_kuning = new Image(15, 15);
        plus_kuning.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/kardeks/plus_kuning.png'; ?>';

        var pagar_biru = new Image(15, 15);
        pagar_biru.src = '<?php echo Yii::app()->getBaseUrl('webroot') . '/images/kardeks/pagar_biru.png'; ?>';



        var lineServiks = new Chart(ch_kardeks, {
            type: 'line',
            data: {
                labels: ch_data.label,
                datasets: [{
                        label: 'Suhu',
                        display: false,
                        fill: false,
                        data: ch_data.suhu,
                        pointStyle: x_hijau,
                        //pointStyle:imgX,
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',
                        fill: false,
                        borderColor: "#00ff00",
                        backgroundColor: "#00ff00"
                    },
                    {
                        label: 'Nadi',
                        display: false,
                        fill: false,
                        data: ch_data.nadi,
                        pointStyle: o_merah,
                        //pointStyle: imgO,
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',
                        fill: false,
                        borderColor: "#ff0000",
                        backgroundColor: "#ff0000"
                    },
                    {
                        label: 'Systol',
                        display: false,
                        fill: false,
                        data: ch_data.sistol,
                        //pointStyle: 'circle',
                        pointStyle: a_hitam,
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',
                        fill: false,
                        borderColor: "#000000",
                        backgroundColor: "#000000"
                    },
                    {
                        label: 'Diastol',
                        display: false,
                        fill: false,
                        data: ch_data.diastol,
                        //pointStyle: 'circle',
                        pointStyle: a_abu,
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',
                        fill: false,
                        borderColor: "#888888",
                        backgroundColor: "#888888"
                    },
                    {
                        label: 'RR',
                        display: false,
                        fill: false,
                        data: ch_data.rr,
                        //pointStyle: 'circle',
                        pointStyle: plus_kuning,
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',
                        fill: false,
                        borderColor: "#ffcc00",
                        backgroundColor: "#ffcc00"
                    },
                    {
                        label: 'SpO2',
                        display: false,
                        fill: false,
                        data: ch_data.spo2,
                        //pointStyle: 'circle',
                        pointStyle: pagar_biru,
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',
                        fill: false,
                        borderColor: "#00ffff",
                        backgroundColor: "#00ffff"
                    }
                ]
            },
            options: {
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                },
                legend: {
                    position: 'left',
                    labels: {
                        usePointStyle: true
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Observasi Pasien'
                }
            }
        });


    });
</script>