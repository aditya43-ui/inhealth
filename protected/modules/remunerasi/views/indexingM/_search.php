<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saindexing-m-search',
        'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'kelrem_id',  CHtml::listData($model->getKelremItems(), 'kelrem_id', 'kelrem_nama'), array('empty' => '-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'indexing_nama',array('size'=>60,'maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'indexing_singk'); ?>            
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'indexing_nilai'); ?>
        </td>
        <td>
            <?php echo $form->checkBoxRow($model,'indexing_aktif',array('checked'=>true)); ?>
        </td>
    </tr>
</table>
		<?php //echo $form->textFieldRow($model,'indexing_id'); ?>
		
		<?php //echo $form->textFieldRow($model,'indexing_urutan'); ?>
		
		<?php //echo $form->textFieldRow($model,'indexing_singk',array('size'=>30,'maxlength'=>30)); ?>
		

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
</div>

<?php $this->endWidget(); ?>
