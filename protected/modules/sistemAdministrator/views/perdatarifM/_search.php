<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'saperda-tarif-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'perdanama_sk', array('placeholder' => 'SK Tarif', 'class' => 'span3', 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'noperda', array('placeholder' => 'No. SK Tarif', 'class' => 'span3', 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'tglperda', array('placeholder' => 'Tanggal SK Tarif', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'ditetapkanoleh', array('placeholder' => 'Ditetapkan Oleh', 'class' => 'span3', 'maxlength' => 30)); ?>
        <?php echo $form->textFieldRow($model, 'tempatditetapkan', array('placeholder' => 'Tempat Ditetapkan', 'class' => 'span3', 'maxlength' => 30)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'perdatentang', array('placeholder' => 'SK Tarif Tentang', 'rows' => 6, 'cols' => 30, 'class' => 'span4')); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'perda_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'perda_aktif', array('checked' => 'checked')); ?> <label for="SAPerdaTarifM_perda_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<?php //echo $form->textFieldRow($model,'perdatarif_id',array('class'=>'span5'));  
?>

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