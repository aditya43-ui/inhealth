<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'rjkelasruangan-m-search',
                 'type'=>'horizontal',
)); ?>
                                <?php // echo $form->DropDownListRow($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --',)); ?>
		<?php echo $form->DropDownListRow($model, 'pegawai_id', CHtml::listData($model->getPegawaiItems(),'pegawai_id','namalengkap'),array('empty'=>'-- Pilih --')); ?>
                                <?php // echo $form->textFieldRow($model, 'nama_pegawai',array('class'=>'span3')) ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
