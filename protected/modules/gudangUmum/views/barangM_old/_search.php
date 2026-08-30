<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sabarang-m-search',
        'type'=>'horizontal',
)); ?>
<table width=100%>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'bidang_id',CHtml::listData(BidangM::model()->findAll(), 'bidang_id', 'bidang_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model,'barang_type',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'barang_nama',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'barang_merk',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->checkBoxRow($model,'barang_statusregister',array('checked'=>'barang_statusregister')); ?>
            <?php echo $form->checkBoxRow($model,'barang_aktif',array('checked'=>'barang_aktif')); ?>
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
