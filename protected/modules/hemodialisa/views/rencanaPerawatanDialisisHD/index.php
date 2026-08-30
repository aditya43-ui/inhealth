<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Asesmen Nyeri',
);
$myicon = new MyIcon();
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rencanaperawatandialisis-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    //    'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
));


//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>

<div class="panel panel-gradient panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><strong>Rencana Perawatan Dialisis</strong></div>
        <?php if (!empty($_GET['pendaftaran_id'])) {
        ?>
            <span style="float:right; padding: 10px">
                <?php echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), array('/hemodialisa/pemeriksaanAsesmenPerawat', 'pendaftaran_id' => $_GET['pendaftaran_id'], 'konsulpoli_id' => $_GET['konsulpoli_id']), array('class' => 'btn btn-sm btn-danger')); ?>
            </span>
        <?php } ?>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . '_dataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi)); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Rencana Perawatan Dialisis</div>
            </div>
            <div class="panel-body">
                <div class="span12">
                    <?php
                    //                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //                        'id' => 'riwayatperkembanganterintegrasipasien',
                    //                        'slide' => true,
                    //                        'content' => array(
                    //                            'content2' => array(
                    //                                'multi' => 'multi',
                    //                                'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan Riwayat Perkembangan Terintegrasi Pasien')) . ' Riwayat Perkembangan Terintegrasi Pasien',
                    //                                'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatTerintegrasi', array(
                    //                                    'modRiwayatTerintegrasi' => $modRiwayatTerintegrasi,
                    //                                    'modPendaftaran' => $modPendaftaran
                    //                                        ), true),
                    //                                'active' => false,
                    //                            ),
                    //                        ),
                    //                    ));
                    ?>

                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'list-terintegrasi',
                        'content' => array(
                            'content-terintegrasi' => array(
                                'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Riwayat Perkembangan Terintegrasi Pasien')) . '<b> Riwayat Perkembangan Terintegrasi Pasien </b>',
                                'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatTerintegrasi', array(
                                    'modRiwayatTerintegrasi' => $modRiwayatTerintegrasi,
                                    'modPendaftaran' => $modPendaftaran
                                ), true),
                                'active' => false,
                            ),
                        ),
                    )); ?>

                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'riwayatrencanaperawatandialisis',
                        'slide' => true,
                        'content' => array(
                            'content3' => array(
                                'multi' => 'multi',
                                'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan Riwayat Rencana Perawatan Dialisis')) . ' Riwayat Rencana Perawatan Dialisis',
                                'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatPerawatan', array(
                                    'modRiwayatPerawatan' => $modRiwayatPerawatan,
                                    'modPendaftaran' => $modPendaftaran
                                ), true),
                                'active' => false,
                            ),
                        ),
                    ));
                    ?>

                    <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'form' => $form)); ?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="form-actions">

                    <?php
                    if (isset($_GET['sukses'])) {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check></i>')), array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'disabled' => true)) . "&nbsp";
                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="' . $myicon::getIcons('ulang') . '"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                        )) . "&nbsp";
                        //                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print(" . $_GET['rencana_perawatan_dialisis_id'] . ",'');return false")) . "&nbsp;";
                    } else {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'id' => 'btn_submit', 'onclick' => 'cekInsert();', 'onKeypress' => 'cekInsert();', 'disabled' => (isset($_GET['sukses'])) ? true : false)) . "&nbsp";
                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="' . $myicon::getIcons('ulang') . '"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
                        )) . "&nbsp";
                        //                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
                    }

                    if (isset($_GET['rencana_perawatan_dialisis_id'])) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print(" . $_GET['rencana_perawatan_dialisis_id'] . ",'');return false")) . "&nbsp;";
                    } else {
                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

</div>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));

$datPerawat = new PegawairuanganV();
if (isset($_GET['PegawairuanganV'])) {
    $datPerawat->attributes = $_GET['PegawairuanganV'];
    $datPerawat->kelompokpegawai_id = isset($_GET['PegawairuanganV']['kelompokpegawai_id']) ? $_GET['PegawairuanganV']['kelompokpegawai_id'] : null;
    $datPerawat->default = isset($_GET['PegawairuanganV']['default']) ? $_GET['PegawairuanganV']['default'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokter-v-grid3',
    //    'dataProvider' => $datPerawat->searchDialogPegRuangan(),
    'dataProvider' => $datPerawat->searchDialogPegRuangan(),
    'filter' => $datPerawat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectDokter",
                       "onClick" => "
                                $(\"#RencanaPerawatanDialisisT_pegawai_id\").val(\"$data->pegawai_id\");
                                $(\"#RencanaPerawatanDialisisT_nama_pegawai\").val(\"$data->nama_pegawai\");
                                $(\"#dialogPegawai\").dialog(\"close\");
                                return false;
                        "
                    ))',
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($datPerawat, 'kelompokpegawai_id', array('class' => 'dialogpegawai_kelompokpegawai_id')) . CHtml::activeTextField($datPerawat, 'nama_pegawai', array())
        ),
        array(
            'header' => 'Jabatan',
            'value' => '$data->jabatan_nama',
            'type' => 'raw',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end data pegawai =============================

//========= Dialog buat cari pegawai  semua =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiAll',
    'options' => array(
        'title' => 'Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));

$datAll = new PegawaiV();
$datAll->default = 'kosong';
if (isset($_GET['PegawaiV'])) {
    $datAll->attributes = $_GET['PegawaiV'];
    $datAll->default = isset($_GET['PegawaiV']['default']) ? $_GET['PegawaiV']['default'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokter-all-grid',
    'dataProvider' => $datAll->searchAllPegawai(),
    'filter' => $datAll,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectDokter",
                       "onClick" => "
                                $(\"#RencanaPerawatanDialisisT_pegawai_id\").val(\"$data->pegawai_id\");
                                $(\"#RencanaPerawatanDialisisT_nama_pegawai\").val(\"$data->nama_pegawai\");
                                $(\"#dialogPegawaiAll\").dialog(\"close\");
                                return false;
                        "
                    ))',
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($datAll, 'default', array('class' => '')) . CHtml::activeTextField($datAll, 'nama_pegawai', array())
        ),
        array(
            'header' => 'Jabatan',
            'value' => '$data->jabatan_nama',
            'type' => 'raw',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end data pegawai =============================
?>
<script>
    var setAuto = (jenis) => {

        var url = "<?php echo $this->createUrl('/actionAutoComplete/DropPetugasRuangan'); ?>";
        var kelompokpegawai_id = $(".kelompok").val();
        if (jenis == 'konsultan nefrologi') {
            url = "<?php echo $this->createUrl('/actionAutoComplete/DropPetugasSemua'); ?>";
            kelompokpegawai_id = '';
        }


        $(".nama_profesi").autocomplete({
            'showAnim': 'fold',
            'minLength': 3,
            'focus': function(event, ui) {
                $(this).val(ui.item.label);
                return false;
            },
            'select': function(event, ui) {
                $(this).val(ui.item.label);
                $("#RIPerkembanganTerintegrasiPasienT_pegawai_id").val(ui.item.pegawai_id);
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: url,
                    dataType: "json",
                    data: {
                        term: request.term,
                        kelompokpegawai_id: kelompokpegawai_id,
                        ruangan_id: '<?= Yii::app()->user->getState('ruangan_id') ?>'
                    },
                    success: function(data) {
                        response(data);
                    }
                })
            }
        });
    }

    var setDialog = (obj) => {
        var profesi = $(".profesi").val();

        if (profesi.toLowerCase() == 'konsultan nefrologi') {
            $("#dialogPegawaiAll").dialog("open");
        } else {
            $("#dialogPegawai").dialog("open");
        }
    }

    function cekInsert() {
        $('#rencanaperawatandialisis-t-form').submit();
    }

    function changeProfesi(obj) {
        //        var x = document.getElementById("pilih_ppds");
        var y = document.getElementById("pilih_pegawai");
        var pegawai_id = document.getElementById("RencanaPerawatanDialisisT_pegawai_id");
        if (obj.value == 'PPDS') {
            if (y.style.display === "block") {
                pegawai_id.value = '';
                y.style.display = "none";
            } else {
                y.style.display = "block";
            }
        } else {
            if (y.style.display === "none") {
                y.style.display = "block";
            }
        }
    }

    function pilihDialog(obj) {

        var val = obj.value;

        if (val == 'DOKTER') {
            $(".kelompok").val(<?php echo Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK ?>);
        } else if (val == 'KEPERAWATAN') {
            $(".kelompok").val(<?php echo Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN ?>);
        } else if (val == 'KETERAPIAN FISIK') {
            $(".kelompok").val(<?php echo Params::KELOMPOKPEGAWAI_ID_KETERAPIAN_FISIK ?>);
        } else if (val == 'TENAGA GIZI') {
            $(".kelompok").val(<?php echo Params::KELOMPOKPEGAWAI_ID_TENAGA_GIZI ?>);
        } else if (val == 'APOTEKER') {
            $(".kelompok").val(<?php echo Params::KELOMPOKPEGAWAI_ID_APOTEKER ?>);
        }

        var def = 'ada';
        if (val.toLowerCase() != 'konsultan nefrologi') {
            var kelompok_id = $(".kelompok").val();
            if (kelompok_id != "") {
                def = 'ada';
            }

            $(".dialogpegawai_kelompokpegawai_id").val(kelompok_id);

            setTimeout(function() {
                //$("#dialogPpds").removeClass('animation-loading-1');                               

                $.fn.yiiGridView.update('dokter-v-grid3', {
                    data: {
                        "PegawairuanganV[kelompokpegawai_id]": kelompok_id,
                        "PegawairuanganV[default]": def,
                    }
                });
            }, 500);
        } else {
            def = '';
            setTimeout(function() {
                //$("#dialogPpds").removeClass('animation-loading-1');                               

                $.fn.yiiGridView.update('dokter-all-grid', {
                    data: {
                        "PegawaiV[default]": def,
                    }
                });
            }, 500);
        }
    }

    function hapusRiwayatPerawatan(id) {
        myConfirm('Apakah anda yakin akan menghapus data ini ?', 'Perhatian!', function(r) {
            if (r) {
                $.ajax({
                    url: '<?= $this->createUrl('hapusRiwayatPerawatan') ?>',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data.sukses == 1) {
                            toastr.success(data.pesan, "Perhatian");
                            location.href = "<?= $this->createUrl('index&pendaftaran_id=') . $_GET['pendaftaran_id'] ?>";
                        } else {
                            toastr.error(data.pesan, "Perhatian");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                })
            }
        })
    }

    function print(id) {
        window.open('<?php echo $this->createUrl('print'); ?>&id=' + id, 'printwin', 'left=100,top=100,width=640,height=640');
    }

    $(document).ready(function() {
        // disable form ketika mode "lihat"
        <?php if (isset($_GET['mode'])) { ?>
            $("#rencanaperawatandialisis-t-form").find('input,select,textarea, button').each(function() {
                $(this).attr('disabled', true);
            });
            setTimeout(function() {
                $('.perencanaan > .redactor_box > .redactor_frame').contents().find('body > #page').attr("contenteditable", false);
                $('.instruksi > .redactor_box > .redactor_frame').contents().find('body > #page').attr("contenteditable", false);
            }, 500);
        <?php } ?>
    })
</script>