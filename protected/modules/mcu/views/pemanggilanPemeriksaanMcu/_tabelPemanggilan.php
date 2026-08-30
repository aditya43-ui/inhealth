<?php 
echo CHtml::css('#isiScroll{max-height:300px;overflow-y:scroll;margin-bottom:10px;}'); 
?>
<div class="span12">
	<div id='isiScroll'>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'pemanggilanmcu-v-grid',
			'dataProvider'=>$modPemanggilanMcu->searchPemanggilanMcu(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-condensed',
			'columns'=>array( 
                                        array(
						'header'=> 'Panggil Pasien ',
						'type'=>'raw',
						'value'=>'
							CHtml::hiddenField(\'MCPemanggilanmcuV[\'.$data->pendaftaran_id.\'][pendaftaran_id]\',$data->pendaftaran_id).
							CHtml::hiddenField(\'MCPemanggilanmcuV[\'.$data->pendaftaran_id.\'][pasien_id]\',$data->pasien_id).
							CHtml::hiddenField(\'MCPemanggilanmcuV[\'.$data->pendaftaran_id.\'][ruangan_id]\',$data->ruangan_id).
							CHtml::checkBox(\'MCPemanggilanmcuV[\'.$data->pendaftaran_id.\'][cekList]\', true, array(\'class\'=>\'cekList\', \'onclick\'=>\'getTotal();setNol(this);\'));
							',
					),
					array(
						'header'=>'No.',
						'type'=>'raw',
						'value'=>'$row+1',
					),
					array(
						'header'=>'Tgl. Rencana MCU',
						'type'=>'raw',
						'value'=>'isset($data->tglrenkontrol) ? MyFormatter::formatDateTimeForUser($data->tglrenkontrol) : ""',
					),
					array(
						'header'=>'No. Rekam Medik',
						'type'=>'raw',
						'value'=>'isset($data->no_rekam_medik) ? $data->no_rekam_medik : ""',
					),
					array(
						'header'=>'Nama Pasien',
						'type'=>'raw',
						'value'=>'isset($data->nama_pasien) ? $data->nama_pasien : ""',
					),
					array(
						'header'=>'Pemanggilan Pasien',
						'type'=>'raw',
						'value'=>'isset($data->pemanggilanke) ? $data->pemanggilanke : ""',
					),
					array(
						'header'=>'Status Pasien',
						'type'=>'raw',
						'value'=>'isset($data->keterangan_pemanggilan) ? $data->keterangan_pemanggilan : ""',
					),
					array(
						'header'=>'Status Hubungan',
						'type'=>'raw',
						'value'=>'$data->status_hubungan',
					),
					
			),
			'afterAjaxUpdate'=>'function(id, data){
				jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
					}',
		)); ?> 
	</div>
</div>