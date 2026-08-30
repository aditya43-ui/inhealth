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
            $.post('<?php echo $this->createUrl('getTabeldet'); ?>', { 
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
    
    $(document).ready(function(){
//        setTipeInsiden();
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
</script>