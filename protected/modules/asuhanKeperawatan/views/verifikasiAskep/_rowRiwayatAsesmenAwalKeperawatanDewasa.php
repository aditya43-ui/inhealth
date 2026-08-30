<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'riwayatasesmenawal-keperawatan-dewasa',
    'dataProvider'=>$modRiwayatAwalKeperawatanDewasa->searchRiwayatByPendaftaran(),
    'filter'=>$modRiwayatAwalKeperawatanDewasa,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
            array(
                'header' => 'Tanggal Pemeriksaan',
                'value' => '!empty($data->tgl_pemeriksaan)?MyFormatter::formatDateTimeForUser($data->tgl_pemeriksaan):""'
            ),
            array(
                'header' => 'Keluhan Utama',
                'value' => '$data->keluhanutama'
            ),
            array(
                'header' => 'Berat Badan',
                'value' => '$data->beratbadan." kg"'
            ),
            array(
                'header' => 'Tinggi Badan',
                'value' => '$data->tinggibadan." cm"'
            ),
            array(
                'header' => 'Tensi',
                'type' => 'raw',
                'value' => function($data){
                    echo $data->tekanandarah_sistolik.' / '.$data->tekanandarah_diastolik;
                }
            ),  
            array(
                'header' => 'Nadi',
                'value' => '$data->nadi'
            ),
            array(
                'header' => 'GCS',
                'value' => '$data->gcs_total'
            ),
            array(
                'header' => 'Psikologis',
                'type' => 'raw',
                'value' => function($data){
                    if($data->psikologis_tenang == true){
                        echo 'Tenang';
                    }elseif($data->psikologis_cemas == true){
                        echo 'Cemas';
                    }elseif($data->psikologis_takut == true){
                        echo 'Takut';
                    }elseif($data->psikologis_marah == true){
                        echo 'Marah';
                    }elseif($data->psikologis_sedih == true){
                        echo 'Sedih';
                    }elseif(!empty($data->psikologis_lainnya)){
                        echo $data->keterangan_psikologislainnya;
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
                    return CHtml::Link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("/asuhanKeperawatan/pengkajianAskep/DetailKeperawatanDewasa",array("id"=>$data->asesmenawalkeperawatan_rj_id)),
                        array("class"=>"", 
                            "target"=>"frameDetailDewasa",
                            "onclick"=>"$('#dialogDetailDewasa').dialog('open');",
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
	'id'=>'dialogDetailDewasa',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Riwayat Rincian Pemeriksaan Awal Keperawatan',
		'autoOpen'=>false,
		'minWidth'=>1200,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetailDewasa" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>