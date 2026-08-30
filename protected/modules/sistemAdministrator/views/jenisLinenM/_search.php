<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sajenislinen-m-search',
	'type'=>'horizontal',
)); ?>

<table style = "width:100%">
    <tr>
        <td>
	<?php //echo $form->textFieldRow($model,'bahanlinen_id',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'jenislinen_no',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jenislinen_nama',array('class'=>'span3','maxlength'=>200)); ?>
        </td>
         <td>
                    
        <?php echo $form->textFieldRow($model,'qtyitem',array('class'=>'span3','maxlength'=>7)); ?>
        <?php echo $form->textFieldRow($model,'warnalinen',array('class'=>'span3','maxlength'=>50)); ?>

	
        </td>
        <td>
            <?php echo $form->checkBoxRow($model,'isberwarna', array('checked'=>'isberwarna')); ?>
        </td>
    </tr>           
    
</table>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-default', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
