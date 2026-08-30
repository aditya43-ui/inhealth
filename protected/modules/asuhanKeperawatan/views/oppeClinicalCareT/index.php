<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mtz.monthpicker.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'oppeclinicalcare-t-form',
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
                    Riwayat <b> Clinical Care dalam 1 Semester </b>
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse in" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff">
                <table class="table table-bordered table-condensed" width="100%" id="riwayatClinicalCare">
                    <thead>
                        <tr>
                            <th style="text-align: center; vertical-align: middle"> No </th>
                            <th style="text-align: center; vertical-align: middle"> Bulan Pencatatan</th>
                            <th style="text-align: center; vertical-align: middle"> Nama Pegawai  </th>
                            <th style="text-align: center; vertical-align: middle"> Prosentase Clinical Care </th>
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
            <?php echo CHtml::label("Bulan Pencatatan <span style='color:red'>*</span>", 'bulan_clinicalcare', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'bulan_clinicalcare',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'class' => "span3 required",
                        'onchange' => 'cekData()',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                    ),
                ));
                ?>                  
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Nama Pegawai <span style='color:red'>*</span>", 'pegawai_id', array('class' => 'control-label')) ?>
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
                                $('#ASOppeclinicalcareT_pegawai_id').val(ui.item.pegawai_id);
                                $('#ASOppeclinicalcareT_nama_perawat').val(ui.item.nama_pegawai);
                                $('#ASOppeclinicalcareT_nip_perawat').val(ui.item.nomorindukpegawai);  
                                $('#ASOppeclinicalcareT_perawat_unitkerja_id').val(ui.item.unitkerja_id);  
                                $('#ASOppeclinicalcareT_namaunitkerja').val(ui.item.namaunitkerja); 
                                cekData(); 
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
            <?php echo CHtml::label("Unit Kerja <span style='color:red'>*</span>", 'perawat_unitkerja_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'perawat_unitkerja_id', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textField($model, 'namaunitkerja', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo CHtml::label("Nama Indikator <span style='color:red'>*</span>", 'indikatoroppekeperawatan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'indikatoroppekeperawatan_id', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textField($model, 'indikatoroppekeperawatan_nama', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo CHtml::label("Prosentase Clinical Care <span style='color:red'>*</span>", 'prosentase_clinicalcare', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'prosentase_clinicalcare', array('onblur' => 'cekNilai(this)', 'readonly' => false, 'class' => 'span3 float2')); ?><label> %</label>
            </div>
            <div class="controls">
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah', array(
                    'onclick' => 'submitClinicalCare(); return false;',
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
            <b> Pencatatan Clinical Care </b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>
        <table class="table table-bordered table-striped table-condensed" id="tableClinicalCare">
            <thead>
                <tr>                                         
                    <th style="text-align: center">Bulan Pencatatan</th>
                    <th style="text-align: center">Nama Perawat</th>						
                    <th style="text-align: center">NIP Perawat</th>
                    <th style="text-align: center">Unit Kerja</th>
                    <th style="text-align: center">Prosentase Clinical Care(%)</th>
                    <th style="text-align: center">Aksi</th>
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
<?php $urlGetData = $this->createUrl('GetClinicalCare'); ?>
<?php
$jscript = <<< JS

		
function resetData(){
    bulan_clinicalcare      = $('#ASOppeclinicalcareT_bulan_clinicalcare').val("");
    pegawai_id              = $('#ASOppeclinicalcareT_pegawai_id').val("");
    nama_pegawai            = $('#ASOppeclinicalcareT_nama_perawat').val("");
    nip                     = $('#ASOppeclinicalcareT_nip_perawat').val("");
    namaunitkerja           = $('#ASOppeclinicalcareT_namaunitkerja').val("");
    perawat_unitkerja_id    = $('#ASOppeclinicalcareT_perawat_unitkerja_id').val("");
    nilai_clinicalcare    = $('#ASOppeclinicalcareT_nilai_clinicalcare').val("");
    prosentase_clinicalcare = $('#ASOppeclinicalcareT_prosentase_clinicalcare').val("");
}
JS;

Yii::app()->clientScript->registerScript('clinicalcare', $jscript, CClientScript::POS_HEAD);
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
                $modUnit = UnitkerjaM::model()->findByPk(Yii::app()->user->getState('unitkerja_id'));
                $data['namaunitkerja'] = !empty($modUnit->namaunitkerja) ? $modUnit->namaunitkerja : null;
                $data['unitkerja_id'] = !empty($modUnit->unitkerja_id) ? $modUnit->unitkerja_id : null;
                return CHtml::Link("<span style='font-size:20px;'><i class='icon-form-check'></i></span>", "javascript:void(0)", array("class" => "btn-small",
                            "id" => "selectBarang",
                            "onClick" => "				
                                        $('#ASOppeclinicalcareT_pegawai_id').val('" . $data['pegawai_id'] . "');  
                                        $('#ASOppeclinicalcareT_nama_perawat').val('" . $data['namaLengkap'] . "');
                                        $('#ASOppeclinicalcareT_nip_perawat').val('" . $data['nomorindukpegawai'] . "');  
                                        $('#ASOppeclinicalcareT_perawat_unitkerja_id').val('" . $data['unitkerja_id'] . "');  
                                        $('#ASOppeclinicalcareT_namaunitkerja').val('" . $data['namaunitkerja'] . "');  
                                        cekData();                                                                          
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
        jQuery('input[name$="ASOppeclinicalcareT[bulan_clinicalcare]"]').monthpicker(
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
                                        renameInputRow($("#tableClinicalCare"));
                                    }
                                    myAlert(data.pesan);
                                    var rowCount = $("#tableClinicalCare").find('tbody tr').length;
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(errorThrown);
                                }
                            });
                        }
                    });
        } else {
            $(obj).parents('tr').detach();
            renameInputRow($("#tableClinicalCare"));
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

    function hitungClinical() {
        var nilai = $("#ASOppeclinicalcareT_nilai_clinicalcare").val();
        var persen = 0;
        persen = (nilai / 10) * 100;
        if (persen > 100) {
            persen = 100;
        }
        $("#ASOppeclinicalcareT_prosentase_clinicalcare").val(persen);
    }

    function hitungNilai() {
        $('#tableClinicalCare tbody tr').each(function () {
            var nilai = $(this).find(".nilai_clinicalcare").val();
            var persen = 0;
            persen = (nilai / 10) * 100;
            if (persen > 100) {
                persen = 100;
            }
            $(this).find('.prosentase_clinicalcare').val(persen);
        });
    }

    /**
     * Hapus data sebelum disimpan
     * @param {type} obj
     * @returns {undefined}     
     */
    function hapusTemporaryClinicalCare(obj) {
        $(obj).parents('tr').detach();
        renameInputRow($("#tableClinicalCare"));
    }

    function submitClinicalCare()
    {
        var bulan_clinicalcare = $('#ASOppeclinicalcareT_bulan_clinicalcare').val();
        var pegawai_id = $('#ASOppeclinicalcareT_pegawai_id').val();
        var nama_pegawai = $('#ASOppeclinicalcareT_nama_perawat').val();
        var nip = $('#ASOppeclinicalcareT_nip_perawat').val();
        var namaunitkerja = $('#ASOppeclinicalcareT_namaunitkerja').val();
        var perawat_unitkerja_id = $('#ASOppeclinicalcareT_perawat_unitkerja_id').val();
        var prosentase_clinicalcare = $('#ASOppeclinicalcareT_prosentase_clinicalcare').val();
        
        var persen = parseFloat(unformatNumber(prosentase_clinicalcare));
        
        if (bulan_clinicalcare == '' || pegawai_id == '' || nama_pegawai == '' || nip == '' || perawat_unitkerja_id == '' || namaunitkerja == '' || prosentase_clinicalcare == '') {
            myAlert('Input field yang bertanda merah', 'Perhatian!');
        } else if (persen == 0) {
            myAlert('Nilai Prosentase harus lebih dari 0', 'Perhatian!');
            $('#ASOppeclinicalcareT_prosentase_clinicalcare').css('border-color', '#b94a48');
        } else {
            $.ajax({
                type: 'POST',
                data: {bulan_clinicalcare: bulan_clinicalcare, pegawai_id: pegawai_id, nama_pegawai: nama_pegawai, nip: nip,
                        perawat_unitkerja_id: perawat_unitkerja_id, namaunitkerja: namaunitkerja, prosentase_clinicalcare: prosentase_clinicalcare,
                        },
                url: '<?php echo $this->createUrl('GetClinicalCare'); ?>',
                dataType: "json",
                success: function (data) {
                    $('#tableClinicalCare > tbody').append(data.return);
                    $("#tableClinicalCare tbody tr:last .float2").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2, "symbol": null});
                    renameInputRow($("#tableClinicalCare"));
                    $('#ASOppeclinicalcareT_prosentase_clinicalcare').css('border-color', ''); 
                    $("#nama_perawat").focus();
                    resetData();
                    unformatNumberSemua();
                    formatNumberSemua();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    /**
     * Cek data ketika memilih perawat
     * @param {type} obj
     * @returns {Boolean}     
     */
    function cekData(term, nama) {
        var cek = 0;
        var term = $("#ASOppeclinicalcareT_pegawai_id").val();
        var nama = $("#ASOppeclinicalcareT_nama_perawat").val();
        var bulan = $("#ASOppeclinicalcareT_bulan_clinicalcare").val();
        
        if (term != '') {            
            $.ajax({
                type: 'POST',
                data: {pegawai_id: term, bulan: bulan},
                url: '<?php echo $this->createUrl('GetPerawat'); ?>',
                dataType: "json",
                success: function (data) {
                    $("#riwayatClinicalCare > tbody ").html(data.tr);
                    $("#riwayatClinicalCare > tfoot ").html(data.tfoot);
                    if (data.ada == 1) {
                        toastr.error(data.pesan, 'Perhatian!');
                    } else {
                        $('#ASOppeclinicalcareT_pegawai_id').val(data.pegawai_id);
                        $('#ASOppeclinicalcareT_nama_perawat').val(data.nama_pegawai);
                        $('#ASOppeclinicalcareT_nip_perawat').val(data.nomorindukpegawai);
                        $('#ASOppeclinicalcareT_unitkerja_id').val(data.unitkerja_id);
                        $('#ASOppeclinicalcareT_namaunitkerja').val(data.namaunitkerja);
                    }
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

        var length = $("#tableClinicalCare > tbody > tr").length;

        if (length == 0) {
            myAlert("Silakan isi data terlebih dahulu!", "Perhatian!");
            return false;
        }

        $("#oppeclinicalcare-t-form").submit();
        disableOnSubmit($("#btn_submit"));
    }
    
    function cekNilai(obj) {
        var nilai = parseFloat(unformatNumber(obj.value));
        if (nilai > 100) {
            toastr.error('Nilai tidak boleh lebih dari 100', "Perhatian");
            $(obj).val('0,00');
            return false;
        } 
    }

</script>