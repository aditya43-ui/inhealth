<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'jenismakanan-m-search',
	'type'=>'horizontal',
)); ?>

	<?php // echo $form->textFieldRow($model,'jenismakanan_id',array('class'=>'span3 numbers-only')); ?>

	<?php echo $form->dropDownListRow($model,'jeniswaktu_id', CHtml::listData(JeniswaktuM::model()->findAll('jeniswaktu_aktif = true order by urutan'), 'jeniswaktu_id', 'jeniswaktu_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'jenismakanan_nama',array('class'=>'span3','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'jenismakanan_namalainnya',array('class'=>'span3','maxlength'=>255)); ?>

    <div class='control-group'>
        <label class='control-label'>&nbsp;</label>
        <div class='controls'>
            <?php echo $form->checkBox($model,'jenismakanan_aktif'); ?>
            <label>Aktif</label>
        </div>
    </div>


	

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
