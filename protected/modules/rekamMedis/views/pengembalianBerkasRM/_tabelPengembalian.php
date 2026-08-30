<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rkpeminjamandokumenrm-v-grid',
	'dataProvider'=>$modPengiriman->searchPengiriman(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
		array(
			'header'=> 'Pilih',
			'type'=>'raw',
			'value'=>'
				CHtml::hiddenField(\'no_urut\', 0,array(\'id\'=>\'no_urut\',\'class\'=>\'no_urut\')).
				CHtml::hiddenField(\'KembalirmT[0][dokrekammedis_id]\', $data->dokrekammedis_id).
				CHtml::hiddenField(\'KembalirmT[0][pasien_id]\', $data->pasien_id).
				CHtml::hiddenField(\'KembalirmT[0][pendaftaran_id]\', $data->pendaftaran_id).
				CHtml::hiddenField(\'KembalirmT[0][ruangan_id]\', $data->ruangan_id).
				CHtml::hiddenField(\'KembalirmT[0][peminjamanrm_id]\', $data->peminjamanrm_id).
				CHtml::hiddenField(\'KembalirmT[0][pengirimanrm_id]\', $data->pengirimanrm_id).                
				CHtml::checkBox(\'KembalirmT[0][cekList]\', false, array(\'onclick\'=>\'setUrutan(this);setLengkap(this);\', \'class\'=>\'cekList\'));
				',
		),
		array(
			'header'=> 'Lokasi Rak',
			'type'=>'raw',
			'value'=>'
				CHtml::dropDownList(\'KembalirmT[0][lokasirak_id]\', $data->lokasirak_id, CHtml::listData(LokasirakM::model()->findAll(\'lokasirak_aktif = true\'), \'lokasirak_id\', \'lokasirak_nama\'), array(\'empty\'=>\'-- Pilih\', \'class\'=>\'span1 lokasiRak\'));
				',
		),
		array(
			'header'=> 'Sub Rak',
			'type'=>'raw',
			'value'=>'
				CHtml::dropDownList(\'KembalirmT[0][subrak_id]\', $data->subrak_id, CHtml::listData(SubrakM::model()->findAll(\'subrak_aktif = true\'), \'subrak_id\', \'subrak_nama\'), array(\'empty\'=>\'-- Pilih\', \'class\'=>\'span1 subRak\'));
				',
		),
		array(
			'header'=>'Warna Dokumen',
			'type'=>'raw',
			'value'=>'$this->grid->getOwner()->renderPartial(\'_warnaDokumen\', array(\'warnadokrm_id\'=>$data->warnadokrm_id), true)',
		),
		'no_rekam_medik',
		'pendaftaran.tgl_pendaftaran',
		'no_pendaftaran',
		'nama_pasien',
		'tanggal_lahir',
		'jeniskelamin',
		'alamat_pasien',
		'instalasi_nama',
		'ruangan_nama',
		array(
			'header'=>'Kelengkapan',
			'type'=>'raw',
			'value'=>'CHtml::checkBox(\'KembalirmT[0][kelengkapan]\', \'false\', array(\'class\'=>\'lengkap\'))',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
//		array(
//			'header'=>'Print',
//			'value'=>'CHtml::checkBox("KembalirmT[0][print]", false, array("value"=>$data->dokrekammedis_id,"id"=>"print","class"=>"inputFormTabel currency span2","onkeypress"=>"return $(this).focusNextInputField(event)"))',
//			'type'=>'raw',
//		),
	),
		'afterAjaxUpdate'=>'function(id, data){
			var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
			jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
		}',
)); 
?>