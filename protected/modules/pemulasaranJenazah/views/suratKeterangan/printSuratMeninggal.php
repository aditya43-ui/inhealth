<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>
<style>
	.conten td{
		padding-bottom: 5px;
	}
	.table_border{border: 1px solid #000;}
	.table_border td {border: 1px solid #000;}
</style>
<br>
<table style="width:100%;">
    <tr>
        <td>
			<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
        </td>
    </tr>
	<table style="width:100%;" class="table_border">
		<tr>
			<td colspan="5" style="text-align: center"><h3><u><?php echo strtoupper($model->judulsurat); ?></u></h3></td>
		</tr>
		<tr style="height:30px;">
			<td colspan="3">Nama : <?php echo $modPasien->nama_pasien; ?></td>
			<td rowspan="2"><?php echo $modPasien->jeniskelamin; ?></td>
			<td colspan="2" style="text-align: center">No Register : <?php echo $modPendaftaran->no_pendaftaran; ?></td>
		</tr>
		<tr style="height:30px;">
			<td>Umur : <?php echo $modPendaftaran->umur; ?></td>
			<td>Ruang : <?php echo $model->ruangan->ruangan_nama; ?></td>
			<td>Lantai :</td>
			<td style="text-align: center">No Rekam Medik : <?php echo $modPasien->no_rekam_medik; ?></td>
		</tr>
	</table>
    <tr>
        <td>
	<p style="margin: 0; text-align: center;">
		<!--<h3><u><?php // echo strtoupper($model->judulsurat); ?></u></h3>-->
		<h3>No. <?php echo $model->nomorsurat; ?></h3>
	</p><br><br>
</td>
</tr>
<tr>
	<td style="width:20px;">
		<p align="justify">Yang bertanda tangan dibawah ini Dokter <?php echo Yii::app()->user->getState('nama_rumahsakit'); ?> menerangkan dengan sesungguhnya atas sumpah (perjanjian) ketika memangku jabatan bahwa orang tersebut di bawah ini : </p>
	</td>
</tr>
<table width="100%" style="width:500px;margin-left:80px;margin-top:10px;" class="conten">
	<tr>
		<td width="40%">Nama</td>
		<td>:</td>
		<td><?php echo $modPasien->nama_pasien; ?></td>
	</tr>
	<tr>
		<td>No. Rekam Medis</td>
		<td>:</td>
		<td><?php echo $modPasien->no_rekam_medik; ?></td>
	</tr>
	<tr>
		<td>Jenis Kelamin</td>
		<td>:</td>
		<td><?php echo $modPasien->jeniskelamin; ?></td>
	</tr>
	<tr>
		<td>Tanggal Lahir</td>
		<td>:</td>
		<td><?php echo $modPasien->tanggal_lahir; ?></td>
	</tr>
	<tr>
		<td>Umur</td>
		<td>:</td>
		<td><?php echo $modPendaftaran->umur; ?></td>
	</tr>
	<tr>
		<td>Agama</td>
		<td>:</td>
		<td><?php echo $modPasien->agama; ?></td>
	</tr>
	<tr>
		<td>Kewarganegaraan</td>
		<td>:</td>
		<td><?php echo $modPasien->warga_negara; ?></td>
	</tr>
	<tr>
		<td>Pekerjaan</td>
		<td>:</td>
		<td><?php echo isset($modPasien->pekerjaan_id) ? $modPasien->pekerjaan->pekerjaan_nama : ''; ?></td>
	</tr>
<!--	<tr>
		<td style="vertical-align:top;">Alamat</td>
		<td style="vertical-align:top;">:</td>
		<td>
			<?php 
//				echo $modPasien->alamat_pasien.". <br>RT/RW:".$modPasien->rt.'/'.$modPasien->rw;
//				echo "<br>Kelurahan : ";
//				if(!empty($modPasien->kelurahan_id)){
//					echo $modPasien->kelurahan->kelurahan_nama;
//				}
//				echo "<br>Kecamatan : ";
//				if(!empty($modPasien->kecamatan_id)){
//					echo $modPasien->kecamatan->kecamatan_nama;
//				}
//				echo "<br>HP : ".$modPasien->no_mobile_pasien; 
			?>
		</td>
	</tr>-->
<!--	<tr>
		<td>Alamat Email</td>
		<td>:</td>
		<td><?php // echo $modPasien->alamatemail; ?></td>
	</tr>-->
</table><br>
<p align="justify">
	Dengan ini menyatakan sesungguhnya kematian warga Negara Indonesia pada hari <?php echo isset($modPasienPulang->tglpasienpulang)? MyFormatter::getDayUser(date("w", strtotime($modPasienPulang->tglpasienpulang))+1) : ''; ?>, tanggal <?php echo isset($modPasienPulang->tglpasienpulang)? MyFormatter::formatDateTimeForUser($modPasienPulang->tglpasienpulang) : ""; ?>, di <?php echo Yii::app()->user->getState('nama_rumahsakit'); ?>
</p>
<br>
<table style="width:100%;">
	<tr>
		<td style="text-align: center">
			Keluarga yang menerima,
		</td>
		<td style="text-align: center">
			<?php $date = date('Y-m-d'); ?>
			<?php echo $data->kabupaten->kabupaten_nama; ?>, <?php echo MyFormatter::formatDateTimeForUser($date); ?><br>
			Dokter Pemeriksa,
		</td>
	</tr>
	<tr style="height:150px;">
		<td style="text-align: center">
			(_________________)
		</td>
		<td style="text-align: center">
			<?php echo $model->mengetahui_surat; ?>
		</td>
	</tr>
</table>
	
</table>
</table>
<div class="footer">
<?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>

