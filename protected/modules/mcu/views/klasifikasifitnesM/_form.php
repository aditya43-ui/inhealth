<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'mcklasifikasifitnes-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#MCKlasifikasifitnesM_age_elev',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'age_elev', array('placeholder' => 'Age Elev', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'lama_menit', array('placeholder' => 'Duration (min)', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'workload_kph', array('placeholder' => 'Work Load (Kph)', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'estimasirate', array('placeholder' => 'Estimate 02 1/min', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'max_intake', array('placeholder' => 'Max 02 Intake ml/kg/min', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'umur_min', array('placeholder' => 'Umur Minimal', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'umur_maks', array('placeholder' => 'Umur Maksimal', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'mets', array('placeholder' => 'Mets', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'klasifikasifitnes', array('placeholder' => 'Klasifikasi Fitnes', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'functional_class', array('placeholder' => 'Functional Class', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
        <?php echo $form->dropDownListRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --', 'class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'walking_kmhr', array('placeholder' => 'Walking KM/Hr', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'jogging_kmhr', array('placeholder' => 'Jogging KM/Hr', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'bicycling_kmhr', array('placeholder' => 'Bicycling KM/Hr', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textAreaRow($model, 'other_sports', array('placeholder' => 'Other Sports', 'rows' => 4, 'cols' => 50, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Klasifikasi Fitnes', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/add', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>