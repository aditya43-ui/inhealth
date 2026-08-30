<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'preventifmainten-m-search',
	'type'=>'horizontal',
)); ?>
    <div class="control-group"> 
        <?php echo CHtml::label('Jenis Peralatan <span class="required">*</span>','barang_id', array('class'=>'span2 control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($model,'barang_nama',array('class'=>'span3')); ?>
        </div>
    </div>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
