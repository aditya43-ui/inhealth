<?php
/**
* - digunakan sebagai informasi penerimaan kantong darah
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>


<?php

Yii::app()->clientScript->registerScript('search', "
    $('#penerimaankantongdarah-r-search').submit(function(){
        $.fn.yiiGridView.update('penerimaankantongdarah-r-grid', {
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
                <div class="panel-title">Informasi <strong>Penerimaan Kantong Darah</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Penerimaan Kantong Darah</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'penerimaankantongdarah-r-grid',
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
                                        if($data->ruangankirim_id != NULL){
                                            $ruangan = RuanganM::model()->findByPk($data->ruangankirim_id);
                                            echo 'Ruangan '.$ruangan->ruangan_nama;
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'Waktu Penerimaan',
                                    'value'=>function($data){
                                        echo MyFormatter::formatDateTimeForUser($data->tglterimakantong);
                                    },
                                ),
                                array(
                                    'header'=>'Suhu',
                                    'value'=>function($data){
                                        echo $data->suhu_terima."<sup>o</sup>C";
                                    },
                                ),
                                array(
                                    'header'=>'Petugas Penerima',
                                    'value'=>function($data){
                                        if($data->pegawaiterima_nama != NULL){
                                            echo $data->pegawaiterima_nama;
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'Detail',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
                                    'value'=>function($data){
                                        return CHtml::Link("<span style='font-size:17px'><i class='".MyIcon::getIcons('lihat2')."'></i></span>",Yii::app()->controller->createUrl("lihatDetail",array("terimakantongdarah_id"=>$data->terimakantongdarah_id,"detail"=>'detail')),
                                            array("class"=>"", 
                                                "target"=>"frameDetail",
                                                "onclick"=>"$('#dialogDetail').dialog('open');",
                                                "rel"=>"tooltip",
                                                'data-placement'=>'left',
                                                "title"=>"Klik untuk melihat rincian penerimaan kantong darah",
                                            ));
                                    },
                                ),
                                array(
                                    'header'=>'Batal',
                                    'type'=>'raw',
                                    'value'=>function($data) {
                                        return CHtml::link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
                                            'onclick'=>'batalTerima(this, '.$data->terimakantongdarah_id.'); return false;',
                                            'width'=>'23px',
                                            'height'=>'23px',
                                            'rel'=>'tooltip',
                                            'data-placement'=>'left',
                                            'title'=>'Klik untuk membatalkan penerimaan.',
                                        ));
                                    },
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
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
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogDetailsPerizinan',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Rincian Perizinan Sponsorship',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false    
     ),
));
?>
<iframe src="" name="iframe" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>
<?php
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogVerifikasiKabag',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Verifikasi Ka.Bid / Ka.Bag',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('penerimaankantongdarah-r-grid', {
            data: $('#penerimaankantongdarah-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>
<?php
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogVerifikasiPeg',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Verifikasi Kepegawaian',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>500,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('penerimaankantongdarah-r-grid', {
            data: $('#penerimaankantongdarah-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe2" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint1=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Informasiprint',array('permohonanpenerimaankantongdarahluar_id'=>''));
    $urlPrint2=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Informasiprintluar',array('permohonanpenerimaankantongdarahluar_id'=>''));
    // $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Printinformasi');

?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetail',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Rincian Penerimaan Kantong Darah',
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
function print1(permohonanpenerimaankantongdarahluar_id){
        window.open('<?php echo $urlPrint1?>'+permohonanpenerimaankantongdarahluar_id,'printwin','left=400,top=400,width=800,height=600');
    }
function print2(permohonanpenerimaankantongdarahluar_id){
    window.open('<?php echo $urlPrint2?>'+permohonanpenerimaankantongdarahluar_id,'printwin','left=400,top=400,width=800,height=600');
}
function batalIzin(id) {
    myConfirm('Apakah anda yakin untuk membatalkan perizinan ini ?', 'Perhatian!', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('BatalIzin'); ?>', {id: id}, function(data) {
                if (data.sukses==1) {
                    myAlert(data.pesan);
                    $.fn.yiiGridView.update('penerimaankantongdarah-r-grid');
                } else {
                    myAlert(data.pesan);
                }
            }, 'json');
        }
    });
}

function batalTerima(obj, id) {
    myConfirm('Apakah anda yakin untuk membatalkan penerimaan kantong darah ini ?', 'Perhatian!', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('batalTerima'); ?>', {id: id}, function(data) {
                if (data.ok==1) {
                    myAlert(data.msg);
                    $.fn.yiiGridView.update('penerimaankantongdarah-r-grid');
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}

</script>