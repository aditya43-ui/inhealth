<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'isiinformasi-m-search',
	'type'=>'horizontal',
)); ?>
<div class="col-sm-6">
	<?php echo $form->dropDownListRow($model,'jenisinformasi_id', CHtml::listData(JenisinformasiM::model()->findAllByAttributes(array(
                //'jenissurat_id'=>$model->jenissurat_id,
                'jenisinformasi_aktif'=>true
            ), array(
                'order'=>'jenissurat_id, jenisinformasi_urutan'
            )), 'jenisinformasi_id', 'jenisinformasi_nama'),
            array('empty'=>'-- Pilih --','class'=>'span3 numbers-only')); ?>
</div>

<div class="col-sm-6">
	<?php // echo $form->textAreaRow($model,'isiinformasi_nama',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo $form->checkBox($model,'isiinformasi_aktif'); ?><label> Aktif</label>
        </div>
    </div>
</div>
<div class="clear"></div>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-default', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
