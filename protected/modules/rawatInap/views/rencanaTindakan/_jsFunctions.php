<script type="text/javascript">
/**
 * set form info pasien
 * @returns {undefined}
 */
function setInfoPasien(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id){
    $("#form-infopasien > div").addClass("animation-loading");
    var instalasi_id = $("#instalasi_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataInfoPasien'); ?>',
        data: {instalasi_id:instalasi_id, pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
        dataType: "json",
        success:function(data){
            $("#<?php echo CHtml::activeId($modInfoPasien,'pendaftaran_id'); ?>").val(data.pendaftaran_id);
            $("#<?php echo CHtml::activeId($modInfoPasien,'pasien_id'); ?>").val(data.pasien_id);
            $("#<?php echo CHtml::activeId($modInfoPasien,'pasienadmisi_id'); ?>").val(data.pasienadmisi_id);
            $("#<?php echo CHtml::activeId($modInfoPasien,'jeniskasuspenyakit_id'); ?>").val(data.jeniskasuspenyakit_id);
            $("#<?php echo CHtml::activeId($modInfoPasien,'carabayar_id'); ?>").val(data.carabayar_id);
            $("#<?php echo CHtml::activeId($modInfoPasien,'penjamin_id'); ?>").val(data.penjamin_id);
            $("#<?php echo CHtml::activeId($modInfoPasien,'penanggungjawab_id'); ?>").val(data.penanggungjawab_id);
            $("#<?php echo CHtml::activeId($modInfoPasien,'kelaspelayanan_id'); ?>").val(data.kelaspelayanan_id);
            $("#<?php echo CHtml::activeId($modInfoPasien,'ruangan_id'); ?>").val(data.ruangan_id);
            $("#no_pendaftaran").val(data.no_pendaftaran);
            $("#<?php echo CHtml::activeId($modInfoPasien,'tgl_pendaftaran'); ?>").val(data.tgl_pendaftaran);
            $("#<?php echo CHtml::activeId($modInfoPasien,'ruangan_nama'); ?>").val(data.ruangan_nama);
            $("#<?php echo CHtml::activeId($modInfoPasien,'jeniskasuspenyakit_nama'); ?>").val(data.jeniskasuspenyakit_nama);
            $("#<?php echo CHtml::activeId($modInfoPasien,'carabayar_nama'); ?>").val(data.carabayar_nama);
            $("#<?php echo CHtml::activeId($modInfoPasien,'penjamin_nama'); ?>").val(data.penjamin_nama);
            $("#no_rekam_medik").val(data.no_rekam_medik);
            $("#namadepan").val(data.namadepan);
            $("#nama_pasien").val(data.nama_pasien);
            $("#<?php echo CHtml::activeId($modInfoPasien,'nama_bin'); ?>").val(data.nama_bin);
            $("#<?php echo CHtml::activeId($modInfoPasien,'tanggal_lahir'); ?>").val(data.tanggal_lahir);
            $("#<?php echo CHtml::activeId($modInfoPasien,'umur'); ?>").val(data.umur);
            $("#<?php echo CHtml::activeId($modInfoPasien,'jeniskelamin'); ?>").val(data.jeniskelamin);
            $("#<?php echo CHtml::activeId($modInfoPasien,'nama_pj'); ?>").val(data.nama_pj);
            $("#<?php echo CHtml::activeId($modInfoPasien,'pengantar'); ?>").val(data.pengantar);
            $("#<?php echo CHtml::activeId($modInfoPasien,'kelaspelayanan_nama'); ?>").val(data.kelaspelayanan_nama);
            $("#<?php echo CHtml::activeId($modInfoPasien,'alamat_pasien'); ?>").val(data.alamat_pasien);
            $("#<?php echo CHtml::activeId($modInfoPasien,'nama_pegawai'); ?>").val(data.nama_pegawai);
            $("#kamarruangan_nokamar").val(data.kamarruangan_nokamar);
            $("#kamarruangan_nobed").val(data.kamarruangan_nobed);
            $("#jenistarif_id").val(data.jenistarif_id);
            $("#jenistarif_nama").val(data.jenistarif_nama);
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
            
            $("#form-infopasien > legend > .judul").html('Data Pasien '+data.no_pendaftaran);
            $("#form-infopasien > legend > .tombol").attr('style','display:true;');
            $("#form-infopasien > .box").addClass("well").removeClass("box");
            
            $("#form-infopasien > div").removeClass("animation-loading");
            $("#<?php echo CHtml::activeId($modInfoPasien,'nama_pasien'); ?>").focus();
			setRiwayatRencanaTindakan(data.pendaftaran_id,data.pasien_id);
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data Pasien tidak ditemukan!"); 
            console.log(errorThrown);
            setInfoPasienReset();
            $("#form-infopasien > div").removeClass("animation-loading");
            $("#<?php echo CHtml::activeId($modInfoPasien,'no_pendaftaran'); ?>").focus();
        }
    });
}
/**
 * reset form info pasien
 * @returns {undefined}
 */
function setInfoPasienReset(){
    $("#<?php echo CHtml::activeId($modInfoPasien,'pendaftaran_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'pasien_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'pasienadmisi_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'jeniskasuspenyakit_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'carabayar_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'penjamin_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'penanggungjawab_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'kelaspelayanan_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'ruangan_id'); ?>").val("");
    $("#no_pendaftaran").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'tgl_pendaftaran'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'ruangan_nama'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'jeniskasuspenyakit_nama'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'carabayar_nama'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'penjamin_nama'); ?>").val("");
    $("#no_rekam_medik").val("");
    $("#nama_depan").val("");
    $("#nama_pasien").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'nama_bin'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'tanggal_lahir'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'umur'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'jeniskelamin'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'nama_pj'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'pengantar'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'kelaspelayanan_nama'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'alamat_pasien'); ?>").val("");
    $("#<?php echo CHtml::activeId($modInfoPasien,'nama_pegawai'); ?>").val("");
    $("#kamarruangan_nokamar").val("");
    $("#kamarruangan_nobed").val("");
    $("#jenistarif_id").val("");
    $("#jenistarif_nama").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-infopasien > legend > .judul").html('Data Pasien');
    $("#form-infopasien > legend > .tombol").attr('style','display:none;');
    $("#form-infopasien > .well").addClass("box").removeClass("well");
}
/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogInfoPasien(){
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
        }
    });
}

var trTindakan=new String(<?php echo CJSON::encode($this->renderPartial('_rowTindakanPasien',array('modTindakan'=>$modTindakan,'removeButton'=>true),true));?>);
var trTindakanFirst=new String(<?php echo CJSON::encode($this->renderPartial('_rowTindakanPasien',array('modTindakan'=>$modTindakan,'removeButton'=>false),true));?>);
 
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
    renameInput('RITindakanPelayananT','nama_pegawai');
    renameInput('RITindakanPelayananT','pegawai_id');
    renameInput('RITindakanPelayananT','kategoriTindakanNama');
    renameInput('RITindakanPelayananT','persenCyto');
    renameInput('RITindakanPelayananT','jumlahTarif');
    renameInput('RITindakanPelayananT','tgl_tindakan');
    
     $('#tblrencanatindakan tbody').each(function(){
        jQuery('input[name$="[tgl_tindakan]"]').datetimepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'minDate':'d',
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
                                                                                    setTindakan(this, ui.item);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/DaftarTindakan');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        term: request.term,
                                                                                                        tipepaket_id: $("#RITindakanPelayananT_0_tipepaket_id").val(),
                                                                                                        kelaspelayanan_id: $("#kelaspelayanan_id").val(),
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });   
    jQuery('#tblrencanatindakan tr:last .tanggal').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
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
            renameInput('RITindakanPelayananT','pegawai_id');
            renameInput('RITindakanPelayananT','nama_pegawai');
            renameInput('RITindakanPelayananT','daftartindakanNama');
            renameInput('RITindakanPelayananT','kategoriTindakanNama');
            renameInput('RITindakanPelayananT','persenCyto');
            renameInput('RITindakanPelayananT','jumlahTarif');
             renameInput('RITindakanPelayananT','tgl_tindakan');
			hitungTotalTarif();
        }
    });
}

function setDialog(obj){
    $("#dialogpemeriksaan-m-grid").find("tr").removeClass("yellow_background");
    var tipepaket_id = <?php echo Params::TIPEPAKET_ID_NONPAKET; ?>;
    var pendaftaran_id = $('#<?php echo CHtml::activeId($modInfoPasien,'pendaftaran_id'); ?>').val();
    var kelaspelayanan_id = $('#<?php echo CHtml::activeId($modInfoPasien,'kelaspelayanan_id'); ?>').val();
    var penjamin_id = $('#<?php echo CHtml::activeId($modInfoPasien,'penjamin_id'); ?>').val();
    var jenistarif_id = $('#jenistarif_id').val();
	var jenistarif = $('#jenistarif_nama').val();
    var jenistarif_nama = "Daftar Tindakan - "+jenistarif;
    $('#tipepaket_id').val(tipepaket_id);
    $('#kelaspelayanan_id').val(kelaspelayanan_id);
	if(pendaftaran_id == ''){
		myAlert('Silakan pilih data pasien!');
	}else{
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
}

function setTindakanAuto(kelaspelayanan_id,daftartindakan_id){
    tipepaket_id = <?php echo Params::TIPEPAKET_ID_NONPAKET; ?>;
    kelaspelayanan_id = $('#<?php echo CHtml::activeId($modInfoPasien,'kelaspelayanan_id'); ?>').val();
    penjamin_id = $('#<?php echo CHtml::activeId($modInfoPasien,'penjamin_id'); ?>').val();
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
    $.get('<?php echo $this->createUrl('daftarTindakan'); ?>',{tipepaket_id: tipepaket_id, kelaspelayanan_id:kelaspelayanan_id, daftartindakan_id:daftartindakan_id,penjamin_id:penjamin_id},function(data){
        $(obj).val(data[0].kategoritindakan_nama);
        $(obj).val(data[0].daftartindakan_nama);
        setTindakan(obj,data[0]);
    },"json");
    $(dialog).dialog("close");
    
}

function setTindakan(obj,item)
{
    var hargaTindakan = unformatNumber(item.harga_tariftindakan);
    var subsidiAsuransi = unformatNumber(item.subsidiasuransi);
    var subsidiPemerintah = unformatNumber(item.subsidipemerintah);
    var subsidiRumahsakit = unformatNumber(item.subsidirumahsakit);
    if(isNaN(subsidiAsuransi))subsidiAsuransi=0;
    if(isNaN(subsidiPemerintah))subsidiPemerintah=0;
    if(isNaN(subsidiRumahsakit))subsidiRumahsakit=0;
    $(obj).parents('tr').find('input[name$="[kategoriTindakanNama]"]').val(item.kategoritindakan_nama);
    $(obj).parents('tr').find('input[name$="[daftartindakan_id]"]').val(item.daftartindakan_id);
    $(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val(formatNumber(item.harga_tariftindakan));
    $(obj).parents('tr').find('input[name$="[qty_tindakan]"]').val('1');
    $(obj).parents('tr').find('input[name$="[persenCyto]"]').val(formatNumber(item.persencyto_tind));
    $(obj).parents('tr').find('input[name$="[jumlahTarif]"]').val(formatNumber(item.harga_tariftindakan));
    $(obj).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(formatNumber(item.subsidiasuransi));
    $(obj).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(formatNumber(item.subsidipemerintah));
    $(obj).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(formatNumber(item.subsidirumahsakit));
    $(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(formatNumber(hargaTindakan - (subsidiAsuransi + subsidiPemerintah +subsidiRumahsakit)));
    //var tombolAddDokter = $(obj).parents('tr').next().find('a');
    //DIDISABLE KARENA DEFAULT SUDAH DOKTER SAAT PENDAFTARAN >>> addDokter(tombolAddDokter);
	hitungTotalTarif();
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tblrencanatindakan tr').length;
    var i = -1;
    $('#tblrencanatindakan tr').each(function(){
        if($(this).has('input[name$="[daftartindakan_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('input[name^="daftartindakanNama["]').attr('name','daftartindakanNama['+i+']');
        $(this).find('input[name^="daftartindakanNama["]').attr('id','daftartindakanNama_'+i+'');
        $(this).find('input[name^="nama_pegawai["]').attr('name','nama_pegawai['+i+']');
        $(this).find('input[name^="nama_pegawai["]').attr('id','nama_pegawai_'+i+'');
        $(this).find('input[name^="pegawai_id["]').attr('name','pegawai_id['+i+']');
        $(this).find('input[name^="pegawai_id["]').attr('id','pegawai_id_'+i+'');
        $(this).find('a[id^="btnAddDokter_"]').attr('id','btnAddDokter_'+i+'');
        $(this).find('div[id^="tampilanDokterPemeriksa_"]').attr('id','tampilanDokterPemeriksa_'+i+'');
        $(this).find('div[id^="tampilanDokterDelegasi_"]').attr('id','tampilanDokterDelegasi_'+i+'');
        $(this).find('div[id^="tampilanBidan_"]').attr('id','tampilanBidan_'+i+'');
        $(this).find('div[id^="tampilanSuster_"]').attr('id','tampilanSuster_'+i+'');
        $(this).find('div[id^="tampilanPerawat_"]').attr('id','tampilanPerawat_'+i+'');
        $(this).find('input[id="row"]').attr('value',i);
        $(this).find('input[id="row"]').val(i);
         $(this).find('input[name^="tgl_tindakan["]').attr('name','tgl_tindakan['+i+']');
        $(this).find('input[name^="tgl_tindakan["]').attr('id','tgl_tindakan_'+i+'');
       // jQuery('input[name$="[daftartindakanNama]"]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
       jQuery('input[name^="tgl_tindakan["]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
        
    });
}

function hitungCyto(obj)
{
    var tarifSatuan = unformatNumber($(obj).parents("#tblrencanatindakan tr").find('input[name$="[tarif_satuan]"]').val());
    var qty = unformatNumber($(obj).parents("#tblrencanatindakan tr").find('input[name$="[qty_tindakan]"]').val());
    var persenCyto = unformatNumber($(obj).parents("#tblrencanatindakan tr").find('input[name$="[persenCyto]"]').val());
    var cyto = unformatNumber($(obj).parents("#tblrencanatindakan tr").find('select[name$="[cyto_tindakan]"]').val());
    if(cyto == '0')
        persenCyto = 0;
    var tarifCyto = qty * tarifSatuan * persenCyto / 100;
    var subTotal = tarifSatuan * qty + tarifCyto;
    $(obj).parents("#tblrencanatindakan tr").find('input[name$="[tarifcyto_tindakan]"]').val(formatNumber(tarifCyto));
    $(obj).parents("#tblrencanatindakan tr").find('input[name$="[jumlahTarif]"]').val(formatNumber(subTotal));
    hitungTotal(); 
	hitungTotalTarif();
}

function hitungTotalTarif()
{
    var totalTarif = 0;
    $('#tblrencanatindakan > tbody > tr').each(function(){
        totalTarif += unformatNumber($(this).find('input[name*="[jumlahTarif]"]').val());
    });
    $('#totalTarif').val(formatNumber(totalTarif));
}

function setDialogDokter(obj){
    $("#dialogpemeriksaan-m-grid").find("tr").removeClass("yellow_background");
	$.fn.yiiGridView.update('dialogdokter-v-grid', {
		data: $(this).serialize()
	});
	parent = $(obj).parents(".input-append").find("input").attr("id");
	dialog = "#dialogDaftarDokter";
	$(dialog).attr("parent-dialog",parent);
	$(dialog).dialog("open");
}

function setDokterAuto(pegawai_id){
    pegawai_id = pegawai_id;
    dialog = "#dialogDaftarDokter";
    parent = $(dialog).attr("parent-dialog");
    obj = $("#"+parent);
    $.get('<?php echo $this->createUrl('daftarDokter'); ?>',{pegawai_id:pegawai_id},function(data){
        $(obj).val(data.pegawai_id);
        $(obj).val(data.nama_pegawai);
        setDokter(obj,data.pegawai_id,data.nama_pegawai);
    },"json");
    $(dialog).dialog("close");
    
}
function setDokter(obj,pegawai_id,nama_pegawai)
{
    $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val(pegawai_id);
    $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val(nama_pegawai);
}

/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

function cekInput()
{
	unformatNumberSemua();
    var kosong = 0 ;
	
    $('#tblrencanatindakan').find('input[name*="[daftartindakan_id]"]').each(function(){
        if($(this).val() == ""){			
            kosong++;
        }
    });
	
	if (kosong != 0 ){
		myAlert('Isi dulu uraian tindakan!');
	}else{
		$('#rencanatindakan-form').submit();
	}
	hitungTotalTarif();
}

/**
 * set tabel riwayat rencana tindakan
 * @param {type} pendaftaran_id, pasien_id
 * @returns {undefined} */
function setRiwayatRencanaTindakan(pendaftaran_id, pasien_id){
    $("#content-riwayattindakan > .accordion-inner").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetRiwayatRencanaTindakan'); ?>',
        data: {pasien_id: pasien_id,pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            $("#content-riwayattindakan > .accordion-inner").html(data.table);
            $("#content-riwayattindakan > .accordion-inner").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
* untuk print penjualan dokter
 */
function print(caraPrint)
{
    var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    
});
</script>