<style>
	.conten td{
		padding-bottom: 5px;
	}
</style>

<?php
	$format = new MyFormatter();
	$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
	if(!empty($_GET['pendaftaran_id'])){
		$pendaftaran_id = $_GET["pendaftaran_id"];
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
		$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
		// $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
		$modPasien->tanggal_lahir = $format->formatDateTimeForUser($modPasien->tanggal_lahir);
		if(!empty($modPendaftaran->pasienadmisi_id)){
			$modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
			// $model->mengetahui_surat = (isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pegawai->namaLengkap : $model->mengetahui_surat);
		}else{
			$modAdmisi = new PasienadmisiT;
			$modAdmisi->tgladmisi = date('Y-m-d')." 00:00:00";
			$modAdmisi->tglpulang = date('Y-m-d')." 00:00:00";
		}
		$modPasMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
		$kodeicd = !empty($modPasMorbiditas)?$modPasMorbiditas->diagnosa->diagnosa_kode:' - ';
	}else{
		$model->tglsurat = date('Y-m-d');
	}
?>
<br>
<table style="width:100%;">
    <tr>
        <td>
            <?php echo $this->renderPartial('application.views.headerReport.headerDefaultSurat'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <p style="margin: 0; text-align: center;">
                <h3><u><?php echo strtoupper($model->judulsurat); ?></u></h3>
                <h3>No. <?php echo $model->nomorsurat; ?></h3>
            </p><br><br>
        </td>
    </tr>
    <tr>
        <td>
            Yang bertanda tangan dibawah ini Dokter <?php echo Yii::app()->user->getState('nama_rumahsakit'); ?> menerangkan bahwa,
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
			<td><?php echo $modPasien->jeniskelamin; ?></td>
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
			<td><?php echo $modPasien->pekerjaan->pekerjaan_nama; ?></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>:</td>
			<td><?php echo $modPasien->alamat_pasien; ?></td>
		</tr>
	</table><br>
    <p align="justify">
            Telah meninggal dunia di <?php echo Yii::app()->user->getState('nama_rumahsakit'); ?> pada,
            <table width="100%" style="width:500px;margin-left:80px;">
			<tr>
				<td width="40%">Hari</td>
				<td>:</td>
				<td><?php echo $format->getDayUser(date("w",  strtotime($modAdmisi->tglpulang))); ?></td>
			</tr> 
			<tr>
				<td>Tanggal</td>
				<td>:</td>
				<td><?php echo $format->formatDateTimeForUser(date('Y-m-d' ,strtotime($modAdmisi->tglpulang))); ?></td>
			</tr> 
			<tr>
				<td>Pukul</td>
				<td>:</td>
				<td><?php echo substr($modAdmisi->tglpulang, -8,5); ?> WITA</td>
			</tr> 
			<tr>
				<td>Penyebab Kematian</td>
				<td>:</td>
				<td><?php echo  $model->penyebabkematian; ?></td>
			</tr>
			<tr>
				<td>Kode ICD</td>
				<td>:</td>
				<td><?php echo  $kodeicd ?></td>
			</tr>
        </table><br>
        </p>
        <p align="justify">
           Demikianlah surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.
        </p>
		<br>
    <div style="margin-left: 450px">
		<?php $date = date('Y-m-d'); ?>
		<?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?><br>
		Dokter Pemeriksa, 
		<br><br><br><br><br>
	<!--(_________________)-->
	<?php
		echo $model->mengetahui_surat;
	?>
	</div>
</table>

