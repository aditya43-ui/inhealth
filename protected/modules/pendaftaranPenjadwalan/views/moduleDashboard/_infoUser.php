<?php $format = new MyFormatter();?>
<form class="form-horizontal">
<div class="row">
	<div class="span9">
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPemakai,'nama_pemakai', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo $modPemakai->nama_pemakai; ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPegawai,'nama_pegawai', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo $modPegawai->gelardepan." ".$modPegawai->nama_pegawai.(isset($modPegawai->gelarbelakang_id) ? ", ".$modPegawai->gelarbelakang->gelarbelakang_nama : ""); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPegawai,'nomorindukpegawai', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo $modPegawai->nomorindukpegawai; ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPegawai,'jeniskelamin', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo ucfirst(strtolower($modPegawai->jeniskelamin)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPegawai,'tgl_lahirpegawai', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo isset($modPegawai->tgl_lahirpegawai) ? $format->formatDateTimeId($modPegawai->tgl_lahirpegawai) : "-"; ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label("Ruangan","ruangan", array('class'=>'control-label')); ?>
			<div class="controls">
				<ul>
					<?php
                                            if(count((array)$modRuanganPegawai) > 0){
						foreach($modRuanganPegawai AS $i => $ruangan) {
							echo "<li>".$ruangan->ruangan->ruangan_nama."</li>";
						}
                                            }else{
                                                echo "<li>Belum memiliki ruangan</li>";
                                            }
					?>
				</ul>
				
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPegawai,'alamatemail', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo isset($modPegawai->alamatemail) ? $format->formatDateTimeId($modPegawai->tgl_lahirpegawai) : "-"; ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPegawai,'notelp_pegawai', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo ucfirst(strtolower($modPegawai->notelp_pegawai)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPemakai,'tglpembuatanlogin', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo $modPemakai->tglpembuatanlogin; ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPemakai,'tglupdatelogin', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo $modPemakai->tglupdatelogin; ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPemakai,'lastlogin', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo $modPemakai->lastlogin; ?>
			</div>
		</div>
<!--		<div class="control-group">
			<?php echo CHtml::activeLabel($modPemakai,'statuslogin', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo ($modPemakai->statuslogin == true) ? "Logged in" : "Logged Out"; ?>
			</div>
		</div>-->
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPemakai,'ruanganaktifitas', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo RuanganM::model()->findByPk($modPemakai->ruanganaktifitas)->ruangan_nama; ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::activeLabel($modPemakai,'crudaktifitas', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo $modPemakai->crudaktifitas; ?>
			</div>
		</div>
	</div>
	<div class="span3">

		<div class="control-group">
		<?php 
		// $path_foto = "data/images/pasien/no_photo.jpeg";
		// if(isset($modPegawai->photopegawai)){
		// 	$path_foto = Params::pathPegawaiDirectory().$modPegawai->photopegawai;
		// }else if(isset($modPemakai->photouser)){
		// 	$path_foto = "data/images/".$modPemakai->photouser;
		// }
		 ?>
		<?php //echo CHtml::image($path_foto,"Foto Pegawai", array('class'=>'span3')) ?>

		<?php echo Chtml::activeHiddenField($modPegawai,'photopegawai',array('readonly'=>true,'class'=>'span3 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <div style="text-align: center;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ambil Foto',array('{icon}'=>'<i class="entypo-camera"></i>')), 
                        array('class'=>'btn btn-primary','onclick'=>"$('#dialog-addphoto').dialog('open');",
                              'id'=>'btn-addphoto','onkeyup'=>"return $(this).focusNextInputField(event)",
                              'rel'=>'tooltip','title'=>'Klik untuk Ambil Foto')) ?>
            <br>
            <?php 
            $url_photopegawai = (!empty($modPegawai->photopegawai) ? Params::urlPegawaiTumbsDirectory()."kecil_".$modPegawai->photopegawai : Params::urlPegawaiDirectory()."no_photo.jpeg");
            ?>
            <img id="photo-preview" src="<?php echo $url_photopegawai?>"width="84px"/> 
        </div>
		</div>
	</div>
	<div class="span12">
		

	<!--</div>
	<div class="col-sm-6">-->
		
<!--		<div class="control-group">
			<?php echo CHtml::activeLabel($modPegawai,'kelompokjabatan', array('class'=>'control-label	')); ?>
			<div class="controls">
				<?php echo isset($modPegawai->kelompokjabatan) ? $modPegawai->kelompokjabatan : "-"; ?>
			</div>
		</div>-->
		
	</div>
</div>
<!--Tombol action-->
<!--<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')), array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'return false;')); ?>
</div>-->
</form>	
                            
<?php
//================= dialog webcam =====================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-addphoto',
    'options'=>array(
        'title'=>'Ambil Foto',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>360,
        'minHeight'=>420,
        'resizable'=>false,
    ),
));
?>

<div id="dialog-content" style="text-align: center;">
    <div id="cam-preview"></div>
    <br>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-cog icon-white"></i>')),array('rel'=>'tooltip','title'=>'Konfigurasi Kamera','class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'webcam.configure();','style'=>'font-size:10px; width:32px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ambil',array('{icon}'=>'<i class="entypo-camera"></i>')),array('id'=>'btn_ambil_gambar','class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'ambilGambar();','style'=>'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-download-alt icon-white"></i>')),array('id'=>'btn_simpan_gambar','disabled'=>true,'class'=>'btn btn-mini btn-primary', 'type'=>'button', 'onclick'=>'simpanGambar();','style'=>'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('id'=>'btn_ulang_gambar','class'=>'btn btn-mini btn-danger', 'type'=>'button', 'onclick'=>'ulangGambar();','style'=>'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>
