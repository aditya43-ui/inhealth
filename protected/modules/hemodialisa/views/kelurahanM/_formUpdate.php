<?php  ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakelurahan-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#propinsi',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Propinsi','propinsi',array('class'=>"control-label")) ?>
                <div class="controls">
                    <?php echo CHtml::dropDownList('propinsi', $model->getPropinsiItemsKec($model->kecamatan_id), CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'),array('empty'=>'-- Pilih --',
                                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                'ajax'=>array(
                                                                                'type'=>'POST',
                                                                                'url'=>Yii::app()->createUrl('ActionDynamic/GetKabupaten',array('encode'=>false,'namaModel'=>'','attr'=>'propinsi')),
                                                                                'update'=>'#kabupaten',))); 
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Kabupaten','kabupaten',array('class'=>"control-label")) ?>
                <div class="controls">
                    <?php echo CHtml::dropDownList('kabupaten', $model->getKabupatenItemsKec($model->kecamatan_id), CHtml::listData($model->KabupatenItems, 'kabupaten_id', 'kabupaten_nama'),array('empty'=>'-- Pilih --',
                                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                'ajax'=>array(
                                                                                'type'=>'POST',
                                                                                'url'=>Yii::app()->createUrl('ActionDynamic/GetKecamatan',array('encode'=>false,'namaModel'=>'','attr'=>'kabupaten')),
                                                                                'update'=>'#SAKelurahanM_kecamatan_id',))); 
                    ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'kecamatan_id',CHtml::listData($model->KecamatanItems, 'kecamatan_id', 'kecamatan_nama'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'kelurahan_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kelurahan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
            <?php echo $form->textFieldRow($model,'kode_pos',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>15,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'kelurahan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        Yii::app()->createUrl($this->module->id.'/kelurahanM/admin'), 
        array('class'=>'btn btn-danger',
           'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php
        $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SAKelurahanM_kelurahan_namalainnya').value = nama.value.toUpperCase();
    }
</script>