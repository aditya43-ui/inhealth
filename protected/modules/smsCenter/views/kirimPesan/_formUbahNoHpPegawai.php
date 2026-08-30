<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'ubahKelPenyakit-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    )
);
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)); ?>

<div class="control-group">
    <?php echo CHtml::label('Nama Pegawai', 'ap', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model, 'nama_pegawai', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="control-group">
    <?php echo CHtml::label('No Hp Pegawai', 'k', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model, 'nomobile_pegawai', array('readonly' => false, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onClick' => 'closeDialog();')
    );
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function closeDialog() {
        window.parent.$('#editNomor').dialog('close');
    }
</script>