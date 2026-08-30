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
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

<?php if($model->pasienadmisi_id > 0) {
    echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
} else{
    null;
}
?>
<?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php // echo $form->hiddenField($model,'rencanaoperasi_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>

<div class="col-sm-6">
    <br>
    <div class="panel panel-dark">
        <span class="group-title">
            Keterangan Waktu Operasi
        </span>
        <div class="panel-body">
            <?php echo $form->textFieldRow($status, 'jam_mulaianestesi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($status, 'jam_selesaianestesi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'lama_anastesi', array('readonly' => false, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($status, 'jam_mulaitindakanbedah', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($status, 'jam_selesaitindakanbedah', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            <?php echo $form->textFieldRow($model, 'lama_pembedahan', array('readonly' => false, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

        </div>
    </div>


</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($model, 'jumlah_urine', array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'jumlah_perdarahan', array(
            'class' => 'control-label'
        )); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'jumlah_perdarahan', array('class' => 'span2 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <label>cc</label>
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'jumlah_cairanim', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textAreaRow($model, 'catatan_akhiranastesi', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

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
    <?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan DataakhiranastesiT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>