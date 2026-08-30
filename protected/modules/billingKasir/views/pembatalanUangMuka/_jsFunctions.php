<script type="text/javascript">


function getDataRekening()
{
    var carabayar = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar') ?>").val();
    var bankid = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id') ?>").val();

    $("#tblInputRekening > tbody").html("");
    $.post('<?php echo $this->createUrl('getRekeningPembatalan');?>', {bankid:bankid, carabayarkeluar: carabayar},
        function(data){
            if(data != null){
                $("#tblInputRekening > tbody").append(data.replace());
                renameRowRekening();
                hitungTotal();
            }
    }, "json");
}

function hitungTotal(){
  unformatNumberSemua();
  var total_keluar = parseFloat($("#<?php echo CHtml::activeId($modBuktiKeluar,'jmlkaskeluar') ?>").val());

  $(".saldodebit, .saldokredit").val(total_keluar);
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
        getDataRekening();

    }
    cekDisabled();
}

function setKodeAkunBank() {
    var data = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id'); ?> :selected").data('rekening');
    var dataRek = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id'); ?> :selected").data('norek');

    if(dataRek != undefined && dataRek != ''){
        $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val(dataRek);
    }

    if(data != undefined && data != ''){
        $("#kode_akun_bank").val(data);
        getDataRekening();
    }else{
        myAlert("Bank Pengirim Yang Dipilih Belum Memiliki Kode Akun !!!");
    }
}



function cekJurnalRekening() {
    var total_keluar = parseFloat(unformatNumber($("#BKTandabuktikeluarT_jmlkaskeluar").val()));
    var saldodebit = 0;
    var saldokredit = 0;
    var reklen = 0;

    $(".saldodebit").each(function() {
        saldodebit += parseFloat(unformatNumber($(this).val()));
        reklen++;
    });
    $(".saldokredit").each(function() {
        saldokredit += parseFloat(unformatNumber($(this).val()));
        reklen++;
    });

    if (saldodebit == 0 && saldokredit == 0 && reklen == 0) return true;

    if (saldodebit - saldokredit != 0) {
        myAlert("Maaf, saldo rekening debit dan kredit tidak sama.");
        return false;
    }

    if (saldodebit != total_keluar) {
        myAlert("Maaf, saldo rekening dengan total kas keluar tidak sama.");
        return false;
    }

    return true;

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

function reset(){
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").val('');
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val('');
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val('');
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val('');
}


function removeDataRekening(obj)
{
    $(obj).parent().parent('tr').detach();
}

// function unMaskMoneyInput(tr)
// {
//     $(tr).find('.integer2:text').unmaskMoney();
// }
//
// function maskMoneyInput(tr)
// {
//     $(tr).find('.integer2:text').maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
// }


function printPembatalan()
{
    var id = '<?php echo (isset($_GET['pembatalanuangmuka_id'])?$_GET['pembatalanuangmuka_id']:"") ?>';
    window.open('<?php echo $this->createUrl('printPembatalan'); ?>&id='+id,'printwin','left=100,top=100,width=800,height=600,scrollbars=1');
}

function reset(){
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'nobukti_transfer') ?>").val('');
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val('');
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val('');
    $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val('');
}


function cekValidasi(){
    if(requiredCheck($('#pembayaran-form'))){
      var totaluangmuka = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modBatal,'total_uangmuka'); ?>").val()));
      var kaskeluar = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modBuktiKeluar,'jmlkaskeluar'); ?>").val()));

      if (kaskeluar > totaluangmuka) {
          myAlert("Jumlah kas keluar melebihi jumlah uang muka.");
          return false;
      }

      if (!cekJurnalRekening()) {
          return false;
      }

      $(".integer, .float, .integer-decimal").each(function(){
          $(this).val(unformatNumber($(this).val()));
      });
      $('#pembayaran-form').submit();

    }
    return false;
}



$(document).ready(function(){
	<?php if(isset($_GET['sukses'])){ ?>
		$("input,textarea,select").attr("disabled",true);
		$("button[type='submit']").attr("disabled",true);
		$("button[type='submit']").removeAttr("onkeypress");
	<?php } ?>

    formCarabayar($("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar') ?>").val());
});
</script>
