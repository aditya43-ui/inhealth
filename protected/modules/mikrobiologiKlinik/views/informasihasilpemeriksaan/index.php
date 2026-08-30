<?php
/**
 * Halaman ini digunakan untuk menampilkan informasi SIP
 * @author Aida Rahmawati <aidarahmawati@.com>
 */

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#daftarpasien-t-search').submit(function(){
            $.fn.yiiGridView.update('daftarpasien-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Hasil Pemeriksaan</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Hasil Pemeriksaan</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: auto; max-width: 100%">
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'daftarpasien-t-grid',
                            'dataProvider' => $model->searchMikro(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                ),
                                array(
                                    'header' => 'Tgl. Pemeriksaan',
                                    'name' => 'tgl_pemeriksaan',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pemeriksaan',
                                ),
                                array(
                                    'header' => 'No. Lab',
                                    'name' => 'no_lab',
                                    'type' => 'raw',
                                    'value' => '$data->no_lab',
                                ),
                               
                                array(
                                    'header' => 'Nama Pasien',
                                    'type' => 'raw',
                                    'value' => '$data->nama_pasien',
                                ),
                                array(
                                    'name' => 'no_rekam_medik',
                                    'type' => 'raw',
                                    'header' => 'No. RM',
                                    'value' => '$data->no_rekam_medik',
                                ),
                                array(
                                    'header' => 'DPJP',
                                    'type' => 'raw',
                                    'value' => '$data->nama_pegawai',
                                ),
                                array(
                                    'header' => 'Jenis Spesimen',
                                    'type' => 'raw',
                                    'value' => '$data->samplelab_nama',
                                ),
            
                                array(
                                    'header' => 'Jenis Pemeriksaan',
                                    'type' => 'raw',
                                    'value' => '$data->daftartindakan_nama',
                                ),
                                array(
                                    'header' => 'Pemeriksaan',
                                    'type' => 'raw',
                                    'value' => function($data){

                                        if($data->is_pemeriksaankultur == true){
                                            echo '<button class="btn btn-primary">Kultur Langsung</button>';
                                        }else if ($data->is_pemeriksaanpewarnaan == true){
                                            echo '<button class="btn btn-success">Pewarnaan Langsung</button>';
                                        }else if ($data->is_pemeriksaancci == true){
                                            echo '<button class="btn btn-success">CCI Langsung</button>';
                                        }else if ($data->is_pemeriksaanpcr == true){
                                            echo '<button class="btn btn-success">PCR Langsung</button>';
                                        }else if ($data->is_pemeriksaanviralload == true){
                                            echo '<button class="btn btn-success">Viral Load Langsung</button>';
                                        }else if ($data->is_pemeriksaanviralload == true){
                                            echo '<button class="btn btn-success">TBC Langsung</button>';
                                        }else{
                                            echo '';
                                        }
                                    }
                                ),
                               
                                array(
                                    'header' => 'Cara Bayar',
                                    'type' => 'raw',
                                    'value' => '$data->carabayar_nama',
                                ), 
                                
                                array(
                                    'header' => 'Status Kirim Hasil',
                                    'type' => 'raw',
                                    'value' => function($data){

                                        if($data->status_kirim == "Sudah Kirim"){
                                            echo '<button class="btn btn-primary">Sudah Kirim</button>';
                                        }else{
                                            echo  '<button class="btn btn-primary">Belum Kirim</button>';
                                        }
                                    }
                                ),

                                array(
                                    'header' => 'Isi Hasil',
                                    'name' => 'masukanHasil',
                                    'type' => 'raw',
                                    'value' => function ($data) use ($module, $controller) {
        
                                        $str = "";
        
                                        if (!empty($data->tgl_pasiendatang)){
                                          //  echo $data->tgl_pasiendatang;
                                           $str .= CHtml::link("<i class=icon-form-input></i>", Yii::app()->controller->createUrl('/' . $module . '/' . $controller . '/hasilPemeriksaan', array("pendaftaran_id" => $data->pendaftaran_id, "pasien_id" => $data->pasien_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk memasukkan hasil"));
                                       
                                        } else{
                                           // echo $data->tgl_pasiendatang;
                                           $str .= CHtml::link("<i class=icon-form-input></i>", 'javascript:void(0);', array("rel" => "tooltip", "title" => "Klik untuk memasukkan hasil", 'onclick' => 'myAlert("Klik verifikasi kedatangan pasien terlebih dahulu")'));
                                            
                                        }
        
                                    
                                        return $str;
                                    },
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                ),

                                array(
                                    'header' => 'Isi Hasil',
                                    'name' => 'masukanHasil',
                                    'type' => 'raw',
                                    'value' => function ($data) use ($module, $controller) {
        
                                        $str = "";
        
                                        if (!empty($data->tgl_pasiendatang)){
                                          //  echo $data->tgl_pasiendatang;
                                           $str .= CHtml::link("<i class=icon-form-input></i>", Yii::app()->controller->createUrl('/' . $module . '/' . $controller . '/hasilPemeriksaan', array("pendaftaran_id" => $data->pendaftaran_id, "pasien_id" => $data->pasien_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk memasukkan hasil"));
                                       
                                        } else{
                                           // echo $data->tgl_pasiendatang;
                                           $str .= CHtml::link("<i class=icon-form-input></i>", 'javascript:void(0);', array("rel" => "tooltip", "title" => "Klik untuk memasukkan hasil", 'onclick' => 'myAlert("Klik verifikasi kedatangan pasien terlebih dahulu")'));
                                            
                                        }
        
                                    
                                        return $str;
                                    },
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                ),
                                array(
                                    'header' => 'Lihat Hasil',
                                    'type' => 'raw',
                                    'value' => function ($data) {
        
                                        $html = "";
        
                                        $html .= CHtml::link("<i class=icon-form-print></i> Pemeriksaan", "javascript:printLabel(" . $data->pendaftaran_id . ");", array("rel" => "tooltip", "title" => "Klik untuk print label pasien"));
                                        return $html;
                                    },
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                ),

                            ),  
                           
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        ?>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> <b> Pencarian </b> </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php
                                $this->renderPartial($this->path_view.'_search', array(
                                    'model' => $model,
                                ));
                                ?>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrint = Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printStatus', array('pendaftaran_id' => ''));
 
$js = <<< JSCRIPT
    function cekForm(obj){
            $("#suratsponsor-r-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
            window.open("${urlPrint}/"+$('#suratsponsor-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>

    <?php
// Dialog dokter DPJTM =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokterDPJTM',
    'options' => array(
        'title' => 'Ubah DPJTM',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 950,
        'minHeight' => 450,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid'); }",
    ),
));
?>
    <iframe src="" name="iframeUbahDokterDPJTM" width="100%" height="500">
    </iframe>

    <?php
$this->endWidget();
//========= end Ubah Dokter =============================
?>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                    'id' => 'dialogRincian',
                    'options' => array(
                        'title' => 'Rincian Tagihan Pasien',
                        'autoOpen' => false,
                        'modal' => true,
                        'width' => 900,
                        'height' => 600,
                        'resizable' => false,
                    ),
                ));
                ?>
    <iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>