<?php
Yii::app()->clientScript->registerScript('search', "
    $('#pengirimankantongdarah-r-search').submit(function(){
        $.fn.yiiGridView.update('pengirimankantongdarah-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Pengiriman Kantong Darah</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Pengiriman Kantong Darah</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'pengirimankantongdarah-r-grid',
                            'dataProvider' => $model->searchInformasi(),
                            'replaceUrl'=>true,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header'=>'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                : ($row+1)',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                ),
                                array(
                                    'header'=>'Nomor Pengiriman',
                                    'value'=>function($data){
                                        echo $data->no_kirimkantong;
                                    },
                                ),
                                array(
                                    'header'=>'Ruangan Asal',
                                    'value'=>function($data){
                                        echo $data->ruangankirim_nama;
                                    },
                                ),
                                array(
                                    'header'=>'Waktu Pengiriman',
                                    'value'=>function($data){
                                        echo MyFormatter::formatDateTimeForUser($data->tglkirimkantongdarah);
                                    },
                                ),
                                array(
                                    'header'=>'Suhu Pengiriman',
                                    'value'=>function($data){
                                        echo $data->suhu_kirim;echo' ℃';
                                    },
                                ),
                                array(
                                    'header'=>'Petugas Pengiriman',
                                    'value'=>function($data){
                                        echo $data->petugaskirim_nama;
                                    },
                                ),
                                array(
                                    'header'=>'Status Pengiriman',
                                    'value'=>function($data){
                                        if($data->isterima == true){
                                            echo 'Sudah Diterima';
                                        }else{
                                            echo 'Belum Diterima';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'Detail Pengiriman <br> Kantong Darah ',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        return CHtml::Link("<span style='font-size:17px'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("detail",array("id"=>$data->kirimkantongdarah_id)),
                                            array("class"=>"", 
                                                "target"=>"frameDetail",
                                                "onclick"=>"$('#dialogDetail').dialog('open');",
                                                "rel"=>"tooltip",
                                                'data-placement'=>'left',
                                                "title"=>"Klik untuk melihat rincian penerimaan kantong darah",
                                            ));
                                        
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Penerimaan Kantong Darah',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        $terima = TerimakantongdarahT::model()->findByAttributes(array(
                                            'kirimkantongdarah_id'=>$data->kirimkantongdarah_id,
                                        ));
                                        
//                                        if (!empty($terima)) {
//                                            return CHtml::link('<i style="font-size:20px" class="entypo-doc-text"></i>', Yii::app()->controller->createUrl('informasiPenerimaanDarah/lihatDetail', array('terimakantongdarah_id'=>$terima->terimakantongdarah_id)), array(
//                                                'rel'=>'tooltip',
//                                                'title'=>'Klik Untuk Melihat detail Penerimaan Kantong Darah',
//                                                'target'=>'frameDetailTerima',
//                                                'onclick'=>'$("#dialogDetailTerima").dialog("open");',
//                                            ));
//                                        }
                                        
                                        // if (Yii::app()->user->getState('ruangan_id') == $data->ruangantujuan_id){
                                            if (!empty($terima)){
                                                return CHtml::link('<i style="font-size:20px" class="entypo-down-circled"></i>', Yii::app()->controller->createUrl('PenerimaanKantongDarah/index', array('terimakantongdarah_id'=>$terima->terimakantongdarah_id,'kirimkantongdarah_id'=>$data->kirimkantongdarah_id,'frame'=>true)), array(
                                                    'rel'=>'tooltip',
                                                    'title'=>'Klik Untuk Menerima Kantong Darah',
                                                ));
                                            }else{
                                                return CHtml::link('<i style="font-size:20px" class="entypo-down-circled"></i>', Yii::app()->controller->createUrl('PenerimaanKantongDarah/index', array('kirimkantongdarah_id'=>$data->kirimkantongdarah_id,'frame'=>true)), array(
                                                    'rel'=>'tooltip',
                                                    'title'=>'Klik Untuk Menerima Kantong Darah',
                                                ));
                                            }
                                        /* }else{
                                            return CHtml::link('<i style="font-size:20px" class="entypo-down-circled"></i>', 'javascript:;', array(
                                                'rel'=>'tooltip',
                                                'title'=>'Klik Untuk Menerima Kantong Darah',
                                                'onclick'=>'cekRuangan("'.$data->ruangantujuan_nama.'"); return false;',
                                            ));
                                        } */
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                                array(
                                    'header'=>'Batal Pengiriman',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        $terima = TerimakantongdarahT::model()->findByAttributes(array(
                                            'kirimkantongdarah_id'=>$data->kirimkantongdarah_id,
                                        ));
                                        
                                        if (!empty($terima)) {
                                            return "-";
                                        }
                                        
                                        return CHtml::link('<i style="font-size:20px" class="glyphicon glyphicon-remove"></i>', '#', array(
                                            'width'=>'23px',
                                            'height'=>'23px',
                                            'rel'=>'tooltip',
                                            'data-placement'=>'left',
                                            'title'=>'Klik untuk membatalkan pengiriman',
                                            'onclick'=>'batalKirim(this, '.$data->kirimkantongdarah_id.'); return false;'
                                        ));
                                    },
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        ?>                            
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial('_search',array(
                                    'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>        
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint1=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Informasiprint',array('permohonanpengirimankantongdarahluar_id'=>''));
    $urlPrint2=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Informasiprintluar',array('permohonanpengirimankantongdarahluar_id'=>''));
    // $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Printinformasi');

?>>
<?php 
// Dialog untuk Lihat Hasil =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogDetailmonitoring',
        'options'=>array(
                'title'=>'Detail Monitoring',
                'autoOpen'=>false,
                'modal'=>true,
                'minWidth'=>1100,
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

// Dialog untuk Lihat Detail Terima =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogDetailTerima',
        'options'=>array(
                'title'=>'Detail Penerimaan Kantong Darah',
                'autoOpen'=>false,
                'modal'=>true,
                'minWidth'=>1100,
                'minHeight'=>450,
                'resizable'=>true,
        ),
));
?>
<iframe src="" name="frameDetailTerima" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
//========= end Lihat Detail Terima =============================
?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetail',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Rincian Pengiriman Kantong Darah',
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
<script>
    function cekRuangan(ruangan) {
        
       myAlert("Anda harus login ke ruangan <b>"+ruangan+"</b>");
        
    }
    
    function batalKirim(obj, id) {
        myConfirm('Apakah anda yakin untuk membatalkan pengiriman kantong darah ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalKirim'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('pengirimankantongdarah-r-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>