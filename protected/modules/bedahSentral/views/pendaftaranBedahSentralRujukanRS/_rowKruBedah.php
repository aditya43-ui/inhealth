<?php 
/**
* - digunakan untuk menambah kru bedah
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
 ?>	
	
<div class="control-group pelaksanaoperasi">
		<?php echo CHtml::label(($length == 0)?ucwords(strtolower($model->krubedah)):'', '', array('class' => 'control-label gantilabel', )) ?>
		<div class="controls">
			<?php echo CHtml::activeHiddenField($model, "[".$i."]pelaksanaoperasi_id",array()); ?>
			<?php echo CHtml::activeHiddenField($model, "[".$i."]krubedah",array()); ?>
			<?php echo CHtml::activeHiddenField($model, "[".$i."]pegawai_id",array('class' => 'krubedah_id')); ?>
			<?php echo CHtml::activeTextField($model, "[".$i."]pegawai_nama", array('readonly' => true, 'class'=>'col-sm-12 krubedah_nama'));?>
			<?php /*$this->widget('MyJuiAutoComplete',array(							
					'model'=> $model,
					'attribute'=>"[".$i."]pegawai_nama",			
					'sourceUrl'=> $this->createUrl('/ActionAutoComplete/PegawaiRuangan'),
					'options'=>array(
						   'showAnim'=>'fold',
						   'minLength' => 0,
						   'focus'=> 'js:function( event, ui ) {
									$(this).val( ui.item.label);
									return false;
							}',
							'select'=>'js:function( event, ui ) {
									$("#'.CHtml::activeId($model, '['.$i.']pegawai_id').'").val( ui.item.value );																		
									return false;
								 }',
						),'htmlOptions' => array('readonly' => true, 'class'=>'col-sm-8')
			));*/ ?>
			<?php 

				//echo CHtml::dropDownList("lookupKruBedah",'' ,LookupM::getItemsUrutan('krubedah'), array('empty'=>'-- Pilih --')); 
			?>
		</div>
			<div class="controls">
				<?php 
					if (empty($model->pelaksanaoperasi_id )){
						echo CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>",'javascript:;',array('onclick'=>'removeData(this,\''.ucwords(strtolower($model->krubedah)).'\')', 'class'=>'btn btn-danger'));
					}else{
						echo CHtml::link("<i class='".MyIcon::getIcons('hapus-baris')."'></i>",'javascript:;',array('onclick'=>'removeDataFromDb(this,\''.ucwords(strtolower($model->krubedah)).'\')', 'class' => 'btn btn-default', 'krubedah_id' => $model->pelaksanaoperasi_id));
					}
				?>
			</div>
</div>	
	
	

