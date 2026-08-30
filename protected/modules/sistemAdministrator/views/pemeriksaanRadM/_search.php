<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapemeriksaan-rad-m-search',
        'type'=>'horizontal',
)); ?> 
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'daftartindakan_nama',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'pemeriksaanrad_jenis',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'pemeriksaanrad_nama',array('class'=>'span3','maxlength'=>20)); ?>
            <?php echo $form->textFieldRow($model,'pemeriksaanrad_namalainnya',array('class'=>'span3','maxlength'=>20)); ?>
        </td>
        <td>
            <div style="padding-left:50px;">
                <?php echo $form->checkBoxRow($model,'pemeriksaanrad_aktif',array('checked'=>true)); ?>
            </div>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'pemeriksaanrad_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
