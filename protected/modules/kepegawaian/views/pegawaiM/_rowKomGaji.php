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
			<?php echo CHtml::activeHiddenField($model, '['.$i.']komponengajipegawai_id',array('class'=>'form-control komponenid'));?>
            <div class="control-group">
				<?php echo CHtml::textField('noUrut', 1,array('class'=>'no-urut','style'=>'width:30px;text-align:left;','readonly'=>true));?>	
			</div>	
	</td>
	<td style="text-align: center;">
		<div class="control-group">
			<?php echo CHtml::activeDropDownList($model, '['.$i.']komponengaji_id',$model->getDropKomponenGaji(),array('class'=>'form-control komponengaji required','empty'=>'-- Pilih --', 'onchange' => 'cekKomponen(this);'));?>	
		</div>            
	</td>
	<td>
		<div class="control-group">
			<?php echo CHtml::activeTextField($model, '['.$i.']tipekomponen',array('class'=>'form-control tipekomponen','readonly'=>true));?>	
		</div>
	</td>
	<td>
		<div class="control-group">
			<?php echo CHtml::activeTextField($model, '['.$i.']jeniskomponen',array('class'=>'form-control jeniskomponen','readonly'=>true));?>	
		</div>
	</td>
	<td>
		<div class="control-group">
			<?php echo CHtml::activeTextField($model, '['.$i.']nilaigaji',array('class'=>'form-control nilaigaji integer2',));?>	
		</div>
	</td>	
	<td style="text-align: center;" class="rowbutton">		
		<?php echo CHtml::link('<i class="entypo-minus"></i>', 'javascript:;', array('class' => 'btn btn-default','onclick'=>'hapusLookup(this)', "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"", "data-original-title"=>"Klik icon ini, jika Anda ingin menghapus baris ini", "data-html" => true)); ?>
	</td>
</tr>