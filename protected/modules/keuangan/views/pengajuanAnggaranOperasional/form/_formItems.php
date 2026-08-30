<?php
/**
* - digunakan untuk mengenrate form untuk input data items
*
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<tr>
	<td style="text-align: center;">
			<?php echo CHtml::activeHiddenField($model, '['.$i.']pengajuanpettydet_id',array('class'=>'form-control type'));?>
            <div class="control-group">
			<?php echo CHtml::activeTextArea($model, '['.$i.']pengajuanpettydet_item',array('class'=>'form-control item required autogrow', 'maxlength'=>250));?>
		</div>
	</td>
	<td style="text-align: center;">
            <div class="control-group">
		<?php echo CHtml::activeTextField($model, '['.$i.']pengajuanpettydet_qty',array('class'=>'form-control qty required numbers-only', 'onkeyup' => 'setNumbersOnly(this);hitungTot();', 'style'=>'text-align:right;', 'maxlength'=>4));?>
            </div>

	</td>
	<td style="text-align: center;">
            <div class="control-group">
		Rp <?php echo CHtml::activeTextField($model, '['.$i.']pengajuanpettydet_hargasatuan',array('class'=>'form-control span2 hargasatuan required integer2', 'style'=>'text-align:right;',  'onkeyup' => 'hitungTot();'));?>
            </div>

	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextArea($model, '['.$i.']pengajuanpettydet_keterangan',array('class'=>'form-control keterangan autogrow'));?>
	</td>
	<td style="text-align: center;">
		<div class="control-group">
			Rp <?php echo CHtml::activeTextField($model, '['.$i.']pengajuanpettydet_subtotal',array('class'=>'form-control subtotal span2 required integer2', 'style'=>'text-align:right;', 'readonly'=>true));?>
		</div>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="entypo-minus"></i>', 'javascript:;', array('class' => 'btn btn-default','onclick'=>'hapusLookup(this)', ));//"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"", "data-original-title"=>"Klik icon ini, jika Anda ingin menghapus bari ini", "data-html" => true ?>
	</td>
</tr>
