<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'sopdetail-m-search',
    'type' => 'horizontal',
));
?>

<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo CHtml::label("SOP", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropdownList($model, 'sop_id', CHtml::listData(SopM::model()->findAll('sop_aktif = true order by sop_aktif ASC'), 'sop_id', 'sop_nama'), array('empty' => '-- Pilih --', 'onkeypress' => 'return $(this).focusNextInputField(event)', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Kelompok Prosedur", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'sopdetail_kelompok', array('placeholder' => 'Kelompok Prosedur', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'sopdetail_aktif', array('checked' => 'sopdetail_aktif')) ?>
                <label for="">Aktif </label>
            </div>
        </div>
        
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
    ); ?>
</div>

<?php $this->endWidget(); ?>