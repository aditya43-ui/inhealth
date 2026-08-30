<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$baseUrl = Yii::app()->createUrl("/");
?>
<script>

    var is_checked = {};

    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }

    function setPetugas(nama, id) {
        $("#<?php echo CHtml::activeId($model, 'petugas_penerima_id') ?>").val(id);
        $("#<?php echo CHtml::activeId($model, 'petugas_penerima_nama') ?>").val(nama);
        $("#dialogPetugas").dialog('close');

        $("#<?php echo CHtml::activeId($model, 'petugas_penerima_nama') ?>").blur();
    }

    function resetKantong() {
        $("#BDReturdarahT_nama_pasien").val("");
        $("#BDReturdarahT_ujikompatibilitas_id").val("");
        $("#BDReturdarahT_no_rekam_medik").val("");
        $("#BDReturdarahT_golongan_darah").val("");
        $("#BDReturdarahT_no_kantongdarah").val("");
        $("#BDReturdarahT_jenis_komponen_darah").val("");
        $("#BDReturdarahT_ruangan_nama").val("");
    }

    function ubahPilih1() {
        $("#BDReturdarahT_pilih2").prop('checked', false);
        $("#BDReturdarahT_pilih3").prop('checked', false);
        $("#BDReturdarahT_bdt_suhucoolbox").attr("readonly", true);
        $("#BDReturdarahT_bdt_suhucoolbox").val("");
        $("#ruangan_tgl_penyerahan").show();
        $("#ruangan_tgl_penyerahan_text").hide();
    }

    function ubahPilih2() {
        $("#BDReturdarahT_pilih1").prop('checked', false);
        $("#BDReturdarahT_pilih3").prop('checked', false);
        $("#BDReturdarahT_bdt_suhucoolbox").removeAttr("readonly");
        $("#BDReturdarahT_ruangan_tgl_penyerahan").val("");
        $("#BDReturdarahT_ruangan_tgl_penyerahan_text").val("");
        $("#ruangan_tgl_penyerahan").hide();
        $("#ruangan_tgl_penyerahan_text").show();
    }

    function ubahPilih3() {
        $("#BDReturdarahT_pilih2").prop('checked', false);
        $("#BDReturdarahT_pilih1").prop('checked', false);
        $("#BDReturdarahT_bdt_suhucoolbox").attr("readonly", true);
        $("#BDReturdarahT_bdt_suhucoolbox").val("");
        $("#BDReturdarahT_ruangan_tgl_penyerahan").val("");
        $("#BDReturdarahT_ruangan_tgl_penyerahan_text").val("");
        $("#ruangan_tgl_penyerahan").hide();
        $("#ruangan_tgl_penyerahan_text").show();
    }

    function setSemuaKantong(obj) {
        if ($(obj).prop("checked") == true) {
            $("input:checkbox.pilih").each(function () {
                $(this).prop("checked", true).change();
            });
        } else {
            $("input:checkbox.pilih").each(function () {
                $(this).prop("checked", false).change();
            });
        }

    }

    function setKantong(obj) {
        var nomor = $(obj).attr('no_kantongdarah');

        if ($(obj).prop("checked") == true) {
            is_checked[nomor] = nomor;
        } else {
            is_checked[nomor] = 0;
        }
    }
    function inputKantong() {
        var no_kantongdarah = is_checked;

        if (isEmpty(no_kantongdarah)) {
            myAlert('kantong yang akan dikirimkan belum dipilih');
            return false;
        } else {
            $('#table-detailkantongdarah').addClass("animation-loading");
            cekList(no_kantongdarah);

        }
    }

    function cekList(id) {
        x = true;

        if (x == true) {
            tambahKantong(is_checked);
            $("#dialogKantong").dialog("close");
            return x;
        }
        return false;
    }

    function tambahKantong(nomor) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getKantong'); ?>',
            data: {no_kantongdarah: nomor},
            dataType: "json",
            success: function (data) {
                $('#table-detailkantongdarah > tbody').append(data);
                $('#table-detailkantongdarah').removeClass("animation-loading");
                renameInputRow($("#table-detailkantongdarah"));
                is_checked = {};
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
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

    function batal(obj) {
        if (!confirm('Apakah anda akan membatalkan Kantong Darah ini ?')) {
            return false;
        } else {
            $(obj).parents('tr').remove();
            renameInputRow($("#table-detailkantongdarah"));
        }
    }
    
    function cekSudahAda(nomor,obj){
        var x= true;
        $('.no_kantongdarah').each(function(){
            if($(this).val() == nomor){
                x = false;
                $("#table-detailkantongdarah").removeClass("animation-loading");
            }else{
                
            }
        });
        
        if(x == false){
            myAlert("Kantong telah ada di list");
            $(obj).val('');
        }else{
            tambahKantong(nomor);
            $(obj).val('');
        }
    }
    
    function setCeklisKantong(){           
        $("input:checkbox.pilih").each(function(){                                   
            var nomor = $(this);
            nomor.prop("checked",false);
            nomor.removeAttr("disabled");
            $("#table-detailkantongdarah > tbody > tr").find(".no_kantongdarah").each(function(){                                                             
                if (nomor.attr('no_kantongdarah') == $(this).val()){                    
                    nomor.prop("checked", true);
                    nomor.attr("disabled", true);
                }
            });                       
        });
    }
    
    function cekSubmit(){
        var pilih1 = $('#BDReturdarahT_pilih1').prop('checked');
        var pilih2 = $('#BDReturdarahT_pilih2').prop('checked');
        var pilih3 = $('#BDReturdarahT_pilih3').prop('checked');
        if(pilih1 == true || pilih2 == true || pilih3 == true){
            if(requiredCheck($("form"))){
                $('#returdarah-form').submit();
            }
        }else{
            myAlert('Pilih Dahulu Asal Darah');
            return false;
        }
    }
</script>