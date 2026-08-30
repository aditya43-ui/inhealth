<script type="text/javascript">
var trUraian=new String(<?php echo CJSON::encode($this->renderPartial($this->path_view. '_rowUraian',array('form'=>$form,'modUraian'=>array(0=>$modUraian[0]),'removeButton'=>true),true));?>);

function removeDataRekening(obj)
{
    $(obj).parent().parent('tr').detach();
}

function getDataRekening(params)
{
    $("#tblInputRekening > tbody").find('tr').not('.trkreditcarabayar').detach();
    $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByJnsPengeluaran');?>', {jenispengeluaran_id:params},
        function(data){
			if(data != null){
				$("#tblInputRekening > tbody").append(data.replace());
				renameRowRekening();
//                $("#KUPengeluaranumumT_persenppn").val("10,00");
				hitungTotalHarga();
			}
    }, "json");    
}

function renameRowRekening()
{
    var idx = 0;
    $("#tblInputRekening > tbody").find('tr').each(
        function()
        {
            unMaskMoneyInput(this);
            maskMoneyInput(this);
             $(this).find('input[name$="[rekening1_id]"]').attr('name', 'RekeningakuntansiV['+idx+'][rekening1_id]');
                                         $(this).find('input[name$="[rekening1_id]"]').attr('id', 'RekeningakuntansiV_'+idx+'_rekening1_id');
                                         $(this).find('input[name$="[rekening2_id]"]').attr('name', 'RekeningakuntansiV['+idx+'][rekening2_id]');
                                         $(this).find('input[name$="[rekening2_id]"]').attr('id', 'RekeningakuntansiV_'+idx+'_rekening2_id');
                                         $(this).find('input[name$="[rekening3_id]"]').attr('name', 'RekeningakuntansiV['+idx+'][rekening3_id]');
                                         $(this).find('input[name$="[rekening3_id]"]').attr('id', 'RekeningakuntansiV_'+idx+'_rekening3_id');
                                         $(this).find('input[name$="[rekening4_id]"]').attr('name', 'RekeningakuntansiV['+idx+'][rekening4_id]');
                                         $(this).find('input[name$="[rekening4_id]"]').attr('id', 'RekeningakuntansiV_'+idx+'_rekening4_id');
                                         $(this).find('input[name$="[rekening5_id]"]').attr('name', 'RekeningakuntansiV['+idx+'][rekening5_id]');
                                         $(this).find('input[name$="[rekening5_id]"]').attr('id', 'RekeningakuntansiV_'+idx+'_rekening5_id');
                                         $(this).find('input[name$="[nama_rekening]"]').attr('name', 'RekeningakuntansiV['+idx+'][nama_rekening]');
                                         $(this).find('input[name$="[nama_rekening]"]').attr('id', 'RekeningakuntansiV_'+idx+'_nama_rekening');
                                         $(this).find('input[name$="[saldodebit]"]').attr('name', 'RekeningakuntansiV['+idx+'][saldodebit]');
                                         $(this).find('input[name$="[saldodebit]"]').attr('id', 'RekeningakuntansiV_'+idx+'_saldodebit');
                                         $(this).find('input[name$="[saldokredit]"]').attr('name', 'RekeningakuntansiV['+idx+'][saldokredit]');
                                         $(this).find('input[name$="[saldokredit]"]').attr('id', 'RekeningakuntansiV_'+idx+'_saldokredit');
//					idx++;
//            $(this).find('input').each(
//                function()
//                {   
//                    
////                    var name_field = $(this).attr('name');
////                    var id_field = $(this).attr('id');
////                    $(this).attr('name', name_field.replace('99', idx));
////                    $(this).attr('id', id_field.replace('99', idx));
//                    
//                }
//            );
            idx++;
        }
    );
}

var is_submit = false;
function simpanPengeluaran(params)
{
	
    if (is_submit) return false;
    
    jenis_simpan = params;
    var kosong = "" ;
    // var dataKosong = $("#input-pengeluaran").find(".[value="+ kosong +"]");
	var harga=0;
	var totharga = 0;
	if(requiredCheck($("#akpengeluaran-umum-t-form"))){
        var detail = 0;
        var rekening = 0;
        
        var total_harga = parseFloat(unformatNumber($('#KUPengeluaranumumT_totalharga').val()));
        var admin = parseFloat(unformatNumber($('#KUTandabuktikeluarT_biayaadministrasi').val()));
        var ppn = parseFloat(unformatNumber($('#KUPengeluaranumumT_ppn').val()));
        
        
        var total_harga_final = total_harga + admin + ppn;
        
        
        $('#tblInputUraian tbody tr').each(
            function(){
                detail++;
            }
        );
        $('#tblInputRekening tbody tr').each(
            function(){
                rekening++;
            }
        );

		if(rekening <= 0){
			myAlert('Silakan pilih nama rekening terlebih dahulu!');
			return false;
		}
		if($('#KUPengeluaranumumT_isurainkeluarumum').is(':checked')){
			$('#tblInputUraian tbody tr').each(function(){
				harga += unformatNumber($(this).find('input[name$="[hargasatuan]"]').val());
				totharga += unformatNumber($(this).find('input[name$="[totalharga]"]').val());
			});
			
			if(totharga != total_harga_final) {
				myAlert('Harga Uraian tidak sesuai');return false;
			}
		}
        
        // cek total jurnal rekening
        var total_debit = 0;
        var total_kredit = 0;
        $("#tblInputRekening .saldodebit").each(function() {
            total_debit += parseFloat(unformatNumber($(this).val()));
        });
        $("#tblInputRekening .saldokredit").each(function() {
            total_kredit += parseFloat(unformatNumber($(this).val()));
        });
        
        if (total_debit != total_kredit) {
            myAlert("Total Debit dan Kredit tidak sama.");
            return false;
        }
        
        if (total_debit != total_harga_final) {
            myAlert("Total nilai rekening tidak sesuai dengan Total Harga di Form.");
            return false;
        }

		if(detail > 0){
            $('.integer2, float2').each(
                function(){
                    this.value = unformatNumber(this.value)
                }
            );
    
            is_submit = true;
    
            $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanPengeluaran');?>', {jenis_simpan:jenis_simpan, data:$('#akpengeluaran-umum-t-form').serialize()},
                function(data){
                    if(data.status == 'ok')
                    {
                        if(data.action == 'insert')
                        {
                            myAlert("Simpan data berhasil");
                            $("#tblInputUraian").find('tr[class$="child"]').detach();
                            //location.reload();
                            $("#reseter").click();
							url = '<?php echo $this->createUrl("Print"); ?>&id=' + data.id;
							$('#url').val(url);
							$('#btn_print').prop('disabled', false);
                            $("#input-pengeluaran").find("input[name$='[nopengeluaran]']").val(data.pesan.nopengeluaran);
                            $("#input-pengeluaran").find("input[name$='[nokaskeluar]']").val(data.pesan.nokaskeluar);
                            $("#tblInputRekening > tbody").find('tr').detach();
                        }else{
                            myAlert("Update data berhasil");
                        }
                    }
                    
                    is_submit = false;
            }, "json");
        }else{
            myAlert('Detail uraian masih kosong');
        }
		
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatNumber($(this).val()));
        });
		
		
    }
	
    return false; 
}

function cekInput()
{
    var harga = 0; var totharga = 0;
    if($('#KUPengeluaranumumT_isuraintransaksi').is(':checked')){    
        $('#tblInputUraian').find('input[name$="[hargasatuan]"]').each(function(){
            harga = harga + unformatNumber(this.value);
        });
        $('#tblInputUraian').find('input[name$="[totalharga]"]').each(function(){
            totharga = totharga + unformatNumber(this.value);
        });
        
        //if(harga != unformatNumber($('#KUPengeluaranumumT_hargasatuan').val())){
        //    myAlert('Harga tidak sesuai');return false;
        //}
        if(totharga != unformatNumber($('#KUPengeluaranumumT_totalharga').val())){
            myAlert('Harga Uraian tidak sesuai');return false;
        }
    }
    $('.integer2').each(function(){this.value = unformatNumber(this.value)});
    
    return true;
}

function hitungTotalUraian(obj)
{
    var volume = unformatNumber($(obj).parents('tr').find('input[name$="[volume]"]').val());
    var hargasatuan = unformatNumber($(obj).parents('tr').find('input[name$="[hargasatuan]"]').val());
    
    $(obj).parents('tr').find('input[name$="[totalharga]"]').val(formatNumber(volume*hargasatuan));
}

function hitungTotalHarga()
{
    var biayaAdministrasi = parseFloat(unformatNumber($('#KUTandabuktikeluarT_biayaadministrasi').val()));
    var vol = parseFloat(unformatNumber($('#KUPengeluaranumumT_volume').val()));
    var harga = parseFloat(unformatNumber($('#KUPengeluaranumumT_hargasatuan').val()));
    
    var pph21 = parseFloat(unformatNumber($('#KUPengeluaranumumT_persenpph_21').val()));
    var pph22 = parseFloat(unformatNumber($('#KUPengeluaranumumT_persenpph_22').val()));
    var pph23 = parseFloat(unformatNumber($('#KUPengeluaranumumT_persenpph_23').val()));
    var ppn = parseFloat(unformatNumber($('#KUPengeluaranumumT_persenppn').val()));
    
    var totalharga = (vol*harga);
    var ppn_total = (ppn/100) * totalharga;
    var pph21_total = (pph21/100) * totalharga;
    var pph22_total = (pph22/100) * totalharga;
    var pph23_total = (pph23/100) * totalharga;
    
    var subtotal = ((totalharga + ppn_total + biayaAdministrasi)-(pph21_total + pph22_total + pph23_total));
    
    $(".jmlpph_21 .input_pph").parents("tr").hide().find("input").prop("disabled", true);
    $(".jmlpph_22 .input_pph").parents("tr").hide().find("input").prop("disabled", true);
    $(".jmlpph_23 .input_pph").parents("tr").hide().find("input").prop("disabled", true);
    $(".tandabukti_biayaadministrasi .input_pph").parents("tr").hide().find("input").prop("disabled", true);
    
    
    if (pph21_total > 0) {
        $(".jmlpph_21 .input_pph").parents("tr").show().find("input").prop("disabled", false);
    }
    if (pph22_total > 0) {
        $(".jmlpph_22 .input_pph").parents("tr").show().find("input").prop("disabled", false);
    }
    if (pph23_total > 0) {
        $(".jmlpph_23 .input_pph").parents("tr").show().find("input").prop("disabled", false);
    }
    if (biayaAdministrasi > 0) {
        $(".tandabukti_biayaadministrasi .input_pph").parents("tr").show().find("input").prop("disabled", false);
    }
    
    
    $('#KUPengeluaranumumT_totalharga').val(formatNumber(totalharga));
    $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatNumber(subtotal));
	$('.saldodebit').not('.input_pph').val(formatNumber(totalharga));
	$('.saldokredit').not('.input_pph').val(formatNumber(subtotal));
    
    $('#KUPengeluaranumumT_jmlpph_21, .jmlpph_21 .input_pph').val(formatNumber(pph21_total));
    $('#KUPengeluaranumumT_jmlpph_22, .jmlpph_22 .input_pph').val(formatNumber(pph22_total));
    $('#KUPengeluaranumumT_jmlpph_23, .jmlpph_23 .input_pph').val(formatNumber(pph23_total));
    $('#KUPengeluaranumumT_ppn, .ppn .input_pph').val(formatNumber(ppn_total));
    $('.tandabukti_biayaadministrasi .input_pph').val(formatNumber(biayaAdministrasi));
    
}

/*
function hitungJmlBayar()
{
    var biayaAdministrasi = unformatNumber($('#KUTandabuktikeluarT_biayaadministrasi').val());
    var totBayar = 0;
    var totHarga = unformatNumber($('#KUPengeluaranumumT_totalharga').val());
    
    var pph21 = parseFloat(unformatNumber($('#KUPengeluaranumumT_jmlpph_21').val()));
    var pph22 = parseFloat(unformatNumber($('#KUPengeluaranumumT_jmlpph_22').val()));
    var pph23 = parseFloat(unformatNumber($('#KUPengeluaranumumT_jmlpph_23').val()));
    
    
    totBayar = totHarga + biayaAdministrasi - (pph21+pph22+pph23);
    
    $('#KUTandabuktikeluarT_jmlkaskeluar, .saldodebit, .saldokredit').val(formatNumber(totBayar));
}
*/

function bukaUraian(obj)
{
    if($(obj).is(':checked')){
        $('#div_tblInputUraian').slideDown();
    } else {
        $('#div_tblInputUraian').slideUp();
    }
}
/*
function bukaUraian(obj)
{
    if($(obj).is(':checked')){
        $('#tblInputUraian').children('tbody').slideDown();
    } else {
        $('#tblInputUraian').children('tbody').slideUp();
    }
}
*/
function addRowUraian(obj)
{
    $(obj).parents('table').children('tbody').append(trUraian.replace());
        
    renameInput('KUUraiankeluarumumT','uraiantransaksi');
    renameInput('KUUraiankeluarumumT','volume');
    renameInput('KUUraiankeluarumumT','satuanvol');
    renameInput('KUUraiankeluarumumT','hargasatuan');
    renameInput('KUUraiankeluarumumT','totalharga');
    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    maskMoneyInput($('#tblInputUraian > tbody > tr:last'));
}
 
function batalUraian(obj)
{
    myConfirm("Apakah Anda yakin akan membatalkan Uraian?",'Perhatian!',function(r){
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();

            renameInput('KUUraiankeluarumumT','uraiantransaksi');
            renameInput('KUUraiankeluarumumT','volume');
            renameInput('KUUraiankeluarumumT','satuanvol');
            renameInput('KUUraiankeluarumumT','hargasatuan');
            renameInput('KUUraiankeluarumumT','totalharga');
        }
    });
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tblInputUraian tr').length;
    var i = -1;
    $('#tblInputUraian tr').each(function(){
        if($(this).has('input[name$="[uraiantransaksi]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}

function getDataRekeningFromGrid(rekening1_id,rekening2_id,rekening3_id,rekening4_id,rekening5_id,status)
{
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('AmbilDataRekening'); ?>',
		data: {rekening1_id:rekening1_id,rekening2_id:rekening2_id,rekening3_id:rekening3_id,rekening4_id:rekening4_id,rekening5_id:rekening5_id,status:status},//
		dataType: "json",
		success:function(data){
			$("#tblInputRekening > tbody").append(data.replace());
			renameRowRekening();
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}
	
function formCarabayar(carabayar)
{
    //myAlert(carabayar);
    if(carabayar == 'TRANSFER'){
        $('#divCaraBayarTransfer').slideDown();
    } else {
        $('#divCaraBayarTransfer').slideUp();
        getDataRekeningCarapembayar();
    }
}

function unMaskMoneyInput(tr)
{
    $(tr).find('.integer2:text').unmaskMoney();
}

function maskMoneyInput(tr)
{
    $(tr).find('.integer2:text').maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
}

function print(caraPrint)
{
	if ($('#url').val() == '') {
		myAlert('Lakukan transaksi terlebih dahulu dengan benar!');
		return false;
	}
	window.open($('#url').val() + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
	return false;
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
                $("#<?php echo CHtml::activeId($modBuktiKeluar, 'denganrekening') ?>").val(data.norekening);
                $("#<?php echo CHtml::activeId($modBuktiKeluar, 'melalubank') ?>").val(data.namabank);
                $("#<?php echo CHtml::activeId($modBuktiKeluar, 'atasnamarekening') ?>").val(data.namabank);
                getDataRekeningCarapembayar();
            },
            error: function (jqXHR, textStatus, errorThrown) { myAlert("Data Setoran Utang Pajak tidak ditemukan!");}
        });
     }
}

function getDataRekeningCarapembayar()
{
    var carabayarkeluar = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>").val();
    
    var bankid = "";
    if ($("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>").val() === 'TRANSFER'){
        bankid = $("#<?php echo CHtml::activeId($modBuktiKeluar, 'bank_id'); ?>").val();
    }

        $("#tblInputRekening > tbody").find('.trkreditcarabayar').detach();
        $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByCaraPembayaran'); ?>', {carapembayaran: carabayarkeluar, bankid:bankid},
        function (data) {
                if (data != null) {
                        $("#tblInputRekening > tbody").append(data.replace());
                        renameRowRekening();
                        hitungTotalHarga();
                }
        }, "json");
}

function getSebagaiBayar(value){
      var textData = (value +" - <?php echo MyFormatter::getMonthId(date('m')) ." ".date('Y'); ?>");
      
      $('#<?php echo CHtml::activeId($modBuktiKeluar,'untukpembayaran'); ?>').val(textData);
  }  

$(document).ready(function(){
    formCarabayar($("#<?php echo CHtml::activeId($modBuktiKeluar, 'carabayarkeluar'); ?>").val());
    getDataRekeningCarapembayar();
});

</script>
