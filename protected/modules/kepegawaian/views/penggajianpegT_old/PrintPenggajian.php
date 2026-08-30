<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));  
?>
<br><br>
<table width="100%" border="0">
	<tr>
		<td colspan="4" style="border-bottom: #000 solid 2px"><td>
	</tr>
	<tr>
		<td width="15%"><b>NIP</b></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->nomorindukpegawai; ?></td>
		<td width="15%"><b>No. Rekening</b></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->no_rekening; ?> / <?php echo $modelpegawai->bank_no_rekening; ?></td>
	</tr>
	<tr>
		<td width="15%"><b>Nama Pegawai</b></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->nama_pegawai; ?></td>
		<td width="15%"><b>Npwp</b></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->npwp; ?></td>
	</tr>
	<tr>
		<td width="15%"><b>Tempat Lahir</b></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->tempatlahir_pegawai; ?></td>
		<td width="15%"><b>No. Telepon</b></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->notelp_pegawai; ?> / <?php echo $modelpegawai->nomobile_pegawai; ?></td>
	</tr>
	<tr>
		<td width="15%"><b>Tanggal Lahir</b></td>
		<td width="35%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($modelpegawai->tgl_lahirpegawai); ?></td>
		<td width="15%"><b>Agama</b></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->agama; ?></td>
	</tr>
	<tr>
		<td width="15%"><b>Jabatan</b></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->jabatan->jabatan_nama; ?></td>
		<td width="15%"><b>Alamat</b></td>
		<td width="35%">: &nbsp; <?php echo $modelpegawai->alamat_pegawai; ?></td>
	</tr>
	<tr>
		<td colspan="4" style="border-bottom: #000 solid 2px"><td>
	</tr>
</table>
<br><br>
<table width="100%" border="0">
	<tr>
		<td width="15%"></td>
		<td width="10%"><b>Total Terima</b></td>
		<td width="25%">: &nbsp; <?php echo MyFormatter::formatUang($model->totalterima); ?></td>
		<td width="10%"><b>Tanggal Penggajian</b></td>
		<td width="25%">: &nbsp; <?php echo MyFormatter::formatDateTimeId($model->tglpenggajian); ?></td>
		
		<td width="15%"></td>
	</tr>
	<tr>
		<td width="15%"></td>
		<td width="10%"><b>Total Potongan</b></td>
		<td width="25%">: &nbsp; <?php echo MyFormatter::formatUang($model->totalpotongan); ?></td>
		<td width="10%"><b>No. Penggajian</b></td>
		<td width="25%">: &nbsp; <?php echo $model->nopenggajian; ?></td>
		<td width="15%"></td>
	</tr>
	<tr>
		<td width="15%"></td>
		<td width="10%"><b>Total Pajak</b></td>
		<td width="25%">: &nbsp; <?php echo MyFormatter::formatUang($model->totalpajak); ?></td>
		<td width="10%"><b>Keterangan</b></td>
		<td width="25%">: &nbsp; <?php echo $model->keterangan; ?></td>
		<td width="15%"></td>
	</tr>
	<tr>
		<td width="15%"></td>
		<td width="10%"><b>Penerimaan Bersih</b></td>
		<td width="25%">: &nbsp; <?php echo MyFormatter::formatUang($model->penerimaanbersih); ?></td>
		<td width="10%"><b></b></td>
		<td width="25%"></td>
		<td width="15%"></td>
	</tr>
</table>
<br><br>
<table width="100%" border="1">
    <tr>
		<td colspan="4" style="border-bottom: #000 solid 2px"><td>
	</tr>
</table>
<br><br>
<table style="width:100%;">
    <tr>
        <td width="50%" style="text-align: center;">Mengetahui,</td>
        <td width="50%" style="text-align: center;">Menyetujui,</td>
    </tr>
    <tr><td>&nbsp;</td><td></td></tr>
    <tr><td>&nbsp;</td><td></td></tr>
    <tr><td>&nbsp;</td><td></td></tr>
	<tr>
        <td width="50%" style="text-align: center;"><b>(<?php echo $model->mengetahui; ?>)</b></td>
        <td width="50%" style="text-align: center;"><b>(<?php echo $model->menyetujui; ?>)</b></td>
    </tr>
</table>