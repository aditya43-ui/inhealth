<style>
    .status {
        width: 140px;
    }
</style>
<?php

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#penerimaanspesimen-r-search').submit(function(){
            $.fn.yiiGridView.update('penerimaanspesimen-r-grid', {
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
                <div class="panel-title">Informasi <strong> Daftar Spesimen </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong> Daftar Spesimen </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'penerimaanspesimen-r-grid',
                            'replaceUrl' => true,
                            'dataProvider' => $model->SearchDaftarSpesimen(),
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
                                    'header' => 'Spesimen ID',
                                    'value' => function($data) {
                                        echo $data->no_spesimen;
                                    },
                                    'htmlOptions'=>array('style'=>'text-align: center;'),
                                    'headerHtmlOptions'=>array('style'=>'text-align: center;'),
                                ),
                                array(
                                    'header' => 'Nama Pasien',
                                    'value' => '$data->nama_pasien',
                                ),
                                array(
                                    'header' => 'No. Rekam Medik',
                                    'value' => '$data->no_rekam_medik',
                                    'htmlOptions'=>array('style'=>'text-align: center;'),
                                    'headerHtmlOptions'=>array('style'=>'text-align: center;'),
                                ),     
                                array(
                                    'header' => 'Waktu Pengambilan Spesimen',
                                    'value' => function($data) {
                                        return MyFormatter::formatDateTimeForUser($data->waktu_pengambilan_spesimen);
                                    },
                                    'htmlOptions'=>array('style'=>'text-align: center;'),
                                    'headerHtmlOptions'=>array('style'=>'text-align: center;'),
                                ),
                                 array(
                                    'header' => 'Jenis Spesimen',
                                    'value' => '$data->samplelab_nama',
 
                                ), 
                                array(
                                    'header' => 'Jenis Pemeriksaan',
                                    'value' => '$data->daftartindakan_nama',
 
                                ),
                                array(
                                    'header' => 'Status Spesimen',
                                    'value' => '$data->status',
                                    'htmlOptions'=>array('style'=>'text-align: center;'),
                                    'headerHtmlOptions'=>array('style'=>'text-align: center;'),
                                ), 
                                array(
                                    'header' => 'Status Pemeriksaan Terakhir',
                                    'value' => function($data) {
                                        if (!empty($data->status_pemeriksaan)) {
                                            if (strtolower($data->status_pemeriksaan) == "staining") {
                                                echo "<div  class='status btn btn-gold'><b>" . strtoupper($data->status_pemeriksaan) . "</b></div>";
                                            } else if (strtolower($data->status_pemeriksaan) == "culture") {
                                                echo "<div class='status btn btn-info'><b>" . strtoupper($data->status_pemeriksaan) . "</b></div>";
                                            } else if (strtolower($data->status_pemeriksaan) == "id / ast") {
                                                echo "<div class='status btn btn-danger'><b>" . strtoupper($data->status_pemeriksaan) . "</b></div>";
                                            } else if (strtolower($data->status_pemeriksaan) == "selesai") {
                                                echo "<div class='status btn btn-success'><b>" . strtoupper($data->status_pemeriksaan) . "</b></div>";
                                            }
                                        } else {
                                            echo "<div class='status btn btn-primary'><b>BELUM DIPERIKSA</b></div>";
                                        }
                                    },
                                    'htmlOptions'=>array('style'=>'text-align: center;'),
                                    'headerHtmlOptions'=>array('style'=>'text-align: center;'),
                                ),
                                array(
                                    'header' => 'Staining',
                                    'type' => 'raw',
                                    'value' => function($data){
                                        return CHtml::link("<span style='font-size:17px'> <i class ='icon-medical-gelas'> </i></span>", Yii::app()->createUrl('mikrobiologiKlinik/pemeriksaanStaining/index&spesimen_id=' . $data->spesimen_id), array(
                                            'class' => 'hover',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk Pemeriksaan Staining "));
                                    },
 
                                ),
                                array(
                                    'header' => 'Culture',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {
                                            return CHtml::link("<span style='font-size:17px'> <i class ='icon-medical-picker'> </i></span>", Yii::app()->createUrl('mikrobiologiKlinik/cultureT/index&spesimen_id=' . $data->spesimen_id), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk Menambahkan "));
                                        } else {
                                            return '-';
                                        }
                                    },
                                ),

                                array(    
                                    'header' => 'ID / AST',
                                    'type'=>'raw',
                                    'value' => function($data){
                                        return CHtml::link("<i class='icon-medical-list'></i>", Yii::app()->createUrl("/mikrobiologiKlinik/idastT/index", array('spesimen_id' => $data->spesimen_id)), 
                                                array('rel' => 'tooltip', 'data-original-title' => 'Klik icon ini, untuk Melakukan Transaksi ID/AST', 'data-placement'=>'left'));
                                    },
                                    'htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
                                ),       
                                array(
                                    'header' => 'Lihat Hasil',
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center',
                                    ),
                                    'value' => function ($data){
                                        echo "<div style='margin-top:25%'>".CHtml::link("<i class ='glyphicon glyphicon-list' style='color:#636363;font-size:20px;'> </i>",Yii::app()->createUrl('mikrobiologiKlinik/informasiDaftarSpesimen/detail&id='.$data->spesimen_id),
                                                array("rel"=>"tooltip","title"=>"Klik untuk Melihat Detail Daftar Spesimen", "target"=>"frame1", "onclick"=>"window.parent.$(\"#dialog1\").dialog(\"open\");"))."</div>";

                                    }
                                ),            
                                array(
                                    'header' => 'Pengambilan Hasil',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                                    'value' => function($data) {
                                        /* fungsi untuk pengambilan hasil   */

                                        $criteria = new CDbCriteria;
                                        $criteria->addCondition("spesimen_id = ".$data->spesimen_id);
                                        $criteria->addCondition("nama_pengambilhasil IS NOT NULL");

                                        $modHasilPemeriksaan = AmbilhasilSpesimenT::model()->findAll($criteria);

                                        if (count($modHasilPemeriksaan) > 0) {
                                            $buttonpengambilanhasil = CHtml::Link("<span style='font-size:25px; color: #0B6623'><i class=\"fa fa-user\"></i></span>", Yii::app()->controller->createUrl("InformasiDaftarSpesimen/PengambilanHasil", array("spesimen_id" => $data->spesimen_id, 'pasien_id' => $data->pasien_id, "frame" => 1, "popup" => "true")), array("class" => "",
                                                "target" => "iframePengambilanHasil",
                                                "onclick" => "$(\"#dialogPengambilanHasil\").dialog(\"open\");",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk pengambilan hasil",
                                            ));
                                        } else {
                                            $buttonpengambilanhasil = CHtml::Link("<span style='font-size:25px;'><i class=\"fa fa-user\"></i></span>", Yii::app()->controller->createUrl("InformasiDaftarSpesimen/PengambilanHasil", array("spesimen_id" => $data->spesimen_id, 'pasien_id' => $data->pasien_id, "frame" => 1, "popup" => "true")), array("class" => "",
                                                "target" => "iframePengambilanHasil",
                                                "onclick" => "$(\"#dialogPengambilanHasil\").dialog(\"open\");",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk pengambilan hasil",
                                            ));
                                        }

                                        return $buttonpengambilanhasil;
                                    }
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));

                        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                        $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
                        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                        $js = <<< JSCRIPT
                                function cekForm(obj){
                                        $("#informasiae-r-search :input[name='"+ obj.name +"']").val(obj.value);
                                }
                                function print(caraPrint){
                                        window.open("${urlPrint}/"+$('#informasiae-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                                }
JSCRIPT;
                        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                        ?>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial('search',array(
                              'model'=>$model,
                              ));  ?>
                        </fieldset>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</div>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog1',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Penerimaan Spesimen',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frame1" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>

<?php
// Dialog untuk Pengambilan Hasil =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPengambilanHasil',
    'options' => array(
        'title' => 'Pengambilan Hasil',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 550,
        'minHeight' => 450,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('penerimaanspesimen-r-grid'); }",
    ),
));
?>
<iframe src="" name="iframePengambilanHasil" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
//========= end Pengambilan Hasil =============================
?>

<script>
    function batalTerima(obj, id) {
        myConfirm('Apakah anda yakin untuk membatalkan penerimaan spesimen ini?', 'Perhatian!', function (r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalTerima'); ?>', {id: id}, function (data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('penerimaanspesimen-r-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>