<?php $i =0; ?>
<script>
    
    /*=== Lokasi Pekerjaan ===*/
    var row_lokasiPekerjaan = <?php echo CJSON::encode(array('html' => $this->renderPartial("detail/_rowLokasiPekerjaan", array('modLokasi'=>$modLokasi,'form'=>$form, 'i'=>$i++), true))); ?>;
    function tambahLokasiPekerjaan(obj) {
        $("#lokasiPekerjaan").append(row_lokasiPekerjaan.html);
        renameInputLokasiPekerjaan();
    }
    
    function hapusLokasiPekerjaan(obj) {
        $(obj).parents("tr").remove();
        renameInputLokasiPekerjaan();
    }
    
    function renameInputLokasiPekerjaan() {
        var cnt = 0;
        $("#lokasiPekerjaan tr").each(function() {
            $(this).find(".row_num").html(cnt+1);
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+cnt+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+cnt+"]["+old_name_arr[2]+"]");
                }
            });

            cnt++;
        });
    }
    
    function setKabupaten(obj){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetDropdownKabupaten'); ?>',
            data: {
                propinsi_id : $(obj).val(),
            },
            dataType: "json",
            success:function(data){
                $(obj).parents("tr").find('.kabupaten_id').html(data.form);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    /*=== Lokasi Pekerjaan ===*/
    
    /*=== Sumber dana ===*/
    var row_sumberdana = <?php echo CJSON::encode(array('html' => $this->renderPartial("detail/_rowSumberDana", array('modSumberDana'=>$modSumberDana,'form'=>$form, 'i'=>$i++), true))); ?>;
    function tambahSumberDana(){
        $("#sumberDana").append(row_sumberdana.html);
        $("#sumberDana > tr:last").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
        renameInputSumberDana();
        hitungTotalSumberDana();
    }
    
    function hapusSumberDana(obj) {
        $(obj).parents("tr").remove();
        renameInputSumberDana();
        hitungTotalSumberDana();
    }
    
    function renameInputSumberDana() {
        var cnt = 0;
        $("#sumberDana tr").each(function() {
            $(this).find(".row_num").html(cnt+1);
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+cnt+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+cnt+"]["+old_name_arr[2]+"]");
                }
            });

            cnt++;
        });
    }
    
    function hitungTotalSumberDana(){
        var total = 0;
        $("#sumberDana tr").each(function() { 
            pagu = unformatNumber($(this).find('input[name$="[pagu]"]').val());
            total = total+pagu;
        });
        $("#totalDana").val(formatInteger(total));
    }
    /*=== Sumber dana ===*/
    
    /*=== Jenis Pengadaan ===*/
    var row_jenispengadaan = <?php echo CJSON::encode(array('html' => $this->renderPartial("detail/_rowJenisPengadaan", array('modJenis'=>$modJenis,'form'=>$form, 'i'=>$i++), true))); ?>;
    function tambahJenisPengadaan(){
        $("#jenisPengadaan").append(row_jenispengadaan.html);
        $("#jenisPengadaan > tr:last").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
        renameInputJenisPengadaan();
        hitungTotalJenisPengadaan();
    }
    
    function hapusJenisPengadaan(obj) {
        $(obj).parents("tr").remove();
        renameInputJenisPengadaan();
        hitungTotalJenisPengadaan();
    }
    
    function renameInputJenisPengadaan() {
        var cnt = 0;
        $("#jenisPengadaan tr").each(function() {
            $(this).find(".row_num").html(cnt+1);
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+cnt+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+cnt+"]["+old_name_arr[2]+"]");
                }
            });

            cnt++;
        });
    }
    
    function hitungTotalJenisPengadaan(){
        var total = 0;
        $("#jenisPengadaan tr").each(function() { 
            pagu = unformatNumber($(this).find('input[name$="[jumlahpagu]"]').val());
            total = total+pagu;
        });
        $("#totalJenisPengadaan").val(formatInteger(total));
    }
    /*=== Jenis Pengadaan ===*/
    
    function setJenisRUP(obj){
        isi = $(obj).val();
        if(isi=="Penyedia"){
            $('.swakelola').find("input,select,textarea").attr("disabled",true);
            $('.penyedia').find("input,select,textarea").removeAttr("disabled");
            $('.swakelola').hide();
            $('.penyedia').show();
        }else{
            $('.swakelola').find("input,select,textarea").removeAttr("disabled");
            $('.penyedia').find("input,select,textarea").attr("disabled",true);
            $('.penyedia').hide();
            $('.swakelola').show();
        }
    }
    
    function cekDipaDpa(obj){
        if($(obj).is(":checked")){
            $("#ADRencanaumumpengadaanT_nomor_kppuas").removeAttr("disabled");
            $('.kppuas').show();
        }else{
            $("#ADRencanaumumpengadaanT_nomor_kppuas").attr("disabled",true);
            $('.kppuas').hide();
        }
    }
    
    function cekSimpanRUP(){
        totalDana = unformatNumber($("#totalDana").val());
        totalJenisPengadaan = unformatNumber($("#totalJenisPengadaan").val());
        kategori = $("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").val();
        
        if(kategori == "Penyedia"){
            if(totalJenisPengadaan != totalDana){
                myAlert("Total Pagu Jenis Pengadaan tidak boleh beda dari Total Pagu Sumber Dana");
            }else{
                $("#rup-t-form").submit();
            }
        }else{
            $("#rup-t-form").submit();
        }
    }
    
    $( document ).ready(function(){
        setJenisRUP($("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori"));
        <?php if(isset($_GET['sukses'])){ ?>
            hitungTotalSumberDana();
            hitungTotalJenisPengadaan();
            $("input,select,textarea").attr("disabled",true);
            $('.add-on').hide();
        <?php } ?>
    });
    
</script>