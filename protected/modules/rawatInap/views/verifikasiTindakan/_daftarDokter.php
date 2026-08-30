<?php     
    $modDokter = new RIDokterV('searchDialogDokter');
    $modDokter->unsetAttributes();    
    if(isset($_GET['RIDokterV'])) {
        $modDokter->attributes = $_GET['RIDokterV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'dialogdokter-v-grid',
            'dataProvider'=>$modDokter->searchDialogDokter(),
            'filter'=>$modDokter,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
				array(
					'header'=>'Pilih',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
						"id" => "selectTindakan",
						"onClick" => "
							setDokterAuto($data->pegawai_id);
						"))',
				),
				array(
					'header'=>'Nomor Induk Pegawai',
					'name'=>'nomorindukpegawai',
					'value'=>'$data->nomorindukpegawai',
					'type'=>'raw',
				),
				array(
					'header'=>'Nama Dokter',
					'name'=>'nama_pegawai',
					'value'=>'$data->nama_pegawai',
					'type'=>'raw',
				),
				array(
					'header'=>'Jenis Kelamin',
					'name'=>'jeniskelamin',
					'value'=>'$data->jeniskelamin',
					'type'=>'raw',
				),
				array(
					'header'=>'Alamat',
					'name'=>'alamat_pegawai',
					'value'=>'$data->alamat_pegawai',
					'type'=>'raw',
				),
            ),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>
