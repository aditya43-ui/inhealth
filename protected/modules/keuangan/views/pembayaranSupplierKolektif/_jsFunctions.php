<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function loadDataFaktur(){
    $("#table-setoran > div").addClass("animation-loading");
    var supplier_id = $('#supplier_id').val();
    var tgl_awal = $('#tgl_awal').val();
    var tgl_akhir = $('#tgl_akhir').val();

    if((tgl_awal !== "" && tgl_akhir != "")  && supplier_id != ""){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetFromFakturPembelian'); ?>',
            data: {tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, supplier_id: supplier_id},
            dataType: "json",
            success:function(data){
                if(data.pesan != ''){
                    myAlert(data.pesan);
                }
                $('#table-setoran > tbody').html(data.form);
                getSebagaiPembayar();
                renameInput($("#table-setoran"));
                hitungTotal();
                formatNumberSemua();
                $("#table-setoran > div").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { myAlert("Data Faktur Pembelian tidak ditemukan!");}
        });
    }else{
        myAlert("Pencarian harus diisi!");
    }

}

function getSebagaiPembayar(){
  var supplier = $('#supplier_nama').val();
  var nosetoran = $('#<?php echo CHtml::activeId($modBuktiKeluar, 'no_setorpajakpembelian') ?>').val();

  $('#<?php echo CHtml::activeId($modBuktiKeluar, 'untukpembayaran') ?>').val('Pembayaran Supplier - '+supplier+' - '+nosetoran);
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
        // $(obj).parents('tr').find('input[name$="[jmlsetoran]"]').attr('disabled',false);
        // $(obj).parents('tr').find('textarea[name$="[keterangan]"]').attr('disabled',false);
    }else{
      $(obj).parents('tr').find('input, textarea').not('input[type="checkbox"]').attr('disabled',true);
        // $(obj).parents('tr').find('input[name$="[jmlsetoran]"]').attr('disabled',true);
        // $(obj).parents('tr').find('textarea[name$="[keterangan]"]').attr('disabled',true);
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
//
function hitungsisa(obj)
{
    unformatNumberSemua();
    var jmldibayarkan = parseFloat($(obj).parents('tr').find('input[name$="[jmldibayarkan]"]').val());
    var totalhutangusaha = parseFloat($(obj).parents('tr').find('input[name$="[totalhutangusaha]"]').val());

    if(jmldibayarkan > totalhutangusaha){
        myAlert('Jumlah Yang Dibayarkan tidak boleh melebihi Total Tagihan');
        $(obj).parents('tr').find('input[name$="[jmldibayarkan]"]').val(0);
        jmlsetoran = 0;
    }

    var sisa = totalhutangusaha - jmldibayarkan;
    $(obj).parents('tr').find('input[name$="[sisahutang]"]').val(sisa);
    formatNumberSemua();
    hitungTotal();
}

function hitungTotal() {
     unformatNumberSemua();
    var totalTagihan = 0;
    var totalBayar = 0;
    var totalsisahutang = 0;

    $("#table-setoran").find("tbody > tr").each(function () {
        if ($(this).find(".checklist").is(":checked")){
          var totHutUsaha = parseFloat($(this).find('input[name$="[totalhutangusaha]"]').val());
          var totBayar = parseFloat($(this).find('input[name$="[jmldibayarkan]"]').val());

            var sisa = totHutUsaha - totBayar;
            $(this).find('input[name$="[sisahutang]"]').val(sisa);
            totalTagihan += totHutUsaha;
            totalBayar += totBayar;
            totalsisahutang += parseFloat($(this).find('input[name$="[sisahutang]"]').val());
        }
    });

    $("#<?php echo CHtml::activeId($model, 'totaltagihan') ?>").val(totalTagihan);
    $("#<?php echo CHtml::activeId($model, 'jmldibayarkan') ?>").val(totalBayar);
    $("#<?php echo CHtml::activeId($model, 'totalsisatagihan') ?>").val(totalsisahutang);
    formatNumberSemua();
    hitungKasKeluar();
}

function hitungKasKeluar()
{
    unformatNumberSemua();
    var jmlBayar = parseFloat($("#<?php echo CHtml::activeId($model, 'jmldibayarkan') ?>").val());
    var biayaadministrasi = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaadministrasi') ?>").val());
    var biayaongkos_kirim = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaongkos_kirim') ?>").val());
    var totaltagihan = parseFloat($("#<?php echo CHtml::activeId($model, 'totaltagihan') ?>").val());

    var kasKeluar = jmlBayar + biayaadministrasi + biayaongkos_kirim;
    if (kasKeluar > 0){
        kasKeluar = parseFloat(kasKeluar.toFixed(2));
    }
    var sisahutang = (totaltagihan - jmlBayar);
    if (sisahutang > 0){
        sisahutang = parseFloat(sisahutang.toFixed(2));
    }

    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar') ?>").val(kasKeluar);
    $("#<?php echo CHtml::activeId($model, 'totalsisatagihan') ?>").val(sisahutang);

    formatNumberSemua();

    // if(jmlBayar > 0 || biaya_materai > 0){
    //     getDataRekDebit();
    // }
}

function formCarabayar(carabayar)
{
    if(carabayar == 'TRANSFER'){
        $('#divCaraBayarTransfer').slideDown();
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").attr('disabled',false);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'norekpenerima') ?>").attr('disabled',false);
        $("#kode_akun_bank").attr('disabled',false);
    } else {
        $('#divCaraBayarTransfer').slideUp();
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").val('');
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'norekpenerima') ?>").val('');
        $("#kode_akun_bank").val("");
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").attr('disabled',true);
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'norekpenerima') ?>").attr('disabled',true);
        $("#kode_akun_bank").attr('disabled',true);
        // getDataRekeningCarabayar();

    }
    cekDisabled();
}

function hitungrekeningNominal(){
    unformatNumberSemua();
    var jmlBayar = parseFloat($("#<?php echo CHtml::activeId($model, 'jmldibayarkan') ?>").val());
    var biaya_materai = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar, 'biaya_materai') ?>").val());
    var jmlkaskeluar = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar') ?>").val());

    $("#tblInputRekening > tbody").find('.trKreditCarabayar').find('.saldokredit').val(jmlkaskeluar);
    $("#tblInputRekening > tbody").find('.trDebitPPh').find('.saldodebit').val(jmlBayar);
    $("#tblInputRekening > tbody").find('.trDebitMaterai').find('.saldodebit').val(biaya_materai);
    formatNumberSemua();

}

function renameRowRekening(obj_table)
{
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
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

function getDataRekeningCarabayar()
{
    var carabayar = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar') ?>").val();
    var bankid = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").val();

    $("#tblInputRekening").find('.trKreditCarabayar').remove();
    $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('AmbilDataRekeningCarabayar'); ?>',
            data: {carabayar: carabayar, bankid:bankid},//
            dataType: "json",
            success:function(data){
                $("#tblInputRekening > tbody").append(data.replace());
                renameRowRekening($("#tblInputRekening"));
                hitungrekeningNominal();

            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function getDataRekDebit()
{
    var jmlBayar = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model, 'jmlpembayaran') ?>").val()));
    var biayamaterai = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modBuktiKeluar, 'biaya_materai') ?>").val()));

    $("#tblInputRekening").find('.trDebitPPh').remove();
    $("#tblInputRekening").find('.trDebitMaterai').remove();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('AmbilDataRekColumn'); ?>',
        data: {jmlBayar: jmlBayar, biayamaterai: biayamaterai},
        dataType: "json",
        success:function(data){
                $("#tblInputRekening > tbody").append(data.replace());
                renameRowRekening($("#tblInputRekening"));
                hitungrekeningNominal();
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function hitungPlorate(obj){
    unformatNumberSemua();
    var valuePlorate = parseFloat($(obj).val());
    var totalhutang = parseFloat($("#<?php echo CHtml::activeId($model, 'totaltagihan') ?>").val());
    var checkdata = false;

    if(valuePlorate > totalhutang){
         myAlert('Jumlah yang dibayarkan tidak boleh melebihi nilai total tagihan');
         $("#table-setoran").find("tbody > tr").each(function () {
             $(this).find('input[name*="[jmldibayarkan]"]').val(0);
         });
         $("#<?php echo CHtml::activeId($model, 'jmlpembayaran') ?>").val(0);
        checkdata = true;
    }

    if(checkdata===false){
        var totalBayar = 0;
        var totalTagihan = 0;
        $("#table-setoran").find("tbody > tr").each(function () {
            if ($(this).find(".checklist").is(":checked")){
                var pajak = parseFloat($(this).find('input[name*="[totalhutangusaha]"]').val());
                var hitung = ((valuePlorate / totalhutang) *pajak);

                if (hitung > 0){
                    hitung = parseFloat(hitung.toFixed(2));
                }
                var perngurangan = (pajak - hitung);
                $(this).find('input[name*="[jmldibayarkan]"]').val(hitung);
                $(this).find('input[name*="[sisahutang]"]').val(perngurangan);
                totalBayar += hitung;
                totalTagihan += parseFloat($(this).find('input[name*="[totalhutangusaha]"]').val());
            }else{
              $(this).find('input[name*="[jmldibayarkan]"]').val(0);
              $(this).find('input[name*="[sisahutang]"]').val(0);
            }
        });
        $("#<?php echo CHtml::activeId($model, 'totaltagihan') ?>").val(totalTagihan);
        $("#<?php echo CHtml::activeId($model, 'jmldibayarkan') ?>").val(totalBayar);
    }
    formatNumberSemua();

    hitungKasKeluar();
}

function print()
{
    var tandabuktikeluar_id = "<?php echo isset($_GET['tandabuktikeluar_id']) ? $_GET['tandabuktikeluar_id'] : null; ?>";
    window.open("<?php echo $this->createUrl('print') ?>&id=" + tandabuktikeluar_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
}

function validasiFaktur(){
    if(requiredCheck($('#pembayaransupplierkolektif-t-form'))){
        var jml = $('#table-setoran tbody tr').find("input[name$='[checklist]']").length;
        if(jml < 1){
            myAlert('Silakan pilih tabel faktur pembelian!');
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
            $('#pembayaransupplierkolektif-t-form').submit();
        }
    }
    return false;
}

function setKodeAkunBank() {
    var data = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id'); ?> :selected").data('rekening');
    var dataRek = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id'); ?> :selected").data('norek');

    if(dataRek != undefined && dataRek != ''){
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val(dataRek);
    }

    if(data != undefined && data != ''){
        $("#kode_akun_bank").val(data);
        getDataRekeningCarabayar();
    }else{
        myAlert("Bank Pengirim Yang Dipilih Belum Memiliki Kode Akun !!!");
    }

}

$(document).ready(function(){
  $('.checkboxAll').attr('checked',false);
    // formCarabayar($('#<?php // echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>').val());
    hitungTotal();
});
</script>
