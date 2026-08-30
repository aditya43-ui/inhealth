<?php

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#informasiae-r-search').submit(function(){
            $.fn.yiiGridView.update('informasiae-r-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong> Insiden Kebakaran </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong> Insiden Kebakaran </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'insidenkebakaran-t-grid',
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
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                ),
                                array(
                                    'header' => 'Tanggal Pelaporan',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'value' => function($data){
                                        echo MyFormatter::formatDateTimeForUser($data->tgl_pelaporan);
                                    }
                                ),
                                array(
                                    'header' => 'Nomor Dokumen',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'value' => function($data){
                                        echo $data->no_dokumen;
                                    }
                                ),
                                array(
                                    'header' => 'Nama Pelapor',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'value' => function($data){
                                        echo $data->pegawai_pelapor->namaLengkap;
                                    }
                                ),
                                array(
                                    'header' => 'NIP',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'value' => function($data){
                                        echo $data->pegawai_pelapor->nomorindukpegawai;
                                    }
                                ),
                                array(
                                    'header' => 'Saksi',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'value' => function($data){
                                        if (!empty($data->saksi1) && !empty($data->saksi2) && !empty($data->saksi3)) {
                                            echo $data->saksi1 ." / ".$data->saksi2 . " / ".$data->saksi3;
                                        } else if(!empty($data->saksi1) && !empty($data->saksi2) && empty($data->saksi3)){
                                            echo $data->saksi1 ." / ".$data->saksi2;
                                        } else {
                                            echo $data->saksi1;
                                        }
                                    }
                                ),
                                array(
                                    'header' => 'Tanggal Insiden',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'value' => function($data){
                                        echo MyFormatter::formatDateTimeForUser($data->tgl_kejadian);
                                    }
                                ),
                                array(
                                    'header' => 'Unit Kerja Kejadian',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'value' => function($data){
                                        echo !empty($data->unitkeja_kejadian_id) ? $data->unitkerja->namaunitkerja : "-";
                                    }
                                ),
                                array(
                                    'header' => 'Lokasi Kejadian',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'value' => function($data){
                                        echo $data->lokasikejadian;
                                    }
                                ),
                                array(
                                    'header' => 'Mengetahui Ketua K3RS',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'value' => function($data){
                                        echo $data->pegawai_mengetahui->namaLengkap;
                                    }
                                ),
                                array(
                                    'header' => 'Rincian Kejadian',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        return CHtml::Link('<i class="fa fa-list-alt">', Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/informasiLaporanInsidenKebakaran/detail", array('insidenkebakaran_id' => $data->insidenkebakaran_id, 'is_detail' => 1,  "frame" => 3, "popup" => "true")), array("class" => "",
                                                    "target" => "iframeDetail",
                                                    "onclick" => "$(\"#dialogDetail\").dialog(\"open\");",
                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk Melihat Detail Data",
                                        ));
                                    },
                                    'htmlOptions' => array('style' => 'text-align:center; font-size: 12pt; vertical-align: middle')
                                ),
                                array(
                                    'header' => 'Verifikasi',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $grading = '';
                                        if ($data->tglverifikasi_pelaporan === null) {
                                            if ($data->mengetahuipegawai_id == Yii::app()->user->getState('pegawai_id')) {
                                                $grading .= '<button class="btn btn-primary btn-md" name="yt1" onclick="setVerifikasi(' . $data->insidenkebakaran_id . '); ">Verifikasi</button>';
                                            } else {
                                                $grading .= CHtml::htmlButton(('Verifikasi'), array('class' => 'btn btn-primary btn-md', 'type' => 'button', 'onclick' => 'toastr.error("Hanya <b>' . $data->pegawai_mengetahui->namaLengkap . '</b> yang bisa melakukan verifikasi")'));
                                            }
                                        } else {
                                            $grading .= '<button class="btn btn-green btn-md" name="yt1">Verifikasi</button>';
                                        }
                                        return $grading;
                                    },
                                    'htmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                ),
                                array(
                                    'header' => 'Revisi',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $grading = '';
                                        if ($data->tglverifikasi_pelaporan === null) {
                                            $grading .= CHtml::Link('<i class="entypo-pencil" style="font-size: 12pt">', Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/InsidenKebakaranT/index", array("insidenkebakaran_id" => $data->insidenkebakaran_id, 'is_edit' => 1, "frame" => 3, "popup" => "true")), array("class" => "",
                                                        "target" => "iframeUbah",
                                                        "onclick" => "$(\"#dialogUbah\").dialog(\"open\");",
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk Mengubah Data",
                                            ));
                                        } else {
                                            $grading .= "<i class='entypo-pencil' style='font-size: 12pt; color:grey;' disabled='disabled'>";
                                        }
                                        return $grading;
                                    },
                                    'htmlOptions' => array('style' => 'text-align:center; vertical-align: middle')
                                ),
                                array(
                                    'header' => 'Batal',
                                    'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $grading = '';
                                        if ($data->tglverifikasi_pelaporan === null) {
                                            $grading .= CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-remove" style="color:red;"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/deleteRecord', array("id" => $data->insidenkebakaran_id)), array(
                                                        'onclick' => 'deleteRecord(this);return false;'));
                                        } else {
                                            $grading .= "<i class='glyphicon glyphicon-remove' style='color:grey; font-size: 12pt' disabled='disabled'>";
                                        }
                                        return $grading;
                                    },
                                    'htmlOptions' => array('style' => 'text-align:center; font-size: 12pt; vertical-align: middle')
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
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
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial($this->path_view.'_search',array(
                                   'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>	
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function setVerifikasi(id) {
        var insidenkebakaran_id = id;
        myConfirm("Apakah anda ingin memverifikasi data ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('setVerifikasi'); ?>',
                            data: {insidenkebakaran_id: insidenkebakaran_id},
                            dataType: "json",
                            success: function (data) {
                                if (data.isverifikasi == true) {
                                    $.fn.yiiGridView.update('insidenkebakaran-t-grid');
                                    toastr.success("Data berhasil diverifikasi", "Perhatian!");
                                } else {
                                    toastr.error(data.pesan);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });
                    }
                }
        );
        return false;
    }
    
    function deleteRecord(obj) {
        myConfirm("Yakin akan membatalkan laporan ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'GET',
                            url: obj.href,
                            data: {}, //
                            dataType: "json",
                            success: function (data) {
                                $.fn.yiiGridView.update('insidenkebakaran-t-grid');
                                if (data.sukses > 0) {
                                    toastr.success("Data berhasil dihapus", "Perhatian!");
                                } else {
                                    toastr.error('Data gagal dihapus');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                toastr.error('Data gagal dihapus');
                                console.log(errorThrown);
                            }
                        });
                    }
                }
        );
        return false;
    }
</script>
<?php
/* ============================== start Detail =============================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Laporan Insiden Kebakaran',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1050,
        'minHeight' => 150,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
/* =============================== end Edit ================================ */
?>
<?php
/* ============================== start Edit =============================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbah',
    'options' => array(
        'title' => 'Ubah Data Laporan Insiden Kebakaran',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'minHeight' => 150,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeUbah" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
/* =============================== end Edit ================================ */
?>