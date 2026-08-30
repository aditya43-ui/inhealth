<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajenisnapza-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onSubmit' => 'return validasi()', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#SAJenisnapzaM_jenisnapza_nama',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'jenisnapza_nama', array('class' => 'span2 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php echo $form->textAreaRow($model, 'jenisnapza_desc', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php // echo $form->checkBoxRow($model,'jenisnapza_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>

    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Napza', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>

    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreateUpdate', array(), true);
    $this->widget('UserTips', array('content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function validasi() {
        var x = 0;
        $('input.required,textarea.required,select.required').each(function() {
            if ($(this).val() == "") {
                $(this).addClass("error");
                x++;
            } else {
                $(this).removeClass("error");
            }
        });
        if (x > 0) {
            return false;
        } else {
            return true;
        }

    }
</script>