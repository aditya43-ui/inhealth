<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfpabrik-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'pabrik_kode'),
)); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'pabrik_kode', array('class' => 'span3', 'maxlength' => 20, 'onkeypress' => "return $(this).focusNextInputField(event);", 'readOnly' => true)); ?>
        <?php //echo $form->dropDownListRow($model, 'jenismodal', LookupM::getItems('jenismodal'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50,'onkeyup' => "return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $form->textFieldRow($model, 'pabrik_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'maxlength' => 100, 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'pabrik_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'maxlength' => 100, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textAreaRow($model, 'pabrik_alamat', array('placeholder' => 'Alamat', 'rows' => 4, 'cols' => 20, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <?php // echo $form->textFieldRow($model,'pabrik_negara',array('class'=>'span3','maxlength'=>50, 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $form->textFieldRow($model, 'pabrik_propinsi', array('placeholder' => 'Provinsi', 'class' => 'span3', 'maxlength' => 100, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'pabrik_kabupaten', array('placeholder' => 'Kabupaten', 'class' => 'span3', 'maxlength' => 100, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <div>
            <?php echo $form->checkBoxRow($model, 'pabrik_aktif'); ?>
        </div>
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
        Yii::t('mds', '{icon} Pengaturan Pabrik', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'master', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAPabrikM_pabrik_namalain').value = nama.value.toUpperCase();
    }
</script>