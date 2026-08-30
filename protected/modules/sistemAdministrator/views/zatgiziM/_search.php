<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'satipediet-m-search',
                 'type'=>'horizontal',
)); ?>
<table width='100%'>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'zatgizi_nama',array('class'=>'span3','size'=>30,'maxlength'=>30)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'zatgizi_namalainnya',array('class'=>'span3','size'=>30,'maxlength'=>30)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'zatgizi_satuan',array('class'=>'span1','size'=>10,'maxlength'=>10)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkboxRow($model,'zatgizi_aktif', array('checked'=>'zatgizi_aktif')); ?>
        </td>
    </tr>
</table>
		<?php /* echo $form->label($model,'zatgizi_id'); */ ?>
		<?php /* echo $form->textField($model,'zatgizi_id'); */ ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
    