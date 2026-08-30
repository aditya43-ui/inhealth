<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saloket-m-search',
	'type'=>'horizontal',
)); ?>
<br>
<div class="row-fluid">
	<div class="span6">
		<?php //echo $form->textFieldRow($model,'loket_id',array('class'=>'span3')); ?>
                <?php echo $form->textFieldRow($model,'modelantrian_kode',array('class'=>'span1', 'maxlength'=>5)); ?>
		<?php echo $form->textFieldRow($model,'modelantrian_nama',array('class'=>'span3')); ?>
		<?php echo $form->textFieldRow($model,'modelantrian_singkatan',array('class'=>'span2')); ?>

		
	</div>
	<div class="span6">
            <?php echo $form->textFieldRow($model,'modelantrian_layanan',array('class'=>'span3')); ?>
            <div class="control-group">
                <?php echo CHtml::label("",'modelantrian_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'modelantrian_aktif',array('checked'=>'modelantrian_aktif')); ?> <label>Aktif</label>
                </div>				
            </div>
                
	</div>
    
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
