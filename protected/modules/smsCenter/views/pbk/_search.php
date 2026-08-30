<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pbk-search',
    'type' => 'horizontal',
)); ?>

<?php // echo $form->textFieldRow($model,'ID',array('class'=>'span3 numbers-only')); 
?>
<?php echo $form->dropDownListRow(
    $model,
    'GroupID',
    CHtml::listData(PbkGroups::model()->findAll(), 'ID', 'Name'),
    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")
); ?>

<?php // echo $form->textFieldRow($model,'GroupID',array('class'=>'span3 numbers-only')); 
?>

<?php echo $form->textAreaRow($model, 'Name', array('placeholder' => 'Nama', 'rows' => 2, 'cols' => 50, 'class' => 'span8')); ?>

<?php echo $form->textAreaRow($model, 'Number', array('placeholder' => 'Nomor', 'rows' => 2, 'cols' => 50, 'class' => 'span8')); ?>

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