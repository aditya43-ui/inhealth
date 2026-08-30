<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajenisdiet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'jenisdiet_nama'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onClick' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model, 'jenisdiet_nama', array('class' => 'span3', 'size' => 50, 'maxlength' => 50, 'onKeyPress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'namaLain(this)',)); ?>
            <?php echo $form->textFieldRow($model, 'jenisdiet_namalainnya', array('class' => 'span3', 'size' => 50, 'maxlength' => 50, 'onKeyPress' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($model, 'jenisdiet_keterangan', array('class' => 'span3', 'rows' => 6, 'cols' => 50, 'onKeyPress' => "return $(this).focusNextInputField(event);")); ?>
            <?php /* echo $form->textAreaRow($model,'jenisdiet_catatan',array('class'=>'ext.redactorjs.Redactor','id'=>'redactor_content1','rows'=>6, 'cols'=>50)); */ ?>
        </td>
        <td>
            <label class="control-label">Catatan</label>
            <div class='controls'>
                <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'jenisdiet_catatan', 'name' => 'jenisdiet_catatan', 'toolbar' => 'mini', 'height' => '100px')) ?>
            </div>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/JenisdietM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/sistemAdministrator/JenisdietM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
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
        document.getElementById('JenisdietM_jenisdiet_namalainnya').value = nama.value.toUpperCase();
    }
    $(document).ready(function() {
        document.getElementById('JenisdietM_jenisdiet_nama').focus();
    });
</script>