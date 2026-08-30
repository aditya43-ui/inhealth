<div class="table-responsive overflow-x" >
    <?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'insidenrs-t-grid',
        'dataProvider' => $model->searchInformasi(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'No',
                'filter' => false,
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                'headerHtmlOptions' => array('style' => 'text-align:center')
            ),
            array(
                'header' => 'Tanggal Pelaporan',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'name' => 'tgl_pelaporan',
                'value' => function($data) {
                    if (!empty($data->tgl_pelaporan)) {
                        echo MyFormatter::formatDateTimeForUser($data->tgl_pelaporan);
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Nomor Dokumen',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'name' => 'no_dokumen',
                'value' => function($data) {
                    if (!empty($data->no_dokumen)) {
                        echo $data->no_dokumen;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Nama Pelapor',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'name' => 'pelapor_nama',
                'value' => function($data) {
                    if (!empty($data->pelapor_id)) {
                        $modPegawai = PegawaiM::model()->findByPk($data->pelapor_id);
                        echo $modPegawai->namaLengkap;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'NIP',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'value' => function($data) {
                    if (!empty($data->nomorindukpegawai)) {
                        echo $data->nomorindukpegawai;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Saksi',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'value' => function($data) {
                    if (!empty($data->saksi1)) {
                        echo $data->saksi1. " / <br>" . $data->saksi2. " / <br>" . $data->saksi3;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Tanggal Insiden',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'name' => 'tgl_kejadian',
                'value' => function($data) {
                    if (!empty($data->tgl_kejadian)) {
                        echo $data->tgl_kejadian;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Unit Kerja Kejadian',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'name' => 'unitkerja_kejadian_nama',
                'value' => function($data) {
                    if (!empty($data->unitkerja_kejadian_id)) {
                        $modDialogUnitKerja = UnitkerjaM::model()->findByPk($data->unitkerja_kejadian_id);
                        echo $modDialogUnitKerja->namaunitkerja;
                    } else {
                        echo '';
                    }
                },
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Lokasi Kejadian',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'value' => function($data) {
                    if (!empty($data->lokasikejadian)) {
                        echo $data->lokasikejadian;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Rincian Kejadian',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'type' => 'raw',
                'value' => function($data) {
                    return CHtml::Link('<i class="entypo-doc-text">', Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/insidentumpahanb3T/index", array('insidentumpahanb3_id' => $data->insidentumpahanb3_id, 'is_detail' => 1,  "frame" => 3, "popup" => "true")), array("class" => "",
                                "target" => "iframeDetail",
                                "onclick" => "$(\"#dialogDetail\").dialog(\"open\");",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Melihat Detail Data",
                    ));
                },
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => 'Mengetahui Ketua K3RS',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'name' => 'mengetahuipegawai_nama',
                'value' => function($data) {
                    if (!empty($data->mengetahuipegawai_id)) {
                        echo $data->pegawai_mengetahui->namaLengkap;
                    } else {
                        echo '';
                    }
                },
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Verifikasi',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'type' => 'raw',
                'value' => function($data) {
                    $grading = '';
                    if ($data->tglverifikasi_pelaporan === null) {
                        if ($data->mengetahuipegawai_id == Yii::app()->user->getState('pegawai_id')) {
                            $grading .= '<button class="btn btn-black btn-sm" name="yt1" onclick="setVerifikasi(' . $data->insidentumpahanb3_id . '); ">Verifikasi</button>';
                        } else {
                            $grading .= CHtml::htmlButton(('Verifikasi'), array('class' => 'btn btn-black btn-sm', 'type' => 'button', 'onclick' => 'myAlert("Hanya <b>' . $data->pegawai_mengetahui->namaLengkap. '</b> yang bisa melakukan verifikasi")'));
                        }
                    } else {
                        $grading .= '<button class="btn btn-green btn-sm" name="yt1">Verifikasi</button>';
                    }
                    return $grading;
                },
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Revisi',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'type' => 'raw',
                'value' => function($data) {
                    $grading = '';
                    if ($data->tglverifikasi_pelaporan === null) {
                        $grading .= CHtml::Link('<i class="entypo-pencil">', Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/insidentumpahanb3T/index", array("insidentumpahanb3_id" => $data->insidentumpahanb3_id, 'is_edit' => 1, "frame" => 3, "popup" => "true")), array("class" => "",
                                    "target" => "iframeUbah",
                                    "onclick" => "$(\"#dialogUbah\").dialog(\"open\");",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk Mengubah Data",
                        ));
                    } else {
                        $grading .= "<i class='entypo-pencil' style='color:black;' disabled='disabled'>";
                    }
                    return $grading;
                },
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => 'Batal',
                'headerHtmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                'type' => 'raw',
                'value' => function($data) {
                    $grading = '';
                    if ($data->tglverifikasi_pelaporan === null) {
                        $grading .= CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-remove" style="color:red;"></i>')), 'javascript:;', array(
                                    'data-id'=>$data->insidentumpahanb3_id,
                                    'onclick' => 'deleteRecord(this);return false;'));
                    } else {
                        $grading .= "<i class='glyphicon glyphicon-remove' style='color:black;' disabled='disabled'>";
                    }
                    return $grading;
                },
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        $("table").find("input[type=text]").each(function(){
            cekForm(this);
        })
    }',
    ));


    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT
    function cekForm(obj){
            $("#insidenrs-t-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
            window.open("${urlPrint}/"+$('#insidenrs-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?> 
</div>
<script type="text/javascript">
    function setVerifikasi(id) {
        var insidentumpahanb3_id = id;
        myConfirm("Apakah anda ingin memverifikasi data ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('setVerifikasi'); ?>',
                            data: {insidentumpahanb3_id: insidentumpahanb3_id},
                            dataType: "json",
                            success: function (data) {
                                if (data.isverifikasi == true) {
                                    $.fn.yiiGridView.update('insidenrs-t-grid');
                                } else {
                                    myAlert(data.pesan);
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
        myConfirm("Apakah Anda yakin Akan Menghapus Data Ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= $this->createUrl('deleteRecord') ?>',
                            data: {
                                id:$(obj).data('id')
                            }, 
                            dataType: "json",
                            success: function (data) {
                                
                                if (data.sukses == 1) {
                                    toastr.success("Data berhasil dihapus","Perhatian!");
                                     $.fn.yiiGridView.update('insidenrs-t-grid', {
                                        data: $("#insidenrs-t-search").serialize()
                                    });
                                } else {
                                    myAlert('Data gagal dihapus.');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                myAlert('Data gagal dihapus.');
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
        'title' => 'Rincian Laporan Insiden Tumpahan B3',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1100,
        'minHeight' => 150,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
/* =============================== end Detail ================================ */


/* ============================== start Ubah =============================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbah',
    'options' => array(
        'title' => 'Revisi Laporan Insiden Tumpahan B3',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1050,
        'minHeight' => 150,
        'resizable' => true,
        'close' => 'js:function(){$.fn.yiiGridView.update(\'insidenrs-t-grid\', {});}'
    ),
));
?>
<iframe src="" name="iframeUbah" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
/* =============================== end Ubah ================================ */
?>