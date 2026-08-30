<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakecamatan-m-search',
        'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'kabupaten_id',  CHtml::listData($model->KabupatenItems, 'kabupaten_id', 'kabupaten_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kecamatan_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kecamatan_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php //echo $form->checkBoxRow($model,'kecamatan_aktif',array('checked'=>true)); ?>
			<div class="control-group">
				<?php echo CHtml::label("",'kecamatan_aktif', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'kecamatan_aktif',array('checked'=>'kecamatan_aktif')); ?> <label>Aktif</label>
				</div>
			</div>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kecamatan_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
