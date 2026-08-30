<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'sajenis-carabayar-m-search',
)); ?>

<div class="row fluid">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'jeniskie', LookupM::getItems('jeniskie'),array('class'=>'span3', 'empty' => '-- Pilih --')) ?>
            <?php echo $form->textFieldRow($model,'listkie_nama',array('class'=>'span3','maxlength'=>200)); ?>

    </div>
    <div class="col-sm-6">
            <?php echo $form->textFieldRow($model,'listkie_namalain',array('class'=>'span3','maxlength'=>200)); ?>
            <?php echo $form->checkBoxRow($model,'listkie_aktif',array('checked'=>'carabayar_aktif')); ?>
        
    </div>
</div>
	<?php //echo $form->textFieldRow($model,'carabayar_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'carabayar_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="fa fa-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
