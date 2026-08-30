<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if(!empty($modPasienPenunjang)){
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Pasien</div>
    </div>
    <div class="panel-body">
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<div class="row-fluid">
		<div class="col-sm-6">
			<?php
				echo CHtml::activeHiddenField($modPasienPenunjang, 'pendaftaran_id');
				echo CHtml::activeHiddenField($modPasienPenunjang, 'pasienmasukpenunjang_id');
				echo CHtml::activeHiddenField($modPasienPenunjang, 'pasien_id');
			?>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPasienPenunjang, 'tgl_pendaftaran',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPasienPenunjang, 'tgl_pendaftaran', array('readonly'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">No. Pendaftaran - Penunjang</label>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPasienPenunjang, 'no_pendaftaran', array('readonly'=>true, 'class'=>'span2')); ?>
					-
					<?php echo CHtml::activeTextField($modPasienPenunjang, 'no_masukpenunjang', array('readonly'=>true, 'class'=>'span2')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPasienPenunjang, 'umur',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPasienPenunjang, 'umur', array('readonly'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPasienPenunjang, 'jeniskasuspenyakit_nama',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPasienPenunjang, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
				</div>
			</div>
			
		</div>
		<div class="col-sm-6">
			<?php 
				if(!empty($modPasienPenunjang->photopasien)){
					echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasienPenunjang->photopasien, 'photo pasien', array('width'=>120));
				} else {
					echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'photo pasien', array('width'=>120));
				}
			?> 
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPasienPenunjang, 'no_rekam_medik',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPasienPenunjang, 'no_rekam_medik', array('readonly'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPasienPenunjang, 'jeniskelamin',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPasienPenunjang, 'jeniskelamin', array('readonly'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPasienPenunjang, 'nama_pasien',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPasienPenunjang, 'nama_pasien', array('readonly'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPasienPenunjang, 'nama_bin',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPasienPenunjang, 'nama_bin', array('readonly'=>true)); ?>
				</div>
			</div>
		</div>
	</div>
    </div>
</div>
<?php
} else {
    Yii::app()->user->setFlash('error',"Data pasien tidak ditemukan");
    $this->widget('bootstrap.widgets.BootAlert');
}

$js = <<< JS
$('#cekRiwayatPasien').change(function(){
        $('#divRiwayatPasien').slideToggle(500);
});
JS;
Yii::app()->clientScript->registerScript('JSriwayatPasien',$js,CClientScript::POS_READY);
?>
