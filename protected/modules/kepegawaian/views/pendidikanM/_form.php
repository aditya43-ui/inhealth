<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'sapendidikan-m-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'focus'=>'#KPPendidikanM_pendidikan_nama',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'pendidikan_nama',array('placeholder' => 'Pendidikan', 'class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <?php echo $form->textFieldRow($model,'pendidikan_namalainnya',array('placeholder' => 'Nama Lainnya', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>            
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'pendidikan_urutan',array('placeholder' => '00', 'class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<?php //echo $form->checkBoxRow($model,'pendidikan_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','SAPendidikanM_pendidikan_nama')")); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan', 'onKeypress'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        Yii::app()->createUrl($this->module->id.'/pendidikanM/admin'), 
        array('class' => 'btn btn-default',
            'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pendidikan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-success',));
        $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('KPPendidikanM_pendidikan_namalainnya').value = nama.value.toUpperCase();
    }
</script>