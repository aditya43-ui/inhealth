<?php
Yii::app()->clientScript->registerScript('search', "
    $('#returdarah-r-search').submit(function(){
        $.fn.yiiGridView.update('returdarah-r-grid', {
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
                <div class="panel-title">Informasi <strong>Penerimaan Darah Kembali</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Penerimaan Darah Kembali</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'returdarah-r-grid',
                            'dataProvider' => $model->searchInformasi(),
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
                                    'header'=>'Tanggal Penerimaan Darah',
                                    'value'=>function($data){
                                        if(!empty($data->tgl_retur_darah)){
                                            echo MyFormatter::formatDateTimeForUser($data->tgl_retur_darah);
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'Nama Pasien',
                                    'value'=>function($data){
                                        if(!empty($data->nama_pasien)){
                                            echo $data->nama_pasien;
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'No. Rekam Medis',
                                    'value'=>function($data){
                                        if(!empty($data->no_rekam_medik)){
                                            echo $data->no_rekam_medik;
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'Ruangan',
                                    'value'=>function($data){
                                        if(!empty($data->ruangan_nama)){
                                            echo $data->ruangan_nama;
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'No. Kantong',
                                    'value'=>function($data){
                                        if(!empty($data->no_kantongdarah)){
                                            echo $data->no_kantongdarah;
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'Jenis Darah',
                                    'value'=>function($data){
                                        if(!empty($data->jenis_komponen_darah)){
                                            echo $data->jenis_komponen_darah;
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'Golongan Darah',
                                    'value'=>function($data){
                                        if(!empty($data->gol_darah)){
                                            echo $data->gol_darah;
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'Asal Darah',
                                    'value'=>function($data){
                                        if($data->is_ruangan == true){
                                            echo 'Ruangan';
                                        }else if($data->is_bdt == true){
                                            echo 'BDT';
                                        }else if($data->is_itd = true){
                                            echo 'ITD';
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'Petugas Penerima',
                                    'value'=>function($data){
                                        if(!empty($data->petugas_penerima_nama)){
                                            echo $data->petugas_penerima_nama;
                                        }else{
                                            echo '-';
                                        }
                                    },
                                ),
                                array(
                                    'header'=>'Analisa Darah Kembali',
                                    'value'=>function($data){
                                        if(empty($data->kesimpulan) && empty($data->petugas_analisa_id)){
                                            echo CHtml::link('<i class="entypo-droplet"></i>', 
                                                    Yii::app()->controller->createUrl("AnalisaDarahKembali/index",array("returdarah_id"=>$data->returdarah_id,"link"=>"informasi"))
                                                    , array(
                                                        'rel'=>'tooltip',
                                                        'data-placement'=>'left',
                                                        'title'=>'Klik Untuk Analisa Darah Kembali',
                                                ));
                                        }else{
                                            echo CHtml::link('<i class="entypo-list"></i>', 
                                                    Yii::app()->controller->createUrl("InformasiReturDarah/detail",array("returdarah_id"=>$data->returdarah_id))
                                                    , array(
                                                        'rel'=>'tooltip',
                                                        "target"=>"iframeDetailAnalisa", 
                                                        "onclick"=>"$('#dialogDetail').dialog('open');",
                                                        'data-placement'=>'left',
                                                        'title'=>'Klik Untuk Melihat Detail Analisa Darah Kembali',
                                                ));
                                        }
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
    $urlPrint1=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Informasiprint',array('permohonanreturdarahluar_id'=>''));
    $urlPrint2=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Informasiprintluar',array('permohonanreturdarahluar_id'=>''));
    // $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Printinformasi');

?>
<?php
// ===========================Dialog Details Analisa Darah Kembali=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogDetail',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Detail Analisa Darah Kembali',
    'autoOpen'=>false,
    'width'=>1000,
    'height'=>600,
    'resizable'=>true,
    'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframeDetailAnalisa" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Analisa Darah Kembali================================
?>