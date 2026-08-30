<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapemnelianlangsung-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>
<div class="panel-group joined" id="accordion-khp"> 
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #a6db9c"> 
                <a data-toggle="collapse" data-parent="#accordion-khp" href="#riwayat" aria-expanded="true" class="">
                    Riwayat Berita Acara Pemeriksaan Administratif PPHP
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff">
                <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'form' => $form), true); ?>
            </div> 
        </div> 
    </div> 
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #b0eaa5"> 
                <a data-toggle="collapse" data-parent="#accordion-khp" href="#transaksi" class="" aria-expanded="false">
                    Berita Acara Pemeriksaan Administratif PPHP
                </a> 
            </h4> 
        </div> 
        <div id="transaksi" class="panel-collapse collapse in" aria-expanded="true"> 
            <div class="panel-body" style="background-color: #fff">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Berita Acara Pemeriksaan Administratif PPHP</span></div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formPemeriksaan', array('model' => $model, 'modSPK' => $modSPK, 'form' => $form)); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Panitia Pemeriksa Hasil Pekerjaan PPHP</span></div>
                    </div>
                    <div class="panel-body">
                        <?php echo CHtml::hiddenField('no_row', '', array('readonly' => true, 'class' => 'no_row',)); ?>
                        <?php $this->renderPartial('_formPPHP', array('model' => $model, 'modSPK' => $modSPK, 'form' => $form, 'modPegPPHP' => $modPegPPHP)); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'>Pemeriksaan Administratif</span></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (!empty($model->bapemeriksaanadmpphp_id)) {
                            $this->renderPartial('_ubahtabelPemeriksaanAdm', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'form' => $form));
                        } else {
                            $this->renderPartial('_tabelPemeriksaanAdm', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'form' => $form));
                        }
                        ?>
                        <br>
                        <?php echo $form->textFieldRow($model, 'pemeriksaan_hasil', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <br>
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php
                        $cekpemeriksaanPPHP = BapemeriksaanadmpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                        $jumlahpemeriksaan = count($cekpemeriksaanPPHP) + 1;

                        $cekTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                        $jumlahTermin = count($cekTermin);
                        if ($modSPK->nilaikontrak <= 200000000) {
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => true));
                            echo "&nbsp;";
                        }else{
                            if ($modSPK->istermin == true) {
                                if ($jumlahpemeriksaan > $jumlahTermin && empty($_GET['bapemeriksaanadmpphp_id'])) {
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                                    echo "&nbsp;";
                                } else {
                                    if (!isset($_GET['sukses'])) {
                                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                                        echo "&nbsp;";
                                    } else {
                                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                                        echo "&nbsp;";
                                    }
                                }
                            } else {
                                if ($jumlahpemeriksaan > 1 && empty($_GET['bapemeriksaanadmpphp_id'])) {
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                                    echo "&nbsp;";
                                } else {
                                    if (!isset($_GET['sukses'])) {
                                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                                        echo "&nbsp;";
                                    } else {
                                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                                        echo "&nbsp;";
                                    }
                                }
                            }
                        }
                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index', array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id)), array('class' => 'btn btn-default', 'onclick' => 'return refreshForm(this);'));
                        echo "&nbsp;";
//                        if (empty($model->bapemeriksaanadmpphp_id)) {
//                            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
//                            echo "&nbsp;";
//                        } else {
//                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary-blue', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
//                            echo "&nbsp;";
//                        }
                        ?>
                    </div>
                </div>
            </div> 
        </div> 
    </div> 
</div>
<?php
$this->endWidget();

$cekJumlah = LookupM::model()->findAll("lookup_type = 'dokumenpemeriksaanadministratif'");

$urlGetRiwayat = $this->createUrl('GetRiwayat');
$suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];

if (!empty($_GET['bapemeriksaanadmpphp_id'])) {
    $update = 'iya';
    $bapemeriksaanadmpphp_id = $_GET['bapemeriksaanadmpphp_id'];
} else {
    $update = 'tidak';
}

$bapemeriksaanadmpphp_id = $model->bapemeriksaanadmpphp_id;
?>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRiwayat',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Pemeriksaan Administratif PPHP',
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
        window.open('<?php echo $this->createUrl('print', array('id' => $model->bapemeriksaanadmpphp_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
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

    function setValidasi(obj, id) {
        var total = <?php echo count($cekJumlah) ?>;
        var jumlah = 0;
        $(obj).parents('table').find('input:radio[class="cekLengkap"]:checked').each(function () {
            if ($(this).val() == 1) {
                jumlah++;
            }
        });

        if (jumlah == total) {
            $("#BapemeriksaanadmpphpT_pemeriksaan_hasil").val('Lengkap Sesuai');
        } else {
            $("#BapemeriksaanadmpphpT_pemeriksaan_hasil").val('Lengkap Tidak Sesuai/Tidak Lengkap');
        }
    }

    function generatePicker() {
        $('#tabel-pphp').find("tbody > tr").each(function () {
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
                                url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/getPegawaiPPHP'); ?>",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }
                    });

        });
    }

    function setPegAuto(obj, item)
    {
        var ada = 0;
        $("#tabel-pphp > tbody > tr").each(function () {
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
                $("#BapemeriksaanadmpphpT_tanggal_sk").val(item.tgl_sk);
                $("#BapemeriksaanadmpphpT_nomor_sk").val(item.no_sk);
            }
        } else {
            myAlert("Data Pegawai sudah ditambahkan di tabel, silahkan pilih data Pegawai yang lain");
            $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val('');
        }
    }

    function tambahBaris() {
        var row = '<?php echo CJSON::encode($this->renderPartial('_rowTabelPertama', array('modDetail' => $modPegPPHP, 'i' => 1), true)); ?>';
        $('#tabel-pphp > tbody').append(row);
        renameInput($("#tabel-pphp"));
        generatePicker();

        jQuery("#tabel-pphp > tbody > tr:last").find('[class*="nama_pegawai"]').autocomplete(
                {
                    'showAnim': 'fold',
                    'minLength': 3,
                    'focus': function (event, ui)
                    {
                        $(this).val(ui.item.label);
                    },
                    'select': function (event, ui)
                    {
                        setPegAuto($(this), ui.item);
                        return false;
                    },
                    'source': function (request, response)
                    {
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/getPegawaiPPHP'); ?>",
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

    function tambahBarisPertama() {
        var row = '<?php echo CJSON::encode($this->renderPartial('_rowTabelPertama', array('modDetail' => $modPegPPHP, 'i' => 1), true)); ?>';
        $('#tabel-pphp > tbody').append(row);
        renameInput($("#tabel-pphp"));
        generatePicker();

        jQuery("#tabel-pphp > tbody > tr:last").find('[class*="nama_pegawai"]').autocomplete(
                {
                    'showAnim': 'fold',
                    'minLength': 3,
                    'focus': function (event, ui)
                    {
                        $(this).val(ui.item.label);
                    },
                    'select': function (event, ui)
                    {
                        setPegAuto($(this), ui.item);
                        return false;
                    },
                    'source': function (request, response)
                    {
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/getPegawaiPPHP'); ?>",
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

    function renameInput(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find('.no_urut').html(row + 1);
            $(this).attr('data-row', row);
            $(this).find('.add-on').each(function () { //element <input>
                var old_name = $(this).attr("id");
                if (typeof old_name !== 'undefined') {
                    var old_name_arr = old_name.split("_");

                    if (old_name_arr.length == 4) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3]);

                    }
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


        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().show();
        $(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
        //set
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
        $(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
        var rowCount = $(obj_table).find('tbody tr').length;
        if (rowCount == 1) {
            $(obj_table).find('tr:first-> child td.rowbutton .icon-minus-sign').parent().hide();
            $(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
            id = $(obj_table).find('tr:first-child input[name*="[lookup_id]"]').val();
            if (id != "") {
                $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
            }
        }

    }
    function setDialog(obj) {
        var no = $(obj).parents("tr").data('row');
        var row = $("#no_row").val(no);
        $("#dialogPegpphp").dialog("open");
    }


    function setPHPDialog(nama, id, nim) {
        var dialog = "#dialogPegpphp";
        var no = $("#no_row").val()
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        ;

        var ada = 0;
        $("#tabel-pphp > tbody > tr").each(function () {
            var pegawai_id_temp = $(this).find('input[name$="[pegawai_id]"]').val();
            if (id == pegawai_id_temp) {
                ada++;
            }
        });

        if (ada == 0) {
            $.get('<?php echo $this->createUrl('GetPegawai'); ?>', {pegawai_id: id}, function (data) {
                $("#tabel-pphp > tbody > tr").each(function () {
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
        $("#tabel-pphp > tbody > tr").each(function () {
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
                $("#BapemeriksaanadmpphpT_tanggal_sk").val(item.tgl_sk);
                $("#BapemeriksaanadmpphpT_nomor_sk").val(item.no_sk);
            }
        } else {
            myAlert("Data Pegawai sudah ditambahkan di tabel, silahkan pilih data Pegawai yang lain");
            $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val('');
            $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val('');
            $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val('');
            $(obj).val('');
        }
    }

    $(document).ready(function () {
        cekRiwayat();
//        setValidasi();
<?php
if (!empty($_GET['bapemeriksaanadmpphp_id'])) {
    $cek = PegpphpT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'bapemeriksaanadmpphp_id' => $_GET['bapemeriksaanadmpphp_id']));
    if (empty($cek)) {
        ?>
                tambahBarisPertama();
    <?php } else { ?>
                renameInput();
    <?php }
} else {
    ?>
            tambahBarisPertama();
<?php } ?>
<?php if (isset($_GET['sukses'])) { ?>
            $('input').attr('readonly', true);
            $('textarea').attr('readonly', true);
            $('.add-on').hide();
<?php } ?>
        var nilaikontrak = <?php echo $modSPK->nilaikontrak ?>;
        if (nilaikontrak <= 200000000) {
            myAlert("Pengadaan ini diperiksa oleh PJPHP gunakan transaksi BA Pemeriksaan Administratif PJPHP");
        }
    });
    
    document.getElementById("BapemeriksaanadmpphpT_dokumen_pendukung").onchange = function () {
        if (this.files[0].size > 5000000) {
            toastr.error('Ukuran maksimal dokumen 5mb');
            $("#BapemeriksaanadmpphpT_dokumen_pendukung").attr("src", "blank");
            $('#BapemeriksaanadmpphpT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#BapemeriksaanadmpphpT_dokumen_pendukung').unwrap();
            return false;
        }
    }
</script>