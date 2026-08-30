<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmsys-dia-search',
        'type'=>'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'systolic_min',array('placeholder' => 'Systolic Min', 'class'=>'span3')); ?>
        <?php echo $form->textFieldRow($model,'systolic_max',array('placeholder' => 'Systolic Max', 'class'=>'span3')); ?>        
        <?php echo $form->checkBoxRow($model,'sysdia_aktif',array('checked'=>'$data->sysdia_aktif')); ?>        
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'diastolic_min',array('placeholder' => 'Diastolic Min', 'class'=>'span3')); ?>
        <?php echo $form->textFieldRow($model,'diastolic_max',array('placeholder' => 'Diastolic Max', 'class'=>'span3')); ?>
    </div>
</div>
<?php //echo $form->textFieldRow($model,'sysdia_id',array('class'=>'span3')); ?>
<?php //echo $form->textFieldRow($model,'kelompokumur_id',array('class'=>'span3')); ?>
<?php //echo $form->textFieldRow($model,'sysdia_range',array('class'=>'span3','maxlength'=>100)); ?>
<?php //echo $form->textFieldRow($model,'sysdia_nama',array('class'=>'span3','maxlength'=>100)); ?>
<?php //echo $form->textAreaRow($model,'sysdia_desc',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>	
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
<?php echo CHtml::link(
    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
    array(
        'title' => 'Ulang',
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
    )
); ?>
</div>

<?php $this->endWidget(); ?>
