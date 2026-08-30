<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function print(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('printTindakan'); ?>&id='+pendaftaran_id,'printwin','left=100,top=100,width=640,height=640');
}
// the subviews rendered with placeholders
var trTindakan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'removeButton'=>true),true));?>);
var trTindakanFirst = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'removeButton'=>false),true));?>);

function addRowTindakan(obj)
{
    $(obj).parents('table').children('tbody').append(trTindakan.replace());
    <?php 
        $attributes = $modTindakan->attributeNames(); 
        foreach($attributes as $i=>$attribute){
            echo "renameInput('RMTindakanPelayananT','$attribute');";
        }
    ?>
    renameInput('RMTindakanPelayananT','daftartindakanNama');
    renameInput('RMTindakanPelayananT','kategoriTindakanNama');
    renameInput('RMTindakanPelayananT','persenCyto');
    renameInput('RMTindakanPelayananT','tarif_tindakan');
    renameInput('RMTindakanPelayananT','tgl_tindakan');
	renameInput('RMTindakanPelayananT','keltindakanid');
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
    jQuery('input[name$="[daftartindakanNama]"]').autocomplete(
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
            },
            'source':function(request, response)
            {
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl('rawatJalan/tindakan/DaftarTindakan');?>",
                    dataType: "json",
                    data:{
                        term: request.term,
                        tipepaket_id: $("#RMTindakanPelayananT_0_tipepaket_id").val(),
                        penjamin_id: $("#RJPendaftaranT_penjamin_id").val(),
                        kelaspelayanan_id: $("#RJPendaftaranT_kelaspelayanan_id").val(),
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }
        }
    );
    
      
}

function batalTindakan(obj)
{
    myConfirm("Apakah Anda yakin akan membatalkan tindakan?","Perhatian!",function(r) {
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();

            <?php 
                foreach($attributes as $i=>$attribute){
                    echo "renameInput('RMTindakanPelayananT','$attribute');";
                }
            ?>
            renameInput('RMTindakanPelayananT','daftartindakanNama');
            renameInput('RMTindakanPelayananT','kategoriTindakanNama');
            renameInput('RMTindakanPelayananT','persenCyto');
            renameInput('RMTindakanPelayananT','tarif_tindakan');
            renameInput('RMTindakanPelayananT','tgl_tindakan');
			renameInput('RMTindakanPelayananT','keltindakanid');
        }
    });
}
 
function deleteTindakan(obj,idTindakanpelayanan)
{
    myConfirm("Apakah Anda yakin akan menghapus tindakan?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxDeleteTindakanPelayanan') ?>', {idTindakanpelayanan: idTindakanpelayanan}, function(data){
                if(data.success)
                {
                    $(obj).parent().parent().detach();
                    myAlert('Data berhasil dihapus.');
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
        $(this).find('input[name^="tgl_tindakan["]').attr('name','tgl_tindakan['+i+']');
        $(this).find('input[name^="tgl_tindakan["]').attr('id','tgl_tindakan_'+i+'');
        $(this).find('a[id^="btnAddDokter_"]').attr('id','btnAddDokter_'+i+'');        
		$(this).find('div[id^="tampilanDokterPemeriksa_"]').attr('id','tampilanDokterPemeriksa_'+i+'');
		$(this).find('div[id^="tampilanDokterPemeriksa2_"]').attr('id','tampilanDokterPemeriksa2_'+i+'');
        $(this).find('div[id^="tampilanDokterDelegasi_"]').attr('id','tampilanDokterDelegasi_'+i+'');
        $(this).find('div[id^="tampilanDokterPendamping_"]').attr('id','tampilanDokterPendamping_'+i+'');
        $(this).find('div[id^="tampilanDokterAnastesi_"]').attr('id','tampilanDokterAnastesi_'+i+'');
        $(this).find('div[id^="tampilanBidan_"]').attr('id','tampilanBidan_'+i+'');
        $(this).find('div[id^="tampilanBidan2_"]').attr('id','tampilanBidan2_'+i+'');
        $(this).find('div[id^="tampilanBidan3_"]').attr('id','tampilanBidan3_'+i+'');
        $(this).find('div[id^="tampilanSuster_"]').attr('id','tampilanSuster_'+i+'');
        $(this).find('div[id^="tampilanPerawat_"]').attr('id','tampilanPerawat_'+i+'');
        $(this).find('div[id^="tampilanPerawat2_"]').attr('id','tampilanPerawat2_'+i+'');
		$(this).find('div[id^="tampilanSupir_"]').attr('id','tampilanSupir_'+i+'');
		$(this).find('input[id="row"]').attr('value',i);
        $(this).find('input[id="row"]').val(i);
//        jQuery('input[name$="[daftartindakanNama]"]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
    });
}

function addDokter(obj)
{
    $('#dialogPemeriksa').dialog('open');
    $('#dialogPemeriksa #rowTindakan').val($(obj).attr('id'));
}

function addDokterLengkap(obj)
{
    var row;
    $('#dialogPemeriksaLengkap').dialog('open');
    $('#dialogPemeriksaLengkap #rowTindakan').val($(obj).parent().find('input[id="row"]').val());
    
    row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    var dokterpemeriksa1 = $('#tampilanDokterPemeriksa_'+row).html();
    var dokterpemeriksa2 = $('#tampilanDokterPemeriksa2_'+row).html();
    var dokterdelegasi = $('#tampilanDokterDelegasi_'+row).html();
    var dokterpendamping = $('#tampilanDokterPendamping_'+row).html();
    var dokteranastesi = $('#tampilanDokterAnastesi_'+row).html();
    var perawat_id = $('#tampilanPerawat_'+row).html();
    var perawat2_id = $('#tampilanPerawat2_'+row).html();
    var bidan_id = $('#tampilanBidan_'+row).html();

	var supir_id = $('#tampilanSupir_'+row).html();

    var bidan2_id = $('#tampilanBidan2_'+row).html();
    var bidan3_id = $('#tampilanBidan3_'+row).html();
    var okupasiterapi_id = $('#tampilanOkupasi_'+row).html();
    var terapiwicara_id = $('#tampilanTerapiwicara_'+row).html();
    var fisioterapi_id = $('#tampilanFisioterapi_'+row).html();

    
    if (dokterpemeriksa1.indexOf(":") != -1) dokterpemeriksa1 = dokterpemeriksa1.split(":")[1].trim();
    if (dokterpemeriksa2.indexOf(":") != -1) dokterpemeriksa2 = dokterpemeriksa2.split(":")[1].trim();
    if (dokterdelegasi.indexOf(":") != -1) dokterdelegasi = dokterdelegasi.split(":")[1].trim();
    if (perawat_id.indexOf(":") != -1) perawat_id = perawat_id.split(":")[1].trim();
    if (perawat2_id.indexOf(":") != -1) perawat2_id = perawat2_id.split(":")[1].trim();
    if (bidan_id.indexOf(":") != -1) bidan_id = bidan_id.split(":")[1].trim();
    if (bidan2_id.indexOf(":") != -1) bidan2_id = bidan2_id.split(":")[1].trim();
    if (dokterpendamping.indexOf(":") != -1) dokterpendamping = dokterpendamping.split(":")[1].trim();
    if (dokteranastesi.indexOf(":") != -1) dokteranastesi = dokteranastesi.split(":")[1].trim();
	if (supir_id.indexOf(":") != -1) supir_id = supir_id.split(":")[1].trim();
    if (okupasiterapi_id.indexOf(":") != -1) okupasiterapi_id = okupasiterapi_id.split(":")[1].trim();
    if (terapiwicara_id.indexOf(":") != -1) terapiwicara_id = terapiwicara_id.split(":")[1].trim();
    if (fisioterapi_id.indexOf(":") != -1) fisioterapi_id = fisioterapi_id.split(":")[1].trim();
    
    $('#dialogPemeriksaLengkap #dokterpemeriksa1_id').val(dokterpemeriksa1);
    $('#dialogPemeriksaLengkap #dokterpemeriksa2_id').val(dokterpemeriksa2);
    $('#dialogPemeriksaLengkap #dokterdelegasi_id').val(dokterdelegasi);
    $('#dialogPemeriksaLengkap #dokterpendamping_id').val(dokterpendamping);
    $('#dialogPemeriksaLengkap #dokteranastesi_id').val(dokteranastesi);
    $('#dialogPemeriksaLengkap #perawat_id').val(perawat_id);
    $('#dialogPemeriksaLengkap #perawat2_id').val(perawat2_id);
    $('#dialogPemeriksaLengkap #bidan_id').val(bidan_id);
	$('#dialogPemeriksaLengkap #supir_id').val(supir_id);
    $('#dialogPemeriksaLengkap #bidan2_id').val(bidan2_id);
    $('#dialogPemeriksaLengkap #okupasiterapi_id').val(okupasiterapi_id);
    $('#dialogPemeriksaLengkap #terapiwicara_id').val(terapiwicara_id);
    $('#dialogPemeriksaLengkap #fisioterapi_id').val(fisioterapi_id);


    
    
    
    
    // load pegawai
    
}

function addDokterLengkap(obj)
{
    var row;
    $('#dialogPemeriksaLengkap').dialog('open');
    $('#dialogPemeriksaLengkap #rowTindakan').val($(obj).parent().find('input[id="row"]').val());
    
    row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    var dokterpemeriksa1 = $('#tampilanDokterPemeriksa_'+row).html();
    var dokterpemeriksa2 = $('#tampilanDokterPemeriksa2_'+row).html();
    var dokterdelegasi = $('#tampilanDokterDelegasi_'+row).html();
    var dokterpendamping = $('#tampilanDokterPendamping_'+row).html();
    var dokteranastesi = $('#tampilanDokterAnastesi_'+row).html();
    var perawat_id = $('#tampilanPerawat_'+row).html();
    var perawat2_id = $('#tampilanPerawat2_'+row).html();
    var bidan_id = $('#tampilanBidan_'+row).html();

	var supir_id = $('#tampilanSupir_'+row).html();

    var bidan2_id = $('#tampilanBidan2_'+row).html();
    var bidan3_id = $('#tampilanBidan3_'+row).html();
    var okupasiterapi_id = $('#tampilanOkupasi_'+row).html();
    var terapiwicara_id = $('#tampilanTerapiwicara_'+row).html();
    var fisioterapi_id = $('#tampilanFisioterapi_'+row).html();
    
    if (dokterpemeriksa1.indexOf(":") != -1) dokterpemeriksa1 = dokterpemeriksa1.split(":")[1].trim();
    if (dokterpemeriksa2.indexOf(":") != -1) dokterpemeriksa2 = dokterpemeriksa2.split(":")[1].trim();
    if (dokterdelegasi.indexOf(":") != -1) dokterdelegasi = dokterdelegasi.split(":")[1].trim();
    if (perawat_id.indexOf(":") != -1) perawat_id = perawat_id.split(":")[1].trim();
    if (perawat2_id.indexOf(":") != -1) perawat2_id = perawat2_id.split(":")[1].trim();
    if (bidan_id.indexOf(":") != -1) bidan_id = bidan_id.split(":")[1].trim();
    if (bidan2_id.indexOf(":") != -1) bidan2_id = bidan2_id.split(":")[1].trim();
    if (dokterpendamping.indexOf(":") != -1) dokterpendamping = dokterpendamping.split(":")[1].trim();
    if (dokteranastesi.indexOf(":") != -1) dokteranastesi = dokteranastesi.split(":")[1].trim();
	if (supir_id.indexOf(":") != -1) supir_id = supir_id.split(":")[1].trim();
    if (okupasiterapi_id.indexOf(":") != -1) okupasiterapi_id = okupasiterapi_id.split(":")[1].trim();
    if (terapiwicara_id.indexOf(":") != -1) terapiwicara_id = terapiwicara_id.split(":")[1].trim();
    if (fisioterapi_id.indexOf(":") != -1) fisioterapi_id = fisioterapi_id.split(":")[1].trim();
    
    $('#dialogPemeriksaLengkap #dokterpemeriksa1_id').val(dokterpemeriksa1);
    $('#dialogPemeriksaLengkap #dokterpemeriksa2_id').val(dokterpemeriksa2);
    $('#dialogPemeriksaLengkap #dokterdelegasi_id').val(dokterdelegasi);
    $('#dialogPemeriksaLengkap #dokterpendamping_id').val(dokterpendamping);
    $('#dialogPemeriksaLengkap #dokteranastesi_id').val(dokteranastesi);
    $('#dialogPemeriksaLengkap #perawat_id').val(perawat_id);
    $('#dialogPemeriksaLengkap #perawat2_id').val(perawat2_id);
    $('#dialogPemeriksaLengkap #bidan_id').val(bidan_id);
	$('#dialogPemeriksaLengkap #supir_id').val(supir_id);
    $('#dialogPemeriksaLengkap #bidan2_id').val(bidan2_id);
    $('#dialogPemeriksaLengkap #okupasiterapi_id').val(okupasiterapi_id);    
    $('#dialogPemeriksaLengkap #terapiwicara_id').val(terapiwicara_id);
    $('#dialogPemeriksaLengkap #fisioterapi_id').val(fisioterapi_id);
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
    console.log('a');
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_dokterpemeriksa1_id').val(item.pegawai_id);
    $('#tampilanDokterPemeriksa_'+row).html("Dokter Pemeriksa : "+item.nama_pegawai);
    $('#tampilanDokterPemeriksaSementara_'+row).html("Pemeriksa : "+item.nama_pegawai);
}
function updateDokterPemeriksa1(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RMTindakanPelayananT_'+row+'_dokterpemeriksa1_id').val('');
		$('#tampilanDokterPemeriksa_'+row).html('');
		$('#tampilanDokterPemeriksaSementara_'+row).html('');
	}
}
function setDokterPemeriksa2(item)
{
    console.log('a');
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_dokterpemeriksa2_id').val(item.pegawai_id);
    $('#tampilanDokterPemeriksa2_'+row).html("Dokter Pemeriksa 2 : "+item.nama_pegawai);
    $('#tampilanDokterPemeriksaSementara2_'+row).html(item.nama_pegawai+",");
}
function updateDokterPemeriksa2(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RMTindakanPelayananT_'+row+'_dokterpemeriksa2_id').val('');
		$('#tampilanDokterPemeriksa2_'+row).html('');
		$('#tampilanDokterPemeriksaSementara2_'+row).html('');
	}
}

function setDokterDelegasi(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_dokterdelegasi_id').val(item.pegawai_id);
    $('#tampilanDokterDelegasi_'+row).html("Dokter Delegasi : "+item.nama_pegawai);
    $('#tampilanDokterDelegasiSementara_'+row).html(item.nama_pegawai+",");
}
function updateDokterDelegasi(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RMTindakanPelayananT_'+row+'_dokterdelegasi_id').val('');
		$('#tampilanDokterDelegasi_'+row).html('');
		$('#tampilanDokterDelegasiSementara_'+row).html('');
	}
}

function setDokterPendamping(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_dokterpendamping_id').val(item.pegawai_id);
    $('#tampilanDokterPendamping_'+row).html("Dokter Pendamping : "+item.nama_pegawai);
    $('#tampilanDokterPendampingSementara_'+row).html(item.nama_pegawai+",");
}
function updateDokterPendamping(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RMTindakanPelayananT_'+row+'_dokterpendamping_id').val('');
		$('#tampilanDokterPendamping_'+row).html('');
		$('#tampilanDokterPendampingSementara_'+row).html('');
	}
}

function setDokterAnastesi(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_dokteranastesi_id').val(item.pegawai_id);
    $('#tampilanDokterAnastesi_'+row).html("Dokter Anastesi : "+item.nama_pegawai);
    $('#tampilanDokterAnastesiSementara_'+row).html(item.nama_pegawai+",");
}
function updateDokterAnastesi(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RMTindakanPelayananT_'+row+'_dokteranastesi_id').val('');
		$('#tampilanDokterAnastesi_'+row).html('');
		$('#tampilanDokterAnastesiSementara_'+row).html('');
	}
}

function setBidan(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_bidan_id').val(item.pegawai_id);
	$('#tampilanBidan_'+row).html("Bidan : "+item.nama_pegawai);
	$('#tampilanBidanSementara_'+row).html(item.nama_pegawai+",");
}
function setBidan2(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_bidan2_id').val(item.pegawai_id);
	$('#tampilanBidan2_'+row).html("Bidan 2 : "+item.nama_pegawai);
	$('#tampilanBidanSementara2_'+row).html(item.nama_pegawai+",");
}
function setBidan3(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_bidan3_id').val(item.pegawai_id);
	$('#tampilanBidan3_'+row).html("Bidan 3 : "+item.nama_pegawai);
	$('#tampilanBidanSementara3_'+row).html(item.nama_pegawai+",");
}

function updateBidan(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RMTindakanPelayananT_'+row+'_bidan_id').val('');
		$('#tampilanBidan_'+row).html('');
		$('#tampilanBidanSementara_'+row).html('');
	}
}
function updateBidan2(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_bidan2_id').val('');
		$('#tampilanBidan2_'+row).html('');
		$('#tampilanBidanSementara2_'+row).html('');
	}
}
function updateBidan3(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RITindakanPelayananT_'+row+'_bidan3_id').val('');
		$('#tampilanBidan3_'+row).html('');
		$('#tampilanBidanSementara3_'+row).html('');
	}
}

function setSuster(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_suster_id').val(item.pegawai_id);
	$('#tampilanSuster_'+row).html("Suster : "+item.nama_pegawai);
	$('#tampilanSusterSementara_'+row).html(item.nama_pegawai+",");
}
function updateSuster(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RMTindakanPelayananT_'+row+'_suster_id').val('');
		$('#tampilanSuster_'+row).html('');
		$('#tampilanSusterSementara_'+row).html('');
	}
}

function setPerawat(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
	if(item != null){
		$('#RMTindakanPelayananT_'+row+'_perawat_id').val(item.pegawai_id);
		$('#tampilanPerawat_'+row).html("Perawat : "+item.nama_pegawai);
		$('#tampilanPerawatSementara_'+row).html(item.nama_pegawai+",");
	}
} 

function setPerawat2(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
	if(item != null){
		$('#RMTindakanPelayananT_'+row+'_perawat2_id').val(item.pegawai_id);
		$('#tampilanPerawat2_'+row).html("Perawat 2 : "+item.nama_pegawai);
		$('#tampilanPerawatSementara2_'+row).html(item.nama_pegawai+",");
	}
}

//OKUPASI TERAPI
function setOkupasi(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_okupasiterapi_id').val(item.pegawai_id);
    $('#tampilanOkupasi_'+row).html("Okupasi Terapi : "+item.nama_pegawai);
    $('#tampilanOkupasiTerapi_'+row).html(item.nama_pegawai+",");
}

function setTerapi(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_terapiwicara_id').val(item.pegawai_id);
    $('#tampilanTerapiwicara_'+row).html("Terapi Wicara : "+item.nama_pegawai);
    $('#tampilanTerapiSementara_'+row).html(item.nama_pegawai+",");
}

function setPerawat5(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
    $('#RMTindakanPelayananT_'+row+'_fisioterapi_id').val(item.pegawai_id);
    $('#tampilanFisioterapi_'+row).html("Fisioterapi : "+item.nama_pegawai);
    $('#tampilanFisioterapiSementara_'+row).html(item.nama_pegawai+",");
}

function updatePerawat(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RMTindakanPelayananT_'+row+'_perawat_id').val('');
		$('#tampilanPerawat_'+row).html('');
		$('#tampilanPerawatSementara_'+row).html('');
	}
}

function updatePerawat(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RMTindakanPelayananT_'+row+'_perawat2_id').val('');
		$('#tampilanPerawat2_'+row).html('');
		$('#tampilanPerawatSementara2_'+row).html('');
	}
}

function setSupir(item)
{
    var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
	if(item != null){
		$('#RMTindakanPelayananT_'+row+'_supir_id').val(item.pegawai_id);
		$('#tampilanSupir_'+row).html("Supir : "+item.nama_pegawai);
		$('#tampilanSupirSementara_'+row).html(item.nama_pegawai+",");
	}
} 

function updateSupir(value){
	if(value == ''){
		var row = $('#dialogPemeriksaLengkap #rowTindakan').val();
		$('#RMTindakanPelayananT_'+row+'_supir_id').val('');
		$('#tampilanSupir_'+row).html('');
		$('#tampilanSupirSementara_'+row).html('');
	}
}

function setParamedis()
{
    var idBtnAddDokter = $('#dialogPemeriksa #rowTindakan').val();
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpemeriksa1_id]"]').val($('#dialogPemeriksa #dokterpemeriksa1').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpemeriksa2_id]"]').val($('#dialogPemeriksa #dokterpemeriksa2').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpendamping_id]"]').val($('#dialogPemeriksa #dokterpendamping').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokteranastesi_id]"]').val($('#dialogPemeriksa #dokterpemeriksa1').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterdelegasi_id]"]').val($('#dialogPemeriksa #dokterdelegasi').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[bidan_id]"]').val($('#dialogPemeriksa #bidan').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[suster_id]"]').val($('#dialogPemeriksa #suster').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[perawat_id]"]').val($('#dialogPemeriksa #perawat').val());
}

function setTindakan(obj,item)
{
    hargaTindakan = 0;
    subsidiAsuransi = 0;
    subsidiPemerintah = 0;
    subsidiRumahsakit = 0;
    
    
    var hargaTindakan = unformatNumber(parseFloat(item.harga_tariftindakan));
    var subsidiAsuransi = unformatNumber(parseFloat(item.subsidiasuransi));
    var subsidiPemerintah = unformatNumber(parseFloat(item.subsidipemerintah));
    var subsidiRumahsakit = unformatNumber(parseFloat(item.subsidirumahsakit));
    var hargacyto_tarif = 0
    if(item.totaltarifakhir_cyto != undefined){
        hargacyto_tarif =  unformatNumber(parseFloat(item.totaltarifakhir_cyto));
    }
   
    $(obj).parents('tr').find('input[name$="[kategoriTindakanNama]"]').val(item.kategoritindakan_nama);
    $(obj).parents('tr').find('input[name$="[daftartindakan_id]"]').val(item.daftartindakan_id);
    $(obj).parents('tr').find('input[name$="[kelaspelayanan_id]"]').val(item.kelaspelayanan_id);
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
        var res = data[0];
        
        //console.log(idPilihSupir);
         setSupir(res);
      
        $("#supir_id").val(res.label);  
}
function setTindakanSementara(obj)
{
    var row;
    $('#dialogDaftarTindakanPaket').val($(obj).parent().find('input[id="row"]').val());
    
    row = $('#dialogDaftarTindakanPaket').val();
    var tampilankategoritindakan_nama = $('#tampilankategoritindakan_nama_'+row).html();

    if (kategoritindakan_nama.indexOf(":") != -1) kategoritindakan_nama = kategoritindakan_nama.split(":")[1].trim();
    
    $('#dialogDaftarTindakanPaket #tindakanSementara').val(kategoritindakan_nama);
    $('#kategoriTindakanNamaSementara_'+row).html(item.kategoritindakan_nama+",");
    
}

function tambahTindakanPemakaianBahan(value,label)
{
    if ($("#daftartindakanPemakaianBahan option[value='" + value + "']").length == 0) {
        $('#daftartindakanPemakaianBahan').append('<option value="'+value+'">'+label+'</option>');
    }
}

function loadTindakanPaket(tipepaket_id,kelaspelayanan_id,kelompokumur_id, pendaftaran_id)
{
//    myAlert(tipepaket_id);
    //var idNonPaket = <?php //echo Params::TIPEPAKET_ID_NONPAKET; ?>; 
//    var carabayar_id = $('#RJPendaftaranT_carabayar_id').val(); << ELEMENT TIDAK ADA DIDALAM IFRAME
    var carabayar_id = <?php echo $modPendaftaran->carabayar_id;?>
    
    /*    
    if(tipepaket_id == <?php echo Params::TIPEPAKET_ID_NONPAKET; ?>)
    {
        $('#tblInputTindakan > tbody').html(trTindakanNonPaket.replace());
    }else if(tipepaket_id == <?php echo Params::TIPEPAKET_ID_LUARPAKET; ?>)
    {
        $('#tblInputTindakan > tbody').html(trTindakanPaketLuar.replace());
    }else{
        
    }
    */
   
    $.post('<?php echo $this->createUrl(Yii::app()->controller->id.'/loadFormTindakanPaket') ?>',
        {
            tipepaket_id: tipepaket_id,
            kelaspelayanan_id:kelaspelayanan_id, 
            kelompokumur_id:kelompokumur_id, 
            carabayar_id:carabayar_id,
            pendaftaran_id: pendaftaran_id
        },
        function(data)
        {
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
            jQuery('input[name$="[daftartindakanNama]"]').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':2,
                    'focus':function( event, ui )
                    {
                        $(this).val( ui.item.label);
                        return false;
                    },
                    'select':function( event, ui )
                    {
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
                    },
                    'source':function(request, response)
                    {
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('rawatJalan/tindakan/DaftarTindakan');?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                                tipepaket_id: $("#RMTindakanPelayananT_0_tipepaket_id").val(),
                                penjamin_id: $("#RJPendaftaranT_penjamin_id").val(),
                                kelaspelayanan_id: $("#RJPendaftaranT_kelaspelayanan_id").val(),
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }
                }
            ); 
            jQuery('input[name$="[tgl_tindakan]"]').datetimepicker(
                jQuery.extend(
                    {showMonthAfterYear:false},
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
        },
        'json'
    );
}

function hitungCyto(obj)
{
    // var tarifSatuan = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').val());
    // var qty = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[qty_tindakan]"]').val());
    // var persenCyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[persenCyto]"]').val());
    var cyto = $(obj).parents("#tblInputTindakan tr").find('select[name$="[cyto_tindakan]"]').val();
    
    if(cyto == 1){
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').hide();
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').show();
    }else{
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').show();
        $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').hide();
    }
    // if(cyto == '0')
    //     persenCyto = 0;
    // var tarifCyto = qty * tarifSatuan * persenCyto / 100;
    // var subTotal = tarifSatuan * qty + tarifCyto;
    // $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').val(formatNumber(tarifCyto));
    // $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_tindakan]"]').val(formatNumber(subTotal));
    // hitungTotal();

    hitungTotalTindakan(); 
}

function hitungSubtotal(obj)
{
    hitungTotalTindakan();
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
    
    // $('.integer').each(function(){this.value = formatNumber(this.value)});
}

function hitungTotalTindakan(){
    $('#tblInputTindakan tr').find('input[name$="[qty_tindakan]"]').each(function() {
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
    });
}

function testUpdateStok(qty,idObatAlkes)
{
    $.post('<?php echo $this->createUrl('updateStok') ?>', {qty:qty, idObatAlkes:idObatAlkes}, function(data){
            myAlert(data.input);
        }, 'json');
}

function cekInput(obj)
{
    var kosong = 0 ;
    $('#tblInputTindakan').find('[name*="daftartindakan_id"]').each(function(){
        if($(this).val()==""){
            kosong++;
        }
    });
    if(kosong==0 && requiredCheck(obj)){
        $(".integer2, .float2, .integer-decimal, .integer").each(function(){
              $(this).val(unformatNumber($(this).val()));
          });
//	    $('.integer').each(function(){this.value = unformatNumber(this.value)});
        return true;  
    }else{
        myAlert('Isi dulu uraian tindakan!');
        return false;
    }
    
}
function setDialog(obj){
    $("#dialogpemeriksaan-m-grid").find("tr").removeClass("yellow_background");
    var tipepaket_id = $("#<?php echo CHtml::activeId($modTindakan,'[0]tipepaket_id'); ?>").val();
    var kelaspelayanan_id = <?php echo $modPendaftaran->kelaspelayanan_id; ?>;
    var pendaftaran_id = <?php echo $modPendaftaran->pendaftaran_id; ?>;
    var penjamin_id = <?php echo $modPendaftaran->penjamin_id; ?>;
    var jenistarif_id = <?php echo $modJenisTarif->jenistarif_id; ?>;
    var jenistarif_nama = "<?php echo "Daftar Tindakan - ".$modJenisTarif->jenistarif->jenistarif_nama; ?>";
//    $.get('<?php echo Yii::app()->createUrl($this->route, array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));?>',{'set_tindakan':1,tipepaket_id: tipepaket_id, kelaspelayanan_id:kelaspelayanan_id},function(data){
//        $("#tableDaftarTindakanPaket").html(data);
//    });
    $('#tipepaket_id').val(tipepaket_id);
    $('#kelaspelayanan_id').val(kelaspelayanan_id);
    $.fn.yiiGridView.update('giladiagnosa-m-grid2', {
        data: {
            "RJPaketpelayananV[kelaspelayanan_id]":kelaspelayanan_id,
            "RJPaketpelayananV[tipepaket_id]":tipepaket_id,
            "RJPaketpelayananV[jenistarif_id]":jenistarif_id,
            "RJPaketpelayananV[penjamin_id]":penjamin_id,
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
    kelaspelayanan_id = kelaspelayanan_id; //<?php //echo $modPendaftaran->kelaspelayanan_id; ?>;
    penjamin_id = <?php echo $modPendaftaran->penjamin_id; ?>;
    daftartindakan_id = daftartindakan_id;
    var dokter_id = $('#RJPendaftaranT_pegawai_id').val();

    dialog = "#dialogDaftarTindakanPaket";
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
        penjamin_id:penjamin_id,
        dokter_id:dokter_id
    },function(data){
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
    
	
	//alert(kelompoktindakan_id);
	//var split = 
	
	//alert(parent);
	//addDokterLengkap($("#btnAddDokter_"));
	//$(obj).parents("tr").next().;
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