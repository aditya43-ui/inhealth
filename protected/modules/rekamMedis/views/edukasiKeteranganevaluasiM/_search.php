<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'edukasi-keteranganevaluasi-m-search',
	'type'=>'horizontal',
)); ?>

	<?php // echo $form->textFieldRow($model,'edukasi_keteranganevaluasi_id',array('class'=>'span3 numbers-only')); ?>
<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'kodeedukator',array('class'=>'span3','maxlength'=>200)); ?>

        <?php echo $form->textFieldRow($model,'keterangan_evaluasi',array('class'=>'span3','maxlength'=>200)); ?>
        
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'urutan',array('class'=>'span3 numbers-only')); ?>

        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php echo $form->checkBox($model,'is_aktif'); ?>
                <?php echo $form->label($model,'is_aktif'); ?>
            </div>
        </div>
        
    </div>
</div>



	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-default', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
