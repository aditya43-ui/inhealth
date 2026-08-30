<script type="text/javascript">
function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();
    
        if(obatalkes_id != '')
        {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormPermohonanBantuan'); ?>',
                data: {obatalkes_id:obatalkes_id,jumlah:jumlah},
                dataType: "json",
                success:function(data){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    renameInputRowObatAlkes($("#table-obatalkespasien"));                    
                    hitungTotal();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            myAlert("Isikan item obat terlebih dahulu");
        }
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    $('#table-obatalkespasien tbody tr').each(function(){
        var jmlpermintaan  = parseInt($(this).find('input[name$="[permohonanoadetail_qty]"]').val());
        var harganetto  = parseInt($(this).find('input[name$="[harganetto]"]').val());
        subtotal = harganetto * jmlpermintaan;
        
        if(subtotal <= 0){
            subtotal = 0;
        }
        
        total += subtotal;
        $(this).find('input[name$="[subtotal]"]').val(subtotal);
    });
    $('#total').val(total);    
    formatNumberSemua();
}

/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    $('#obatalkes_id').val('');
    $('#obatalkes_nama').val('');
    $('#qty_input').val(1);
}

function batalObat(obj){
    myConfirm('Apakah Anda akan membatalkan bantuan obat alkes ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
        }
    }); 
    hitungTotal();
}

function pilihSatuan(obj){
    var satuanobat = $(obj).val();
    
    if(satuanobat == '<?php echo PARAMS::SATUAN_KECIL; ?>'){
        $(obj).parents('tr').find('.satuankecil').show();
        $(obj).parents('tr').find('.satuanbesar').hide();
    }else{
        $(obj).parents('tr').find('.satuanbesar').show();
        $(obj).parents('tr').find('.satuankecil').hide();
    }
}

/**
* load rencdetailkeb_t yang sudah tersimpan berdasarkan:
* - permintaanpembelian_id
*/ 
function setRiwayatPermohonanBantuan(){
    $('#table-obatalkespasien').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setRiwayatPermohonanBantuan'); ?>',
        data: {permohonanoa_id:$("#permohonanoa_id").val()},
        dataType: "json",
        success:function(data){
            $('#table-obatalkespasien > tbody').html(data.rows);
            $('#table-obatalkespasien > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
            $('#table-obatalkespasien').removeClass("animation-loading");
            renameInputRowObatAlkes($("#table-obatalkespasien"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
* untuk print rencana kebutuhan
 */
function print(caraPrint)
{
    var permohonanoa_id = $('#permohonanoa_id').val();
    window.open('<?php echo $this->createUrl('print'); ?>&permohonanoa_id='+permohonanoa_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

/** bersihkan dropdown kecamatan */
function setClearDropdownKecamatan()
{
    $("#<?php echo CHtml::activeId($modPermohonanOa,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
/** bersihkan dropdown kelurahan */
function setClearDropdownKelurahan()
{
    $("#<?php echo CHtml::activeId($modPermohonanOa,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function cekObat(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-obatalkespasien tbody tr').length;
        if(jmlObat <= 0){
                myAlert('Silakan isikan permohonan bantuan obat alkes terlebih dahulu!');
            return false;
        }else{
            $('#permohonanoa-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;    
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var permohonanoa_id = '<?php echo $modPermohonanOa->permohonanoa_id; ?>';
    
    if(permohonanoa_id != ""){
        $("#table-obatalkespasien :input").attr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();
        
        $("#permintaanpembelian-form :input").attr("readonly",true);
        $("#permintaanpembelian-form .dtPicker3").attr("readonly",true);
        $("#permintaanpembelian-form .add-on").remove();
        
        $("input, select, textarea").attr("disabled",true);
        
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }

    // Notifikasi Dokter
    <?php 
        if(isset($_GET['smspemohon'])){
            if($_GET['smspemohon']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PEMOHON', isinotifikasi:'sdr. <?php echo $modPermohonanOa->pemohon_nama; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
    
});
</script>