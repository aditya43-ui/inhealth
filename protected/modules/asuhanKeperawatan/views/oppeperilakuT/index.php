<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mtz.monthpicker.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'oppeperilaku-t-form',
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
                    Riwayat <b> Presentase Perilaku dalam 1 Semester </b>
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse in" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff">
                <table class="table table-bordered table-condensed table-striped" width="100%" id="riwayatPerilaku">
                    <thead>
                        <tr>
                            <th style="text-align: center; vertical-align: middle"> No </th>
                            <th style="text-align: center; vertical-align: middle"> Bulan Kuisioner </th>
                            <th style="text-align: center; vertical-align: middle"> Nama Perawat </th>
                            <th style="text-align: center; vertical-align: middle"> Nilai <br> Sejawat </th>
                            <th style="text-align: center; vertical-align: middle"> Nilai <br> Pasien / Keluarga </th>
                            <th style="text-align: center; vertical-align: middle"> Nilai <br> Dokter </th>
                            <th style="text-align: center; vertical-align: middle"> Rata-rata </th>
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
            <?php echo $form->labelEx($model, 'bulan_pencatatan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $model,
                    'attribute' => 'bulan_pencatatan',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'class' => "span3 required",
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'onchange' => '$("#table-nilaiiku tbody").empty();',
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
                                $('#ASOppeperilakuT_pegawai_id').val(ui.item.pegawai_id);
                                $('#ASOppeperilakuT_nama_perawat').val(ui.item.nama_pegawai);
                                $('#ASOppeperilakuT_nip_perawat').val(ui.item.nomorindukpegawai);  
                                $('#ASOppeperilakuT_perawat_unitkerja_id').val(ui.item.unitkerja_id);  
                                $('#ASOppeperilakuT_namaunitkerja').val(ui.item.namaunitkerja); 
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
            <label class='control-label'>Responden Kuisioner</label>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'ka_unitkerja_id', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->hiddenField($model, 'unitkerja_id', array('readonly' => true, 'class' => 'span3')); ?><br><br>
            </div>
        </div>  
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nilai_sejawat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilai_sejawat', array('class' => 'span3 float2', 'onblur' => 'cekNilai(this);')); ?><label> %</label>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label">Pasien / Keluarga</label>
            <div class="controls">
                <?php 
                echo CHtml::dropDownList('nilai' , 'Pasien', array('Pasien'=>'Pasien', 'Keluarga'=>'Keluarga'), array(
                'class' => 'span3', 'onchange' => 'showNilaiPasien()'));
                ?>
            </div>
        </div>
        <div class="control-group" id="nilai-pasien">
            <?php echo $form->labelEx($model, 'nilai_pasien', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilai_pasien', array('class' => 'span3 float2', 'onblur' => 'cekNilai(this);')); ?><label> %</label>
            </div>
        </div>  
        <div class="control-group" id="nilai-keluarga">
            <?php echo $form->labelEx($model, 'nilai_keluarga', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilai_keluarga', array('class' => 'span3 float2', 'onblur' => 'cekNilai(this);')); ?><label> %</label>
            </div>
        </div>  
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nilai_dokter', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nilai_dokter', array('class' => 'span3 float2', 'onblur' => 'cekNilai(this);')); ?><label> %</label>
            </div>
            <div class="controls">
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah', array(
                    'onclick' => 'submitPerilaku(); return false;',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "return $(this).focusNextInputField(event);",
                    'rel' => "tooltip",
                    'id' => 'tambahbahanmenudiet',
                    'title' => "Klik untuk Menambahkan Data",
                        )
                );

                $array = array(
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                );
                $allZeroes = count($array) == count(array_keys($array, '0', true));

                $clear_array = array_unique($array);
                $count_values = array_count_values($array);
                $rata = $allZeroes;
                echo $rata;
                ?>	
            </div>
        </div>  
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Pencatatan Kuisioner Perilaku
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>
        <table class="table table-bordered table-striped table-condensed" id="tablePerilaku">
            <thead>
                <tr>                                         
                    <th style="text-align: center; vertical-align: middle">Bulan <br> Pencatatan</th>
                    <th style="text-align: center; vertical-align: middle">Nama Perawat</th>						
                    <th style="text-align: center; vertical-align: middle">NIP Perawat</th>
                    <th style="text-align: center; vertical-align: middle">Unit Kerja</th>
                    <th style="text-align: center; vertical-align: middle">Sejawat (%)</th>
                    <th style="text-align: center; vertical-align: middle">Pasien (%)</th>
                    <th style="text-align: center; vertical-align: middle">Keluarga(%)</th>
                    <th style="text-align: center; vertical-align: middle">Dokter (%)</th>
                    <th style="text-align: center; vertical-align: middle">Rata-Rata</th>
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
<?php $urlGetData = $this->createUrl('GetPerilaku'); ?>
<?php
$jscript = <<< JS
function submitPerilaku()
{
    bulan_pencatatan                = $('#ASOppeperilakuT_bulan_pencatatan').val();
    pegawai_id                      = $('#ASOppeperilakuT_pegawai_id').val();
    nama_pegawai                    = $('#ASOppeperilakuT_nama_perawat').val();
    nip                             = $('#ASOppeperilakuT_nip_perawat').val();
    namaunitkerja                   = $('#ASOppeperilakuT_namaunitkerja').val();
    perawat_unitkerja_id            = $('#ASOppeperilakuT_perawat_unitkerja_id').val();
    nilai_sejawat                   = $('#ASOppeperilakuT_nilai_sejawat').val();
    nilai_pasien                    = $('#ASOppeperilakuT_nilai_pasien').val();
    nilai_dokter                    = $('#ASOppeperilakuT_nilai_dokter').val();
    nilai_keluarga                  = $('#ASOppeperilakuT_nilai_keluarga').val();
        
    if(bulan_pencatatan == '' || pegawai_id == '' || nama_pegawai == '' || nip == '' || perawat_unitkerja_id == '' || namaunitkerja == '' || nilai_sejawat == '' || nilai_dokter == ''){
        myAlert('Input field yang bertanda merah');
    }else{
        $.post("${urlGetData}", {bulan_pencatatan:bulan_pencatatan, pegawai_id:pegawai_id, nama_pegawai:nama_pegawai, nip:nip, 
                                 perawat_unitkerja_id:perawat_unitkerja_id, namaunitkerja:namaunitkerja,
                                 nilai_sejawat:nilai_sejawat, nilai_pasien:nilai_pasien, nilai_dokter:nilai_dokter,
                                 nilai_keluarga:nilai_keluarga
                                },
        function(data){
            $('#tablePerilaku > tbody').append(data.return);
            $("#tablePerilaku tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
            renameInputRow($("#tablePerilaku"));	
            $("#nama_perawat").focus();
            resetData();
            unformatNumberSemua();
            formatNumberSemua();
        }, "json");
    }   
}
		
function resetData(){
    bulan_pencatatan                = $('#ASOppeperilakuT_bulan_pencatatan').val("");
    pegawai_id                      = $('#ASOppeperilakuT_pegawai_id').val("");
    nama_pegawai                    = $('#ASOppeperilakuT_nama_perawat').val("");
    nip                             = $('#ASOppeperilakuT_nip_perawat').val("");
    namaunitkerja                   = $('#ASOppeperilakuT_namaunitkerja').val("");
    perawat_unitkerja_id            = $('#ASOppeperilakuT_perawat_unitkerja_id').val("");
    nilai_sejawat                   = $('#ASOppeperilakuT_nilai_sejawat').val("");
    nilai_pasien                    = $('#ASOppeperilakuT_nilai_pasien').val("");
    nilai_keluarga                  = $('#ASOppeperilakuT_nilai_keluarga').val("");
    nilai_dokter                    = $('#ASOppeperilakuT_nilai_dokter').val("");
}
JS;

Yii::app()->clientScript->registerScript('bahanmenudiet', $jscript, CClientScript::POS_HEAD);
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
                                        $('#ASOppeperilakuT_pegawai_id').val('" . $data['pegawai_id'] . "');  
                                        $('#ASOppeperilakuT_nama_perawat').val('" . $data['nama_pegawai'] . "');
                                        $('#ASOppeperilakuT_nip_perawat').val('" . $data['nomorindukpegawai'] . "');  
                                        $('#ASOppeperilakuT_perawat_unitkerja_id').val('" . $data['unitkerja_id'] . "');  
                                        $('#ASOppeperilakuT_namaunitkerja').val('" . $data['namaunitkerja'] . "');   
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

    function cekNilai(obj) {
        var nilai = parseFloat(unformatNumber(obj.value));
        if (nilai > 100) {
            toastr.error("Nilai tidak boleh lebih dari 100", "Perhatian!");
            $(obj).val('0,00');
            return false;
        }
    }
    
    function showNilaiPasien(){
        var nilai = $('#nilai').val();
        
        if (nilai == 'Pasien') {
            $('#nilai-pasien').show();
            $('#nilai-keluarga').hide();
        } else {
            $('#nilai-keluarga').show();
            $('#nilai-pasien').hide();
        }
    }

    function setMenuDiet(id) {
        $("#tablePerilaku").addClass("animation-loading");
        $('#tablePerilaku > tbody').html("");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetMenuDiet'); ?>',
            data: {id: id, is_update: 1}, //
            dataType: "json",
            success: function (data) {
                $('#tablePerilaku > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInputRow($("#tablePerilaku"));
                $("#tablePerilaku").removeClass("animation-loading");
                $("#tablePerilaku tbody tr .float2").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2, "symbol": null});

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
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
                                        renameInputRow($("#tablePerilaku"));
                                    }
                                    myAlert(data.pesan);
                                    var rowCount = $("#tablePerilaku").find('tbody tr').length;
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(errorThrown);
                                }
                            });
                        }
                    });
        } else {
            $(obj).parents('tr').detach();
            renameInputRow($("#tablePerilaku"));
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
    
    function hitungNilai(){
        var rata_rata = 0; 
        var jumlah = 0; 
        unformatNumberSemua();
        $('#tablePerilaku tbody tr').each(function () {
            var sejawat = parseFloat($(this).find('.nilai_sejawat').val());
            var pasien = parseFloat($(this).find('.nilai_pasien').val());
            var keluarga = parseFloat($(this).find('.nilai_keluarga').val());
            var dokter = parseFloat($(this).find('.nilai_dokter').val());
            
            var array = [sejawat, pasien, keluarga, dokter]; 
            var total = sejawat + pasien + keluarga + dokter; 
            array.forEach(function(item) {
                if (item > 0) {
                    jumlah++; 
                }
            });
            rata_rata = total / jumlah;
            console.log('jumlah_data : '+jumlah);
            console.log('total : '+total);
            $(this).find('.nilai_rata').val(rata_rata.toFixed(2)); 
        }); 
        formatNumberSemua();
    }

    /**
     * Hapus data sebelum disimpan
     * @param {type} obj
     * @returns {undefined}     
     */
    function hapusTemporaryPerilaku(obj) {
        $(obj).parents('tr').detach();
        renameInputRow($("#tablePerilaku"));
    }

    /**
     * Cek data ketika memilih perawat
     * @param {type} obj
     * @returns {Boolean}     
     */
    function cekData(pegawai_id) {
        var cek = 0;
        var bulan = $("#ASOppeperilakuT_bulan_pencatatan").val(); 
        if (pegawai_id != '' && bulan != '') {
            $("#tablePerilaku > tbody > tr").each(function () {
                if ($(this).find(".pegawai_id").val() == pegawai_id && $(this).find(".bulan_pencatatan").val() == bulan) {
                    cek++;
                }
            });

            $.ajax({
                type: 'POST',
                data: {pegawai_id: pegawai_id, bulan:bulan},
                url: '<?php echo $this->createUrl('GetPerawat'); ?>',
                dataType: "json",
                success: function (data) {
                    $("#riwayatPerilaku > tbody ").html(data.tr);
                    $("#riwayatPerilaku > tfoot ").html(data.tfoot);
                    
                    $("#riwayatPerilaku > tbody > tr").each(function () {
                        var nilai_sejawat = parseFloat($(this).find('.riwayat_nilai_sejawat')); 
                    }); 
                    
                    if (data.ada == 1 ) {
                        toastr.error(data.pesan, 'Perhatian!');
                        resetData();
                    } else {
                        $('#ASOppeperilakuT_pegawai_id').val(data.pegawai_id);
                        $('#ASOppeperilakuT_nama_perawat').val(data.nama_pegawai);
                        $('#ASOppeperilakuT_nip_perawat').val(data.nomorindukpegawai);
                        $('#ASOppeperilakuT_perawat_unitkerja_id').val(data.unitkerja_id);
                        $('#ASOppeperilakuT_namaunitkerja').val(data.namaunitkerja);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }
    }

    /**
     * Generate Bulan 
     * @returns {undefined}     */
    function generateBulan() {
        jQuery('input[name$="ASOppeperilakuT[bulan_pencatatan]"]').monthpicker(
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
        
    /**
     * Cek data sebelum disimpan
     * @returns {Boolean}     
     */
    function cekForm() {

        var length = $("#tablePerilaku > tbody > tr").length;

        if (length == 0) {
            myAlert("Silakan isi data terlebih dahulu!", "Perhatian!");
            return false;
        }

        $("#oppeperilaku-t-form").submit();
        disableOnSubmit($("#btn_submit"));
    }
    
    $(document).ready(function(){
        showNilaiPasien(); 
    });
    

</script>