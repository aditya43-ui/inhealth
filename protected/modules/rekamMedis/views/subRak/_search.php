<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmsub-rak-search',
        'type'=>'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'subrak_nama',array('class'=>'span3','maxlength'=>30)); ?>
        <?php echo $form->checkBoxRow($model,'subrak_aktif',array('checked'=>'$data->subrak_aktif')); ?>        
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'subrak_namalainnya',array('class'=>'span3','maxlength'=>30)); ?>        
    </div>
</div>
<?php //echo $form->textFieldRow($model,'subrak_id',array('class'=>'span3')); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
