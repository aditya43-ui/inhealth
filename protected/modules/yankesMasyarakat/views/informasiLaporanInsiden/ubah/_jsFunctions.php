<script>   
    function pilihPenanggung(obj){
        var ini = $(obj);
        if(ini.is(":checked") ){
            var isi = ini.val();
            if(isi == "Lainnya"){
                $("#InsidenrsT_penanggungjawabpasien_lainnya_ket").prop("readonly", false);
            }else{
                $("#InsidenrsT_penanggungjawabpasien_lainnya_ket").val("");
                $("#InsidenrsT_penanggungjawabpasien_lainnya_ket").prop("readonly", true);
            }
            $("#penanggungjawab_biaya").val(isi);
        }            
    }
    
    function refreshDialog() {
        var ruangan = $("#InsidenrsT_lokasikejadian_id").val();
        var def = '';
        if (ruangan == "") {
            def = 'ada';
        }

        $(".ruangan_id").val(ruangan);

        setTimeout(function () {
            $("#dialogUnitKerja").removeClass('animation-loading-1');                               
            $.fn.yiiGridView.update('unitkerja-m-grid', {
                data: {
                    "UnitkerjaruanganM[ruangan_id]": ruangan,
                    "UnitkerjaruanganM[default]": def,
                }
            });
        }, 500);
    }
    
    function refreshDialogPenyebab() {
        var ruangan = $("#InsidenrsT_ruanganpenyebab_id").val();
        var def = '';
        if (ruangan == "") {
            def = 'ada';
        }

        $(".ruangan_id").val(ruangan);
        $("#dialogUnitKerjaPenyebab").addClass('animation-loading-1');                               
        setTimeout(function () {
            $("#dialogUnitKerjaPenyebab").removeClass('animation-loading-1');                               
            $.fn.yiiGridView.update('unitkerjapenyebab-m-grid', {
                data: {
                    "UnitkerjaruanganM[ruangan_id]": ruangan,
                    "UnitkerjaruanganM[default]": def,
                }
            });
        }, 500);
    }
    
    function setKunjungan(data) {
        $("#no_rekam_medik").val(data.no_rekam_medik);
        $("#nama_pasien").val(data.nama_pasien);
        $("#jeniskelamin").val(data.jeniskelamin);
        $("#no_pendaftaran").val(data.no_pendaftaran);
        $("#tanggal_kunjungan").val(data.tgl_pendaftaran);
        $("#instalasi_pasien").val(data.instalasi_nama);
        $("#ruangan_pasien").val(data.ruangan_nama);
        $("#diagnosa_nama").val(data.diagnosa_nama);
        $("#diagnosa_id").val(data.diagnosa_id);
        $("#penjamin_nama").val(data.penjamin_nama);
        $("#umur").val(data.umur);
        $("#pendaftaran_id").val(data.pendaftaran_id);
        $("#InsidenrsT_pendaftaran_id").val(data.pendaftaran_id);
        $("#InsidenrsT_diagnosa_id").val(data.diagnosa_id);
        $("#nama_pasien").blur();
    }
    
    $('#InsidenrsT_tindakan_olehlainnya').attr('disabled','true');
    function setTindakanLainnya(){
        //var tindakan = $('#InsidenrsT_tindakan_oleh').val();
        var tindakan = $('#InsidenrsT_tindakan_olehpetugaslain').prop('checked');
        if (tindakan == true){            
            $('#InsidenrsT_tindakan_olehlainnya').removeAttr('disabled');
        } else {
            $('#InsidenrsT_tindakan_olehlainnya').val("");
            $('#InsidenrsT_tindakan_olehlainnya').attr('disabled','true');
        }
    }
    function inputRuangan(lokasikejadian_id){
        clearRuangan();
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('GetDataRuangan'); ?>',
            data: {ruangan_id : lokasikejadian_id},
            dataType: "json",
            success:function(data){
                $("#<?= CHtml::activeId($model, 'lokasikejadian_id'); ?>").val(data.ruangan_id);
                $("#<?= CHtml::activeId($model, 'lokasikejadian_nama'); ?>").val(data.ruangan_nama);
                $("#<?= CHtml::activeId($model, 'unitkerjatempat_id'); ?>").val(data.unitkerja_id);
                $("#<?= CHtml::activeId($model, 'unitkerja'); ?>").val(data.unitkerja);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function clearRuangan(){
        $("#<?= CHtml::activeId($model, 'ruangan_id'); ?>").val('');
        $("#<?= CHtml::activeId($model, 'ruangan_nama'); ?>").val('');
        $("#<?= CHtml::activeId($model, 'unitkerjatempat_id'); ?>").val('');
        $("#<?= CHtml::activeId($model, 'unitkerja'); ?>").val('');
    }
    function cekForm(){
        if (requiredCheck($('insiden-rs-t-form'))){
            $('insiden-rs-t-form').submit();
        }

       return false;
    }
    
    function setTipeInsiden()
    {
        var tipeinsiden = $('#InsidenrsT_tipeinsiden').val();
        $("#table-insiden").addClass("animation-loading");
        $('#table-insiden > tbody').html("");
        if(tipeinsiden != ''){
            $.post('<?php echo $this->createUrl('getTabel'); ?>', { 
                tipeinsiden:tipeinsiden, 
            },
            function(data){
                if(data.pesan == 'sukses'){
                    $('#table-insiden > tbody').append(data.return);
                    $("#table-insiden tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
                    $("#table-insiden").removeClass("animation-loading");
                }else{
                    $("#table-insiden").removeClass("animation-loading");
                    $('#table-insiden > tbody').html("");
                }
            }, "json");
        }else{
            $("#table-insiden").removeClass("animation-loading");
            $('#table-insiden > tbody').html("");
        }
    }
    
    function setPerubahan(obj){
        var ganti = document.getElementById("ganti");
        var ada = $('#InsidenrsT_perubahan_ada');
        if (ada.is(" :checked")) {
            if (ganti.style.display === "block") {
                ganti.style.display = "block";
            } else {
                ganti.style.display = "block";
            } 
        } else {
            if (ganti.style.display === "none") {
                ganti.style.display = "block";
            } else {
                ganti.style.display = "none";
            }
        }
    }
    
    function showHideTabel(obj) {
        var tipeinsiden = document.getElementById("InsidenrsT_tipeinsiden");
        var baru = document.getElementById("baru");
        
        if(obj.value != ''){
            if (baru.style.display === "block") {
                baru.style.display = "block";
            } else {
                baru.style.display = "block";
            }  
        }else{
            if (baru.style.display === "none") {
                baru.style.display = "block";
            } else {
                baru.style.display = "none";
            }
        }
    }
    
    $(document).ready(function(){
        setTipeInsiden();
        refreshDialog();
        refreshDialogPenyebab();
        $(".kejadian").find('input:checkbox').click(function () {
            var cek_lis = $(this).prop('checked');
            $(this).parents(".control-group").find('input:checkbox').each(function () {
                $(this).prop("checked", false);
                $(this).removeClass("required");
            });
            if (cek_lis == true) {
                $(this).prop("checked", true);
                $(this).addClass("required");
            }
        });
    });
    
    
     function refreshPetugas(){
        var unitkerja_id = $("#<?php echo CHtml::activeId($model, 'unitkerjatempat_id'); ?>").val();
        var unitkerja_nama = $("#<?php echo CHtml::activeId($model, 'unitkerja'); ?>").val();            
    
        if (unitkerja_id == ''){
            var def = 'ada';            
            $("#judul-petugas").html('');
        }else{
            var def = '';            
            $("#judul-petugas").html(" Berdasarkan unit "+unitkerja_nama);
        }
    
        
    
        $.fn.yiiGridView.update('dialog-pegawai-grid', {
            data: {
                "PegawaiV[default]":def,			
                "PegawaiV[unitkerja_id]":unitkerja_id
            }
        });
        
        $("#dialogPetugas").dialog('open');
    }
    function refreshPetugas1(){
        var unitkerjapenyebab_id = $("#<?php echo CHtml::activeId($model, 'unitkerjapenyebab_id'); ?>").val();
        var unitkerjapenyebab_nama = $("#<?php echo CHtml::activeId($model, 'unitkerjapenyebab_nama'); ?>").val();            
    
        if (unitkerjapenyebab_id == ''){
            var def = 'ada';            
            $("#judul-petugas1").html('');
        }else{
            var def = '';            
            $("#judul-petugas1").html(" Berdasarkan unit "+unitkerjapenyebab_nama);
        }
    
        
    
        $.fn.yiiGridView.update('dialog-pegawai1-grid', {
            data: {
                "PegawaiV[default]":def,			
                "PegawaiV[unitkerja_id]":unitkerjapenyebab_id
            }
        });
        
        $("#dialogPetugas1").dialog('open');
    }
    
    function getDefault(){
        var unitkerja_id = $("#<?php echo CHtml::activeId($model, 'unitkerjatempat_id'); ?>").val();
        var unitkerja_nama = $("#<?php echo CHtml::activeId($model, 'unitkerja'); ?>").val();            
    
        if (unitkerja_id == ''){
            var def = 'ada';                        
        }else{
            var def = '';                        
        }
        
        return def;
    }
    function getDefault1(){
        var unitkerjapenyebab_id = $("#<?php echo CHtml::activeId($model, 'unitkerjapenyebab_id'); ?>").val();
        var unitkerjapenyebab_nama = $("#<?php echo CHtml::activeId($model, 'unitkerjapenyebab_nama'); ?>").val();            
    
        if (unitkerjapenyebab_id == ''){
            var def = 'ada';                        
        }else{
            var def = '';                        
        }

        return def;
    }
   
     function setPetugas(data){
        $("#<?php echo CHtml::activeId($model, 'mengetahui_id') ?>").val(data.pegawai_id);
        $("#<?php echo CHtml::activeId($model, 'mengetahui_nama') ?>").val(data.namaLengkap);
        
        $("#dialogPetugas").dialog('close');
    }
     function setPetugas1(data){
        $("#<?php echo CHtml::activeId($model, 'mengetahui_kepalaunitpenyebab_id') ?>").val(data.pegawai_id);
        $("#<?php echo CHtml::activeId($model, 'mengetahui_kepalaunitpenyebab_nama') ?>").val(data.namaLengkap);
        
        $("#dialogPetugas1").dialog('close');
    }
</script>