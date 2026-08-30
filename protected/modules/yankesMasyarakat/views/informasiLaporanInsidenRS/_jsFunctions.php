<script>   
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
        $("#<?= CHtml::activeId($model, 'diagnosa_id'); ?>").val(data.diagnosa_id);
        $("#<?= CHtml::activeId($model, 'diagnosa_nama'); ?>").val(data.diagnosa_nama);
        if($("#<?= CHtml::activeId($model, 'insidenrs_pelapor'); ?>").val() == "Pasien"){
            $("#<?= CHtml::activeId($model, 'nama_pelapor'); ?>").val(data.nama_pasien);
        }
        $("#nama_pasien").blur();
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
    
    function setPelapor(obj){
        var nama_pasien = $("#nama_pasien").val();
        if($(obj).val() == "Pasien"){
            $("#<?= CHtml::activeId($model, 'nama_pelapor'); ?>").val(nama_pasien);
        }else{
            $("#<?= CHtml::activeId($model, 'nama_pelapor'); ?>").val('');
        }
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
       
    function setUnitLain(obj) {        
        var tindakan = $('#InsidenrsT_terjadiunitlain_ya').prop('checked');
        if (tindakan == true){            
            $('#InsidenrsT_kejadian_diunitlain').removeAttr('disabled');
        } else {
            $('#InsidenrsT_kejadian_diunitlain').val("");
            $('#InsidenrsT_kejadian_diunitlain').attr('disabled','true');
        }
    }
    
    function inputRuangan(lokasikejadian_id){
        clearRuangan();
        $("#<?php echo CHtml::activeId($model, 'mengetahui_nama'); ?>").addClass('animation-loading-1');
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
                $("#<?= CHtml::activeId($model, 'mengetahui_id'); ?>").val(data.pegawai_id);
                $("#<?= CHtml::activeId($model, 'mengetahui_nama'); ?>").val(data.nama_pegawai);
                                                                               
                $("#<?php echo CHtml::activeId($model, 'mengetahui_nama'); ?>").removeClass('animation-loading-1');
            
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
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
    
    function refreshPetugasPenyebab(){
        var unitkerja_id = $("#<?php echo CHtml::activeId($model, 'unitkerjapenyebab_id'); ?>").val();
        var unitkerja_nama = $("#<?php echo CHtml::activeId($model, 'unitkerjapenyebab_nama'); ?>").val();            
    
        if (unitkerja_id == ''){
            var def = 'ada';            
            $("#judul-petugas").html('');
        }else{
            var def = '';            
            $("#judul-petugas").html(" Berdasarkan unit "+unitkerja_nama);
        }
    
        
    
        $.fn.yiiGridView.update('dialog-pegawai-penyebab-grid', {
            data: {
                "PegawaiV[default]":def,			
                "PegawaiV[unitkerja_id]":unitkerja_id
            }
        });
        
        $("#dialogPetugasPenyebab").dialog('open');
    }
    
    function setPetugas(data){
        $("#<?php echo CHtml::activeId($model, 'mengetahui_id') ?>").val(data.pegawai_id);
        $("#<?php echo CHtml::activeId($model, 'mengetahui_nama') ?>").val(data.namaLengkap);
        
        $("#dialogPetugas").dialog('close');
    }
    
    function setPetugasPenyebab(data){
        $("#<?php echo CHtml::activeId($model, 'mengetahui_kepalaunitpenyebab_id') ?>").val(data.pegawai_id);
        $("#<?php echo CHtml::activeId($model, 'mengetahui_kepalaunitpenyebab_nama') ?>").val(data.namaLengkap);
        
        $("#dialogPetugasPenyebab").dialog('close');
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
    
    function setTipeInsiden(jenis)
    {
        var tipeinsiden = $('#InsidenrsT_tipeinsiden').val();
        var insiden_id = $("#InsidenrsT_insidenrs_id").val();
        
        $("#table-insiden").addClass("animation-loading");
        $('#table-insiden > tbody').html("");
        if(tipeinsiden != ''){
            $.post('<?php echo $this->createUrl('getTabel'); ?>', { 
                tipeinsiden:tipeinsiden, insiden_id:insiden_id, jenis:jenis
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
            setTipeInsiden('load'); 
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
    
    $(document).ready(function(){
        setTindakan(); 
        refreshDialog();
        refreshDialogPenyebab(); 
        setUnitLain($(".kejadian"));
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
            setUnitLain($(".kejadian"));
        });
        
    });
</script>