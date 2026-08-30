
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 5));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <fieldset>
            <table class="items table table-striped table-condensed">
                <tr>
                    <td>No. Dekontaminasi</td>
                    <td>:</td>
                    <td><?php echo isset($model->dekontaminasi_no) ? $model->dekontaminasi_no : ""; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Dekontaminasi</td>
                    <td>:</td>
                    <td><?php echo isset($model->dekontaminasi_tgl) ? MyFormatter::formatDateTimeForUser($model->dekontaminasi_tgl) : ""; ?></td>
                </tr>
                <tr>
                    <td>Pegawai Dekontaminasi</td>
                    <td>:</td>
                    <td><?php echo (isset($model->pegpetugas->NamaLengkap) ? $model->pegpetugas->NamaLengkap : ""); ?></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td><?php echo isset($model->dekontaminasi_ket) ? $model->dekontaminasi_ket : ""; ?></td>
                </tr>
            </table><br>
            <table class="items table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No. Penerimaan Sterilisasi</th>
                        <th>Ruangan Asal</th>
                        <th>Nama Peralatan</th>
                        <th>Jumlah</th>
                        <th>Lama Dekontaminasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count((array)$modDetails) > 0) {
                        $disabled = false;
                        foreach ($modDetails AS $i => $detail) {
                            ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo (!empty($detail->penerimaansterilisasi_id) ? $detail->penerimaansterilisasi->penerimaansterilisasi_no : ""); ?></td>
                                <td><?php echo (!empty($detail->ruangan_id) ? $detail->ruangan->ruangan_nama : ""); ?></td>
                                <td><?php echo (!empty($detail->peralatansterilisasi_id) ? $detail->peralatansterilisasi->peralatansterilisasi_nama : ""); ?></td>
                                <td><?php echo (!empty($detail->dekontaminasidetail_jml) ? $detail->dekontaminasidetail_jml : ""); ?></td>
                                <td><?php echo (!empty($detail->dekontaminasidetail_lama) ? $detail->dekontaminasidetail_lama : ""); ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        $disabled = true;
                        ?>
                        <tr>
                            <td colspan="6">Data tidak ditemukan.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </fieldset>

        <table class="table">
            <tr>
                <th colspan="3" style="width:50%; text-align:center; padding-bottom: 50px;">
                    Pegawai Mengetahui,
                    <br><br><br><br><br><br>
                    ( <?php echo isset($model->pegmengetahui_id) ? $model->pegmengetahui->NamaLengkap : "-"; ?> )		
                </th>
                <th colspan="3"style="width:50%; text-align:center; padding-bottom: 50px;">
                    Pegawai Dekontaminasi,
                    <br><br><br><br><br><br>
                    ( <?php echo $model->pegpetugas->NamaLengkap; ?> )
                </th>
            </tr>
        </table>

    </div>

    <?php
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'EXCEL') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => ''));
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <fieldset>
                            <table class="table-border">
                                <tr>
                                    <td>No. Dekontaminasi</td>
                                    <td>:</td>
                                    <td><?php echo isset($model->dekontaminasi_no) ? $model->dekontaminasi_no : ""; ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Dekontaminasi</td>
                                    <td>:</td>
                                    <td><?php echo isset($model->dekontaminasi_tgl) ? MyFormatter::formatDateTimeForUser($model->dekontaminasi_tgl) : ""; ?></td>
                                </tr>
                                <tr>
                                    <td>Pegawai Dekontaminasi</td>
                                    <td>:</td>
                                    <td><?php echo (isset($model->pegpetugas->NamaLengkap) ? $model->pegpetugas->NamaLengkap : ""); ?></td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td>:</td>
                                    <td><?php echo isset($model->dekontaminasi_ket) ? $model->dekontaminasi_ket : ""; ?></td>
                                </tr>
                            </table><br>
                            <table class="table-border">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Penerimaan Sterilisasi</th>
                                        <th>Ruangan Asal</th>
                                        <th>Nama Peralatan</th>
                                        <th>Jumlah</th>
                                        <th>Lama Dekontaminasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count((array)$modDetails) > 0) {
                                        $disabled = false;
                                        foreach ($modDetails AS $i => $detail) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i + 1; ?></td>
                                                <td><?php echo (!empty($detail->penerimaansterilisasi_id) ? $detail->penerimaansterilisasi->penerimaansterilisasi_no : ""); ?></td>
                                                <td><?php echo (!empty($detail->ruangan_id) ? $detail->ruangan->ruangan_nama : ""); ?></td>
                                                <td><?php echo (!empty($detail->peralatansterilisasi_id) ? $detail->peralatansterilisasi->peralatansterilisasi_nama : ""); ?></td>
                                                <td><?php echo (!empty($detail->dekontaminasidetail_jml) ? $detail->dekontaminasidetail_jml : ""); ?></td>
                                                <td><?php echo (!empty($detail->dekontaminasidetail_lama) ? $detail->dekontaminasidetail_lama : ""); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        $disabled = true;
                                        ?>
                                        <tr>
                                            <td colspan="6">Data tidak ditemukan.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </fieldset>

                        <table class="table">
                            <tr>
                                <th  style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
                                    Pegawai Mengetahui,
                                    <br><br><br><br><br><br>
                                    ( <?php echo isset($model->pegmengetahui_id) ? $model->pegmengetahui->NamaLengkap : "-"; ?> )		
                                </th>
                                <th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
                                    Pegawai Dekontaminasi,
                                    <br><br><br><br><br><br>
                                    ( <?php echo $model->pegpetugas->NamaLengkap; ?> )
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>   

    <?php
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
    </div>
    <div class="content">
        <fieldset>
            <table class="table border">
                <tr>
                    <td>No. Dekontaminasi</td>
                    <td>:</td>
                    <td><?php echo isset($model->dekontaminasi_no) ? $model->dekontaminasi_no : ""; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Dekontaminasi</td>
                    <td>:</td>
                    <td><?php echo isset($model->dekontaminasi_tgl) ? MyFormatter::formatDateTimeForUser($model->dekontaminasi_tgl) : ""; ?></td>
                </tr>
                <tr>
                    <td>Pegawai Dekontaminasi</td>
                    <td>:</td>
                    <td><?php echo (isset($model->pegpetugas->NamaLengkap) ? $model->pegpetugas->NamaLengkap : ""); ?></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td><?php echo isset($model->dekontaminasi_ket) ? $model->dekontaminasi_ket : ""; ?></td>
                </tr>
            </table><br>
            <table class="table border">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No. Penerimaan Sterilisasi</th>
                        <th>Ruangan Asal</th>
                        <th>Nama Peralatan</th>
                        <th>Jumlah</th>
                        <th>Lama Dekontaminasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count((array)$modDetails) > 0) {
                        $disabled = false;
                        foreach ($modDetails AS $i => $detail) {
                            ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo (!empty($detail->penerimaansterilisasi_id) ? $detail->penerimaansterilisasi->penerimaansterilisasi_no : ""); ?></td>
                                <td><?php echo (!empty($detail->ruangan_id) ? $detail->ruangan->ruangan_nama : ""); ?></td>
                                <td><?php echo (!empty($detail->peralatansterilisasi_id) ? $detail->peralatansterilisasi->peralatansterilisasi_nama : ""); ?></td>
                                <td><?php echo (!empty($detail->dekontaminasidetail_jml) ? $detail->dekontaminasidetail_jml : ""); ?></td>
                                <td><?php echo (!empty($detail->dekontaminasidetail_lama) ? $detail->dekontaminasidetail_lama : ""); ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        $disabled = true;
                        ?>
                        <tr>
                            <td colspan="6">Data tidak ditemukan.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </fieldset>

        <table class="table">
            <tr>
                <th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
                    Pegawai Mengetahui,
                    <br><br><br><br><br><br>
                    ( <?php echo isset($model->pegmengetahui_id) ? $model->pegmengetahui->NamaLengkap : "-"; ?> )		
                </th>
                <th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
                    Pegawai Dekontaminasi,
                    <br><br><br><br><br><br>
                    ( <?php echo $model->pegpetugas->NamaLengkap; ?> )
                </th>
            </tr>
        </table>

    </div>

    <?php
}
?>
