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
	<td>
		<?php 
			$model->pilih = true;
			echo CHtml::activeCheckBox($model, '['.$i.']pilih',array('class'=>'pilih','onchange'=>'hitungTot();')); 
		?>
	</td>
	<td style="text-align: center;">		
			<?php echo CHtml::activeHiddenField($model, '['.$i.']pengajuanpetty_id',array('class'=>'form-control type'));?>
			<?php echo CHtml::activeHiddenField($model, '['.$i.']pengajuanpettydet_id',array('class'=>'form-control type'));?>
            <div class="control-group">
			<?php echo CHtml::activeTextArea($model, '['.$i.']pengajuanpettydet_item',array('readonly'=>true,'class'=>'form-control item required autogrow', 'maxlength'=>250));?>	
		</div>	
	</td>
	<td style="text-align: center;">
            <div class="control-group">
		<?php echo CHtml::activeTextField($model, '['.$i.']pengajuanpettydet_qty',array('class'=>'form-control qty required numbers-only', 'onkeyup' => 'setNumbersOnly(this);hitungTot();', 'style'=>'text-align:right;', 'maxlength'=>4));?>	
            </div>
            
	</td>	
	<td style="text-align: center;">
            <div class="control-group">
		<?php echo CHtml::activeTextField($model, '['.$i.']pengajuanpettydet_hargasatuan',array('class'=>'form-control hargasatuan required integer2', 'style'=>'text-align:right;',  'onkeyup' => 'hitungTot();'));?>	
            </div>
            
	</td>	
	<td style="text-align: center;">
		<?php echo CHtml::activeTextArea($model, '['.$i.']pengajuanpettydet_keterangan',array('readonly'=>false,'class'=>'form-control keterangan autogrow'));?>	
	</td>	
	<td style="text-align: center;">
		<div class="control-group">
			<?php echo CHtml::activeTextField($model, '['.$i.']pengajuanpettydet_subtotal',array('class'=>'form-control subtotal required integer2', 'style'=>'text-align:right;', 'readonly'=>true));?>	
		</div>	
	</td>	
</tr>