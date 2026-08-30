<script type="text/javascript">
var trUraian=new String(<?php echo CJSON::encode($this->renderPartial('_rowUraian',array('form'=>$form,'modUraian'=>array(0=>$modUraian[0]),'removeButton'=>true),true));?>);

function removeDataRekening(obj)
{
    $(obj).parent().parent('tr').detach();
}

function getDataRekening(params)
{
    $("#tblInputRekening > tbody").find('tr').detach();
    $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/GetDataRekeningByJnsPengeluaran');?>', {jenispengeluaran_id:params},
        function(data){
			if(data != null){
				$("#tblInputRekening > tbody").append(data.replace());
				renameRowRekening();
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

function simpanPengeluaran(params)
{
    jenis_simpan = params;
    var kosong = "" ;
    var dataKosong = $("#input-pengeluaran").find(".[value="+ kosong +"]");
	var harga=0;
	var totharga = 0;
	if(requiredCheck($("#akpengeluaran-umum-t-form"))){
        var detail = 0;
        var rekening = 0;
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
		if($('#AKPengeluaranumumT_isurainkeluarumum').is(':checked')){
			$('#tblInputUraian tbody tr').each(function(){
				harga += unformatNumber($(this).find('input[name$="[hargasatuan]"]').val());
				totharga += unformatNumber($(this).find('input[name$="[totalharga]"]').val());
			});
			
			if(totharga != unformatNumber($('#AKPengeluaranumumT_totalharga').val())){
				myAlert('Harga Uraian tidak sesuai');return false;
			}
		}

		if(detail > 0){
            $('.currency').each(
                function(){
                    this.value = unformatNumber(this.value)
                }
            );
            $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanPengeluaran');?>', {jenis_simpan:jenis_simpan, data:$('#akpengeluaran-umum-t-form').serialize()},
                function(data){
                    if(data.status == 'ok')
                    {
                        if(data.action == 'insert')
                        {
                            myAlert("Simpan data berhasil");
                            $("#tblInputUraian").find('tr[class$="child"]').detach();
                            $("#reseter").click();
                            $("#input-pengeluaran").find("input[name$='[nopengeluaran]']").val(data.pesan.nopengeluaran);
                            $("#input-pengeluaran").find("input[name$='[nokaskeluar]']").val(data.pesan.nokaskeluar);
                            $("#tblInputRekening > tbody").find('tr').detach();
                        }else{
                            myAlert("Update data berhasil");
                        }
                    }
            }, "json");
        }else{
            myAlert('Detail uraian masih kosong');
        }
		
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false; 
}

function cekInput()
{
    var harga = 0; var totharga = 0;
    if($('#AKPengeluaranumumT_isuraintransaksi').is(':checked')){    
        $('#tblInputUraian').find('input[name$="[hargasatuan]"]').each(function(){
            harga = harga + unformatNumber(this.value);
        });
        $('#tblInputUraian').find('input[name$="[totalharga]"]').each(function(){
            totharga = totharga + unformatNumber(this.value);
        });
        
        //if(harga != unformatNumber($('#AKPengeluaranumumT_hargasatuan').val())){
        //    myAlert('Harga tidak sesuai');return false;
        //}
        if(totharga != unformatNumber($('#AKPengeluaranumumT_totalharga').val())){
            myAlert('Harga Uraian tidak sesuai');return false;
        }
    }
    $('.currency').each(function(){this.value = unformatNumber(this.value)});
    
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
    var biayaAdministrasi = unformatNumber($('#AKTandabuktikeluarT_biayaadministrasi').val());
    var vol = unformatNumber($('#AKPengeluaranumumT_volume').val());
    var harga = unformatNumber($('#AKPengeluaranumumT_hargasatuan').val());
    
    $('#AKPengeluaranumumT_totalharga').val(formatNumber(vol*harga));
    $('#AKTandabuktikeluarT_jmlkaskeluar').val(formatNumber(vol*harga+biayaAdministrasi));
	$('#RekeningakuntansiV_0_saldodebit').val(formatNumber(vol*harga+biayaAdministrasi));
	$('#RekeningakuntansiV_1_saldokredit').val(formatNumber(vol*harga+biayaAdministrasi));
}

function hitungJmlBayar()
{
    var biayaAdministrasi = unformatNumber($('#AKTandabuktikeluarT_biayaadministrasi').val());
    var totBayar = 0;
    var totHarga = unformatNumber($('#AKPengeluaranumumT_totalharga').val());
    
    totBayar = totHarga + biayaAdministrasi;
    
    $('#AKTandabuktikeluarT_jmlkaskeluar').val(formatNumber(totBayar));
}

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
        
    renameInput('AKUraiankeluarumumT','uraiantransaksi');
    renameInput('AKUraiankeluarumumT','volume');
    renameInput('AKUraiankeluarumumT','satuanvol');
    renameInput('AKUraiankeluarumumT','hargasatuan');
    renameInput('AKUraiankeluarumumT','totalharga');
    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    maskMoneyInput($('#tblInputUraian > tbody > tr:last'));
}
 
function batalUraian(obj)
{
    myConfirm("Apakah Anda yakin akan membatalkan Uraian?",'Perhatian!',function(r){
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();

            renameInput('AKUraiankeluarumumT','uraiantransaksi');
            renameInput('AKUraiankeluarumumT','volume');
            renameInput('AKUraiankeluarumumT','satuanvol');
            renameInput('AKUraiankeluarumumT','hargasatuan');
            renameInput('AKUraiankeluarumumT','totalharga');
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
    }
}

function unMaskMoneyInput(tr)
{
    $(tr).find('input.currency:text').unmaskMoney();
}

function maskMoneyInput(tr)
{
    $(tr).find('input.currency:text').maskMoney({"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
}
</script>