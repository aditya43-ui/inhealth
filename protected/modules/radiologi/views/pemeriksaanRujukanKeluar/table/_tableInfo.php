<?php 
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'kpinfohukumanpoinpeg-v-grid',
    'dataProvider'=>$model->searchInformasi(),   
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'No.',				
            'filter' => false,
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'headerHtmlOptions' => array('style' => 'text-align:center')
        ),
        array(
            'name' => 'pemeriksaankeluar_tgl',
            'value' => 'MyFormatter::formatDateTimeForUser($data->pemeriksaankeluar_tgl)'
        ),
        array(
            'header' => 'No. Pendaftaran',
            'value' => '$data->no_pendaftaran'
        ),
        array(
            'header' => 'No. Rekam Medik',
            'value' => '$data->no_rekam_medik'
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien'
        ),
        array(
            'header' => 'Pemeriksaan',
            'value' => '$data->daftartindakan_nama'
        ),
        array(
            'name' => 'dokterpengirim_id',           
            'value' => '$data->namaLengkap'
        ),
        array(
            'name' => 'labklinikrujukan_id',            
            'value' => '$data->labklinikrujukan_nama'
        ),      
		array(
			'name' => 'pemeriksaankeluar_alasan'
		),
        /*array(
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function($data){
                return CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detail",array("id"=>$data->pasienmasukpenunjang_id)),array('rel'=>'tooltip','title'=>'Klik ikon ini, jika Anda ingin menampilkan <b>detail data permohonan cuti</b>', 'data-html'=>true,"id"=>"$data->pasienmasukpenunjang_id","target"=>"frameDetail", "onclick"=>"window.parent.$('#dialogDetail').dialog('open');"));
            }
        ),*/
    ),
   'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
)); ?>                   