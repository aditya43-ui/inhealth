<?php 
$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$kodeicd = '';
if(!empty($_GET['pendaftaran_id'])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
	$modPasien->tanggal_lahir = $format->formatDateTimeForUser($modPasien->tanggal_lahir);
    if(!empty($modPendaftaran->pasienadmisi_id)){
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        $model->mengetahui_surat = (isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pegawai->nama_pegawai : "");
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

if(!empty($_GET['suratketerangan_id'])){
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 50px;
        text-align: justify;
    }
</style>
<TABLE border="1">
<div>
    <div>
        <TABLE ALIGN="CENTER" style="margin-left:100px; text-align: center;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN MENINGGAL"; ?></U></span></B>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4>NO : <?php echo CHtml::activeTextField($model,'nomorsurat', array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></span></B>
                    
                    <?php
                        echo CHtml::activeHiddenField($model,'suratketerangan_id',array()); 
                    ?>
                </td>
            </tr>
        </TABLE>
    </div>
    </br><br><br><br>
    <p align="justify">
        Yang bertanda tangan dibawah ini Dokter <?php echo $data->nama_rumahsakit;?> menerangkan bahwa,
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:80px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
			<tr>
                <td>No. Rekam Medis</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->no_rekam_medik, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
			<tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->jeniskelamin, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->tanggal_lahir, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Umur</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPendaftaran->umur, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->agama, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Kewarganegaraan</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->warga_negara, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
				<?php if(!empty($_GET['pendaftaran_id'])){ ?>
					<td><?php echo CHtml::textField('nama_pasien',$modPasien->pekerjaan->pekerjaan_nama, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
				<?php }else{ ?>
					<td><?php echo CHtml::textField('nama_pasien','', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
				<?php } ?>
                
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->alamat_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
        </table><br>
        <p align="justify">
            Telah meninggal dunia di <?php echo $data->nama_rumahsakit;?> pada,
            <table width="100%" style="width:500px;margin-left:80px;">
<!--<tr>
                <td>Tanggal Masuk</td>
                <td>:</td>
                <td>-->
                    <?php 
//                        $modAdmisi->tgladmisi = (!empty($modAdmisi->tgladmisi) ? $format->formatDateTimeForUser($modAdmisi->tgladmisi) : '');
//                        $this->widget('MyDateTimePicker', array(
//                            'model'=> $modAdmisi,
//                            'attribute'=>'tgladmisi',
//                            'mode' => 'datetime',
//                            'options' => array(
//                                'dateFormat' => Params::DATE_FORMAT,
////                                'maxDate' => 'd',
//                            ),
//                            'htmlOptions' => array('readonly' => true,
//                                'onkeypress' => "return $(this).focusNextInputField(event)"),
//                        ));
                    ?>
<!--</td>
            </tr>-->
            <?php if(!empty($_GET['pendaftaran_id'])){
                    if(!empty($modAdmisi->tglpulang)){
            ?>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>
                         <?php 
                            $modAdmisi->tglpulang = (!empty($modAdmisi->tglpulang) ? $format->formatDateTimeForUser($modAdmisi->tglpulang) : '');
                            $this->widget('MyDateTimePicker', array(
                                'model'=>$modAdmisi,
                                'attribute'=>'tglpulang',
                                'name'=>'tglpulang',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
//                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                        ?>
                    </td>
                </tr>
               
            <?php }else{ echo ""; }}else{ ?>
               <tr>
                    <td>Tanggal Meninggal</td>
                    <td>:</td>
                    <td>
                         <?php 
                            $modAdmisi->tglpulang = (!empty($modAdmisi->tglpulang) ? $format->formatDateTimeForUser($modAdmisi->tglpulang) : '');
                            $this->widget('MyDateTimePicker', array(
                                'model'=>$modAdmisi,
                                'attribute'=>'tglpulang',
                                'name'=>'tglpulang',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
//                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                        ?>
                    </td>
                </tr> 
           <?php } ?>
			<tr>
				<td>Penyebab Kematian</td>
				<td>:</td>
				<td><?php echo CHtml::textArea('penyebabkematian',$model->penyebabkematian, array('readonly' => false,
                                    'onkeypress' => "return $(this).focusNextInputField(event)"));?></td>
			</tr>
			<tr>
				<td>Kode ICD</td>
				<td>:</td>
				
				<td><?php echo CHtml::textField('kodeicd',$kodeicd, array('readonly'=>true,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
			</tr>
        </table><br>
        </p>
        <p align="justify">
           Demikianlah surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.
        </p>
</div><br><br>
	<div style="margin-left: 400px">
		<?php $date = date('Y-m-d'); ?>
		<?php echo $data->kecamatan->kecamatan_nama ;?>, <?php echo $format->formatDateTimeForUser($date); ?><br>
		Dokter Pemeriksa, 
		<br><br><br><br><br>
	<!--(_________________)-->
	<?php
		echo CHtml::activeDropDownList($model,'mengetahui_surat', CHtml::listData(DokterV::model()->findAll(array(
                    'condition'=>'pegawai_aktif = true AND kelompokpegawai_id = '.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                    'order'=>'nama_pegawai',
                )), 'namaLengkap', 'namaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
	?>
	</div>
</TABLE>
