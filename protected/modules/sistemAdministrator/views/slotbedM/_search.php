<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'slotbed-m-search',
        'focus'=>'#SASotbedM_jadwal_hari',
        'type'=>'horizontal',        
)); ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model,'jadwal_hari',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'jadwal_hari',array('class'=>'span3 form-control','maxlength'=>20)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model,'Tanggal',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'bulan', Params::getBulan() ,array('class' => 'form-control','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model,'jadwal_buka',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'jadwal_buka',array('class'=>'span3 form-control','maxlength'=>50)); ?>
            </div>
        </div>
	<?php //echo $form->textFieldRow($model,'jadwal_mulai',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'jadwal_tutup',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'maximumantrian',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span5')); ?>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
