<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sasubkelompok-m-search',
        'type'=>'horizontal',
)); ?>
<table width='100%'>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'kelompok_id',  CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'subkelompok_kode',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'subkelompok_nama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'subkelompok_aktif',array('checked'=>'subkelompok_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'subkelompok_id',array('class'=>'span3')); ?>

	<?php //echo $form->dropDownListRow($model,'kelompok_id',CHtml::listData(KelompokM::model()->findAll(), 'kelompok_id', 'kelompok_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
	

	

	

	<?php //echo $form->textFieldRow($model,'subkelompok_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
