<div class="table-responsive overflow-x" >
    <?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'insidenrs-selainpasien-t-grid',
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
                'header' => 'Nama Pelapor',
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
                'header' => 'Nomor Kejadian',
                'name' => 'no_kejadian',
                'value' => function($data) {
                    if (!empty($data->no_kejadian)) {
                        echo $data->no_kejadian;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Satuan Kerja',
                'name' => 'unitkerja_pelapor_id',
                'value' => function($data) {
                    if (!empty($data->unitkerja_pelapor_id)) {
                        echo $data->unitkerja->namaunitkerja;
                        ;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Tanggal Insiden',
                'name' => 'tgl_kejadian',
                'value' => function($data) {
                    if (!empty($data->tgl_kejadian)) {
                        echo MyFormatter::formatDateTimeForUser($data->tgl_kejadian);
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Lokasi Kejadian',
                'name' => 'lokasikejadian',
                'value' => function($data) {
                    if (!empty($data->lokasikejadian)) {
                        echo $data->lokasikejadian;
                    } else {
                        echo '';
                    }
                }
            ),
            array(
                'header' => 'Jenis Kejadian',
                'name' => 'jeniskejadian',
                'value' => function($data) {
                    if (!empty($data->jeniskejadian)) {
                        echo $data->jeniskejadian;
                    } else {
                        echo '';
                    }
                }
            ),
            array(
                'header' => 'Nama Korban',
                'name' => 'namakorban',
                'value' => function($data) {
                    if (!empty($data->namakorban)) {
                        echo $data->namakorban;
                    } else {
                        echo '';
                    }
                }
            ),
            array(
                'header' => 'Rincian Kejadian',
                'type' => 'raw',
                'value' => function($data) {
                    return CHtml::Link('<i class="entypo-doc-text">', Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/insidenrsSelainpasienT/index", array('insidenrs_selainpasien_id' => $data->insidenrs_selainpasien_id, 'is_detail' => 1,  "frame" => 3, "popup" => "true")), array("class" => "",
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
                'name' => 'pegawai_mengetahui2_id',
                'value' => function($data) {
                    if (!empty($data->pegawai_mengetahui2_id)) {
                        echo $data->pegawai_mengetahui2->namaLengkap;
                    } else {
                        echo '';
                    }
                }
            ),
            array(
                'header' => 'Verifikasi',
                'type' => 'raw',
                'value' => function($data) {
                    $grading = '';
                    if ($data->tglverifikasi_pelaporan === null) {
                        if ($data->pegawai_mengetahui2_id != Yii::app()->user->getState('pegawai_id')) {
                            $grading .= '<button class="btn btn-black btn-sm" name="yt1" onclick="setVerifikasi(' . $data->insidenrs_selainpasien_id . '); ">Verifikasi</button>';
                        } else {
                            $grading .= CHtml::htmlButton(('Verifikasi'), array('class' => 'btn btn-black btn-sm', 'type' => 'button', 'onclick' => 'myAlert("Hanya <b>' . $data->pegawai_mengetahui2->namaLengkap . '</b> yang bisa melakukan verifikasi")'));
                        }
                    } else {
                        $grading .= '<button class="btn btn-green btn-sm" name="yt1">Verifikasi</button>';
                    }
                    return $grading;
                },
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Ubah',
                'type' => 'raw',
                'value' => function($data) {
                    $grading = '';
                    if ($data->tglverifikasi_pelaporan === null) {
                        $grading .= CHtml::Link('<i class="entypo-pencil">', Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/insidenrsSelainpasienT/index", array("insidenrs_selainpasien_id" => $data->insidenrs_selainpasien_id, 'is_edit' => 1, "frame" => 3, "popup" => "true")), array("class" => "",
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
                'type' => 'raw',
                'value' => function($data) {
                    $grading = '';
                    if ($data->tglverifikasi_pelaporan === null) {
                        $grading .= CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="glyphicon glyphicon-remove" style="color:red;"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/deleteRecord', array("id" => $data->insidenrs_selainpasien_id)), array(
                                    'onclick' => 'deleteRecord(this);return false;'));
                    } else {
                        $grading .= "<i class='glyphicon glyphicon-remove' style='' disabled='disabled'>";
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
            $("#gradinginsidenrs-t-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
            window.open("${urlPrint}/"+$('#gradinginsidenrs-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?> 
</div>
<script type="text/javascript">
    /**
     * Set Verifikasi
     * @param {type} id
     * @returns {Boolean}
     */
    function setVerifikasi(id) {
        var insidenrs_selainpasien_id = id;
        myConfirm("Apakah anda ingin memverifikasi data ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('setVerifikasi'); ?>',
                            data: {insidenrs_selainpasien_id: insidenrs_selainpasien_id},
                            dataType: "json",
                            success: function (data) {
                                if (data.isverifikasi == true) {
                                    $.fn.yiiGridView.update('insidenrs-selainpasien-t-grid');
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

    /**
     * Hapus Data
     * @param {type} obj
     * @returns {Boolean} 
     */
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
                                $.fn.yiiGridView.update('insidenrs-selainpasien-t-grid');
                                if (data.sukses > 0) {
                                } else {
                                    myAlert('Data gagal dihapus');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                myAlert('Data gagal dihapus');
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
        'title' => 'Detail Laporan Insiden Selain Pasien',
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
/* =============================== end Detail ================================ */
?>
<?php
/* ============================== start Edit =============================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogUbah',
    'options' => array(
        'title' => 'Ubah Data Laporan Insiden Selain Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1050,
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