<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rjkelasruangan-m-search',
	'type'=>'horizontal',
)); ?>
	
	<?php echo $form->DropDownListRow($model, 'pegawai_id', CHtml::listData($model->getPegawaiItems(),'pegawai_id','namalengkap'),array('empty'=>'-- Pilih --')); ?>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
