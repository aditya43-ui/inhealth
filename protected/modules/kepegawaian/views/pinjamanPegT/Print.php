<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}

// $this->widget($table,array(
// 	'id'=>'sajenis-kelas-m-grid',
//         'enableSorting'=>$sort,
// 	'dataProvider'=>$data,
//         'template'=>$template,
//         'itemsCssClass'=>'table table-striped table-bordered table-condensed',
// 	'columns'=>array(
// 		////'presensi_id',
// 		array(
//                         'header'=>'ID',
//                         'value'=>'$data->presensi_id',
//                 ),
// 		'statuskehadiran_id',
// 		'pegawai_id',
// 		'statusscan_id',
// 		'tglpresensi',
// 		'no_fingerprint',
// 		/*
// 		'verifikasi',
// 		'keterangan',
// 		'jamkerjamasuk',
// 		'jamkerjapulang',
// 		'terlambat_mnt',
// 		'pulangawal_mnt',
// 		'create_time',
// 		'update_time',
// 		'create_loginpemakai_id',
// 		'update_loginpemakai_id',
// 		'create_ruangan',
// 		*/

//         ),
//     )); 
$format = new MyFormatter();
$modPinjamDetail = KPPinjamPegDetT::model()->findAllByAttributes(array('pinjamanpeg_id' => $model->pinjamanpeg_id), array('order' => 'angsuranke'));
?>
<table align="center">
    <tr>
        <td width="130px"><b>NIP</b></td>
        <td>:</td>
        <td width="230px"><?php echo $modPegawai->nomorindukpegawai; ?></td>
        <td width="130px"><b>No. Telp</b></td>
        <td>:</td>
        <td><?php echo $modPegawai->notelp_pegawai . ' - ' . $modPegawai->nomobile_pegawai; ?></td>
    </tr>
    <tr>
        <td><b>Nama Pegawai</b></td>
        <td>:</td>
        <td><?php echo $modPegawai->nama_pegawai; ?></td>
        <td><b>Alamat</b></td>
        <td>:</td>
        <td><?php echo $modPegawai->alamat_pegawai; ?></td>
    </tr>
    <tr>
        <td><b>Tempat Lahir</b></td>
        <td>:</td>
        <td><?php echo $modPegawai->tempatlahir_pegawai; ?></td>
        <td><b>Tanggal Lahir</b></td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeId($modPegawai->tgl_lahirpegawai); ?></td>
    </tr>
    <tr>
        <td><b>Jenis Kelamin</b></td>
        <td>:</td>
        <td><?php echo $modPegawai->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td colspan="6">
            <hr>
        </td>
    </tr>
    <tr>
        <td><b>Tgl. Peminjaman</b></td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeId(date("Y-m-d", strtotime($model->tglpinjampeg))); ?></td>
        <td><b>Lama Pinjam</b></td>
        <td>:</td>
        <td><?php echo $model->lamapinjambln . ' Bulan'; ?></td>
    </tr>
    <tr>
        <td><b>No. Peminjaman</b></td>
        <td>:</td>
        <td><?php echo $model->nopinjam; ?></td>
        <td><b>Bunga Pinjam</b></td>
        <td>:</td>
        <td><?php echo $model->persenpinjaman . ' %'; ?></td>
    </tr>
    <tr>
        <td><b>Jumlah Peminjaman (Rp)</b></td>
        <td>:</td>
        <td><?php echo number_format($model->jumlahpinjaman, 0, "", "."); ?></td>
        <td><b>Untuk Keperluan</b></td>
        <td>:</td>
        <td><?php echo $model->untukkeperluan; ?></td>
    </tr>
    <tr>
        <td><b>Keterangan</b></td>
        <td>:</td>
        <td><?php echo $model->keterangan; ?></td>
    </tr>
    <tr>
        <td colspan="6">
            <hr>
        </td>
    </tr>
</table>
<table align="center" border="1" width="100%">
    <tr>
        <th>No.</th>
        <th>Bulan Ke</th>
        <th>Tgl. Pembayaran</th>
        <th>Jumlah Bayar</th>
    </tr>
    <?php
    $no = 1;
    foreach ($modPinjamDetail as $key => $data) {
    ?>
        <tr>
            <th width="50px"><?php echo $no; ?></th>
            <th width="100px"><?php echo $data['angsuranke']; ?></th>
            <th width="150px"><?php echo $format->formatDateTimeId($data['tglakanbayar']); ?></th>
            <th width="180px"><?php echo number_format($data['jmlcicilan']); ?></th>
        </tr>
    <?php
        $no++;
    }
    ?>
</table>