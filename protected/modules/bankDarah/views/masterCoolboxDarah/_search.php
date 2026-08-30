<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'coolboxdarah-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Cool Box','coolboxdarah_nama', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'coolboxdarah_nama',array('rows'=>2, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Merek','coolbox_merk', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'coolbox_merk',array('rows'=>2, 'cols'=>50, 'class'=>'span3 hurufs-only', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jenis Cool Box','coolbox_jenis', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'coolbox_merk',array('rows'=>2, 'cols'=>50, 'class'=>'span3 hurufs-only', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("",'coolbox_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'coolbox_aktif',array('checked'=>'coolbox_aktif')); ?> <label>Aktif</label>
            </div>				
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
