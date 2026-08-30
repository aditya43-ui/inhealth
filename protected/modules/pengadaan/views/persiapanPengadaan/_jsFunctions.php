<?php
/** 
 * view ini digunakan untuk menampung fungsi - fungsi javascript
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
$det = new ADPersiapanpengadaandetT;
?>
<script type='text/javascript'>
    function setUnitKerjaPPK(data){
        $("#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>").val(data.unitkerja_id);
        $("#<?php echo CHtml::activeId($model, 'namaunitkerja') ?>").val(data.namaunitkerja);
        $("#<?php echo CHtml::activeId($model, 'instalasi_id') ?>").val(data.instalasi_id);
        $("#<?php echo CHtml::activeId($model, 'instalasi_nama') ?>").val(data.instalasi_nama);
        
        $("#dialogUnitKerjaPPK").dialog('close');
    }
    
    function gantiNamaMetode(obj){
        var select = $(obj).find(":selected").text();
        
        $("#<?php echo CHtml::activeId($model, 'metodepengadaan_nama') ?>").val(select);
        
        loadDokByMetode(obj);
    }
    
    
     function tambahBaris(){
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'form/_rowHPS',array('model'=>$det, 'i'=>1,),true));?>';               
        
        $("#tabel-hps > tbody").append(row);
        
        $("#tabel-hps > tbody > tr:last").find('.integer-decimal').maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
        );                    

        $("#tabel-hps > tbody > tr:last").find('.float2').maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
        );
        
       
        renameInput($("#tabel-hps"));
    }
    
    function hapusBaris(obj){
        myConfirm("Apakah Anda yakin, ingin menghapus data ini ?","Perhatian !",function(r){
            if (r){
                $(obj).parents("tr").remove();
                renameInput($("#tabel-hps"));                                                
            }
        });
    }
    
    function renameInput(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find('.no_urut').html(row+1);
            $(this).attr('data-row',row);
            
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
                
                if(old_name_arr.length == 4){
                    $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                    $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
                }
            });
            row++;
        });

        row = 0;
        $(obj_table).find('tbody > tr').each(function(){
            if (row == 0){
                $(this).find('.tambah').attr('style','display:block;border-radius:100%;padding:0px;');
                $(this).find('.hapus').attr('style','display:none;border-radius:100%;padding:0px;');
            }else if(row >= 1){
                $(this).find('.tambah').attr('style','display:block;border-radius:100%;padding:0px;');
                $(this).find('.hapus').attr('style','display:block;border-radius:100%;padding:0px;');
            }
            row++;
        });
        
        $("#tabel-hps > tbody > tr").find('.angkacoma-only').keyup(function(e) {
            setAngkaComaOnly(this);
        });
        
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
                   
    function refreshTableRUP(){
        var instalasi_id = $("#<?php echo CHtml::activeId($model, 'instalasi_id') ?>").val();
        var kategori_pengadaan = $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_kategori') ?>").val();
        var periodeanggaran_id = $("#<?php echo CHtml::activeId($model, 'periodeanggaran_id') ?>").val();
        var unitkerja_id = $("#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>").val();
    
        $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_nomor') ?>").addClass("animation-loading-1");        
        setTimeout(function(){       
            $.fn.yiiGridView.update('dialog-rup-grid', {
                data: {
                    "ADRencanaumumpengadaanT[instalasi_id]":instalasi_id,
                    "ADRencanaumumpengadaanT[rencanaumumpengadaan_kategori]":kategori_pengadaan,
                    "ADRencanaumumpengadaanT[periodeanggaran_id]":periodeanggaran_id,
                    "ADRencanaumumpengadaanT[pegawaippk_id]":'<?php echo Yii::app()->user->getState('pegawai_id') ?>',
                    "ADRencanaumumpengadaanT[unitkerja_id]":unitkerja_id,
                    "ADRencanaumumpengadaanT[filter]":true,
                }
            });            
            
            $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_nomor') ?>").removeClass("animation-loading-1");                        
        }
        ,100);
                
    }
    
    function generatePicker(){        
//        $("#id-detail > tbody > tr").find('input[name$="[invperalatan_namabrg]"]').each(function(){                                                    
//            $(this).autocomplete(
//                {
//                    'showAnim':'fold',
//                    'minLength':3,
//                    'focus':function(event, ui )
//                    {
//                        $(this).val("");
//                        return false;
//                    },
//                    'select':function( event, ui )
//                    {                                                
//                        setAset(ui.item,this);
//                        return false;
//                    },
//                    'source':function(request, response)
//                    {                                                                                                                                  
//                        $.ajax({
//                            url: "<?php //echo $this->createUrl('/actionAutoComplete/dropInventarisasiAset');?>",
//                            dataType: "json",
//                            data:{
//                                term: request.term,                                
//                                invperalatan_id: $("#tampung_id").val(),
//                                custom:'not_invperalatan_id'
//                            },
//                            success: function (data) {
//                                response(data);
//                            }
//                        })
//                    },
//                }
//            );
//        });
        
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    function setDialog(){       
        refreshTableRUP();
        
        $("#dialogRUP").dialog("open");                                        
    }        
    
    function cekRUPNomor(obj){
        var temp = $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_nomortemp') ?>").val();
        
        if($(obj).val() == ""){ 
            var count = 0;
            
             $("#form-penyedia").find('input, textarea, select').each(function(){
                if ($(this).val() != ''){
                    count++;
                }
             });        
             
             $("#form-swakelola").find('input, textarea, select').each(function(){
                if ($(this).val() != ''){
                    count++;
                }
             });        
            
            
            if (count > 0){
                myConfirm("Apakah Anda yakin ingin, mengganti data rencana umum pengadaan ini ?","Perhatian", function(r){
                    if (r){
                        $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_id'); ?>").val("");
                        resetFormPenyedia();
                        resetFormSwakelola();
                        resetFormLanjutan();
                        resetFormDokumen();
                    }else{
                        $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_nomor'); ?>").val(temp);                    
                    }
                });
            }            
        }
    }
    
    function loadDokByMetode(obj){
        var rencanaumumpengadaan_id = $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_id') ?>").val();
        var metodepengadaan_id = $(obj).val();
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('loadDokPengadaan'); ?>',
            data: {
                metodepengadaan_id:  metodepengadaan_id,       
                rencanaumumpengadaan_id: rencanaumumpengadaan_id,
                persiapanpengadaan_id:<?php echo !empty($model->persiapanpengadaan_id)?$model->persiapanpengadaan_id:"''"; ?>,
            },
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){                                                                                     
                    $("#form-dokpendukung > tbody").html(data.html);                       
                }else{
                    toastr.error(data.pesan);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });   
    }
        
    function loadRUP(rencanaumumpengadaan_id){         
        var kategori = $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_kategori') ?>").val();
    
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('loadRUP'); ?>',
            data: {rencanaumumpengadaan_id:rencanaumumpengadaan_id, kategori:kategori,persiapanpengadaan_id:<?php echo !empty($model->persiapanpengadaan_id)?$model->persiapanpengadaan_id:"''"; ?>},
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){       
                    cekKatPengadaan($("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_kategori') ?>"));
                    
                    $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_id'); ?>").val(data.rencanaumumpengadaan_id);
                    $("#<?php echo CHtml::activeId($model, 'programkerja_id'); ?>").val(data.programkerja_id);
                    $("#<?php echo CHtml::activeId($model, 'subprogram_id'); ?>").val(data.subprogram_id);
                    $("#<?php echo CHtml::activeId($model, 'programkerja_nama'); ?>").val(data.programkerja_nama);
                    $("#<?php echo CHtml::activeId($model, 'subprogramkerja_nama'); ?>").val(data.subprogramkerja_nama);
                    $("#<?php echo CHtml::activeId($model, 'nama_pekerjaan'); ?>").val(data.nama_pekerjaan);
                    $("#<?php echo CHtml::activeId($model, 'persiapanpengadaan_pagu'); ?>").val(data.total_pagu);
                    $("#<?php echo CHtml::activeId($model, 'jenispengadaan_id'); ?>").val(data.jenispengadaan_id);                    
                    $("#<?php echo CHtml::activeId($model, 'jenispengadaan_nama'); ?>").val(data.jenispengadaan);                    
                    $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_nomor'); ?>").val(data.rencanaumumpengadaan_nomor);                    
                    $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_nomortemp'); ?>").val(data.rencanaumumpengadaan_nomor);
                    $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id'); ?>").val(data.metodepengadaan_id);
                    $("#<?php echo CHtml::activeId($model, 'metodepengadaan_nama'); ?>").val(data.metodepengadaan_nama);
                    $("#<?php echo CHtml::activeId($model, 'pemanfaatanbarang_tglawal'); ?>").val(data.pemanfaatanbarang_tglawal);
                    $("#<?php echo CHtml::activeId($model, 'pemanfaatanbarang_tglakhir'); ?>").val(data.pemanfaatanbarang_tglakhir);
                    $("#<?php echo CHtml::activeId($model, 'pelaksanaankontrak_tglawal'); ?>").val(data.pelaksanaankontrak_tglawal);
                    $("#<?php echo CHtml::activeId($model, 'pelaksanaankontrak_tglakhir'); ?>").val(data.pelaksanaankontrak_tglakhir);
                    $("#<?php echo CHtml::activeId($model, 'pemilihanpenyedia_tglawal'); ?>").val(data.pemilihanpenyedia_tglawal);
                    $("#<?php echo CHtml::activeId($model, 'pemilihanpenyedia_tglakhir'); ?>").val(data.pemilihanpenyedia_tglakhir);
                    $("#<?php echo CHtml::activeId($model, 'swakelola_tipe'); ?>").val(data.swakelola_tipe);
                    $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_nama'); ?>").val(data.subkegiatanprogram_nama);
                    $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_id'); ?>").val(data.subkegiatanprogram_id);
                    $("#<?php echo CHtml::activeId($model, 'dpa_pagu'); ?>").val(data.dpa_pagu);
                    $("#<?php echo CHtml::activeId($model, 'kode_sirup'); ?>").val(data.kode_rup);
                    $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya'); ?>").val(data.total_hargaseluruhnya);
                    $("#<?php echo CHtml::activeId($model, 'total_pajak') ?>").val(data.total_pajak);
                    $("#<?php echo CHtml::activeId($model, 'total_harga') ?>").val(data.total_harga);
                    $("#sumberdana").html(data.sumberDana);
                    $("#tabel-hps > tbody").html(data.tr);                   
                    $("#form-dokpendukung > tbody").html(data.dokDukung);
                    $("#form-dokrup > tbody").html(data.dokRUP);
                    
                    $("#tabel-hps").find('input[class*="integer-decimal"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
                    );                    
            
                    $("#tabel-hps").find('input[class*="float2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
                    );
            
                    formatNumberSemua();
            
                    renameInput($("#tabel-hps"));
                    
//                    hitung();
            
                    $("#dialogRUP").dialog("close");        
                }else{
                    toastr.error(data.pesan);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });                  
    }
    
    function cekForm(){        
                            
        unformatNumberSemua();
        var ok = 0;
        var item = [];
        var i = 0;
        $("#tabel-hps > tbody > tr").each(function(){
            var nama = ($(this).find(".persiapanpengadaandet_nama").val());
            var sisapagu = ($(this).find(".sisapagu_pengadaan").val());
            var jumlah_hargalama = ($(this).find(".jumlah_hargalama").val());
            var jumlah_hargabaru = ($(this).find(".harga").val());
            var selisihpagu = 0;
                   
            jumlah_hargalama = parseFloat(jumlah_hargalama);   
            jumlah_hargabaru = parseFloat(jumlah_hargabaru);                                

            selisihpagu = jumlah_hargabaru - jumlah_hargalama;
            
//            alert('selisih : '+selisihpagu+'. sisapagu : '+sisapagu);
            
            if(selisihpagu > sisapagu){
                var arraycontains_item = (item.indexOf(nama) > -1);
                console.log(arraycontains_item);   

                if (arraycontains_item == false){
                    item[i] = nama;
                    i++;
                }  
                ok = 1;
            }else{
                ok = 0;
            }      
            
        }); 
        
        if(ok == 1){
            formatNumberSemua();
            myAlert("<strong>Item "+item.join(', ')+"</strong> melebihi sisa pagu","Perhatian");
            return false;
        }
//        return false;           
        <?php if (!empty($model->persiapanpengadaan_id)){ ?>
                if (<?php echo $model->pegawaipembuat_id ?> != <?php echo Yii::app()->user->getState('pegawai_id') ?> && 
                    <?php echo $model->rencanaumumpengadaan->pegawaipa_id ?> != <?php echo Yii::app()->user->getState('pegawai_id') ?> && 
                    <?php echo $model->rencanaumumpengadaan->pegawaikpa_id ?> != <?php echo Yii::app()->user->getState('pegawai_id') ?> && 
                    <?php echo $model->rencanaumumpengadaan->pegawaippk_id ?> != <?php echo Yii::app()->user->getState('pegawai_id') ?> ){
                    formatNumberSemua();
                    myAlert("Maaf, Anda tidak berwenang mengubah data.", "Perhatian!");
                    return false;
                }
        <?php } ?>
    
        var total_seluruh = parseFloat($("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").val());
        var dpa_pagu = parseFloat($("#<?php echo CHtml::activeId($model, 'dpa_pagu') ?>").val());                
        
        if ( total_seluruh > dpa_pagu) {
            formatNumberSemua();
            myAlert("Maaf, total harga tidak boleh melebihi pagu dari DPA");
            return false;
        }    
    
        formatNumberSemua();
        if (requiredCheck($("#persiapanpengadaan-t-form"))){
            var metode_pengadaan = $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").val();
            var jenis_pengadaan = $("#<?php echo CHtml::activeId($model, 'jenispengadaan_id') ?>").val();
            var jenis_pengadaan_konsultasi = '<?= Params::JENIS_PENGADAAN_ID_JASA_KONSULTASI?>';
            var metode_pengadaan_epurchasing = '<?= Params::METODE_PENGADAAN_ID_EPURCHASING?>';
            var total_seluruh_pengadaan = $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").val();
                        
            // formatNumberSemua() ketika tidak jadi submit, ketika di-submit maka tidak perlu formatNumberSemua() 
            if (total_seluruh_pengadaan > 200000000 && jenis_pengadaan !== jenis_pengadaan_konsultasi) { // kondisi 1 > 200 juta dan jenis_pengadaan != Jasa Konsultasi 
                myConfirm("Nilai yang diadakan lebih dari 200.000.000 sehingga pengadaan dilakukan oleh Pejabat Pembuat Komitmen. Apakah Anda yakin untuk menyimpan?","Perhatian!",function(r){
                    if (r){
                        $('#persiapanpengadaan-t-form').submit();
                        disableOnSubmit($("#btn_submit"),'no_unformat');
                    } else {
                        formatNumberSemua();
                    }
                });
            } else if (total_seluruh_pengadaan > 100000000 && jenis_pengadaan == jenis_pengadaan_konsultasi){ // kondisi 2 > 100 juta dan jenis_pengadaan == Jasa Konsultasi
                myConfirm("Pengadaan Jasa Konsultansi dengan nilai yang diadakan lebih dari 100.000.000 sehingga pengadaan dilakukan oleh Pejabat Pembuat Komitmen. Apakah Anda yakin untuk menyimpan?","Perhatian!",function(r){
                    if (r){
                        $('#persiapanpengadaan-t-form').submit();
                        disableOnSubmit($("#btn_submit"),'no_unformat');
                    } else {
                        formatNumberSemua();
                    }
                });
            } else if (total_seluruh_pengadaan <= 10000000 && metode_pengadaan !== metode_pengadaan_epurchasing) { // kondisi 3 nilai pengadaan <=10 jt dan metode pengadaan  selain e-purchasing (metodepengadaan_id = 3) 
                myConfirm("Nilai yang diadakan kurang dari 10.000.000 (non e-purchasing) sehingga pengadaan dilakukan oleh Pejabat Pembuat Komitmen. Apakah Anda yakin untuk menyimpan?","Perhatian!",function(r){
                    if (r){
                        $('#persiapanpengadaan-t-form').submit();
                        disableOnSubmit($("#btn_submit"),'no_unformat');
                    } else {
                        formatNumberSemua();
                    }
                });
            } else { // kondisi 4 selain kondisi di atas 
                $('#persiapanpengadaan-t-form').submit();
                disableOnSubmit($("#btn_submit"),'no_unformat');
            }
            
        }
        
       return false;
    }
    
    function unformatNilai(){
        $("#tabel-hps > tbody > tr").each(function(){
           var pajak = unformatNumber($(this).find(".persenpajak").val());           
           $(this).find(".persenpajak").val(pajak);
        });                
    }
    
    function formatNilai(){
        $("#tabel-hps > tbody > tr").each(function(){
           var pajak = formatNumbers($(this).find(".persenpajak").val());           
           $(this).find(".persenpajak").val(pajak);
        });                
    }
    
    function cekKatPengadaan(obj){
        var kat = $(obj).val();
        
        
        if (kat.toUpperCase() == '<?php echo Params::KATEGORI_PENGADAAN_PENYEDIA; ?>'){
            $("#form-penyedia").removeClass('hide');
            $("#form-tanggalkontrak").removeClass('hide');             
            $("#form-swakelola").addClass('hide');             
            
            $("#judul-tanggal").html("Kontrak");
            
            resetFormSwakelola();
            resetFormLanjutan();
            resetFormDokumen();
        }else if (kat.toUpperCase() == '<?php echo Params::KATEGORI_PENGADAAN_SWAKELOLA; ?>'){
            $("#form-penyedia").addClass('hide');
            $("#form-tanggalkontrak").removeClass('hide');             
            $("#form-swakelola").removeClass('hide');            
            
            $("#judul-tanggal").html("Pekerjaan");
            
            resetFormPenyedia();
            resetFormLanjutan();
            resetFormDokumen();
        }else{
            $("#form-penyedia").addClass('hide');
            $("#form-tanggalkontrak").addClass('hide');             
            $("#form-swakelola").addClass('hide');            
            
            $("#judul-tanggal").html("Pekerjaan");
            
            resetFormPenyedia();
            resetFormLanjutan();
            resetFormSwakelola();
            resetFormDokumen();
        }
    }
    
    
    function resetFormPenyedia(){                
        $("#form-penyedia").find('input, textarea, select').val('');        
    }
    
    function resetFormSwakelola(){
        $("#form-swakelola").find('input, textarea, select').val('');        
    }        
    
    function resetFormLanjutan(){
        <?php if (empty($model->persiapanpengadaan_id)){ ?>
            $("#form-lanjutan").find('input, textarea, select').val('');        
            $("#tabel-hps > tbody").html('');
            $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_nomor') ?>").val('');
            $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_id') ?>").val('');
            $("#<?php echo CHtml::activeId($model, 'rencanaumumpengadaan_nomortemp') ?>").val('');
        <?php } ?>
    }
    
    function resetFormDokumen(){
        $("#form-dokpendukung > tbody").html('');  
        $("#form-dokrup > tbody").html('');        
    }
       
    function hitung(){
        var total_harga = 0;
        var total_pajak = 0;
        var grandtotal = 0;
        
        unformatNumberSemua();
        $("#tabel-hps > tbody > tr").each(function(){
            var volume = $(this).find(".volume").val();
            var harga = $(this).find(".estimasi").val();
            var pajak = ($(this).find(".persenpajak").val());
            var sisapagu = ($(this).find(".sisapagu_pengadaan").val());
            var jumlah_hargalama = ($(this).find(".jumlah_hargalama").val());
            var jumlah_hargabaru = ($(this).find(".harga").val());
            
            var total = 0; 
            var hit_pajak = 0;
            var harga_vol = 0;
            var selisihpagu = 0;
            
            if (volume != '' && harga != '' && pajak != ''){                
                volume = parseFloat(volume);
                harga = parseFloat(harga);                
                pajak = parseFloat(pajak);                                
               
                hit_pajak = ((volume*harga*pajak) /100);
               
                harga_vol = (volume * harga);                
                total = (harga_vol) + ( hit_pajak );                
                total_harga += harga_vol;
                total_pajak += hit_pajak;
                grandtotal += total;
                
                $(this).find('.pajak').val(hit_pajak.toFixed(2));
                $(this).find('.harga').val(total);
            }                        
        });       
        
        $("#<?php echo CHtml::activeId($model, 'total_harga') ?>").val(total_harga.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'total_pajak') ?>").val(total_pajak.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'total_hargaseluruhnya') ?>").val(grandtotal.toFixed(2));
        
        formatNumberSemua();
                
    }
      
    function cekFile(obj){       
        
        var cek = $(obj).val();               
        if (cek != ''){
            var type = $(obj).get(0).files[0]['type'];
            var tipeFile = type.split('/');                    
            var ext = '.'+$(obj).val().split('.').pop().toLowerCase();           
            var fileExt = $(obj).attr('accept').split(',');        
                                                
            if($.inArray(ext, fileExt) == -1 && $.inArray(tipeFile[0]+'/*', fileExt) == -1) {
                myAlert('Tipe file yang diupload tidak diizinkan !',"Perhatian!");
                $(obj).val(""); 
                $(".fileinput-exists").trigger('click');
                return false;
            }

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 10) {
                myAlert("Ukuran file tidak boleh lebih dari 200kb/2mb","perhatian !");
                $(obj).val("");                 
                $(obj).parents(".load-gambar").find('.labelbrowse').html('');
                $(".fileinput-exists").trigger('click');
                return false;
            }else{
                $(obj).parents(".load-gambar").find('.labelbrowse').html("<u>"+$(obj).get(0).files[0]['name']+"</u>");
            }
        }
       
    }
    
    function fileLoad(obj){
        $(obj).parents(".load-gambar").find('input:file').trigger('click');
    }

            
    $(document).ready(function(){
        <?php if (isset($_GET['sukses'])){ ?>
                
                $(".add-on").hide();
                $(".rowbutton").attr("style","display:none;");
                
                loadRUP(<?php echo $model->rencanaumumpengadaan_id; ?>);
                
                var kat = '<?php echo $model->rencanaumumpengadaan_kategori; ?>';
                
                if (kat.toUpperCase() == '<?php echo Params::KATEGORI_PENGADAAN_PENYEDIA; ?>'){
                    $("#form-penyedia").removeClass('hide');
                    $("#form-tanggalkontrak").removeClass('hide');             
                    $("#form-swakelola").addClass('hide');             

                    $("#judul-tanggal").html("Pemilihan Penyedia");
                  
                }else if (kat.toUpperCase() == '<?php echo Params::KATEGORI_PENGADAAN_SWAKELOLA; ?>'){
                    $("#form-penyedia").addClass('hide');
                    $("#form-tanggalkontrak").removeClass('hide');             
                    $("#form-swakelola").removeClass('hide');            
                   
                }
                
                $("#persiapanpengadaan-t-form").find('input,select,textarea').each(function(){
                    $(this).attr('readonly',true);
                });
        <?php             
            } else if(!empty($_GET['rencanaumumpengadaan_id'])){ ?>
                var rencanaumumpengadaan_id = '<?php echo $_GET['rencanaumumpengadaan_id']?>';
                loadRUP(rencanaumumpengadaan_id);
        <?php }else{ 
                //fungsi ubah
                if (!empty($model->persiapanpengadaan_id)){
        ?>
                    $("#persiapanpengadaan-t-form").find('input,select,textarea').each(function(){
                        $(this).attr('readonly',true);        
                    });
                    $('#ADRiwayatpengadaanR_riwayatpengadaan_catatan').attr('readonly',false);     
                    $('#ADRiwayatpengadaanR_riwayatpengadaan_lampiran').attr('readonly',false);  
                    $('#ADPersiapanpengadaanT_kode_sirup').attr('disabled',false);

                    $(".add-on").hide();
                    $(".rowbutton").attr("style","display:none;");

                    loadRUP(<?php echo $model->rencanaumumpengadaan_id; ?>);

                    var kat = '<?php echo $model->rencanaumumpengadaan_kategori; ?>';

                    $("#<?php echo CHtml::activeId($modRiwayat, 'riwayatpengadaan_catatan'); ?>").removeAttr("disabled");
                    $("#<?php echo CHtml::activeId($modRiwayat, 'riwayatpengadaan_lampiran'); ?>").removeAttr("disabled");

                    if (kat.toUpperCase() == '<?php echo Params::KATEGORI_PENGADAAN_PENYEDIA; ?>'){
                        $("#form-penyedia").removeClass('hide');
                        $("#form-tanggalkontrak").removeClass('hide');             
                        $("#form-swakelola").addClass('hide');             

                        $("#judul-tanggal").html("Pemilihan Penyedia");
                        
                        $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id'); ?>").removeAttr("disabled");
                        $("#<?php echo CHtml::activeId($model, 'metodepengadaan_nama'); ?>").removeAttr("disabled");
                        
                        $("#<?php echo CHtml::activeId($model, 'pemanfaatanbarang_tglawal'); ?>").removeAttr("disabled");
                        $("#<?php echo CHtml::activeId($model, 'pemanfaatanbarang_tglakhir'); ?>").removeAttr("disabled");
                        $("#<?php echo CHtml::activeId($model, 'pemanfaatanbarang_tglawal_date'); ?>").show();
                        $("#<?php echo CHtml::activeId($model, 'pemanfaatanbarang_tglakhir_date'); ?>").show();
                        
                        $("#<?php echo CHtml::activeId($model, 'pemilihanpenyedia_tglawal'); ?>").removeAttr("disabled");
                        $("#<?php echo CHtml::activeId($model, 'pemilihanpenyedia_tglakhir'); ?>").removeAttr("disabled");
                        $("#<?php echo CHtml::activeId($model, 'pemilihanpenyedia_tglawal_date'); ?>").show();
                        $("#<?php echo CHtml::activeId($model, 'pemilihanpenyedia_tglakhir_date'); ?>").show();                                                

                    }else if (kat.toUpperCase() == '<?php echo Params::KATEGORI_PENGADAAN_SWAKELOLA; ?>'){
                        $("#form-penyedia").addClass('hide');
                        $("#form-tanggalkontrak").removeClass('hide');             
                        $("#form-swakelola").removeClass('hide');                                   
                    }
                    
                    $("#<?php echo CHtml::activeId($model, 'swakelola_tipe'); ?>").removeAttr("disabled");
                    $("#<?php echo CHtml::activeId($model, 'pelaksanaankontrak_tglawal'); ?>").removeAttr("disabled");
                    $("#<?php echo CHtml::activeId($model, 'pelaksanaankontrak_tglakhir'); ?>").removeAttr("disabled");
                    $("#<?php echo CHtml::activeId($model, 'pelaksanaankontrak_tglawal_date'); ?>").show();
                    $("#<?php echo CHtml::activeId($model, 'pelaksanaankontrak_tglakhir_date'); ?>").show();                                                                                                                        
                    
                    setTimeout(function(){
                        $("#tabel-hps").find("input,textarea,select").each(function(){
                            $(this).attr('readonly',true);
                            if ($(this).hasClass('ubah')){
                                $(this).removeAttr('readonly');
                            }
                        });

                        $(".rowbutton").html('');
                    },500);
        <?php }} ?>
                    
    });
</script>
