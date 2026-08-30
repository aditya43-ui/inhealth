<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'papanantrianserialruangan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="col-sm-6">
    <?php echo $form->dropDownListRow(
        $model,
        'ruangan_id',
        CHtml::listData(SARuanganM::model()->findAll(array(
            'join' => 'join instalasi_m i on i.instalasi_id = t.instalasi_id',
            'order' => 'i.instalasi_nama, t.ruangan_nama',
            'condition' => 't.ruangan_aktif = true and i.revenuecenter = true'
        )), 'ruangan_id', 'ruanganInstalasi'),
        array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
    ); ?>
    <?php echo $form->textFieldRow($model, 'ip_address', array('placeholder' => 'IP Address', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->textFieldRow($model, 'ip_port', array('placeholder' => 'IP Port', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>

</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($model, 'serial_port', array('placeholder' => 'Serial Port', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->textFieldRow($model, 'serial_id', array('placeholder' => 'Serial Port', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->textFieldRow($model, 'poliklinik_nama', array('placeholder' => 'Poliklinik', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
</div>

<div class="clear"></div>

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
        Yii::t('mds', '{icon} Pengaturan LED Display Antrian', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>
<?php $this->endWidget(); ?>