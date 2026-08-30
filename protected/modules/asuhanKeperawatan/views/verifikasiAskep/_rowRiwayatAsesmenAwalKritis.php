<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'riwayatasesmenawal-kritis',
    'dataProvider'=>$modRiwayatAwalKritis->searchRiwayatByPendaftaran(),
    'filter'=>$modRiwayatAwalKritis,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
          
            array(
                'header' => 'Tanggal Pemeriksaan',
                'value' => '!empty($data->tglasesmen)?MyFormatter::formatDateTimeForUser($data->tglasesmen):""'
            ),
            array(
                'header' => 'Irama Nafas',
                'type' => 'raw',
                'value' => function($data){
                    if($data->iramanafas_teratur == true){
                        echo 'Teratur';
                    }elseif($data->iramanafas_tidakteratur == true){
                        echo 'Tidak Teratur';
                    }
                }
            ),
            array(
                'header' => 'Sesak Nafas',
                'type' => 'raw',
                'value' => function($data){
                    if($data->sesaknafas_ya == true){
                        echo 'Ya';
                    }elseif($data->sesaknafas_tidak == true){
                        echo 'Tidak, '.$data->sesaknafas_tidak_keterangan;
                    }
                }
            ),
            array(
                'header' => 'Tensi',
                'type' => 'raw',
                'value' => function($data){
                    echo $data->tensi;
                }
            ),  
            array(
                'header' => 'MAP',
                'value' => '$data->map'
            ),
            array(
                'header' => 'Nadi',
                'value' => '$data->nadi'
            ),
            array(
                'header' => 'Suhu',
                'value' => '$data->suhu'
            ),
            array(
                'header' => 'GCS',
                'value' => '$data->total_gcs'
            ),
            array(
                'header'=>'Detail',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value'=>function($data){
                    return CHtml::Link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("/asuhanKeperawatan/pengkajianAskep/Detail",array("id"=>$data->asesmenawalkritis_id)),
                        array("class"=>"", 
                            "target"=>"frameDetail2",
                            "onclick"=>"$('#dialogDetail2').dialog('open');",
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
	'id'=>'dialogDetail2',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Riwayat Rincian Pemeriksaan Awal Kritis',
		'autoOpen'=>false,
		'minWidth'=>1000,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetail2" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>