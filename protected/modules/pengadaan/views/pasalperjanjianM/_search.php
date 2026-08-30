<?php
/**
* digunakan untuk Master pasal perjanjian
* @author Elham Budianto <elhambudianto1@gmail.com>
**/
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pasalperjanjian-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Nama Pasal Perjanjian","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'pasalperjanjian_nama',array('class'=>'span3','placeholder'=>'Ketik Nama Pasal Perjanjian','maxlength'=>100)); ?>
                </div>
            </div> 
            <div class="control-group">
                <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'pasalperjanjian_aktif',array('checked'=>'ipm_aktif')); ?> <label>Aktif</label>
                </div>
            </div>
	</div>
	<div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Uraian Pasal Perjanjian","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'pasalperjanjian_uraian',array('class'=>'span3','placeholder'=>'Ketik Uraian Pasal Perjanjian','maxlength'=>100)); ?>		
                </div>
            </div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
