<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'golongan-gaji-m-search',
    'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'masakerja',array('class'=>'span3','maxlength'=>15)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jmlgaji',array('class'=>'span3','maxlength'=>20)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jenisgolongan',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'golongangaji_aktif',array('checked'=>'golongangaji_aktif')); ?>
        </td>
    </tr>
</table>
	

	

	

	

	<div class="form-actions">
        <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
