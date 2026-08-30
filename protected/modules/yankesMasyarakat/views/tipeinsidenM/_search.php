<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'tipeinsiden-m-search',
	'type'=>'horizontal',
)); ?>
<br>
<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'tipeinsiden_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'tipeinsiden_namalainnya',array('class'=>'span3 hurufs-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        <div class="control-group">
            <?php echo CHtml::label("",'tipeinsiden_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'tipeinsiden_aktif',array('checked'=>'tipeinsiden_aktif')); ?> <label>Aktif</label>
            </div>				
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
