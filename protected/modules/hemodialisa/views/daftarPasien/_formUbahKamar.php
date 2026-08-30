<fieldset class="box">
	<?php 
	if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success', "Data kamar ruangan pasien berhasil disimpan !");
    }
    $this->widget('bootstrap.widgets.BootAlert');
	?>
    <legend class="rim">Data Pasien</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id',array('class'=>'control-label')); ?>
            </td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?></td>
            <td rowspan="4">
                <?php 
                    if(!empty($modPasien->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'photo pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'photo pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly'=>true)); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->dokter, 'nama_pegawai', array('readonly'=>true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('readonly'=>true)); ?></td>
        </tr>        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

            <td><?php echo CHtml::activeLabel($modPasien, 'alamat_pasien', array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'alamat_pasien', array('readonly'=>true)); ?></td>
        </tr>        
    </table>
</fieldset>

<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjpasienadmisi-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);','onsubmit'=>'return requiredCheck(this);'),
)); 
?>
<div class="block-tabel">
    <h6>Ubah <b>Kamar Ruangan</b></h6>
    <div class="row-fluid">
		<div class='control-group'>
			<?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($modPendaftaran,'ruangan_id'),array('class'=>'control-label required'))?>                                   
			<div class='controls'>
				<?php echo $form->dropDownList($modPendaftaran,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_id='.$modPendaftaran->ruangan_id), 'ruangan_id', 'ruangan_nama') ,
									  array('empty'=>'-- Pilih --','disabled'=>true)); ?>  
			</div>
		</div> 
		<?php echo $form->dropDownListRow($modPendaftaran,'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_id='.$modPendaftaran->kelaspelayanan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3','disabled'=>true)); ?>
		<div class="control-group">
			<?php echo CHtml::label("Kamar Lama","",array('class'=>'control-label'))?>
			<div class='controls'>
				<?php echo $form->dropDownList($modPendaftaran,'kamarruangan_id', !empty($modPendaftaran->ruangan_id) ? CHtml::listData(KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$modPendaftaran->ruangan_id,'kamarruangan_status'=>true)),'kamarruangan_id','KamarDanTempatTidur') : array() ,
								array('empty'=>'-- Pilih --',
									'onkeypress'=>"return $(this).focusNextInputField(event)",
									'class'=>'',
									'disabled'=>true
								  )); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label("Kamar Baru","",array('class'=>'control-label'))?>
			<div class='controls'>
				<?php echo $form->dropDownList($modPendaftaran,'kamarruangan_id', !empty($modPendaftaran->ruangan_id) ? CHtml::listData(KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$modPendaftaran->ruangan_id,'kamarruangan_status'=>true)),'kamarruangan_id','KamarDanTempatTidur') : array() ,
								array('onkeypress'=>"return $(this).focusNextInputField(event)",
									'class'=>'',
								  )); ?>
			</div>
		</div>
    </div>
</div>
<div class="form-actions">
	<?php
	if(isset($_GET['sukses'])){
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)','disabled'=>true));
    }else{
		echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
	}
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			array('class'=>'btn btn-danger', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
	function closeDialog(){
		window.parent.$('#dialogKamarRuangan').dialog('close');
	}
</script>