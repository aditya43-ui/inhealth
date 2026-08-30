<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sagolongan-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'umdns_kode',array('class'=>'span3','placeholder'=>'Ketik Kode UMDNS')); ?>
                <div class="control-group">
                    <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'umdns_aktif',array('checked'=>'golongan_aktif')); ?> <label>Aktif</label>
                    </div>
                </div>  
	</div>
	<div class="col-sm-6">
		<?php echo $form->textFieldRow($model,'umdns_nama',array('class'=>'span3 custom-only','placeholder'=>'Ketik Nama UMDNS','maxlength'=>100)); ?>
		<?php echo $form->textFieldRow($model,'umdns_namalainnya',array('class'=>'span3 custom-only','placeholder'=>'Ketik Nama Lain UMDNS','maxlength'=>100)); ?>		
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
