<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapemilikbarang-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'pemilikbarang_kode',array('class'=>'span3','maxlength'=>20)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'pemilikbarang_nama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
         <td>
            <?php echo $form->textFieldRow($model,'pemilikbarang_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'pemilikbarang_aktif',array('checked'=>'pemilikbarang_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'pemilikbarang_id',array('class'=>'span5')); ?>

	

	

	<?php //echo $form->textFieldRow($model,'pemilikbarang_namalainnya',array('class'=>'span5','maxlength'=>100)); ?>

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
