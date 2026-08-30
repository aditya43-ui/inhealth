<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'klasifikasisubkelas-m-search',
        'type'=>'horizontal',
)); ?>
<br>
            <?php echo $form->textFieldRow($model,'klasifikasisubkelas_nama',array('class'=>'form-control span3','maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'klasifikasisubkelas_kode',array('class'=>'form-control span3','maxlength'=>50)); ?>
        
			<div class="control-group">
			<?php echo CHtml::label("",'klasifikasisubkelas_aktif', array('class'=>'control-label')) ?>
				  <div class="controls">
						<?php echo $form->checkBox($model,'klasifikasisubkelas_aktif',array('checked'=>'checked')); ?> <label>Aktif</label>
				  </div>
			</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-default', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
