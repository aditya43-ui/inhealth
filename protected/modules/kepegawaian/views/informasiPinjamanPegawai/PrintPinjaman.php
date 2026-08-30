
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    $format = new MyFormatter();
    $modPinjamDetail = KPPinjamPegDetT::model()->findAllByAttributes(array('pinjamanpeg_id'=>$model->pinjamanpeg_id),array('order'=>'angsuranke'));
?>
<table align="center">
    <tr>
        <td width="130px">NIP</td>
        <td>:</td>
        <td width="230px"><?php echo $modPegawai->nomorindukpegawai; ?></td>
        <td width="130px">No. Telp</td>
        <td>:</td>
        <td><?php echo $modPegawai->notelp_pegawai.' - '.$modPegawai->nomobile_pegawai; ?></td>
    </tr>
    <tr>
        <td>Nama Pegawai</td>
        <td>:</td>
        <td><?php echo $modPegawai->nama_pegawai; ?></td>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo $modPegawai->alamat_pegawai; ?></td>
    </tr>
    <tr>
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><?php echo $modPegawai->tempatlahir_pegawai; ?></td>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeId($modPegawai->tgl_lahirpegawai); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo $modPegawai->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td colspan="6"><hr></td>
    </tr>
    <tr>
        <td>Tgl. Peminjaman</td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeId($model->tglpinjampeg); ?></td>
        <td>Lama Pinjam</td>
        <td>:</td>
        <td><?php echo $model->lamapinjambln.' Bulan'; ?></td>
    </tr>
    <tr>
        <td>No. Peminjaman</td>
        <td>:</td>
        <td><?php echo $model->nopinjam; ?></td>
        <td>Bunga Pinjam</td>
        <td>:</td>
        <td><?php echo $model->persenpinjaman.' %'; ?></td>
    </tr>
    <tr>
        <td>Jumlah Peminjaman</td>
        <td>:</td>
        <td><?php echo number_format($model->jumlahpinjaman); ?></td>
        <td>Untuk Keperluan</td>
        <td>:</td>
        <td><?php echo $model->untukkeperluan; ?></td>
    </tr>
    <tr>
        <td>Keterangan</td>
        <td>:</td>
        <td><?php echo $model->keterangan; ?></td>
    </tr>
    <tr>
        <td colspan="6"><hr></td>
    </tr>
</table>
<table align="center" border="1">
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