<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saformasishift-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'ruangan_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'shift_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  
        ?>
        <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jmlformasi', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  
        ?>
        <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  
        ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'formasishift_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'formasishift_aktif'); ?>
                <label for="SAFormasishiftM_formasishift_aktif">Aktif</label>
            </div>
        </div>

    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/formasiShiftKP/update'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Formasi Shift', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>