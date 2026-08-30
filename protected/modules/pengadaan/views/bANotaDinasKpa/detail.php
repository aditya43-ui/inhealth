<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'notadinas-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><span class='judul'>Nota Dinas KPA</span></div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'notadinaskpa_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'nomor_notadinas', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor Nota Dinas')); ?>
                <?php echo $form->dropDownListRow($model, 'notadinaskpa_kepada', LookupM::getItems('tujuannotadinaskpa'), array('empty' => '-- Pilih --', 'class' => 'span4',));
                ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'notadinaskpa_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'notadinaskpa_tanggal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                        ));
                        ?>
                        <?php echo $form->error($model, 'notadinaskpa_tanggal'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'termin_ke', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'termin_ke', array('class' => 'span1', 'readonly' => true)); ?>
                    </div>
                    <label class="control-label" style="width: 35px !important">Dari</label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'total_termin', array('class' => 'span1', 'readonly' => true)); ?>
                    </div>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'terminke', array('class' => 'span1', 'readonly' => true)); ?>
                        <?php echo $form->hiddenField($model, 'termin_persen', array('class' => 'span1', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'pegkpa_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'pegkpa_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<script>

    $(document).ready(function () {
            $('input').attr('disabled', true);
            $('select').attr('disabled', true);
            $('.add-on').hide();
    });
</script>