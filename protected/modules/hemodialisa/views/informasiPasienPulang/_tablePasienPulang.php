<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftarPasienPulang-grid',
	'dataProvider'=>$modPasienYangPulang->searchHD(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(	
//                'tglpasienpulang',
		array(
                    'header'=>'Tgl. Pasien Pulang',
                    'value'=>'$data->tglpasienpulang',
                ),
                array(
                    'header'=>'Cara/ Kondisi Pulang',
			'type'=>'raw',
                    'value'=>'$data->CaradanKondisiPulang'
		),
               
                array(
                    'header'=>'Tgl. Pendaftaran',
                    'value'=>'$data->tgl_pendaftaran',
	),
//                'tgladmisi',
                array(
                    'header'=>'No. Rekam Medik / <BR> No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->NoRMdanNoPendaftaran'
                ),
            
                array(
                    'header'=>'Nama / Alias',
                    'type'=>'raw',
                    'value'=>'$data->NamadanNamaBIN'
                ),    
//                'umur',
//                 array(
//                       'header'=>'Jenis Penjamin / Penjamin',
//                        'type'=>'raw',
//                        'value'=>'$data->CaraBayardanPenjamin'
//                    ),
                array(
                    'header'=>'Kelas Pelayanan',
                    'type'=>'raw',
                    'value'=>'$data->KelasPelayanan'
                ),   
                array(
                    'header'=>'Nama Jenis Kasus Penyakit',
                    'value'=>'$data->jeniskasuspenyakit_nama',
                ),
//                'jeniskasuspenyakit_nama',

//                array(
//                       'header'=>'Batal Pulang',
//                       'type'=>'raw',
//                       'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ","javascript:cekHakAkses($data->pasienpulang_id,$data->pasienadmisi_id,$data->pasien_id,$data->pendaftaran_id)" ,array("title"=>"Klik Untuk Membatalkan Kepulangan"))',
//                    ),
                array(
                       'header'=>'Batal Pulang',
                       'type'=>'raw',
                       'value'=>'CHtml::link("<i class=\'icon-remove\'></i>", 
                           Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/batalPulang",array("pendaftaran_id"=>$data->pendaftaran_id)),
                               array("title"=>"Klik untuk Batal Pulang", "target"=>"iframeBatalPulang", "onclick"=>"$(\"#dialogBatalPulang\").dialog(\"open\");", "rel"=>"tooltip"))',
                       'htmlOptions'=>array('style'=>'text-align: center; width: 60px;'),
                    ),
              
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
echo CHtml::hiddenField('pasien_id','',array('readonly'=>TRUE));
echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>TRUE));
?>
