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
        text-indent: 50px;
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
<div class="allcontent">
<TABLE border="1">
<div>
    <div>
        <TABLE width="100%" ALIGN="CENTER" style="margin-left:100px; text-align: center;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=6><U><?php echo "SURAT KETERANGAN LAHIR"; ?></U></span></B>
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
        MENERANGKAN BAHWA DI <?php echo strtoupper($data->nama_rumahsakit);?> TELAH LAHIR SEORANG BAYI <?php echo strtoupper($modPasien->jeniskelamin); ?>,
    </p>
    <p align="justify">
        <table width="100%" style="width:500px;margin-left:80px;">
            <tr>
                <td>NAMA</td>
                <td>:</td>
                <td><?php echo CHtml::textField('nama_pasien',$modPasien->nama_pasien, array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>PADA,</td>
                <td></td>
                <td></td>
            </tr>
			<tr>
                <td>TANGGAL</td>
                <td>:</td>
                <td>
					<?php 
                            $model->lahir_tgllahir = (!empty($model->lahir_tgllahir) ? $format->formatDateTimeForUser($model->lahir_tgllahir) : $format->formatDateTimeForUser(date('Y-m-d H:i:s')));
                            $this->widget('MyDateTimePicker', array(
                                'model'=>$model,
                                'attribute'=>'lahir_tgllahir',
                                'name'=>'lahir_tgllahir',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
					?>
				</td>
            </tr>
            <tr>
                <td>DENGAN,</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>PANJANG BADAN</td>
                <td>:</td>
                <td><?php echo CHtml::activeTextField($model, 'lahir_panjangbadan_cm', array('readonly'=>false,
														'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 numbersOnly','placeholder'=>'Cm', 'maxlength'=>2, 'style'=>'text-align: right;')); ?> CM</td>
            </tr>
            <tr>
                <td>BERAT BADAN</td>
                <td>:</td>
                <td><?php echo CHtml::activeTextField($model, 'lahir_beratbadan_gram', array('readonly'=>false,
														'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span1 numbersOnly','placeholder'=>'Gr', 'maxlength'=>4, 'style'=>'text-align: right;')); ?> GRAM</td>
            </tr>
            <tr>
                <td>PENOLONG PERSALINAN</td>
                <td>:</td>
                <td>
					<?php
                                            $penolong = new CDbCriteria();
                                            $penolong->addCondition("pegawai_aktif = TRUE");
                                            $penolong->addInCondition('ruangan_id',array(Params::RUANGAN_ID_BERSALIN, Params::RUANGAN_ID_KEBIDANAN));
                                            $penolong->addInCondition('kelompokpegawai_id',array(Params::KELOMPOKPEGAWAI_ID_BIDAN, Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK));
                                            $penolong->order="nama_pegawai ASC";
						echo CHtml::activeDropDownList($model,'dokter_persalinan_id', CHtml::listData(PegawairuanganV::model()->findAll($penolong), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
					?>
				</td>
            </tr>
            <tr>
                <td>NAMA IBU</td>
                <td>:</td>
                <td><?php echo CHtml::activeTextField($model, 'lahir_namaibu', array('readonly'=>false,
														'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>NAMA AYAH</td>
                <td>:</td>
                <td><?php echo CHtml::activeTextField($model, 'lahir_namaayah', array('readonly'=>false,
														'onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
            </tr>
            <tr>
                <td>PEKERJAAN</td>
                <td>:</td>
                <td><?php echo CHtml::activeTextField($model, 'lahir_pekerjaan_ayah', array('readonly'=>false,
														'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Pekerjaan Ayah')); ?></td>
            </tr>
            <tr>
                <td>NO. PEKERJA / KTP</td>
                <td>:</td>
                <td>
					<?php echo CHtml::activeTextField($model, 'no_pekerja_badge', array('readonly'=>false,
														'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','placeholder'=>'NIP')); ?> / 
					<?php echo CHtml::activeTextField($model, 'no_ktp_ayah', array('readonly'=>false,
														'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','placeholder'=>'No. KTP')); ?>
				</td>
            </tr>
            <tr>
                <td>ALAMAT</td>
                <td>:</td>
                <td><?php echo CHtml::activeTextArea($model, 'lahir_alamat', array('readonly'=>false,
														'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alamat Orangtua',)); ?></td>
            </tr>
        </table><br>
</div><br><br>
<div style="margin-left: 400px" class="allcontent">
		<?php $date = date('Y-m-d'); ?>
		<?php echo strtoupper($data->kecamatan->kecamatan_nama) ;?>, <?php echo strtoupper($format->formatDateTimeForUser($date)); ?><br>
		<?php echo strtoupper($data->nama_rumahsakit);?>,
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
</div>