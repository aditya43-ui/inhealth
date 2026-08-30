<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function print(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('printTindakan'); ?>&id='+pendaftaran_id,'printwin','left=100,top=100,width=640,height=640');
}
// the subviews rendered with placeholders
var trTindakan=new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'removeButton'=>true),true));?>);
var trTindakanFirst=new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'removeButton'=>false),true));?>);
 
function addRowTindakan(obj)
{
    $(obj).parents('table').children('tbody').append(trTindakan.replace());
    <?php 
        $attributes = $modTindakan->attributeNames(); 
        foreach($attributes as $i=>$attribute){
            echo "renameInput('RITindakanPelayananT','$attribute');";
        }
    ?>
    renameInput('RITindakanPelayananT','daftartindakanNama');
    renameInput('RITindakanPelayananT','kategoriTindakanNama');
    renameInput('RITindakanPelayananT','persenCyto');
    renameInput('RITindakanPelayananT','tarif_tindakan');
    renameInput('RITindakanPelayananT','tgl_tindakan');
    renameInput('RITindakanPelayananT','keltindakanid');
     $('#tblInputTindakan tbody').each(function(){
        jQuery('input[name$="[tgl_tindakan]"]').datetimepicker(
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
    jQuery('input[name$="[daftartindakanNama]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
                                                                                    $(this).val( ui.item.label);
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    
                                                                                    var is_ada = false;
                                                                                    $("#tblInputTindakan .daftartindakan_id").each(function() {
                                                                                        if ($(this).val() == ui.item.daftartindakan_id) is_ada = true;
                                                                                    });

                                                                                    if (is_ada) {
                                                                                        $(this).val("");
                                                                                        myAlert("Tindakan yang dipilih sudah ditambahkan sebelumnya. Silakan ubah jumlah-nya.");
                                                                                        return false;
                                                                                    }
                                                                                    
                                                                                    setTindakan(this, ui.item);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/DaftarTindakan');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        term: request.term,
                                                                                                        tipepaket_id: $("#RITindakanPelayananT_0_tipepaket_id").val(),
                                                                                                        penjamin_id: $("#penjamin_id").val(),
                                                                                                        kelaspelayanan_id: $("#kelaspelayanan_id").val(),
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });   
    jQuery('#tblInputTindakan tr:last .tanggal').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
}
 
function batalTindakan(obj)
{
    myConfirm("Apakah Anda yakin akan membatalkan tindakan?","Perhatian!",function(r) {
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();

            <?php 
                foreach($attributes as $i=>$attribute){
                    echo "renameInput('RITindakanPelayananT','$attribute');";
                }
            ?>
            renameInput('RITindakanPelayananT','daftartindakanNama');
            renameInput('RITindakanPelayananT','kategoriTindakanNama');
            renameInput('RITindakanPelayananT','persenCyto');
            renameInput('RITindakanPelayananT','tarif_tindakan');
			renameInput('RITindakanPelayananT','tgl_tindakan');
			renameInput('RITindakanPelayananT','keltindakanid');
			hitungTotalTarif();
        }
    });
}
 
function deleteTindakan(obj,idTindakanpelayanan)
{
    myConfirm("Apakah Anda yakin akan menghapus tindakan?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxDeleteTindakanPelayanan') ?>', {idTindakanpelayanan: idTindakanpelayanan}, function(data){
                if(data.success && data.pesan =='berhasil'){
                    myAlert('Data berhasil dihapus.');
                    $(obj).parent().parent().detach();
                } else if(data.pesan == 'gagal'){
                    myAlert('Tindakan sudah dibayarkan');
                }else{
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
        $(this).find('input[name^="daftartindakanNama["]').attr('name','daftartindakanNama['+i+']');
        $(this).find('input[name^="daftartindakanNama["]').attr('id','daftartindakanNama_'+i+'');
        $(this).find('a[id^="btnAddDokter_"]').attr('id','btnAddDokter_'+i+'');
    });
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tblInputTindakan tr').length;
    var i = -1;
    $('#tblInputTindakan tr').each(function(){
        if($(this).has('input[name$="[daftartindakan_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('input[name^="daftartindakanNama["]').attr('name','daftartindakanNama['+i+']');
        $(this).find('input[name^="daftartindakanNama["]').attr('id','daftartindakanNama_'+i+'');
        $(this).find('a[id^="btnAddDokter_"]').attr('id','btnAddDokter_'+i+'');
        $(this).find('div[id^="tampilanDokterPemeriksa_"]').attr('id','tampilanDokterPemeriksa_'+i+'');
        $(this).find('div[id^="tampilanDokterDelegasi_"]').attr('id','tampilanDokterDelegasi_'+i+'');
        $(this).find('div[id^="tampilanDokterAnastesi_"]').attr('id','tampilanDokterAnastesi_'+i+'');
        $(this).find('div[id^="tampilanBidan_"]').attr('id','tampilanBidan_'+i+'');
        $(this).find('div[id^="tampilanSuster_"]').attr('id','tampilanSuster_'+i+'');
        $(this).find('div[id^="tampilanPerawat_"]').attr('id','tampilanPerawat_'+i+'');
        $(this).find('div[id^="tampilanPerawat2_"]').attr('id','tampilanPerawat2_'+i+'');
        $(this).find('div[id^="tampilanPerawat3_"]').attr('id','tampilanPerawat3_'+i+'');
		$(this).find('div[id^="tampilanSupir_"]').attr('id','tampilanSupir_'+i+'');
        $(this).find('input[id="row"]').attr('value',i);
        $(this).find('input[id="row"]').val(i);
         $(this).find('input[name^="tgl_tindakan["]').attr('name','tgl_tindakan['+i+']');
        $(this).find('input[name^="tgl_tindakan["]').attr('id','tgl_tindakan_'+i+'');
       // jQuery('input[name$="[daftartindakanNama]"]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
       jQuery('input[name^="tgl_tindakan["]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
        
    });
}

// addDokter = tidak digunakan -> diganti dengan addDokterLengkap
function addDokter(obj)
{
    $('#dialogPemeriksa').dialog('open');
    $('#dialogPemeriksa #rowTindakan').val($(obj).attr('id'));
}

function addDokterLengkap(obj)
{
    $('#dialogPemeriksaLengkap').dialog('open');
    $('#dialogPemeriksaLengkap #rowTindakan').val($(obj).parent().find('input[id="row"]').val());
    
    row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    var dokterpemeriksa1 = $('#tampilanDokterPemeriksa_'+row).html();
    var dokterpemeriksa2 = $('#tampilanDokterDelegasi_'+row).html();
    var dokteranastesi = $('#tampilanDokterAnastesi_'+row).html();
    var perawat_id = $('#tampilanPerawat_'+row).html();
    var perawat2_id = $('#tampilanPerawat2_'+row).html();
    var perawat3_id = $('#tampilanPerawat3_'+row).html();
    var bidan_id = $('#tampilanBidan_'+row).html();
	var supir_id = $('#tampilanSupir_'+row).html();
    
    if (dokterpemeriksa1.indexOf(":") != -1) dokterpemeriksa1 = dokterpemeriksa1.split(":")[1].trim();
    if (dokterpemeriksa2.indexOf(":") != -1) dokterpemeriksa2 = dokterpemeriksa2.split(":")[1].trim();
    if (dokteranastesi.indexOf(":") != -1) dokteranastesi = dokteranastesi.split(":")[1].trim();
    if (perawat_id.indexOf(":") != -1) perawat_id = perawat_id.split(":")[1].trim();
    if (perawat2_id.indexOf(":") != -1) perawat2_id = perawat2_id.split(":")[1].trim();
    if (perawat3_id.indexOf(":") != -1) perawat3_id = perawat3_id.split(":")[1].trim();
    if (bidan_id.indexOf(":") != -1) bidan_id = bidan_id.split(":")[1].trim();
	if (supir_id.indexOf(":") != -1) supir_id = supir_id.split(":")[1].trim();
    
    $('#dialogPemeriksaLengkap #dokterpemeriksa1_id').val(dokterpemeriksa1);
    $('#dialogPemeriksaLengkap #dokterdelegasi_id').val(dokterpemeriksa2);
    $('#dialogPemeriksaLengkap #dokteranastesi_id').val(dokteranastesi);
    $('#dialogPemeriksaLengkap #perawat_id').val(perawat_id);
    $('#dialogPemeriksaLengkap #perawat2_id').val(perawat2_id);
    $('#dialogPemeriksaLengkap #perawat3_id').val(perawat3_id);
    $('#dialogPemeriksaLengkap #bidan_id').val(bidan_id);
	$('#dialogPemeriksaLengkap #supir_id').val(supir_id);
    
}
function setDefaultDokterPemeriksa1(){
    var dokterId = <?php echo (empty($modTindakan->dokterpemeriksa1_id)) ? "" : $modTindakan->dokterpemeriksa1_id; ?>;
    var dokterNama = "<?php echo (empty($modTindakan->dokterpemeriksa1_id)) ? "" : $modTindakan->dokterpemeriksa1Nama ?>";
    if(dokterId != ""){
        $('#dialogPemeriksaLengkap #dokterpemeriksa1_id').val(dokterNama);
    }
}
setDefaultDokterPemeriksa1();
function setDokterPemeriksa1(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RITindakanPelayananT_'+row+'_dokterpemeriksa1_id').val(item.pegawai_id);
    $('#tampilanDokterPemeriksa_'+row).html("Dokter Pemeriksa : "+item.nama_pegawai);
}
function updateDokterPemeriksa1(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_dokterpemeriksa1_id').val('');
		$('#tampilanDokterPemeriksa_'+row).html('');
	}
}
// function setDokterPemeriksa2(item)
// {
//     var idBtnAddDokter = $('#dialogPemeriksaLengkap #rowTindakan').val();
//     $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpemeriksa2_id]"]').val(item.pegawai_id);
// }

// function setDokterPendamping(item)
// {
//     var idBtnAddDokter = $('#dialogPemeriksaLengkap #rowTindakan').val();
//     $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpendamping_id]"]').val(item.pegawai_id);
// }

function setDokterAnastesi(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RITindakanPelayananT_'+row+'_dokteranastesi_id').val(item.pegawai_id);
    $('#tampilanDokterAnastesi_'+row).html("Dokter Anastesi : "+item.nama_pegawai);
    /*
     var idBtnAddDokter = $('#dialogPemeriksaLengkap #rowTindakan').val();
     $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokteranastesi_id]"]').val(item.pegawai_id); */
}

function updateDokterAnastesi(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_dokteranastesi_id').val('');
		$('#tampilanDokterAnastesi_'+row).html('');
	}
}
       
function setDokterDelegasi(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RITindakanPelayananT_'+row+'_dokterdelegasi_id').val(item.pegawai_id);
    $('#tampilanDokterDelegasi_'+row).html("Dokter Delegasi : "+item.nama_pegawai);
}
function updateDokterDelegasi(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_dokterdelegasi_id').val('');
		$('#tampilanDokterDelegasi_'+row).html('');
	}
}
function setBidan(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RITindakanPelayananT_'+row+'_bidan_id').val(item.pegawai_id);
	$('#tampilanBidan_'+row).html("Bidan : "+item.nama_pegawai);
}
function updateBidan(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_bidan_id').val('');
		$('#tampilanBidan_'+row).html('');
	}
}
function setSuster(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RITindakanPelayananT_'+row+'_suster_id').val(item.pegawai_id);
	$('#tampilanSuster_'+row).html("Suster : "+item.nama_pegawai);
}
function updateSuster(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_suster_id').val('');
		$('#tampilanSuster_'+row).html('');
	}
}
function setPerawat(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RITindakanPelayananT_'+row+'_perawat_id').val(item.pegawai_id);
	$('#tampilanPerawat_'+row).html("Perawat : "+item.nama_pegawai);
} 
function setPerawat2(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RITindakanPelayananT_'+row+'_perawat2_id').val(item.pegawai_id);
	$('#tampilanPerawat2_'+row).html("Perawat 2 : "+item.nama_pegawai);
} 
function setPerawat3(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RITindakanPelayananT_'+row+'_perawat3_id').val(item.pegawai_id);
	$('#tampilanPerawat3_'+row).html("Perawat 3 : "+item.nama_pegawai);
} 

function updatePerawat(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_perawat_id').val('');
		$('#tampilanPerawat_'+row).html('');
	}
}
function updatePerawat2(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_perawat2_id').val('');
		$('#tampilanPerawat2_'+row).html('');
	}
}
function updatePerawat3(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_perawat3_id').val('');
		$('#tampilanPerawat3_'+row).html('');
	}
}

function setSupir(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
	if(item != null){
		$('#RITindakanPelayananT_'+row+'_supir_id').val(item.pegawai_id);
		$('#tampilanSupir_'+row).html("Supir : "+item.nama_pegawai);
	}
} 

function updateSupir(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_supir_id').val('');
		$('#tampilanSupir_'+row).html('');
	}
}

function setTindakan(obj,item)
{
    var hargaTindakan = unformatNumber(parseFloat(item.harga_tariftindakan));
    var subsidiAsuransi = unformatNumber(parseFloat(item.subsidiasuransi));
    var subsidiPemerintah = unformatNumber(parseFloat(item.subsidipemerintah));
    var subsidiRumahsakit = unformatNumber(parseFloat(item.subsidirumahsakit));
    if(isNaN(subsidiAsuransi))subsidiAsuransi=0;
    if(isNaN(subsidiPemerintah))subsidiPemerintah=0;
    if(isNaN(subsidiRumahsakit))subsidiRumahsakit=0;

    var hargacyto_tarif = 0
    if(item.totaltarifakhir_cyto != undefined){
        hargacyto_tarif = unformatNumber(parseFloat(item.totaltarifakhir_cyto));
    }

    $(obj).parents('tr').find('input[name$="[kategoriTindakanNama]"]').val(item.kategoritindakan_nama);
    $(obj).parents('tr').find('input[name$="[daftartindakan_id]"]').val(item.daftartindakan_id);
    $(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val(formatThousandDecimal(unformatNumber(parseFloat(item.harga_tariftindakan))));
    $(obj).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val(formatThousandDecimal(hargacyto_tarif));
    $(obj).parents('tr').find('input[name$="[qty_tindakan]"]').val('1');
    $(obj).parents('tr').find('input[name$="[persenCyto]"]').val(formatThousandDecimal(unformatNumber(parseFloat(item.persencyto_tind))));
    $(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val(formatThousandDecimal(hargaTindakan));
    $(obj).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(formatThousandDecimal(subsidiAsuransi));
    $(obj).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(formatThousandDecimal(subsidiPemerintah));
    $(obj).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(formatThousandDecimal(subsidiRumahsakit));
    $(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(formatThousandDecimal(hargaTindakan - (subsidiAsuransi + subsidiPemerintah +subsidiRumahsakit)));
	$(obj).parents('tr').find('input[name$="[keltindakanid]"]').val(item.kelompoktindakan_id);
    //$(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(item.iurbiaya);
    tambahTindakanPemakaianBahan(item.daftartindakan_id,item.label);

    //var tombolAddDokter = $(obj).parents('tr').next().find('a');
    //DIDISABLE KARENA DEFAULT SUDAH DOKTER SAAT PENDAFTARAN >>> addDokter(tombolAddDokter);
	//// input bmhp di commnet karena formnya tidak digunakan
    //inputBMHP(item.daftartindakan_id, $("#RIPendaftaranT_kelompokumur_id").val());
	hitungTotalTarif();
}

function tambahTindakanPemakaianBahan(value,label)
{
    $('#daftartindakanPemakaianBahan').append('<option value="'+value+'">'+label+'</option>');
}

function loadTindakanPaket(tipepaket_id,kelaspelayanan_id, kelompokumur_id, pendaftaran_id)
{
    //myAlert(tipepaket_id);
    //var idNonPaket = <?php echo Params::TIPEPAKET_ID_NONPAKET; ?>; 
    
    $.post('<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/loadFormTindakanPaket') ?>', {tipepaket_id: tipepaket_id, kelaspelayanan_id:kelaspelayanan_id, kelompokumur_id:kelompokumur_id, pendaftaran_id:pendaftaran_id}, function(data){
        if(data.form == '')
            $('#tblInputTindakan > tbody').html(trTindakanFirst.replace());
        else
            $('#tblInputTindakan > tbody').html(data.form); 
        
        $("#tblInputTindakan > tbody .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
        $('.integer').each(function(){this.value = formatNumber(this.value)});
        
        $('#tblInputPaketBhp > tbody').html(data.formPaketBmhp);
        $('#totHargaBmhp').val(formatNumber(data.totHargaBmhp));
        $('#tblInputPemakaianBahan > tbody').html('');
        $('#daftartindakanPemakaianBahan').html(data.optionDaftarttindakan);
        
    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    jQuery('input[name$="[daftartindakanNama]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
                $(this).val( ui.item.label);
                return false;
            },'select':function( event, ui ) {
                
                
                var is_ada = false;
                $("#tblInputTindakan .daftartindakan_id").each(function() {
                    if ($(this).val() == ui.item.daftartindakan_id) is_ada = true;
                });

                if (is_ada) {
                    $(this).val("");
                    myAlert("Tindakan yang dipilih sudah ditambahkan sebelumnya. Silakan ubah jumlah-nya.");
                    return false;
                }
                                                                                    
                setTindakan(this, ui.item);
                return false;
            },'source':function(request, response) {
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/DaftarTindakan');?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                        tipepaket_id: $("#RITindakanPelayananT_0_tipepaket_id").val(),
                        penjamin_id: $("#penjamin_id").val(),
                        kelaspelayanan_id: $("#kelaspelayanan_id").val(),
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }
            });  
       jQuery('input[name$="[tgl_tindakan]"]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
    }, 'json');
    
}

function hitungCyto(obj)
{
    var cyto = $(obj).parents("#tblInputTindakan tr").find('select[name$="[cyto_tindakan]"]').val();
    
    if(cyto == 1){
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').hide();
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').show();
    }else{
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').show();
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').hide();
    }

    // var tarifSatuan = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').val());
    // var qty = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[qty_tindakan]"]').val());
    // var persenCyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[persenCyto]"]').val());
    // var cyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('select[name$="[cyto_tindakan]"]').val());
    // if(cyto == '0')
    //     persenCyto = 0;
    // var tarifCyto = qty * tarifSatuan * persenCyto / 100;
    // var subTotal = tarifSatuan * qty + tarifCyto;
    // $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').val(formatNumber(tarifCyto));
    // $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_tindakan]"]').val(formatNumber(subTotal));
    // hitungTotal(); 
	hitungTotalTarif();
}

function hitungSubtotal(obj)
{
    // var tarifSatuan = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').val());
    // var qty = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[qty_tindakan]"]').val());
    // var persenCyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[persenCyto]"]').val());
    // var cyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('select[name$="[cyto_tindakan]"]').val());
    // if(cyto == '0')
    //     persenCyto = 0;
    // var tarifCyto = qty * tarifSatuan * persenCyto / 100;
    // var subTotal = tarifSatuan * qty + tarifCyto;
    // $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').val(formatNumber(tarifCyto));
    // $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_tindakan]"]').val(formatNumber(subTotal));
    // hitungTotal();
	hitungTotalTarif();
}

function hitungTotalTarif()
{
    var totalTarif = 0;
    $('#tblInputTindakan tr').find('input[name$="[qty_tindakan]"]').each(function(){
        var tarifSatuan = parseFloat(unformatNumber($(this).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').val()));
        var tarif_cyto = parseFloat(unformatNumber($(this).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').val()));
        var qty = parseFloat(unformatNumber($(this).parents("#tblInputTindakan tr").find('input[name$="[qty_tindakan]"]').val()));
        var ctyoIs = $(this).parents("#tblInputTindakan tr").find('select[name$="[cyto_tindakan]"]').val();

        var satuantindakan = tarifSatuan;
        
        if(ctyoIs == 1){
            satuantindakan = tarif_cyto;
        }
        
        var total = (satuantindakan * qty);

        if(total > 0){
            total = parseFloat(total.toFixed(2));
        }
        $(this).parents("#tblInputTindakan tr").find('input[name$="[tarif_tindakan]"]').val(formatThousandDecimal(total));

        totalTarif += total;
    });
    $('#totalTarif').val(formatThousandDecimal(totalTarif));
}

function testUpdateStok(qty,obatalkes_id)
{
    $.post('<?php echo $this->createUrl('updateStok') ?>', {qty:qty, obatalkes_id:obatalkes_id}, function(data){
            myAlert(data.input);
        }, 'json');
}

function cekInput()
{
    
    var kosong = 0 ;
	var deposit = $('#deposit').val();
	var totTarif = unformatNumber($('#totalTarif').val());
	var totPemakaianBahan = unformatNumber($('#totPemakaianBahan').val());
	var totHargaBmhp = unformatNumber($('#totHargaBmhp').val());
	var total =  totPemakaianBahan + totHargaBmhp + totTarif;
			
    $('#tblInputTindakan').find('[name*="daftartindakan_id"]').each(function(){
        if($(this).val()==""){
            kosong++;
        }
    });
    if(kosong==0){
//        return true;  
    }else{
        myAlert('Isi dulu uraian tindakan!');
        return false;
    }
	hitungTotalTarif();
        /*
	if (deposit == ""){
		 myConfirm("Pasien Belum Melakukan Deposit!","Perhatian!",function(r) {
			if(r){	
				// notifikasi
				var totalTarif =  $('#totalTarif').val();
				var params = [];
				params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:19, judulnotifikasi:'Deposit Tidak Mencukupi', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik; echo "-"; echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp <?php echo isset($modDeposit)? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp ' + totalTarif + '. Silakan hubungi kasir'};
				insert_notifikasi(params);
				simpanTransaksi();
			}
		});
	}else{
		if (deposit < total){
			var pendaftaran_id = <?php echo $_GET['pendaftaran_id']; ?>;
			
			$.ajax({
				type:'POST',
				url: "<?php echo $this->createUrl('cekDeposit');?>",
				dataType: "json",
				data: {pendaftaran_id : pendaftaran_id},
				success: function (data) {
					if(data.tglperjanjian == null){
						$('#dialogDeposit').dialog("open");
						myAlert("Uang deposit pasien tidak mencukupi, Buat tanggal perjanjian terlebih dahulu");
					}else{
						$.ajax({
							type:'POST',
							url: "<?php echo $this->createUrl('cekTanggalPerjanjian');?>",
							dataType: "json",
							data: {bayaruangmuka_id : data.bayaruangmuka_id},
							success: function (data) {
								if(data==true){
									simpanTransaksi();
								}else{
									$('#dialogDeposit').dialog("open");
									myAlert("Uang deposit pasien tidak mencukupi , Perbaharui tanggal perjanjian terlebih dahulu");
								}
							}
						});
					}
				}
			});
		}else{ */
		simpanTransaksi();
		// }
	//}
}

function simpanTransaksi(){
    $(".integer2, .float2, .integer-decimal, .integer").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });
	disableOnSubmit('#btn_submit');
	$('#rjtindakan-pelayanan-t-form').submit();
}

function simpanDeposit(){
	var bayaruangmuka_id = $("#RIBayaruangmukaT_bayaruangmuka_id").val();
	var tglperjanjian = $("#RIBayaruangmukaT_tglperjanjian").val();
	var ketperjanjian = $("#RIBayaruangmukaT_keterangan_perjanjian'").val();
	if((tglperjanjian!='')&&(ketperjanjian!='')){
		$('#btn_savedeposit').addClass('animation-loading-1');
		$.ajax({
			type:'POST',
			url: "<?php echo $this->createUrl('UpdateDepositPasien');?>",
			dataType: "json",
			data: {bayaruangmuka_id:bayaruangmuka_id,tglperjanjian:tglperjanjian,ketperjanjian:ketperjanjian},
			success: function (data) {
				if(data==true){
					myAlert("Berhasil disimpan! untuk melanjutkan klik 'Lanjutkan' ");
					$('#btn_savedeposit').attr('disabled',true);
					$('#btn_lanjutdeposit').attr('disabled',false);
					$("#RIBayaruangmukaT_tglperjanjian").attr('disabled',true);
					$("#RIBayaruangmukaT_keterangan_perjanjian").attr('disabled',true);
				}else{
					myAlert("Gagal disimpan");
				}
				$('#btn_savedeposit').removeClass('animation-loading-1');
			}
		});
	}else{
		myAlert('Tanggal Perjanjian dan Keterangan Perjanjian tidak boleh kosong');
	}
}

function setDialog(obj){
    $("#dialogpemeriksaan-m-grid").find("tr").removeClass("yellow_background");
    var tipepaket_id = $("#<?php echo CHtml::activeId($modTindakan,'[0]tipepaket_id'); ?>").val();
    var kelaspelayanan_id = $('#kelaspelayanan_id').val();
    var penjamin_id = <?php echo $modAdmisi->penjamin_id; ?>;
    var jenistarif_id = <?php echo $modJenisTarif->jenistarif_id; ?>;
    var jenistarif_nama = "<?php echo "Daftar Tindakan - ".$modJenisTarif->jenistarif->jenistarif_nama; ?>";
//    $.get('<?php echo Yii::app()->createUrl($this->route, array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));?>',{'set_tindakan':1,tipepaket_id: tipepaket_id, kelaspelayanan_id:kelaspelayanan_id},function(data){
//        $("#tableDaftarTindakanPaket").html(data);
//    });
    $('#tipepaket_id').val(tipepaket_id);
    $('#kelaspelayanan_id').val(kelaspelayanan_id);
    $.fn.yiiGridView.update('giladiagnosa-m-grid2', {
        data: {
            "RIPaketpelayananV[kelaspelayanan_id]":kelaspelayanan_id,
            "RIPaketpelayananV[tipepaket_id]":tipepaket_id,
            "RIPaketpelayananV[penjamin_id]":penjamin_id,
            "RIPaketpelayananV[jenistarif_id]":jenistarif_id,
        }
    });
    $("#ui-dialog-title-dialogDaftarTindakanPaket").html(jenistarif_nama);
    parent = $(obj).parents(".input-append").find("input").attr("id");
    dialog = "#dialogDaftarTindakanPaket";
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");
}
function setTindakanAuto(kelaspelayanan_id,daftartindakan_id){
    
    var is_ada = false;
    $("#tblInputTindakan .daftartindakan_id").each(function() {
        if ($(this).val() == daftartindakan_id) is_ada = true;
    });
    
    if (is_ada) {
        myAlert("Tindakan yang dipilih sudah ditambahkan sebelumnya. Silakan ubah jumlah-nya.");
        return false;
    }
    
    
    tipepaket_id = $("#<?php echo CHtml::activeId($modTindakan,'[0]tipepaket_id'); ?>").val();
    kelaspelayanan_id = $('#kelaspelayanan_id').val();
    penjamin_id = $('#penjamin_id').val();
    daftartindakan_id = daftartindakan_id;
    dialog = "#dialogDaftarTindakanPaket";
    /*
    if(idDlg != null)
    {
        dialog = idDlg;
    }
    */
    parent = $(dialog).attr("parent-dialog");
    obj = $("#"+parent);
    $.get('<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/daftarTindakan'); ?>',{tipepaket_id: tipepaket_id, kelaspelayanan_id:kelaspelayanan_id, daftartindakan_id:daftartindakan_id,penjamin_id:penjamin_id},function(data){
        $(obj).val(data[0].kategoritindakan_nama);
        $(obj).val(data[0].daftartindakan_nama);
		
		kelompoktindakan_id = data[0].kelompoktindakan_id;
				
		var old_name_arr = parent.split("_");
		
        setTindakan(obj,data[0]);
		
		if (kelompoktindakan_id == <?php echo Params::KELOMPOKTINDAKAN_ID_AMBULANS ?>){
			
			alert("Untuk tindakan ini, silakan isi data pengantar untuk perawat dan supir");
			addDokterLengkap($("#btnAddDokter_"+old_name_arr[1]));
		}
		
    },"json");
    $(dialog).dialog("close");
    
}

function dialogFOC(obj,tindakanpelayanan_id){
    if($(obj).prop('checked') == true){
        $('#foc_transaksi_'+tindakanpelayanan_id).show();
        $('#foc_transaksi_'+tindakanpelayanan_id).addClass('animation-loading-1');
        $('#foc_transaksi_'+tindakanpelayanan_id).find('#tbl_tindakanpembebasan').find('tbody').html('');

        $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('loadPembebasanTindakan'); ?>',
            data: {tindakanpelayanan_id:tindakanpelayanan_id},
            dataType: "json",
            success:function(data){
                $('#foc_transaksi_'+tindakanpelayanan_id).find('#tbl_tindakanpembebasan').find('tbody').html(data);
                $('#foc_transaksi_'+tindakanpelayanan_id).removeClass('animation-loading-1');
                
                
                $('#foc_transaksi_'+tindakanpelayanan_id).find('#tbl_tindakanpembebasan').find('tbody').find('.detail_komp').each(function(){
                    if($(this).find('input[name*="[pembebasantarif_id]"]').val() == ''){
                        $(this).find(".checklist").attr('checked',true);
                    }
                    changePembebasan($(this).find(".checklist"), tindakanpelayanan_id);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $('#foc_transaksi_'+tindakanpelayanan_id).removeClass('animation-loading-1');}
        });
        
    }else{
        $('#foc_transaksi_'+tindakanpelayanan_id).hide();
        $('#foc_transaksi_'+tindakanpelayanan_id).find('tbody').html('');
    }
}

function changePembebasan(obj, tindakanpelayanan_id){
    if($(obj).prop("checked") == true){
        $(obj).parents('.detail_komp').find('input, select').not('input[type="checkbox"]').attr('disabled',false);
    }else{
        $(obj).parents('.detail_komp').find('input, select').not('input[type="checkbox"]').attr('disabled',true);
    }
    hitungTotalPembebasan(tindakanpelayanan_id); 
}

function hitungTotalPembebasan(tindakanpelayanan_id) {
    unformatNumberSemua();
    var totaltarif = 0;
    var totalpembebasan = 0;
    var totalsetelahpembebasan = 0;
    
    $('#foc_transaksi_'+tindakanpelayanan_id).find('#tbl_tindakanpembebasan').find("tbody").find('.detail_komp').each(function () {
        if ($(this).find(".checklist").prop("checked") == true){
            var tarif = parseFloat($(this).find('input[name*="[tarif]"]').val());
            var pembebasan = parseFloat($(this).find('input[name*="[tarif_tindakankomp]"]').val());

            if(pembebasan > tarif){
                $(this).find('input[name*="[tarif_tindakankomp]"]').val(0);
                pembebasan = 0;
                myAlert('Total Pembebasan tidak boleh melebihi Tarif !!!');
            }
            var setelahpembebasan = (tarif - pembebasan);
            if(setelahpembebasan > 0){
                setelahpembebasan = parseFloat(setelahpembebasan.toFixed(2));
            }

            $(this).find('input[name*="[tarif_setelahpembebasan]"]').val(setelahpembebasan);

            totaltarif += tarif;
            totalpembebasan += pembebasan;
            totalsetelahpembebasan += setelahpembebasan;
        }
    });

    $('#foc_transaksi_'+tindakanpelayanan_id).find('#tbl_tindakanpembebasan').find("#total_tarif_pembebasan").val(totaltarif);
    $('#foc_transaksi_'+tindakanpelayanan_id).find('#tbl_tindakanpembebasan').find("#total_pembebasan").val(totalpembebasan);
    $('#foc_transaksi_'+tindakanpelayanan_id).find('#tbl_tindakanpembebasan').find("#total_setalahpembebasan").val(totalsetelahpembebasan);
    formatNumberSemua();
}

function simpanPembebasan(tindakanpelayanan_id){
    $('#foc_transaksi_'+tindakanpelayanan_id).find('#td_simpanpembebasan').addClass('animation-loading-1');
    $('#foc_transaksi_'+tindakanpelayanan_id).find('.alert_pembebasan').html('');
    $('#foc_transaksi_'+tindakanpelayanan_id).find(".integer-decimal, .integer2, .float2").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });

    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('savePembebasanTindakan'); ?>',
        data: $('#foc_transaksi_'+tindakanpelayanan_id).find('input, textarea, select').serialize(),
        dataType: "json",
        success:function(data){
            suksesData = false;
          if(data != ""){
            if(data.sukses > 0){
              suksesData = true;
              $('#foc_transaksi_'+tindakanpelayanan_id).find('.alert_pembebasan').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
            }else{
                $('#foc_transaksi_'+tindakanpelayanan_id).find('.alert_pembebasan').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
            }
            if(suksesData==true){
              setTimeout(function(){
                $('#foc_transaksi_'+tindakanpelayanan_id).find('.alert_pembebasan').html('');
              }, 5000);
            }
          }else{
              $('#foc_transaksi_'+tindakanpelayanan_id).find('.alert_pembebasan').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
          }
          $('#foc_transaksi_'+tindakanpelayanan_id).find('#td_simpanpembebasan').removeClass('animation-loading-1');
          hitungTotalPembebasan(tindakanpelayanan_id);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $('#foc_transaksi_'+tindakanpelayanan_id).find('#td_simpanpembebasan').removeClass('animation-loading-1');}
    });
}


function dialogReturTindakan(obj,tindakanpelayanan_id, tindakansudahbayar_id){
    if($(obj).prop('checked') == true){
        $('#returtindakan_transaksi_'+tindakanpelayanan_id).show();
        $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#tbl_returtindakan').show();
        $('#returtindakan_transaksi_'+tindakanpelayanan_id).addClass('animation-loading-1');
        $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#tbl_returtindakan').find('tbody').html('');

        $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('loadReturTindakan'); ?>',
            data: {tindakanpelayanan_id:tindakanpelayanan_id, tindakansudahbayar_id: tindakansudahbayar_id},
            dataType: "json",
            success:function(data){
                if(data.pesan != ''){
                    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('.alert_returtindakan').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                    setTimeout(function(){
                        $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('.alert_returtindakan').html('');
                    }, 5000);
                }
                if(data.issudahretur == false){
                    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#tbl_returtindakan').find('tbody').html(data.form);
                }else{
                    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#tbl_returtindakan').hide();
                    $('#returtindakan_riwayat').attr('checked',false);
                }
                
                $('#returtindakan_transaksi_'+tindakanpelayanan_id).removeClass('animation-loading-1');

                $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#tbl_returtindakan').find('tbody').find('.detail_komp').each(function(){
                    changeReturTagihan($(this).find(".checklist"), tindakanpelayanan_id);
                });

                if($('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#tbl_returtindakan').find('tbody').find('.detail_komp').length == 0){
                    hitungTotalRetur(tindakanpelayanan_id); 
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $('#returtindakan_transaksi_'+tindakanpelayanan_id).removeClass('animation-loading-1');}
        });
        
    }else{
        $('#returtindakan_transaksi_'+tindakanpelayanan_id).hide();
        $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('tbody').html('');
    }
}

function changeReturTagihan(obj, tindakanpelayanan_id){
    if($(obj).prop("checked") == true){
        $(obj).parents('.detail_komp').find('input, select').not('input[type="checkbox"]').attr('disabled',false);
    }else{
        $(obj).parents('.detail_komp').find('input, select').not('input[type="checkbox"]').attr('disabled',true);
    }
    hitungTotalRetur(tindakanpelayanan_id); 
}


function hitungTotalRetur(tindakanpelayanan_id) {
    unformatNumberSemua();
    var totaltarif = 0;
    var totalretur = 0;
    var totalsetelahretur = 0;
    
    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#tbl_returtindakan').find("tbody").find('.detail_komp').each(function () {
        if ($(this).find(".checklist").prop("checked") == true){
            var tarif = parseFloat($(this).find('input[name*="[tarif]"]').val());
            var retur = parseFloat($(this).find('input[name*="[hargaretur]"]').val());

            if(retur > tarif){
                $(this).find('input[name*="[hargaretur]"]').val(0);
                retur = 0;
                myAlert('Total Harga Retur tidak boleh melebihi Tarif !!!');
            }
            var setelahretur = (tarif - retur);
            if(setelahretur > 0){
                setelahretur = parseFloat(setelahretur.toFixed(2));
            }

            $(this).find('input[name*="[tarif_setelahretur]"]').val(setelahretur);

            totaltarif += tarif;
            totalretur += retur;
            totalsetelahretur += setelahretur;
        }
    });

    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#tbl_returtindakan').find("#total_tarifretur").val(totaltarif);
    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#tbl_returtindakan').find("#total_retur").val(totalretur);
    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#tbl_returtindakan').find("#total_setelahretur").val(totalsetelahretur);
    formatNumberSemua();
}


function simpanRetur(tindakanpelayanan_id){
    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#td_simpanretur').addClass('animation-loading-1');
    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('.alert_returtindakan').html('');
    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find(".integer-decimal, .integer2, .float2").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });

    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('saveReturTindakan'); ?>',
        data: $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('input, textarea, select').serialize(),
        dataType: "json",
        success:function(data){
          suksesData = false;
          if(data != ""){
            if(data.sukses > 0){
              suksesData = true;
              $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('.alert_returtindakan').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
            }else{
                $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('.alert_returtindakan').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
            }
            if(suksesData==true){
              setTimeout(function(){
                $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('.alert_returtindakan').html('');
              }, 5000);
            }
          }else{
              $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('.alert_returtindakan').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
          }
          $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#td_simpanretur').removeClass('animation-loading-1');
          hitungTotalRetur(tindakanpelayanan_id);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $('#returtindakan_transaksi_'+tindakanpelayanan_id).find('#td_simpanretur').removeClass('animation-loading-1');}
    });
}
</script>
