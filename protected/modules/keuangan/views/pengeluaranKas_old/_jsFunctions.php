<script type="text/javascript">
var trUraian=new String(<?php echo CJSON::encode($this->renderPartial('_rowUraian',array('form'=>$form,'modUraian'=>$modUraian,'removeButton'=>true),true));?>);

function removeDataRekening(obj)
{
    $(obj).parent().parent('tr').detach();
}

function getDataRekening(params)
{
    $("#tblInputRekening > tbody").find('tr').detach();
    $.post('<?php echo $this->createUrl('GetDataRekeningByJnsPengeluaran');?>', {jenispengeluaran_id:params},
        function(data){
            $("#tblInputRekening > tbody").append(data.replace());
            renameRowRekening();
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
    var dataKosong = $("#input-pengeluaran").find(".reqForm[value="+ kosong +"]");
	var harga= 0;
	var totharga =0;
	if(requiredCheck($("#kupengeluaran-umum-t-form"))){
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
		if($('#KUPengeluaranumumT_isurainkeluarumum').is(':checked')){
			$('#tblInputUraian tbody tr').each(function(){
				harga += unformatNumber($(this).find('input[name$="[hargasatuan]"]').val());
				totharga += unformatNumber($(this).find('input[name$="[totalharga]"]').val());
			});
			
			if(totharga != unformatNumber($('#KUPengeluaranumumT_totalharga').val())){
				myAlert('Harga Uraian tidak sesuai');return false;
			}
		}
        
        if(detail > 0){
            $('.integer').each(
                function(){
                    this.value = unformatNumber(this.value)
                }
            );
                
            $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanPengeluaran');?>', {jenis_simpan:jenis_simpan, data:$('#kupengeluaran-umum-t-form').serialize()},
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
    $('.integer').each(function(){this.value = unformatNumber(this.value)});
    
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
    var biayaAdministrasi = unformatNumber($('#KUTandabuktikeluarT_biayaadministrasi').val());
    var vol = unformatNumber($('#KUPengeluaranumumT_volume').val());
    var harga = unformatNumber($('#KUPengeluaranumumT_hargasatuan').val());
    
    $('#KUPengeluaranumumT_totalharga').val(formatNumber(vol*harga));
    $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatNumber(vol*harga+biayaAdministrasi));
	$('#RekeningakuntansiV_0_saldodebit').val(formatNumber((vol * harga) + biayaAdministrasi));
	$('#RekeningakuntansiV_1_saldokredit').val(formatNumber((vol * harga) + biayaAdministrasi));
}

function hitungJmlBayar()
{
    var biayaAdministrasi = unformatNumber($('#KUTandabuktikeluarT_biayaadministrasi').val());
    var totBayar = 0;
    var totHarga = unformatNumber($('#KUPengeluaranumumT_totalharga').val());
    
    totBayar = totHarga + biayaAdministrasi;
    
    $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatNumber(totBayar));
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

function formCarabayar(carabayar)
{
    //myAlert(carabayar);
    if(carabayar == 'TRANSFER'){
        $('#divCaraBayarTransfer').slideDown();
    } else {
        $('#divCaraBayarTransfer').slideUp();
    }
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
	
function unMaskMoneyInput(tr)
{
    $(tr).find('input.integer:text').unmaskMoney();
}

function maskMoneyInput(tr)
{
    $(tr).find('input.integer:text').maskMoney({"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
}
</script>