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
                <?php echo $form->textFieldRow($model,'lokasi_karcisantrian_nama',array('class'=>'span3')); ?>
		<?php echo $form->textFieldRow($model,'lokasi_karcisantrian_judul',array('class'=>'span3')); ?>
		

		
	</div>
	<div class="span6">
            <div class="control-group">
                <?php echo CHtml::label("",'loket_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'lokasi_karcisantrian_aktif',array('checked'=>'lokasi_karcisantrian_aktif', 'class' => 'cek-aktif')); ?> <label>Aktif</label>
                </div>				
            </div>
                
	</div>
    
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
