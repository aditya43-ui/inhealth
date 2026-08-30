<?php 

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'monitoringsuhu-v-grid',
    'dataProvider'=>$model->searchInformasiMonitoring(),   
    'replaceUrl'=>true,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array( 
            'header'=>'Tanggal Monitoring',
            'name' => 'tgl_penggunaan_coolbox',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_penggunaan_coolbox)',
            'htmlOptions' => array('style' => ''),
            'headerHtmlOptions' => array('style' => ''),
        ), 
        array( 
            'header'=>'No. Penggunaan Coolbox',
            'name' => 'no_penggunaan_coolbox',
            'value' => '$data->no_penggunaan_coolbox',
            'htmlOptions' => array('style' => ''),
            'headerHtmlOptions' => array('style' => ''),
        ), 
        array( 
            'header'=>'Jenis Coolbox',
            'value' => function($data){
                $cek_coolbox = CoolboxdarahM::model()->findByPk($data->coolboxdarah_id);
                if(!empty($cek_coolbox)){
                    echo $cek_coolbox->coolboxdarah_nama;
                }else{
                    echo '';
                }
            },
            'htmlOptions' => array('style' => ''),
            'headerHtmlOptions' => array('style' => ''),
        ), 
         array(
            'header' => 'Detail Kantong Darah',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:17px'><i class='" . MyIcon::getIcons('lihat2') . "'></i></span>", Yii::app()->controller->createUrl("lihatDetail", array("penggunaan_coolbox_id" => $data->penggunaan_coolbox_id, "detail" => 'detail')), array("class" => "",
                            "target" => "frameDetail",
                            "onclick" => "$('#dialogDetail').dialog('open');",
                            "rel" => "tooltip",
                            'data-placement' => 'left',
                            "title" => "Klik untuk melihat rincian penerimaan kantong darah",
                ));
            },
        ),
        array(
            'header' => 'Detail Monitoring',
            'type' => 'raw',
            'value' => function($data){
                return CHtml::Link("<i class=\"entypo-box\"></i>",Yii::app()->controller->createUrl("monitoringSuhuKantongDarah/detailmonitoring",array("id"=>$data->penggunaan_coolbox_id,"tgl_penggunaan_coolbox"=>$data->tgl_penggunaan_coolbox)));
            },
            'htmlOptions' => array('style' => 'text-align:center; font-size:20px !important'),
            'headerHtmlOptions' => array('style' => ''),
        ), 
    ),
   'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
)); ?>                 

<?php 
// Dialog untuk Lihat Hasil =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogDetailmonitoring',
        'options'=>array(
                'title'=>'Detail Monitoring',
                'autoOpen'=>false,
                'modal'=>true,
                'minWidth'=>1050,
                'minHeight'=>450,
                'resizable'=>true,
        ),
));
?>
<iframe src="" name="iframeDetailmonitoring" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
//========= end Lihat Hasil =============================
?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetail',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Detail Kantong Darah',
		'autoOpen'=>false,
		'minWidth'=>900,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetail" width="100%" height="500" style="border: none;">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>