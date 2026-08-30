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
		<?php echo CHtml::activeHiddenField($model, '['.$i.']refhasildet_id',array('class'=>'form-control type'));?>
		<div class="control-group">
			<?php echo CHtml::activeTextField($model, '['.$i.']refhasildet_nama',array('class'=>'form-control required',  ));?>	
			
		</div>	
	</td>
	<td style="text-align: center;">
		<div class="control-group">
			<?php echo CHtml::activeDropDownList($model, '['.$i.']refhasildet_jk',  LookupM::getItems('jeniskelamin'),array('class'=>'form-control','empty'=>'-- Pilih --'));?>	
		</div>
            
	</td>		
	<td style="text-align: center;">
		<?php //$this->widget('ext.redactorjs.Redactor',array('model'=>$model,'attribute'=>'['.$i.']refhasildet_isian','toolbar'=>'mini','height'=>'100px')) ?>
		<?php echo CHtml::activeTextArea($model, '['.$i.']refhasildet_isian',array('class'=>'form-control desc autogrow'));?>	
	</td>
	<td style="text-align: center;">				
		<div class="control-group">
			<?php echo CHtml::activeTextField($model, '['.$i.']refhasildet_urut',array('class'=>'required span1', 'style'=>'text-align:right;', 'maxlength'=>2,'onkeyup' => 'setNumbersOnly(this);', ));?>				
		</div>	
	</td>
	<td style="text-align: center;">				
		<div class="control-group">
			<?php echo CHtml::activeCheckBox($model, '['.$i.']refhasildet_aktif',array('class'=>'required span1', ));?>				
		</div>	
	</td>
	<td style="text-align: center;" class="rowbutton">		
		<?php 
			if (empty($model->refhasildet_id)){
				echo CHtml::link('<i class="entypo-minus"></i>', 'javascript:;', array('class' => 'btn btn-default','onclick'=>'hapusLookup(this)', "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"", "data-original-title"=>"Klik icon ini, jika Anda ingin menghapus baris ini", "data-html" => true)); 
			}
		?>
	</td>
</tr>