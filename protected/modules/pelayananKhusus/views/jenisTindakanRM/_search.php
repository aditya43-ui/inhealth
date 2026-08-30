<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmjenis-tindakanrm-m-search',
        'type'=>'horizontal',
)); ?>


	<?php echo $form->textFieldRow($model,'jenistindakanrm_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'jenistindakanrm_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>

	
        <div class="control-group">
        <?php echo CHtml::label("", 'jenistindakanrm_aktif', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->checkBox($model, 'jenistindakanrm_aktif', array('checked' => 'jenistindakanrm_aktif')) ?> <label>Aktif</label>
        </div>	
            </div>	
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
