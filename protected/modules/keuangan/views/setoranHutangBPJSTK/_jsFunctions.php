<script type="text/javascript">
function loadDataFaktur(){
    $("#table-setoran > div").addClass("animation-loading");
    var periodetahun = $('#tahunperiode').val();
    
    if(periodetahun != ""){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetFromHutangPajak'); ?>',
            data: {periodetahun: periodetahun},
            dataType: "json",
            success:function(data){			
                if(data.pesan != ''){
                    myAlert(data.pesan);
                }			
                $('#table-setoran > tbody').html(data.form);

                renameInput($("#table-setoran"));  
                hitungTotal();
                formatNumberSemua();
                $("#table-setoran > div").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { myAlert("Data Setoran Utang Pajak tidak ditemukan!");}
        });
    }else{
        if(periodetahun == ''){
            myAlert("Tahun Periode Gaji harus diisi!");
        }
    }
    
}

function setNol(obj){
    if($(obj).parents('tr').find('.checklist').is(":checked")){
        $(obj).parents('tr').find('input[name$="[jmlsetoran]"]').attr('disabled',false);
        $(obj).parents('tr').find('textarea[name$="[keterangan]"]').attr('disabled',false);
    }else{
        $(obj).parents('tr').find('input[name$="[jmlsetoran]"]').attr('disabled',true);
        $(obj).parents('tr').find('textarea[name$="[keterangan]"]').attr('disabled',true);
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
    var jmlsetoran = parseFloat($(obj).parents('tr').find('input[name$="[jmlsetoran]"]').val());
    var pajakpph = parseFloat($(obj).parents('tr').find('input[name$="[totalpajak]"]').val());
    
    if(jmlsetoran > pajakpph){
        myAlert('Jumlah yang disetorkan tidak boleh melebihi nilai total hutang');
        $(obj).parents('tr').find('input[name$="[jmlsetoran]"]').val(0);
        jmlsetoran = 0;
    }
    
    var sisa = pajakpph - jmlsetoran;
    $(obj).parents('tr').find('input[name$="[sisahutang]"]').val(sisa);
    formatNumberSemua();
    hitungTotal();
}

function hitungKasKeluar()
{
    unformatNumberSemua();
    var jmlBayar = parseFloat($("#<?php echo CHtml::activeId($model, 'jmlpembayaran') ?>").val());
    var biaya_materai = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar, 'biaya_materai') ?>").val());
   
    var kasKeluar = jmlBayar + biaya_materai;
    if (kasKeluar > 0){
        kasKeluar = parseFloat(kasKeluar.toFixed(2));
    }
                
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar') ?>").val(kasKeluar);

    formatNumberSemua();
    
    if(jmlBayar > 0 || biaya_materai > 0){
        getDataRekDebit();
    }
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
        getDataRekeningCarabayar();
        
    }
    cekDisabled();
}

function hitungTotal() {
     unformatNumberSemua();
    var totalTagihan = 0;
    var totalBayar = 0;
    var totalsisahutang = 0;
    
    $("#table-setoran").find("tbody > tr").each(function () {
        if ($(this).find(".checklist").is(":checked")){
            totalTagihan += parseFloat($(this).find('input[name*="[totalpajak]"]').val());
            totalBayar += parseFloat($(this).find('input[name*="[jmlsetoran]"]').val());
            totalsisahutang += parseFloat($(this).find('input[name*="[sisahutang]"]').val());
        }
    });
   
    $("#<?php echo CHtml::activeId($model, 'totalhutang') ?>").val(totalTagihan);
    $("#<?php echo CHtml::activeId($model, 'jmlpembayaran') ?>").val(totalBayar);
    $("#<?php echo CHtml::activeId($model, 'totalsisahutang') ?>").val(totalsisahutang);
    formatNumberSemua();
    hitungKasKeluar();
}
function hitungrekeningNominal(){
    unformatNumberSemua();
    var jmlBayar = parseFloat($("#<?php echo CHtml::activeId($model, 'jmlpembayaran') ?>").val());
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
    var totalhutang = parseFloat($("#<?php echo CHtml::activeId($model, 'totalhutang') ?>").val());
    var checkdata = false;
    
    if(valuePlorate > totalhutang){
         myAlert('Jumlah yang disetorkan tidak boleh melebihi nilai total hutang');
         $("#table-setoran").find("tbody > tr").each(function () {
             $(this).find('input[name*="[jmlsetoran]"]').val(0);
         });
         $("#<?php echo CHtml::activeId($model, 'jmlpembayaran') ?>").val(0);
        checkdata = true;
    }
    
    if(checkdata===false){
        var totalBayar = 0;
        var totalTagihan = 0;
        $("#table-setoran").find("tbody > tr").each(function () {
            if ($(this).find(".checklist").is(":checked")){
                var pajak = parseFloat($(this).find('input[name*="[totalpajak]"]').val());
                var hitung = ((valuePlorate / totalhutang) *pajak);
                
                if (hitung > 0){
                    hitung = parseFloat(hitung.toFixed(2));
                }
                var perngurangan = (pajak - hitung);
                $(this).find('input[name*="[jmlsetoran]"]').val(hitung);
                $(this).find('input[name*="[sisahutang]"]').val(perngurangan);
                totalBayar += hitung;
                totalTagihan += parseFloat($(this).find('input[name*="[totalpajak]"]').val());
            }
        });
        $("#<?php echo CHtml::activeId($model, 'totalhutang') ?>").val(totalTagihan);
        $("#<?php echo CHtml::activeId($model, 'jmlpembayaran') ?>").val(totalBayar);
    }
    formatNumberSemua();
    
    hitungKasKeluar();
}

function print()
{
    var tandabuktikeluar_id = "<?php echo isset($_GET['tandabuktikeluar_id']) ? $_GET['tandabuktikeluar_id'] : null; ?>";
    window.open("<?php echo $this->createUrl('print') ?>&id=" + tandabuktikeluar_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
}
//
function validasiFaktur(){
    if(requiredCheck($('#setoranhutangbpjstk-t-form'))){
        var jml = $('#table-setoran tbody tr').find("input[name$='[checklist]']").length;
        if(jml < 1){
            myAlert('Silakan pilih Tabel Setoran!');
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
            $('#setoranhutangbpjstk-t-form').submit();
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
    formCarabayar($('#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>').val());
    hitungTotal();
});
</script>