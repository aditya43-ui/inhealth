<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sadiagnosa-m-search',
    'type' => 'horizontal',
)); ?>

<?php //echo $form->textFieldRow($model,'diagnosa_id',array('class'=>'span5')); 
?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'diagnosa_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'diagnosa_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php //echo $form->checkBoxRow($model,'diagnosa_aktif',array('checked'=>true)); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'diagnosa_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'diagnosa_aktif', array('checked' => 'diagnosa_aktif')); ?> <label for="SADiagnosaM_diagnosa_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'diagnosa_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'diagnosa_katakunci', array('placeholder' => 'Kata Kunci', 'class' => 'span3', 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php //echo $form->checkBoxRow($model,'diagnosa_imunisasi'); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'diagnosa_imunisasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'diagnosa_imunisasi', array('checked' => 'diagnosa_imunisasi')); ?> <label for="SADiagnosaM_diagnosa_imunisasi">Imunisasi</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>