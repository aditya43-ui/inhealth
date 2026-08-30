<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
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
                <div class="panel-title">Informasi <strong> Analisa dan Regrading Laporan Insiden Pasien </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong> Analisa dan Regrading Laporan Insiden Pasien </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'informasiae-r-grid',
                            'replaceUrl' => true,
                            'dataProvider' => $model->searchInformasi(),
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
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'header' => 'Tanggal Pelaporan',
                                    'value' => function($data) {
                                        echo MyFormatter::formatDateTimeForUser($data->insidenrs_tgllapor);
                                    }
                                ),
                                array(
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'htmlOptions' => array('style' => 'text-align:left; min-width: 80px'),
                                    'header' => 'Tanggal dan Waktu Insiden',
                                    'value' => function($data) {
                                        echo MyFormatter::formatDateTimeForUser($data->insidenrs_tglinsiden);
                                    }
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
                                        echo $data->no_rekam_medik . "/ <br>" . $data->nama_pasien;
                                    }
                                ),
                                array(
                                    'header' => 'Insiden',
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'value' => '$data->insidenrs_nama',
                                ),
                                array(
                                    'header' => 'Kronologis Insiden',
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'value' => '$data->insidenrs_kronologis',
                                ),
                                array(
                                    'header' => 'Jenis Insiden',
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'value' => '$data->insidenrs_jenis',
                                ),
                                array(
                                    'header' => 'Tempat Insiden / Lokasi Kejadian',
                                    'headerHtmlOptions' => array('style' => 'text-align: center', ),
                                    'value' => function($data){
                                        $namaunitkerja = !empty($data->unitkerjatempat->namaunitkerja) ? $data->unitkerjatempat->namaunitkerja :" - ";
                                        $ruangan_nama = !empty($data->lokasikejadian->ruangan_nama) ? $data->lokasikejadian->ruangan_nama : " - ";
                                        echo $namaunitkerja ." / ".$ruangan_nama;
                                    }
                                ),
                                array(
                                    'header' => 'Tingkat Risiko',
                                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                                    'value' => '$data->tingkatrisiko_nama',
                                ),
                                array(
                                    'header' => 'Grading',
                                    'headerHtmlOptions' => array('style' => 'text-align: center',),
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data) {
                                        if (!empty($data->gradinginsidenrs_id)) {
                                            if ($data->gradingrisiko == Params::GRADING_MERAH) {
                                                echo CHtml::Link("<button class ='btn btn-sm btn-red' style='width: 75px'> <b> Merah </b> </button>");
                                            } else if ($data->gradingrisiko == Params::GRADING_KUNING) {
                                                echo CHtml::Link("<button class ='btn btn-sm btn-gold' style='width: 75px'> <b> Kuning </b> </button>");
                                            } else if ($data->gradingrisiko == Params::GRADING_BIRU) {
                                                echo CHtml::Link("<button class ='btn btn-sm btn-blue' style='width: 75px'> <b> Biru </b> </button>");
                                            } else {
                                                echo CHtml::Link("<button class ='btn btn-sm btn-green' style='width: 75px'> <b> Hijau </b> </button>");
                                            }
                                        } else {
                                            echo " ";
                                        }
                                    }
                                ),
                                array(
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'htmlOptions' => array('style' => 'text-align:left; min-width: 120px'),
                                    'header' => 'Tindakan',
                                    'value' => '$data->tindakan',
                                ),
                                array(
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'htmlOptions' => array('style' => 'text-align:left; min-width: 120px'),
                                    'header' => 'Tindak Lanjut',
                                    'value' => '$data->tindaklanjut',
                                ),
                                array(
                                    'header' => 'Detail',
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'value' => ' ',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        echo CHtml::Link("<button class ='btn btn-sm btn-primary'> <i class='glyphicon glyphicon-align-justify'> </i> </button>", Yii::app()->controller->createUrl("InformasiLaporanInsidenRS/detail", array("insidenrs_id" => $data->insidenrs_id)), array(
                                            "class" => "",
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk Melihat Detail",
                                                )
                                        );
                                    }
                                ),
                                array(
                                    'header' => 'Analisa <br> dan <br> Regrading',
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'value' => ' ',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data) {
                                        $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                                        $modRegrading = GradinginsidenrsT::model()->findByPk($data->gradinginsidenrs_id);
                                        if (!empty($data->gradinginsidenrs_id)) {
                                            if (!empty($modRegrading->tgl_persetujuan)) {
                                                if (!empty($data->regradingrisiko)) {
                                                    if ($data->regradingrisiko == Params::GRADING_MERAH) {
                                                        $title = 'Merah';
                                                        $btn = 'btn btn-sm btn-red';
                                                    } else if ($data->regradingrisiko == Params::GRADING_BIRU) {
                                                        $title = 'Biru';
                                                        $btn = 'btn btn-sm btn-blue';
                                                    } else if ($data->regradingrisiko == Params::GRADING_HIJAU) {
                                                        $title = 'Hijau';
                                                        $btn = 'btn btn-sm btn-green';
                                                    } else {
                                                        $title = 'Kuning';
                                                        $btn = 'btn btn-sm btn-gold';
                                                    }
                                                    echo "<button class ='" . $btn . "' style='width: 75px; text-align: center'> <b>" . $title . "</b> </button>";
                                                } else {
                                                    echo "<button class ='btn btn-sm btn-primary'  style='width: 75px'> <b> Regrading </b> </button>";
                                                }
                                            } else {
                                                if ($modPegawai->unitkerja_id == Params::UNITKERJA_ID_KMKP) {
                                                    if (!empty($data->regradingrisiko)) {
                                                        if ($data->regradingrisiko == Params::GRADING_MERAH) {
                                                            $title = 'Merah';
                                                            $btn = 'btn btn-sm btn-red';
                                                        } else if ($data->regradingrisiko == Params::GRADING_BIRU) {
                                                            $title = 'Biru';
                                                            $btn = 'btn btn-sm btn-blue';
                                                        } else if ($data->regradingrisiko == Params::GRADING_HIJAU) {
                                                            $title = 'Hijau';
                                                            $btn = 'btn btn-sm btn-green';
                                                        } else {
                                                            $title = 'Kuning';
                                                            $btn = 'btn btn-sm btn-gold';
                                                        }
                                                        echo CHtml::Link("<button class ='" . $btn . "'  style='width: 75px'> <b> ".$title." </b> </button>", Yii::app()->controller->createUrl("InformasiLaporanInsidenRS/regrading", array("insidenrs_id" => $data->insidenrs_id)), array(
                                                            "class" => "",
                                                            "target" => "iframe1",
                                                            "onclick" => "$(\"#dialogRegrading\").dialog(\"open\");",
                                                            "rel" => "tooltip",
                                                            "title" => "Klik untuk Menambahkan Regrading",
                                                                ));
                                                    } else {
                                                        echo CHtml::Link("<button class ='btn btn-sm btn-primary'  style='width: 75px'> <b> Regrading </b> </button>", Yii::app()->controller->createUrl("InformasiLaporanInsidenRS/regrading", array("insidenrs_id" => $data->insidenrs_id)), array(
                                                            "class" => "",
                                                            "target" => "iframe1",
                                                            "onclick" => "$(\"#dialogRegrading\").dialog(\"open\");",
                                                            "rel" => "tooltip",
                                                            "title" => "Klik untuk Menambahkan Regrading",
                                                                ));
                                                    }
                                                } else {
                                                    echo CHtml::Link("<button class ='btn btn-sm btn-primary' style='width: 75px'> <b> Regrading </b> </button>", '#', array(
                                                        "class" => "",
                                                        "onclick" => "toastr.error('Hanya Pegawai Komite Mutu dan Keselamatan Pasien yang bisa Melakukan Grading', 'Perhatian!')",
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk Menambahkan Regrading",
                                                    ));
                                                } 
                                            }
                                        }
                                    }
                                ),
                                array(
                                    'header' => 'Status Laporan',
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                    'value' => function($data) {
                                        if (!empty($data->statuslaporan)) {
                                            if ($data->statuslaporan == "Kirim Laporan") {
                                                echo '<button class="btn btn-sm btn-primary"> <b> Kirim Laporan </b> </button>';
                                            } else if ($data->statuslaporan == "Menunggu Persetujuan") {
                                                echo CHtml::Link("<button class ='btn btn-sm btn-gold'> <b>  Menunggu Persetujuan </b> </button>", Yii::app()->controller->createUrl("InformasiLaporanInsidenRS/submitLaporan", array("insidenrs_id" => $data->insidenrs_id)), array(
                                                    "class" => "",
                                                    "target" => "iframe4",
                                                    "onclick" => "$(\"#dialogLaporan\").dialog(\"open\");",
                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk Menyetujui",
                                                ));
                                            } else if ($data->statuslaporan == Params::VERIFIKASI_DISETUJUI) {
                                                echo '<button class="btn btn-sm btn-green"> <b> Disetujui </b> </button>';
                                            } else {
                                                echo CHtml::Link("<button class ='btn btn-sm btn-red'> <b>  Ditolak </b> </button>", Yii::app()->controller->createUrl("InformasiLaporanInsidenRS/detailDitolak", array("insidenrs_id" => $data->insidenrs_id)), array(
                                                    "class" => "",
                                                    "target" => "iframe5",
                                                    "onclick" => "$(\"#dialogDitolak\").dialog(\"open\");",
                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk Menyetujui",
                                                ));
                                            }
                                        } else {
                                            echo " ";
                                        }
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
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php
                            $this->renderPartial($this->path_view . '_search', array(
                                'model' => $model,
                            ));
                            ?>
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
    'id' => 'dialogRegrading',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Analisa dan Regrading',
        'autoOpen' => false,
        'width' => 1200,
        'height' => 800,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('informasiae-r-grid'); }",
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Insiden',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 800,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframe2" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailGrading',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Grading',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 800,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframe3" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogLaporan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Status Laporan',
        'autoOpen' => false,
        'width' => 550,
        'height' => 400,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframe4" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
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

<script>
    function reloadTabel() {
        myAlert('Perubahan Status Laporan berhasil dilakukan');
        $.fn.yiiGridView.update('informasiae-r-grid');
    }
</script>