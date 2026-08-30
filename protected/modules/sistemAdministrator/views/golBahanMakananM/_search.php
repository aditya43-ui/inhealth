<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
     'id'=>'sagolbahanmakanan-m-search',
                'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'golbahanmakanan_nama',array('size'=>60,'maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'golbahanmakanan_namalain',array('size'=>60,'maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'golbahanmakanan_aktif'); ?>
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
