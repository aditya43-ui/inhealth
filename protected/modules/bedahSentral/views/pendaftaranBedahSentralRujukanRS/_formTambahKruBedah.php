<?php

/**
 * - digunakan untuk memanggil form tambah kru
 * 
 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
 */

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'kkrubedah-add-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'focus' => '#lookupKruBedah',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>

<div class="control-group">
	<?php echo CHtml::label("Kru Bedah <span class='required'>*</span> ", "", array('class' => 'control-label', 'style' => 'float:left;padding:10px;')) ?>
	<div class="controls" style="float:left;padding-left:32px;">
		<?php echo CHtml::dropDownList("lookupKruBedah", '', LookupM::getItemsUrutan('krubedah'), array('empty' => '-- Pilih --')); ?>
	</div>

	<div class="controls">
		<?php
		echo CHtml::link("<i class='" . MyIcon::getIcons('tambah-baris') . "'></i>", "javascript:;", array(
			'class' => 'btn btn-primary',
			'style' => 'color: #fff; margin-left: 5px;',
			//'onclick' => "addKruBedahPeg();", 		
			'onclick' => "tambahLookup()",
			'rel' => 'tooltip',
			'title' => 'Klik untuk menambah kru bedah yang lain '
		));
		?>
	</div>
</div>

<div class="clear"></div>

<div class="control-group">
	<?php echo CHtml::label("Nama Pegawai <span class='required'>*</span> ", "", array('class' => 'control-label', 'style' => 'float:left;padding:10px;')) ?>
	<div class="controls" style="float:left;padding-left:10px;">
		<?php echo CHtml::hiddenField("kruBedahId", '', array('readonly' => true)) ?>
		<?php $this->widget('MyJuiAutoComplete', array(
			'name' => 'kruBedahNama',
			'value' => '',
			'sourceUrl' => $this->createUrl('/ActionAutoComplete/PegawaiRuangan'),
			'options' => array(
				'showAnim' => 'fold',
				'minLength' => 0,
				'focus' => 'js:function( event, ui ) {
										$(this).val( ui.item.label);
										return false;
								}',
				'select' => 'js:function( event, ui ) {
									$("#kruBedahId").val( ui.item.value );																		
									return false;
								 }',
			), 'htmlOptions' => array(
				'placeholder' => 'Nama Pegawai',
			)
		)); ?>
		<?php

		//echo CHtml::dropDownList("lookupKruBedah",'' ,LookupM::getItemsUrutan('krubedah'), array('empty'=>'-- Pilih --')); 
		?>
	</div>
</div>

<div class="clear"></div>

<div class="form-actions">
	<?php echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')),
		array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanKruPegawai();')
	); //,'onKeypress'=>'return formSubmit(this,event)' 
	?>
</div>

<?php $this->endWidget(); ?>