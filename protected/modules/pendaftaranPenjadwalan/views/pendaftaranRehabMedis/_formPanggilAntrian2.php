<?php $form_antrian = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'anantrian-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'antrian_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'ruangan_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'carabayar_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'pendaftaran_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'profilrs_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'loket_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'tglantrian', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'statuspasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'noantrian', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 6)); ?>
<?php echo $form_antrian->hiddenField($modAntrian, 'carabayar_loket', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<!--<div style="width: 100%; text-align: center; font-size: 30px; font-weight: bold;">-->
<div class="label_no_antrian_2">
    <?php

    $modelAntrian = ModelantrianM::model()->findByPk($modAntrian->modelantrian_id);

    echo (empty($modAntrian->modelantrian_id) ? "X" : $modelAntrian->modelantrian_singkatan) . "-" . (empty($modAntrian->noantrian) ? "0000" : $modAntrian->noantrian); 
    ?>
</div>
<!--<div class="control-group">
                <?php // echo CHtml::label('Status Panggilan', 'panggil_flaq',array('class'=>'control-label')); 
                ?>
                <div class="controls">-->
<?php
$statuspanggilan = (isset($modAntrian->antrian_id) ? (($modAntrian->panggil_flaq) ? "SUDAH" : "BELUM") : "");
echo CHtml::hiddenField('statuspanggilan', $statuspanggilan, array('class' => 'span3'));
echo $form_antrian->hiddenField($modAntrian, 'panggil_flaq', array('readonly' => true, 'class' => 'span3'));
?>
<!--</div>
            </div>-->

<?php $this->endWidget(); ?>