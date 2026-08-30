<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'observasiruangpulih-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php // echo $form->hiddenField($model,'rencanaoperasi_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>

<div class="col-sm-6">
    <?php echo $form->textFieldRow($model, 'pemeriksaanke', array('class' => 'span2 numbers-only', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'observasijam', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'observasijam',
                'mode' => 'time',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onclick' => "return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'detaknadi', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'detaknadi', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label>x/menit</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'pernapasan', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'pernapasan', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label>x/menit</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'suhubadan', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'suhubadan', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label>&deg;C</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'td_systolic', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'td_systolic', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label>/</label>
            <?php echo $form->textField($model, 'td_dyastolic', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>

</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo $form->label($model, 'spo2_nilai', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'spo2_nilai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label>%</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'o2_nilai', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'o2_nilai', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label>L/menit</label>
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'skalanyeri', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo $form->label($model, 'mualmuntah_status', array('class' => 'control-label')); ?>
        <div class="controls radio_field">
            <?php echo $form->radioButtonList($model, 'mualmuntah_status', array('-' => '-', '+' => '+'), array('class' => 'mualmuntah_status radio_ceklis', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textField($model, 'mualmuntah_ket', array('class' => 'span3 mualmuntah_ket radio_input', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

        </div>
    </div>
    <div class="control-group">
        <?php echo $form->label($model, 'perdarahan_status', array('class' => 'control-label')); ?>
        <div class="controls radio_field">
            <?php echo $form->radioButtonList($model, 'perdarahan_status', array('-' => '-', '+' => '+'), array('class' => 'mualmuntah_status radio_ceklis', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textField($model, 'perdarahan_ket', array('class' => 'span3 mualmuntah_ket radio_input', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

        </div>
    </div>

</div>
<div class="clear"></div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan ObservasiruangpulihT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-bar"></i> Grafik Observasi Ruang Pulih
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_grafik', array(
            'base_model' => $model,
        ), true); ?>

    </div>
</div>


<script>
    function cekRadioInput() {
        $(".radio_field").each(function() {
            var nilai = $(this).find(".radio_ceklis:checked").val();

            if (nilai == "+") {
                $(this).find(".radio_input").prop("readonly", false);
            } else {
                $(this).find(".radio_input").prop("readonly", true).val("");

            }
        });
    }

    $(document).ready(function() {
        $(".radio_ceklis").on("click", cekRadioInput);
        cekRadioInput();
    });
</script>