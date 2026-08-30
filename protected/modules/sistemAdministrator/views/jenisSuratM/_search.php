<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'type'=>'horizontal',
                'id'=>'sajenissurat-m-search'
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jenissurat_nama',array('size'=>60,'maxlength'=>200,'class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jenissurat_namalain',array('size'=>60,'maxlength'=>200,'class'=>'span3')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'jenissurat_aktif'); ?>
        </td>
    </tr>
</table>
		<?php // echo $form->textFieldRow($model,'jenissurat_id',array('class'=>'span3')); ?>

	<div class="form-actions">
	  <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>