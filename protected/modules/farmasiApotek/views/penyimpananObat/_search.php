<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'penyimpananobat-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'rakobat_nama',array('placeholder' => 'Rak Obat', 'class'=>'span3','maxlength'=>200)); ?>
		<?php echo $form->textFieldRow($model,'rakobat_namalain',array('placeholder' => 'Rak Obat Lainnya', 'class'=>'span3','maxlength'=>200)); ?>		
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'rakobat_label',array('placeholder' => 'Rak Obat Label', 'class'=>'span3','maxlength'=>1)); ?>
		<?php echo $form->checkBoxRow($model,'rakobat_aktif'); ?>		
	</div>
</div>
<?php //echo $form->textFieldRow($model,'rakobat_id',array('class'=>'span3')); ?>
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
