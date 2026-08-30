<script type="text/javascript">
function print(caraPrint)
{
    var advancepayment_id = '<?php echo (isset($_GET['advancepayment_id']) ? $_GET['advancepayment_id'] : null); ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&advancepayment_id='+advancepayment_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
function toTitleCase(str) {
  return str.replace(
    /\w\S*/g,
    function(txt) {
      return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    }
  );
}

function simpanDataTransaksi(){
    $('#advancepayment-t-form').submit()
}
// function setJenisTransaksi(obj){
// 	if ($('#AdvancepaymentT_profilrs_id').val() == '') {
// 		myAlert('Pilih dulu klinik');
// 		$('#AdvancepaymentT_jenistransaksi').val('')
// 		return false;
// 	}
// 	if ($(obj).val() == 'ADVANCE PAYMENT') {
// 		generateNoPengajuan('AP',$('#AdvancepaymentT_profilrs_id').val());
// 	}else if ($(obj).val() == 'REQUEST OF PAYMENT') {
// 		generateNoPengajuan('ROP',$('#AdvancepaymentT_profilrs_id').val());
// 	}
//
// 	$('#jenis_transaksi').text(toTitleCase($(obj).val()))
// }

function generateNoPengajuan(kode, klinik){
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GenerateNoPengajuan'); ?>',
        data: {klinik:klinik,kode:kode},
        dataType: "json",
        success:function(data){
            $('#nopengajuan').val(data.no)
			if (kode == 'AP') {
				$('#KUTandabuktikeluarT_untukpembayaran').val('Advance Payment '+'-'+ $('#nopengajuan').val())
			}else if (kode == 'ROP') {
				$('#KUTandabuktikeluarT_untukpembayaran').val('Request Of Payment '+'-'+ $('#nopengajuan').val())

			}
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setKlinik(obj){
    // $('#profilrs_id').val()

      setTimeout(function(){
                $.fn.yiiGridView.update('pegawai-m-grid', {
                    data: {
                        "PegawaiM[profilrs_id]":$(obj).val(),
                    }
                });
    },500);
    generateNoPengajuan('AP',$(obj).val());
    // $('#jenis_transaksi').text(toTitleCase($(obj).val()))
}
function setCaraBayar(obj){
    // console.log($(obj).val())
    if ($(obj).val() == 'TRANSFER') {
        $('#transfer').show();
    }else{
        $('#transfer').hide();
    }
}

function calculate(){
    var jumlahpembayaran = parseFloat(unformatNumber($('#AdvancepaymentT_jmlpembayaran').val()));
    var biayaadmin = parseFloat(unformatNumber($('#KUTandabuktikeluarT_biayaadministrasi').val()));
    var total = 0;
    total = jumlahpembayaran + biayaadmin;

    $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatThousandDecimal(total))
}

function setBank(obj){

    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetBank'); ?>',
        data: {profilrs_id:$(obj).val()},//
        dataType: "json",
        success:function(data){
        //    console.log(data)
           $("#KUTandabuktikeluarT_bank_id").html(data.option);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });

}

// function setNoRek(obj){
//     // console.log('sfsjhdfkjsdfhsjdfh')
// //    $("#KUTandabuktikeluarT_denganrekening").val($(obj).find(':selected').data('norek'));
// //    var data = $("#KUTandabuktikeluarT_bank_id :selected").data('norek');
// //    console.log(data)
// //     $("#KUTandabuktikeluarT_denganrekening").val(data);
// }

$(document).ready(function(){
    $('#transfer').hide();
    // setJenisTransaksi('AP');
    var sukses = "<?php echo isset($_GET['sukses']) ?  1 : 0 ?>"
    if (sukses == 0) {
        $('#AdvancepaymentT_jmlpembayaran').val(formatThousandDecimal(0))
        $('#KUTandabuktikeluarT_biayaadministrasi').val(formatThousandDecimal(0))
        $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatThousandDecimal(0))
    }else{
        $('#AdvancepaymentT_jmlpembayaran').val(formatThousandDecimal($('#AdvancepaymentT_jmlpembayaran').val()))
        $('#KUTandabuktikeluarT_biayaadministrasi').val(formatThousandDecimal($('#KUTandabuktikeluarT_biayaadministrasi').val()))
        $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatThousandDecimal($('#KUTandabuktikeluarT_jmlkaskeluar').val()))
    }

})
</script>
