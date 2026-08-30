<script>
function getDataRekening(params)
{
    $("#tblInputRekening > tbody").find('tr').detach();
    $.post('<?php echo Yii::app()->createUrl('keuangan/penerimaanUmum/GetDataRekeningByJnsPenerimaan'); ?>', {jenispenerimaan_id: params},
    function (data) {
        if (data != null) {
            $("#tblInputRekening > tbody").append(data.replace());
            renameRowRekening();
            setNilaiJurnal();
            // hitungTotalHarga();
        }
    }, "json");
}

function getDataRekeningBatalSupplier()
{
    var tandabuktikeluar_id = $("#<?php echo CHtml::activeId($modBatalBayar,'tandabuktikeluar_id'); ?>").val();
    var bayarkesupplier_id = $("#<?php echo CHtml::activeId($modBatalBayar,'bayarkesupplier_id'); ?>").val();
    var carabayarkeluar = $("#<?php echo CHtml::activeId($modTandabukti, 'carapembayaran'); ?>").val();
    
    var totaltagihan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modBayarSupplier, 'totaltagihan'); ?>").val()));
    var uangditerima = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti, 'uangditerima'); ?>").val()));
    var biayaadministrasi = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti, 'biayaadministrasi'); ?>").val()));
    var biayamaterai = parseFloat(unformatNumber($("#<?php // echo CHtml::activeId($modTandabukti, 'biayamaterai'); ?>").val()));
    
    var bankid = "";
    if ($("#<?php echo CHtml::activeId($modTandabukti, "ispakekartu"); ?>").is(':checked')){
        bankid = $("#<?php echo CHtml::activeId($modTandabukti, 'bank_id'); ?>").val();
    }
    $("#tblInputRekening > tbody").find('tr').detach();
    $.post('<?php echo Yii::app()->createUrl('billingKasir/BatalBayarSupplier/getDataRekeningBatalSupplier'); ?>', {bayarkesupplier_id:bayarkesupplier_id, tandabuktikeluar_id:tandabuktikeluar_id,carabayarkeluar: carabayarkeluar, bankid:bankid,uangditerima:uangditerima,totaltagihan:totaltagihan,biayaadministrasi:biayaadministrasi},
    function (data) {
        if (data != null) {
            $("#tblInputRekening > tbody").append(data.replace());
            renameRowRekening();
//            setNilaiJurnal();
            // hitungTotalHarga();
        }
    }, "json");
}

function setNilaiJurnal() {
    var nilai = parseFloat(unformatNumber($("#TandabuktibayarT_jmlpembayaran").val()));
    
    $("#tblInputRekening .saldodebit, #tblInputRekening .saldokredit").val(formatNumber(nilai));
}

function renameRowRekening()
{
    var idx = 0;
    $("#tblInputRekening > tbody").find('tr').each(
            function ()
            {
                unMaskMoneyInput(this);
                maskMoneyInput(this);
                $(this).find('input').each(
                        function ()
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

function removeDataRekening(obj)
{
    $(obj).parent().parent('tr').detach();
}

function maskMoneyInput(tr)
{
    $(tr).find('input.integer2:text').maskMoney(
            {
                "symbol": "Rp",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ",",
                "thousands": ".",
                "precision": 0
            }
    );
}

function unMaskMoneyInput(tr)
{
    $(tr).find('input.integer2:text').unmaskMoney();
}

function ubahCaraPembayaran(obj)
	{
		if (obj.value == 'CICILAN') {
			$('#TandabuktibayarT_jmlpembayaran').removeAttr('readonly');
		} else {
			$('#TandabuktibayarT_jmlpembayaran').attr('readonly', true);
			hitungJmlBayar();
		}

		if (obj.value == 'TUNAI') {
			hitungJmlBayar();
		}
	}

	function hitungJmlBayar()
	{
		var biayaAdministrasi = unformatNumber($('#TandabuktibayarT_biayaadministrasi').val());
		var biayaMaterai = unformatNumber($('#TandabuktibayarT_biayamaterai').val());
		var totTagihan = unformatNumber($('#totTagihan').val());
		var jmlPembulatan = unformatNumber($('#TandabuktibayarT_jmlpembulatan').val());
		totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai;
		$('#TandabuktibayarT_jmlpembayaran').val(formatNumber(totBayar));
		$('#TandabuktibayarT_uangditerima').val(formatNumber(totBayar));
		hitungKembalian();
	}

	function hitungKembalian()
	{
		var jmlBayar = unformatNumber($('#TandabuktibayarT_jmlpembayaran').val());
		var uangDiterima = unformatNumber($('#TandabuktibayarT_uangditerima').val());
		var uangKembalian = uangDiterima - jmlBayar;
		if (uangKembalian < 0)
		{
			uangKembalian = 0;
		}
		$('#TandabuktibayarT_uangkembalian').val(formatNumber(uangKembalian));

	}



function cekValidasi(obj) {
    
    var nilai = parseFloat(unformatNumber($("#TandabuktibayarT_jmlpembayaran").val()));
    var saldodebit = 0;
    var saldokredit = 0;
    
    if ($("#tblInputRekening tbody tr").length > 0) {
        $("#tblInputRekening .saldodebit").each(function() {
            saldodebit += parseFloat(unformatNumber($(this).val()));
        });
        $("#tblInputRekening .saldokredit").each(function() {
            saldokredit += parseFloat(unformatNumber($(this).val()));
        });

        if (saldodebit != saldokredit) {
            myAlert("Saldo debit dan kredit pada Rekening tidak sama.");
            return false;
        }

        if (saldodebit != nilai) {
            myAlert("Saldo rekening dengan Jumlah Penerimaan tidak sama");
            return false;
        }
    }
    // console.log("OK");
    
    // return false;
    return requiredCheck(obj);
}

function formCarabayar()
{
    if($("#<?php echo CHtml::activeId($modTandabukti, "ispakekartu"); ?>").is(':checked')){
        $("#<?php echo CHtml::activeId($modTandabukti, "ispakekartu"); ?>").val(1);
        $('#divCaraBayarTransfer').show();
    } else {
        $("#<?php echo CHtml::activeId($modTandabukti, "ispakekartu"); ?>").val(0);
        $('#divCaraBayarTransfer').hide();
        $("#<?php echo CHtml::activeId($modTandabukti, 'bank_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modTandabukti, 'denganrekening') ?>").val('');
        $("#<?php echo CHtml::activeId($modTandabukti, 'bank_nama') ?>").val('');
        getDataRekeningBatalSupplier();
    }
}

function setNamaBank(obj){
     var bank = $(obj).val();
     
     if(bank !== ''){
         $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('GetMasterBank'); ?>',
            data: {bank_id: bank},
            dataType: "json",
            success:function(data){			
                $("#<?php echo CHtml::activeId($modTandabukti, 'denganrekening') ?>").val(data.norekening);
                $("#<?php echo CHtml::activeId($modTandabukti, 'bank_nama') ?>").val(data.namabank);
                getDataRekeningBatalSupplier();
            },
            error: function (jqXHR, textStatus, errorThrown) { myAlert("Data Setoran Utang Pajak tidak ditemukan!");}
        });
     }
}

$(document).ready(function() {
    hitungJmlBayar();
    formCarabayar();
});
</script>