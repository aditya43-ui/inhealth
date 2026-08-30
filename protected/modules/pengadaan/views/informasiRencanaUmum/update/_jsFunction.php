<?php 
    $i =0; 
    $rencana_id = $_GET['id'];
?>
<script>
    function cekMetode(obj){
       var value = $(obj).attr('value');
       
       if ($(obj).prop("checked") == true){
           if (value == '1'){
               $("#ADRencanaumumpengadaanT_metodepengadaan_id").parents(".control-group").hide();
               $("#ADRencanaumumpengadaanT_metodepengadaan_id").removeClass('required');
           }else{
               $("#ADRencanaumumpengadaanT_metodepengadaan_id").parents(".control-group").show();
               $("#ADRencanaumumpengadaanT_metodepengadaan_id").addClass('required');
           }
       }
   }
    function ubahMindate_pemanfaatanbarang(){
        var minDate = $("#ADRencanaumumpengadaanT_pemanfaatanbarang_tglawal").val();
        if(minDate != ""){
            $('#ADRencanaumumpengadaanT_pemanfaatanbarang_tglakhir').datepicker('option','minDate', minDate);       
        }
    }
    
    function ubahMindate_pelaksanaankontrak(){
        var minDate = $("#ADRencanaumumpengadaanT_pelaksanaankontrak_tglawal").val();
        if(minDate != ""){
            $('#ADRencanaumumpengadaanT_pelaksanaankontrak_tglakhir').datepicker('option','minDate', minDate);       
        }
    }
    
    function ubahMindate_pemilihanpenyedia(){
        var minDate = $("#ADRencanaumumpengadaanT_pemilihanpenyedia_tglawal").val();
        if(minDate != ""){
            $('#ADRencanaumumpengadaanT_pemilihanpenyedia_tglakhir').datepicker('option','minDate', minDate);       
        }
    }
    
    var set_ceklist_barang = {};
    
    function cekListBarang(){
        $("#barangjasa-m-grid > table > tbody > tr").find('.pilih').each(function(){                        
            if (typeof $("#tabelRAB").find('.dokumenpelaksanaananggarandet_id[value="'+$(this).attr('id-data')+'"]').val() !== 'undefined'){
                $(this).prop("checked", true);
                $(this).prop("disabled", true);
            }
        });
    }
    
    function setSemuaBarang(obj){
        if ($(obj).prop("checked") == true){            
            $(obj).parents("#barangjasa-m-grid").find('table > tbody > tr').find('.pilih').each(function(){                
               if (typeof $(this).attr("disabled") === 'undefined'){
                   $(this).prop("checked", true);
                   setBarangCek($(this));
               }
            });
        }else{
            $(obj).parents("#barangjasa-m-grid").find('table > tbody > tr').find('.pilih').each(function(){
               if (typeof $(this).attr("disabled") === 'undefined'){
                   $(this).prop("checked", false);
               }
            });
        }
        
    }
    
    function setBarangCek(obj){        
        var det_id = $(obj).attr('id-data');
        
        if ($(obj).prop("checked") == true){
            set_ceklist_barang[det_id] = det_id;
        }else{
            delete set_ceklist_barang[det_id];
        }
    }
    
    function loadBarangJasaByDetId(){       
        var row = $('#noRow').val();
        var jenis_trans = $('#jenis_trans').val();
                 
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setDokumenDet'); ?>',
            data: {
                dokumenpelaksanaananggarandet_id: set_ceklist_barang,
                jenis_trans:jenis_trans
            },
            dataType: "json",
            success: function (data) {
                if (data.html != ''){
                    
                    $("#tabelRAB > tbody").find('tr[rowdata="'+row+'"]').detach();
                    $("#tabelRAB > tbody").append(data.html);                    
                    
                    set_ceklist_barang = {};
                    
                    $("#tabelRAB").find('input[class*="integer-decimal"]').unmaskMoney();
                    $("#tabelRAB").find('input[class*="integer-decimal"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
                    );  
                    
                    $("#tabelRAB").find('input[class*="float2"]').unmaskMoney();
                    $("#tabelRAB").find('input[class*="float2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
                    ); 
            
                    renameInputRow($("#tabelRAB"));                    

                    generateExt();

                    hitungTotalSeluruhnya();
                }
                $("#dialogBarangJasa").dialog('close');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
       
    function cekPaket(){
        var adapaket = $("#adapaket").prop("checked");
        var nonpaket = $("#nonpaket").prop("checked");
                        
        if (adapaket == true){
            $("#form-pilih-paket").show();
            
            $('#RAB').attr('style','display:none');
            $("#jenis_trans").val('paket');
        }else{
            $("#form-pilih-paket").hide();
            $("#adapaket").attr('checked',false);
            $("#nonpaket").attr('checked',true);
            
            $("#jenis_trans").val('nonpaket');
            var i = 1;
            $("#tabel-paket-rup > tbody > tr").each(function(){
                if (i == 1){
                    $(this).find('input,select,textarea').val('');
                }else{
                    $(this).detach();
                }
                i++;
            });
            
            $('#RAB').attr('style','display:none');
            
        }
    }
    
    /*=== Lokasi Pekerjaan ===*/
    var row_lokasiPekerjaan = <?php echo CJSON::encode(array('html' => $this->renderPartial($this->path_view_ubah."_rowLokasiPekerjaan", array('modLokasi'=>$lokasi,'form'=>$form, 'i'=>$i++), true))); ?>;
    function tambahLokasiPekerjaan(obj) {
        $("#lokasiPekerjaan").append(row_lokasiPekerjaan.html);
        renameInputLokasiPekerjaan();
    }
    
    function hapusLokasiPekerjaan(obj) {
        
        var id = $(obj).parents("tr").find('.pengadaanlokasi_id').val();
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!",function(r){
            if (r){
                if (id != ''){
                    $("#tabelHapusPekerjaan > tbody").append("<tr><td><input type = 'hidden' value='"+id+"' name='delete[lokasi][]'></td></tr>");
                }
                $(obj).parents("tr").remove();
                renameInputLokasiPekerjaan();
            }            
        });
        
        
        
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
    
    function loadLokasiPekerjaan(){
        var rencana_id = '<?php echo $_GET['id']?>';
        $("#tabelPekerjaan").addClass("animation-loading");
        $('#tabelPekerjaan > tbody').html("");
        $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('GetLokasi'); ?>',
                data: {
                    rencana_id: rencana_id, 
                    is_update: 1
                },
                dataType: "json",
                success:function(data){
                        $('#tabelPekerjaan > tbody').append(data.form);
                        jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                        renameInputLokasiPekerjaan($("#tabelPekerjaan"));

                        $("#tabelPekerjaan").removeClass("animation-loading");
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    /*=== Lokasi Pekerjaan ===*/
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
    
    /*=== Sumber dana ===*/
    var row_sumberdana = <?php echo CJSON::encode(array('html' => $this->renderPartial($this->path_view_ubah."_rowSumberDana", array('modSumberDana'=>$modDana,'form'=>$form, 'i'=>$i++), true))); ?>;
    
    function tambahSumberDana(){
        $("#sumberDana").append(row_sumberdana.html);
        $("#sumberDana > tr:last").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
        
        generateExtSumberDana();
        
        renameInputSumberDana();
        hitungTotalSumberDana();
        $("#tabel-sumberdana").find('input[class*="integer-decimal"]').unmaskMoney();
        $("#tabel-sumberdana").find('input[class*="integer-decimal"]').maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
        ); 

    }
    
    function generateExtSumberDana(){
        jQuery("#tabel-sumberdana").find('.mak_nama').autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function(event, ui )
                {
                    $(this).val( ui.item.label);
                },
                'select':function( event, ui )
                {
                    $(this).parents("tr").find('[class*="mak_id"]').val(ui.item.value);

                    $(this).val(ui.item.label);
                    return false;
                },
                'source':function(request, response)
                {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompleteRekening'); ?>",
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
    
    function hapusSumberDana(obj) {
        var id = $(obj).parents("tr").find('.pengadaansumberdana_id').val();
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!",function(r){
            if (r){
                if (id != ''){
                    $("#tabel-hapussumberdana > tbody").append("<tr><td><input type = 'hidden' value='"+id+"' name='delete[sumberdana][]'></td></tr>");                    
                }
                $(obj).parents("tr").remove();
                renameInputSumberDana();
                hitungTotalSumberDana();
                $("#tabel-sumberdana").find('input[class*="integer-decimal"]').unmaskMoney();
                $("#tabel-sumberdana").find('input[class*="integer-decimal"]').maskMoney(
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
                ); 

            }            
        });                        
    }
    
    function renameInputSumberDana() {
        var cnt = 0;
        $("#sumberDana tr").each(function () {
            $(this).find(".row_num").html(cnt + 1);
            $(this).find("#no_urut").val(cnt + 1);
            $(this).attr("data-row", cnt);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + cnt + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + cnt + "][" + old_name_arr[2] + "]");
                }
            });

            cnt++;
        });
    }
    
    function hitungTotalSumberDana(){
        var total = 0;
        unformatNumberSemua();
        $("#sumberDana > tr").each(function () {
            var pagu = $(this).find('input[name$="[pagu]"]').val();
            $(this).find('input[name$="[pagu]"]').val(parseFloat(pagu));
            total = total + parseFloat(pagu);
        });
        $("#totalDana").val(parseFloat(total));
        formatNumberSemua();
    }
    <?php 
        $rab = new RencanaumumpengadaandetT;
        $rab->rencanaumumpengadaandet_pajak = 10;
    ?>
    function tambahRAB(){
        var row_rab = <?php echo CJSON::encode($this->renderPartial("update/_rowRABHPS", array('model' => new RencanaumumpengadaandetT,), true)); ?>;
        $("#tabelRAB > tbody").append(row_rab);
        $("#tabelRAB > tbody > tr:last").find('input[class*="integer-decimal"]').maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
        );  
        $("#tabelRAB > tbody > tr:last").find('input[class*="float2"]').maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
        ); 
        renameInputRow($("#tabelRAB"));
        
        generateExt();
        
        hitungTotalSeluruhnya();
    }
    
    function hapusRAB(obj){
        /*var id = $(obj).parents("tr").find("input[name$='[rencanaumumpengadaandet_id]']").val();
        if(id !== ""){
                myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
                function(r){
                        if(r){
                            $.ajax({
                                    type:'POST',
                                    url:'<?php echo $this->createUrl('Delete'); ?>&id='+id,
                                    data: {id : id},//
                                    dataType: "json",
                                    success:function(data){
                                            if(data.sukses == 1){
                                                    $(obj).parents('tr').detach();
                                                    renameInputRow($("#tabelRAB"));
                                            }
                                            myAlert(data.pesan);
                                            var rowCount = $("#tabelRAB").find('tbody tr').length;
 
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                            });
                        }
                });
        } else {
                $(obj).parents('tr').detach();
                renameInputRow($("#tblDokumen"));
        }*/
        var id = $(obj).parents("tr").find('.rencanaumumpengadaandet_id').val();
        myConfirm("Apakah anda yakin akan menghapus data ini?", "Perhatian!",
            function (r) {
                if (r) {
                    
                    if (id != ''){
                        $("#tabelHapusRAB > tbody").append("<tr><td><input type = 'hidden' value='"+id+"' name='delete[rab][]'></td></tr>");
                    }
                    $(obj).parents("tr").remove();
                    hitungTotalSeluruhnya();
                    renameInputRow($("#tabelRAB"));
                }
            });
    }
    
    function loadSumberDana(){
        var rencana_id = '<?php echo $_GET['id']?>';
        $("#tabel-sumberdana").addClass("animation-loading");
        $('#tabel-sumberdana > tbody').html("");
        $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('GetSumberDana'); ?>',
                data: {
                    rencana_id: rencana_id, 
                    is_update: 1
                },//
                dataType: "json",
                success:function(data){
                        $('#tabel-sumberdana > tbody').append(data.form);
                        jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                        renameInputSumberDana($("#tabel-sumberdana"));
                
                        $("#tabel-sumberdana").removeClass("animation-loading");
                        hitungTotalSumberDana();
                        generateExtSumberDana();
                        $("#tabel-sumberdana").find('input[class*="integer-decimal"]').unmaskMoney();
                        $("#tabel-sumberdana").find('input[class*="integer-decimal"]').maskMoney(
                            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
                        ); 
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    /*=== Sumber dana ===*/
    
    /*=== Jenis Pengadaan ===*/
    var row_jenispengadaan = <?php echo CJSON::encode(array('html' => $this->renderPartial($this->path_view_ubah."_rowJenisPengadaan", array('jenis' => $jenis, 'modJenis'=>$modJenis,'form'=>$form, 'i'=>$i++), true))); ?>;
    function tambahJenisPengadaan(){
        $("#jenisPengadaan").append(row_jenispengadaan.html);
        $("#jenisPengadaan > tr:last").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
        renameInputJenisPengadaan();
        hitungTotalJenisPengadaan();
        $("#tabelJenis").find('input[class*="integer-decimal"]').unmaskMoney();
        $("#tabelJenis").find('input[class*="integer-decimal"]').maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
        ); 
    }
    
    function hapusJenisPengadaan(obj) {
        var id = $(obj).parents("tr").find('.pengadaanjenis_id').val();
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!",function(r){
            if (r){
                if (id != ''){
                    $("#form-hapusjenispengadaan > tbody").append("<tr><td><input type = 'hidden' value='"+id+"' name='delete[jenis][]'></td></tr>");
                }                
                $(obj).parents("tr").remove();    
                renameInputJenisPengadaan();
                hitungTotalJenisPengadaan();
                $("#tabelJenis").find('input[class*="integer-decimal"]').unmaskMoney();
                $("#tabelJenis").find('input[class*="integer-decimal"]').maskMoney(
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
                ); 
            }
        });
                    
        $('#form-dokpendukung > tbody > tr').each(function(){                            
            if (typeof $('#jenisPengadaan > tr').find('option:selected[value='+$(this).attr('row-pengadaan')+']').val() == 'undefined'){
                $(this).detach();
            }
        });
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
        unformatNumberSemua();
        $("#jenisPengadaan tr").each(function() { 
            var pagu = $(this).find('input[name$="[jumlahpagu]"]').val();
            $(this).find('input[name$="[jumlahpagu]"]').val(parseFloat(pagu));
            total = total+parseFloat(pagu);
        });
        $("#totalJenisPengadaan").val(parseFloat(total));
        formatNumberSemua();
        
    }
    
    function loadJenis(){
        var rencana_id = '<?php echo $_GET['id']?>';
        $("#tabelJenis").addClass("animation-loading");
        $('#tabelJenis > tbody').html("");
        $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('GetJenis'); ?>',
                data: {
                    rencana_id: rencana_id, 
                    is_update: 1
                },
                dataType: "json",
                success:function(data){
                        $('#tabelJenis > tbody').append(data.form);
                        jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                        renameInputJenisPengadaan($("#tabelJenis"));

                        $("#tabelJenis").removeClass("animation-loading");
                        hitungTotalJenisPengadaan();
                        $("#tabelJenis").find('input[class*="integer-decimal"]').unmaskMoney();
                        $("#tabelJenis").find('input[class*="integer-decimal"]').maskMoney(
                            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
                        ); 
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    /*=== Jenis Pengadaan ===*/
    
    function setJenisRUP(obj) {
        isi = $(obj).val();
        if (isi == "Penyedia") {
            if ($("#ADRencanaumumpengadaanT_isdikecualikan_0").prop("checked") === '0'){
                $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").addClass('required');
                $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").parents(".control-group").find('.control-label').append(" <span class='required'>*</span>");
            }
            $('.swakelola').find("input,select,textarea").attr("disabled", true);
            $('.penyedia').find("input,select,textarea").removeAttr("disabled");
            $('.swakelola').hide();
            $('.penyedia').show();
        } else {
            $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").removeClass('required');
            $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").parents(".control-group").find('.control-label').find("span").remove();
            $('.swakelola').find("input,select,textarea").removeAttr("disabled");
            $('.penyedia').find("input,select,textarea").attr("disabled", true);
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
        
    function setDokumen(obj, update){
        var jenispengadaan = $('#tabelJenis > tbody > tr ').find('.jenispengadaan').val();
        var jenispengadaan_nama = $('#tabelJenis > tbody > tr ').find(':selected').text();
        var metodepengadaan_id = $('#ADRencanaumumpengadaanT_metodepengadaan_id').val();
        var count = 0;
                
        $("#jenisPengadaan > tr").each(function(){
            if ( jenispengadaan == $(this).find('.jenispengadaan').val() ){
                count++;
            }            
        });
        
        if (count > 1){
            toastr.error("Jenis Pengadaan <b>"+jenispengadaan_nama+"</b> sudah dipilih!","Perhatian!");
            $(obj).val('');
            return false;
        }
        
        $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadDokumen'); ?>',
                data: {
                    jenispengadaan_id: jenispengadaan,
                    rencanaumumpengadaan_id:<?php echo $model->rencanaumumpengadaan_id; ?>,
                    is_update: update,
                    metodepengadaan_id: metodepengadaan_id,
                },//
                dataType: "json",
                success:function(data){   
                        $('#form-dokpendukung > tbody > tr').each(function(){                            
                            if (typeof $('#jenisPengadaan > tr').find('option:selected[value='+$(this).attr('row-pengadaan')+']').val() == 'undefined'){
                                $(this).detach();
                            }
                        });                   
                        
                        $('#form-dokpendukung > tbody').html(data.dokDukung);    
                        jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                        renameInputRow($("#form-dokpendukung"));

                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
        
    function setDokumenLoad(){
        
//        var jenispengadaan = $('#tabelJenis').find('select[name$="[jenispengadaan_id]"]').val();
//        var jenispengadaan = [];
//        $("#jenisPengadaan").each(function() {
//            jenispengadaan.push($(this).find('#jenis_pengadaan').val());
//        });
        var id = <?php echo $model->rencanaumumpengadaan_id; ?>; 
        $('#form-dokpendukung > tbody').html("");
        $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadDokumen'); ?>',
                data: {
                    rencanaumumpengadaan_id: id,
                    is_update: 'ya',
                    tipe:'load'
                },//
                dataType: "json",
                success:function(data){
                        $('#form-dokpendukung > tbody').html(data.dokDukung);
                        jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
//                        renameInputRow($("#form-dokpendukung")); // tidak usah di-rename supaya nama barisnya sesuai dengan dokumenpengadaan_id 

                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
        function renameInputRow(obj_table){
        var row = 0;
        var count = $(obj_table).find("tbody > tr").length;
        
        $(obj_table).find("tbody > tr").each(function(){            
                $(this).attr('rowdata',row);
                $(this).find('.no-urut').html(row+1);
                $(this).find('span').each(function(){ //element <input>
                    if (typeof $(this).attr("name") != 'undefined'){
                        var old_name = $(this).attr("name").replace(/]/g,"");
                        var old_name_arr = old_name.split("[");
                        if(old_name_arr.length == 3){
                                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                        }
                    }
                });
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

                if (count == 1){
                    $(this).find('.btntambah').removeClass('hide');
                    $(this).find('.btnhapus').addClass('hide');
                }else{       
                    if (count == (row+1)){
                        $(this).find('.btntambah').removeClass('hide');
                        $(this).find('.btnhapus').removeClass('hide');
                    }else{
                        $(this).find('.btnhapus').removeClass('hide');
                        $(this).find('.btntambah').addClass('hide');                        
                    }
                }

                row++;
        });               
       
       jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    function cekFile(obj){       
        
        var cek = $(obj).val();       
        if (cek != ''){
            var type = $(obj).get(0).files[0]['type'];
            var tipeFile = type.split('/');                    
            var ext = '.'+$(obj).val().split('.').pop().toLowerCase();           
            var fileExt = $(obj).attr('accept').split(',');        
                                                
            if($.inArray(ext, fileExt) == -1 && $.inArray(tipeFile[0]+'/*', fileExt) == -1) {
                toastr.error('Tipe file yang diupload tidak diizinkan !',"Perhatian!");
                $(obj).val(""); 
                $(".fileinput-exists").trigger('click');
                return false;
            }

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 10) {
                toastr.error("Ukuran file tidak boleh lebih dari 200kb/2mb","perhatian !");
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
    
    function cekSimpanRUP(jenis) {
        var totalDana = parseFloat(unformatNumber($("#totalDana").val()));
        var totalJenisPengadaan = parseFloat(unformatNumber($("#totalJenisPengadaan").val()));
        var kategori = $("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").val();
        var totalPagu = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model, 'dpa_pagu') ?>").val()));
        var totalRAB = parseFloat(unformatNumber($("#total_hargaseluruhnya").val()));
        var status = $("#<?php echo CHtml::activeId($model, 'statusnya') ?>").val();
        var countReq = 0;
        $("#form-dokpendukung > tbody > tr").each(function(){                        
            if ($(this).find('.dokfile').hasClass('required')){
                if ($(this).find('.dataada').html() == null ){
                    $(this).find('.label_dok').attr('style','');
                    if ($(this).find('.dokfile').val() == ''){
                        $(this).find('td').attr('style', 'background: #ffcece !important');
                        $(this).find('.label_dok').attr('style','color:red;');
                        countReq++;
                    } else {
                        $(this).find('td').attr('style', 'background: white !important');
                    }
                }
            }           
        });
                
        if (countReq > 0){
            toastr.error("Ada Dokumen Pendukung yang belum diupload","Perhatian!");
            return false;
        }
                
        if (jenis == 'ubah'){
            $("#ADRencanaumumpengadaanT_statusnya").val('Draft');
        }else if (jenis == 'ajukan'){
            $("#ADRencanaumumpengadaanT_statusnya").val('Pengajuan');
        }else if (jenis == 'revisi'){
            $("#ADRencanaumumpengadaanT_statusnya").val('Revisi TPP-RUP');
        }else if(jenis == 'revisi_ppk'){
            $("#ADRencanaumumpengadaanT_statusnya").val('Revisi PPK');
        }
        
        if (requiredCheck($("#rup-t-form"))) {
            var total = 0;
            var ok = 0;
                $("#tabelRAB > tbody > tr").each(function () {
                var jumlah_harga = parseFloat($(this).find('.harga').val());
                var sisa_pagu = parseFloat($(this).find('.sisapagu_pengadaan').val());
                var status = parseFloat($(this).find('.status').val());

                if (jumlah_harga > sisa_pagu) {
                    $(this).find('td').attr('style', 'background: #ffcece !important');
                    ok = 1;
                } else {
                    $(this).find('td').attr('style', 'background: white !important');
                    ok = 0;
                }
                total += ok;
            });
            
            if (total > 0) {
                toastr.error("Jumlah item yang ditagihkan melebihi Sisa Pagu", "Perhatian!");
            }

            if (total === 0) {
                $("#rup-t-form").submit();
                disableOnSubmit($(".form-actions"), 'no_unformat');
            }
            
            formatNumberSemua();
        }
        return false;
    }
 
    /**
     * Show RAB
     * @returns {undefined}
     */
    function showRAB() {
        var x = document.getElementById("RAB");
        var a = document.getElementById("ADRencanaumumpengadaanT_subkegiatanprogram_id");
        if (a.value != null) {
            if (x.style.display === "none") {
                x.style.display = "block";
            }
        }
    }
    
    /**
     * Generate tabel RAB
     * @returns {undefined}
     */
    function showTabelRAB() {
        var unitkerjanya = $("#unitkerjanya").val();
        var periodeanggaran_id = $("#ADRencanaumumpengadaanT_periodeanggaran_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('generateTableRAB'); ?>',
            data: {unitkerjanya: unitkerjanya, periodeanggaran_id: periodeanggaran_id},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    $("#tabelRAB").html(data.html);
                    $("#totalnya").html(data.valtotal);
                    hitungTotalSeluruhnya();
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    /**
     * Digunakan sebagai autocomplete data pegawai
     * @param {type} data
     * @returns {undefined}
     */
    function setData(data) {
        $("#rup-t-form #ADRencanaumumpengadaanT_subprogram_id").val(data.subprogramkerja_id);
        $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_id").val(data.value);
        $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_nama").val(data.label);
        $("#rup-t-form #ADRencanaumumpengadaanT_nama_pekerjaan").val(data.label);
        $("#rup-t-form #program").val(data.programkerja_nama);
        $("#rup-t-form #kegiatan").val(data.subprogramkerja_nama);
    }
    
    function setDialog(obj) {
        var no = $(obj).parents("tr").data('row');
        var subprogramkerja_id = $("#<?php echo CHtml::activeId($model, 'subprogram_id') ?>").val();
        var count = 0;
        var subkegiatanprogram_id = '';
        var paketpekerjaan_id = '';
        
        $("#tabel-subkegiatan-list > tbody > tr").find('.subkegiatanprogram_id').each(function(index){
            if ($(this).val() != ''){
                subkegiatanprogram_id += $(this).val()+',';
                count++;
            }
        });
        
        $("#tabel-paket-rup > tbody > tr").find('.paketpekerjaan_id').each(function(index){
            if ($(this).val() != ''){
                paketpekerjaan_id += $(this).val()+',';
                count++;
            }
        });

        $("#no_row").val(parseInt(no));
        
        var def = 'ada';
        if (count > 0){
            def = '';
        }
        
        $("#mak-m-grid .default").val(def);
        $("#mak-m-grid .subkegiatanprogram_id").val(subkegiatanprogram_id);
        $("#mak-m-grid .paketpekerjaan_id").val(paketpekerjaan_id);
        
        $.fn.yiiGridView.update('mak-m-grid', {
            data: {                                
                "ADDokumenpelaksanaananggarandetT[default]":def,
                "ADDokumenpelaksanaananggarandetT[subkegiatanprogram_id]":subkegiatanprogram_id,
                "ADDokumenpelaksanaananggarandetT[paketpekerjaan_id]":paketpekerjaan_id,
            }
        }); 
        
        $("#dialogMAK").dialog("open");
    }
    
    function setPengadaan(data, obj) {
        
        var cek = 0;
        
        $("#tabel-sumberdana > tbody > tr").find('.mappingrekeninganggaran_id').each(function(){
            var komponen_kegiatan = $(this).parents("tr").find('.komponen_kegiatan').val()
            if ($(this).val() != ''){
                if ( (data.mappingrekeninganggaran_id == $(this).val()) && (data.subprogramkerja_nama == komponen_kegiatan) ){
                    cek++;
                }
            }
        });
        
        if (cek > 0){
            toastr.warning("Rekening dengan kegiatan ini sudah dipilih","Perhatian!");
            return false;
        }
        
        if (typeof $(obj).parents("tr").attr('data-row') !== 'undefined'){
            var row = $(obj).parents("tr").attr('data-row');
        }else{
            var row = $("#no_row").val();
        }
        
        
        
        $("#tabel-sumberdana > tbody > tr[data-row='"+row+"']").find('.rekeninganggaran5_id').val(data.rekeninganggaran5_id);
        $("#tabel-sumberdana > tbody > tr[data-row='"+row+"'] ").find('.mappingrekeninganggaran_id').val(data.mappingrekeninganggaran_id);                
        $("#tabel-sumberdana > tbody > tr[data-row='"+row+"'] ").find('.mak_nama').val(data.namarekening);
        $("#tabel-sumberdana > tbody > tr[data-row='"+row+"'] ").find('.kegiatanprogram_id').val(data.kegiatanprogram_id);
        $("#tabel-sumberdana > tbody > tr[data-row='"+row+"'] ").find('.komponen_kegiatan').val(data.subprogramkerja_nama);
                
        

        $("#dialogMAK").dialog("close");
    }
    
    function generateExt(){
        $('.numbers-only').keyup(function() {
            setNumbersOnly(this);
        });
        
        $("#tabelRAB").find('.rencanaumumpengadaandet_nama').autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function(event, ui )
                {
                    $(this).val( ui.item.label);
                    return false;
                },
                'select':function( event, ui )
                {
                    setBarangJasa(ui.item,this);
                    return false;
                },
                'source':function(request, response)
                {
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('autocomplate/BarangJasa');?>",
                        dataType: "json",
                        data:{
                            term: request.term,                                
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                }
            }
        );
    }
    
    function setRow(obj){
        var no = $(obj).parents("tr").attr('rowdata');        
        $("#noRow").val(no);                
    }
    
    function setBarangJasa(data,obj){
        
        var cek = 0;
        $("#tabelRAB > tbody > tr").each(function(){
            if ($(this).find('.dokumenpelaksanaananggarandet_id').val() == data.dokumenpelaksanaananggarandet_id){
                cek++;
            }
        });
        
        if (cek > 0){
            toastr.error("Barang dan Jasa sudah dipilih","Perhatian!");
            return false;
        }
        
        if (typeof obj === 'undefined'){
            var row = $('#noRow').val();
        }else{
            var row = $(obj).parents("tr").attr('data-row');
        }                        
        
        $("#tabelRAB > tbody > tr[data-row='"+row+"']").find('.barang_id').val(data.barang_id);
        $("#tabelRAB > tbody > tr[data-row='"+row+"']").find('.jenis_barang').val(data.jenis_barang);
        $("#tabelRAB > tbody > tr[data-row='"+row+"']").find('.dokumenpelaksanaananggarandet_id').val(data.dokumenpelaksanaananggarandet_id);
        $("#tabelRAB > tbody > tr[data-row='"+row+"']").find('.rencanaumumpengadaandet_nama').val(data.uraian);
        $("#tabelRAB > tbody > tr[data-row='"+row+"']").find('.rencanaumumpengadaandet_satuan').val(data.satuan);
        $("#tabelRAB > tbody > tr[data-row='"+row+"']").find('.rencanaumumpengadaandet_harga').val(data.harga_satuan);
        $("#tabelRAB > tbody > tr[data-row='"+row+"']").find('.hargaawal').val(data.harga_satuan);
        $("#tabelRAB > tbody > tr[data-row='"+row+"']").find('.rencanaumumpengadaandet_volume').val(data.volume);
        $("#tabelRAB > tbody > tr[data-row='"+row+"']").find('.volumeawal').val(data.volume);
                                
        hitungTotalSeluruhnya();
        
        $("#<?php echo CHtml::activeId($model, 'pegawaipa_nama') ?>").blur();
    }
    
    function refreshBarangJasa(){
        var instalasi_id = $("#<?php echo CHtml::activeId($model, 'instalasi_id') ?>").val();
        var unitkerja_id = $("#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>").val();
        var periodeanggaran_id = $("#<?php echo CHtml::activeId($model, 'periodeanggaran_id') ?>").val();
        //var subkegiatanprogram_id = $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_id') ?>").val();
        
        var subkegiatanprogram_id = '';
        
        var i = 0;
        $("#tabel-subkegiatan-list > tbody > tr").find('.subkegiatanprogram_id').each(function(index){            
            subkegiatanprogram_id += $(this).val()+',';                            
            i++;
        })
        
        var jenis_trans = $("#jenis_trans").val();
        var paket_id = '';
        var mappingrekeninganggaran_id = '';                
        
        if (jenis_trans == 'paket'){       
            var i = 0;
            $("#tabel-paket-rup > tbody > tr").find('.paketpekerjaan_id').each(function(index){                                                                
                paket_id += $(this).val()+',';                                  
                i++;
            });                      
            //mappingrekeninganggaran_id = $("#mappingrekeninganggaran_id").val();
            //$(".paketpekerjaan_id").val(paket_id);
            //$(".barang_mappingrekeninganggaran_id").val(mappingrekeninganggaran_id);
        }else{
            paket_id = '';            
           // $(".paketpekerjaan_id").val('');
           // $(".barang_mappingrekeninganggaran_id").val('');
        }
        
        $(".barang_instalasi_id").val(instalasi_id);
        $(".barang_periodeanggaran_id").val(periodeanggaran_id);        
        $(".barang_unitkerja_id").val(unitkerja_id);
        $(".barang_subkegiatanprogram_id").val(subkegiatanprogram_id);        
        $(".barang_paketpekerjaan_id").val(paket_id); 
        
        $.fn.yiiGridView.update('barangjasa-m-grid', {
            data: {
                "DokumenpelaksanaananggarandetT[instalasi_id]":instalasi_id,
                "DokumenpelaksanaananggarandetT[periodeanggaran_id]":periodeanggaran_id,
                "DokumenpelaksanaananggarandetT[subkegiatanprogram_id]":subkegiatanprogram_id,                
                "DokumenpelaksanaananggarandetT[unitkerja_id]":unitkerja_id,                
                "DokumenpelaksanaananggarandetT[paketpekerjaan_id]":paket_id,                  
            }
        });     
    }
    
    function setPaguDPA(){
        
        var id = new Array();
        
        var i = 0;
        var a = 0;
        var load = 'dpadet';
        $("#tabelRAB > tbody > tr").each(function(){           
            if ($(this).find('.dokumenpelaksanaananggarandet_id').val() != ''){                                
                id[i] = $(this).find('.dokumenpelaksanaananggarandet_id').val();
                i++;               
            }            
            if ($(this).find('.rencanaumumpengadaandet_id').val() != ''){                                
                a++;
            }                        
        });
        
        if ( $("#tabelRAB > tbody > tr").length == a){            
            load = 'rup';
        }
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/actionAjax/loadDPAdariPagu'); ?>',
            data: {
                dokumenpelaksanaananggarandet_id:id,
                st:'ubah',
                load:load,
                rencanaumumpengadaan_id: '<?php echo $model->rencanaumumpengadaan_id; ?>'
            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {                    
                    $("#<?php echo CHtml::activeId($model, 'dpa_pagu') ?>").val(data.total);
                    $("#<?php echo CHtml::activeId($model, 'dpa_pagu_temp') ?>").val(data.total);
                } else {
                    toastr.error(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function refreshPejabatPA(){   
        $("#jenis_jabatan").html('<?php echo Params::JABATAN_PENGADAAN_PA; ?>');
        $("#jenisJabatan").val('<?php echo Params::JABATAN_PENGADAAN_PA; ?>');
        $.fn.yiiGridView.update('pejabatpa-m-grid', {
            data: {                                
                "PejabatpengadaanM[default]":'',
                "PejabatpengadaanM[jabatan_pengadaan]":'<?php echo Params::JABATAN_PENGADAAN_PA; ?>',
            }
        }); 
    }
    
     function refreshPejabatPPK(){       
        $("#jenis_jabatan").html('<?php echo Params::JABATAN_PENGADAAN_PPK; ?>');
        $("#jenisJabatan").val('<?php echo Params::JABATAN_PENGADAAN_PPK; ?>');
        let periodeanggaran_id = $("#<?= CHtml::activeId($model, 'periodeanggaran_id') ?>").val()
        var def = '';
        if (periodeanggaran_id == ''){
            def = 'kosong';
        }
        
        $.fn.yiiGridView.update('pejabatpa-m-grid', {
            data: {                                
                "PejabatpengadaanM[default]":def,
                "PejabatpengadaanM[periodeanggaran_id]":periodeanggaran_id,
                "PejabatpengadaanM[jabatan_pengadaan]":'<?php echo Params::JABATAN_PENGADAAN_PPK; ?>',
            }
        }); 
    }
    
    function refreshPejabatKPA(){       
        $("#jenis_jabatan").html('<?php echo Params::JABATAN_PENGADAAN_KPA; ?>');
        $("#jenisJabatan").val('<?php echo Params::JABATAN_PENGADAAN_KPA; ?>');
        let periodeanggaran_id = $("#<?= CHtml::activeId($model, 'periodeanggaran_id') ?>").val()
        var def = '';
        if (periodeanggaran_id == ''){
            def = 'kosong';
        }
        
        $.fn.yiiGridView.update('pejabatpa-m-grid', {
            data: {                                
                "PejabatpengadaanM[default]":def,
                "PejabatpengadaanM[periodeanggaran_id]":periodeanggaran_id,
                "PejabatpengadaanM[jabatan_pengadaan]":'<?php echo Params::JABATAN_PENGADAAN_KPA; ?>',
            }
        }); 
    }
    
    function setPejabatPengadaan(data,jenis){
        if (typeof jenis === 'undefined'){
           var jenis = $("#jenisJabatan").val();
        }else{
            var jenis = jenis;
        }
        
        if (jenis == '<?php echo Params::JABATAN_PENGADAAN_PA ?>'){
            $("#<?php echo CHtml::activeId($model, 'pegawaipa_id') ?>").val(data.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'pegawaipa_nama') ?>").val(data.namaLengkap);
        }else if(jenis == '<?php echo Params::JABATAN_PENGADAAN_PPK ?>'){                        
            $("#<?php echo CHtml::activeId($model, 'pegawaippk_id') ?>").val(data.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'pegawaippk_nama') ?>").val(data.namaLengkap);
        }else if(jenis == '<?php echo Params::JABATAN_PENGADAAN_KPA ?>'){
            $("#<?php echo CHtml::activeId($model, 'pegawaikpa_id') ?>").val(data.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'pegawaikpa_nama') ?>").val(data.namaLengkap);            
        }
        
        $("#<?php echo CHtml::activeId($model, 'volume_pekerjaan') ?>").blur();
    }
    
    function hitungJumlahBaris(obj){
        var volume = 0;
        var pajak = 0;
        var jumlah = 0;
        var harga_satuan = 0; 
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.rencanaumumpengadaandet_volume').val();
        pajak = parseFloat($(obj).parents("tr").find('.rencanaumumpengadaandet_pajak').val());
        jumlah = $(obj).parents("tr").find('.rencanaumumpengadaandet_jumlah').val();
        if (volume !== '' && jumlah !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = 100 / (100 + pajak) * jumlah;
            harga_satuan = hit_persen / volume; 
            var jumlah_persen = ((volume * harga_satuan * pajak) / 100);
            $(obj).parents("tr").find('.rencanaumumpengadaandet_harga').val(harga_satuan.toFixed(2));
            $(obj).parents("tr").find('.rencanaumumpengadaandet_jmlpajak').val(jumlah_persen.toFixed(2));
        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }
    
    function hitungHargaBaris(obj){
        var volume = 0;
        var pajak = 0;
        var harga_satuan = 0; 
        unformatNumberSemua();
        volume = $(obj).parents("tr").find('.rencanaumumpengadaandet_volume').val();
        pajak = parseFloat($(obj).parents("tr").find('.rencanaumumpengadaandet_pajak').val());
        harga_satuan = $(obj).parents("tr").find('.rencanaumumpengadaandet_harga').val();
        if (volume !== '' && harga_satuan !== '' && pajak !== '') {
            volume = parseFloat(volume);
            var hit_persen = ((volume * harga_satuan * pajak) / 100);
            var sebelum_pajak  = (volume * harga_satuan);
            var total = (hit_persen) + (sebelum_pajak);
            $(obj).parents("tr").find('.rencanaumumpengadaandet_jumlah').val(total.toFixed(2));
            $(obj).parents("tr").find('.rencanaumumpengadaandet_jmlpajak').val(hit_persen.toFixed(2));

        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }
    
     function hitungTotalSeluruhnya(){
        var total_harga = 0;
        var total_pagu = 0;
        var total_pajak = 0;
        var sebelum_pajak = 0;
        unformatNumberSemua();
        var total_ok = 0;
        var ok = 0;
        $("#tabelRAB > tbody > tr").each(function () {
            var jumlah_harga = parseFloat($(this).find('.harga').val());
            var rencanaumumpengadaandet_harga = parseFloat($(this).find('.rencanaumumpengadaandet_harga').val());
            var sisa_pagu = parseFloat($(this).find('.sisapagu_pengadaan').val());
            var volume = parseFloat($(this).find(".volume").val());
            var pajak = parseFloat($(this).find(".persenpajak").val());
            var hit_pajak = ((volume * rencanaumumpengadaandet_harga * pajak) / 100);
            var harga_vol = (volume * rencanaumumpengadaandet_harga);
            var total = (harga_vol) + (hit_pajak);

            if (jumlah_harga > sisa_pagu) {
                ok = 1;
                $(this).find('td').attr('style', 'background: #ffcece !important');
            } else {
                $(this).find('td').attr('style', 'background: white !important');
            }
            total_harga += jumlah_harga;
            total_pagu += sisa_pagu;
            sebelum_pajak += harga_vol;
            total_pajak += hit_pajak;
            total_ok += ok;
        });
        
        if (total_ok > 0 ) {
            toastr.error("Jumlah item yang ditagihkan melebihi Sisa Pagu", "Perhatian!");
        }
        
        $('#total_hargaseluruhnya').val(total_harga.toFixed(2));
        $('#total_sisapagu').val(total_pagu.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'dpa_pagu') ?>").val(total_pagu.toFixed(2));  
        $("#<?php echo CHtml::activeId($model, 'total_harga') ?>").val(sebelum_pajak.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'total_pajak') ?>").val(total_pajak.toFixed(2));
        formatNumberSemua();
        cekValidasiDokumen();
    }
    
    var dokumen_id = {};
    
    function cekValidasiDokumen(){
        var total_hargaseluruhnya = parseFloat(unformatNumber($('#total_hargaseluruhnya').val()));
       
        $("#form-dokpendukung > tbody > tr").each(function () {
            dok_id = $(this).find('.dokumenpengadaan_id').val();
            dokumen_id[dok_id] = dok_id;
        });
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setValidasiDokumen'); ?>',
            data: {
                dokumenpengadaan_id: dokumen_id,
                total_hargaseluruhnya:total_hargaseluruhnya
            },
            dataType: "json",
            success: function (data) {
                var dok = data.tr;
                var res = dok.split(",");
                var attributeName = 'dokumenpendukungpengadaan_file';
                if (data.html >= 10000000){
                    if (dok != '') {
                        for (var x = 0; x < res.length; x++) {
                            if($("#form-dokpendukung ").find('tbody > tr[row-pengadaan="'+res[x]+'"]').find('.temp_file').val() === ''){ // required berlaku ketika dokumen sebelumnya belum diisi
                                $("#form-dokpendukung ").find('tbody > tr[row-pengadaan="'+res[x]+'"]').find('.dokumenpendukungpengadaan_file').addClass(' required'); // menambahkan class required 
                            }
                            $("#form-dokpendukung ").find('tbody > tr[row-pengadaan="'+res[x]+'"]').find('.label_required').html('*'); // menambahkan tanda * untuk required
                        }
                    }
                } else {
                    // menghilangkan required 
                    $("#form-dokpendukung > tbody > tr").each(function () {
                        $(this).find('input[name$="[' + attributeName + ']"]').removeClass('required'); 
                        $(this).find('.label_required').html('');
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }    
        
    $( document ).ready(function(){
        setJenisRUP($("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori"));
        var ispradpa = $("#ADRencanaumumpengadaanT_ispradpa").val();
        if (ispradpa == 1){
            $("#ADRencanaumumpengadaanT_ispradpa").attr('checked',true);
            cekDipaDpa($("#ADRencanaumumpengadaanT_ispradpa"));
            $("#ytADRencanaumumpengadaanT_ispradpa").val(1);
        }else{
            $("#ADRencanaumumpengadaanT_ispradpa").attr('checked',false);
            cekDipaDpa($("#ADRencanaumumpengadaanT_ispradpa"));
            $("#ytADRencanaumumpengadaanT_ispradpa").val(0);
        }
        cekPaket();  
//        $('.integer-decimal').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
        loadSumberDana();
        renameInputSumberDana();
        loadLokasiPekerjaan();
        loadJenis();
        setDokumenLoad();
        hitungTotalSumberDana();
        hitungTotalJenisPengadaan();
        renameInputRow($("#tabelRAB"));        
        <?php if(isset($_GET['sukses'])){ ?>
            $("input,select,textarea").attr("disabled",true);
            $('.add-on').hide();
        <?php } ?>        
    });
    
</script>