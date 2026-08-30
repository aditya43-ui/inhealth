<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pilihpendaftaran-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); 

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');

?>

<?php echo $form->errorSummary($modKirimKeUnitLain); ?>

<div class="row" style="margin-top: 30px;">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Pendaftaran','pendaftaran_id',array('class'=>'control-label')); ////$form->labelEx($model,'nama_pegawai',array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php
                    $status = 'SUDAH PULANG';
                    $pendaftaran = LBPendaftaranT::model()->findAll("pasien_id = '" . $_GET['pasien_id'] . "' AND statusperiksa != '" . $status . "' AND pasienbatalperiksa_id IS NULL ORDER BY pendaftaran_id DESC");
                    echo $form->dropDownList($modKirimKeUnitLain, 'pendaftaran_id', CHtml::listData($pendaftaran, 'pendaftaran_id', 'ruanganTanggalStatus'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onchange' => ''));
                ?>
            </div>
        </div>
    </div>
</div>
<div class='form-actions' style='float:right'>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array(
            'class' => 'btn btn-danger', 'type' => 'submit',
            'onKeypress' => 'return formSubmit(this,event)',
            'id' => 'btn_simpan',
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>