<div class="wide form">

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
     'id'=>'sajenis-carabayar-m-search',
                'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'zatgizi_id',
                CHtml::listData($model->ZatgiziItems, 'zatgizi_id', 'zatgizi_nama'),
                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'bahanmakanan_id',
                CHtml::listData($model->BahanMakananItems, 'bahanmakanan_id', 'namabahanmakanan'),
                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kandunganbahan',array('class'=>'span2')); ?>
        </td>
    </tr>
</table>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!--search-form-->