<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'rjkasuspenyakitdiagnosa-m-search',
                 'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->DropDownListRow($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJeniskasuspenyakitItems(),'jeniskasuspenyakit_id','jeniskasuspenyakit_nama'),array('empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->DropDownListRow($model, 'diagnosa_id', CHtml::listData($model->getDiagnosaItems(),'diagnosa_id','diagnosa_nama'),array('empty'=>'-- Pilih --')); ?>
        </td>
    </tr>
</table>
		<?php /* echo $form->textFieldRow($model,'jenisdiet_id'); */ ?>
		<?php // echo $form->textFieldRow($model,'jeniskasuspenyakit_nama',array('class'=>'span3','size'=>50,'maxlength'=>50)); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
