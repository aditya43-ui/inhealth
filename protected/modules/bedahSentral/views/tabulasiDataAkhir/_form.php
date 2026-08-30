<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'dataakhiranastesi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class="col-sm-4">
        <?php echo $form->textFieldRow($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'pasienmasukpenunjang_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'rencanaoperasi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'jumlah_urine', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'jumlah_perdarahan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'jumlah_cairanim', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'lama_anastesi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'lama_pembedahan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textAreaRow($model, 'catatan_akhiranastesi', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'create_time', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'update_time', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'create_loginpemakai_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'update_loginpemakai_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'create_ruangan', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-4">

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
        Yii::t('mds', '{icon} Pengaturan DataakhiranastesiT', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>