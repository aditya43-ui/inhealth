<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sadiagnosakeperawatan-m-search',
        'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'diagnosakeperawatan_kode',array('class'=>'span2','maxlength'=>10)); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'diagnosa_medis',array('rows'=>3, 'cols'=>30, 'class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'diagnosa_keperawatan',array('rows'=>3, 'cols'=>30, 'class'=>'span3')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'diagnosa_keperawatan_aktif', array('checked'=>'$data->diagnosa_keperawatan_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'diagnosakeperawatan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'diagnosa_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
