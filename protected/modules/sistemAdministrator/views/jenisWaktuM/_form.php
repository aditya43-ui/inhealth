<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajeniswaktu-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'jeniswaktu_nama'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'jeniswaktu_nama', array('size' => 50, 'maxlength' => 50, 'onkeyup' => "namaLain(this)", 'onKeyPress' => 'return disableKeyPress(event)')); ?>
<?php echo $form->textFieldRow($model, 'jeniswaktu_namalain', array('size' => 50, 'maxlength' => 50, 'onKeyPress' => 'return disableKeyPress(event)')); ?>
<!--<div class="control-label">Jam *</div>
                        <div class="controls">
                            <?php //echo CHtml::textField('jam','',array('size'=>20,'maxlength'=>2,'style'=>'width:20px;')); 
                            ?> /
                            <?php //echo CHtml::textField('menit','',array('size'=>20,'maxlength'=>2,'style'=>'width:20px;')); 
                            ?>
                        </div>-->
<div class='control-group'>
    <?php echo $form->labelEx($model, 'jeniswaktu_jam', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => 'jeniswaktu_jam',
            //                                        'mode'=>'date',
            'mode' => 'time',
            'options' => array(
                'timeFormat' => '',
            ),
            'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onKeyPress' => 'return disableKeyPress(event)'),
        )); ?>
        <?php echo $form->error($model, 'jeniswaktu_jam'); ?>
    </div>
</div>
<div>
    <?php echo $form->checkBoxRow($model, 'jeniswaktu_aktif'); ?>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jenisWaktuM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Waktu', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/sistemAdministrator/JenisWaktuM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('JenisWaktuM_jeniswaktu_namalain').value = nama.value.toUpperCase();
    }
</script>