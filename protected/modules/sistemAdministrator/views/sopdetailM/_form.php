<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sopdetail-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'sop_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo Chtml::activeDropDownList($model, 'sop_id', CHtml::listData(SopM::model()->findAll('sop_aktif = true order by sop_aktif ASC'), 'sop_id', 'sop_nama'), array('empty' => '-- Pilih --', 'class'=>'span3')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'sopdetail_kelompok', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'sopdetail_nama', array('class' => 'control-label')); ?>
            <div class="controls" style="width: 70%">
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'sopdetail_nama', 'toolbar' => 'mini', 'height' => '200px')) ?>
            </div>
        </div> 
        <?php echo $form->textFieldRow($model, 'sopdetail_nourut', array('class' => 'span2 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength'=>250)); ?>
             
        
        <?php if(!empty($model->sopdetail_id)){ ?>
        <div class="control-group">
            <?php echo CHtml::label("Status Aktif", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'sopdetail_aktif', array()) ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Detail SOP', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $tips = array(
        '0' => 'autocomplete-search',
        '1' => 'simpan',
        '2' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
