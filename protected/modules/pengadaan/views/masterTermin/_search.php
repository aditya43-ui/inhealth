<?php
/**
* digunakan untuk Master Termin
* @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
**/
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'adlookup-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Nama Termin","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lookup_name',array('class'=>'span3','placeholder'=>'Ketik Nama Termin','maxlength'=>100)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Jumlah Termin","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lookup_value',array('class'=>'span3','placeholder'=>'Ketik Jenis Termin','maxlength'=>100)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Uratan","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lookup_urutan',array('class'=>'span3','placeholder'=>'Ketik Urutan','maxlength'=>100)); ?>		
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'lookup_aktif',array('checked'=>'ipm_aktif')); ?> <label>Aktif</label>
                </div>
            </div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
