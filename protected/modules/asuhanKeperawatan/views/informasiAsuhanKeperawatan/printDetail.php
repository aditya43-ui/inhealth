<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

echo $this->renderPartial('application.views.headerReport.headerAnggaran', array('judulLaporan' => $judulLaporan, 'deskripsi' => $deskripsi, 'colspan' => 10));
?>
<fieldset>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tanggal Asuhan Keperawatan</td>
            <td>:</td>
            <td><?php echo isset($model->tglaskep) ? MyFormatter::formatDateTimeForUser($model->tglaskep) : ""; ?></td>
        </tr>
        <tr>
            <td>No. Pendaftaran</td>
            <td>:</td>
            <td><?php echo (isset($model->pendaftaran->no_pendaftaran) ? $model->pendaftaran->no_pendaftaran : ""); ?></td>
        </tr>
        <tr>
            <td>No. Rekam Medik</td>
            <td>:</td>
            <td><?php echo (isset($model->pasien->no_rekam_medik) ? $model->pasien->no_rekam_medik : ""); ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo (isset($model->pasien->nama_pasien) ? $model->pasien->nama_pasien : ""); ?></td>
        </tr>
    </table><br>
</fieldset>
<fieldset>
    <h6>Tabel Rencana dan <b>Implementasi Keperawatan</b></h6>
    <table width="100%" class="table table-striped table-condensed" id='asuhankeperawatan'>
        <thead>
            <tr>
                <th>Diagnosa </th>
                <th width="200">Intervensi</th>
                <th width="200">Implementasi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count((array)$model) > 0) {
                $disabled = false;
            ?>
                <tr>
                    <td><?php echo isset($model->diagnosakeperawatan_id) ? $model->diagnosakeperawatan->diagnosakeperawatan_kode : ""; ?><br>
                        <?php echo isset($model->diagnosakeperawatan->diagnosa_id) ? $model->diagnosakeperawatan->diagnosa->diagnosa_kode . " - " . $model->diagnosakeperawatan->diagnosa->diagnosa_nama : ""; ?>
                    </td>
                    <td><?php $this->renderPartial('_intervensilanjutan', array('asuhankeperawatan_id' => $model->asuhankeperawatan_id)); ?></td>
                    <td><?php $this->renderPartial('_rencanaKeperawatan', array('asuhankeperawatan_id' => $model->asuhankeperawatan_id)); ?></td>
                </tr>
            <?php } else {
                $disabled = true; ?>
                <tr>
                    <td colspan="3"><i>Data tidak ditemukan.</i>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h6>Tabel <b>Planning Keperawatan</b></h6>
    <table class="table table-striped table-condensed" id="asuhankeperawatan3">
        <thead>
            <tr>
                <th>Diagnosa</th>
                <th colspan='2'>Planning</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count((array)$model) > 0) {
                $disabled = false;
            ?>
                <tr>
                    <td><?php echo isset($model->diagnosakeperawatan_id) ? $model->diagnosakeperawatan->diagnosakeperawatan_kode : ""; ?><br>
                        <?php echo isset($model->diagnosakeperawatan->diagnosa_id) ? $model->diagnosakeperawatan->diagnosa->diagnosa_kode . " - " . $model->diagnosakeperawatan->diagnosa->diagnosa_nama : ""; ?>
                    </td>
                    <td><?php $this->renderPartial('_intervensilanjutan', array('asuhankeperawatan_id' => $model->asuhankeperawatan_id)); ?></td>
                </tr>
            <?php } else {
                $disabled = true; ?>
                <tr>
                    <td colspan="3"><i>Data tidak ditemukan.</i>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</fieldset>