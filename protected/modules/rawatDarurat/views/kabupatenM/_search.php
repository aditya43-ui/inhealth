<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'sakabupaten-m-search',
        'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'propinsi_nama',array('class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kabupaten_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php //echo $form->checkBoxRow($model,'kabupaten_aktif',array('checked'=>true)); ?>
			<div class="control-group">
				<?php echo CHtml::label("",'kabupaten_aktif', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'kabupaten_aktif',array('checked'=>'kabupaten_aktif')); ?> <label>Aktif</label>
				</div>
			</div>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kabupaten_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
