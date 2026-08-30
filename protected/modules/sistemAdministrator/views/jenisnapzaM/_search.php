<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sajenisnapza-m-search',
        'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jenisnapza_nama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'jenisnapza_aktif',array('checked'=>'jenisnapza_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'jenisnapza_id',array('class'=>'span5')); ?>

	<?php //echo $form->textAreaRow($model,'jenisnapza_desc',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
