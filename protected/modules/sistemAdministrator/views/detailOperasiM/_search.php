<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'bsdetail-operasi-m-search',
    'type' => 'horizontal',
)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownlistRow($model, 'operasi_id',  CHtml::listData(OperasiM::model()->getAllItems(), 'operasi_id', 'operasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'style' => 'width:160px', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->checkBoxRow($model, 'detailoperasi_aktif', array('checked' => 'checked')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'detailoperasi_nama', array('placeholder' => 'Nama Detail', 'class' => 'span3', 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'detailoperasi_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'maxlength' => 100)); ?>
    </div>
</div>

<table style="width: 100%; border: none;">
    <tr>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td colspan="3">
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'detailoperasi_id',array('class'=>'span5')); 
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