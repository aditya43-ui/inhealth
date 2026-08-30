<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saanastesi-m-search',
	'type'=>'horizontal',
)); ?>
<br>
    <div class="row-fluid">
        <div class="span6">
            <?php echo $form->dropDownListRow($model, 'jenisanastesi_id', CHtml::listData($model->JenisanestesiItems, 'jenisanastesi_id', 'jenisanastesi_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            <?php // echo $form->checkBoxRow($model,'anastesi_aktif',array('checked'=>true)); ?>
            <div class="control-group">
                <?php echo CHtml::label("",'anastesi_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model,'anastesi_aktif',array('checked'=>'anastesi_aktif')); ?> <label>Aktif</label>
                </div>				
            </div>
        </div>
        <div class="span6">
            <?php echo $form->textFieldRow($model,'anastesi_nama',array('class'=>'span3','maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'anastesi_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
        </div>
    </div>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
