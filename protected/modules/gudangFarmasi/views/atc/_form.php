<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfatc-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'atc_kode', array('placeholder' => 'Kode ATC', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        <?php echo $form->textFieldRow($model, 'atc_nama', array('placeholder' => 'Nama ATC', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'atc_namalain', array('placeholder' => 'Nama Lain ATC', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event); ", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'atc_singkatan', array('placeholder' => 'Singkatan ATC', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'atc_ddd', array('placeholder' => 'Ddd ATC', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($model, 'atc_units', LookupM::getItems('unitatc'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($model, 'atc_admr', LookupM::getItems('routeofadmatc'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'atc_note', array('placeholder' => 'Keterangan Atc', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->checkBoxRow($model, 'atc_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
        Yii::t('mds', '{icon} Pengaturan Atc', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('GFAtcM_atc_namalain').value = nama.value.toUpperCase();
    }
</script>