<?php
$pembulatanHarga = Yii::app()->user->getState('pembulatanharga');
?>
<script type="text/javascript">
function getDataRekening()
{
    var penjamin_id = $("#<?php echo CHtml::activeId($modPendaftaran,'penjamin_id') ?>").val();
    var carapembayaran = $("#BKPembayaranklaimT_pembayaranmelalui").val();
    var bank_id = $("#TandabuktibayarT_bank_id").val();
    var biaya_administrasi = parseFloat(unformatNumber($('#<?php echo CHtml::activeId($modPembayaranKlaim,'biaya_administrasi') ?>').val()));

    if(penjamin_id != ""){
      $("#tblInputRekening > tbody").html("");
         $.post('<?php echo $this->createUrl('getDataRekeningByJnsPenerimaan'); ?>', {
             carapembayaran: carapembayaran,
             bank_id: bank_id,
             penjamin_id: penjamin_id,
             biaya_administrasi: biaya_administrasi
         },
         function (data) {
             if (data != null) {
                 $("#tblInputRekening > tbody").html(data.replace());
                 renameRowRekening();
                 hitungTotalAll();
             }
         }, "json");
    }
}

function renameRowRekening()
{
    var idx = 0;
    $("#tblInputRekening > tbody").find('tr').each(
        function()
        {
            $(this).find('input').each(
                function()
                {
                    var name_field = $(this).attr('name');
                    var id_field = $(this).attr('id');
                    $(this).attr('name', name_field.replace('99', idx));
                    $(this).attr('id', id_field.replace('99', idx));

                }
            );
            idx++;
        }
    );
}

function enableInputPembayaran(){
	if($('#BKPembayaranklaimT_pembayaranmelalui').val() == "TRANSFER"){
    $('#divDenganTransfer').removeClass('hide');
    $("#<?php echo CHtml::activeId($modPembayaranKlaim,'nobuktisetor'); ?>").addClass('required').prop("disabled", false);
    // $("#<?php //echo CHtml::activeId($modPembayaranKlaim,'alamatpenyetor'); ?>").prop("disabled", false);
    $("#<?php echo CHtml::activeId($modPembayaranKlaim,'namabank'); ?>").addClass('required').prop("disabled", false);
    $("#<?php echo CHtml::activeId($modPembayaranKlaim,'norekbank'); ?>").addClass('required').prop("disabled", false);
	}else{
    $('#divDenganTransfer').addClass('hide');
    $("#<?php echo CHtml::activeId($modPembayaranKlaim,'nobuktisetor'); ?>").removeClass('required').prop("disabled", true);
    // $("#<?php //echo CHtml::activeId($modPembayaranKlaim,'alamatpenyetor'); ?>").prop("disabled", true);
    $("#<?php echo CHtml::activeId($modPembayaranKlaim,'namabank'); ?>").removeClass('required').prop("disabled", true);
    $("#<?php echo CHtml::activeId($modPembayaranKlaim,'norekbank'); ?>").removeClass('required').prop("disabled", true);
    reset();
	}
    getDataRekening();
}

function reset(){
    $("#<?php echo CHtml::activeId($modPembayaranKlaim,'nobuktisetor'); ?>").val('');
    $("#<?php echo CHtml::activeId($modPembayaranKlaim,'alamatpenyetor'); ?>").val('');
    $("#<?php echo CHtml::activeId($modPembayaranKlaim,'namabank'); ?>").val('');
    $("#<?php echo CHtml::activeId($modPembayaranKlaim,'norekbank'); ?>").val('');
}

function hitungPembayaran()
{
    $('#tableList').find('input[name$="[pembayaranpelayanan_id]"]').each(function(){
        hitungTotalPembayaran(this);
    });
    hitungJmlPembayaran();
}

function hitungTotalPembayaran(obj)
{
    var pembayaranpelayanan_id = unformatNumber(obj.value);
    var jmlTagihan = unformatNumber($(obj).parents('tr').find('input[name$="[jmltagihan]"]').val());
    var jmlPiutang = unformatNumber($(obj).parents('tr').find('input[name$="[jmlpiutang]"]').val());
    var jmlTelahBayar = unformatNumber($(obj).parents('tr').find('input[name$="[jmltelahbayar]"]').val());
    var jmlBayar = unformatNumber($(obj).parents('tr').find('input[name$="[jmlBayar]"]').val());
    var JmlSisaTagihan = unformatNumber($(obj).parents('tr').find('input[name$="[jmlsisatagihan]"]').val());

    var totTagihan = 0;
    $(obj).parents('table').find(':checkbox:checked').each(function(){
        $(this).parents('tr').find('input[name$="[jmltagihan]"]').each(function(){
            totTagihan = totTagihan + unformatNumber(this.value);
        });
    });
    $('#tottagihan').val(formatInteger(totTagihan));

    var totPiutang = 0;
    $(obj).parents('table').find(':checkbox:checked').each(function(){
        $(this).parents('tr').find('input[name$="[jmlpiutang]"]').each(function(){
            totPiutang = totPiutang + unformatNumber(this.value);
        });
    });
    $('#totpiutang').val(formatInteger(totPiutang));
    $('#BKPembayaranklaimT_totalpiutang').val(formatInteger(totPiutang));

    var totTelahBayar = 0;
    $(obj).parents('table').find(':checkbox:checked').each(function(){
        $(this).parents('tr').find('input[name$="[jmltelahbayar]"]').each(function(){
            totTelahBayar = totTelahBayar + unformatNumber(this.value);
        });
    });
    $('#tottelahbayar').val(formatInteger(totTelahBayar));

    var totBayar = 0;
    $(obj).parents('table').find(':checkbox:checked').each(function(){
        $(this).parents('tr').find('input[name$="[jmlbayar]"]').each(function(){
            totBayar = totBayar + unformatNumber(this.value);
        });
    });
    $('#totbayar').val(formatInteger(totBayar));

    var totSisaTagihan = 0;
    $(obj).parents('table').find(':checkbox:checked').each(function(){
        $(this).parents('tr').find('input[name$="[jmlsisatagihan]"]').each(function(){
            totSisaTagihan = totSisaTagihan + unformatNumber(this.value);
        });
    });
    $('#totsisatagihan').val(formatInteger(totSisaTagihan));

}

function hitungJmlPembayaran()
{
    var totalPiutang = unformatNumber($('#totpiutang').val());
    var totalTelahBayar = unformatNumber($('#BKPembayaranklaimT_telahbayar').val());
    var totalBayar = unformatNumber($('#BKPembayaranklaimT_totalbayar').val());
    var totalSisaPiutang = unformatNumber($('#BKPembayaranklaimT_totalsisapiutang').val());

    totpiutang = totalPiutang;
    $('#BKPembayaranklaimT_totalpiutang').val(totpiutang);

}

function cekInputTindakan()
{
    jumlahPilihan = $(".cek:checked").length;
    if (jumlahPilihan < 1){
        myAlert('Tidak Ada Transaksi Pembayaran');
        return false;
    }

    if ($("#BKPembayaranklaimT_pembayaranmelalui").val() == ''){
        myAlert('Cara Pembayaran Belum Diisi');
        return false;
    }

    if($('#BKPembayaranklaimT_pembayaranmelalui').val() == "TRANSFER"){
        var is_kosong = false;
        $("#divDenganTransfer input").each(function() {
            if ($(this).val() == "" && $(this).parents(".control-group").find(".required").length > 0) {
                is_kosong = true;
            }
        });
        if (is_kosong) {
            myAlert("Input yang ditandai * harus diisi");
        }
    }

    if($('#tottagihan').val() <=0 ){
        myAlert('Tidak ada Tagihan');
        return false;
    } else {
      $(".integer, .float, .integer-decimal").each(function(){
          $(this).val(unformatNumber($(this).val()));
      });
        return true;
    }
    $(".integer, .float, .integer-decimal").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });
    return false;
}

function hitungTotalBayar(obj){
    totalBayar = 0;
    totJmlBayar = 0;

    totalBayar = unformatNumber($('#BKPembayaranklaimT_totalbayar').val());

     $('#tableList tbody .cek').each(function(){
        var totTagihan = unformatNumber($('#tottagihan').val());
        var totPiutang = unformatNumber($('#totpiutang').val());
        var totTelahBayar = unformatNumber($('#tottelahbayar').val());
        var totBayar = unformatNumber($('#totbayar').val());
        var totSisaTagihan = unformatNumber($('#totsisatagihan').val());

        totJmlBayar = 0;
        totJmlSisaTagihan = 0;

        $('.cek').each(function(){

                var jmlTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltagihan]"]').val()));
                var jmlPiutang = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlpiutang]"]').val()));
                var jmlTelahBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltelahbayar]"]').val()));
                var jmlBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlbayar]"]').val()));
                var jmlSisaTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlsisatagihan]"]').val()));

                var totalJumlahBayar = unformatNumber($(this).parents('tr').find('.jmlbayar').val());
                var totalJumlahSisaTagihan = unformatNumber($(this).parents('tr').find('.jmlsisatagihan').val());


                jmlSisaTagihan = 0;

                jumlahBayar = Math.ceil(((jmlPiutang - jmlTelahBayar) / (totPiutang) * (totalBayar)).toFixed(2));

                pembulatan = (jumlahBayar) % <?php echo $pembulatanHarga; ?>;

                jmlPembulatan = <?php echo $pembulatanHarga; ?> - pembulatan;
                if (jQuery.isNumeric(jmlPembulatan)){
                    if (jmlPembulatan >= <?php echo $pembulatanHarga; ?>){
                        jmlPembulatan = 0;
                    }
                }

                if (jQuery.isNumeric(totalJumlahBayar)){
                    totJmlBayar += parseFloat(unformatNumber(totalJumlahBayar));
                }
                if (jQuery.isNumeric(totalJumlahSisaTagihan)){
                    totJmlSisaTagihan += parseFloat(unformatNumber(totalJumlahSisaTagihan));
                }

                if(jmlBayar > jmlPiutang){
                    if(jmlSisaTagihan > 0 ){
                        jumlahSisaTagihan = 0;
                    }else{
                        jumlahSisaTagihan = (jmlBayar - (jmlPiutang - jmlTelahBayar));
                    }
                }else{
                    jmlSisaTagihan = ((jmlPiutang - jmlTelahBayar) - jmlBayar);
                }

            $(this).parents("tr").find('input[name$="[jmlbayar]"]').val(formatInteger(jumlahBayar + jmlPembulatan));
            $(this).parents("tr").find('input[name$="[jmlsisatagihan]"]').val(formatInteger(jmlSisaTagihan));
            $('#totbayar').val(formatInteger(totJmlBayar));
            $('#totsisatagihan').val(formatInteger(totJmlSisaTagihan));
        });
    });
}

function checkAllPembayaran() {
    if ($("#checkPembayaran").is(":checked")) {
        $('#tableList input[name*="cekList"]').each(function(){
           $(this).attr('checked',true);
        })
    } else {
       $('#tableList input[name*="cekList"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
    $('#tableList input[name*="cekList"]').each(function(){
        setNol($(this));
   });
}

function print()
{
    var pembayarklaim_id = "<?php echo isset($modPembayaranKlaim->pembayarklaim_id)?$modPembayaranKlaim->pembayarklaim_id:null; ?>";
    //harusnya menggunakan controller yang sama
    window.open("<?php echo $this->createUrl('print') ?>&pembayarklaim_id="+pembayarklaim_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
}

function removeDataRekening(obj)
{
    $(obj).parent().parent('tr').detach();
}

function setKodeAkunBank() {
    var data = $("#TandabuktibayarT_bank_id :selected").data('rekening');
    $("#kode_akun_bank").val(data);
    getDataRekening();
}

function hitungTotalAll(){
  unformatNumberSemua();
  var totaltagihan = 0;
  var totalDiskon = 0;
  var totalPiutang = 0;
  var totalJumlahTelahBayar = 0;
  var totalBayar = 0;
  var totalSisaTagihan = 0;

  $("#tableList").find("tbody > tr").each(function () {
      if ($(this).find(".cek").is(":checked")){
          var jmltagihan = parseFloat($(this).find('input[name*="[jmltagihan]"]').val());
          var jmldiskon = parseFloat($(this).find('input[name*="[jmldiskon]"]').val());
          var jmlpiutang = parseFloat($(this).find('input[name*="[jmlpiutang]"]').val());
          var jmltelahbayar = parseFloat($(this).find('input[name*="[jmltelahbayar]"]').val());
          var jumlahbayar = parseFloat($(this).find('input[name*="[jumlahbayar]"]').val());

          var sisatagihan = (jmlpiutang - (jmltelahbayar + jumlahbayar));

          $(this).find('input[name*="[jmlsisapiutang]"]').val(sisatagihan);

          totaltagihan += jmltagihan;
          totalDiskon += jmldiskon;
          totalPiutang += jmlpiutang;
          totalJumlahTelahBayar += jmltelahbayar;
          totalBayar += jumlahbayar;
          totalSisaTagihan += sisatagihan;
      }
  });
  $('#tottagihan').val(totaltagihan);
  $('#totdiskon').val(totalDiskon);
  $('#totpiutang').val(totalPiutang);
  $('#tottelahbayar').val(totalJumlahTelahBayar);
  $('#totbayar').val(totalBayar);
  $('#totsisatagihan').val(totalSisaTagihan);

  $('#txt_totaltagihan').val(totaltagihan);
  $('#<?php echo CHtml::activeId($modPembayaranKlaim,'totaldiskon') ?>').val(totalDiskon);
  $('#<?php echo CHtml::activeId($modPembayaranKlaim,'totalpiutang') ?>').val(totalPiutang);
  $('#<?php echo CHtml::activeId($modPembayaranKlaim,'telahbayar') ?>').val(totalJumlahTelahBayar);
  $('#<?php echo CHtml::activeId($modPembayaranKlaim,'totalbayar') ?>').val(totalBayar);

  formatNumberSemua();
  hitungKasKeluar();
}

function hitungKasKeluar(){
  unformatNumberSemua();
  var totalbayar = parseFloat($('#<?php echo CHtml::activeId($modPembayaranKlaim,'totalbayar') ?>').val());
  var biaya_administrasi = parseFloat($('#<?php echo CHtml::activeId($modPembayaranKlaim,'biaya_administrasi') ?>').val());
  var totaltagihan = parseFloat($('#txt_totaltagihan').val());
  var totalpiutang = parseFloat($('#BKPembayaranklaimT_totalpiutang').val());
  var telahbayar = parseFloat($('#BKPembayaranklaimT_telahbayar').val());

  var totalpenerimaan = (totalbayar + biaya_administrasi);
  var sisatagihan = (totalpiutang - (totalbayar + telahbayar));
  $('#<?php echo CHtml::activeId($modPembayaranKlaim,'totalpenerimaan') ?>').val(totalpenerimaan);
  $('#<?php echo CHtml::activeId($modPembayaranKlaim,'totalsisapiutang') ?>').val(sisatagihan);

  $('.tr_debit').val(totalbayar);
  $('.tr_administrasi').val(biaya_administrasi);
  $('.tr_kredit').val(totalpenerimaan);
  formatNumberSemua();
}

function hitungAdministrasi(){
  hitungKasKeluar();
  getDataRekening();
}
function setAll(){

    jmltagihan = 0;
    jmlpiutang = 0;
    jmltelahbayar = 0;
    jmlbayar = 0;
    jmlsisatagihan = 0;

    jmltotpiutang = 0;
    jmltotbayar = 0;
    jmltottelahbayar = 0;
    jmltotsisapiutang = 0;

    totaltransaksi = 0;

    jmldiskon = 0;

    $('.cek').each(function(){
       if ($(this).is(':checked')){
            temptagihan = unformatNumber($(this).parents('tr').find('.jmltagihan').val());
            temppiutang = unformatNumber($(this).parents('tr').find('.jmlpiutang').val());
            temptelahbayar = unformatNumber($(this).parents('tr').find('.jmltelahbayar').val());
            tempbayar = unformatNumber($(this).parents('tr').find('.jmlbayar').val());
            tempsisatagihan = unformatNumber($(this).parents('tr').find('.jmlsisatagihan').val());
            diskon = parseFloat(unformatNumber($(this).parents('tr').find('.diskon').val()));

            temptotaltransaksi = $(this).parents('tr').find('.totaltransaksi').val();
            totalbayar = parseFloat(unformatNumber($('#REClosingkasirT_nilaiclosingtrans').val()));
            saldoawal = parseFloat($('#REClosingkasirT_closingsaldoawal').val());
            totalnilaiclosing =$('#totalnilaiclosing').val();

            jmlnilaiclosing = totalbayar + saldoawal;

            if (jQuery.isNumeric(temptagihan)){
                jmltagihan += parseFloat(unformatNumber(temptagihan));
            }
            if (jQuery.isNumeric(temppiutang)){
                jmlpiutang += parseFloat(unformatNumber(temppiutang));
            }
            if (jQuery.isNumeric(temptelahbayar)){
                jmltelahbayar += parseFloat(unformatNumber(temptelahbayar));
            }
            if (jQuery.isNumeric(tempbayar)){
                jmlbayar += parseFloat(unformatNumber(tempbayar));
            }
            if (jQuery.isNumeric(tempsisatagihan)){
                jmlsisatagihan += parseFloat(unformatNumber(tempsisatagihan));
            }
            if (jQuery.isNumeric(diskon)){
                jmldiskon += diskon;
            }
             $(this).parents('tr').find('.cek').val(1);
        }else{
            $(this).parents('tr').find('.cek').val(0);
        }
    });

    $('#BKPembayaranklaimT_totalpiutang').val(formatInteger(jmlpiutang));
    $('#BKPembayaranklaimT_telahbayar').val(formatInteger(jmltelahbayar));
    $('#BKPembayaranklaimT_totalbayar').val(formatInteger(jmlbayar));
    $('#BKPembayaranklaimT_totalsisapiutang').val(formatInteger(jmlsisatagihan));

    $('#tottagihan, #txt_totaltagihan').val(formatNumber(jmltagihan));
    $('#totpiutang').val(formatNumber(jmlpiutang));
    $('#totdiskon, #BKPembayaranklaimT_totaldiskon').val(formatNumber(jmldiskon));
    $('#tottelahbayar').val(formatNumber(jmltelahbayar));
    $('#totbayar').val(formatNumber(jmlbayar));
    $('#totsisatagihan').val(formatNumber(jmlsisatagihan));

    $('.saldodebit').val(formatNumber(jmlbayar));
    $('.saldokredit').val(formatNumber(jmlbayar));

}

function hitungSisaTagihan(){

    var is_lebih = false;

    $('#tableList tbody .cek').each(function(){

        totTagihan = parseFloat(unformatNumber($('#tottagihan').val()));
        totPiutang = parseFloat(unformatNumber($('#totpiutang').val()));
        totTelahBayar = parseFloat(unformatNumber($('#tottelahbayar').val()));
        totBayar = parseFloat(unformatNumber($('#totbayar').val()));
        totSisaTagihan = parseFloat(unformatNumber($('#totsisatagihan').val()));

        jmlTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltagihan]"]').val()));
        jmlPiutang = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlpiutang]"]').val()));
        jmlTelahBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltelahbayar]"]').val()));
        jmlBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlbayar]"]').val()));
        jmlSisaTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlsisatagihan]"]').val()));

        jumlahSisaTagihan = 0;

        if (jmlBayar == 0) {
            $(this).val(0).prop("checked", false);
        }

        if(jmlTelahBayar > jmlPiutang){
//                jumlahSisaTagihan = (jmlBayar - (jmlPiutang - jmlTelahBayar));
              jumlahSisaTagihan = 0;
        }else{
            jumlahSisaTagihan = ((jmlPiutang - jmlTelahBayar) - jmlBayar);
        }

        if (jumlahSisaTagihan < 0) {
            jmlBayar += jumlahSisaTagihan;
            jumlahSisaTagihan = 0;
            is_lebih = true;
            $(this).parents('tr').find('input[name$="[jmlbayar]"]').val(formatNumber(jmlBayar));
        }

        $('.cek').each(function(){
                totalJumlahSisaTagihan = unformatNumber($(this).parents('tr').find('.jmlsisatagihan').val());

                totalJumlahSisaTagihan = 0;
                if (jQuery.isNumeric(totalJumlahSisaTagihan)){
                    totalJumlahSisaTagihan += parseFloat(unformatNumber(totalJumlahSisaTagihan));
                }
        });

        $(this).parents("tr").find('input[name$="[jmlsisatagihan]"]').val(formatNumber(jumlahSisaTagihan));
        $('#totalsisatagihan').val(formatInteger(totalJumlahSisaTagihan));

    });
    setAll(this);
}

function setNol(obj){
    if($(obj).parents('tr').find('.cek').is(":checked")){
        $(obj).parents('tr').find('input[name$="[jumlahbayar]"]').attr('disabled',false);
    }else{
        $(obj).parents('tr').find('input[name$="[jumlahbayar]"]').attr('disabled',true);
    }
    hitungTotalAll();
}

function setCeklisBayarPiutang(obj) {
    var telahbayar = parseFloat(unformatNumber($(obj).parents('tr').find('.jmltelahbayar').val()));
    var jmlpiutang = parseFloat(unformatNumber($(obj).parents('tr').find('.jmlpiutang').val()));

    if (!$(obj).is(':checked')) {
        $(obj).parents('tr').find('.jmlbayar').val(0);
    } else {
        $(obj).parents('tr').find('.jmlbayar').val(formatNumber(jmlpiutang - telahbayar));
    }
    hitungSisaTagihan();
}

function hitungDiskon(){
    $('#tableList tbody .cek').each(function(){
        persenDiskon = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[diskonpersen]"]').val()));
        jmlPiutang = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlpiutang3]"]').val()));
        jmlBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltelahbayar]"]').val()));

        jumlahDis = ((persenDiskon/100)*jmlPiutang);
        totPiutang = (jmlPiutang - jumlahDis);
        jmlBayar = totPiutang - jmlBayar;

        $(this).parents("tr").find('input[name$="[jmldiskon]"]').val(formatNumber(jumlahDis));
        $(this).parents("tr").find('input[name$="[jmlpiutang]"]').val(formatNumber(totPiutang));
        $(this).parents("tr").find('input[name$="[jmlbayar]"]').val(formatNumber(jmlBayar));
    });
        setAll(this);
}

function hitungJumlahPiutang(obj){
     $('#tableList tbody .cek').each(function(){

        totTagihan = unformatNumber($('#tottagihan').val());
        totPiutang = unformatNumber($('#totpiutang').val());
        totTelahBayar = unformatNumber($('#tottelahbayar').val());
        totBayar = unformatNumber($('#totbayar').val());
        totSisaTagihan = unformatNumber($('#totsisatagihan').val());

        jmlTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltagihan]"]').val()));
        jmlPiutang = (obj.value);
        jmlTelahBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltelahbayar]"]').val()));
        jmlBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlbayar]"]').val()));
        jmlSisaTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlsisatagihan]"]').val()));

        $('.cek').each(function(){

                jumlahSisaTagihan = 0;
                if(jmlBayar > jmlPiutang){
                      jumlahSisaTagihan = 0;
                }else{
                    jumlahSisaTagihan = ((jmlPiutang - jmlTelahBayar) - jmlBayar);
                }

                totalJumlahSisaTagihan = 0;
                if (jQuery.isNumeric(totalJumlahSisaTagihan)){
                    totalJumlahSisaTagihan += parseFloat(unformatNumber(jmlSisaTagihan));
                }
        });

        $(obj).parents("tr").find('input[name$="[jmlsisatagihan]"]').val(jumlahSisaTagihan);
        $(this).parents("tr").find('input[name$="[jmlpiutang2]"]').val(jmlPiutang);
        $('#totalsisatagihan').val(formatInteger(totalJumlahSisaTagihan));
    });
    setAll(this);
}

function hitungJumlahTelahBayar(obj){
    $('#tableList tbody .cek').each(function(){

        totTagihan = unformatNumber($('#tottagihan').val());
        totPiutang = unformatNumber($('#totpiutang').val());
        totTelahBayar = unformatNumber($('#tottelahbayar').val());
        totBayar = unformatNumber($('#totbayar').val());
        totSisaTagihan = unformatNumber($('#totsisatagihan').val());

        jmlTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltagihan]"]').val()));
        jmlPiutang = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlpiutang]"]').val()));
        jmlPiutang2 = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlpiutang2]"]').val()));
        jmlTelahBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmltelahbayar]"]').val()));
        jmlBayar = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlbayar]"]').val()));
        jmlSisaTagihan = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[jmlsisatagihan]"]').val()));

        jumlahSisaTagihan = 0;
        if(jmlTelahBayar > jmlPiutang){
//                jumlahSisaTagihan = (jmlBayar - (jmlPiutang2 - jmlTelahBayar));
                 // jumlahPiutang = (jmlPiutang2 - jmlTelahBayar);
              jumlahSisaTagihan = 0;
              jumlahPiutang = 0;
        }else{
            jumlahSisaTagihan2 = ((jmlPiutang2 - jmlTelahBayar) - jmlBayar);
            jumlahSisaTagihan = (jumlahSisaTagihan2 < 0 ? 0 : jumlahSisaTagihan2);
            jumlahPiutang = (jmlPiutang2 - jmlTelahBayar);
        }

        $('.cek').each(function(){
                totalJumlahSisaTagihan = unformatNumber($(this).parents('tr').find('.jmlsisatagihan').val());
                totalJumlahPiutang = unformatNumber($(this).parents('tr').find('.jmlpiutang').val());

                totalJumlahSisaTagihan = 0;
                if (jQuery.isNumeric(totalJumlahSisaTagihan)){
                    totalJumlahSisaTagihan += parseFloat(unformatNumber(totalJumlahSisaTagihan));
                }
        });
            $(this).parents("tr").find('input[name$="[jmlsisatagihan]"]').val(jumlahSisaTagihan);
            $('#totalsisatagihan').val(formatInteger(totalJumlahSisaTagihan));

    });
    setAll(this);
}

function ajaxGetList(){
  var pengajuanklaimpiutang_id = $('#pengajuanklaimpiutang_id').val();

  if(pengajuanklaimpiutang_id == ''){
    //myAlert('Silakan Pilih No. Pengajuan');
    return false;
  }else{
  $('#tableList').addClass('animation-loading');
  $('#tableList tbody').html("");

  $.ajax({
      type:'POST',
      url:'<?php echo $this->createUrl('SetFromPengajuanKlaim'); ?>',
      data: {pengajuanklaimpiutang_id:pengajuanklaimpiutang_id},
      dataType: "json",
      success:function(data){
          if(data.pesan != ''){
              myAlert(data.pesan);
          }
          $('#tableList > tbody').html(data.form);
          checkAllPembayaran();
          enableInputPembayaran();
          $("#BKPembayaranklaimT_bayarke").val(data.bayarke);
          $('#tableList').removeClass('animation-loading');
      },
      error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak ditemukan!"); $('#tableList').removeClass('animation-loading');}
  });

    // $.get('<?php echo $this->createUrl('SetFromPengajuanKlaim'); ?>', {pengajuanklaimpiutang_id:pengajuanklaimpiutang_id},function(data){
    //   $('#tableList tbody').html(data);
    //   $('#tableList').removeClass('animation-loading');
    //   // checkAllPembayaran();
    //   // enableInputPembayaran();
    // });
  }
}

function hitungSemuaTransaksi(){
    $('.cek').each(function(){
                jmltagihan = unformatNumber($(this).parents('tr').find('.jmltagihan').val());
                jmlpiutang = unformatNumber($(this).parents('tr').find('.jmlpiutang').val());
                jmltelahbayar = unformatNumber($(this).parents('tr').find('.jmltelahbayar').val());
                jmlbayar = unformatNumber($(this).parents('tr').find('.jmlbayar').val());
                jmlsisatagihan = unformatNumber($(this).parents('tr').find('.jmlsisatagihan').val());
                jmldiskon = unformatNumber($(this).parents('tr').find('.jmldiskon').val());
                persendiskon = unformatNumber($(this).parents('tr').find('.persendiskon').val());

                if(jmltagihan == ''){
                    jmltagihan = 0;
                }
                if(jmlpiutang == ''){
                    jmlpiutang = 0;
                }
                if(jmltelahbayar == ''){
                    jmltelahbayar = 0;
                }
                if(jmlbayar == ''){
                    jmlbayar = 0;
                }
                if(jmlsisatagihan == ''){
                    jmlsisatagihan = 0;
                }

    });
}

function setPengajuanKlaimPiutang(data) {
    console.log(data);
    
    $('#pengajuanklaimpiutang_id').val(data.pengajuanklaimpiutang_id);
    
    $("#BKPengajuanklaimpiutangT_tglpengajuanklaimanklaim").val(data.tglpengajuanklaimanklaim);
    $("#BKPengajuanklaimpiutangT_nopengajuanklaimanklaim").val(data.nopengajuanklaimanklaim);
    $("#BKPengajuanklaimpiutangT_tgljatuhtempo").val(data.tgljatuhtempo);
    $("#BKPengajuanklaimpiutangT_carabayar_nama").val(data.carabayar_nama);
    $("#BKPengajuanklaimpiutangT_penjamin_nama").val(data.penjamin_nama);
    
    $("#BKPengajuanklaimpiutangT_totaltagihan").val(formatThousandDecimal(data.totaltagihan));
    $("#BKPengajuanklaimpiutangT_totaldiskon").val(formatThousandDecimal(data.totaldiskon));
    $("#BKPengajuanklaimpiutangT_totalpiutang").val(formatThousandDecimal(data.totalpiutang));
    $("#BKPengajuanklaimpiutangT_totalbayar").val(formatThousandDecimal(data.totalbayar));
    $("#BKPengajuanklaimpiutangT_totalsisapiutang").val(formatThousandDecimal(data.totalsisapiutang));
    
    ajaxGetList();
}

$(document).ready(function(){
		ajaxGetList();
});
</script>
