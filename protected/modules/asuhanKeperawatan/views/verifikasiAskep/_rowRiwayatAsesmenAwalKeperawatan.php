<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'riwayatasesmenawal-keperawatan',
    'dataProvider'=>$modRiwayatAwalKeperawatan->searchRiwayatByPendaftaran(),
    'filter'=>$modRiwayatAwalKeperawatan,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
            
            array(
                'header' => 'Tanggal Pemeriksaan',
                'value' => '!empty($data->tgl_asesmen_keperawatan)?MyFormatter::formatDateTimeForUser($data->tgl_asesmen_keperawatan):""'
            ),
            array(
                'header' => 'Riwayat Kesehatan',
                'value' => '$data->riwayat_kesehatan'
            ),
            array(
                'header' => 'Kesulitan Bernafas',
                'type' => 'raw',
                'value' => function($data){
                    if($data->pernafasan_sulitbernafas_ya == true){
                        echo 'Ya';
                    }elseif($data->pernafasan_sulitbernafas_tidak == true){
                        echo 'Tidak';
                    }
                }
            ),
            array(
                'header' => 'Tensi',
                'type' => 'raw',
                'value' => function($data){
                    echo $data->sirkulasi_tensi_sistolik.' / '.$data->sirkulasi_tensi_diastolik;
                }
            ),  
            array(
                'header' => 'Nadi',
                'value' => '$data->sirkulasi_nadi'
            ),
            array(
                'header' => 'GCS',
                'value' => '$data->persarafan_total_gcs'
            ),
            array(
                'header' => 'Psikologis',
                'type' => 'raw',
                'value' => function($data){
                    if($data->persarafan_psikologis_tenang == true){
                        echo 'Tenang';
                    }elseif($data->persarafan_psikologis_cemas == true){
                        echo 'Cemas';
                    }elseif($data->persarafan_psikologis_takut == true){
                        echo 'Takut';
                    }elseif($data->persarafan_psikologis_marah == true){
                        echo 'Marah';
                    }elseif($data->persarafan_psikologis_sedih == true){
                        echo 'Sedih';
                    }elseif(!empty($data->persarafan_psikologis_lainnya)){
                        echo $data->persarafan_psikologis_lainnya;
                    }else{
                        echo '-';
                    }
                }
            ),
            array(
                'header'=>'Detail',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value'=>function($data){
                    return CHtml::Link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("/asuhanKeperawatan/pengkajianAskep/DetailKeperawatan",array("id"=>$data->asesmen_awal_keperawatan_id)),
                        array("class"=>"", 
                            "target"=>"frameDetail3",
                            "onclick"=>"$('#dialogDetail3').dialog('open');",
                            "rel"=>"tooltip",
                            'data-placement'=>'left',
                            "title"=>"Klik untuk melihat detail asesmen awal kritis",
                        ));
                },
            ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
                
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetail3',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Riwayat Rincian Pemeriksaan Awal Keperawatan',
		'autoOpen'=>false,
		'minWidth'=>1000,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetail3" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>