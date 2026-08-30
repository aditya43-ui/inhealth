<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {


?>

    <table width="100%">
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
                        <br>
                        <div class="judulcontent"> <?php echo $judulLaporan   ?> </div>
                        <br>
                        <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="width:150px">No. Rencana</td>
                                <td style="width:10px">:</td>
                                <td><?php echo $model->noperencnaan; ?></td>

                                <td style="width:150px">Sumber Dana</td>
                                <td style="width:10px">:</td>
                                <td><?php echo (!empty($model->sumberdana_id) ? $model->sumberdana_nama : ""); ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Rencana : </td>
                                <td>:</td>
                                <td><?php echo MyFormatter::formatDateTimeForUser($model->tglperencanaan); ?></td>
                            </tr>

                        </table><br />
                        <table class="table">
                            <thead>
                                <tr style="border:1px solid;">
                                    <th>No.</th>
                                    <th>Supplier</th>
                                    <th>Jenis</th>
                                    <th>Nama Obat</th>
                                    <th>Tgl. Kadaluarsa</th>
                                    <th>Jumlah yang Harus Diorder</th>
                                    <!-- <th>Maksimal Stok</th> -->
                                    <th>Stok Akhir</th>
                                    <th>Jumlah Kemasan (Satuan)</th>
                                    <th>Jumlah Kebutuhan</th>
                                    <th>Harga Satuan</th>
                                    <th>PPN (%)</th>
                                    <th>PPN (Rp)</th>
                                    <th>HPP</th>
                                    <th>VEN</th>
                                    <th>ABC</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                $subtotal = 0;
                                foreach ($modDetails as $i => $modDetail) {
                                    $oa = ObatalkesM::model()->findByPk($modDetail->obatalkes_id);
                                    $modSupplier = ObatalkesV::model()->findByAttributes(array(
                                        'obatalkes_id' => $modDetail->obatalkes_id
                                    ));
                                    $sat = !empty($modDetail->satuankecil_id) ? $modDetail->satuankecil->satuankecil_nama : $modDetail->satuanbesar->satuanbesar_nama;
                                    $kecil = $oa->satuankecil->satuankecil_nama;
                                    $modLookup = ADLookupM::model()->findByAttributes(array('lookup_value' => $modDetail->obatalkes->ven));
                                ?>
                                    <tr>
                                        <td><?php echo $i + 1;
                                            echo ". "; ?></td>
                                        <td><?php echo $modSupplier->supplier_nama; ?></td>
                                        <td><?php echo empty($oa->jenisobatalkes_id) ? "-" : $oa->jenisobatalkes->jenisobatalkes_nama; ?></td>
                                        <td><?php echo $oa->obatalkes_nama; ?></td>
                                        <td><?php echo MyFormatter::formatDateTimeForUser($oa->tglkadaluarsa); ?></td>
                                        <td class="uang"><?php echo $modDetail->jmlharusorder . " " . $kecil; ?></td>
                                        <td class="uang" hidden><?php echo $modDetail->maksimalstok . " " . $kecil; ?></td>
                                        <td class="uang"><?php echo $modDetail->stokakhir . " " . $kecil; ?></td>
                                        <td class="uang"><?php echo $modDetail->kemasanbesar . " " . $kecil; ?></td>
                                        <td class="uang"><?php echo number_format($modDetail->jmlpermintaan, 2, ",", ".") . " " . $sat; ?></td>
                                        <td class="uang"><?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($modDetail->harganettorenc, 2) : "Hidden"; ?></td>
                                        <td class="uang"><?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? ($modDetail->persenppn) : "Hidden"; ?></td>
                                        <td class="uang"><?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($modDetail->ppn, 2) : "Hidden"; ?></td>
                                        <td class="uang"><?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($modDetail->hpp, 2) : "Hidden"; ?></td>
                                        <td><?php echo isset($modLookup->lookup_name) ? $modLookup->lookup_name : "-"; ?></td>
                                        <td><?php echo $modDetail->kategori_abc; ?></td>
                                        <td style="font-weight: normal; text-align: right;">
                                            <?php
                                            //                                if (!empty($modDetail->satuankecil_id)) {
                                            //                                    $subtotal = $modDetail->hpp * $modDetail->jmlpermintaan;
                                            //                                } else {
                                            //                                    $subtotal = $modDetail->hpp * $modDetail->jmlpermintaan * $modDetail->kemasanbesar;
                                            //                                }
                                            //$subtotal = ($modDetail->harganettorenc * $modDetail->jmlpermintaan);
                                            $total += $modDetail->hargatotalrenc;
                                            echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($modDetail->hargatotalrenc, 2) : "Hidden"; ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr style="border:1px solid;">
                                    <td colspan="15" style="text-align:right;font-weight: normal; font-style: italic;">Total Anggaran</td>
                                    <td style="font-weight: normal; font-style: italic; text-align: right;">
                                        <?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($total, 2) : "Hidden"; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="100%">
                            <tr>
                                <th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">&nbsp;</th>
                                <th style="width:50%; text-align:center; padding-bottom: 50px;">
                                    <?php
                                    if (isset($model->tglmenyetujui)) { ?>
                                        Kepala Instalasi Farmasi, <br> Menyetujui
                                        <br><br><br><br><br><br>
                                        ( <?php echo $model->PegawaimenyetujuiLengkap; ?> )
                                    <?php } ?>
                                </th>
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") {  ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php  }  ?>
    </div>

<?php
}
if ($caraPrint == 'PDF') {
?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <br>
        <div class="judulcontent"> <?php echo $judulLaporan   ?> </div>
        <br> <br>
        <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:150px">No. Rencana</td>
                <td style="width:10px">:</td>
                <td><?php echo $model->noperencnaan; ?></td>

                <td style="width:150px">Sumber Dana</td>
                <td style="width:10px">:</td>
                <td><?php echo (!empty($model->sumberdana_id) ? $model->sumberdana_nama : ""); ?></td>
            </tr>
            <tr>
                <td>Tanggal Rencana : </td>
                <td>:</td>
                <td><?php echo MyFormatter::formatDateTimeForUser($model->tglperencanaan); ?></td>
            </tr>

        </table><br />
        <table class="table">
            <thead>
                <tr style="border:1px solid;">
                    <th>No.</th>
                    <th>Jenis</th>
                    <th>Nama Obat</th>
                    <th>Tgl. Kadaluarsa</th>
                    <th>Minimal Stok</th>
                    <th>Maksimal Stok</th>
                    <th>Stok Akhir</th>
                    <th>Jumlah Kemasan (Satuan)</th>
                    <th>Jumlah Kebutuhan</th>
                    <th>Harga Satuan</th>
                    <th>PPN (%)</th>
                    <th>PPN (Rp)</th>
                    <th>HPP</th>
                    <th>VEN</th>
                    <th>ABC</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $subtotal = 0;
                foreach ($modDetails as $i => $modDetail) {
                    $oa = ObatalkesM::model()->findByPk($modDetail->obatalkes_id);
                    $sat = !empty($modDetail->satuankecil_id) ? $modDetail->satuankecil->satuankecil_nama : $modDetail->satuanbesar->satuanbesar_nama;
                    $kecil = $oa->satuankecil->satuankecil_nama;
                    $modLookup = ADLookupM::model()->findByAttributes(array('lookup_value' => $modDetail->obatalkes->ven));
                ?>
                    <tr>
                        <td><?php echo $i + 1;
                            echo ". "; ?></td>
                        <td><?php echo empty($oa->jenisobatalkes_id) ? "-" : $oa->jenisobatalkes->jenisobatalkes_nama; ?></td>
                        <td><?php echo $oa->obatalkes_nama; ?></td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($oa->tglkadaluarsa); ?></td>
                        <td class="uang"><?php echo $modDetail->minimalstok . " " . $kecil; ?></td>
                        <td class="uang"><?php echo $modDetail->maksimalstok . " " . $kecil; ?></td>
                        <td class="uang"><?php echo $modDetail->stokakhir . " " . $kecil; ?></td>
                        <td class="uang"><?php echo $modDetail->kemasanbesar . " " . $kecil; ?></td>
                        <td class="uang"><?php echo number_format($modDetail->jmlpermintaan, 2, ",", ".") . " " . $sat; ?></td>
                        <td class="uang"><?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($modDetail->harganettorenc, 2) : "Hidden"; ?></td>
                        <td class="uang"><?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? ($modDetail->persenppn) : "Hidden"; ?></td>
                        <td class="uang"><?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($modDetail->ppn, 2) : "Hidden"; ?></td>
                        <td class="uang"><?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($modDetail->hpp, 2) : "Hidden"; ?></td>
                        <td><?php echo isset($modLookup->lookup_name) ? $modLookup->lookup_name : "-"; ?></td>
                        <td><?php echo $modDetail->kategori_abc; ?></td>
                        <td style="font-weight: normal; text-align: right;">
                            <?php
                            //                                if (!empty($modDetail->satuankecil_id)) {
                            //                                    $subtotal = $modDetail->hpp * $modDetail->jmlpermintaan;
                            //                                } else {
                            //                                    $subtotal = $modDetail->hpp * $modDetail->jmlpermintaan * $modDetail->kemasanbesar;
                            //                                }
                            //$subtotal = ($modDetail->harganettorenc * $modDetail->jmlpermintaan);
                            $total += $modDetail->hargatotalrenc;
                            echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($modDetail->hargatotalrenc, 2) : "Hidden"; ?>
                        </td>
                    </tr>
                <?php } ?>

                <tr style="border:1px solid;">
                    <td colspan="15" style="text-align:right;font-weight: normal; font-style: italic;">Total Anggaran</td>
                    <td style="font-weight: normal; font-style: italic; text-align: right;">
                        <?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($total, 2) : "Hidden"; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%">
            <tr>
                <th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">&nbsp;</th>
                <th style="width:50%; text-align:center; padding-bottom: 50px;">
                    <?php
                    if (isset($model->tglmenyetujui)) { ?>
                        Kepala Instalasi Farmasi, <br> Menyetujui
                        <br><br><br><br><br><br>
                        ( <?php echo $model->PegawaimenyetujuiLengkap; ?> )
                    <?php } ?>
                </th>
            </tr>
        </table>
    </div>

<?php
}
?>