<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sabarang-m-search',
        'type'=>'horizontal',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'bidang_id',CHtml::listData(BidangM::model()->findAll(), 'bidang_id', 'bidang_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model,'barang_type',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'barang_nama',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'barang_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php //echo $form->checkBoxRow($model,'barang_statusregister',array('checked'=>'barang_statusregister')); ?>
            <?php //echo $form->checkBoxRow($model,'barang_aktif',array('checked'=>'barang_aktif')); ?>
        </td>
    </tr>
	<tr>
		<td>
			 <?php echo $form->checkBoxRow($model,'barang_aktif',array('checked'=>'barang_aktif')); ?>
		</td>
	</tr>
</table>
	<?php //echo $form->textFieldRow($model,'barang_id',array('class'=>'span5')); ?>

	
	<?php //echo $form->textFieldRow($model,'barang_kode',array('class'=>'span5','maxlength'=>50)); ?>
            
	<?php // echo $form->textFieldRow($model,'barang_namalainnya',array('class'=>'span5','maxlength'=>100)); ?>
            

	<?php //echo $form->textFieldRow($model,'barang_noseri',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'barang_ukuran',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'barang_bahan',array('class'=>'span5','maxlength'=>20)); ?>

	<?php // echo $form->textFieldRow($model,'barang_thnbeli',array('class'=>'span5','maxlength'=>5)); ?>

	<?php //echo $form->textFieldRow($model,'barang_warna',array('class'=>'span5','maxlength'=>50)); ?>
            

	<?php // echo $form->textFieldRow($model,'barang_ekonomis_thn',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'barang_satuan',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'barang_jmldlmkemasan',array('class'=>'span5')); ?>
	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
	</div>

<?php $this->endWidget(); ?>
