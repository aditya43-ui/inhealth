<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakelurahan-m-search',
                 'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'kecamatan_id',  CHtml::listData($model->KecamatanItems, 'kecamatan_id', 'kecamatan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kelurahan_nama',array('class'=>'span3','maxlength'=>30)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kode_pos',array('class'=>'span1','maxlength'=>6)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php //echo $form->checkBoxRow($model,'kelurahan_aktif',array('checked'=>'checked')); ?>
			<div class="control-group">
				<?php echo CHtml::label("",'kelurahan_aktif', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'kelurahan_aktif',array('checked'=>'kelurahan_aktif')); ?> <label>Aktif</label>
				</div>
			</div>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kelurahan_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
