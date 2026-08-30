<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'riwayatasesmenawal-keperawatan-anak',
    'dataProvider'=>$modRiwayatAwalKeperawatanAnak->searchRiwayatByPendaftaran(),
    'filter'=>$modRiwayatAwalKeperawatanAnak,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
            array(
                'header' => 'Tanggal Pemeriksaan',
                'value' => '!empty($data->waktu_pemeriksaan)?MyFormatter::formatDateTimeForUser($data->waktu_pemeriksaan):""'
            ),
            array(
                'header' => 'Diagnosis Masuk',
                'value' => function($data){
                    $diagnosa = $data->diagnosa_masuk;
                    $cekDiagnosa = DiagnosaM::model()->findByPk($diagnosa);
                    echo !empty($cekDiagnosa) ? $cekDiagnosa->diagnosa_nama : '';
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
                'header' => 'Suhu',
                'type' => 'raw',
                'value' => '$data->sirkulasi_suhu." <sup>o</sup>C"'
            ),
            array(
                'header' => 'Respiration Rate',
                'value' => '$data->pernafasan_respiratorrate'
            ),
            array(
                'header'=>'Detail',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value'=>function($data){
                    return CHtml::Link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("/asuhanKeperawatan/pengkajianAskep/DetailKeperawatanAnak",array("id"=>$data->asesmen_awal_keperawatan_anak_id)),
                        array("class"=>"", 
                            "target"=>"frameDetailAnak",
                            "onclick"=>"$('#dialogDetailanak').dialog('open');",
                            "rel"=>"tooltip",
                            'data-placement'=>'left',
                            "title"=>"Klik untuk melihat detail asesmen awal anak",
                        ));
                },
            ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
                
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetailanak',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Riwayat Rincian Pemeriksaan Awal Keperawatan Anak',
		'autoOpen'=>false,
		'minWidth'=>1100,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetailAnak" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>