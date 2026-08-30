<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->widget('bootstrap.widgets.BootAlert');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'statusHD-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
    'focus' => '#' . CHtml::activeId($model, 'status_hd'),
));
?>
<table width='100%'>
    <tr>
        <td>Status Awal</td>
        <td>
            <?php echo $form->textField($model, 'status_lama', array('readonly' => true, 'class' => 'span3 form-control')); ?>
        </td>
    </tr>
    <tr>
        <td>Ubah Status</td>
        <td>
            <?php echo $form->dropDownList($model, 'status_hd', array('ANTRIAN' => 'ANTRIAN', 'SEDANG TINDAKAN' => 'SEDANG TINDAKAN', 'TIDAK SELESAI' => 'TIDAK SELESAI', 'SELESAI TINDAKAN' => 'SELESAI TINDAKAN') , array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
</table>
<br/>
<div class="form-action">
    <?php 
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
        array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
    ?>
    <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl('StatusHemodialisa'), array('class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
</div>


<?php $this->endWidget(); ?>
<script>
$(document).ready(function(){
    if ("<?php echo !empty($_GET['sukses'])?>") {
        window.parent.$('#dialogStatusHemodialisa').dialog('close');
    }
});
</script>