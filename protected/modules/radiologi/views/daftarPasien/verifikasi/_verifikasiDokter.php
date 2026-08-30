<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'verifikasidokter-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($modPasienMasukPenunjang,'catatan_verifikasi'),
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class='control-group' style="width: 100%;">
    <?php
        if($modPasienMasukPenunjang->is_verifikasi == true || $modPasienMasukPenunjang->is_verifikasi == false) {

            $is_verif = $modPasienMasukPenunjang->is_verifikasi == true ? "Sesuai" : "Tidak Sesuai";
            echo CHtml::label("&emsp;Hasil Verifikasi&nbsp;:&nbsp;", 'catatan_verifikasi', array('class' => 'control-label'));
            echo CHtml::label("&emsp;$is_verif", 'catatan_verifikasi', array('class' => 'control-label'));

        } 
    ?>
</div>
<div class='control-group'>
    <?php echo CHtml::label("&emsp;Catatan", 'catatan_verifikasi', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
            echo $form->hiddenField($modPasienMasukPenunjang, 'is_verifikasi', array('class' => '')); 
            echo $form->textArea($modPasienMasukPenunjang, 'catatan_verifikasi', array('class' => 'span5', 'rows' => 7, 'maxlength' => 100)); 
        ?>
    </div>
</div>
<div class="" style="float: right; margin-right: 20px;">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','Tidak Sesuai',array()),array('class'=>'btn btn-danger', 'type'=>'button', 'onClick'=>'verifikasi(false);', 'onKeypress'=>'verifikasi();')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','Sesuai',array()),array('class'=>'btn btn-danger', 'type'=>'button', 'onClick'=>'verifikasi(true);', 'onKeypress'=>'verifikasi();')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>

function verifikasi(is_verif){

    $('#<?php echo CHtml::activeId($modPasienMasukPenunjang, "is_verifikasi"); ?>').val(is_verif);

    $('#verifikasidokter-t-form').submit();

    return false;
    
}

</script>