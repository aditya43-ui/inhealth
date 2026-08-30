<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapemnelianlangsung-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<!--<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <strong>Berita Acara Pemeriksaan Pekerjaan</strong></div>
    </div>
    <div class="panel-body">-->
<div class="panel-group joined" id="accordion-khp"> 
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #a6db9c"> 
                <a data-toggle="collapse" data-parent="#accordion-khp" href="#riwayat" aria-expanded="true" class="">
                    Riwayat Berita Acara Pemeriksaan Pekerjaan
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff">
                <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'modSPKRincian' => $modSPKRincian, 'form' => $form), true); ?>
            </div> 
        </div> 
    </div> 
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #b0eaa5"> 
                <a data-toggle="collapse" data-parent="#accordion-khp" href="#transaksi" class="" aria-expanded="false">
                    Berita Acara Pemeriksaan Pekerjaan
                </a> 
            </h4> 
        </div> 
        <div id="transaksi" class="panel-collapse collapse in" aria-expanded="true"> 
            <div class="panel-body" style="background-color: #fff">

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Data Berita Acara Pemeriksaan Pekerjaan</span></div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formPemeriksaan', array('model' => $model, 'modSPK' => $modSPK, 'form' => $form)); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Tim Teknis</span></div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formTimTeknisBaru', array('modPegawai' => $modTeknisi, 'form' => $form)); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Lampiran</span></div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formLampiran', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'modSPKRincian' => $modSPKRincian, 'form' => $form)); ?>
                    </div>
                </div>
                <br>
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php
                        $cekpemeriksaanpekerjaan = BapemeriksaanpekerjaanT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                        $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;

                        $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                        $jumlahTermin = count($cekTermin);
                        if ($modSPK->istermin == true) {
                            if ($jumlahpemeriksaan > $jumlahTermin && empty($_GET['bapemeriksaanpekerjaan_id'])) {
                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                                echo "&nbsp;";
                            } else {
                                if (!isset($_GET['sukses'])) {
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
                                    echo "&nbsp;";
                                } else {
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                                    echo "&nbsp;";
                                }
                            }
                        } else {
                            if ($jumlahpemeriksaan > 1 && empty($_GET['bapemeriksaanpekerjaan_id'])) {
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                                    echo "&nbsp;";
                                } else {
                                    if (!isset($_GET['sukses'])) {
                                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
                                        echo "&nbsp;";
                                    } else {
                                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                                        echo "&nbsp;";
                                    }
                                }
                        }
                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id)), array('class' => 'btn btn-danger', 'onclick' => 'return refreshForm(this);'));
                        echo "&nbsp;";
                        ?>
                    </div>
                </div>

            </div> 
        </div> 
    </div> 
</div>
<!--    </div>
</div>-->

<?php
$this->endWidget();

$urlGetRiwayat = $this->createUrl('GetRiwayat');
$suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];

$id = $_GET['suratperjanjiankerja_id'];
$cekTimteknis = PegtimteknisT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
if (!empty($cekTimteknis)) {
    $ada = 'ada';
} else {
    $ada = '';
}

if (!empty($_GET['bapemeriksaanpekerjaan_id'])) {
    $update = 'iya';
    $pemeriksaanpekerjaan_id = $_GET['bapemeriksaanpekerjaan_id'];
} else {
    $update = 'tidak';
}

$pemeriksaanpekerjaan_id = $model->bapemeriksaanpekerjaan_id;
?>
<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pemeriksaan Pekerjaan',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 750,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframe1" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<script>    
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->bapemeriksaanpekerjaan_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

    function cekRiwayat(obj) {
        var suratperjanjiankerja_id = <?php echo $suratperjanjiankerja_id ?>;
        if (suratperjanjiankerja_id !== "") {
            $.post("<?php echo $urlGetRiwayat ?>", {suratperjanjiankerja_id: suratperjanjiankerja_id, },
                    function (data) {
                        $("#tableRiwayat").children("tbody").append(data.tr);
                    }, "json");
        } else {
            myAlert("Silahkan pilih data Surat Perjanjian Kerja !");
        }
        return false;

    }

    function cekHasil() {
        var tidak_semua = 0;
        $('#tabel_lampiran').find("tbody > tr").each(function () {
            if ($(this).find('.hasil_pemeriksaan').is(":checked")) {
            } else {
                tidak_semua++;
            }
        });

        if (tidak_semua == 0) {
            $("#<?= CHtml::activeId($model, 'bapemeriksaanpekerjaan_hasil') ?>").val('Sesuai Kontrak');
        } else {
            $("#<?= CHtml::activeId($model, 'bapemeriksaanpekerjaan_hasil') ?>").val('Tidak Sesuai Kontrak');
        }
    }

    function renameInput(obj_table) {
        var row = 0;
        var jmlRow = $('#tabelTimTeknis tbody tr').length;
        if (jmlRow == 1) {
            $("#tabelTimTeknis > tbody > tr:last .tambahRow").attr('style', 'display:true;');
            $("#tabelTimTeknis > tbody > tr:last .hapusRow").attr('style', 'display:none;');
        } else {
            $("#tabelTimTeknis > tbody > tr:last .tambahRow").attr('style', 'display:true;');
            $("#tabelTimTeknis > tbody > tr .hapusRow").attr('style', 'display:true;');
        }
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).attr('data-row', row);
            $(this).find('span[name*="[ii]"]').each(function () { //element <span>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
    }

    function tambahBaris()
    {
        var row = '<?php echo CJSON::encode($this->renderPartial('_rowTimTeknis', array('modPegawai' => $modTeknisi, 'i' => 1), true)); ?>';

        $("#tabelTimTeknis > tbody > tr:last .tambahRow").attr('style', 'display:none;');
        $("#tabelTimTeknis > tbody > tr:last .hapusRow").attr('style', 'display:true;');
        $('#tabelTimTeknis > tbody').append(row);
        renameInput('#tabelTimTeknis');
        generatePicker();
        jQuery('input[name$="[nama_pegawai]"]').autocomplete(
                {
                    'showAnim': 'fold',
                    'minLength': 3,
                    'focus': function (event, ui)
                    {
                        $(this).val(ui.item.nama_pegawai);
                        return false;
                    },
                    'select': function (event, ui)
                    {
                        setPegAuto($(this), ui.item);
                        return false;
                    },
                    'source': function (request, response)
                    {
                        $.ajax({
                            url: "<?php echo $this->createUrl('AutocompletePegawai'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    }
                });
    }

    function generatePicker() {
        $('#tabelTimTeknis').find("tbody > tr").each(function () {
            jQuery('input[name$="[nama_pegawai]"]').autocomplete(
                    {
                        'showAnim': 'fold',
                        'minLength': 3,
                        'focus': function (event, ui)
                        {
                            $(this).val(ui.item.nama_pegawai);
                            return false;
                        },
                        'select': function (event, ui)
                        {
                            setPegAuto($(this), ui.item);
                            return false;
                        },
                        'source': function (request, response)
                        {
                            $.ajax({
                                url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/getTimTeknis'); ?>",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function (data) {
                                    response(data);
                                }
                            });
                        }
                    });

        });
    }

    function setDialog(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        var no = $(obj).parents("tr").data('row');
        $("#no_row").val(parseInt(no));
        dialog = "#dialog1";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    // Set Pegawai Dialog
    function setPegawaiDialog(pegawai_id) {
        var dialog = "#dialog1";
        var no = $("#no_row").val()
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        ;

        var ada = 0;
        $("#tabelTimTeknis > tbody > tr").each(function () {
            var pegawai_id_temp = $(this).find('input[name$="[pegawai_id]"]').val();
            if (pegawai_id == pegawai_id_temp) {
                ada++;
            }
        });

        if (ada == 0) {
            $.get('<?php echo $this->createUrl('AutocompletePegawai'); ?>', {pegawai_id: pegawai_id}, function (data) {
                $("#tabelTimTeknis > tbody > tr").each(function () {
                    if ($(this).attr('data-row') == no) {
                        setPeg($(this).find('input[name$="[pegawai_id]"]'), data[0]);
                    }
                });

            }, "json");
        } else {
            myAlert("Data Pegawai sudah ditambahkan di tabel, silahkan pilih data Pegawai yang lain");
        }

        $(dialog).dialog("close");
    }

    function setPeg(obj, item) {
        var ada = 0;
        $("#tabelTimTeknis > tbody > tr").each(function () {
            peg_id = $(this).find('input[name$="[pegawai_id]"]').val();
            if (item.pegawai_id === peg_id) {
                ada++;
            }
        });

        if (ada == 0) {
            $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val(item.pegawai_id);
            $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val(item.nama_pegawai);
            $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val(item.nomorindukpegawai);
            if ($(obj).parents('tr').attr('data-row') == 0) {
                $("#ADBapemeriksaanpekerjaanT_pa_tanggalsk").val(item.tgl_sk);
                $("#ADBapemeriksaanpekerjaanT_pa_nomorsk").val(item.no_sk);
            }
        } else {
            myAlert("Data Pegawai sudah ditambahkan di tabel, silahkan pilih data Pegawai yang lain");
            $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val('');
            $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val('');
            $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val('');
            $(obj).val('');
        }
    }

    function setPegAuto(obj, item)
    {
        var ada = 0;
        $("#tabelTimTeknis > tbody > tr").each(function () {
            pegawai_id_temp = $(this).find('input[name$="[pegawai_id]"]').val();
            if (item.pegawai_id == pegawai_id_temp) {
                ada++;
            }
        });
        if (ada == 0) {
            $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val(item.pegawai_id);
            $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val(item.nama_pegawai);
            $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val(item.nomorindukpegawai);
            if ($(obj).parents('tr').attr('data-row') == 0) {
                $("#ADBapemeriksaanpekerjaanT_pa_tanggalsk").val(item.tgl_sk);
                $("#ADBapemeriksaanpekerjaanT_pa_nomorsk").val(item.no_sk);
            }
        } else {
            myAlert("Data Pegawai sudah ditambahkan di tabel, silahkan pilih data Pegawai yang lain");
            $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val('');
            $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val('');
            $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val('');
        }
    }

    function hapusBaris(obj) {
        myConfirm("Apakah Anda yakin, ingin menghapus data ini ?", "Perhatian !", function (r) {
            if (r) {
                $(obj).parents("tr").remove();
                renameInput($("#tabel-pphp"));
            }
        });
    }

    function hapusData(obj) {
        myConfirm('Apakah anda akan menghapus data ini??', 'Perhatian!',
                function (r) {
                    if (r) {

                        $(obj).parents('tr').hide();
                        $(obj).parents("tr").find(".status").val(1);

                    }
                });

    }

    function setPegawai() {
        if ('<?php echo $update ?>' === 'iya') {
            var pemeriksaanpekerjaan_id = '<?php echo $pemeriksaanpekerjaan_id ?>';
            var id = '<?php echo $id; ?>';
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('GetPegawai'); ?>',
                data: {
                    id: id, pemeriksaanpekerjaan_id: pemeriksaanpekerjaan_id
                },
                dataType: "json",
                success: function (data) {
                    $('#tabelTimTeknis > tbody').append(data.form);
                    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                    renameInput($("#tabelTimTeknis"));
                    generatePicker();
                    $("#tabelTimTeknis").removeClass("animation-loading");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            tambahBaris();
        }
    }

    $(document).ready(function () {
     $('.integer-decimal').each(function(){
           $(this).val(formatThousandDecimal(parseFloat($(this).val())));
       });
        cekRiwayat();
        $("#tabelTimTeknis > tbody > tr .tambahRow").attr('style', 'display:true;');
        if ('<?php echo $ada ?>' !== '') {
            setPegawai();
        } else {
            tambahBaris();
        }
<?php if (isset($_GET['sukses'])) { ?>
            $('input').attr('readonly', true);
            $('.add-on').hide();
<?php } ?>
        cekHasil();
    });
    
    document.getElementById("ADBapemeriksaanpekerjaanT_dokumen_pendukung").onchange = function () {
        
       
        if (this.files[0].size > 5000000) {
            toastr.error('Ukuran maksimal dokumen 5mb');
            $("#ADBapemeriksaanpekerjaanT_dokumen_pendukung").attr("src", "blank");
            $('#ADBapemeriksaanpekerjaanT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#ADBapemeriksaanpekerjaanT_dokumen_pendukung').unwrap();
            return false;
        }
    }
</script>