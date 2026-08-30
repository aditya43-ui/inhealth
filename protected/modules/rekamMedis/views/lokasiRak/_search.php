<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmlokasi-rak-search',
        'type'=>'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'lokasirak_nama',array('class'=>'span3','maxlength'=>100)); ?>        
        <?php echo $form->checkBoxRow($model,'lokasirak_aktif',array('checked'=>'$data->lokasirak_aktif')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'lokasirak_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>        
    </div>
</div>
<?php //echo $form->textFieldRow($model,'lokasirak_id',array('class'=>'span3')); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
