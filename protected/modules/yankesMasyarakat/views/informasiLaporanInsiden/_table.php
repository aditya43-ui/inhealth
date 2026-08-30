<div class="table-responsive overflow-x" >
    <?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'insidenrs-t-grid',
        'replaceUrl' => true,
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
                'name' => 'insidenrs_tgllapor',
                'value' => function($data) {
                    if (!empty($data->insidenrs_tgllapor)) {
                        echo MyFormatter::formatDateTimeForUser($data->insidenrs_tgllapor);
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Tanggal dan Waktu Insiden',
                'name' => 'insidenrs_tglinsiden',
                'value' => function($data) {
                    if (!empty($data->insidenrs_tglinsiden)) {
                        echo MyFormatter::formatDateTimeForUser($data->insidenrs_tglinsiden);
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Instalasi / Ruangan',
                'value' => function($data) {

                    $cekPendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                    if (!empty($cekPendaftaran)) {
                        echo (isset($cekPendaftaran->instalasi_id) ? $cekPendaftaran->instalasi->instalasi_nama : "-") . " / " . (isset($cekPendaftaran->ruangan_id) ? $cekPendaftaran->ruangan->ruangan_nama : "-");
                    } else {
                        $instalasi = !empty($data->instalasi_id) ? $data->instalasiinsiden->instalasi_nama : null;
                        $ruangan = !empty($data->ruangan_id) ? $data->ruanganinsiden->ruangan_nama : null;
                        echo $instalasi . '/<br/>' . $ruangan;
                    }
                },
            ),
            array(
                'header' => 'No. Rekam Medik / Nama Pasien',
                'value' => function ($data) {
                    $cekPendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                    if (!empty($cekPendaftaran)) {
                        echo $cekPendaftaran->pasien->no_rekam_medik . " / <br>" . $cekPendaftaran->pasien->nama_pasien;
                    } else {
                        echo !empty($data->norekammedik) ? $data->norekammedik : '-';
                        echo ' / <br>';
                        echo !empty($data->nama_pasien) ? $data->nama_pasien : '-';
                    } 
                }
            ),
            array(
                'header' => 'Insiden',
                'name' => 'insidenrs_nama',
                'value' => function($data) {
                    if (!empty($data->insidenrs_nama)) {
                        echo $data->insidenrs_nama;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Kronologis Insiden',
                'name' => 'insidenrs_kronologis',
                'value' => function($data) {
                    if (!empty($data->insidenrs_kronologis)) {
                        echo $data->insidenrs_kronologis;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Jenis Insiden',
                'name' => 'insidenrs_jenis',
                'value' => function($data) {
                    if (!empty($data->insidenrs_jenis)) {
                        echo $data->insidenrs_jenis;
                    } else {
                        echo '';
                    }
                },
            ),
            array(
                'header' => 'Lokasi Kejadian / Ruangan Penyebab',
                'name' => 'insidenrs_jenis',
                'value' => function($data) {
                    $tempat = '';
                    $ruangan_penyebab = '';
                    if (!empty($data->lokasikejadian_id)) {
                        $cekRuangan = RuanganM::model()->findByPk($data->lokasikejadian_id);
                        $tempat = $cekRuangan->ruangan_nama;

                        $cekLokasi = RuanganM::model()->findByPk($data->ruanganpenyebab_id);
                        $ruangan_penyebab = $cekLokasi->ruangan_nama; 
                    } else {
                        $tempat = '';
                        $ruangan_penyebab = '';
                    }

                    echo $tempat . ' / <br>' . $ruangan_penyebab;
                },
            ),
            array(
                'header' => 'Detail',
                'type' => 'raw',
                'value' => function($data) {
                    return CHtml::Link('<i class="entypo-doc-text" style="font-size: 14px;">', Yii::app()->controller->createUrl("detail", array('insidenrs_id' => $data->insidenrs_id, "frame" => 3, "popup" => "true")), array("class" => "",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Melihat Detail Data",
                    ));
                },
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => 'Grading Risiko',
                'type' => 'raw',
                'value' => '$data->getGrading($data->insidenrs_id, $data)',
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Verifikasi',
                'type' => 'raw',
                'value' => '$data->getVerifikasi($data->insidenrs_id, $data)',
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Status Laporan',
                'type' => 'raw',
                'value' => '$data->getStatus($data->insidenrs_id, $data)',
                'htmlOptions' => array('style' => 'text-align:center;'),
            ),
            array(
                'header' => 'Ubah',
                'type' => 'raw',
                'value' => function($data) {
                    $cek = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $data->insidenrs_id));
                    $grading = '';
                    if (!empty($cek)) {
                        $criteria = new CDbCriteria();
                        $criteria->addCondition('statuslaporan IS NOT NULL');
                        $criteria->addCondition("insidenrs_id = " . $data->insidenrs_id);
                        $cekGrading = GradinginsidenrsT::model()->find($criteria);

                        if (!empty($cekGrading)) {
                            $grading .= "<i class='entypo-pencil' style='color:black;' disabled='disabled'>";
                        } elseif (empty($cekGrading)) {
                            $grading .= CHtml::link("<i class='entypo-pencil'>", Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/informasiLaporanInsiden/Update", array("insidenrs_id" => $data->insidenrs_id)), array('rel' => 'tooltip', 'title' => 'Klik untuk Mengubah Data'));
                        }
                    } else {
                        $grading .= CHtml::link("<i class='entypo-pencil'>", Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/informasiLaporanInsiden/Update", array("insidenrs_id" => $data->insidenrs_id)), array('rel' => 'tooltip', 'title' => 'Klik untuk Mengubah Data'));
                    }
                    return $grading;
                },
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'header' => 'Batal',
                'type' => 'raw',
                'value' => function($data) {
                    $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                    $cek = GradinginsidenrsT::model()->findByAttributes(array('insidenrs_id' => $data->insidenrs_id));
                    $criteria = new CDbCriteria();
                    $criteria->addCondition('statuslaporan IS NOT NULL');
                    $criteria->addCondition("insidenrs_id = " . $data->insidenrs_id);
                    $cekGrading = GradinginsidenrsT::model()->find($criteria);
                    if (empty($cek->tglverifikasi_unit)) {
                        if (empty($data->is_batal) || empty($cekGrading)) {
                            if (Yii::app()->user->getState('unitkerja_id') == Params::UNITKERJA_ID_KMKP) {
                                echo CHtml::Link('<i class="glyphicon glyphicon-remove" style="color:red; font-size: 14px"></i>', Yii::app()->controller->createUrl("batal", array('insidenrs_id' => $data->insidenrs_id, "frame" => 3, "popup" => "true")), array("class" => "",
                                                "target" => "iframeBatal",
                                                "onclick" => "$(\"#dialogBatal\").dialog(\"open\");",
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk Membatalkan",
                                    ));
                            } else {
                                echo CHtml::link("<span style='font-size:15px; color: black'><i class='glyphicon glyphicon-remove'></i></span>", 'javascript:;', array(
                                                        'onclick' => 'toastr.error("Hanya <b> Komite Mutu dan Keselamatan Pasien </b> yang Bisa Membatalkan Laporan Insiden. ","Perhatian!")',
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "data-placement" => "left",
                                                        "title" => "Klik untuk Membatalkan"));
                            } 
                        } else {
                            echo "<i class='glyphicon glyphicon-remove' style='color:black; font-size: 14px' disabled='disabled'>";
                        }
                    } else {
                        echo "";
                    }
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
    function setVerifikasi(id) {
        var insidenrs_id = id;
        myConfirm("Apakah anda ingin memverifikasi data ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('setVerifikasi'); ?>',
                            data: {insidenrs_id: insidenrs_id},
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

    function cekVerifikator() {
        myAlert("Yang bisa melakukan verifikasi hanya yang melakukan grading");
        return false;
    }

    function cekKirimlaporan() {
        myAlert("Yang bisa mengirim laporan hanya yang melakukan verifikasi");
        return false;
    }

    function setStatus(id) {
        var insidenrs_id = id;
        myConfirm("Apakah anda ingin mengirim data ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('setStatus'); ?>',
                            data: {insidenrs_id: insidenrs_id},
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
        myConfirm("Yakin akan membatalkan laporan ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $.ajax({
                            type: 'GET',
                            url: obj.href,
                            data: {}, //
                            dataType: "json",
                            success: function (data) {
                                $.fn.yiiGridView.update('insidenrs-t-grid');
                                if (data.sukses > 0) {
                                } else {
                                    myAlert('Data gagal dihapus karena data digunakan oleh <br>Master Kelompok Subtipe Insiden atau Master Subtipe Insiden.');
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                myAlert('Data gagal dihapus karena data digunakan oleh <br>Master Kelompok Subtipe Insiden atau Master Subtipe Insiden.');
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
/* ============================== start Grading =============================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogGrading',
    'options' => array(
        'title' => 'Grading Risiko Unit',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'minHeight' => 150,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeGrading" width="100%" height="320">
</iframe>

<?php
$this->endWidget();
/* =============================== end Grading ================================ */


/* ============================== start Detail =============================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Laporan Insiden',
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
/* =============================== end Grading ================================ */

/* ============================== start Batal =============================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBatal',
    'options' => array(
        'title' => 'Batal Laporan Insiden',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 250,
        'resizable' => true,
        'close' => 'js:function(){$.fn.yiiGridView.update(\'insidenrs-t-grid\', {});}'
    ),
));
?>
<iframe src="" name="iframeBatal" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
/* =============================== end Batal ================================ */
?>
<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDitolak',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Laporan Ditolak',
        'autoOpen' => false,
        'width' => 550,
        'height' => 300,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframe5" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>