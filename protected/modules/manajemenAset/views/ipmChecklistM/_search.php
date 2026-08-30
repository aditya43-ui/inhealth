<?php
/**
* - digunakan sebagai Admin IPM CHECKLIST
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sagolongan-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
		<div class="control-group">
            <?php echo $form->labelEx($model,'ipm_jenis',array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeDropDownList($model, 'ipm_jenis', LookupM::getItems('ipmchecklist'), array(
                    'empty'=>'-- Pilih --',
                ))?>
		    </div>
        </div> 
        <!--<div class="control-group">
            <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'ipm_aktif',array('checked'=>'ipm_aktif')); ?> <label>Aktif</label>
            </div>
        </div>-->  
	</div>
	<div class="col-sm-6">
		<?php //echo $form->textFieldRow($model,'ipm_list_nourut',array('class'=>'span3 custom-only','placeholder'=>'Ketik Nama UMDNS','maxlength'=>100)); ?>
		<?php echo $form->textFieldRow($model,'ipm_listnama',array('class'=>'span3','placeholder'=>'Ketik Nama IPM','maxlength'=>100)); ?>		
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
