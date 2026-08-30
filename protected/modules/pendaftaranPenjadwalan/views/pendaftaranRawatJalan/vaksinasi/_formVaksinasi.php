<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Vaksinasi/<br/>Imunisasi <span class="required">*</span></th>
            <th>
                Vaksinasi/<br/>Imunisasi Ke-<span class="required">*</span>
            </th>
            <th>
                Jenis Vaksin/<br/>Imunisasi <span class="required">*</span>
                <?php echo CHtml::htmlButton('+', array('class'=>'btn btn-success', 'onclick'=>'tambahMasterJenisVaksin();')); ?>
            </th>
            <th>
                Program Vaksinasi/<br/>Imunisasi <span class="required">*</span>
                <?php echo CHtml::htmlButton('+', array('class'=>'btn btn-success', 'onclick'=>'tambahMasterProgramImunisasi();')); ?>
            </th>
            <th>
                Nama Vaksin/<br/>Imunisasi <span class="required">*</span>
                <?php echo CHtml::htmlButton('+', array('class'=>'btn btn-success', 'onclick'=>'tambahMasterVaksin();')); ?>
            </th>
            <th>No. Batch </th>
            <th>Lokasi Menerima <span class="required">*</span></th>
            <th>
                <?php echo CHtml::htmlButton('+', array('class'=>'btn btn-success', 'onclick'=>'tambahRowRiwayat();')); ?>
            </th>
        </tr>
    </thead>
    <tbody id="tab_riwayat_vaksinasi">
        
    </tbody>
</table>

<?php

$listJenis = CHtml::listData(JenisvaksinM::model()->findAll('jenisvaksin_aktif = true order by jenisvaksin_nama asc'), 'jenisvaksin_id', 'jenisvaksin_nama');

$str_list_jenis = '<option value="">-- Pilih --</option>';
foreach ($listJenis as $val => $item) {
    $str_list_jenis.= '<option value="'.$val.'">'.$item.'</option>';;
}

?>

<script>
    
    var row_idx = 0;
    var item_jenis_vaksinasi = '<?php echo $str_list_jenis; ?>';
    var row_vaksinasi = <?php echo CJSON::encode(array(
        'html'=>$this->renderPartial("pendaftaranPenjadwalan.views.pendaftaranRawatJalan.vaksinasi._rowVaksinasi", array(), true),
    )); ?>;
        
        
    function getDataRiwayatVaksinasi(pasien_id) {
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/loadRiwayatVaksinasi') ?>', {pasien_id: pasien_id}, function(data) {
            if (data.ok == 1) {
                
                var idx = 0;
                
                $("#tab_riwayat_vaksinasi").html(data.html);
                
                renameInputRiwayatVaksinasi();
                
                $("#tab_riwayat_vaksinasi tr").each(function() {
                    
                    var date_input = $(this).find(".vaksinasi_tanggal").attr("id", "vaksinasi_tanggal_" + row_idx);
                    
                    $(date_input).datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                        jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                             'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    $(date_input).parents(".input-append").find(".add-on").on('click', function() { $(date_input).datepicker('show'); }); 
                    
                    //$(this).find(".jenisvaksin_id").html(item_jenis_vaksinasi);
                    $(this).find(".vaksinasi_ke").maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ",",
                        "thousands": "",
                        "precision": 0
                    });

                    row_idx++;
                    
                });
                
                if ($("#tab_riwayat_vaksinasi tr").length > 0) {
                    tampilFormRiwayatVaksinasi();
                }
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }    
        
    function hapusRowRiwayatVaksinasi(obj) {
        $(obj).parents("tr").remove();
    }    
        
        
        
    function tambahRowRiwayat() {
        $("#tab_riwayat_vaksinasi").append(row_vaksinasi.html);
        renameInputRiwayatVaksinasi();
        
        var last = $("#tab_riwayat_vaksinasi tr:last-child");
        
        var date_input = $(last).find(".vaksinasi_tanggal").attr("id", "vaksinasi_tanggal_" + row_idx);
        
        
        $(date_input).datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
        $(date_input).parents(".input-append").find(".add-on").on('click', function() { $(date_input).datepicker('show'); });             
        
        $(last).find(".jenisvaksin_id").html(item_jenis_vaksinasi);
        $(last).find(".vaksinasi_ke").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": "",
            "precision": 0
        });
        
        row_idx++;
        
    }
    
    function renameInputRiwayatVaksinasi() {
        
        var name_val = "RiwayatvaksinasipasienT[detail]";
        var id_val = "RiwayatvaksinasipasienT_detail_";
        var idx = 0;
        
        $("#tab_riwayat_vaksinasi tr").each(function() {
            
            var name_res = name_val + '[' + idx + ']';
            // var id_res = id_val + idx + '_';
            
            $(this).find(".riwayatvaksinasipasien_id").attr("name", name_res + "[riwayatvaksinasipasien_id]");
            $(this).find(".vaksinasi_tanggal").attr("name", name_res + "[vaksinasi_tanggal]");
            $(this).find(".vaksinasi_ke").attr("name", name_res + "[vaksinasi_ke]");
            $(this).find(".jenisvaksin_id").attr("name", name_res + "[jenisvaksin_id]");
            $(this).find(".vaksin_id").attr("name", name_res + "[vaksin_id]");
            $(this).find(".daftarvaksin_id").attr("name", name_res + "[daftarvaksin_id]");
            $(this).find(".no_batch").attr("name", name_res + "[no_batch]");
            $(this).find(".vaksinasi_lokasimenerima").attr("name", name_res + "[vaksinasi_lokasimenerima]");
            
            idx++;
        });
    } 
    
    
    function setItemVaksin(obj) {
        var jenisvaksin_id = $(obj).val();
        var input_vaksin = $(obj).parents("tr").find(".vaksin_id");
        
        $(obj).parents("tr").find(".daftarvaksin_id").val("");
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListVaksin'); ?>', {jenisvaksin_id: jenisvaksin_id}, function(data) {
            $(input_vaksin).html(data.html);
        }, 'json');
    }
    
    function setItemDaftarVaksin(obj) {
        var vaksin_id = $(obj).val();
        var input_daftar_vaksin = $(obj).parents("tr").find(".daftarvaksin_id");
        
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListDaftarVaksin'); ?>', {vaksin_id: vaksin_id}, function(data) {
            $(input_daftar_vaksin).html(data.html);
        }, 'json');
    }
    
    function setLoadJenisVaksinasi() {
        $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListJenisVaksin'); ?>', {}, function(data) {
            
            $(".list_jenisvaksin").each(function() {
                var data_lama = $(this).val();
                $(this).html(data.html);
                $(this).val(data_lama);
            });
            
            item_jenis_vaksinasi = data.html;
        }, 'json');
    }
    
    function setLoadProgramVaksinasi(jenisvaksin_id) {
        $("#tab_riwayat_vaksinasi tr").each(function() {
            
            var input_vaksin = $(this).find(".vaksin_id");
            
            if ($(this).find(".jenisvaksin_id").val() == jenisvaksin_id) {
                $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListVaksin'); ?>', {jenisvaksin_id, jenisvaksin_id}, function(data) {
                    var nilai_lama = $(input_vaksin).val();
                    $(input_vaksin).html(data.html).val(nilai_lama);
                }, 'json');
            }
        });
    }
    function setLoadDaftarVaksinasi(vaksin_id) {
        console.log("VAKSIN", vaksin_id);
        $("#tab_riwayat_vaksinasi tr").each(function() {
            
            var input_vaksin = $(this).find(".daftarvaksin_id");
            
            if ($(this).find(".vaksin_id").val() == vaksin_id) {
                $.post('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/ajaxListDaftarVaksin'); ?>', {vaksin_id, vaksin_id}, function(data) {
                    var nilai_lama = $(input_vaksin).val();
                    $(input_vaksin).html(data.html).val(nilai_lama);
                }, 'json');
            }
        });
    }
    
    /** control accordion penanggung jawab pasien */
    $('#form-vaksinasi > div > .accordion-heading').click(function(){
    //    console.log("Detail PJ Pasien Di Klik!");
        var is_vaksinasi = $("#<?php echo CHtml::activeId($model, "is_vaksinasi"); ?>");
        if(is_vaksinasi.val() > 0){ //hide
            is_vaksinasi.val(0);
        }else{//show
            is_vaksinasi.val(1);
        }
    });
    
    function tampilFormRiwayatVaksinasi(){
        $('#form-vaksinasi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-vaksinasi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-vaksinasi').removeClass().addClass("accordion-body in collapse");
        $("#<?php echo CHtml::activeId($model, "is_vaksinasi"); ?>").val(1);
    }
    
    
    function cekValidasiRiwayatVaksinasi() {
        var is_kosong = 0;
        var is_vaksinasi = $("#<?php echo CHtml::activeId($model, "is_vaksinasi"); ?>").val();
        
        $("#tab_riwayat_vaksinasi .input_req").each(function() {
            $(this).removeClass("error");
            if ($(this).val() == "" || $(this).val() == null) {
                is_kosong = 1;
                $(this).addClass("error");
            }
        });
        
        if (is_kosong != 0 && is_vaksinasi == 1) {
            myAlert("Input pada Kolom * pada Tabel Riwayat Vaksinasi harus diisi");
            return false;
        }
        
        return true;
        
    }
</script>