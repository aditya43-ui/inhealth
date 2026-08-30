<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mtz.monthpicker.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'oppekehadiran-t-form',
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
                    Riwayat <b> Kehadiran dalam 1 Semester </b>
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse in" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff">
                <table class="table table-bordered table-condensed" width="100%" id="riwayatKehadiran">
                    <thead>
                        <tr>
                            <th> No </th>
                            <th> Bulan </th>
                            <th> Nama Pegawai </th>
                            <th> Nomor Induk Pegawai </th>
                            <th> Prosesentase </th>
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
            <?php echo $form->labelEx($model, 'bulan_kehadiran', array('class' => 'control-label')) ?>
            <div class="controls"> 
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'bulan_kehadiran',
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
        <div class="control-group">
            <?php echo $form->labelEx($model, 'prosentase_kehadiran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'prosentase_kehadiran', array('readonly' => false, 'class' => 'span3 float2', 'onblur' => 'cekNilai(this);')); ?><label> %</label>
            </div>
            <div class="controls">
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah', array(
                    'onclick' => 'submitKehadiran(); return false;',
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
            <b> Pencatatan Kehadiran </b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>
        <table class="table table-bordered table-striped table-condensed" id="tableKehadiran">
            <thead>
                <tr>                                         
                    <th style="text-align: center">Bulan Kehadiran</th>
                    <th style="text-align: center">Nama Perawat</th>						
                    <th style="text-align: center">NIP Perawat</th>
                    <th style="text-align: center">Unit Kerja</th>
                    <th style="text-align: center">Prosentase Kehadiran (%)</th>
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
<?php $urlGetData = $this->createUrl('GetKehadiran'); ?>
<?php
$jscript = <<< JS
function submitKehadiran()
{
    bulan_kehadiran      = $('#ASOppekehadiranT_bulan_kehadiran').val();
    pegawai_id           = $('#ASOppekehadiranT_pegawai_id').val();
    nama_pegawai         = $('#ASOppekehadiranT_nama_perawat').val();
    nip                  = $('#ASOppekehadiranT_nip_perawat').val();
    namaunitkerja        = $('#ASOppekehadiranT_namaunitkerja').val();
    perawat_unitkerja_id = $('#ASOppekehadiranT_perawat_unitkerja_id').val();
    prosentase_kehadiran = $('#ASOppekehadiranT_prosentase_kehadiran').val();
        
    if(bulan_kehadiran == '' || pegawai_id == '' || nama_pegawai == '' || nip == '' || perawat_unitkerja_id == '' || namaunitkerja == '' || prosentase_kehadiran == ''){
        myAlert('Input field yang bertanda merah');
    }else{
        $.post("${urlGetData}", {bulan_kehadiran:bulan_kehadiran, pegawai_id:pegawai_id, nama_pegawai:nama_pegawai, nip:nip, 
                                 perawat_unitkerja_id:perawat_unitkerja_id, namaunitkerja:namaunitkerja, prosentase_kehadiran:prosentase_kehadiran,
                                },
        function(data){
            $('#tableKehadiran > tbody').append(data.return);
            $("#tableKehadiran tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
            renameInputRow($("#tableKehadiran"));	
            $("#nama_perawat").focus();
            resetData();
            unformatNumberSemua();
            formatNumberSemua();
        }, "json");
    }   
}
		
function resetData(){
    bulan_kehadiran      = $('#ASOppekehadiranT_bulan_kehadiran').val("");
    pegawai_id           = $('#ASOppekehadiranT_pegawai_id').val("");
    nama_pegawai         = $('#ASOppekehadiranT_nama_perawat').val("");
    nip                  = $('#ASOppekehadiranT_nip_perawat').val("");
    namaunitkerja        = $('#ASOppekehadiranT_namaunitkerja').val("");
    perawat_unitkerja_id = $('#ASOppekehadiranT_perawat_unitkerja_id').val("");
    prosentase_kehadiran = $('#ASOppekehadiranT_prosentase_kehadiran').val("");
}
JS;

Yii::app()->clientScript->registerScript('kehadiran', $jscript, CClientScript::POS_HEAD);
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
                                        $('#ASOppekehadiranT_pegawai_id').val('" . $data['pegawai_id'] . "');
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
        jQuery('input[name$="ASOppekehadiranT[bulan_kehadiran]"]').monthpicker(
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
    
    function cekNilai(obj) {
        var nilai = parseFloat(unformatNumber(obj.value));
        if(nilai > 100){
            toastr.error("Nilai tidak boleh lebih dari 100", "Perhatian!");
            $(obj).val('0,00');
            return false;
        }
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
                                        renameInputRow($("#tableKehadiran"));
                                    }
                                    myAlert(data.pesan);
                                    var rowCount = $("#tableKehadiran").find('tbody tr').length;
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(errorThrown);
                                }
                            });
                        }
                    });
        } else {
            $(obj).parents('tr').detach();
            renameInputRow($("#tableKehadiran"));
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
    function hapusTemporaryKehadiran(obj) {
        $(obj).parents('tr').detach();
        renameInputRow($("#tableKehadiran"));
    }

    /**
     * Cek data ketika memilih perawat
     * @param {type} obj
     * @returns {Boolean}     
     */
    function cekData() {
        var cek = 0;
        console.log('cek data 1');
        var term = $('#ASOppekehadiranT_pegawai_id').val(); 
        var bulan = $('#ASOppekehadiranT_bulan_kehadiran').val();
        if (term != '') {
            $("#tableKehadiran > tbody > tr").each(function () {
                if ($(this).find(".pegawai_id").val() == term && $(this).find(".bulan_pencatatan").val() == bulan) {
                    cek++;
                }
            });

            if (cek > 0) {
                resetData(); 
                window.parent.toastr.warning('Hanya bisa memilih 1 perawat dalam 1 bulan.', 'Perhatian!');
                return false;
            }

            $.ajax({
                type: 'POST',
                data: {pegawai_id: term, bulan:bulan},
                url: '<?php echo $this->createUrl('GetPerawat'); ?>',
                dataType: "json",
                success: function (data) {
                    $("#riwayatKehadiran > tbody ").html(data.tr);
                    $("#riwayatKehadiran > tfoot ").html(data.tfoot);
                    if (data.ada == 1) {
                        resetData(); 
                        window.parent.toastr.error(data.pesan, 'Perhatian');
                        return false;
                    } else {
                        $('#ASOppekehadiranT_pegawai_id').val(data.pegawai_id);
                        $('#ASOppekehadiranT_nama_perawat').val(data.nama_pegawai);
                        $('#ASOppekehadiranT_nip_perawat').val(data.nomorindukpegawai);
                        $('#ASOppekehadiranT_perawat_unitkerja_id').val(data.unitkerja_id);
                        $('#ASOppekehadiranT_namaunitkerja').val(data.namaunitkerja);
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

        var length = $("#tableKehadiran > tbody > tr").length;

        if (length == 0) {
            myAlert("Silakan isi data terlebih dahulu!", "Perhatian!");
            return false;
        }

        $("#oppekehadiran-t-form").submit();
        disableOnSubmit($("#btn_submit"));
    }

</script>