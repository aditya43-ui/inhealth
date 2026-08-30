<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jenisinformasi-m-search',
	'type'=>'horizontal',
)); ?>

<div class="col-sm-6">
	<?php echo $form->textFieldRow($model,'jenissurat_id',array('class'=>'span3 numbers-only')); ?>
	<?php echo $form->textFieldRow($model,'jenisinformasi_nama',array('class'=>'span3')); ?>
</div>
<div class="col-sm-6">
	<?php echo $form->textFieldRow($model,'jenisinformasi_namalain',array('class'=>'span3')); ?>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'jenisinformasi_aktif'); ?><label> Aktif</label>
        </div>
    </div>
</div>
<div class="clear"></div>




	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-default', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
