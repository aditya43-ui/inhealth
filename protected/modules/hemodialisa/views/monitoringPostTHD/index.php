<?php
$this->breadcrumbs = array(
    'Monitoring Post HD',
);


?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'monitoringpost-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>

<style>
    .groupUkurans{
        display:inline;
    }
    .numbers-only{
        text-align: right;
    }
    .form-horizontal .control-label{
        text-align: left;
    }
    a.accordion-toggle{
        color: #045702 !important;
        text-decoration: none !important;
        background: #BDEDBC none repeat scroll 0% 0% !important;
        border: 1px solid #b4e8a8 !important;
        font-weight: inherit !important;
        padding: 10px !important;
        font-size: 14px !important;
        border-radius: 5px 5px 0px 0px !important;
    }
    .accordion-inner{
        border: 1px solid #b4e8a8 !important;
    }
</style>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'list-rujukankeluar',
    'content' => array(
        'content-list-rujukankeluar' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik Untuk Menampilkan Riwayat Monitoring Pasien Post HD')) . '<b> Riwayat Monitoring Pasien Post HD</b>',
            'isi' => $this->renderPartial($this->path_view . '_listHD', array(
                'model' => $model,
                'modPendaftaran' => $modPendaftaran,
                'modPasien' => $modPasien,
                'loadRiwayat' => $loadRiwayat
                    ), true),
            'active' => false,
        ),
    ),
));
?>

<div class="row-fluid">
    <?php
        $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <div class="span12" style="margin-bottom: 0px">
        <fieldset class="box row-fluid" style="margin-top: 16px;">

            <div class="col-md-6" style="margin: 10px 0px 10px 0px;">
                <div class="control-group " style="margin-top: 10px;">
                    <?php echo CHtml::label('Tanggal dan Jam', 'tanggal', array('class' => 'control-label required')) ?>
                    <div class="controls">
                        <?php
//                           (isset($model->waktu_prescription)) ? $model->waktu_prescription : date('d-m-Y');
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'waktu',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                'yearRange' => "-60:+0",
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">DPJP</label>
                    <div class="controls">
                        <?= $form->HiddenField($model, 'dpjp_id', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
                        <?= $form->textField($model, 'dpjp_nama', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => '', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6"  style="margin: 10px 0px 10px 0px;">
                <div class="control-group "  style="margin-top: 10px;">
                    <?php echo CHtml::label('Perawat 1', 'perawat1_id', array('class' => 'control-label')) ?>
                    <?php echo CHtml::activeHiddenField($model, 'perawat1_id', array('readonly' => true, 'style' => 'width:110px;')); ?>
                    <div class="controls">
                        <div class="input-append" style='display:inline'>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'perawat1_nama',
                                'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                            url: "' . $this->createUrl('AutoCompletePerawat') . '",
                                                            dataType: "json",
                                                            data: {
                                                                    term: request.term,
                                                                    perawat_id: $("#perawat1_id").val(),
                                                            },
                                                            success: function (data) {
                                                                    response(data);
                                                            }
                                                    })
                                            }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                                            $(this).val( ui.item.label);
                                                            return false;
                                                     }',
                                    'select' => 'js:function( event, ui ) {
                                                            $("#perawat1_id").val(ui.item.perawat1_id);
                                                            $("#perawat1_nama").val(ui.item.perawat1_nama);
                                                            return false;
                                                    }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPerawat1'),
                                'htmlOptions' => array('class' => 'span4'),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Perawat 2', 'perawat2_id2', array('class' => 'control-label')) ?>
                    <?php echo CHtml::activeHiddenField($model, 'perawat2_id2', array('readonly' => true, 'style' => 'width:110px;')); ?>
                    <div class="controls">
                        <div class="input-append" style='display:inline'>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'perawat2_nama',
                                'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                            url: "' . $this->createUrl('AutoCompletePerawat') . '",
                                                            dataType: "json",
                                                            data: {
                                                                    term: request.term,
                                                                    perawat_id: $("#perawat2_id2").val(),
                                                            },
                                                            success: function (data) {
                                                                    response(data);
                                                            }
                                                    })
                                            }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                                            $(this).val( ui.item.label);
                                                            return false;
                                                     }',
                                    'select' => 'js:function( event, ui ) {
                                                            $("#perawat2_id2").val(ui.item.perawat2_id2);
                                                            $("#perawat2_nama").val(ui.item.perawat2_nama);
                                                            return false;
                                                    }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPerawat2'),
                                'htmlOptions' => array('class' => 'span4'),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </fieldset>
    </div>
</div>
<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'list-evaluasikeperawatan',
    'content' => array(
        'content-list-evaluasikeperawatan' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini hide', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Menampilkan Form Evaluasi Keperawatan Post HD')) . ' Evaluasi Keperawatan Post HD',
            'isi' => $this->renderPartial($this->path_view . '_evaluasikeperawatan', array(
                'form' => $form,
                'model' => $model,                
                    ), true),
            'active' => true,
        ),
    ),
));
?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'list-evaluasikeperawatan',
    'content' => array(
        'content-list-evaluasikeperawatan' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini hide', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Menampilkan Form Catatan')) . ' Catatan',
            'isi' => $this->renderPartial($this->path_view . '_catatan', array(
                'form' => $form,
                'model' => $model,
                    ), true),
            'active' => true,
        ),
    ),
));

$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'riwayat1',
    'content' => array(
        'content-riwayat1' => array(
            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini hide', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk Menampilkan Dischard Planning')) . ' Dischard Planning',
            'isi' => $this->renderPartial($this->path_view . '_tabelDischardPlanning', array(
                'model' => $model, 'form' => $form, 'modAlatBahan' => $modAlatBahan, 'modPrescription' => $modPrescription, 'modKelengkapanAlat' => $modKelengkapanAlat, 'modResephd' => $modResephd,
                    ), true),
            'active' => true,
        ),
    ),
));
?>
<div class="control-group ">
<?php echo CHtml::label('HD yang akan datang', 'tanggal', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php
    $this->widget('MyDateTimePicker', array(
        'model' => $modAkandatang,
        'attribute' => 'jadwalhemodialisa_tgl_ke',
        'mode' => 'date',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'yearRange' => "-20:+20",
        ),
        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
        ),
    ));
    
    $drop_shift = CHtml::listData(ShiftHdM::model()->findAll(" shift_hd_aktif = TRUE ORDER BY shift_hd_nama ASC "), 'shift_hd_id', 'shift_hd_nama');
//    if (!empty($modAkandatang->jadwalhemodialisa_id)) 
//        $drop_shift = CHtml::listData(HDMonitoringPostHdT::model()->getShift($modAkandatang->jadwalhemodialisa_id), 'shift_id', 'shift_nama');
    
    echo $form->dropDownList($modAkandatang, 'shift_id', $drop_shift, array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'empty' => '--Pilih--')); 
    ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="form-actions">
<?php
if (isset($_GET['sukses'])) {
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'id' => 'btn_submit', 'disabled' => true)) . "&nbsp";
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&konsulpoli_id='.$_GET['konsulpoli_id'].'&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
    )) . "&nbsp";
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ",'".(isset($_GET['post_hd_id'])?$_GET['post_hd_id']:'')."');return false")) . "&nbsp;";
} else {
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'id' => 'btn_submit', 'onclick' => 'cekInsert();', 'onKeypress' => 'cekInsert();', 'disabled' => (isset($_GET['sukses'])) ? true : false)) . "&nbsp";
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id']), array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index&konsulpoli_id='.$_GET['konsulpoli_id'].'&pendaftaran_id=' . $_GET['pendaftaran_id']) . '";}); return false;'
    )) . "&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
}
?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPerawat1',
    'options' => array(
        'title' => 'Kelas Terapi Obat',
        'autoOpen' => false,
        'position' => ['top', 20],
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$modPegawai->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'therapiobat-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                        "id" => "selectObat",
                        "onClick" => "
                            $(\"#HDMonitoringPostHdT_perawat1_id\").val(\"$data->pegawai_id\");
                            $(\"#HDMonitoringPostHdT_perawat1_nama\").val(\"$data->nama_pegawai\");
                            $(\'#dialogPerawat1\').dialog(\'close\');
                            return false;"))',
        ),
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPerawat2',
    'options' => array(
        'title' => 'Kelas Terapi Obat',
        'autoOpen' => false,
        'position' => ['top', 20],
        'modal' => true,
        'width' => 550,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$modPegawai->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'therapiobat-grid',
    'dataProvider' => $modPegawai->searchDialogPegRuangan(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                        "id" => "selectObat",
                        "onClick" => "
                            $(\"#HDMonitoringPostHdT_perawat2_id2\").val(\"$data->pegawai_id\");
                            $(\"#HDMonitoringPostHdT_perawat2_nama\").val(\"$data->nama_pegawai\");
                            $(\'#dialogPerawat2\').dialog(\'close\');
                            return false;"))',
        ),
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<script>
    $(document).ready(function () {
        var perubahan = $("#HDMonitoringPostHdT_perubahan[checked='checked']").val();
        console.log(perubahan)
        cekCatatan();
        checkDialysateLain();
        cekHeparinisasiTanpaHeparin();
        cekHeparinisasiLainnya();
        gen_ext();
        cekMeninggal($(".cek-meninggal"))

        // disable form ketika mode "lihat"
<?php if (isset($_GET['mode'])) { ?>
            $("#monitoringpost-t-form").find('input,select,textarea, button').each(function () {
                $(this).attr('disabled', true);
            });
<?php } ?>
    });

    function addRow() {
        var key = $('.tr-kelengkapanAlat:last').attr("baris");
        if (key == null) {
            var key = 0;
        }
        var keyNew = parseInt(key) + 1;
        var no = $('.td-no:last').attr("baris");
        if (no == null) {
            var no = 0;
        }
        var noNew = parseInt(no) + 1;
        $.ajax({
            url: '<?= $this->createUrl('addRowKelengkapanAlat'); ?>',
            dataType: 'json',
            type: 'post',
            data: {key: keyNew, no: noNew},
            success: function (data) {
                console.log(data);
                $('#table-kelengkapanAlat > tbody > tr:last').after(data.form);
                gen_ext();
            }
        })
    }

    function setRow(obj) {
        let no = $(obj).parents("tr").attr('baris')

        $("#nourut").val(no);
    }

    function hapusBaris(obj) {
        $(obj).parents("tr").detach();
    }

    function cekHeparinisasiTanpaHeparin() {
        if ($('#HDPrescriptionHdT_heparinisasi_tanpaheparin').is(":checked")) {
            $('#HDPrescriptionHdT_heparinisasi_tanpaheparin_penyebab').attr("disabled", false);
        } else {
            $('#HDPrescriptionHdT_heparinisasi_tanpaheparin_penyebab').attr("disabled", true);
            $('#HDPrescriptionHdT_heparinisasi_tanpaheparin_penyebab').val('');
        }
    }

    function cekHeparinisasiLainnya() {
        if ($('#HDPrescriptionHdT_heparinisasi_lainnya').is(":checked")) {
            $('#HDPrescriptionHdT_heparinisasi_lainnya_penyebab').attr("disabled", false);
        } else {
            $('#HDPrescriptionHdT_heparinisasi_lainnya_penyebab').attr("disabled", true);
            $('#HDPrescriptionHdT_heparinisasi_lainnya_penyebab').val('');
        }
    }
    
    var cekMeninggal = (obj) => {
        var cek = $(obj).prop("checked");
        if (cek){
            $(".waktu_meninggal").removeAttr("disabled");
            $(obj).parents('.control-group').find('.add-on').show();
        }else{
            $(".waktu_meninggal").attr("disabled", true);
            $(".waktu_meninggal").val("");
            $(obj).parents('.control-group').find('.add-on').hide();
        }
    }

    function cekCatatan() {
        if ($('#HDMonitoringPostHdT_catatan_lainnya').is(":checked")) {            
            $('#HDMonitoringPostHdT_catatan_lainnya_keterangan').removeAttr("disabled");
        } else {
            $('#HDMonitoringPostHdT_catatan_lainnya_keterangan').attr("disabled", true);
            $('#HDMonitoringPostHdT_catatan_lainnya_keterangan').val('');
        }
    }

    function checkDialysateLain() {
        if ($('#HDPrescriptionHdT_dialysate_lainnya').is(":checked")) {
            $('#HDPrescriptionHdT_dialysate_lainnya_keterangan').attr("disabled", false);
        } else {
            $('#HDPrescriptionHdT_dialysate_lainnya_keterangan').attr("disabled", true);
            $('#HDPrescriptionHdT_dialysate_lainnya_keterangan').val("");
        }
    }

    function cekInsert() {
        var perubahan = $("#HDMonitoringPostHdT_perubahan:checked").val();
        if (perubahan == null) {
            alert("Pilih dahulu apakah ada perubahan pada perawatan selanjutnya ?");
            return false;
        } else {
            $('#monitoringpost-t-form').submit();
            disableOnSubmit($("#btn_submit"))
        }

    }
    function cekPerubahan(param) {
        console.log(param);
        if (param == 'ya') {
            $('.pres_2').attr("hidden", false);
            $('.kelengkapan_alat').attr("hidden", false);
        } else {
            $('.pres_2').attr("hidden", true);
            $('.kelengkapan_alat').attr("hidden", true);
        }
    }
    function hapusPost(id) {
        console.log(id);
        myConfirm('Apakah anda yakin menghapus data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.ajax({
                    url: '<?= $this->createUrl('hapusPostHd') ?>',
                    dataType: 'json',
                    type: 'post',
                    data: {id: id},
                    success: function (data) {
                        if (data.sukses == 1) {
                            toastr.success(data.pesan, "Perhatian!");
                            location.href = '<?= $this->createUrl('index&pendaftaran_id=') . $_GET['pendaftaran_id'].'&konsulpoli_id='.$_GET['konsulpoli_id'] ?>';
                        } else {
                            toastr.error(data.pesan, "Perhatian!");
                        }
                    }
                })
            }
        })
    }
    function print(pendaftaran_id, monitoringpostid)
    {
        window.open('<?php echo $this->createUrl('print'); ?>&monitoringpostid=' + monitoringpostid + '&id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=640,height=640');
    }

    function load_resep(paket_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadPaket'); ?>',
            data: {paket_id: paket_id},
            dataType: "json",
            success: function (data) {
                $("#table-kelengkapanAlat > tbody").html(data.tr);
                gen_ext();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function setObat(obj, data){
        $(obj).parents("tr").find('.obatalkes_id').val(data.obatalkes_id);
        $(obj).parents("tr").find('.obatalkes_nama').val(data.obatalkes_nama);
        
        $("#dialogKelengkapanAlat").dialog('close');
    }

    function gen_ext() {
        $("#table-kelengkapanAlat").find('.obatalkes_nama').autocomplete(
                {
                    'showAnim': 'fold',
                    'minLength': 3,
                    'focus': function (event, ui)
                    {
                        $(this).val(ui.item.label);
                        return false;
                    },
                    'select': function (event, ui)
                    {
                        setObat(this, ui.item)
                        return false;
                    },
                    'source': function (request, response)
                    {
                        $.ajax({
                            url: "<?php echo $this->createUrl('/actionAutoComplete/ObatAlkesPartograf'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }
                }
        );
    }
</script>
