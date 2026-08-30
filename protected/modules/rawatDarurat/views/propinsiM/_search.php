<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'sapropinsi-m-search',
                 'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'propinsi_nama',array('class'=>'span3', 'maxlength'=>25)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'propinsi_namalainnya',array('class'=>'span3','maxlength'=>25)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php //echo  $form->checkBoxRow($model,'propinsi_aktif',array('checked'=>true)); ?>
			<div class="control-group">
				<?php echo CHtml::label("",'propinsi_aktif', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($model,'propinsi_aktif',array('checked'=>'propinsi_aktif')); ?> <label>Aktif</label>
				</div>
			</div>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'propinsi_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
