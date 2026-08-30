<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sajenis-anastesi-m-search',
	'type'=>'horizontal',
)); ?>
<br>	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'jenisanastesi_nama',array('class'=>'span3','maxlength'=>50)); ?>
			<?php // echo $form->checkBoxRow($model,'jenisanastesi_aktif',array('checked'=>true)); ?>
                    <div class="control-group">
                        <?php echo CHtml::label("",'jenisanastesi_aktif', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($model,'jenisanastesi_aktif',array('checked'=>'jenisanastesi_aktif')); ?> <label>Aktif</label>
                        </div>				
                    </div>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'jenisanastesi_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'jenisanastesi_teknik',array('class'=>'span3','maxlength'=>50)); ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw "></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
