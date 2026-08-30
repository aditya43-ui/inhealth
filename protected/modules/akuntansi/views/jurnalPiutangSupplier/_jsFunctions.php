<script type="text/javascript">
function addDetail(){
    $('#jurnalpiutangsupplier-grid').addClass('srbacLoading');
    $('#jurnalpiutangsupplier-grid > table > tbody').html("");
    $("#totalDebit, #totalKredit").val(0);
    var params = $('#jurnalpiutangsupplier-search').serialize();
    
    $.ajax({
        url: "<?php echo $this->createUrl('GetRekeningPiutangSupplier')?>",
        type: "post",
        data: params,
        dataType: "json",
        success: function(data){
            $('#jurnalpiutangsupplier-grid > table > tbody').append(data);
            
            $("#jurnalpiutangsupplier-grid > table > tbody > tr").find('input[name$="[rekDebitKredit]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
                                                                            $(this).val("");
                                                                            return false;
                                                                        },'select':function( event, ui ) {
                                                                            $(this).val(ui.item.value);
                                                                            var data = {
                                                                                rincianobyek_id:ui.item.rincianobyek_id,
                                                                                obyek_id:ui.item.obyek_id,
                                                                                jenis_id:ui.item.jenis_id,
                                                                                kelompok_id:ui.item.kelompok_id,
                                                                                struktur_id:ui.item.struktur_id,
                                                                                nmrincianobyek:ui.item.nmrincianobyek,
                                                                                kdstruktur:ui.item.kdstruktur,
                                                                                kdkelompok:ui.item.kdkelompok,
                                                                                kdjenis:ui.item.kdjenis,
                                                                                kdobyek:ui.item.kdobyek,
                                                                                kdrincianobyek:ui.item.kdrincianobyek,
                                                                                saldodebit:ui.item.saldodebit,
                                                                                saldokredit:ui.item.saldokredit,
                                                                                status:"debit"
                                                                            };
                                                                            var row = $(this).parents("tr").find("#row").val();
                                                                            editDataRekeningFromGrid(data, row);
                                                                            return false;
                                                                        },'source':function(request, response) {
                                                                                        $.ajax({
                                                                                            url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>null));?>",
                                                                                            dataType: "json",
                                                                                            data: {
                                                                                                term: request.term,
                                                                                            },
                                                                                            success: function (data) {
                                                                                                response(data);
                                                                                            }
                                                                                        })
                                                                                    }
                                                                        });  
            $("#jurnalpiutangsupplier-grid > table > tbody > tr").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
            //integer2 agar tidak duakali maskMoney krn bisa error input
            $("#jurnalpiutangsupplier-grid > table > tbody").find('.integer2');
            var last = $("#jurnalpiutangsupplier-grid > table > tbody > tr:last").find('input[name$="[noUrut]"]').val();
            if(last > 499){
                myAlert("Maksimal rekening yang ditampilkan sebanyak 500 data!");
            }
            setTimeout(function(){hitungSemua();},500);
            $('#jurnalpiutangsupplier-grid').removeClass('srbacLoading');
        },
        error:function(){
            myAlert("Data tidak Ditemukan!");
            $('#jurnalpiutangsupplier-grid').removeClass('srbacLoading');
        }
    });
//    $('#jurnalpiutangpasien-grid').removeClass('srbacLoading');
}
function checkAllDetail(){
    $("#jurnalpiutangsupplier-grid > table > tbody > tr").find('input[type="checkbox"]').each(
    function(){
        if($("#checkAllRekening").is(":checked")){
            $(this).attr('checked','checked');
        }else{
            $(this).removeAttr('checked');
        }
    });
}

function setDialogRekening(obj){
        var row = $(obj).parents('tr').find('#row').val();
        $('#dialogRekDebitKredit #row').val(row);
        $('#dialogRekDebitKredit').dialog('open');
    }
function editDataRekeningFromGrid(params, row){
    var namaModel = 'AKRincianfakturhutangsupplierV';
    $("#"+namaModel+"_"+row+"_struktur_id").val(params.struktur_id);
    $("#"+namaModel+"_"+row+"_kelompok_id").val(params.kelompok_id);
    $("#"+namaModel+"_"+row+"_jenis_id").val(params.jenis_id);
    $("#"+namaModel+"_"+row+"_obyek_id").val(params.obyek_id);
    $("#"+namaModel+"_"+row+"_rincianobyek_id").val(params.rincianobyek_id);
    $("#"+namaModel+"_"+row+"_kdstruktur").val(params.kdstruktur);
    $("#"+namaModel+"_"+row+"_kdkelompok").val(params.kdkelompok);
    $("#"+namaModel+"_"+row+"_kdjenis").val(params.kdjenis);
    $("#"+namaModel+"_"+row+"_kdobyek").val(params.kdobyek);
    $("#"+namaModel+"_"+row+"_kdrincianobyek").val(params.kdrincianobyek);
    $("#"+namaModel+"_"+row+"_rekDebitKredit").val(params.nmrincianobyek);
    $("#"+namaModel+"_"+row+"_nama_rekening").val(params.nmrincianobyek);
//    $("#"+namaModel+"_"+row+"_saldodebit").val(formatNumber(parseFloat(params.saldodebit)));
//    $("#"+namaModel+"_"+row+"_saldokredit").val(formatNumber(parseFloat(params.saldokredit)));
}

function unformatSemuaInput(){
    $('.currency').each(function(){this.value = unformatNumber(this.value)});
    return true;
}
function formatSemuaInput(){
    $('.integer2').each(function(){
        this.value = formatNumber(this.value);
        $(this).find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        $(this).removeClass('integer2');
        $(this).addClass('currency');
    });
    return true;
}
formatSemuaInput();

function hitungSemua(){
    var totalDebit = 0;
    var totalKredit = 0;
    $('#jurnalpiutangsupplier-grid > table > tbody > tr').each(function(){
        debit = parseFloat(unformatNumber($(this).find('input[name$="[saldodebit]"]').val()));
        kredit = parseFloat(unformatNumber($(this).find('input[name$="[saldokredit]"]').val()));

        totalDebit += debit;
        totalKredit += kredit;

    });
    $('#totalDebit').val(formatInteger(totalDebit));
    $('#totalKredit').val(formatInteger(totalKredit));
}
function hitungSaldo(obj){
    $('#jurnalpiutangsupplier-grid > table > tbody > tr').each(function(){
        debit = parseFloat(unformatNumber($(obj).find('input[name$="[saldodebit]"]').val()));
        kredit = parseFloat(unformatNumber($(obj).find('input[name$="[saldokredit]"]').val()));

        totalDebit += debit;
        totalKredit += kredit;
    });
    hitungSemua();
}

</script>