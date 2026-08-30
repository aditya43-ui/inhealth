<?php
/**
 * KHUSUS UNTUK MENYIMPAN FUNGSI-FUNGSI JAVASCRIPT
 */
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php 
    $modNewRekenings = array();
    $modNewRekenings[0] = new RekeningpembayarankasirV;
?>
<script type="text/javascript">
    var namaModel = "RekeningpembayarankasirV";
    var trRekening=new String(<?php echo CJSON::encode($this->renderPartial('akuntansi.views.pembayaranKlaimMerchant.rekening._rowRekening',array('modRekenings'=>$modNewRekenings,'removeButton'=>true),true));?>);
    function setDialogRekening(obj){
        var row = $(obj).parents('tr').find('#row').val();
        $('#dialogRekDebitKredit #row').val(row);
        $('#dialogRekDebitKredit').dialog('open');
    }
    function editDataRekeningFromGrid(params, row){
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
        
//        JIKA DIAKTIFKAN SALADO AKAN ME RESET DARI NOL
//        $("#"+namaModel+"_"+row+"_saldodebit").val(formatNumber(parseFloat(params.saldodebit)));
//        $("#"+namaModel+"_"+row+"_saldokredit").val(formatNumber(parseFloat(params.saldokredit)));
    }
    
    function addDataRekening(obj){
        $("#tblInputRekening > tbody").append(trRekening.replace());
        $("#tblInputRekening > tbody > tr:last").find('input[name$="[rekDebitKredit]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
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
        $("#tblInputRekening > tbody > tr:last").find('.uncurrency').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        //uncurrency agar tidak duakali maskMoney krn bisa error input
        $("#tblInputRekening > tbody").find('.uncurrency').addClass('currency');
        $("#tblInputRekening > tbody").find('.currency').removeClass('uncurrency');
        //copy penjamin_id, penjamin_nama 
        var penjaminId = $(obj).parents('tr').find("input[name$='[penjamin_id]']").val();
        var penjaminNama = $(obj).parents('tr').find("input[name$='[penjamin_nama]']").val();
        $("#tblInputRekening > tbody > tr:last").find("input[name$='[penjamin_id]']").val(penjaminId);
        $("#tblInputRekening > tbody > tr:last").find("input[name$='[penjamin_nama]']").val(penjaminNama);
        setTimeout(function(){renameRowRekening()},500);
    }
    
    //getDataRekening untuk load data rekening berdasarkan pelayanan yang ditambahkan
    function getDataRekeningKlaim(){
        $('.currency').each(function(){this.value = unformatNumber(this.value)});
        $('.number').each(function(){this.value = unformatNumber(this.value)});
        $("#formJurnalRekeningKasir").addClass("srbacLoading");
        $("#formJurnalRekeningKasir > table > tbody").html("");
        $.post('<?php echo Yii::app()->createUrl('ActionAjax/GetDataRekeningPembayaranKlaimMerchant');?>', {},
            function(data){
                if(data == null){
//                    alert("Tidak memiliki rekening!");
                }else{
                    $("#tblInputRekening > tbody").append(data.replace());
                    $("#tblInputRekening > tbody").find('input[name$="[rekDebitKredit]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
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
                    $("#tblInputRekening > tbody").find('.uncurrency').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":2});
                    //uncurrency agar tidak duakali maskMoney krn bisa error input
                    $("#tblInputRekening > tbody").find('.uncurrency').addClass('currency');
                    $("#tblInputRekening > tbody").find('.currency').removeClass('uncurrency');
                    setTimeout(function(){renameRowRekening()},1000);
                }
              $("#formJurnalRekeningKasir").removeClass("srbacLoading");  
            }, "json");
            $('.currency').each(function(){this.value = formatDesimal(this.value)});
            $('.number').each(function(){this.value = formatDesimal(this.value)});
            return false;
    }

    function renameRowRekening(){
        var i = 0;
        $("#tblInputRekening > tbody").find('tr').each(
            function()
            {
                $(this).find('#noUrut').val(i+1);
                $(this).find('#row').val(i);
                $(this).find('.currency').each(function(){this.value = formatDesimal(this.value)});

                $(this).find('input[name$="[kdstruktur]"]').attr('name',namaModel+'['+i+'][kdstruktur]')
                        .attr('id',namaModel+'_'+i+'_kdstruktur');
                $(this).find('input[name$="[struktur_id]"]').attr('name',namaModel+'['+i+'][struktur_id]')
                        .attr('id',namaModel+'_'+i+'_struktur_id');
                $(this).find('input[name$="[kdkelompok]"]').attr('name',namaModel+'['+i+'][kdkelompok]')
                        .attr('id',namaModel+'_'+i+'_kdkelompok');
                $(this).find('input[name$="[kelompok_id]"]').attr('name',namaModel+'['+i+'][kelompok_id]')
                        .attr('id',namaModel+'_'+i+'_kelompok_id');
                $(this).find('input[name$="[kdjenis]"]').attr('name',namaModel+'['+i+'][kdjenis]')
                        .attr('id',namaModel+'_'+i+'_kdjenis');
                $(this).find('input[name$="[jenis_id]"]').attr('name',namaModel+'['+i+'][jenis_id]')
                        .attr('id',namaModel+'_'+i+'_jenis_id');
                $(this).find('input[name$="[kdobyek]"]').attr('name',namaModel+'['+i+'][kdobyek]')
                        .attr('id',namaModel+'_'+i+'_kdobyek');
                $(this).find('input[name$="[obyek_id]"]').attr('name',namaModel+'['+i+'][obyek_id]')
                        .attr('id',namaModel+'_'+i+'_obyek_id');
                $(this).find('input[name$="[kdrincianobyek]"]').attr('name',namaModel+'['+i+'][kdrincianobyek]')
                        .attr('id',namaModel+'_'+i+'_kdrincianobyek');
                $(this).find('input[name$="[rincianobyek_id]"]').attr('name',namaModel+'['+i+'][rincianobyek_id]')
                        .attr('id',namaModel+'_'+i+'_rincianobyek_id');
                $(this).find('input[name$="[nama_rekening]"]').attr('name',namaModel+'['+i+'][nama_rekening]')
                        .attr('id',namaModel+'_'+i+'_nama_rekening');
                $(this).find('input[name$="[rekDebitKredit]"]').attr('name',namaModel+'['+i+'][rekDebitKredit]')
                        .attr('id',namaModel+'_'+i+'_rekDebitKredit');
                $(this).find('input[name$="[saldodebit]"]').attr('name',namaModel+'['+i+'][saldodebit]')
                        .attr('id',namaModel+'_'+i+'_saldodebit');
                $(this).find('input[name$="[saldokredit]"]').attr('name',namaModel+'['+i+'][saldokredit]')
                        .attr('id',namaModel+'_'+i+'_saldokredit');
                                
                i++;

                

            }
        );
    }
    function removeDataRekening(obj)    {
        var namaRekening = $(obj).parents("tr").find("input[name$='[nama_rekening]']").val();
        if(confirm("Apakah Anda akan menghapus rekening '"+namaRekening+"' ?") == true){
            $(obj).parent().parent('tr').detach();
        }
        setTimeout(function(){renameRowRekening()},500);
    }
    
    function updateRekeningPembayaranKlaim(saldo){
        $("#tblInputRekening > tbody > tr").each(function(){
            saldoTotal = saldo;
            if($(this).find('input[name$="[saldonormal]"]').val() == "D"){
                $(this).find('input[name$="[saldodebit]"]').val(saldoTotal);
            }else{
                $(this).find('input[name$="[saldokredit]"]').val(saldoTotal);
            }
        });
    }
    
</script>
<?php 
Yii::app()->clientScript->registerScript('renameOnload', "renameRowRekening();", CClientScript::POS_READY);
?>