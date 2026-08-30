<script type="text/javascript">
var trUraian=new String(<?php echo CJSON::encode($this->renderPartial('_rowUraian',array('form'=>$form,'modUraian'=>array(0=>$modUraian[0]),'removeButton'=>true),true));?>);
$('.integer').each(function(){this.value = unformatNumber(this.value)});
function cekInput()
{

    var harga = 0; var totharga = 0;
    if($('#KUPenerimaanUmumT_isuraintransaksi').is(':checked')){    
        $('#tblInputUraian').find('input[name$="[hargasatuan]"]').each(function(){
            harga = harga + unformatNumber(this.value);
        });
        $('#tblInputUraian').find('input[name$="[totalharga]"]').each(function(){
            totharga = totharga + unformatNumber(this.value);
        });
        
        //if(harga != unformatNumber($('#KUPenerimaanUmumT_hargasatuan').val())){
        //    myAlert('Harga tidak sesuai');return false;
        //}
        if(totharga != unformatNumber($('#KUPenerimaanUmumT_totalharga').val())){
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
    var biayaAdministrasi = unformatNumber($('#KUTandabuktibayarT_biayaadministrasi').val());
    var biayaMaterai = unformatNumber($('#KUTandabuktibayarT_biayamaterai').val());
    var vol = unformatNumber($('#KUPenerimaanUmumT_volume').val());
    var harga = unformatNumber($('#KUPenerimaanUmumT_hargasatuan').val());
    
    $('#KUPenerimaanUmumT_totalharga').val(formatNumber(vol*harga));
    $('#KUTandabuktibayarT_jmlpembayaran').val(formatNumber((vol*harga)+biayaAdministrasi+biayaMaterai));
}

function addRowUraian(obj)
{
    $(obj).parents('table').children('tbody').append(trUraian.replace());
        
    renameInput('KUUraianpenumumT','uraiantransaksi');
    renameInput('KUUraianpenumumT','volume');
    renameInput('KUUraianpenumumT','satuanvol');
    renameInput('KUUraianpenumumT','hargasatuan');
    renameInput('KUUraianpenumumT','totalharga');
    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    maskMoneyInput($('#tblInputUraian > tbody > tr:last'));
}

function totaltagihankeseluruhan(obj)
{
    var totaltagihan = 0;
    var totalharga = 0;
    var totalbaris = 0;
    $(obj).each(function() {
        totalbaris = $(obj).parents("tr").children(".totalharga").val();
        totalharga = unformatNumber(totalbaris);
        totaltagihan += totalharga;
    });
//    $('#totTagihan').hide();
    $('#totTagihan').val(totaltagihan);
}
 
function batalUraian(obj)
{
    myConfirm("Apakah Anda yakin akan membatalkan Uraian?",
    "Perhatian!",
    function(r){
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();
            
            renameInput('KUUraianpenumumT','uraiantransaksi');
            renameInput('KUUraianpenumumT','volume');
            renameInput('KUUraianpenumumT','satuanvol');
            renameInput('KUUraianpenumumT','hargasatuan');
            renameInput('KUUraianpenumumT','totalharga');
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

function enableInputKartu()
{
    if($('#pakeKartu').is(':checked'))
        $('#divDenganKartu').show();
    else 
        $('#divDenganKartu').hide();
    if($('#KUTandabuktibayarT_dengankartu').val() != ''){
        //myAlert('isi');
        $('#KUTandabuktibayarT_bankkartu').removeAttr('readonly');
        $('#KUTandabuktibayarT_nokartu').removeAttr('readonly');
        $('#KUTandabuktibayarT_nostrukkartu').removeAttr('readonly');
    } else {
        //myAlert('kosong');
        $('#KUTandabuktibayarT_bankkartu').attr('readonly','readonly');
        $('#KUTandabuktibayarT_nokartu').attr('readonly','readonly');
        $('#KUTandabuktibayarT_nostrukkartu').attr('readonly','readonly');
        
        $('#KUTandabuktibayarT_bankkartu').val('');
        $('#KUTandabuktibayarT_nokartu').val('');
        $('#KUTandabuktibayarT_nostrukkartu').val('');
    }
}

function ubahCaraPembayaran(obj)
{
    if(obj.value == 'CICILAN'){
        $('#KUTandabuktibayarT_jmlpembayaran').removeAttr('readonly');
    } else {
        $('#KUTandabuktibayarT_jmlpembayaran').attr('readonly', true);
        hitungJmlBayar();
    }
    
    if(obj.value == 'TUNAI'){
        hitungJmlBayar();
    } 
}

function hitungJmlBayar()
{
    var biayaAdministrasi = unformatNumber($('#KUTandabuktibayarT_biayaadministrasi').val());
    var biayaMaterai = unformatNumber($('#KUTandabuktibayarT_biayamaterai').val());
    var totBayar = 0;
    var totTagihan = unformatNumber($('#KUPenerimaanUmumT_totalharga').val());
    var jmlPembulatan = unformatNumber($('#KUTandabuktibayarT_jmlpembulatan').val());
    
    totBayar = totTagihan + jmlPembulatan + biayaAdministrasi + biayaMaterai;
    
    $('#KUTandabuktibayarT_jmlpembayaran').val(formatNumber(totBayar));
    hitungKembalian();
}

function hitungKembalian()
{
    var jmlBayar = unformatNumber($('#KUTandabuktibayarT_jmlpembayaran').val());
    var uangDiterima = unformatNumber($('#KUTandabuktibayarT_uangditerima').val());
    var uangKembalian = uangDiterima - jmlBayar;
    
    $('#KUTandabuktibayarT_uangkembalian').val(formatNumber(uangKembalian));
}

function maskMoneyInput(tr)
{
    $(tr).find('input.currency:text').maskMoney({"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
}

function bukaUraian(obj)
{
    if($(obj).is(':checked')){
        $('#div_tabeluraian').slideDown();
		$('#tblInputUraian').children('tbody').slideDown();
    } else {
        $('#div_tabeluraian').slideUp();
		$('#tblInputUraian').children('tbody').slideUp();
    }
}
</script>