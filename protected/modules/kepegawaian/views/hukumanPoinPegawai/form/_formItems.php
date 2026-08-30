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
			<?php echo CHtml::activeHiddenField($model, '['.$i.']poinpegdet_id',array('class'=>'form-control type'));?>
            <div class="control-group">
			<?php echo CHtml::activeDropDownList($model, '['.$i.']nilaipoin_id',$model->getDropNilaiPoinAktif(),array('class'=>'form-control hurufs-only nilai required','empty'=>'-- Pilih --', 'onchange' => 'getPoin(this);'));?>	
		</div>	
	</td>
	<td style="text-align: center;">
            <div class="control-group">
		<?php echo CHtml::activeTextField($model, '['.$i.']poinpegdet_poin',array('class'=>'form-control poin required numbers-only', 'onkeyup' => 'setNumbersOnly(this);hitungTot();', 'style'=>'text-align:right;', 'maxlength'=>2));?>	
            </div>
            
	</td>	
        <td style="text-align: center;">
		<?php echo CHtml::activeTextArea($model, '['.$i.']poinpegdet_desc',array('class'=>'form-control desc autogrow', 'onkeyup' => 'setHurufsOnly(this);'));?>	
	</td>	
	<td style="text-align: center;" class="rowbutton">		
		<?php echo CHtml::link('<i class="entypo-minus"></i>', 'javascript:;', array('class' => 'btn btn-default','onclick'=>'hapusLookup(this)', "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"", "data-original-title"=>"Klik icon ini, jika Anda ingin menghapus bari ini", "data-html" => true)); ?>
	</td>
</tr>