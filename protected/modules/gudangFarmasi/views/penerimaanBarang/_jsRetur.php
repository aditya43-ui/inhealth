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
</script>