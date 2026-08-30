<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 14.7cm;
    }
    .content td{
        /*height: 48px;*/
    }
</style>    
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%">: <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%">: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<!--<table width="100%" class="content" style="border: none;">-->
<?php 
if (count((array)$modPemeriksaanFisik)>0){
foreach ($modPemeriksaanFisik as $i => $loop){
?>
<div class="row">
	<div class="span12">
		<span style="text-align:center;vertical-align:middle;font-weight:bold;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;
            PERIKSA FISIK
		</span>
	</div>
	<div class="col-sm-6">
		<table>
			<tr>
				<td style="width:20%">Nama Dokter</td>
				<td style="width:25%">: <?php echo (isset($loop->pegawai_id) ? $loop->pegawai->nama_pegawai :"-"); ?></td>				
			</tr>
			<tr>
				<td width="20%">Inspeksi</td>
				<td width="30%">: <?php echo isset($loop->inspeksi)?$loop->inspeksi:" - "; ?></td>				
			</tr>
			<tr>
				<td width="15%">Palpasi</td>
				<td width="30%">: <?php echo isset($loop->palpasi)?$loop->palpasi:" - "; ?></td>
			</tr>
			<tr>
				<td width="15%">Detak Nadi</td>
				<td width="30%">: <?php echo (isset($loop->detaknadi)?$loop->detaknadi:" - ").' /Menit'; ?></td>
			</tr>
			<tr>
				<td width="15%">Denyut Jantung</td>
				<td width="30%">: <?php echo (isset($loop->denyutjantung)?$loop->denyutjantung:" - "); ?></td>
			</tr>
			<tr>
				<td width="15%">Tekanan Darah</td>
				<td width="30%">: <?php echo (isset($loop->tekanandarah)?$loop->tekanandarah:" - ").' /MmHg'; ?></td>
			</tr>
			<tr>
				<td width="15%">Mean Arterial Pressure</td>
				<td width="30%">: <?php echo isset($loop->meanarteripressure)?$loop->meanarteripressure:" - "; ?></td>
			</tr>
			<tr>
				<td width="15%">Suhu Tubuh</td>
				<td width="30%">: <?php echo (isset($loop->suhutubuh)?$loop->suhutubuh:" - ").' &deg; Celcius'; ?></td>
			</tr>
			<tr>
				<td width="15%">Perkusi</td>
				<td width="30%">: <?php echo isset($loop->perkusi)?$loop->perkusi:" - "; ?></td>
			</tr>
			<tr>
				<td width="15%">Auskultasi</td>
				<td width="30%">: <?php echo isset($loop->auskultasi)?$loop->auskultasi:" - "; ?></td>
			</tr>
			<tr>
				<td width="15%">Tinggi badan / Berat badan</td>
				<td width="30%">: <?php echo (isset($loop->tinggibadan_cm)?$loop->tinggibadan_cm:" - ").' Cm / '.(isset($loop->beratbadan_kg)?$loop->beratbadan_kg:" - ").' Kg'; ?></td>
			</tr>
			<tr>
				<td width="15%">Index Masa Tubuh</td>
				<td width="30%">: <?php echo (isset($loop->indexmassatubuh)?$loop->indexmassatubuh:" - "); ?></td>
			</tr>
			<tr>
				<td width="15%">Pernapasan</td>
				<td width="30%">: <?php echo (isset($loop->pernapasan)?$loop->pernapasan:" - ").' /Menit'; ?></td>
			</tr>
			<tr>
				<td width="15%">Kelainan Pada Bagian Tubuh</td>
				<td width="30%">: <?php echo isset($loop->kelainanpadabagtubuh)?$loop->kelainanpadabagtubuh:" - "; ?></td>
			</tr>
		</table>
	</div>
	<div class="col-sm-6">
		<table>
			<tr>
				<td style="width:20%">Tanggal Periksa</td>
				<td style="width:30%">: <?php echo (isset($loop->tglperiksafisik) ? $loop->tglperiksafisik :"-"); ?></td>
			</tr>
		</table>
		<table border="1">
			<tr>
				<td colspan="3"><b>PEMERIKSAAN ANGGOTA TUBUH</b></td>
			</tr>
			<?php 
			if(count((array)$modPemeriksaanGambar)>0){?>
				<tr>
					<td><p style="margin: 0; text-align: center;"><b>No.</b></p></td>
					<td><b>Bagian Tubuh</b></td>
					<td><b>Keterangan</b></td>
				</tr>
				<?php foreach($modPemeriksaanGambar as $i => $v ){ ?>
				<tr>
					<td><p style="margin: 0; text-align: center;"><?= $i+1; ?></p></td>
					<td><?php echo $v->bagiantubuh->namabagtubuh; ?></td>
					<td><?php echo $v->keterangan_periksa_gbr; ?></td>
				</tr>
				<?php } ?>
			<?php } ?>
		</table>
	</div>
</div>
    <tr>
        <td>&nbsp;</td>
        <td ></td>
    </tr>
    
    
    <tr><td colspan="6"><hr></td></tr>
<?php }
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada pemeriksaan fisik</td>
    </tr> 
<?php } ?>
<!--</table>-->
