<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/datetime.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/fileinput.js'); ?>
<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'hasilIndikator-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    )
);
?>
<p class="help-block">
    <?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Hasil Indikator
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label('', 'sterilisasi_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'sterilisasi_id', array('class' => 'span3')); ?>
            </div>
        </div>
        <?php echo $form->radioButtonListInlineRow($model, 'indikator_hslkimia_1', array('Lolos' => 'Lolos', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>


        <?php echo $form->radioButtonListInlineRow($model, 'indikator_hslkimia_4', array('Lolos' => 'Lolos', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>


        <?php echo $form->radioButtonListInlineRow($model, 'indikator_hslkimia_5', array('Lolos' => 'Lolos', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>


        <?php echo $form->radioButtonListInlineRow($model, 'batch_monitoring', array('Lolos' => 'Lolos', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>

        <?php echo $form->radioButtonListInlineRow($model, 'bowie_dick', array('Lolos' => 'Lolos', 'Tidak' => 'Tidak'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>



        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            ?>
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array('class' => 'btn btn-default', 'type' => 'button', 'onClick' => 'closeDialog();')
            );
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPendaftaran() {
        var sterilisasi_id = $('#temp_dialogIndikator').val();
        $('#STHasilindikatorT_sterilisasi_id').val(sterilisasi_id);

    }
    loadDataPendaftaran();

    function closeDialog() {
        window.parent.$('#dialogIndikator').dialog('close');
    }
</script>