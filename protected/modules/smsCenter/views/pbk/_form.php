<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pbk-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block">
<?php
// echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
?>
</p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-12">
        <?php echo $form->dropDownListRow($model, 'GroupID', CHtml::listData(PbkGroups::model()->findAll(), 'ID', 'Name'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'Name', array('placeholder' => 'Nama', 'rows' => 3, 'cols' => 50, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'Number', array('placeholder' => 'Nomor', 'rows' => 3, 'cols' => 50, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
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
        Yii::t('mds', '{icon} Pengaturan Phone Book', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>