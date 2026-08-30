<style>
    .table-rincian td,
    th {
        border: solid #000 1px;
    }
</style>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])) {
?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                        ?></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                    <?php
                }
                    ?>

                    <div class="judulcontent" style='width:100%; text-align: center; font-weight: bold;'>
                        RINCIAN TAGIHAN OBAT DAN ALAT KESEHATAN PASIEN
                    </div>

                    <table style="width: 100%; border: none;">
                        <tr>
                            <td>No. Urut</td>
                            <td>: <?php echo "-" ?></td>
                            <td>No. D.M.K</td>
                            <td>: <?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td>No. Reg</td>
                            <td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
                            <td>Tanggal Masuk RS</td>
                            <td>: <?php echo date("d-m-Y", strtotime($modPendaftaran->tgl_pendaftaran)); ?></td>
                        </tr>
                        <tr>
                            <td>Nama/Umur</td>
                            <td>: <?php echo $modPendaftaran->pasien->namadepan . " " . $modPendaftaran->pasien->nama_pasien . "/" . $modPendaftaran->umur; ?></td>
                            <td>Tanggal Keluar</td>
                            <td>: <?php
                                    if (count((array)$modRincians) > 0) {
                                        echo date("d-m-Y", strtotime($modRincians[count((array)$modRincians) - 1]->tgl_tindakan));
                                    } else {
                                        echo "-";
                                    }
                                    ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: <?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <table width='100%' cellpadding='2px' class='table-rincian'>
                        <thead>
                            <th>Tanggal</th>
                            <th>Uraian</th>
                            <th>Banyaknya</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                        </thead>
                        <tbody>
                            <?php
                            $totalbiaya = 0;
                            foreach ($modRincians as $i => $rincian) {
                                $totalbiaya += ($rincian->qty_tindakan * $rincian->tarif_satuan);
                                $tampilruangan = true;
                                if ($i > 0) {
                                    if ($modRincians[$i]->unitlayanan_id == $modRincians[$i - 1]->unitlayanan_id) {
                                        $tampilruangan = false;
                                    } else {
                                        $tampilruangan = true;
                                    }
                                }
                                if ($tampilruangan) {
                            ?>
                                    <tr>
                                        <td></td>
                                        <td colspan='4'><b><?php echo $rincian->unitlayanan_nama; ?></b></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td align='right'><?php echo date("d-m-Y", strtotime($rincian->tgl_tindakan)); ?></td>
                                    <td><?php echo $rincian->daftartindakan_nama; ?></td>
                                    <td align='right'><?php echo $rincian->qty_tindakan; ?></td>
                                    <td align='right'><?php echo $format->formatNumberForPrint($rincian->tarif_satuan); ?></td>
                                    <td align='right'><?php echo $format->formatNumberForPrint($rincian->qty_tindakan * $rincian->tarif_satuan); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan='4' align='right' style="font-weight:bold;">Jumlah Biaya</td>
                                <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totalbiaya); ?></td>
                            </tr>
                            <tr>
                                <td colspan='4' align='right' style="font-style:italic;">(<?php echo $format->formatNumberTerbilang($totalbiaya); ?> rupiah)</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    <?php
                    if (isset($_GET['frame'])) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();"));
                    ?>
                        <script type='text/javascript'>
                            /**
                             * print
                             */
                            function print() {
                                window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranObatPasien/PrintRincianOABelumBayar", array("instalasi_id" => $_GET['instalasi_id'], "pendaftaran_id" => $_GET['pendaftaran_id'], "pasienadmisi_id" => (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null))) ?>", "", 'location=_new, width=1024px');
                            }
                        </script>
                    <?php
                    } else {
                    ?>
                        <table width='100%'>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Dicetak oleh</td>
                            </tr>
                            <tr height='100px'>
                                <td></td>
                                <td></td>
                                <!-- <td><?php //echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?></td> -->
                                <td><?php echo Yii::app()->user->getState('nama_pegawai') ?></td>
                            </tr>
                        </table>
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
        <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    </div>
<?php
                    }
?>