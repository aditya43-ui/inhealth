<script> 
    var set_instalasi = () => {
        var unit = $(".set_unitkerja_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/actionAjax/getInstalasiByUnit'); ?>',
            data: {
                unitkerja_id: unit,                                
            },
            dataType: "json",
            success: function (data) {
                $(".set_instalasi_id").val(data.instalasi_id);
                $(".set_instalasi_nama").val(data.instalasi_nama);                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    var load_unit = () => {
        var period_id = $(".set_periodeanggaran_id").val();
        var pegawai_id = '<?= Yii::app()->user->getState('pegawai_id')  ?>';
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/actionDynamic/GetUnitByPejabatPengadaan'); ?>',
            data: {
                period_id: period_id,                
                pegawai_id: pegawai_id,                
            },
            dataType: "json",
            success: function (data) {
                $(".set_unitkerja_id").html(data.drop);
                set_instalasi();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
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
    
   function tambahSub(){
        var row_rab = <?php echo CJSON::encode($this->renderPartial("row/_rowSubKegiatan", array('model' => new ADPengadaanprogramT,'tipe'=>'new'), true)); ?>;
        $("#tabel-subkegiatan-list > tbody").append(row_rab);
        renameInputRow($("#tabel-subkegiatan-list"));
        
        generateExtSubKegiatan(); 
        tambahSumberDana();
    }

    function hapusSub(obj) {
        var no = $(obj).parents("tr").attr('rowdata');
        myConfirm("Apakah anda yakin akan menghapus data ini?", "Perhatian!",
        function (r) {
            if (r) {
                $(obj).parents("tr").detach();                                  
                hapusSumberDana($("#tabel-sumberdana > tbody > tr[data-row='"+no+"']"));                
                
                renameInputRow($("#tabel-subkegiatan-list"));
            }
        });

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
    
    function loadSubByPaket(load,obj){        
        
//        var paketpekerjaan_id = new Array();
//        $("#tabel-paket-rup > tbody > tr").find('.paketpekerjaan_id').each(function(index){
//                if ($(this).val() != ''){
//                    paketpekerjaan_id[index] = $(this).val();
//                }
//        });

        var paketpekerjaan_id = load.paketpekerjaan_id;
        var mappingrekeninganggaran_id = load.mappingrekeninganggaran_id;
        var subkegiatanprogram_id = load.subkegiatanprogram_id
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GenFormSubkegiatan'); ?>',
            data: {
                paketpekerjaan_id: paketpekerjaan_id,                
                mappingrekeninganggaran_id: mappingrekeninganggaran_id,
                subkegiatanprogram_id: subkegiatanprogram_id
            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1){                                                                                                    
                    
                    var total = $("#tabel-paket-rup > tbody >tr").length;
                    if (total > 1){
                        tambahSumberDana();
                    }
                    
                    setData(data,obj,'paket');
                    
                    showRAB();                    
                    showTabelRAB();
                    generateExtSubKegiatan();
                }else{
                    toastr.error(data.pesan,"Perhatian!");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        
    }

    function setPaketPekerjaan(data,obj){
        var cek = 0;
        var cekMap = 0;
        var count = $("#tabel-paket-rup > tbody > tr").length;
        
        if (count > 1){            
            $("#tabel-paket-rup > tbody > tr").each(function(){
                if ($(this).find('.paketpekerjaan_id').val() == data.paketpekerjaan_id && $(this).find('.subkegiatanprogram_id').val() == data.subkegiatanprogram_id){
                    cek++;
                }                
            });         
        }else{
            if (data.paketpekerjaan_id == $("#tabel-paket-rup > tbody > tr:first").find('.paketpekerjaan_id').val()){
                
                return false;
            }
                
            
        }
        
//        if (cekMap > 0) {
//            toastr.error("Paket tidak bisa dipilih, karena berbeda kode rekening/sub kegiatan dengan paket yang sudah dipilih","Perhatian!");       
//            return false;
//        }
        
        if (typeof obj === 'undefined'){
            var row = $('#noRow').val();
        }else{
            var row = $(obj).parents("tr").attr('rowdata');
        }  
        
        if (cek > 0){
            toastr.error("Paket dengan sub kegiatan tersebut sudah dipilih","Perhatian!");            
            return false;
        }
        
        $("#tabel-paket-rup > tbody > tr[rowdata='"+row+"']").find('.paketpekerjaan_id').val(data.paketpekerjaan_id);        
        $("#tabel-paket-rup > tbody > tr[rowdata='"+row+"']").find('.subkegiatanprogram_id').val(data.subkegiatanprogram_id);
        $("#tabel-paket-rup > tbody > tr[rowdata='"+row+"']").find('.kode_paketpekerjaan').val(data.kode_paketpekerjaan);                                        
        $("#tabel-paket-rup > tbody > tr[rowdata='"+row+"']").find('.mappingrekeninganggaran_id').val(data.mappingrekeninganggaran_id);                                                
                
                        
        loadSubByPaket(data,obj);
        
        $("#dialogPaketPekerjaan").dialog("close");
    }
    
    function refreshPaketPekerjaan(){
        var unitkerja_id = $("#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>").val();
        var periodeanggaran_id = $("#<?php echo CHtml::activeId($model, 'periodeanggaran_id') ?>").val();        
        
        var def = 'kosong';
        if (unitkerja_id != '' && periodeanggaran_id != ''){
            def = '';
        }
                
        $.fn.yiiGridView.update('paketpekerjaan-m-grid', {
            data: {
                "RupPaketV[unitkerja_id]":unitkerja_id,
                "RupPaketV[periodeanggaran_id]":periodeanggaran_id,
                "RupPaketV[default]":def,
            }
        });     
    }
    
    function cekPaket(){
        var adapaket = $("#adapaket").prop("checked");
        var nonpaket = $("#nonpaket").prop("checked");
                        
        
        if (adapaket == true){
            generateExtPaket();
            $("#form-pilih-paket").show();
            
            $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_nama') ?>").attr('readonly',true);
            $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_nama') ?>").parents('.input-append').find('.add-on').hide();
            
            $("#jenis_trans").val('paket');
            
            $("#rup-t-form #ADRencanaumumpengadaanT_subprogram_id").val('');
            $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_id").val('');
            $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_nama").val('');            
            $("#rup-t-form #ADRencanaumumpengadaanT_nama_pekerjaan").val('');
            $("#rup-t-form #program").val('');
            $("#rup-t-form #kegiatan").val('');
            $("#rup-t-form #mappingrekeninganggaran_id").val('');
//            $("#rup-t-form #ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").val('data.kategori_pengadaan');

            $("#ADRencanaumumpengadaanT_metodepengadaan_id").val('');      

            $("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").change();
            
            $('#RAB').attr('style','display:none');
            
            clearMAK();
            generateFormSubKegiatan('paket');
        }else{
            $("#form-pilih-paket").hide();
            
            $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_nama') ?>").removeAttr('readonly',true);
            $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_nama') ?>").parents('.input-append').find('.add-on').show();
            
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
            
            $("#rup-t-form #ADRencanaumumpengadaanT_subprogram_id").val('');
            $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_id").val('');
            $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_nama").val('');            
            $("#rup-t-form #ADRencanaumumpengadaanT_nama_pekerjaan").val('');
            $("#rup-t-form #program").val('');
            $("#rup-t-form #kegiatan").val('');
            $("#rup-t-form #mappingrekeninganggaran_id").val('');
//            $("#rup-t-form #ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").val('data.kategori_pengadaan');

            $("#ADRencanaumumpengadaanT_metodepengadaan_id").val('');      

            $("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").change();
            
            $('#RAB').attr('style','display:none');
            
            clearMAK();
            generateFormSubKegiatan('nonpaket');
        }
    }
    
    function generateFormSubKegiatan(paket){
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('genFormSubkegiatan'); ?>',
            data: {
                paket: paket,                
            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1){
                    $(".form-subkegiatan").html(data.html);
                    generateExtSubKegiatan();                    
                }else{
                    toastr.error(data.pesan,"Perhatian!");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function generateExtSubKegiatan(){
        $("#tabel-subkegiatan-list > tbody > tr").find('.subkegiatanprogram_nama').autocomplete(
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
                    setData(ui.item,this);
                    return false;
                },
                'source':function(request, response)
                {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompleteKegiatan');?>",
                        dataType: "json",
                        data:{
                            term: request.term,     
                            unitkerja_id: $("#<?php echo CHtml::activeId($model, 'unitkerja_id'); ?>").val(),                            
                            periodeanggaran_id: $("#<?php echo CHtml::activeId($model, 'periodeanggaran_id'); ?>").val(),
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                }
            }
        ); 
    }
    
    function generateExtPaket(){                
        $("#tabel-paket-rup").find('.kode_paketpekerjaan').autocomplete(
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
                    setPaketPekerjaan(ui.item,this);
                    return false;
                },
                'source':function(request, response)
                {
                    $.ajax({
                        url: "<?php echo $this->createUrl('getPaketPekerjaan');?>",
                        dataType: "json",
                        data:{
                            term: request.term,     
                            unitkerja_id: $("#<?php echo CHtml::activeId($model, 'unitkerja_id'); ?>").val(),                            
                            periodeanggaran_id: $("#<?php echo CHtml::activeId($model, 'periodeanggaran_id'); ?>").val(),
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                }
            }
        );                
    }
            
    function tambahPaket(obj) {
        var row_paketpekerjaan = <?php echo CJSON::encode(array('html' => $this->renderPartial("_rowPaket", array(), true))); ?>;
    
        $("#tabel-paket-rup > tbody").append(row_paketpekerjaan.html);
        generateExtPaket();
        renameInputRow($("#tabel-paket-rup"));
    }
    
    function hapusPaket(obj) {
        
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!", function(r){
            if (r){
                $(obj).parents("tr").detach();
                renameInputRow($("#tabel-paket-rup"));
            }
        })                
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
           // Set jadi 0 supaya kalau di uncheck tetep muncul yang terakhir dicek 
            set_ceklist_barang[det_id] = 0;
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
                    hitung();
                    hitungTotalSeluruhnya();
//                    $('#total_hargaseluruhnya').val(data.total_harga);
//                    $('#total_awal').val(data.total_harga);
//                    $('#total_sisapagu').val(data.total_pagu);
                }
                $("#dialogBarangJasa").dialog('close');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /*=== Lokasi Pekerjaan ===*/
    var row_lokasiPekerjaan = <?php echo CJSON::encode(array('html' => $this->renderPartial("_rowLokasiPekerjaan", array('modLokasi' => $modLokasi, 'form' => $form), true))); ?>;
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
        $("#lokasiPekerjaan tr").each(function () {
            $(this).find(".row_num").html(cnt + 1);
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

    function setKabupaten(obj) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownKabupaten'); ?>',
            data: {
                propinsi_id: $(obj).val(),
            },
            dataType: "json",
            success: function (data) {
                $(obj).parents("tr").find('.kabupaten_id').html(data.form);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /*=== Lokasi Pekerjaan ===*/

    /*=== Sumber dana ===*/
    var row_sumberdana = <?php echo CJSON::encode(array('html' => $this->renderPartial("_rowSumberDana", array('modSumberDana' => $modSumberDana, 'form' => $form, 'i' => 1), true))); ?>;
    function tambahSumberDana() {
        $("#sumberDana").append(row_sumberdana.html);
        $("#tabel-sumberdana").find('input[class*="integer-decimal"]').unmaskMoney();
        $("#tabel-sumberdana").find('input[class*="integer-decimal"]').maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
        );  
        renameInputSumberDana();
        hitungTotalSumberDana();
        
        var subkegiatanprogram_id = new Array();
        
        $("#tabel-subkegiatan-list > tbody > tr").find('.subkegiatanprogram_id').each(function(index){
            if ($(this).val() != ''){
                subkegiatanprogram_id[index] = $(this).val();                
            }
        })
        
        $("#tabel-sumberdana > tbody > tr:last").find('[class*="asal_nama"]').val('Pemerintah Provinsi Jawa Timur RSUD DR SOETOMO');
            
            jQuery("#tabel-sumberdana > tbody > tr:last").find('[class*="mak_nama"]').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':3,
                    'focus':function(event, ui )
                    {
                        $(this).val( ui.item.label);
                    },
                    'select':function( event, ui )
                    {
                        setPengadaan(ui.item,this);
                        return false;
                    },
                    'source':function(request, response)
                    {
                        $.ajax({
                            url: "<?php echo $this->createUrl('RekeningMAK'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                                subkegiatanprogram_id: subkegiatanprogram_id
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
        $(obj).parents("tr").remove();
        renameInputSumberDana();
        hitungTotalSumberDana();
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

    function hitungTotalSumberDana(obj) {
        unformatNumberSemua();
        var total = 0;
        $("#sumberDana tr").each(function () {
            pagu = parseFloat($(this).find('input[name$="[pagu]"]').val());
            total = total + pagu;
        });

        //var dpa = unformatNumber($("#ADRencanaumumpengadaanT_dpa_pagu").val());
        
        //if (total > dpa) {
          //  myAlert('Total melebihi Pagu pada DPA');
            //$(obj).val(0);
        //} else {
            $("#totalDana").val(total);
            $("#totalJenisPengadaan").val(total);
            $("#jenisPengadaan > tr").each(function () {            
                $(this).find('input[name$="[jumlahpagu]"]').val(total);            
            }); 
        //}
        formatNumberSemua();
    }
    /*=== Sumber dana ===*/

    /*=== Jenis Pengadaan ===*/
    var row_jenispengadaan = <?php echo CJSON::encode(array('html' => $this->renderPartial("_rowJenisPengadaan", array('modJenis' => $modJenis, 'form' => $form), true))); ?>;
    function tambahJenisPengadaan() {
        $("#jenisPengadaan").append(row_jenispengadaan.html);
        $("#jenisPengadaan > tr:last").find('.integer-decimal').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2});
        renameInputJenisPengadaan();
        hitungTotalJenisPengadaan();
    }

    function hapusJenisPengadaan(obj) {
        $(obj).parents("tr").remove();
        renameInputJenisPengadaan();
        hitungTotalJenisPengadaan();
    }

    function tambahRAB(){
        var row_rab = <?php echo CJSON::encode($this->renderPartial("_rowRABHPS", array('model' => new RencanaumumpengadaandetT,), true)); ?>;
        $("#tabelRAB > tbody").append(row_rab);
        $("#tabelRAB > tbody > tr:last").find('input[class*="integer-decimal"]').maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
        );  
        $("#tabelRAB > tbody > tr:last").find('input[class*="float2"]').maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
        ); 
        renameInputRow($("#tabelRAB"));
        
        generateExt();
        
        hitung();
    }

    function hapusRAB(obj) {
        myConfirm("Apakah anda yakin akan menghapus data ini?", "Perhatian!",
                function (r) {
                    if (r) {
                        $(obj).parents("tr").remove();
                        hitungTotalSeluruhnya();
                        renameInputRow($("#tabelRAB"));
                        generateExt();
                    }
                });

    }

    function renameInputJenisPengadaan() {
        var cnt = 0;
        $("#jenisPengadaan tr").each(function () {
            $(this).find(".row_num").html(cnt + 1);
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

    function hitungTotalJenisPengadaan() {
        unformatNumberSemua();
        var total = 0;
        $("#jenisPengadaan > tr").each(function () {            
            var pagu = parseFloat($(this).find('input[name$="[jumlahpagu]"]').val());            
            total += pagu;            
        });       
        $("#totalJenisPengadaan").val(total);
        formatNumberSemua();
    }
    /*=== Jenis Pengadaan ===*/

    function setJenisRUP(obj) {
        var isi = $(obj).val();
        
        $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").removeClass('required');
        $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").parents(".control-group").find('.control-label').find("span").remove();
        if (isi == "Penyedia") {
            $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").addClass('required');
            $("#<?php echo CHtml::activeId($model, 'metodepengadaan_id') ?>").parents(".control-group").find('.control-label').append(" <span class='required'>*</span>");
            $('.swakelola').find("input,select,textarea").attr("disabled", true);
            $('.penyedia').find("input,select,textarea").removeAttr("disabled");
            $('.swakelola').hide();
            $('.penyedia').show();
        } else {            
            $('.swakelola').find("input,select,textarea").removeAttr("disabled");
            $('.penyedia').find("input,select,textarea").attr("disabled", true);
            $('.penyedia').hide();
            $('.swakelola').show();
        }
    }

    function cekDipaDpa(obj) {
        if ($(obj).is(":checked")) {
            $("#ADRencanaumumpengadaanT_nomor_kppuas").removeAttr("disabled");
            $('.kppuas').show();
        } else {
            $("#ADRencanaumumpengadaanT_nomor_kppuas").attr("disabled", true);
            $('.kppuas').hide();
        }
    }

    function cekSimpanRUP() {       
        if (requiredCheck($("#rup-t-form"))) {
            var ok = 0;
            var total = 0;
            $("#tabelRAB > tbody > tr").each(function () {
                var jumlah_harga = parseFloat($(this).find('.harga').val());
                var sisa = parseFloat($(this).find('.sisapagu_pengadaan').val());
                if (jumlah_harga > sisa) {
                    $(this).find('td').attr('style', 'background: #ffcece !important');
                    toastr.error("Jumlah yang diadakan tidak boleh melebihi sisa pagu", "Perhatian!");
                    ok = 1;
                } else {
                    $(this).find('td').attr('style', 'background: white !important');
                    ok = 0;
                } 
                total += ok;
            });
        
            if (total === 0) {
                $("#ADRencanaumumpengadaanT_statusnya").val('Draft');
                $("#rup-t-form").submit();
                disableOnSubmit($("#btn_submit"), 'no_unformat');
            }
            
            formatNumberSemua();
        }
        return false;
    }
    

    function cekSimpanRUP2() {
        totalDana = unformatNumber($("#totalDana").val());
        totalJenisPengadaan = unformatNumber($("#totalJenisPengadaan").val());
        kategori = $("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").val();

        if (kategori == "Penyedia") {
            if (totalJenisPengadaan != totalDana) {
                myAlert("Total Pagu Jenis Pengadaan tidak boleh beda dari Total Pagu Sumber Dana");
            } else {
                $("#ADRencanaumumpengadaanT_statusnya").val('PPK');
                $("#rup-t-form").submit();
                 disableOnSubmit($("#btn_submit"), 'no_unformat');
            }
        } else {
            $("#ADRencanaumumpengadaanT_statusnya").val('PPK');
            $("#rup-t-form").submit();
             disableOnSubmit($("#btn_submit"), 'no_unformat');
        }
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
    
    function setSumberDana(obj){
        var row = $(obj).parents("tr").data('row');
        if ($(obj).val() == 5) {
            $('#tabel-sumberdana > tbody > tr').each(function () {
                if ($(this).attr('data-row') == row) {
                    $(this).find('.asal_nama').val('Pemerintah Provinsi Jawa Timur RSUD DR SOETOMO');
                }
            });
        } else {
            $('#tabel-sumberdana > tbody > tr').each(function () {
                if ($(this).attr('data-row') == row) {
                    $(this).find('.asal_nama').val('');
                }
            });
        }
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
                        $(this).find('.btnhapus').addClass('hide');
                    }else{
                        $(this).find('.btnhapus').removeClass('hide');
                        $(this).find('.btntambah').addClass('hide');                        
                    }
                }

                row++;
        });               
       
       jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
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
                        url: "<?php echo $this->createUrl('autoCompleteBarangJasa');?>",
                        dataType: "json",
                        data:{
                            term: request.term,     
                            instalasi_id: $("#<?php echo CHtml::activeId($model, 'instalasi_id'); ?>").val(),
                            subkegiatanprogram_id: $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_id'); ?>").val(),
                            periodeanggaran_id: $("#<?php echo CHtml::activeId($model, 'periodeanggaran_id'); ?>").val(),
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
        
        if (typeof obj === 'undefined'){
            var row = $('#noRow').val();
        }else{
            var row = $(obj).parents("tr").attr('rowdata');
        }  
        
        if (cek > 0){
            toastr.error("Barang dan Jasa sudah dipilih","Perhatian!");
            $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.rencanaumumpengadaandet_nama').val($("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.tempNama').val());                    
            return false;
        }
        
        $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.barang_id').val(data.barang_id);
        $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.jenis_barang').val(data.jenis_barang);
        $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.dokumenpelaksanaananggarandet_id').val(data.dokumenpelaksanaananggarandet_id);
        $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.rencanaumumpengadaandet_nama').val(data.uraian);
        $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.tempNama').val(data.uraian);        
        $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.rencanaumumpengadaandet_satuan').val(data.satuan);
        $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.rencanaumumpengadaandet_harga').val(data.harga_satuan);
        $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.hargaawal').val(data.harga_satuan);
        $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.rencanaumumpengadaandet_volume').val(data.volume);
        $("#tabelRAB > tbody > tr[rowdata='"+row+"']").find('.volumeawal').val(data.volume);                                        
        
        $("#<?php echo CHtml::activeId($model, 'pegawaipa_nama') ?>").blur();
        
        hitung();
    }
    
    /**
     * Hitung dari Jumlah
     * @param {type} obj
     * @returns {undefined}
     */
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
            var hit_pajak = ((volume * harga_satuan * pajak) / 100);
            $(obj).parents("tr").find('.pajak').val(hit_pajak.toFixed(2));
            $(obj).parents("tr").find('.rencanaumumpengadaandet_harga').val(harga_satuan.toFixed(2));
        }
        formatNumberSemua();
        hitungTotalSeluruhnya();
    }
    
    /**
     * Hitung dari Harga, Volume dan Pajak
     * @param {type} obj
     * @returns {undefined}
     */
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
            $(obj).parents("tr").find('.pajak').val(hit_persen.toFixed(2));
            $(obj).parents("tr").find('.rencanaumumpengadaandet_jumlah').val(total.toFixed(2));
        }

        formatNumberSemua();
        hitungTotalSeluruhnya();
    }
    
    function hitungTotalSeluruhnya(){
        var total_harga = 0;
        var total_pagu = 0;
        var total_pajak = 0;
        var total_sebelumpajak = 0;
        unformatNumberSemua();
        $("#tabelRAB > tbody > tr").each(function () {
            var jumlah_harga = parseFloat($(this).find('.harga').val());
            var sisa_pagu = parseFloat($(this).find('.sisapagu_pengadaan').val());
            var pajak = parseFloat($(this).find('.pajak').val());
            var total = jumlah_harga - pajak;
            if (jumlah_harga > sisa_pagu) {
                $(this).find('td').attr('style', 'background: #ffcece !important');
                toastr.error("Jumlah item yang ditagihkan melebihi Sisa Pagu", "Perhatian!");
            } else {
                $(this).find('td').attr('style', 'background: white !important');
            }
            total_sebelumpajak += total;
            total_pajak += pajak;
            total_harga += jumlah_harga;
            total_pagu += sisa_pagu;
        });
        
        $('#total_hargaseluruhnya').val(total_harga.toFixed(2));
        $('#total_sisapagu').val(total_pagu.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'total_harga') ?>").val(total_sebelumpajak);
        $("#<?php echo CHtml::activeId($model, 'total_pajak') ?>").val(total_pajak);
        formatNumberSemua();
    }
    
    function refreshBarangJasa(){
        var instalasi_id = $("#<?php echo CHtml::activeId($model, 'instalasi_id') ?>").val();
        var unitkerja_id = $("#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>").val();
        var periodeanggaran_id = $("#<?php echo CHtml::activeId($model, 'periodeanggaran_id') ?>").val();
        //var subkegiatanprogram_id = $("#<?php echo CHtml::activeId($model, 'subkegiatanprogram_id') ?>").val();
        
        var subkegiatanprogram_id = '';
        
        var i = 0;
        $("#tabel-subkegiatan-list > tbody > tr").find('.subkegiatanprogram_id').each(function(index){    
            if ($(this).val() != ''){
                subkegiatanprogram_id += $(this).val()+',';
                i++;
            }        
        });
        
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
        
        $("#tabel-sumberdana > tbody > tr").find('.mappingrekeninganggaran_id').each(function(index){                                                                
            mappingrekeninganggaran_id += $(this).val()+',';                                  
            i++;
        });                      
        
        $(".barang_instalasi_id").val(instalasi_id);
        $(".barang_periodeanggaran_id").val(periodeanggaran_id);        
        $(".barang_unitkerja_id").val(unitkerja_id);
        $(".barang_subkegiatanprogram_id").val(subkegiatanprogram_id);        
        $(".barang_paketpekerjaan_id").val(paket_id); 
        $(".barang_mappingrekeninganggaran_id").val(mappingrekeninganggaran_id);
        
        $.fn.yiiGridView.update('barangjasa-m-grid', {
            data: {
                "DokumenpelaksanaananggarandetT[instalasi_id]":instalasi_id,
                "DokumenpelaksanaananggarandetT[periodeanggaran_id]":periodeanggaran_id,
                "DokumenpelaksanaananggarandetT[subkegiatanprogram_id]":subkegiatanprogram_id,                
                "DokumenpelaksanaananggarandetT[unitkerja_id]":unitkerja_id,                
                "DokumenpelaksanaananggarandetT[paketpekerjaan_id]":paket_id,                  
                "DokumenpelaksanaananggarandetT[mappingrekeninganggaran_id]":mappingrekeninganggaran_id,                  
            }
        });     
    }
    
    function refreshSubKegiatan(){
        var periodeanggaran_id = $("#<?php echo CHtml::activeId($model, 'periodeanggaran_id') ?>").val();
        var instalasi_id = $("#<?php echo CHtml::activeId($model, 'instalasi_id') ?>").val();
        var unitkerja_id = $("#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>").val();
        var def = 'ada';
        if (periodeanggaran_id != '' && instalasi_id != '' && unitkerja_id != ''){
            def = '';
        }
        
        $(".subkeg_unitkerja_id").val(unitkerja_id);
        $(".subkeg_instalasi_id").val(instalasi_id);
        $(".subkeg_periodeanggaran_id").val(periodeanggaran_id);
        
        $.fn.yiiGridView.update('kegiatan-t-grid', {
            data: {                
                "RupSubkegiatanprogramV[periodeanggaran_id]":periodeanggaran_id,                
                "RupSubkegiatanprogramV[instalasi_id]":instalasi_id,
                "RupSubkegiatanprogramV[unitkerja_id]":unitkerja_id,
                "RupSubkegiatanprogramV[default]":def
            }
        });     
    }
    
    function setPaguDPA(){
        
        var id = new Array();
        var load = 'dpadet';
        var transaksi = 'true';
        $("#tabelRAB > tbody > tr").each(function(index){
            if ($(this).find('.dokumenpelaksanaananggarandet_id').val() != ''){
                id[index] = $(this).find('.dokumenpelaksanaananggarandet_id').val();
            }
        });
    
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/actionAjax/loadDPAdariPagu'); ?>',
            data: {
                dokumenpelaksanaananggarandet_id:id,
                load:load,
                transaksi:transaksi
                
            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {                    
                    $("#<?php echo CHtml::activeId($model, 'dpa_pagu') ?>").val(data.total);
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
    
    var reset_pejabat = () => {
        $("#<?php echo CHtml::activeId($model, 'pegawaippk_id') ?>").val("");
        $("#<?php echo CHtml::activeId($model, 'pegawaippk_nama') ?>").val("");
        
        $("#<?php echo CHtml::activeId($model, 'pegawaikpa_id') ?>").val("");
        $("#<?php echo CHtml::activeId($model, 'pegawaikpa_nama') ?>").val("");
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
         

    //filter langsung ketika on load
    $(document).ready(function () {
        $("#PengadaanlokasiT_0_kabupaten_id").val(528);
        $("#PengadaanlokasiT_0_detil_lokasi").val('RSUD Dr. Soetomo');
        load_unit();
        
        tambahSumberDana();
        setJenisRUP($("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori"));
        cekDipaDpa($("#ADRencanaumumpengadaanT_ispradpa"));
        cekPaket();        
<?php if (isset($_GET['sukses'])) { ?>
            hitungTotalSumberDana();
            hitungTotalJenisPengadaan();
            $("input,select,textarea").attr("disabled", true);
            $('.add-on').hide();
<?php } ?>
        
    });

</script>