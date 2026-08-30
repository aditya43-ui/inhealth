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
    <div class="col-sm-12">
    <div class="control-group">
    <?php echo CHtml::label("Tanggal Kirim Permintaan", 'tgl_kirimpasien', array('class'=>'control-label required')); ?>
            <div class="controls">
                <?php
                         $this->widget('MyDateTimePicker', array(
                                 'model' => $modKirimKeUnitLain,
                                 'attribute' => 'tgl_kirimpasien',
                                 'value'=>null,
                                 'mode' => 'datetime',
                                 'options' => array(
                                         'dateFormat' => Params::DATE_FORMAT,
                                        //  'maxDate' => 'd',
                                 ),
                                 'htmlOptions' => array(
                                         'readonly' => true,
                                         'onkeypress' => "return $(this).focusNextInputField(event)",
                                         'class'=>'span3 htpd',
                                 ),
                         ));
                     ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modKirimKeUnitLain,'tglrencanapemeriksaan',array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                         $this->widget('MyDateTimePicker', array(
                                 'model' => $modKirimKeUnitLain,
                                 'attribute' => 'tglrencanapemeriksaan',
                                 'value'=>null,
                                 'mode' => 'datetime',
                                 'options' => array(
                                         'dateFormat' => Params::DATE_FORMAT,
                                        //  'maxDate' => 'd',
                                 ),
                                 'htmlOptions' => array(
                                         'readonly' => true,
                                         'onkeypress' => "return $(this).focusNextInputField(event)",
                                         'class'=>'span3 htpd',
                                 ),
                         ));
                     ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Pemeriksaan', 'jenispemeriksaanlab_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPermintaan, 'jenispemeriksaanlab_nama', array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pemeriksaan', 'pemeriksaanrad_nama', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modPermintaan, 'pemeriksaanlab_id',array('class'=>'control-label')); ?>
                <?php echo CHtml::activeTextField($modPermintaan, 'pemeriksaanlab_nama', array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group hide">
            <div class="controls" style="margin-left: 140px; margin-top: 10px;">
                <?php echo $form->checkBox($modKirimKeUnitLain, 'is_elektif', array('id'=>'is_elektif')); ?>
                <label for="is_elektif">Pemeriksaan Elektif</label>
            </div>
        </div>
    </div>
</div>

<div class='form-actions' style='float:left'>
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