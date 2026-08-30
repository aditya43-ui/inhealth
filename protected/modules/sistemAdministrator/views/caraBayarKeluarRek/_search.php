<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sarekeningcolumn-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-4">
        <div class='control-group'>
            <?php echo CHtml::label('Jenis Penjamin Keluar', 'carabayarkeluar', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'carabayarkeluar', array('placeholder' => 'Jenis Penjamin Keluar', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Rekening', 'rekening', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'rekening', array('placeholder' => 'Rekening', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo CHtml::label('Debit / Kredit', 'debkre', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'debkre', array("D" => "Debit", "K" => "Kredit"), array('class' => 'span3', 'prompt' => '-- Pilih --')); ?>
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