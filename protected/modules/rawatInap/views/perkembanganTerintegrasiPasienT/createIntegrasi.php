<?php
$myicon = new MyIcon();
$this->breadcrumbs = array(
    'Perkembangan Terintegrasi Pasien',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data anamnesa berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');

$path_view = !empty($path_view)?$path_view:$this->path_view;
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'integrasi-pasien-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#nama_pegawai',
        ));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.taggd.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/taggd.css'); ?>
<div class="row-fluid">
    <?php
    echo $this->renderPartial($path_view . '_dataPasien', array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
            ), true);
//    
    if ($this->init != 'HD') {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'tindakan-anestesi',
            'content' => array(
                'content-tindakan-anestesi' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat anamnesa')) . '<b> Riwayat Perkembangan Terintegrasi Pasien</b>',
                    'isi' => $this->renderPartial($path_view . '_table', array('form' => $form, 'modTampilAsesmen' => $modTampilAsesmen, 'modPenunjang' => $modPenunjang, 'model' => $model), true),
                    'active' => false,
                ),
            ),
        ));
    }
    ?>  

    <?php
    if (isset($_GET['transfusi'])) {
        $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
//            print_r(Yii::app()->user->getState('lookup_id'));die;
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $model->nama_pegawai = $pegawai->nama_pegawai;
    }
    ?>
</div>
<div class="panel panel-gradient">
    <?php
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <div class="panel-heading">
<?php if ($this->init == 'HD') { ?>
            <div class="panel-title"><strong>Perkembangan Terintegrasi Pasien</strong></div>
        <?php } else { ?>
            <div class="panel-title"><strong>Perkembangan Terintegrasi Pasien</strong></div>
        <?php } ?>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <label class="control-label">Waktu Pemeriksaan <span class="required">*</span></label>
                <div class="controls">  
<?php
$this->widget('MyDateTimePicker', array(
    'model' => $model,
    'attribute' => 'tgltransaksi',
    'mode' => 'datetime',
    'options' => array(
        'dateFormat' => Params::DATE_FORMAT,
        'maxDate' => 'd',
    ),
    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3 required',
        'onkeypress' => "return $(this).focusNextInputField(event)"),
));
?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Profesi <span class="required">*</span></label>
                <div class="controls">  
<?php
echo $form->dropDownList($model, 'profesi', LookupM::getItemsUrutan('profesi'), array('empty' => '--Pilih--', 'class' => 'span3 required', 'onchange' => "changeProfesi(this); pilihDialog(this);"));
echo $form->hiddenField($model, 'kelompok_pegawai', array('class' => 'kelompok'));
?>
                </div>
            </div>
        </div>
<?php
$requiredpegawai = '';
$requiredppds = '';
$pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
if (!empty($pegawai)) {
    $requiredpegawai = ''; //required dihilangkan dulu
    $requiredppds = '';
}

$ppds = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));
if (!empty($ppds)) {
    $requiredpegawai = '';
    $requiredppds = ''; //required dihilangkan dulu
}
?>
        <div class="col-sm-6">
            <span id="pilih_pegawai" style="display: block">
                <div class="control-group ">
<?php echo CHtml::label(!empty($requiredpegawai) ? 'Pegawai <span class="required">*</span>' : 'Pegawai ', 'ppds', array('class' => 'control-label')); ?>
                    <div class="controls">  
                    <?php
                    echo CHtml::activeHiddenField($model, 'pegawai_id', array('readonly' => true));
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'nama_pegawai',
                        'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . Yii::app()->createUrl('rawatInap/PerkembanganTerintegrasiPasienT/GetPegawai') . '",
                                            dataType: "json",
                                            data: {
                                               term: request.term,
                                               kelompokpegawai: $(".kelompok").val()
                                            },
                                            success: function (data) {
                                                response(data);
                                            }
                                    })
                                 }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.label);
                                            $("#RIPerkembanganTerintegrasiPasienT_pegawai_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 ' . $requiredpegawai, 'placeholder' => 'Ketikkan Nama Pegawai  '),
                        'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                    ));
                    ?>
                    </div>
                </div>
            </span>
            <span id="pilih_ppds" style="display: none">
                <div class="control-group">
<?php echo CHtml::label(!empty($requiredppds) ? 'PPDS <span class="required">*</span>' : 'PPDS ', 'ppds', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php
                    echo $form->hiddenField($model, 'ppds_id', array('readonly' => true));
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'ppds_nama',
                        'value' => $model->ppds_nama,
                        'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('AutocompletePpds') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                            },
                                            success: function (data) {
                                                response(data);
                                            }
                                        })
                            }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.value);
                                    return false;
                                }',
                            'select' => 'js:function( event, ui ) {
    //                                $("#InfokunjunganriV_no_pendaftaran").val(ui.item.no_pendaftaran);
                                    return false;
                                }',
                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 ' . $requiredppds, 'placeholder' => 'PPDS'),
                        'tombolDialog' => array('idDialog' => 'dialogPpds'),
                    ));
                    ?>
                    </div>
                </div>
            </span>
        </div>
        <br>
<?php
$path_view = !empty($this->path_perkembangan)?$this->path_perkembangan:$path_view;
echo $this->renderPartial($path_view . '_formInput', array('model' => $model, 'form' => $form));
?>        
        <div class="form-actions" id="form-aksi">
        <?php
//            if (!isset($_GET['sukses'])) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')) . '&nbsp;';
//            } else {
//                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => TRUE, 'id' => 'btn_simpan')) . '&nbsp;';
//            }

        if (isset($_GET['transfusi'])) {
            if (isset($_GET['sukses'])) {
                $perkembangan_id = isset($_GET['perkembangan_terintegrasi_pasien_id']) ? $_GET['perkembangan_terintegrasi_pasien_id'] : '';
                echo CHtml::link(Yii::t('mds', '{icon} Print Form Clothing', array('{icon}' => '<i class="icon-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success', 'onclick' => "printFormClothing($perkembangan_id);return false", 'id' => 'btn-print-form-clothing')) . "&nbsp;";

                echo CHtml::link(Yii::t('mds', '{icon} Print Soapi', array('{icon}' => '<i class="icon-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success', 'onclick' => "print();return false", 'id' => 'btn-print-form-clothing')) . "&nbsp;";
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Form Clothing', array('{icon}' => '<i class="icon-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success', 'disabled' => true, 'id' => 'btn-print-form-clothing')) . "&nbsp;";

                if ($this->init != 'HD') {
                    echo CHtml::link(Yii::t('mds', '{icon} Informasi Integrasi', array('{icon}' => '<i class="entypo-add"></i>')), $this->createUrl('index', array('id' => $modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => !empty($modAdmisi->pasienadmisi_id) ? $modAdmisi->pasienadmisi_id : null)), array('class' => 'btn btn-success')) . "&nbsp";
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print Soapi', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:;', array('class' => 'btn btn-success', 'disabled' => true)) . "&nbsp";
                }
            }
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Informasi Integrasi', array('{icon}' => '<i class="entypo-add"></i>')), $this->createUrl('index', array('id' => $modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => !empty($modAdmisi->pasienadmisi_id) ? $modAdmisi->pasienadmisi_id : null)), array('class' => 'btn btn-success')) . "&nbsp";
        }
        ?>
            <?php
            $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>
    </div>

</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
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
    'id' => 'dokter-v-grid2',
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
                                $(\"#RIPerkembanganTerintegrasiPasienT_pegawai_id\").val(\"$data->pegawai_id\");
                                $(\"#RIPerkembanganTerintegrasiPasienT_nama_pegawai\").val(\"$data->nama_pegawai\");
                                $(\"#dialogPegawai\").dialog(\"close\");
                                return false;
                        "
                    ))',
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'type' => 'raw',
            'filter' => CHtml::activeHiddenField($datPerawat, 'kelompokpegawai_id', array('class' => 'dialogpegawai_kelompokpegawai_id')) . CHtml::activeTextField($datPerawat, 'nama_pegawai', array())
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($datPerawat, 'jabatan_id', CHtml::listData(
                            JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'
                    ), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                if (!empty($data->jabatan_nama)) {
                    return $data->jabatan_nama;
                } else {
                    return "-";
                }
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end data pegawai =============================
?>

<?php
//========= Dialog buat cari data PPDS  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPpds',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPpds = new PpdsM('searchPPDS');
$modPpds->unsetAttributes();
$modPpds->ppds_aktif = true;

if (isset($_GET['PpdsM'])) {
    $modPpds->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m-grid',
    'dataProvider' => $modPpds->searchPPDS(),
    'filter' => $modPpds,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                        "id" => "selectPendaftaran",
                        "onClick" => "
                            $(\"#dialogPpds\").dialog(\"close\");
                            $(\"#RIPerkembanganTerintegrasiPasienT_ppds_id\").val(\"$data->ppds_id\"); 
                            $(\"#ppds_nama\").val(\"$data->ppds_nama\");

                        "))',
        ),
        array(
            'header' => 'Nama PPDS',
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ),
        array(
            'header' => 'NIM',
            'name' => 'ppds_nim',
            'value' => '$data->ppds_nim'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Search data PPDS =============================
?>
<script>

    //Digunakan untuk mengganti autocomplete jika memilih profesi PPDS
    function changeProfesi(obj) {
        var x = document.getElementById("pilih_ppds");
        var y = document.getElementById("pilih_pegawai");
        var pegawai_id = document.getElementById("RIPerkembanganTerintegrasiPasienT_pegawai_id");
        var nama_pegawai = document.getElementById("nama_pegawai");
        var ppds_id = document.getElementById("RIPerkembanganTerintegrasiPasienT_ppds_id");
        var ppds_nama = document.getElementById("ppds_nama");
        if (obj.value == 'PPDS') {
            if (x.style.display === "none" && y.style.display === "block") {
                pegawai_id.value = '';
                //nama_pegawai.value = '';
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
                y.style.display = "block";
            }
        } else {
            if (x.style.display === "block" && y.style.display === "none") {
                ppds_id.value = '';
                ppds_nama.value = '';
                x.style.display = "none";
                y.style.display = "block";
            }
        }
    }

    function pilihDialog(obj) {
        if (obj.value == 'DPJP') {
            $(".kelompok").val(<?php echo Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK ?>);
        } else if (obj.value == 'KEPERAWATAN') {
            $(".kelompok").val(<?php echo Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN ?>);
        } else if (obj.value == 'KETERAPIAN FISIK') {
            $(".kelompok").val(<?php echo Params::KELOMPOKPEGAWAI_ID_KETERAPIAN_FISIK ?>);
        } else if (obj.value == 'TENAGA GIZI') {
            $(".kelompok").val(<?php echo Params::KELOMPOKPEGAWAI_ID_TENAGA_GIZI ?>);
        } else if (obj.value == 'APOTEKER') {
            $(".kelompok").val(<?php echo Params::KELOMPOKPEGAWAI_ID_APOTEKER ?>);
        }

        var kelompok_id = $(".kelompok").val();
        var def = '';
        if (kelompok_id == "") {
            def = 'ada';
        }

        $(".dialogpegawai_kelompokpegawai_id").val(kelompok_id);

        setTimeout(function () {
            //$("#dialogPpds").removeClass('animation-loading-1');                               

            $.fn.yiiGridView.update('dokter-v-grid2', {
                data: {
                    "PegawairuanganV[kelompokpegawai_id]": kelompok_id,
                    "PegawairuanganV[default]": def,
                }
            });
        }, 500);
    }

    function stopTindakanDialisis(id) {
        var konsulpoli_id = '<?= isset($_GET['konsulpoli_id']) ? $_GET['konsulpoli_id'] : null; ?>'
        $.ajax({
            url: '<?= $this->createUrl('stopTindakanDialisis') ?>',
            dataType: 'json',
            type: 'post',
            data: {id: id, konsulpoli_id: konsulpoli_id},
            success: function (data) {
                if (data.sukses == 1) {
                    toastr.success(data.pesan, 'Perhatian!');
                    $('#btn-stop-tindakan-dialisis').attr('disabled', true);
                } else {
                    toastr.error(data.pesan, 'Perhatian!');
                }
            }
        })
    }
    function printFormClothing(id) {
        window.open('<?php echo $this->createUrl('printFormClothing'); ?>&id=' + id, 'printwin', 'left=100,top=100,width=640,height=480');
    }

    function print() {
        window.open('<?php echo $this->createUrl('print', array('pendaftaran_id' => isset($_GET['pendaftaran_id'])?$_GET['pendaftaran_id']:$_GET['id'])); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }


    $(document).ready(function () {

<?php if (!empty($_GET['detail'])) {
    ?>
            $("#integrasi-pasien-t-form").find('input,select,textarea, button').each(function () {
                $(this).attr('disabled', true);
            });
            $('#tindakan-anestesi').hide();
            $('#form-aksi').hide();
            $('a,.add-on').hide();
<?php } ?>


        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');


        var x = document.getElementById("pilih_ppds");
        var y = document.getElementById("pilih_pegawai");
        var profesi = document.getElementById("RIPerkembanganTerintegrasiPasienT_profesi");
        if (profesi.value == 'PPDS') {
            if (x.style.display === "none" && y.style.display === "block") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
                y.style.display = "block";
            }
        } else {
            if (x.style.display === "block" && y.style.display === "none") {
                x.style.display = "none";
                y.style.display = "block";
            }
        }
    });
</script>