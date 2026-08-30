<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'riwayatasesmenawal-kebidanan',
    'dataProvider'=>$modRiwayatAwalKebidanan->searchRiwayatByPendaftaran(),
    'filter'=>$modRiwayatAwalKebidanan,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
           
            array(
                'header' => 'Tanggal Pemeriksaan',
                'value' => '!empty($data->create_time)?MyFormatter::formatDateTimeForUser($data->create_time):""'
            ),
            array(
                'header'=>'Data Subyektif',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value'=>function($data){
                    return CHtml::Link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("/asuhanKeperawatan/pengkajianAskep/DetailKebidanan1",array("id"=>$data->asesmenawalkebidanan_bidan_id)),
                        array("class"=>"", 
                            "target"=>"frameDetailKebidanan1",
                            "onclick"=>"$('#dialogDetailKebidanan1').dialog('open');",
                            "rel"=>"tooltip",
                            'data-placement'=>'left',
                            "title"=>"Klik untuk melihat detail asesmen awal kebidanan - data subyektif",
                        ));
                },
            ),
            array(
                'header'=>'Data Obyektif',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value'=>function($data){
                    return CHtml::Link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("/asuhanKeperawatan/pengkajianAskep/DetailKebidanan2",array("id"=>$data->asesmenawalkebidanan_bidan_id)),
                        array("class"=>"", 
                            "target"=>"frameDetailKebidanan2",
                            "onclick"=>"$('#dialogDetailKebidanan2').dialog('open');",
                            "rel"=>"tooltip",
                            'data-placement'=>'left',
                            "title"=>"Klik untuk melihat detail asesmen awal kebidanan -  data oyektif",
                        ));
                },
            ),
            array(
                'header'=>'Prosedur Invasif',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value'=>function($data){
                    return CHtml::Link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("/asuhanKeperawatan/pengkajianAskep/DetailKebidanan3",array("id"=>$data->asesmenawalkebidanan_bidan_id)),
                        array("class"=>"", 
                            "target"=>"frameDetailKebidanan3",
                            "onclick"=>"$('#dialogDetailKebidanan3').dialog('open');",
                            "rel"=>"tooltip",
                            'data-placement'=>'left',
                            "title"=>"Klik untuk melihat detail asesmen awal kebidanan - prosedur invasif",
                        ));
                },
            ),
            array(
                'header'=>'Kontrol Risiko Infeksi dan Eliminasi',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'value'=>function($data){
                    return CHtml::Link("<span style='font-size:15px;'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("/asuhanKeperawatan/pengkajianAskep/DetailKebidanan4",array("id"=>$data->asesmenawalkebidanan_bidan_id)),
                        array("class"=>"", 
                            "target"=>"frameDetailKebidanan4",
                            "onclick"=>"$('#dialogDetailKebidanan4').dialog('open');",
                            "rel"=>"tooltip",
                            'data-placement'=>'left',
                            "title"=>"Klik untuk melihat detail asesmen awal kebidanan - kontrol risiko infeksi dan eliminasi",
                        ));
                },
            ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

// ===========================Dialog Detail1=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetailKebidanan1',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Riwayat Rincian Pemeriksaan Awal Kebidanan - Data Subyektif',
		'autoOpen'=>false,
		'minWidth'=>1200,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetailKebidanan1" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
  

// ===========================Dialog Detail2=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetailKebidanan2',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Riwayat Rincian Pemeriksaan Awal Kebidanan - Data Obyektif',
		'autoOpen'=>false,
		'minWidth'=>1000,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetailKebidanan2" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
   

// ===========================Dialog Detail3=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetailKebidanan3',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Riwayat Rincian Pemeriksaan Awal Kebidanan - Prosedur Invasif',
		'autoOpen'=>false,
		'minWidth'=>1000,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetailKebidanan3" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
     
// ===========================Dialog Detail4=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetailKebidanan4',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Riwayat Rincian Pemeriksaan Awal Kebidanan - Kontrol Risiko Infeksi dan Eliminasi',
		'autoOpen'=>false,
		'minWidth'=>1030,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetailKebidanan4" style="width: 100%; height: 98%;"></iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>