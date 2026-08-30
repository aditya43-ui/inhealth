<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gftemplateobat-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model,'dokter_id', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'nama_pegawai',array('class'=>'span3')); ?>
            </div>
        </div> 
        <?php echo $form->textFieldRow($model,'nama_paket',array('class'=>'span3','maxlength'=>100)); ?>            
        <div class='control-group'>
            <?php echo CHtml::label("",'is_paketbmhp', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::label(CHtml::activeCheckBox($model, 'is_paketbmhp')."Paket BMHP",'is_paketbmhp', array('class' => 'control-label'))?>
            </div>
        </div> 
	</div>
	<div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'harga_paket',array('class'=>'span3','maxlength'=>100)); ?>            
        <div class='control-group'>
            <?php echo CHtml::label("",'is_aktif', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'is_aktif',array('checked'=>'is_aktif', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> <label>Aktif</label>
            </div>
        </div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
