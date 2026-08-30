<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'edukasitransfusiitem-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'edukasitransfusiitem_nama', array('placeholder' => 'Nama', 'rows' => 2, 'cols' => 60, 'class' => '', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'edukasitransfusiitem_urutan', array('placeholder' => 'Urutan', 'class' => 'integer span2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'edukasitransfusiitem_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'edukasitransfusiitem_aktif'); ?>
                <label for="EdukasitransfusiitemM_edukasitransfusiitem_aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="control-group">
    <?php
    echo $form->label($model, 'edukasitransfusiitem_deskripsi', array(
        'class' => 'control-label'
    ));
    ?>
    <div class="controls" style="width: 98%">
        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'edukasitransfusiitem_deskripsi', 'toolbar' => 'mini', 'height' => '300px')); ?>
    </div>
</div>

<?php //  $form->textAreaRow($model,'edukasitransfusiitem_deskripsi',array('rows'=>6, 'cols'=>50, 'class'=>'span8', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
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
        Yii::t('mds', '{icon} Item Edukasi Transfusi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>