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
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
	$modPasien->tanggal_lahir = $format->formatDateTimeForUser($modPasien->tanggal_lahir);
    
}else{
    $model->tglsurat = date('Y-m-d');
}

if(!empty($_GET['suratketerangan_id'])){
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        margin-left: 50px;
        text-align: justify;
		/*font-style: oblique;*/
		font-weight: bold;
    }
	.allcontent{
		/*font-style: oblique;*/
		font-weight: bold;
	}
	
	table td{
		/*font-style: oblique;*/
		font-weight: bold;
	}
</style>
<table style="width:100%;">
    <tr>
        <td>
            <?php echo $this->renderPartial('application.views.headerReport.headerDefaultSurat'); ?>
        </td>
    </tr>
</table><br><br>
<div class="allcontent">
<TABLE border="1">
<div>
    <div>
        <TABLE width="100%" ALIGN="CENTER" text-align: center;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=6><U><?php echo "SURAT KETERANGAN LAHIR"; ?></U></span></B>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=5>NO.  <?php echo $model->nomorsurat; ?></span></B>
                    
                    <?php
                        echo CHtml::activeHiddenField($model,'suratketerangan_id',array()); 
                    ?>
                </td>
            </tr>
        </TABLE>
    </div>
    </br><br><br><br>
    <p align="justify">
        MENERANGKAN BAHWA DI <?php echo strtoupper($data->nama_rumahsakit);?> TELAH LAHIR SEORANG BAYI <?php echo strtoupper($modPasien->jeniskelamin); ?>,
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:80px;">
            <tr>
                <td width="40%">NAMA</td>
                <td width="3%">:</td>
                <td><?php echo $modPasien->nama_pasien; ?></td>
            </tr>
            <tr>
                <td>PADA,</td>
                <td> &nbsp; </td>
                <td></td>
            </tr>
			<tr>
                <td>HARI</td>
                <td>:</td>
                <td><?php echo strtoupper($format->getDayUser(date("w",  strtotime($model->lahir_tgllahir)))); ?></td>
            </tr>
			<tr>
                <td>TANGGAL</td>
                <td>:</td>
                <td><?php echo strtoupper($format->formatDateTimeForUser(date('Y-m-d' ,strtotime($model->lahir_tgllahir)))); ?></td>
            </tr>
			<tr>
                <td>PUKUL</td>
                <td>:</td>
                <td><?php echo substr($model->lahir_tgllahir, -8,5); ?> WITA</td>
            </tr>
            <tr>
                <td>DENGAN,</td>
                <td> &nbsp; </td>
                <td></td>
            </tr>
            <tr>
                <td>PANJANG BADAN</td>
                <td>:</td>
                <td><?php echo $model->lahir_panjangbadan_cm; ?> CM</td>
            </tr>
            <tr>
                <td>BERAT BADAN</td>
                <td>:</td>
                <td><?php echo $model->lahir_beratbadan_gram; ?> GRAM</td>
            </tr>
            <tr>
                <td>PENOLONG PERSALINAN</td>
                <td>:</td>
                <td><?php echo (isset($model->dokter_persalinan_id))?strtoupper($model->dokterpersalinan->nama_pegawai):'-'; ?></td>
            </tr>
            <tr>
                <td>NAMA IBU</td>
                <td>:</td>
                <td><?php echo strtoupper($model->lahir_namaibu); ?></td>
            </tr>
            <tr>
                <td>NAMA AYAH</td>
                <td>:</td>
                <td><?php echo strtoupper($model->lahir_namaayah); ?></td>
            </tr>
            <tr>
                <td>PEKERJAAN</td>
                <td>:</td>
				<td><?php echo strtoupper($model->lahir_pekerjaan_ayah); ?></td>
            </tr>
            <tr>
                <td>NO. PEKERJA / KTP</td>
                <td>:</td>
                <td><?php echo strtoupper($model->no_pekerja_badge); ?> / <?php echo strtoupper($model->no_ktp_ayah); ?>
				</td>
            </tr>
            <tr>
                <td>ALAMAT</td>
                <td>:</td>
				<td><?php echo strtoupper($model->lahir_alamat); ?></td>
            </tr>
        </table><br>
</div><br><br>
<div style="margin-left: 400px" class="allcontent">
		<?php $date = date('Y-m-d'); ?>
		<?php echo strtoupper($data->kabupaten->kabupaten_nama) ;?>, <?php echo strtoupper($format->formatDateTimeForUser($date)); ?><br>
		<?php echo strtoupper($data->nama_rumahsakit);?>,
		<br><br><br><br><br>
	<?php echo strtoupper($model->mengetahui_surat); ?>
	</div>
</TABLE>
</div>