<script type="text/javascript">
function loadData(){
    $("#table-setoran > div").addClass("animation-loading");
    var periodetahun = $('#tahunperiode').val();
    var jenisgaji = $('#jenisgaji').val();
    $('#table-setoran > tbody').html('');

    if(periodetahun != "" && jenisgaji != ''){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetFromPengajuan'); ?>',
            data: {periodetahun: periodetahun, jenisgaji:jenisgaji},
            dataType: "json",
            success:function(data){
                if(data.pesan != ''){
                    myAlert(data.pesan);
                }
                if(data.form != ''){
                    $('#table-setoran > tbody').html(data.form);
                    renameInput($("#table-setoran"));
                }else{
                  myAlert("Data tidak ditemukan!");
                }
                hitungTotal();
                $("#table-setoran > div").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak ditemukan!");}
        });
    }else{
        myAlert("Tahun Periode dan Jenis Transaksi harus diisi!");
    }

}

function setNol(obj){
  if($(obj).parents('tr').find('.checklist').is(":checked")){
    $(obj).parents('tr').find('input, textarea').not('input[type="checkbox"]').attr('disabled',false);
  }else{
    $(obj).parents('tr').find('input, textarea').not('input[type="checkbox"]').attr('disabled',true);
    $(obj).parents('tr').find('input[name$="[jmldibayarkan]"]').val(0);
    $(obj).parents('tr').find('input[name$="[sisahutang]"]').val(0);
  }

    hitungTotal();
}

function changeJenisTransaksi(){
  var jenistransaksi = $('#jenisgaji').val();

  if(jenistransaksi != ''){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getJenisTransaksi'); ?>',
        data: {jenistransaksi: jenistransaksi},
        dataType: "json",
        success:function(data){
          $('#<?php echo CHtml::activeId($model,'jenisgaji') ?>').val(jenistransaksi);
          $('.jenistransaksi').html(jenistransaksi);
          $('#<?php echo CHtml::activeId($model,'nopembayaran') ?>').val(data);
          $('#<?php echo CHtml::activeId($modBuktiKeluar,'untukpembayaran') ?>').val("Pembayaran "+jenistransaksi+" Pegawai - "+data);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
  }
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

function hitungsisa(obj)
{
    unformatNumberSemua();
    var jmldibayar = parseFloat($(obj).parents('tr').find('input[name$="[jmldibayarkan]"]').val());
    var totalpajak = parseFloat($(obj).parents('tr').find('input[name$="[totalpajak]"]').val());

    if(jmldibayar > totalpajak){
        myAlert('Jumlah Yang Dibayarkan tidak boleh melebihi Total Utang !!');
        $(obj).parents('tr').find('input[name$="[jmldibayarkan]"]').val(0);
        jmldibayar = 0;
    }

    var sisa = totalpajak - jmldibayar;
    $(obj).parents('tr').find('input[name$="[sisahutang]"]').val(sisa);
    formatNumberSemua();
    hitungTotal();
}

function hitungKasKeluar()
{
    unformatNumberSemua();
    var jmlBayar = parseFloat($("#<?php echo CHtml::activeId($model, 'totaldibayarkan') ?>").val());
    var biaya_materai = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar, 'biayaadministrasi') ?>").val());
    var totalhutang = parseFloat($("#<?php echo CHtml::activeId($model, 'totalhutang') ?>").val());

    var kasKeluar = jmlBayar + biaya_materai;
    if (kasKeluar > 0){
        kasKeluar = parseFloat(kasKeluar.toFixed(2));
    }
    var sisahutang = (totalhutang - jmlBayar);
    if (sisahutang > 0){
        sisahutang = parseFloat(sisahutang.toFixed(2));
    }
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'jmlkaskeluar') ?>").val(kasKeluar);
    $("#<?php echo CHtml::activeId($model, 'totalsisahutang') ?>").val(sisahutang);

    formatNumberSemua();
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
          var totHutUsaha = parseFloat($(this).find('input[name$="[totalpajak]"]').val());
          var totBayar = parseFloat($(this).find('input[name$="[jmldibayarkan]"]').val());

          var sisa = totHutUsaha - totBayar;

          $(this).find('input[name$="[jmlsisahutang]"]').val(sisa);
          totalTagihan += totHutUsaha;
          totalBayar += totBayar;
          totalsisahutang += sisa;
        }
    });

    $("#<?php echo CHtml::activeId($model, 'totalhutang') ?>").val(totalTagihan);
    $("#<?php echo CHtml::activeId($model, 'totaldibayarkan') ?>").val(totalBayar);
    $("#<?php echo CHtml::activeId($model, 'totalsisahutang') ?>").val(totalsisahutang);
    formatNumberSemua();
    hitungKasKeluar();
}

function hitungPlorate(obj){
    unformatNumberSemua();
    var valuePlorate = parseFloat($(obj).val());
    var totalhutang = parseFloat($("#<?php echo CHtml::activeId($model, 'totalhutang') ?>").val());
    var checkdata = false;

    if(valuePlorate > totalhutang){
         myAlert('Jumlah Yang Dibayarkan tidak boleh melebihi Total Utang !!');
         $("#table-setoran").find("tbody > tr").each(function () {
             $(this).find('input[name*="[jmldibayarkan]"]').val(0);
         });
         $("#<?php echo CHtml::activeId($model, 'totaldibayarkan') ?>").val(0);
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
                $(this).find('input[name*="[jmldibayarkan]"]').val(hitung);
                $(this).find('input[name*="[jmlsisahutang]"]').val(perngurangan);
                totalBayar += hitung;
                totalTagihan += parseFloat($(this).find('input[name*="[totalpajak]"]').val());
            }
        });
        $("#<?php echo CHtml::activeId($model, 'totalhutang') ?>").val(totalTagihan);
        $("#<?php echo CHtml::activeId($model, 'totaldibayarkan') ?>").val(totalBayar);
    }
    formatNumberSemua();

    hitungKasKeluar();
}

function print()
{
    var tandabuktikeluar_id = "<?php echo isset($_GET['tandabuktikeluar_id']) ? $_GET['tandabuktikeluar_id'] : null; ?>";
    window.open("<?php echo $this->createUrl('print') ?>&id=" + tandabuktikeluar_id + "&caraPrint=PRINT", "", 'location=_new, width=1024px');
}

function simpanPembayaran(){
    if(requiredCheck($('#pembayaranbonusthr-t-form'))){
        var jml = $('#table-setoran tbody tr').find("input[name$='[checklist]']").length;
        if(jml < 1){
            myAlert('Silakan pilih tabel pengajuan '+$('#jenisgaji').val()+' pegawai terlebih dahulu!');
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
            $('#pembayaranbonusthr-t-form').submit();
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
    }else{
        myAlert("Bank Pengirim Yang Dipilih Belum Memiliki Kode Akun !!!");
    }
}

$(document).ready(function(){
    formCarabayar($('#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>').val());
    hitungTotal();
});
</script>
