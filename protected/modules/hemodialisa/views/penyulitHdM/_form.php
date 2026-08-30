<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penyulit-hd-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'penyulit_hd_nama')
        ));
?>
<div class="control-group">
<label class="help-block" style="color:#333;">Bagian yang bertanda <span class="required">*</span> harus diisi.</label>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Nama Penyulit <span class="required">*</span>', array('class' => 'span3 control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penyulit_hd_nama', array('class' => 'span3 required', 'onkeyup'=>"penyulitNama(this);",
                    'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'Nama Penyulit Lainnya<span class="required">*</span>', array('class' => 'span3 control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penyulit_hd_namalainnya', array('class' => 'span3 required', 'maxlength' => 100)); ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('create'), array('class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Penyulit HD', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('content' => '')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
//    function shiftNama(this){
//        console.log(this.value);
//    }
    
    function penyulitNama(nama)
    {
        document.getElementById('PenyulitHdM_penyulit_hd_namalainnya').value = nama.value.toUpperCase();
        document.getElementById('PenyulitHdM_penyulit_hd_nama').value = nama.value;
    }
</script>