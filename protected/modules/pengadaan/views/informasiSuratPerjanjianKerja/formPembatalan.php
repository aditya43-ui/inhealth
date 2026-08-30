<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'permohonanizindinasluar-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    .control-label {
        float: left;
        width: 250px;
        padding-top: 5px;
        text-align: left;
    }
</style>
<?php echo $form->errorSummary($model); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Pembatalan Kontrak</b> </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label("Alasan Pembatalan <span class='required'> * </span>", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                if (!empty($_GET['sukses'])) {
                    echo $form->textArea($model, 'batal_alasan', array('readonly' => true, 'rows' => 3, 'class' => 'span4 required', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                } else {
                    echo $form->textArea($model, 'batal_alasan', array('rows' => 3, 'class' => 'span4 required', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                }
                ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Dokumen Pendukung', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                    if (empty($_GET['sukses'])) {
                        echo $form->fileField($model, 'batal_file', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                    }
                    if (!empty($model->batal_file)) {
                        echo CHtml::link($model->batal_file, $this->createUrl('unduhDokumen',array('id'=>$model->suratperjanjiankerja_id)),array('title'=>'Unduh File','rel'=>'tooltip')); 
                    } else {
                        echo "<label> Belum ada file yang diunggah </label>";
                    }
                ?> 
            </div>
        </div>

        <div class="row-fluid">
            <div class="form-action">
                <?php
                if (!empty($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => true));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>