<?php
$checkLoginPegawai = false;
$modePgLogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
if (isset($modePgLogin)) {
    if ($modePgLogin->jabatan_id == 71 || $modePgLogin->jabatan_id == 131 || $modePgLogin->jabatan_id == 97) {
        $checkLoginPegawai = true;
    }
}

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 14));
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        if ($caraPrint != 'EXCEL') {
                            echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array('judulLaporan' => $judulLaporan, 'periode' => ''));
                        }
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">

                        <?php
                        if (!$modRealisasiLemburDetail) {
                            echo "Data tidak ditemukan.";
                            exit;
                        }
                        $format = new MyFormatter;
                        if (!isset($_GET['frame'])) {
//    echo $this->renderPartial($this->path_view.'_headerPrint'); 
                        }
                        ?>
                        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" valig="middle" colspan="3">
                                    <b><?php //echo $judul_print       ?></b>
                                </td>
                            </tr>
                            <tr>
                                <td>No. Realisasi</td>
                                <td>:</td>
                                <td><?php echo $modRealisasiLembur->norealisasi; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Realisasi</td>
                                <td>:</td>
                                <td><?php echo $format->formatDateTimeForUser($modRealisasiLembur->tglrealisasi); ?></td>
                            </tr>
                            <?php if (!empty($modRealisasiLembur->rencanalembur_id)) { ?>
                                <tr>
                                    <td>No. Rencana</td>
                                    <td>:</td>
                                    <td><?php echo $modRealisasiLembur->rencanalembur->norencana; ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Rencana</td>
                                    <td>:</td>
                                    <td><?php echo $format->formatDateTimeForUser($modRealisasiLembur->rencanalembur->tglrencana); ?></td>
                                </tr>
                            <?php } ?>
    <!--<tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php // echo (isset($modRealisasiLembur->pegawaimengetahui->NamaLengkap) ? $modRealisasiLembur->pegawaimengetahui->NamaLengkap : ""); ?></td>
        </tr>-->
                            <tr>
                                <td>Pegawai Menyetujui</td>
                                <td>:</td>
                                <td><?php echo (isset($modRealisasiLembur->pegawaimenyetujui->NamaLengkap) ? $modRealisasiLembur->pegawaimenyetujui->NamaLengkap : ""); ?></td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td><?php echo $modRealisasiLembur->keterangan; ?></td>
                            </tr>
                        </table><br>
                        <table width="100%" style='margin-left:auto; margin-right:auto;' class="table border tab_detail">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" rowspan="2">No.</th>
                                    <th style="text-align: center;" rowspan="2">No. Induk Pegawai</th>
                                    <th style="text-align: center;" rowspan="2">Nama Pegawai</th>
                                    <th style="text-align: center;" rowspan="2">Jam Mulai</th>
                                    <th style="text-align: center;" rowspan="2">Jam Selesai</th>
                                    <th style="text-align: center;" rowspan="2">Total Jam Lembur</th>
                                    <th style="text-align: center;" rowspan="2">Jam Normal</th>
                                    <th style="text-align: center;" rowspan="2">Jenis Lembur</th>
                                    <th style="text-align: center;" rowspan="2">Upah Sejam Lembur Hari Kerja</th>
                                    <th style="text-align: center;" rowspan="2">Upah Bulanan</th>
                                    <th style="text-align: center;" colspan="3">Upah Lembur</th>
                                    <th style="text-align: center;" rowspan="2">Total</th>
                                    <th style="text-align: center;" rowspan="2">Alasan Lembur</th>
                                </tr>
                                <tr>
                                    <th>Jam ke-1</th>
                                    <th>Jam ke-2</th>
                                    <th>Jam ke-3</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $subtotal = 0;
                                foreach ($modRealisasiLemburDetail as $i => $detail) {
                                    $biayaLembur = BiayalemburM::model()->findByPk($detail->biayalembur_id);
                                    if ($detail->tglmulai != null) {
                                        $detail->jamMulai = date('H:i', strtotime($detail->tglmulai));
                                    }
                                    if ($detail->tglselesai != null) {
                                        $detail->jamSelesai = date('H:i', strtotime($detail->tglselesai));
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo ($i + 1) . "."; ?></td>
                                        <td><?php echo $detail->pegawai->nomorindukpegawai; ?></td>
                                        <td><?php echo $detail->pegawai->nama_pegawai; ?></td>
                                        <td><?php echo $detail->jamMulai; ?></td>
                                        <td><?php echo $detail->jamSelesai; ?></td>
                                        <td style="text-align: right;"><?php echo $detail->total_jam; ?></td>
                                        <td style="text-align: right;"><?php echo $detail->total_jam_normal; ?></td>
                                        <td><?php echo $biayaLembur->biayalembur_nama; ?></td>
                                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->upahsejamlembur) : "Hidden"); ?></td>
                                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->upah_bulanan) : "Hidden"); ?></td>
                                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->nilai_lembur) : "Hidden"); ?></td>
                                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->upah_lembur_jam2) : "Hidden"); ?></td>
                                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->upah_lembur_jam3) : "Hidden"); ?></td>
                                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->total_nilai_lembur) : "Hidden"); ?></td>
                                        <td><?php echo $detail->alasanlembur; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <table width="100%" style="margin-top:20px;">
                            <tr>
                                <td width="100%" align="left" align="top">
                                    <table style="width: 100%; border: none;">
                                        <tr>
                                            <td width="35%" align="center">
                                                <div>Pegawai Mengetahui</div>
                                                <div style="margin-top:60px;"><br><br><br><?php echo isset($modRealisasiLembur->pegawaimengetahui->NamaLengkap) ? $modRealisasiLembur->pegawaimengetahui->NamaLengkap : "" ?></div>
                                            </td>
                                            <td width="35%" align="center">
                                                <div><?php echo Yii::app()->user->getState("kabupaten_nama") . ", " . MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                                                <div>Pegawai Menyetujui</div>
                                                <div style="margin-top:60px;"><br><br><br><?php echo isset($modRealisasiLembur->pegawaimenyetujui->NamaLengkap) ? $modRealisasiLembur->pegawaimenyetujui->NamaLengkap : "" ?></div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>		
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="">
    </div>
    <div class="footer">
        <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>   

    <?php
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
    </div>
    <div class="content">
        <?php
        if (!$modRealisasiLemburDetail) {
            echo "Data tidak ditemukan.";
            exit;
        }
        $format = new MyFormatter;
        if (!isset($_GET['frame'])) {
//    echo $this->renderPartial($this->path_view.'_headerPrint'); 
        }
        ?>
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" valig="middle" colspan="3">
                    <b><?php //echo $judul_print       ?></b>
                </td>
            </tr>
            <tr>
                <td>No. Realisasi</td>
                <td>:</td>
                <td><?php echo $modRealisasiLembur->norealisasi; ?></td>
            </tr>
            <tr>
                <td>Tanggal Realisasi</td>
                <td>:</td>
                <td><?php echo $format->formatDateTimeForUser($modRealisasiLembur->tglrealisasi); ?></td>
            </tr>
            <?php if (!empty($modRealisasiLembur->rencanalembur_id)) { ?>
                <tr>
                    <td>No. Rencana</td>
                    <td>:</td>
                    <td><?php echo $modRealisasiLembur->rencanalembur->norencana; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Rencana</td>
                    <td>:</td>
                    <td><?php echo $format->formatDateTimeForUser($modRealisasiLembur->rencanalembur->tglrencana); ?></td>
                </tr>
            <?php } ?>
    <!--<tr>
    <td>Pegawai Mengetahui</td>
    <td>:</td>
    <td><?php // echo (isset($modRealisasiLembur->pegawaimengetahui->NamaLengkap) ? $modRealisasiLembur->pegawaimengetahui->NamaLengkap : ""); ?></td>
    </tr>-->
            <tr>
                <td>Pegawai Menyetujui</td>
                <td>:</td>
                <td><?php echo (isset($modRealisasiLembur->pegawaimenyetujui->NamaLengkap) ? $modRealisasiLembur->pegawaimenyetujui->NamaLengkap : ""); ?></td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td><?php echo $modRealisasiLembur->keterangan; ?></td>
            </tr>
        </table><br>
        <table width="100%" style='margin-left:auto; margin-right:auto;' class="table border tab_detail">
            <thead>
                <tr>
                    <th style="text-align: center;" rowspan="2">No.</th>
                    <th style="text-align: center;" rowspan="2">No. Induk Pegawai</th>
                    <th style="text-align: center;" rowspan="2">Nama Pegawai</th>
                    <th style="text-align: center;" rowspan="2">Jam Mulai</th>
                    <th style="text-align: center;" rowspan="2">Jam Selesai</th>
                    <th style="text-align: center;" rowspan="2">Total Jam Lembur</th>
                    <th style="text-align: center;" rowspan="2">Jam Normal</th>
                    <th style="text-align: center;" rowspan="2">Jenis Lembur</th>
                    <th style="text-align: center;" rowspan="2">Upah Sejam Lembur Hari Kerja</th>
                    <th style="text-align: center;" rowspan="2">Upah Bulanan</th>
                    <th style="text-align: center;" colspan="3">Upah Lembur</th>
                    <th style="text-align: center;" rowspan="2">Total</th>
                    <th style="text-align: center;" rowspan="2">Alasan Lembur</th>
                </tr>
                <tr>
                    <th>Jam ke-1</th>
                    <th>Jam ke-2</th>
                    <th>Jam ke-3</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $subtotal = 0;
                foreach ($modRealisasiLemburDetail as $i => $detail) {
                    $biayaLembur = BiayalemburM::model()->findByPk($detail->biayalembur_id);
                    if ($detail->tglmulai != null) {
                        $detail->jamMulai = date('H:i', strtotime($detail->tglmulai));
                    }
                    if ($detail->tglselesai != null) {
                        $detail->jamSelesai = date('H:i', strtotime($detail->tglselesai));
                    }
                    ?>
                    <tr>
                        <td><?php echo ($i + 1) . "."; ?></td>
                        <td><?php echo $detail->pegawai->nomorindukpegawai; ?></td>
                        <td><?php echo $detail->pegawai->nama_pegawai; ?></td>
                        <td><?php echo $detail->jamMulai; ?></td>
                        <td><?php echo $detail->jamSelesai; ?></td>
                        <td style="text-align: right;"><?php echo $detail->total_jam; ?></td>
                        <td style="text-align: right;"><?php echo $detail->total_jam_normal; ?></td>
                        <td><?php echo $biayaLembur->biayalembur_nama; ?></td>
                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->upahsejamlembur) : "Hidden"); ?></td>
                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->upah_bulanan) : "Hidden"); ?></td>
                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->nilai_lembur) : "Hidden"); ?></td>
                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->upah_lembur_jam2) : "Hidden"); ?></td>
                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->upah_lembur_jam3) : "Hidden"); ?></td>
                        <td style="text-align: right;"><?php echo (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($detail->total_nilai_lembur) : "Hidden"); ?></td>
                        <td><?php echo $detail->alasanlembur; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <table width="100%" style="margin-top:20px; ">
            <tr>
                <td width="100%" align="left" align="top">
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td width="35%" align="center">
                                <div>Pegawai Mengetahui</div>
                                <div style="margin-top:60px;"><br><br><br><?php echo isset($modRealisasiLembur->pegawaimengetahui->NamaLengkap) ? $modRealisasiLembur->pegawaimengetahui->NamaLengkap : "" ?></div>
                            </td>
                            <td width="35%" align="center">
                                <div><?php echo Yii::app()->user->getState("kabupaten_nama") . ", " . MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                                <div>Pegawai Menyetujui</div>
                                <div style="margin-top:60px;"><br><br><br><?php echo isset($modRealisasiLembur->pegawaimenyetujui->NamaLengkap) ? $modRealisasiLembur->pegawaimenyetujui->NamaLengkap : "" ?></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <?php
}
?>
