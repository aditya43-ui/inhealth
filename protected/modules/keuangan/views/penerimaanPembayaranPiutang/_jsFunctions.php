<script type="text/javascript">
function loadDataPemabayaran(){
    $("#table-setoran > div").addClass("animation-loading");
    var tgl_awal = $('#<?php echo CHtml::activeId($model, 'tgl_awal'); ?>').val();
    var tgl_akhir = $('#<?php echo CHtml::activeId($model, 'tgl_akhir') ?>').val();
    var jenispembayaran_id = $('#<?php echo CHtml::activeId($model, 'jenispembayaran_id') ?>').val();
    var bank_id = $('#<?php echo CHtml::activeId($model, 'bank_id') ?>').val();
     if(!$("#bankDiv").is(":visible")){
        bank_id = "visible";
     }
    $('#table-setoran > tbody').html("");

    if(tgl_awal !== "" && tgl_akhir !== "" && jenispembayaran_id !== "" && bank_id !== ""){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetFromPembayaranPiutang'); ?>',
            data: $('#penerimaanpembayaranpiutang-src-form').serialize(),
            dataType: "json",
            success:function(data){
                if(data.pesan != ''){
                    myAlert(data.pesan);
                }
                $('#table-setoran > tbody').html(data.form);

                renameInput($("#table-setoran"));
                hitungTotal();
                formatNumberSemua();
                keteranganPembayaran();
                $("#table-setoran > div").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak ditemukan!");}
        });
    }else{
        myAlert("Pencarian bertanda <span class='required'>*</span> harus diisi!");
    }

}

function changePilihAll(obj){
  if($(obj).is(":checked")){
    $('#table-setoran > tbody').find('tr').each(function(){
        $(this).find('.checklist').attr('checked',true);
        setNol($(this).find('.checklist'));
    });
  }else{
    $('#table-setoran > tbody').find('tr').each(function(){
        $(this).find('.checklist').attr('checked',false);
        setNol($(this).find('.checklist'));
    });
  }
}

function setNol(obj){
  if($(obj).parents('tr').find('.checklist').is(":checked")){
    $(obj).parents('tr').find('input, textarea').not('input[type="checkbox"]').attr('disabled',false);
  }else{
    $(obj).parents('tr').find('input, textarea').not('input[type="checkbox"]').attr('disabled',true);
  }
    hitungTotal();
}

function renameInput(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
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

}

function hitungTotal() {
     unformatNumberSemua();
    var totalTagihan = 0;
    var totalBayar = 0;
    var totalsisahutang = 0;
    var totalbiayaadm = 0;
    var totalbiayamaterai = 0;
    var totalpenerimaan = 0;

    $("#table-setoran").find("tbody > tr").each(function () {
        if ($(this).find(".checklist").is(":checked")){
          var totHutUsaha = parseFloat($(this).find('input[name$="[jumlahpembayaran]"]').val());
          var totBayar = parseFloat($(this).find('input[name$="[jmldibayarkan]"]').val());
          var biayaadministrasi = parseFloat($(this).find('input[name$="[biayaadministrasi]"]').val());
          var biaya_materai = parseFloat($(this).find('input[name$="[biaya_materai]"]').val());
          var jmlpenerimaan = parseFloat($(this).find('input[name$="[jmlpenerimaan]"]').val());

            var sisa = totHutUsaha - totBayar;
            $(this).find('input[name$="[sisahutang]"]').val(sisa);
            totalTagihan += totHutUsaha;
            totalBayar += totBayar;
            totalsisahutang += parseFloat($(this).find('input[name$="[sisahutang]"]').val());
            totalbiayaadm += biayaadministrasi;
            totalbiayamaterai += biaya_materai;
            totalpenerimaan += jmlpenerimaan;
        }
    });

    $("#<?php echo CHtml::activeId($model, 'totalpiutang') ?>").val(totalTagihan);
    $("#<?php echo CHtml::activeId($model, 'totalbayar') ?>").val(totalBayar);
    $("#<?php echo CHtml::activeId($model, 'totalsisapiutang') ?>").val(totalsisahutang);
    $("#<?php echo CHtml::activeId($modBuktiBayar, 'biayaadministrasi') ?>").val(totalbiayaadm);
    $("#<?php echo CHtml::activeId($modBuktiBayar, 'biayamaterai') ?>").val(totalbiayamaterai);

    formatNumberSemua();
    hitungKasKeluar();
}

function hitungKasKeluar()
{
    unformatNumberSemua();
    var jmlBayar = parseFloat($("#<?php echo CHtml::activeId($model, 'totalbayar') ?>").val());
    var biayaadministrasi = parseFloat($("#<?php echo CHtml::activeId($modBuktiBayar, 'biayaadministrasi') ?>").val());
    var biayaongkos_kirim = parseFloat($("#<?php echo CHtml::activeId($modBuktiBayar, 'biayamaterai') ?>").val());
    var totaltagihan = parseFloat($("#<?php echo CHtml::activeId($model, 'totalpiutang') ?>").val());

    var kasKeluar = jmlBayar - biayaadministrasi - biayaongkos_kirim;
    if (kasKeluar > 0){
        kasKeluar = parseFloat(kasKeluar.toFixed(2));
    }
    var sisahutang = (totaltagihan - jmlBayar);
    if (sisahutang > 0){
        sisahutang = parseFloat(sisahutang.toFixed(2));
    }
    // $("#<?php //echo CHtml::activeId($modBuktiBayar, 'uangditerima') ?>").val(totalpenerimaan);
    $("#<?php echo CHtml::activeId($modBuktiBayar, 'uangditerima') ?>").val(kasKeluar);
    $("#<?php echo CHtml::activeId($model, 'totalsisapiutang') ?>").val(sisahutang);

    formatNumberSemua();
}

function hitungsisa(obj)
{
    unformatNumberSemua();
    var jmldibayarkan = parseFloat($(obj).parents('tr').find('input[name$="[jmldibayarkan]"]').val());
    var totalhutangusaha = parseFloat($(obj).parents('tr').find('input[name$="[jumlahpembayaran]"]').val());
    var biayaadministrasi = parseFloat($(obj).parents('tr').find('input[name$="[biayaadministrasi]"]').val());
    var biaya_materai = parseFloat($(obj).parents('tr').find('input[name$="[biaya_materai]"]').val());

    if(jmldibayarkan > totalhutangusaha){
        myAlert('Jumlah Yang Dibayarkan tidak boleh melebihi Jumlah Piutang');
        $(obj).parents('tr').find('input[name$="[jmldibayarkan]"]').val(0);
        jmlsetoran = 0;
    }

    var sisa = totalhutangusaha - jmldibayarkan;
    var jmlpenerimaan = (jmldibayarkan - biayaadministrasi - biaya_materai);
    $(obj).parents('tr').find('input[name$="[sisahutang]"]').val(sisa);
    $(obj).parents('tr').find('input[name$="[jmlpenerimaan]"]').val(jmlpenerimaan);
    formatNumberSemua();
    hitungTotal();
}

function hitungPlorate(obj){
    unformatNumberSemua();
    var valuePlorate = parseFloat($(obj).val());
    var totalhutang = parseFloat($("#<?php echo CHtml::activeId($model, 'totalpiutang') ?>").val());
    var checkdata = false;

    if(valuePlorate > totalhutang){
         myAlert('Total yang dibayarkan tidak boleh melebihi nilai total Piutang');
         $("#table-setoran").find("tbody > tr").each(function () {
             $(this).find('input[name*="[jmldibayarkan]"]').val(0);
         });
         $("#<?php echo CHtml::activeId($model, 'totalbayar') ?>").val(0);
        checkdata = true;
    }

    if(checkdata===false){
        var totalBayar = 0;
        var totalTagihan = 0;
        $("#table-setoran").find("tbody > tr").each(function () {
            if ($(this).find(".checklist").is(":checked")){
                var pajak = parseFloat($(this).find('input[name*="[jumlahpembayaran]"]').val());
                var hitung = ((valuePlorate / totalhutang) *pajak);

                if (hitung > 0){
                    hitung = parseFloat(hitung.toFixed(2));
                }
                var perngurangan = (pajak - hitung);
                $(this).find('input[name*="[jmldibayarkan]"]').val(hitung);
                $(this).find('input[name*="[sisahutang]"]').val(perngurangan);
                totalBayar += hitung;
                totalTagihan += parseFloat($(this).find('input[name*="[jumlahpembayaran]"]').val());
            }else{
              $(this).find('input[name*="[jmldibayarkan]"]').val(0);
              $(this).find('input[name*="[sisahutang]"]').val(0);
            }
        });
        $("#<?php echo CHtml::activeId($model, 'totalpiutang') ?>").val(totalTagihan);
        $("#<?php echo CHtml::activeId($model, 'totalbayar') ?>").val(totalBayar);
    }
    formatNumberSemua();

    hitungKasKeluar();
}

function formCarabayar(carabayar)
{
    if(carabayar == 'TRANSFER'){
        $('#divCaraBayarTransfer').slideDown();
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'bank_id') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'bank_nama') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'nokartu') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'nostrukkartu') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'norekpenerima') ?>").attr('disabled',false);
    } else {
        $('#divCaraBayarTransfer').slideUp();
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'bank_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'bank_nama') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'nokartu') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'nostrukkartu') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'norekpenerima') ?>").val('');

        $("#<?php echo CHtml::activeId($modBuktiBayar, 'bank_id') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'bank_nama') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'nokartu') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'nostrukkartu') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'norekpenerima') ?>").attr('disabled',true);
    }
    cekDisabled();
}

function keteranganPembayaran(){
    var valueJenisPemb = "";
    var valueBank = "";

    if($("#<?php echo CHtml::activeId($model, 'jenispembayaran_id') ?>").val() != ''){
      valueJenisPemb = $("#<?php echo CHtml::activeId($model, 'jenispembayaran_id') ?>").find('option:selected').text();
    }

    if($("#<?php echo CHtml::activeId($model, 'bank_id') ?>").val() != ''){
      valueBank = $("#<?php echo CHtml::activeId($model, 'bank_id') ?>").find('option:selected').text();
    }
    var no_pembayaran = $("#<?php echo CHtml::activeId($model, 'nopembayaran') ?>").val();

    $("#<?php echo CHtml::activeId($modBuktiBayar, 'sebagaipembayaran_bkm') ?>").val("Pembayaran Piutang "+valueJenisPemb + ' '+ valueBank +' - '+no_pembayaran);
}

function print()
{
    var tandabuktibayar_id = "<?php echo isset($_GET['tandabuktibayar_id']) ? $_GET['tandabuktibayar_id'] : null; ?>";
    window.open("<?php echo $this->createUrl('print') ?>&id=" + tandabuktibayar_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
}

function simpanData(){
    if(requiredCheck($('#penerimaanpembayaranpiutang-t-form'))){
        var jml = $('#table-setoran tbody tr').find("input[name$='[checklist]']").length;
        if(jml < 1){
            myAlert('Silakan pilih tabel pembayaran piutang bank dan pembayaran digital terlebih dahulu!');
            return false;
        }
        else{
             $('#table-setoran').find("tbody > tr").each(function(){
                  if(!$(this).find(".checklist").is(":checked")){
                      $(this).find('input,select,textarea').each(function(){
                          $(this).attr('disabled', true);
                      });
                  }
             });

             var row = 0;
                $('#table-setoran').find("tbody > tr").each(function(){
                     if($(this).find(".checklist").is(":checked")){
                        $(this).find('input,select,textarea').each(function(){ //element <input>
                            var old_name = $(this).attr("name").replace(/]/g,"");
                            var old_name_arr = old_name.split("[");
                            if(old_name_arr.length == 3){
                                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                            }
                        });
                        row++;
                     }
                });
                $(".integer, .float, .integer-decimal").each(function(){
                    $(this).val(unformatNumber($(this).val()));
                });
            $('#penerimaanpembayaranpiutang-t-form').submit();
        }
    }
    return false;
}

function setKodeAkunBank() {
    var data = $("#<?php echo CHtml::activeId($modBuktiBayar, 'bank_id'); ?> :selected").data('rekening');
    var dataRek = $("#<?php echo CHtml::activeId($modBuktiBayar, 'bank_id'); ?> :selected").data('norek');

    if(dataRek != undefined && dataRek != ''){
        $("#<?php echo CHtml::activeId($modBuktiBayar, 'norekpenerima') ?>").val(dataRek);
    }
}

function setJnsPembayar() {
    var dataBank = $("#<?php echo CHtml::activeId($model, 'jenispembayaran_id'); ?> :selected").data('bankpenerima');

    if(dataBank != undefined && dataBank != ''){
        $('#bankDiv').show();
    }else{
      $('#bankDiv').hide();
    }
}

$(document).ready(function(){
    formCarabayar($('#<?php  echo CHtml::activeId($modBuktiBayar, 'carapembayaran'); ?>').val());
    hitungTotal();
});
</script>
