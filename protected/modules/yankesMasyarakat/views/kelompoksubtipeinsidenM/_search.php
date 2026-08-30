<?php
/**
* digunakan untuk Master kelompok tipe insiden
* @author Elham Budianto <elhambudianto1@gmail.com>
**/
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kelompoktipeinsiden-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Tipe Insiden","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'tipeinsiden_id',Chtml::listData(TipeinsidenM::model()->findAllByAttributes(array('tipeinsiden_aktif'=>true)),'tipeinsiden_id','tipeinsiden_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
                </div>
            </div> 
            <div class="control-group">
                <?php echo CHtml::label("Kelompok Subtipe Insiden","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'kelompoksubtipeinsiden_nama',array('class'=>'span3','placeholder'=>'Ketik Nama Kelompok Subtipe Insiden','maxlength'=>100)); ?>
                </div>
            </div> 
            <div class="control-group">
                <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'kelompoksubtipeinsiden_aktif',array('checked'=>'kelompoksubtipeinsiden_aktif')); ?> <label>Aktif</label>
                </div>
            </div>
	</div>
	<div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Nama Lain Kelompok Subtipe Insiden","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'kelompoksubtipeinsiden_namalainnya',array('class'=>'span3','placeholder'=>'Ketik Nama Lain Kelompok Subtipe Insiden','maxlength'=>100)); ?>
                </div>
            </div> 
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
