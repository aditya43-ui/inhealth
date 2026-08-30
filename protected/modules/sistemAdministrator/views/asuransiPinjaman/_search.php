<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapremiasuransi-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'umur',array('class'=>'span3 numbers-only','maxlength'=>7,'style' => 'text-align:right;')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'tahun',array('class'=>'span3 numbers-only','maxlength'=>7,'style' => 'text-align:right;')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'persen',array('class'=>'span3 comadesimal-only','maxlength'=>10,'style' => 'text-align:right;')); ?>
        </td>
    </tr>
    
    
</table>
	<?php //echo $form->textFieldRow($model,'asalaset_id',array('class'=>'span5')); ?>

	

	

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
