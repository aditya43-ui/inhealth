<script type="text/javascript">
function print(caraPrint)
{
    var advancepayment_id = '<?php echo (isset($_GET['advancepayment_id']) ? $_GET['advancepayment_id'] : null); ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&advancepayment_id='+advancepayment_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}


var trTindakan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowUraianSettlement',array('modSettlementPaymentDetails'=>$modSettlementPaymentDetails,'modSettlementPaymentDetail'=>$modSettlementPaymentDetail,'removeButton'=>true),true));?>);
// var trTindakanFirst = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowUraianSettlement',array('modSettlementPaymentDetails'=>$modSettlementPaymentDetails,'modSettlementPaymentDetail'=>$modSettlementPaymentDetail,'removeButton'=>true),true));?>);
var trLamp = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowLampiranSettlement',array('modSettlementPaymentLamps'=>$modSettlementPaymentLamps,'modSettlementPaymentLamp'=>$modSettlementPaymentLamp,'removeButton'=>true),true));?>);
// var trTindakanFirst = new String(<?php //echo CJSON::encode($this->renderPartial($this->path_view.'_rowUraianSettlement',array('modSettlementPaymentDetail'=>$modSettlementPaymentDetail,'catatan'=>$catatan,'removeButton'=>false),true));?>);
// function setDate(obj){
//     $('#'+$(obj).attr('id')).val($(obj).val())
//     $('#'+$(obj).attr('id')).removeClass('realtime')

// }
function addRowLamp(obj){
    $(obj).parents('table').children('tbody').append(trLamp.replace());
}

function setDate(obj){
    $('#'+$(obj).attr('id')).val($(obj).val())
    $('#'+$(obj).attr('id')).removeClass('realtime')
}

function batalLamp(obj)
{
    myConfirm("Apakah anda yakin akan membatalkan uraian?","Perhatian!",function(r) {
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();

            <?php 
                // foreach($attributes as $i=>$attribute){
                //     echo "renameInput('SettlementpaymentdetT','$attribute');";
                // }
            ?>
            // renameInput('SettlementpaymentdetT','jenispengeluaran_nama');
            // renameInput('SettlementpaymentdetT','kategoriTindakanNama');
            // renameInput('SettlementpaymentdetT','persenCyto');
            // renameInput('SettlementpaymentdetT','jumlahTarif');
            // renameInput('SettlementpaymentdetT','tgltransaksi');
			// renameInput('SettlementpaymentdetT','keltindakanid');
        }
    });
}

function addRowTindakan(obj)
{
    $(obj).parents('table').children('tbody').append(trTindakan.replace());
    <?php 
        $attributes = $modSettlementPaymentDetail->attributeNames(); 
        foreach($attributes as $i=>$attribute){
            echo "renameInput('SettlementpaymentdetT','$attribute');";
        }
    ?>
    renameInput('SettlementpaymentdetT','volume');
    renameInput('SettlementpaymentdetT','hargasatuan');
    renameInput('SettlementpaymentdetT','totalharga');
    renameInput('SettlementpaymentdetT','jenispengeluaran_nama');
    renameInput('SettlementpaymentdetT','tgltransaksi');
    // renameInput('SettlementpaymentdetT','kategoriTindakanNama');
    $('#tblInputTindakan tbody').each(function(){
        jQuery('input[name$="[tgltransaksi]"]').datetimepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'maxDate':'d',
                    'timeText':'Waktu',
                    'hourText':'Jam',
                    'minuteText':'Menit',
                    'secondText':'Detik',
                    'showSecond':true,
                    'timeOnlyTitle':'Pilih Waktu',
                    'timeFormat':'hh:mm:ss',
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-80y:+20y'
                }
            )
        );
    });  
    
    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    jQuery('input[name$="[jenispengeluaran_nama]"]').autocomplete(
        {
            'showAnim':'fold',
            'minLength':2,
            'focus':function(event, ui )
            {
                $(this).val( ui.item.label);
                return false;
            },
            'select':function( event, ui )
            {
                var is_ada = false;
                $("#tblInputTindakan .jen").each(function() {
                    if ($(this).val() == ui.item.jenispengeluaran_id) is_ada = true;
                });

                if (is_ada) {
                    $(this).val("");
                    myAlert("Jenis Pengeluaran yang dipilih sudah ditambahkan sebelumnya. Silahkan ubah jumlah-nya.");
                    return false;
                }
                setPengeluaran(this, ui.item);
                return false;
            },
            'source':function(request, response)
            {
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl('rawatJalan/tindakan/DaftarTindakan');?>",
                    dataType: "json",
                    data:{
                        term: request.term,
                       
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }
        }
    );
    
      
}
function setPengeluaran(obj,item)
{
    console.log(item)
    $(obj).parents('tr').find('input[name$="[jenispengeluaran_nama]"]').val(item.jenispengeluaran_nama);
    $(obj).parents('tr').find('input[name$="[jenispengeluaran_id]"]').val(item.jenispengeluaran_id);
   ;
}
function setRekening(obj,item)
{
    console.log(item)
    // $(obj).parents('tr').find('input[name$="[jenispengeluaran_nama]"]').val(item.jenispengeluaran_nama);
    // $(obj).parents('tr').find('input[name$="[jenispengeluaran_id]"]').val(item.jenispengeluaran_id);
   ;
}
function batalTindakan(obj)
{
    myConfirm("Apakah anda yakin akan membatalkan uraian?","Perhatian!",function(r) {
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();

            <?php 
                foreach($attributes as $i=>$attribute){
                    echo "renameInput('SettlementpaymentdetT','$attribute');";
                }
            ?>
            renameInput('SettlementpaymentdetT','jenispengeluaran_nama');
            renameInput('SettlementpaymentdetT','tgltransaksi');
            // renameInput('SettlementpaymentdetT','kategoriTindakanNama');
            renameInput('SettlementpaymentdetT','volume');
            renameInput('SettlementpaymentdetT','hargasatuan');
            renameInput('SettlementpaymentdetT','totalharga');
        }
    });
}
 
function deleteTindakan(obj,idTindakanpelayanan)
{
    myConfirm("Apakah anda yakin akan menghapus tindakan?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxDeleteTindakanPelayanan') ?>', {idTindakanpelayanan: idTindakanpelayanan}, function(data){
                if(data.success)
                {
                    $(obj).parent().parent().detach();
                    myAlert('Data berhasil dihapus !!');
                } else {
                    myAlert('Data Gagal dihapus');
                }
            }, 'json');
        }
    });
}

function renameListTindakan(modelName,attributeName)
{
    var trLength = $('#tblInputTindakan tr').length;
    var i = -1;
    $('#tblInputTindakan tr').each(function(){
        if($(this).has('input[name$="[tarif_satuan]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('input[name^="jenispengeluaran_nama["]').attr('name','jenispengeluaran_nama['+i+']');
        $(this).find('input[name^="jenispengeluaran_nama["]').attr('id','jenispengeluaran_nama_'+i+'');
        $(this).find('input[name^="rekening5_nama["]').attr('name','rekening5_nama['+i+']');
        $(this).find('input[name^="rekening5_nama["]').attr('id','rekening5_nama'+i+'');
        // $(this).find('a[id^="btnAddDokter_"]').attr('id','btnAddDokter_'+i+'');
    });
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tblInputJenisPengeluaran tr').length;
    var i = -1;
    $('#tblInputJenisPengeluaran tr').each(function(){
        if($(this).has('input[name$="[jenispengeluaran_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('input[name^="jenispengeluaran_nama["]').attr('name','jenispengeluaran_nama['+i+']');
        $(this).find('input[name^="jenispengeluaran_nama["]').attr('id','jenispengeluaran_nama_'+i+'');
        $(this).find('input[name^="tgltransaksi["]').attr('name','tgltransaksi['+i+']');
        $(this).find('input[name^="tgltransaksi["]').attr('id','tgltransaksi_'+i+'');
        // $(this).find('a[id^="btnAddDokter_"]').attr('id','btnAddDokter_'+i+'');        
		// $(this).find('div[id^="tampilanDokterPemeriksa_"]').attr('id','tampilanDokterPemeriksa_'+i+'');
		// $(this).find('div[id^="tampilanDokterPemeriksa2_"]').attr('id','tampilanDokterPemeriksa2_'+i+'');
        // $(this).find('div[id^="tampilanDokterDelegasi_"]').attr('id','tampilanDokterDelegasi_'+i+'');
        // $(this).find('div[id^="tampilanDokterPendamping_"]').attr('id','tampilanDokterPendamping_'+i+'');
        // $(this).find('div[id^="tampilanDokterAnastesi_"]').attr('id','tampilanDokterAnastesi_'+i+'');
        // $(this).find('div[id^="tampilanBidan_"]').attr('id','tampilanBidan_'+i+'');
        // $(this).find('div[id^="tampilanBidan2_"]').attr('id','tampilanBidan2_'+i+'');
        // $(this).find('div[id^="tampilanSuster_"]').attr('id','tampilanSuster_'+i+'');
        // $(this).find('div[id^="tampilanPerawat_"]').attr('id','tampilanPerawat_'+i+'');
        // $(this).find('div[id^="tampilanPerawat2_"]').attr('id','tampilanPerawat2_'+i+'');
		// $(this).find('div[id^="tampilanSupir_"]').attr('id','tampilanSupir_'+i+'');
		$(this).find('input[id="row"]').attr('value',i);
        $(this).find('input[id="row"]').val(i);
//        jQuery('input[name$="[jenispengeluaran_nama]"]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
    });
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
function setJenisTransaksi(obj){
	if ($('#AdvancepaymentT_profilrs_id').val() == '') {
		myAlert('Pilih dulu klinik');
		$('#AdvancepaymentT_jenistransaksi').val('')
		return false;
	}
	if ($(obj).val() == 'ADVANCE PAYMENT') {
		generateNoPengajuan('AP',$('#AdvancepaymentT_profilrs_id').val());
	}else if ($(obj).val() == 'REQUEST OF PAYMENT') {
		generateNoPengajuan('ROP',$('#AdvancepaymentT_profilrs_id').val());
	}

	$('#jenis_transaksi').text(toTitleCase($(obj).val()))
}
// 
function hitungTotalUraian(obj)
{
    var volume = unformatNumber($(obj).parents('tr').find('input[name$="[volume]"]').val());
    var hargasatuan = unformatNumber($(obj).parents('tr').find('input[name$="[hargasatuan]"]').val());
    
    $(obj).parents('tr').find('input[name$="[totalharga]"]').val(formatThousandDecimal(volume*hargasatuan));
}
function generateNoPengajuan(kode, klinik){
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GenerateNoPengajuan'); ?>',
        data: {klinik:klinik,kode:kode},
        dataType: "json",
        success:function(data){
            $('#AdvancepaymentT_nopengajuan').val(data.no)
			if (kode == 'AP') {
				$('#KUTandabuktikeluarT_untukpembayaran').val('Advance Payment '+'-'+ $('#AdvancepaymentT_nopengajuan').val())
			}else if (kode == 'ROP') {
				$('#KUTandabuktikeluarT_untukpembayaran').val('Request Of Payment '+'-'+ $('#AdvancepaymentT_nopengajuan').val())
				
			}
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setKlinik(obj){
      setTimeout(function(){     
                $.fn.yiiGridView.update('pegawai-m-grid', {
                    data: {
                        "PegawaiM[profilrs_id]":$(obj).val(),         
                    }
                });
    },500);
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

function setJenisPenerimaanAuto(jenispengeluaran_id){
    
    var is_ada = false;
    $("#tblInputJenisPengeluaran .jenispengeluaran_id").each(function() {
        if ($(this).val() == jenispengeluaran_id) is_ada = true;
    });
    

    if (is_ada) {
        myAlert("Tindakan yang dipilih sudah ditambahkan sebelumnya. Silahkan ubah jumlah-nya.");
        return false;
    }
   
    jenispengeluaran_id = jenispengeluaran_id;
    // dialog = "#dialogDaftarTindakanPaket";
    /*
    if(idDlg != null)
    {
        dialog = idDlg;
    }
    */
    parent = $(dialog).attr("parent-dialog");
    obj = $("#"+parent);
	
	var kelompoktindakan_id;
    $.get('<?php echo Yii::app()->createUrl('rawatJalan/tindakan/daftarTindakan'); ?>',{
        tipepaket_id: tipepaket_id, 
        kelaspelayanan_id:kelaspelayanan_id, 
        daftartindakan_id:daftartindakan_id,
        penjamin_id:penjamin_id
    },function(data){
        $(obj).val(data[0].kategoritindakan_nama);
        $(obj).val(data[0].daftartindakan_nama);
		kelompoktindakan_id = data[0].kelompoktindakan_id;
				
		var old_name_arr = parent.split("_");
		
        setJenisPenerimaanAuto(data[0]);
				
		
		
    },"json");
    $(dialog).dialog("close");
    
	
	//alert(kelompoktindakan_id);
	//var split = 
	
	//alert(parent);
	//addDokterLengkap($("#btnAddDokter_"));
	//$(obj).parents("tr").next().;
}

$(document).ready(function(){
    $('#transfer').hide();
    $('#AdvancepaymentT_jmlpembayaran').val(formatThousandDecimal($('#AdvancepaymentT_jmlpembayaran').val()))
    $('#KUTandabuktikeluarT_biayaadministrasi').val(formatThousandDecimal($('#KUTandabuktikeluarT_biayaadministrasi').val()))
    $('#KUTandabuktikeluarT_jmlkaskeluar').val(formatThousandDecimal($('#KUTandabuktikeluarT_jmlkaskeluar').val()))
})
</script>