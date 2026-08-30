<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mtz.monthpicker.js'); ?>
<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'oppepelatihan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#nama_perawat',
        ));
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>

<div class="panel-group joined" id="accordion-khp"> 
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #a6db9c"> 
                <a data-toggle="collapse"  data-parent="#accordion-khp" href="#riwayat" aria-expanded="true" class="">
                    Riwayat <b> Pelatihan dalam 1 Semester </b>
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse in" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff">
                <table class="table table-bordered table-condensed" width="100%" id="riwayatPelatihan">
                    <thead>
                        <tr>
                            <th> No </th>
                            <th> Bulan Pelatihan</th>
                            <th> Nama Pelatihan</th>
                            <th> No Sertifikat </th>
                            <th> Penyelenggara </th>
                            <th> Jumlah SKP </th>
                            <th> Skor </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'bulan_pelatihan', array('class' => 'control-label')) ?>
            <div class="controls">                
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'bulan_pelatihan',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'class' => "span3 required",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3 pegawai_id')); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'attribute' => 'nama_perawat',
                    'model' => $model,
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutoCompleteGetPerawat') . '",
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
                                $(this).val("");
                                return false;
                            }',
                        'select' => "js:function( event, ui ) {
                                $(this).val(ui.item.nama_pegawai);
                                $('#ASOppepelatihanT_pegawai_id').val(ui.item.pegawai_id);
                                $('#ASOppepelatihanT_nama_perawat').val(ui.item.nama_pegawai);
                                $('#ASOppepelatihanT_nip_perawat').val(ui.item.nomorindukpegawai);  
                                $('#ASOppepelatihanT_perawat_unitkerja_id').val(ui.item.unitkerja_id);  
                                $('#ASOppepelatihanT_namaunitkerja').val(ui.item.namaunitkerja); 
                                return false;
                            }",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Perawat',
                        'class' => 'span3 custom-only',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPerawat', 'jsFunction' => '$("#dialogPerawat").dialog("open");'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nip_perawat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nip_perawat', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo $form->labelEx($model, 'perawat_unitkerja_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'perawat_unitkerja_id', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textField($model, 'namaunitkerja', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo $form->labelEx($model, 'indikatoroppekeperawatan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'indikatoroppekeperawatan_id', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textField($model, 'indikatoroppekeperawatan_nama', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>  
    </div>
    <div class="col-sm-6"> 
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nama_pelatihan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'ka_unitkerja_id', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->hiddenField($model, 'unitkerja_id', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textField($model, 'nama_pelatihan', array('class' => 'span3')); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo $form->labelEx($model, 'no_sertifikat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_sertifikat', array('class' => 'span3')); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo $form->labelEx($model, 'penyelenggara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penyelenggara', array('class' => 'span3')); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jml_skp', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jml_skp', array('class' => 'span3 numbers-only', 'onblur' => 'hitungSkor();')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'skor', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'skor', array('readonly' => true, 'class' => 'span3 numbers-only')); ?><label> %</label>
            </div>
            <div class="controls">
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah', array(
                    'onclick' => 'submitPelatihan(); return false;',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                    'rel' => "tooltip",
                    'id' => 'tambahbahanmenudiet',
                    'title' => "Klik untuk Menambahkan Data",
                        )
                );
                ?>	
            </div>
        </div>  
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <b> Pencatatan Pelatihan dan Workshop </b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>
        <table class="table table-bordered table-striped table-condensed" id="tablePelatihan">
            <thead>
                <tr>                                         
                    <th style="text-align: center; vertical-align: middle">Bulan <br> Pelatihan</th>
                    <th style="text-align: center; vertical-align: middle">Nama Perawat</th>						
                    <th style="text-align: center; vertical-align: middle">NIP Perawat</th>
                    <th style="text-align: center; vertical-align: middle">Unit Kerja</th>
                    <th style="text-align: center; vertical-align: middle">Nama Pelatihan</th>
                    <th style="text-align: center; vertical-align: middle">No. Sertifikat</th>
                    <th style="text-align: center; vertical-align: middle">Penyelenggara</th>
                    <th style="text-align: center; vertical-align: middle">Jumlah SKP</th>
                    <th style="text-align: center; vertical-align: middle">Skor (%)</th>
                    <th style="text-align: center; vertical-align: middle">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) : Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'onclick' => 'cekForm();', 'id' => 'btn_submit', 'disabled' => (isset($_GET['sukses'])) ? true : false)); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/bahanMenuDietM/admin'), array('class' => 'btn btn-danger', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
</div>
<?php $this->endWidget(); ?>
<?php $urlGetData = $this->createUrl('GetPelatihan'); ?>
<?php
$jscript = <<< JS
function submitPelatihan()
{
    bulan_pelatihan      = $('#ASOppepelatihanT_bulan_pelatihan').val();
    pegawai_id           = $('#ASOppepelatihanT_pegawai_id').val();
    nama_pegawai         = $('#ASOppepelatihanT_nama_perawat').val();
    nip                  = $('#ASOppepelatihanT_nip_perawat').val();
    namaunitkerja        = $('#ASOppepelatihanT_namaunitkerja').val();
    perawat_unitkerja_id = $('#ASOppepelatihanT_perawat_unitkerja_id').val();
    nama_pelatihan       = $('#ASOppepelatihanT_nama_pelatihan').val();
    no_sertifikat        = $('#ASOppepelatihanT_no_sertifikat').val();
    penyelenggara        = $('#ASOppepelatihanT_penyelenggara').val();
    jml_skp              = $('#ASOppepelatihanT_jml_skp').val();
    skor                 = $('#ASOppepelatihanT_skor').val();
        
    if(bulan_pelatihan == '' || pegawai_id == '' || nama_pegawai == '' || nip == '' || perawat_unitkerja_id == '' || namaunitkerja == '' || nama_pelatihan == '' || no_sertifikat == '' || penyelenggara == ''){
        myAlert('Input field yang bertanda merah', "Perhatian!");
    }else if (skor == 0) {
        myAlert('Jumlah SKP tidak boleh 0', "Perhatian!");
    }else{
        $.post("${urlGetData}", {bulan_pelatihan:bulan_pelatihan, pegawai_id:pegawai_id, nama_pegawai:nama_pegawai, nip:nip, 
                                 perawat_unitkerja_id:perawat_unitkerja_id, namaunitkerja:namaunitkerja, jml_skp:jml_skp, skor:skor,
                                 nama_pelatihan:nama_pelatihan, no_sertifikat:no_sertifikat, penyelenggara:penyelenggara
                                },
        function(data){
            $('#tablePelatihan > tbody').append(data.return);
            $("#tablePelatihan tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
            renameInputRow($("#tablePelatihan"));	
            $("#nama_perawat").focus();
            resetData();
            unformatNumberSemua();
            formatNumberSemua();
        }, "json");
    }   
}
		
function resetData(){
    bulan_pelatihan      = $('#ASOppepelatihanT_bulan_pelatihan').val("");
    pegawai_id           = $('#ASOppepelatihanT_pegawai_id').val("");
    nama_pegawai         = $('#ASOppepelatihanT_nama_perawat').val("");
    nip                  = $('#ASOppepelatihanT_nip_perawat').val("");
    namaunitkerja        = $('#ASOppepelatihanT_namaunitkerja').val("");
    perawat_unitkerja_id = $('#ASOppepelatihanT_perawat_unitkerja_id').val("");
    nama_pelatihan       = $('#ASOppepelatihanT_nama_pelatihan').val("");
    no_sertifikat        = $('#ASOppepelatihanT_no_sertifikat').val("");
    penyelenggara        = $('#ASOppepelatihanT_penyelenggara').val("");
    jml_skp              = $('#ASOppepelatihanT_jml_skp').val("");
    skor                 = $('#ASOppepelatihanT_skor').val("");
}
JS;

Yii::app()->clientScript->registerScript('pelatihan', $jscript, CClientScript::POS_HEAD);
?>
<?php
/* ========= Dialog buat cari Kantong Darah ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPerawat',
    'options' => array(
        'title' => 'Daftar Perawat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new ASPegawaiM('searchDialogJabatanPerawat');
$modPegawai->unsetAttributes();
if (isset($_GET['ASPegawaiM'])) {
    $modPegawai->attributes = $_GET['ASPegawaiM'];
    $modPegawai->jabatan_nama = !empty($_GET['ASPegawaiM']['jabatan_nama']) ? $_GET['ASPegawaiM']['jabatan_nama'] : "";
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modPegawai->searchDialogJabatanPerawat(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:20px;'><i class='icon-form-check'></i></span>", "javascript:void(0)", array("class" => "btn-small",
                            "id" => "selectBarang",
                            "onClick" => "				
                                        $('#ASOppepelatihanT_pegawai_id').val('" . $data['pegawai_id'] . "');  
                                        $('#ASOppepelatihanT_nama_perawat').val('" . $data['nama_pegawai'] . "');
                                        $('#ASOppepelatihanT_nip_perawat').val('" . $data['nomorindukpegawai'] . "');  
                                        $('#ASOppepelatihanT_perawat_unitkerja_id').val('" . $data['unitkerja_id'] . "');  
                                        $('#ASOppepelatihanT_namaunitkerja').val('" . $data['namaunitkerja'] . "');  
                                        cekData('" . $data['pegawai_id'] . "');                                                                          
					$('#dialogPerawat').dialog('close');
					return false;"));
            },
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai'
        ),
        array(
            'header' => 'Nama Perawat',
            'name' => 'nama_pegawai'
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_nama'
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'namaunitkerja'
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<script>
    $(document).ready(function () {
        generateBulan();
    });

    /**
     * Generate Bulan 
     * @returns {undefined}     */
    function generateBulan() {
        jQuery('input[name$="ASOppepelatihanT[bulan_pelatihan]"]').monthpicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.monthpicker.regional['en-GB'],
                        {

                            'dateFormat': 'M yy',
                            'timeOnlyTitle': 'Pilih Waktu',
                            'changeYear': true,
                            'changeMonth': true,
                            'finalYear': 'y',
                            'yearRange': "-10",
                            'showAnim': 'fold'
                        }
                ));
    }

    function hitungSkor() {
        var jml_skp = $('#ASOppepelatihanT_jml_skp').val();
        var indikator_id = $('#ASOppepelatihanT_indikatoroppekeperawatan_id').val();

        if (jml_skp >= 2) {
            $('#ASOppepelatihanT_skor').val(100);
        } else if (jml_skp <= 0) {
            $('#ASOppepelatihanT_skor').val(0);
        } else {
            $('#ASOppepelatihanT_skor').val(50);
        }
    }

    function hitungSKP() {
        $('#tablePelatihan tbody tr').each(function () {
            var jumlah = $(this).find('.jumlah_skp').val();

            if (jumlah >= 2) {
                $(this).find('.skor').val(100);
            } else if (jumlah <= 0) {
                $(this).find('.skor').val(0);
            } else {
                $(this).find('.skor').val(50);
            }
        });
    }

    function hapusBahanResepMakanan(obj) {
        var menumakanan_id = $(obj).parents("tr").find("input[name$='[menumakanan_id]']").val();
        var bahanmakanan_id = $(obj).parents("tr").find("input[name$='[bahanmakanan_id]']").val();
        if (menumakanan_id !== "" && bahanmakanan_id != "") {
            myConfirm("Apakah Anda yakin akan menghapus data ini dari database?", "Perhatian!",
                    function (r) {
                        if (r) {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo $this->createUrl('Delete'); ?>&menumakanan_id=' + menumakanan_id + '&bahanmakanan_id=' + bahanmakanan_id,
                                data: {id: menumakanan_id}, //
                                dataType: "json",
                                success: function (data) {
                                    if (data.sukses == 1) {
                                        $(obj).parents('tr').detach();
                                        renameInputRow($("#tablePelatihan"));
                                    }
                                    myAlert(data.pesan);
                                    var rowCount = $("#tablePelatihan").find('tbody tr').length;
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(errorThrown);
                                }
                            });
                        }
                    });
        } else {
            $(obj).parents('tr').detach();
            renameInputRow($("#tablePelatihan"));
        }
    }

    /**
     * Rename input
     * @param {type} obj_table
     * @returns {undefined}     
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find('.nourut').val(row + 1);
            $(this).find('span').each(function () { //element <input>
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

    /**
     * Hapus data sebelum disimpan
     * @param {type} obj
     * @returns {undefined}     
     */
    function hapusTemporaryPelatihan(obj) {
        $(obj).parents('tr').detach();
        renameInputRow($("#tablePelatihan"));
    }

    /**
     * Cek data ketika memilih perawat
     * @param {type} obj
     * @returns {Boolean}     
     */
    function cekData(term) {
        var cek = 0;
        var bulan = $("#ASOppepelatihanT_bulan_pelatihan").val();

        if (term != '') {
//            $("#tablePelatihan > tbody > tr").each(function () {
//                if ($(this).find(".pegawai_id").val() == term && $(this).find(".bulan_pencatatan").val() == bulan) {
//                    cek++;
//                }
//            });
//
//            if (cek > 0) {
//                $('#ASOppepelatihanT_pegawai_id').val('');
//                $('#ASOppepelatihanT_nama_perawat').val('');
//                $('#ASOppepelatihanT_nip_perawat').val('');
//                $('#ASOppepelatihanT_unitkerja_id').val('');
//                $('#ASOppepelatihanT_namaunitkerja').val('');
//                window.parent.toastr.warning('Hanya bisa memilih 1 perawat dalam 1 bulan.', 'Perhatian!');
//                return false;
//            }

            $.ajax({
                type: 'POST',
                data: {pegawai_id: term, bulan: bulan},
                url: '<?php echo $this->createUrl('GetDataPelatihan'); ?>',
                dataType: "json",
                success: function (data) {
                    $("#riwayatPelatihan > tbody ").html(data.tr);
                    $("#riwayatPelatihan > tfoot ").html(data.tfoot);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }
    }

    /**
     * Cek data sebelum disimpan
     * @returns {Boolean}     
     */
    function cekForm() {

        var length = $("#tablePelatihan > tbody > tr").length;

        if (length == 0) {
            myAlert("Silakan isi data terlebih dahulu!", "Perhatian!");
            return false;
        }

        $("#oppepelatihan-t-form").submit();
        disableOnSubmit($("#btn_submit"));
    }

</script>