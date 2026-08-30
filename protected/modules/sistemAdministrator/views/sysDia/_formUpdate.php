<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rmsys-dia-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RMSysDia_kelompokumur_id',
)); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Sysdia</b>
        </div>
    </div>

    <div class="panel-body table-responsive">

        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>

        <?php //echo $form->textFieldRow($model,'kelompokumur_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $form->dropDownListRow($model, 'kelompokumur_id', CHtml::listData($model->KelompokUmurItems, 'kelompokumur_id', 'kelompokumur_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'systolic_min', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'systolic_max', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'diastolic_min', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'diastolic_max', array('class' => 'span3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'sysdia_range', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'sysdia_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textAreaRow($model, 'sysdia_desc', array('rows' => 6, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->checkBoxRow($model,'sysdia_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'sysdia_aktif', array('checked' => 'sysdia_aktif')) . ' Aktif'; ?>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . 'sysDia/admin'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Sysdia', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('sysDia/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>

            <?php
            $content = $this->renderPartial('rekamMedis.views.tips.tipsaddedit', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>