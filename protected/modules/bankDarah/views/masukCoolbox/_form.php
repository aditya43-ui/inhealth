<?php $radioTemplate = '{input} <span style="margin-right: 30px;">{label}</span>'; ?>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <label class='control-label'>No. Kantong Utama <span class="required">*</span></label>
            <div class="controls">
                <?php echo CHtml::hiddenField('jeniskantongdarah_id'); ?>
                <?php echo CHtml::hiddenField('komponendarah_id'); ?>
                <?php echo CHtml::hiddenField('kantongdarah_id'); ?>
                <?php echo CHtml::hiddenField('daftardonasi_id'); ?>
                <?php echo CHtml::hiddenField('nomorbarcode_utama'); ?>
                
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'nomorbarcode',
                        'source'=>'js: function(request, response) {
                            $.ajax({
                                url: "'.$this->createUrl('AutoCompleteGetKantong').'",
                                dataType: "json",
                                data: {
                                    term: request.term,    
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                         'options'=>array(
                            'showAnim'=>'fold',
                            'minLength' => 2,
                            'focus'=> 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                            'select'=>"js:function( event, ui ) {
                                $(this).val(ui.item.nomorbarcode_utama);
                                $('#nomorbarcode').blur();
                                //$('#nomorbarcode_utama').val(ui.item.nomorbarcode_utama);
                                //$('#nomorbarcode').val(ui.item.nomorbarcode_utama);  
                                // $('#PenggunaanCoolboxdetT_jeniskantong').val(ui.item.nama_jenis);  
                                // $('#PenggunaanCoolboxdetT_gol_darah').val(ui.item.gol_darah);  
                                //$('#PenggunaanCoolboxdetT_rhesus_0').prop('checked',ui.item.rhesus_positif);  
                                //$('#PenggunaanCoolboxdetT_rhesus_1').prop('checked',ui.item.rhesus_negatif);  
                                //cekData(ui.item.nomorbarcode_utama); 
                                $
                                return false;
                            }",
                        ),
                        'htmlOptions'=>array(
                            'placeholder' => 'Ketik No. Kantong Utama',
                            'class' => 'span3 custom-only',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",                            
                            'onblur'=>"cekData(this.value)"
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogKantongDarah', 'jsFunction' => '$("#dialogKantongDarah").dialog("open");'),
                    )); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kantong Darah", "", array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modDet, 'jeniskantong', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>  
        <div class="control-group">
            <?php echo CHtml::label("No. Kantong Pabrik <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modDet, 'no_kantongpabrik', array('class' => 'span3 no_kantongpabrik')); ?>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label">Volume Kantong Darah</label>
            <div class="controls">
                <?php echo $form->textField($modDet, 'volume', array('class' => 'span3')); ?> <label>ml</label>
            </div>
        </div>
        
        <div class="control-group ">
            <label class="control-label">Golongan Darah<span class="required">*</span></label>
            <div class="controls">
                <?php echo $form->dropDownList($modDet, 'gol_darah', LookupM::getItemsUrutan('golongandarah'), array( 'empty' => '-- Pilih --', 'class' => 'span2')); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">Rhesus<span class="required">*</span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($modDet, 'rhesus', array('Positif' => 'Positif', 'Negatif' => 'Negatif'), array('readonly' => false, 'template' => $radioTemplate)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <label class="control-label">Sampel Konfirmasi Golongan Darah <span class="required">*</span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($modDet, 'ada_samplekonfirmasi', array('Ada' => 'Ada', 'Tidak Ada' => 'Tidak Ada'), array('readonly' => false, 'template' => $radioTemplate)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">Sampel Skrining IMLTD <span class="required">*</span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($modDet, 'ada_sampleitd', array('Ada' => 'Ada', 'Tidak Ada' => 'Tidak Ada'), array('readonly' => false, 'template' => $radioTemplate)); ?>
            </div>
        </div>
        <div class="control-group ">
            <label class="control-label">Kantong Darah <span class="required">*</span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($modDet, 'ada_kantongdarah', array('Ada' => 'Ada', 'Tidak Ada' => 'Tidak Ada'), array('readonly' => false, 'template' => $radioTemplate)); ?>
            </div>
        </div>        
    </div>
</div>
<div class="row-fluid">
    <?php
    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>Tambah', array(
        'onclick' => 'submitKantongDarah(); return false;',
        'class' => 'btn btn-primary',
        'onkeypress' => "return $(this).focusNextInputField(event);",
        'rel' => "tooltip",
        'id' => 'tambahbahanmenudiet',
        'title' => "Klik Untuk Menambahkan Data",
            )
    );
    ?>	
</div>
<div class="panel-body overflow-x">
    <?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>
    <table class="table table-bordered table-striped table-condensed" id="tableKantong">
        <thead>
            <tr>
                <th>No</th>                                            
                <th>No Barcode</th>
                <th>Jenis Kantong Darah</th>
                <th>No. Kantong Pabrik</th>						
                <th>Volume</th>
                <th>Gol Darah</th>
                <th>Rhesus</th>
                <th>Sample Konfirmasi Golongan Darah</th>
                <th>Sample Skrinning IMLTD</th>
                <th>Kantong Darah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<?php $urlGetMultipleKantong = $this->createUrl('GetMultipleKantong'); ?>

<?php
$jscript = <<< JS
function submitKantongDarah()
{
    nomorbarcode_utama = $('#nomorbarcode_utama').val();
    daftardonasi_id = $('#daftardonasi_id').val();
    jeniskantong = $('#PenggunaanCoolboxdetT_jeniskantong').val();
    volume = $('#PenggunaanCoolboxdetT_volume').val();
    penggunaan_coolbox_id = $('#PenggunaanCoolboxT_penggunaan_coolbox_id').val();
    var gol_darah = $('#PenggunaanCoolboxdetT_gol_darah').val();
        
    sampelkonfirmasi = '';
    ada_samplekonfirmasi = $('#PenggunaanCoolboxdetT_ada_samplekonfirmasi_0');
    if (ada_samplekonfirmasi.is(" :checked")) {
        sampelkonfirmasi = "Ada";
    }
    ada_samplekonfirmasi1 = $('#PenggunaanCoolboxdetT_ada_samplekonfirmasi_1');
    if (ada_samplekonfirmasi1.is(" :checked")) {
        sampelkonfirmasi = "Tidak Ada";
    }
    
    sampleitd = '';
    ada_sampleitd = $('#PenggunaanCoolboxdetT_ada_sampleitd_0');
    if (ada_sampleitd.is(" :checked")) {
        sampleitd = "Ada";
    }
    ada_sampleitd1 = $('#PenggunaanCoolboxdetT_ada_sampleitd_1');
    if (ada_sampleitd1.is(" :checked")) {
        sampleitd = "Tidak Ada";
    }
        
    kantongdarah = '';
    ada_kantongdarah = $('#PenggunaanCoolboxdetT_ada_kantongdarah_0');
    if (ada_kantongdarah.is(" :checked")) {
        kantongdarah = "Ada";
    }
    ada_kantongdarah1 = $('#PenggunaanCoolboxdetT_ada_kantongdarah_1');
    if (ada_kantongdarah1.is(" :checked")) {
        kantongdarah = "Tidak Ada";
    }
        
    var rhesus = '';
    var ada_rhesus = $('#PenggunaanCoolboxdetT_rhesus_0');
    if (ada_kantongdarah.is(" :checked")) {
        rhesus = "Positif";
    }
    ada_kantongdarah = $('#PenggunaanCoolboxdetT_rhesus_1');
    if (ada_kantongdarah1.is(" :checked")) {
        rhesus = "Negatif";
    }

    var no_kantongpabrik = $('.no_kantongpabrik').val();
    
        
    if(nomorbarcode_utama==''){
        myAlert('Silahkan Pilih Barcode Terlebih Dahulu');
    }else if (penggunaan_coolbox_id == ''){
        myAlert('Pilih coolbox yang akan digunakan');
    }else if((kantongdarah == '') || (sampleitd == '') || (sampelkonfirmasi == '')  || gol_darah == '' || rhesus == '' || no_kantongpabrik == ''){
        myAlert('Input field yang bertanda merah');
    }else{
        $.post("${urlGetMultipleKantong}", {
                                            penggunaan_coolbox_id:penggunaan_coolbox_id, 
                                            nomorbarcode_utama:nomorbarcode_utama, 
                                            jeniskantong:jeniskantong, 
                                            volume:volume, 
                                            sampelkonfirmasi:sampelkonfirmasi, 
                                            sampleitd:sampleitd, 
                                            kantongdarah:kantongdarah,
                                            rhesus:rhesus, 
                                            gol_darah:gol_darah,
                                            no_kantongpabrik:no_kantongpabrik,
                                            daftardonasi_id:daftardonasi_id
                                            },
        function(data){
            $('#tableKantong > tbody').append(data.return);
            $("#tableKantong tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
            renameInputRow($("#tableKantong"));	
            $("#nomorbarcode").focus();
            resetPilihMenuBahan();
            unformatNumberSemua();
            formatNumberSemua();
        }, "json");
    }   
}
		
function resetPilihMenuBahan(){
    $('#nomorbarcode_utama').val("");
    $('#PenggunaanCoolboxdetT_jeniskantong').val("");
    $('#PenggunaanCoolboxdetT_volume').val("");
    $('#nomorbarcode').val("");
    $('.no_kantongpabrik').val("");
    ada_samplekonfirmasi = $('#PenggunaanCoolboxdetT_ada_samplekonfirmasi_0');
    if (ada_samplekonfirmasi.is(" :checked")) {
        $('#PenggunaanCoolboxdetT_ada_samplekonfirmasi_0').removeAttr('checked');
    } else {
        $('#PenggunaanCoolboxdetT_ada_samplekonfirmasi_1').removeAttr('checked');
    }
    
    ada_sampleitd = $('#PenggunaanCoolboxdetT_ada_sampleitd_0');
    if (ada_sampleitd.is(" :checked")) {
        $('#PenggunaanCoolboxdetT_ada_sampleitd_0').removeAttr('checked');
    } else {
        $('#PenggunaanCoolboxdetT_ada_sampleitd_1').removeAttr('checked');
    }
    
    ada_kantongdarah = $('#PenggunaanCoolboxdetT_ada_kantongdarah_0');
    if (ada_kantongdarah.is(" :checked")) {
        $('#PenggunaanCoolboxdetT_ada_kantongdarah_0').removeAttr('checked');
    } else {
        $('#PenggunaanCoolboxdetT_ada_kantongdarah_1').removeAttr('checked');
    }
}
JS;

Yii::app()->clientScript->registerScript('bahanmenudiet', $jscript, CClientScript::POS_HEAD);
?>

<?php
    $this->renderPartial($this->path_view . '/_dialogKantongDarah');
?>

<script>
    $(document).ready(function () {
        $(".add-on").on("click", function () {
            changeSize();
        });


    });

    function changeSize()
    {
        window.parent.document.getElementById('tableKantong').style = 'overflow-y:scroll;';
    }

    function setMenuDiet(id) {
        $("#tableKantong").addClass("animation-loading");
        $('#tableKantong > tbody').html("");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetMenuDiet'); ?>',
            data: {id: id, is_update: 1}, //
            dataType: "json",
            success: function (data) {
                $('#tableKantong > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInputRow($("#tableKantong"));
                $("#tableKantong").removeClass("animation-loading");
                $("#tableKantong tbody tr .float2").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2, "symbol": null});

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }

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

    function hapusBahanResepMakanan(obj) {
        var menumakanan_id = $(obj).parents("tr").find("input[name$='[menumakanan_id]']").val();
        var bahanmakanan_id = $(obj).parents("tr").find("input[name$='[bahanmakanan_id]']").val();
        if (menumakanan_id !== "" && bahanmakanan_id != "") {
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?", "Perhatian!",
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
                                        renameInputRow($("#tableKantong"));
                                    }
                                    myAlert(data.pesan);
                                    var rowCount = $("#tableKantong").find('tbody tr').length;
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log(errorThrown);
                                }
                            });
                        }
                    });
        } else {
            $(obj).parents('tr').detach();
            renameInputRow($("#tableKantong"));
        }
    }

    function hapusTemporaryKantong(obj) {
        $(obj).parents('tr').detach();
        renameInputRow($("#tableKantong"));
    }
    
    function cekKantong(nomor){
        if(nomor != ''){
            $("#table-pegawai-ditugaskan > tbody > tr").each(function () {
                if ($(this).attr('data-row') == no) {
                    setUnitKerja($(this).find('input[name$="[suratsponsorunitkerja_id]"]'), data[0]);
                }
            });
            
            $.ajax({
                type: 'POST',
                data: {nomor: nomor},
                url: '<?php echo $this->createUrl('getDataKantong'); ?>',
                dataType: "json",
                success: function (data) {
                    $('#no_kantongdarah').val(data.no_kantongdarah);
                    $('#PenggunaanCoolboxdetT_kantongdarah_id').val(data.kantongdarah_id);
                    $('#PenggunaanCoolboxdetT_jeniskantong').val(data.jeniskantong);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }
    
    function cekData(nomor){    
        var cek = 0;
        
         if(nomor != ''){
            $("#tableKantong > tbody > tr").find(".nomorbarcode_utama").each(function(){                                                             
                if ($(this).val() == nomor){                 
                    cek++;
                }
            });           

            if (cek > 0 ){
                $('#nomorbarcode').val('');
                $('#nomorbarcode_utama').val('');
                $('#PenggunaanCoolboxdetT_jeniskantong').val('');   
                $('#PenggunaanCoolboxdetT_gol_darah').val('');
                $('#PenggunaanCoolboxdetT_rhesus_0').prop('checked',false);
                $('#PenggunaanCoolboxdetT_rhesus_1').prop('checked',false);                
                toastr.warning('Kantong darah sudah dipilih','Perhatian!');
                return false;
            }        
            
            $.ajax({
                type: 'POST',
                data: {term: nomor},
                url: '<?php echo $this->createUrl('AutoCompleteGetKantong'); ?>',
                dataType: "json",
                success: function (data) {                    
                    $('#nomorbarcode_utama').val(data[0].nomorbarcode_utama);
                    $('#nomorbarcode').val(data[0].nomorbarcode_utama);  
                    $('#PenggunaanCoolboxdetT_jeniskantong').val(data[0].nama_jenis);  
                    $('#PenggunaanCoolboxdetT_gol_darah').val(data[0].gol_darah);  
                    $('#PenggunaanCoolboxdetT_rhesus_0').prop('checked',data[0].rhesus_positif);  
                    $('#PenggunaanCoolboxdetT_rhesus_1').prop('checked',data[0].rhesus_negatif);  
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        
        }
    }
</script>