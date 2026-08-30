<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'satypeanastesi-m-search',
	'type'=>'horizontal',
)); ?>
<br>
    <div class="row-fluid">
        <div class="span6">
            <?php echo $form->dropDownListRow($model, 'anastesi_id', CHtml::listData($model->AnestesiItems, 'anastesi_id', 'anastesi_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            <?php // echo $form->checkBoxRow($model,'typeanastesi_aktif',array('checked'=>true)); ?>
            <div class="control-group">
                <?php echo CHtml::label("",'typeanastesi_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'typeanastesi_aktif',array('checked'=>'typeanastesi_aktif')); ?> <label>Aktif</label>
                </div>				
            </div>
        </div>
        <div class="span6">
            <?php echo $form->textFieldRow($model,'typeanastesi_nama',array('class'=>'span3','maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'typeanastesi_namalain',array('class'=>'span3','maxlength'=>50)); ?>
        </div>
    </div>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
