<style>
    body {
        color: black;
    }

    .col-judul {
        width: 10%;
    }

    .col-titik {
        width: 1%;
    }

    .col-isi {
        width: 20%;
    }

    .text-center-bold {
        text-align: center;
        font-weight: bold;
    }

    .text-left-bold {
        text-align: left;
        font-weight: bold;
    }

    .text-right {
        text-align: right;
    }

    .text-right-bold {
        text-align: right;
        font-weight: bold;
    }

    .border-tr-td {
        border: 1px solid black;
    }

    #tab_detail {
        border: 1px solid black;
    }
</style>
<?php
$format = new MyFormatter;
echo $this->renderPartial('application.views.headerReport.headerRincianKasir', array('judulLaporan' => null, 'periode' => null));
?>
<table style="width: 100%; border: none;">
    <tr>
        <td colspan="6" class="text-center-bold">DETAIL RINCIAN TAGIHAN PASIEN</td>
    </tr>
    <tr>
        <td class="col-judul"><b>No. RM</b></td>
        <td class="col-titik">:</td>
        <td class="col-isi"><?php echo $modInfo->no_rekam_medik; ?></td>

        <td class="col-judul"><b>No. Pendaftaran</b></td>
        <td class="col-titik">:</td>
        <td class="col-isi"><?php echo $modInfo->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td class="col-judul"><b>Nama Pasien</b></td>
        <td class="col-titik">:</td>
        <td class="col-isi"><?php echo $modInfo->namadepan . " " . $modInfo->nama_pasien; ?></td>

        <td class="col-judul"><b>Tanggal Pendaftaran</b></td>
        <td class="col-titik">:</td>
        <td class="col-isi"><?php echo $format->formatDateTimeForUser($modInfo->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td class="col-judul"><b>Tanggal Lahir</b></td>
        <td class="col-titik">:</td>
        <td class="col-isi"><?php echo $format->formatDateTimeForUser($modInfo->tanggal_lahir); ?></td>

        <td class="col-judul"><b>Ruangan Terakhir</b></td>
        <td class="col-titik">:</td>
        <td class="col-isi"><?php echo $modInfo->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td class="col-judul"><b>Jenis Kelamin</b></td>
        <td class="col-titik">:</td>
        <td class="col-isi"><?php echo $modInfo->jeniskelamin; ?></td>

        <td class="col-judul"><b>Penjamin</b></td>
        <td class="col-titik">:</td>
        <td class="col-isi"><?php echo $modInfo->penjamin_nama; ?></td>
    </tr>
</table>
<br>
<table width="100%" id="tab_detail">
    <thead class="border-tr-td">
        <tr>
            <th style='text-align: center;'>No.</th>
            <th style='text-align: center;'>Tanggal Pelayanan</th>
            <th style='text-align: center;'>Deskripsi</th>
            <th style='text-align: center;'>Jumlah</th>
            <th style='text-align: center;'>Harga Satuan</th>
            <th style='text-align: center;'>Biaya Lain</th>
            <th style='text-align: center;'>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 0;
        $totalTindakan = 0;
        $total_biayalain = 0;
        $totalJmlTindakan = count((array)$modRincianTindakan); //RSSP-1037
        $isAkomodasi = true;
        $isVisit = true;
        $isTindakan = true;
        if (count((array)$modRincianTindakan) > 0) {
            foreach ($modRincianTindakan as $i => $tindakan) {

                $tarif_rsakomodasi = $tindakan->tarif_rsakomodasi;
                $tarif_medis = $tindakan->tarif_medis;
                $tarif_bhp = $tindakan->tarif_bhp;
                $tarif_paramedis = $tindakan->tarif_paramedis;
                $tarifcyto_tindakan = $tindakan->tarifcyto_tindakan;
                //				$biaya_lain = $tarif_rsakomodasi + $tarif_medis + $tarif_bhp + $tarif_paramedis + $tarifcyto_tindakan;
                //$biaya_lain = $tarif_rsakomodasi + $tarif_medis + $tarif_paramedis + $tarifcyto_tindakan; //RND-13614
                $biaya_lain = $tarifcyto_tindakan; //RND-13614
                $total_biaya = $tindakan->qty_tindakan * $tindakan->tarif_satuan;
                $totalTindakan += $biaya_lain + $total_biaya;

                $tampilruangan = true;
                $tampilinstalasi = false;
                if ($i > 0) {
                    if ($modRincianTindakan[$i]->ruangan_id == $modRincianTindakan[$i - 1]->ruangan_id) {
                        $tampilruangan = false;
                    } else {
                        $tampilruangan = true;
                        $isAkomodasi = true;
                        $isVisit = true;
                    }
                }
                if ($totalJmlTindakan > $i && ($totalJmlTindakan - $i) <> 1) { //RSSP-1037
                    if ($modRincianTindakan[$i]->instalasi_id == $modRincianTindakan[$i + 1]->instalasi_id) {
                        $tampilinstalasi = true;
                    } else {
                        $tampilinstalasi = false;
                    }
                }

                if ($tampilruangan) {
        ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan='7'><b><?php echo $tindakan->instalasi_nama . " - " . $tindakan->ruangan_nama . " - " . $tindakan->kelaspelayanan_nama; ?></b></td>
                    </tr>
                <?php } ?>

                <!--Start RSSP-1129-->
                <?php if (isset($tindakan->komponenunit_id) && $tindakan->instalasi_id == Params::INSTALASI_ID_RI && $tindakan->komponenunit_id == 2 && $isAkomodasi) { ?>
                    <tr style='border:1px solid;'>
                        <td></td>
                        <td colspan='7'><b>&nbsp;&nbsp;&nbsp;&nbsp;- AKOMODASI</b></td>
                    </tr>
                <?php $isAkomodasi = false;
                } ?>
                <?php if (isset($tindakan->komponenunit_id) && $tindakan->instalasi_id == Params::INSTALASI_ID_RI && $tindakan->komponenunit_id == 3 && $isVisit) { ?>
                    <tr style='border:1px solid;'>
                        <td></td>
                        <td colspan='7'><b>&nbsp;&nbsp;&nbsp;&nbsp;- VISITE & KONSUL</b></td>
                    </tr>
                <?php $isVisit = false;
                } ?>
                <?php if (isset($tindakan->komponenunit_id) && $tindakan->instalasi_id == Params::INSTALASI_ID_RI && $tindakan->komponenunit_id != 3 && $tindakan->komponenunit_id != 2 && !$isAkomodasi && !$isVisit && $isTindakan) { ?>
                    <tr style='border:1px solid;'>
                        <td></td>
                        <td colspan='7'><b>&nbsp;&nbsp;&nbsp;&nbsp;- TINDAKAN</b></td>
                    </tr>
                <?php $isTindakan = false;
                } ?>
                <!--End-->

                <tr style='border:1px solid;'>
                    <td><?php echo ($i + 1); ?></td>
                    <td style='text-align:left;'><?php echo date("d/m/Y H:i:s", strtotime($tindakan->tgl_tindakan)); ?></td>

                    <?php //RSSP-1129
                    if (isset($tindakan->komponenunit_id) && $tindakan->instalasi_id == Params::INSTALASI_ID_RI && $tindakan->komponenunit_id == 3) {
                        $dokter = "";
                        if (!empty($tindakan->dokterpemeriksa1_id)) {
                            $modDok = PegawaiM::model()->findByPk($tindakan->dokterpemeriksa1_id);
                            $dokter = "<br>- dokter ( " . $modDok->nama_pegawai . " )";
                        }
                    ?>
                        <td><?php echo $tindakan->daftartindakan_nama . $dokter; ?></td>
                    <?php } else { ?>
                        <td><?php echo $tindakan->daftartindakan_nama; ?></td>
                    <?php } ?>

                    <td style='text-align: center;'><?php echo $format->formatNumberForPrint($tindakan->qty_tindakan); ?></td>
                    <td style='text-align: right;'><?php echo $format->formatNumberForPrint($tindakan->tarif_satuan); ?></td>
                    <td style='text-align: right;'><?php echo $format->formatNumberForPrint($biaya_lain); ?></td>
                    <td style='text-align: right;'><?php echo $format->formatNumberForPrint($biaya_lain + $total_biaya); ?></td>
                </tr>

                <?php
                if (isset($is_total_instalasi) && !$tampilinstalasi) { //RSSP-1037
                ?>
                    <tr style='border:1px solid;'>
                        <td></td>
                        <td colspan="5"><b>TOTAL <?php echo $tindakan->instalasi_nama; ?></b></td>
                        <td style='text-align: right;'><?php echo $format->formatNumberForPrint($tindakan->TotalTindakanPerInstalasiJenazah($modInfo->pendaftaran_id, $tindakan->instalasi_id)); ?></td>
                    </tr>
                <?php
                }
                ?>

            <?php
                $no = ($i + 1);
            }
            ?>
            <tr class="border-tr-td">
                <td colspan="6" class="text-right-bold">Total Tindakan</td>
                <td style="text-align: right;"><?php echo $format->formatNumberForPrint($totalTindakan); ?></td>
            </tr>
        <?php } ?>

        <?php
        $no = $no;
        $totalObatAlkes = 0;
        $totalJmlOA = count((array)$modRincianObatAlkes); //RSSP-1037
        if (count((array)$modRincianObatAlkes) > 0) {
            foreach ($modRincianObatAlkes as $i => $obatalkes) {
                $no = $no + 1;

                $tarifcyto_oa = $obatalkes->tarifcyto;
                $biayaadministrasi = $obatalkes->biayaadministrasi;
                $biayakemasan = $obatalkes->biayakemasan;
                $biayakonseling = $obatalkes->biayakonseling;
                $biayaservice = $obatalkes->biayaservice;
                $biaya_lain = $tarifcyto_oa + $biayaadministrasi + $biayakemasan + $biayakonseling + $biayaservice;
                $total_biaya = $obatalkes->qty_oa * $obatalkes->hargasatuan_oa;
                $totalObatAlkes += $biaya_lain + $total_biaya;

                $tampilresep = true;
                $tampilinstalasi = false;
                if ($i > 0) {
                    if ($modRincianObatAlkes[$i]->penjualanresep_id == $modRincianObatAlkes[$i - 1]->penjualanresep_id) {
                        $tampilresep = false;
                    } else {
                        $tampilresep = true;
                    }
                }
                if ($totalJmlOA > $i && ($totalJmlOA - $i) <> 1) { //RSSP-1037
                    if ($modRincianObatAlkes[$i]->instalasi_nama == $modRincianObatAlkes[$i + 1]->instalasi_nama) {
                        $tampilinstalasi = true;
                    } else {
                        $tampilinstalasi = false;
                    }
                }

                if ($tampilresep) {
        ?>
                    <tr>
                        <td></td>
                        <td colspan='7'><b><?php echo $obatalkes->ruangan_nama . " - " . $obatalkes->noresep; ?></b></td>
                    </tr>
                <?php } ?>
                <tr class="border-tr-td">
                    <td><?php echo $no; ?></td>
                    <td style='text-align:left;'><?php echo date("d/m/Y H:i:s", strtotime($obatalkes->tglpelayanan)); ?></td>
                    <td><?php echo $obatalkes->obatalkes_kode . " / " . $obatalkes->obatalkes_nama; ?></td>
                    <td style='text-align: center;'><?php echo $format->formatNumberForPrint($obatalkes->qty_oa); ?></td>
                    <td style='text-align: right;'><?php echo $format->formatNumberForPrint($obatalkes->hargasatuan_oa); ?></td>
                    <td style='text-align: right;'><?php echo $format->formatNumberForPrint($biaya_lain); ?></td>
                    <td style='text-align: right;'><?php echo $format->formatNumberForPrint($biaya_lain + $total_biaya); ?></td>
                </tr>

                <?php
                if (isset($is_total_instalasi) && !$tampilinstalasi) { //RSSP-1037
                ?>
                    <tr style='border:1px solid;'>
                        <td></td>
                        <td colspan="5"><b>TOTAL <?php echo $obatalkes->instalasi_nama; ?></b></td>
                        <td style='text-align: right;'><?php echo $format->formatNumberForPrint($obatalkes->TotalOAPerInstalasi($modInfo->pendaftaran_id, $obatalkes->instalasi_nama)); ?></td>
                    </tr>
                <?php
                }
                ?>

            <?php $no = $no;
            } ?>
            <tr class="border-tr-td">
                <td colspan="6" class="text-right-bold">Total Obat / Alkes</td>
                <td class="text-right"><?php echo $format->formatNumberForPrint($totalObatAlkes); ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr class="border-tr-td">
            <td colspan='6' class="text-right-bold">Total</td>
            <td class="text-right-bold"><?php echo $format->formatNumberForPrint($totalTindakan + $totalObatAlkes); ?></td>
        </tr>
    </tfoot>
</table>
<br>
<br>
<table style="width: 100%; border: none;">
    <tr align="left">
        <td colspan="5"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td class="tandatangan" style="text-align: center;">Petugas</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr align="left">
        <td colspan="5"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <!--<td class="tandatangan" style="height: 50px;text-align: center;">.........................</td>-->
        <td class="tandatangan" style="height: 50px;text-align: center;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></td>
    </tr>
</table>
<?php
if (isset($_GET['frame'])) {
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian Tagihan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();"));
?>
    <script type='text/javascript'>
        function print() {
            //        window.open("<?php // echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/RincianTagihanPasienDetail", array("pendaftaran_id"=>$_GET['pendaftaran_id'], "pasienadmisi_id"=>(isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null))) 
                                    ?>","",'location=_new, width=1024px');
            window.open("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . "/" . Yii::app()->controller->id . "/RincianTagihanPasienDetail", array("pendaftaran_id" => $_GET['pendaftaran_id'], "pasienadmisi_id" => (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null))) ?>", "", 'location=_new, width=1024px');
        }
    </script>
<?php
}
?>