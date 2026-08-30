<?php
$modRujukKeluar = new PemeriksaankeluarT();
?>

<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pasienmasukpenunjang_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasienmasukpenunjang_id").val(data.pasienmasukpenunjang_id);
                $("#pasien_id").val(data.pasien_id);
                $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                $("#carabayar_id").val(data.carabayar_id);
                $("#penjamin_id").val(data.penjamin_id);
                $("#penanggungjawab_id").val(data.penanggungjawab_id);
                $("#instalasiasal_id").val(data.instalasiasal_id);
                $("#ruanganasal_id").val(data.ruanganasal_id);
                $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                $("#no_masukpenunjang").val(data.no_masukpenunjang);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#tglmasukpenunjang").val(data.tglmasukpenunjang);
                $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
                $("#instalasiasal_nama").val(data.instalasiasal_nama);
                $("#ruanganasal_nama").val(data.ruanganasal_nama);
                $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
                $("#carabayar_nama").val(data.carabayar_nama);
                $("#penjamin_nama").val(data.penjamin_nama);
                $("#no_rekam_medik").val(data.no_rekam_medik);
                $("#namadepan").val(data.namadepan);
                $("#nama_pasien").val(data.nama_pasien);
                $("#nama_bin").val(data.nama_bin);
                $("#tanggal_lahir").val(data.tanggal_lahir);
                $("#umur").val(data.umur);
                $("#jeniskelamin").val(data.jeniskelamin);
                $("#nama_pj").val(data.nama_pj);
                $("#pengantar").val(data.pengantar);
                $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
                $("#alamat_pasien").val(data.alamat_pasien);
				$("#dokterperujuk").val(data.dokterperujuk);
                if(data.photopasien === null || data.photopasien === ""){ //set photo
                    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                }else{
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }
				//form masuk penunjang
				$("#form-masukpenunjang select[name$='[jeniskasuspenyakit_id]']").val(data.jeniskasuspenyakit_id);
				$("#form-masukpenunjang select[name$='[pegawai_id]']").val(data.pegawai_id);
				$("#form-masukpenunjang select[name$='[perawat_id]']").val(data.perawat_id);
				
                setTindakanPelayanan();
                setTindakanRegistrasi();
                <?php if (isset($dariHasil)) { ?>
                    setRiwayatAnamnesa(); // khusus untuk PencatatanHasilPemeriksaanController
                    setRiwayatPemeriksaanFisik(); // khusus untuk PencatatanHasilPemeriksaanController
                    setRiwayatDiagnosa(); // khusus untuk PencatatanHasilPemeriksaanController
                <?php } ?>
                
                $("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_masukpenunjang);
                $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
                $("#form-datakunjungan > .box").addClass("well").removeClass("box");
            }
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan!"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        }
    });

}
/**
 * untuk mereset form kunjungan
 * @returns {undefined} */
function setKunjunganReset(){
    $("#form-datakunjungan input,textarea").each(function(){
        $(this).val("");
    });
    $("#ruangan_id").val(<?php echo $modKunjungan->ruangan_id; ?>);
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well");
        
    $('#form-tindakanpemeriksaan table > tbody').html("");
    $('#form-hasilpemeriksaanlab table > tbody').html(""); //untuk di pencatatanHasilPemeriksaan
    $('#form-hasilpemeriksaanlab input').val(""); //untuk di pencatatanHasilPemeriksaan
    $('#content-pemeriksaan-lab .checklists').html("");
    $('#content-pemeriksaan-lab input').each(function(){
        $(this).val("");
    });
}

/**
 * update (refresh) checklist pemeriksaan lab
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistPemeriksaanLab(){
    $('#content-pemeriksaan-lab .checklists').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/laboratorium/pendaftaranLaboratorium/SetChecklistPemeriksaanLab'); ?>',
        data: {data:$("#form-caripemeriksaan :input").serialize()},
        dataType: "json",
        success:function(data){
            $('#content-pemeriksaan-lab .checklists').html(data.content);
            $('.checkboxlist-tile').tile({widths : [ 190 ]});
            $('#content-pemeriksaan-lab .checklists').removeClass("animation-loading");
            setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * Set checklist pemeriksaan lab
 */
function setChecklistPemeriksaanLab(){
    var penjamin_id = $("#penjamin_id").val();
    var ruangan_id = $("#ruangan_id").val();
    var kelaspelayanan_id = $("#kelaspelayanan_id").val();
    if(penjamin_id == "" && kelaspelayanan_id==""){
        myAlert("Silakan pilih data kunjungan!");
    }else{
        $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
        $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
        $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
        updateChecklistPemeriksaanLab();
    }
}
/**
 * reset pencarian & checklist pemeriksaan lab
 */
function setChecklistPemeriksaanLabReset(){
    $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
        $(this).val("");
    });
    updateChecklistPemeriksaanLab();
}

/**
 * Centang pemeriksaan lab dari checkboxlist
 */
function pilihPemeriksaanIni(obj){
    var pemeriksaanlab_id = $(obj).val();
    var pemeriksaanlab_nama = $(obj).parent().find('input[name$="[pemeriksaanlab_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
    var harga_tariftindakan = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view_pendaftaran.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
    if($(obj).is(':checked')){
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
        $("#form-tindakanpemeriksaan").find('span[name$="[ii][pemeriksaanlab_nama]"]').html(pemeriksaanlab_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(harga_tariftindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
        $("#form-tindakanpemeriksaan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
		
		//rujuk keluar
		renameInput();
    }else{
		var row_tindakanpelayanan = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanlab_id]"][value="'+pemeriksaanlab_id+'"]').parents('tr');
        var tindakanpelayanan_id =  row_tindakanpelayanan.find('input[name$="[tindakanpelayanan_id]"]').val();
		if(tindakanpelayanan_id == ""){
            row_tindakanpelayanan.detach();
			
			renameInput();
        }else{ //jika undefined = tindakanpelayanan_id terisi
            myConfirm('Apakah Anda yakin akan menghapus pemeriksaan yang sudah di database?', 'Perhatian!', function(r)
            {
                if(r){
					hapusTindakanPelayanan(daftartindakan_id);
					$("#rujukanKeluar").find('#PemeriksaankeluarT_daftartindakan_id option[value='+daftartindakan_id+']').remove();
                    jQuery(jQuery('#<?php echo CHtml::activeId($modRujukKeluar, 'daftartindakan_id') ?>')).multiselect('rebuild');	
					renameInput();
                }else{
                    $(obj).attr("checked",true);
                }
            });
        }
    }
    renameInputRow($("#form-tindakanpemeriksaan"));
}
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <span>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
            }
        });
        row++;
    });
    
}
/**
 * set checked pemeriksaan yang sudah ada di daftar
 */
function setCheckedPemeriksaan(obj_table){
    $("div.checklists").find('input[name$="[is_pilih]"]').removeAttr('checked');
    $(obj_table).find('input[name$="[pemeriksaanlab_id]"]').each(function(){
        var pemeriksaanlab_id = $(this).val();
        $("div.checklists").find('input[name$="[is_pilih]"][value='+pemeriksaanlab_id+']').attr('checked',true);
    });
    hitungTotalSemua();
    
}
/**
* load pemeriksaan yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setTindakanPelayanan(){
    $('#form-tindakanpemeriksaan').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetTindakanPelayanan'); ?>',
        data: {pasienmasukpenunjang_id:$("#pasienmasukpenunjang_id").val()},
        dataType: "json",
        success:function(data){
            $('#form-tindakanpemeriksaan table > tbody').html(data.rows);
            $('#form-tindakanpemeriksaan').removeClass("animation-loading");
            renameInputRow($("#form-tindakanpemeriksaan"));
            //setChecklistPemeriksaanLab();
            hitungTotalSemua();

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setTindakanRegistrasi(){
    $('#form-tindakanpemeriksaan-registrasi').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetTindakanRegistrasi'); ?>',
        data: {pasienmasukpenunjang_id:$("#pasienmasukpenunjang_id").val()},
        dataType: "json",
        success:function(data){
            $('#form-tindakanpemeriksaan-registrasi table > tbody').html(data.rows);
            $('#form-tindakanpemeriksaan-registrasi').removeClass("animation-loading");
            renameInputRow($("#form-tindakanpemeriksaan-registrasi"));
            //setChecklistPemeriksaanLab();
            hitungTotalSemua();

        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function pembulatanKeAtas(obj){
    $(obj).val(Math.ceil(obj.value));
}
 
/**
* hitung tarif tindakan
*/ 
function hitungTotal(obj)
{   
    unformatNumberSemua();
    var qty = $(obj).val();
    var harga = parseFloat($(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val());
    var subTotal=0;
    
    subTotal = parseFloat(harga*qty);
    if ($.isNumeric(subTotal)){
        $(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val(subTotal);
    }

    formatNumberSemua();
    hitungTotalSemua();
}

function hitungTotalSemua()
{   
    unformatNumberSemua();
    var total = 0;
    var totalReg = 0;
    $("#form-tindakanpemeriksaan").find("tbody > tr").each(function () {
        total += parseInt( $(this).find('input[name$="[tarif_tindakan]"]').val());
    });

    $("#form-tindakanpemeriksaan-registrasi").find("tbody > tr").each(function () {
        totalReg += parseInt( $(this).find('input[name$="[tarif_tindakan]"]').val());
    });

    $('#totaltarif').val(total);
    $('#totaltarifregis').val(totalReg);
    formatNumberSemua();
}

/**
* hapus tindakanpelayanan_t berdasarkan daftartindakan_id
*/ 
function hapusTindakanPelayanan(daftartindakan_id){
    var pasienmasukpenunjang_id = $("#pasienmasukpenunjang_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('HapusTindakanPelayanan'); ?>',
        data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id, daftartindakan_id:daftartindakan_id},
        dataType: "json",
        success:function(data){
            myAlert(data.pesan);
            if(data.sukses){
                var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[daftartindakan_id]"][value="'+daftartindakan_id+'"]').parents('tr');
                delete_row.detach();
                renameInputRow($("#form-tindakanpemeriksaan"));
            }
            setChecklistPemeriksaanLab();
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);return false;}
    });
}
/**
 * print status 
 */
function printStatus()
{
    var pendaftaran_id = $("#pendaftaran_id").val();
    if(pendaftaran_id != ""){
        window.open('<?php echo $this->createUrl('pendaftaranLaboratorium/printStatusLab'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
    }else{
        myAlert("Silakan pilih data kunjungan pasien!");
    }
}
/*
function addRowRujukan()
{
	var trSample = <!--?= json_encode($this->renderPartial("_formGetRujukan",array('form'=>$form, 'modRujukKeluar'=>$modRujukKeluar, 'i'=>0 ,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang),true)) ?-->;
	$('table#table-rujukankeluar > tbody').append(trSample.replace());
	renameInput();
}
*/
/*
function hapusRowRujukan(obj, id = null)
{
	if (id == null) {
		$(obj).parents('tr').detach();
		renameInput();
	} else {
		var cf = confirm("Apakah Anda yakin akan menghapus rujukan keluar ini ?");
		
		if (cf) {
			$.post('<?php echo $this->createUrl('AjaxDeleteRujukanKeluar') ?>', {id: id}, function (data) {
				if (data.success)
				{
					$(obj).parents('tr').detach();
					myAlert('Data berhasil dihapus.');
					renameInput();
				} else {
					myAlert('Data Gagal dihapus');
					renameInput();
				}
			}, 'json');
		}
		
	}

}
*/

function renameInput() {
	var option = '<option value="">-- Pilih --</option>';
	$("#form-tindakanpemeriksaan > table >tbody > tr").each(function(){
		option += '<option value="'+$(this).find("input[name$='[daftartindakan_id]']").val()+'-'+$(this).find("input[name$='[tindakanpelayanan_id]']").val()+'">'+$(this).find("span[name$='[pemeriksaanlab_nama]']").html()+'</option>';
	});
	//alert(option);
	var row = 0;
	var obj_table = '#table-rujukankeluar';
	$(obj_table).find("tbody > tr").each(function () {		
		$(this).find('input,select,textarea').each(function () { //element <input>		
			var old_name = $(this).attr("name").replace(/]/g, "");
			var old_name_arr = old_name.split("[");	
			var value = $(this).val();
			
			if (old_name_arr.length == 3) {
				
				$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
				$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
			}
			
			if (old_name_arr[2] == 'daftartindakan_id'){				
				$(this).html(option);
				$(this).val(value);
			}
		});
		$(this).find('span.add-on').each(function () {
			var old_name = $(this).parent('.input-append').find('input').attr("name").replace(/]/g, "");
			var old_name_arr = old_name.split("[");
			var id_span = '';
			if (old_name_arr.length == 3) {
				id_span = old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_date";
				id = old_name_arr[0] + "_" + row + "_" + old_name_arr[2];
				registerDateJs(id, id_span);
			}
		});
		
		$(this).find('a.accordion-toggle').each(function () {
			var old_name = $(this).attr("href");
			var old_name_arr = old_name.split("-");			
			$(this).attr("href",old_name_arr[0]+'-'+old_name_arr[1]+'-'+row);
			$(this).attr("data-parent","#rujukaccordion-"+row);

		});

		$(this).find('div.accordion-body').each(function () {
			var old_name = $(this).attr("id");
			var old_name_arr = old_name.split("-");

			$(this).attr("id",old_name_arr[0]+'-'+old_name_arr[1]+'-'+row);

		});
		
		$(this).find("div.accordion").attr("id","rujukaccordion-"+row);
		//alert($(this).find("div.accordion").attr());
		
		row++;
	});
}

function registerDateJs(id, id_span) {
	jQuery('#' + id).datepicker(jQuery.extend({showMonthAfterYear: false}, jQuery.datepicker.regional['id'], {'dateFormat': 'dd M yy', 'maxDate': 'd', 'timeText': 'Waktu', 'hourText': 'Jam', 'minuteText': 'Menit', 'secondText': 'Detik', 'showSecond': true, 'timeOnlyTitle': 'Pilih Waktu', 'timeFormat': 'hh:mm:ss', 'changeYear': true, 'changeMonth': true, 'showAnim': 'fold', 'yearRange': '-80y:+20y'}));
	jQuery('#' + id_span).on('click', function () {
		jQuery('#' + id).datepicker('show');
	});
}

// ----------------------------------------------------------------------------
/**
* Validasi sebelum 
* 

 * @param {type} obj
 * @returns {Boolean} */
function cekValidasi(obj) {
    
    var is_ok = true;
    
    if ($(obj).find(".txt_klinikrujukan").val().trim() == "") {
        myAlert("Klinik Rujukan harus diisi.");
        is_ok = false;
        return false;
    }
    if ($(obj).find(".txt_dokterpengirim").val().trim() == "") {
        myAlert("Dokter Pengirim harus diisi.");
        is_ok = false;
        return false;
    }
    if ($(obj).find(".txt_pemeriksaankeluar_tgl").val().trim() == "") {
        myAlert("Tanggal Rujuk harus diisi.");
        is_ok = false;
        return false;
    }
    if ($(obj).find(".txt_perawat").val().trim() == "") {
        myAlert("Perawat Pengantar harus diisi.");
        is_ok = false;
        return false;
    }
    if ($(obj).find(".txt_sopir").val().trim() == "") {
        myAlert("Sopir Pengantar harus diisi.");
        is_ok = false;
        return false;
    }
    if ($(obj).find(".alasanrujuk").val().trim() == "") {
        myAlert("Tanggal Rujuk harus diisi.");
        is_ok = false;
        return false;
    }
    
    if (!is_ok) {
        return false;
    }
    
    return true;
}

function batalRujukKeluar(id) {
    myConfirm("Anda yakin untuk membatalkan rujukan keluar atas pemeriksaan ini?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl("batalRujukKeluar"); ?>', {id: id}, function(data) {
                if (data.ok == 1) {
                    myAlert("Rujukan keluar telah dibatalkan.");
                    setTindakanPelayanan();
                } else {
                    myAlert("Rujukan keluar gagal dibatalkan.<br>" + data.msg);
                }
            }, 'json');
        }
    });
}

function setRujukan(id) {
    
    $.post('<?php echo $this->createUrl('setFormRujukan'); ?>', {id: id}, function(data) {
        
        $("#dialogRujukPasien .tab_header #rujuk_tgl_pendaftaran").html(data.tgl_pendaftaran);
        $("#dialogRujukPasien .tab_header #rujuk_no_pendaftaran").html(data.no_pendaftaran);
        $("#dialogRujukPasien .tab_header #rujuk_tglmasukpenunjang").html(data.tglmasukpenunjang);
        $("#dialogRujukPasien .tab_header #rujuk_no_masukpenunjang").html(data.no_masukpenunjang);
        $("#dialogRujukPasien .tab_header #rujuk_no_rekam_medik").html(data.no_rekam_medik);
        $("#dialogRujukPasien .tab_header #rujuk_nama_pasien").html(data.nama_pasien);
        $("#dialogRujukPasien .tab_header #rujuk_instalasiasal_nama").html(data.instalasiasal_nama);
        $("#dialogRujukPasien .tab_header #rujuk_ruanganasal_nama").html(data.ruanganasal_nama);
        $("#dialogRujukPasien .tab_header #rujuk_carabayar_nama").html(data.carabayar_nama);
        $("#dialogRujukPasien .tab_header #rujuk_penjamin_nama").html(data.penjamin_nama);
        $("#dialogRujukPasien .tab_header #rujuk_daftartindakan_nama").html(data.daftartindakan_nama);
        
        $("#dialogRujukPasien :input").val("").prop('disabled', false);
        $("#dialogRujukPasien .rujukkeluar-daftartindakan-id").val(data.tindakanpelayanan_id);
        $("#dialogRujukPasien .rujukkeluar-pasienmasukpenunjang-id").val(data.pasienmasukpenunjang_id);
        
        
        $("#dialogRujukPasien").dialog("open");
        
    }, 'json');
    
}

function simpanRujukanKeluar() {
    if (!cekValidasi("#dialogRujukPasien")) return false;
    
    // disable input
    var serial = $("#dialogRujukPasien :input").serialize();
    
    $("#dialogRujukPasien :input").prop("disabled", true);
    
    
    // submit
    $.post('<?php echo $this->createUrl('simpanRujukanKeluar'); ?>', serial, function(data) {
        if (data.ok == 1) {
            myAlert("Rujukan keluar berhasil ditransaksikan.");
            $("#dialogRujukPasien").dialog("close");
            $("#dialogRujukPasien :input").prop("disabled", false);
            setTindakanPelayanan();
        } else {
            myAlert("Rujukan keluar gagal ditransaksikan.<br>" + data.msg);
            $("#dialogRujukPasien :input").prop("disabled", false);
        }
    }, 'json');
}

function dialogReturTindakan(obj,tindakanpelayanan_id, tindakansudahbayar_id){
    if($(obj).prop('checked') == true){
        var row_tindakan = $('#returtindakan_transaksi_'+tindakanpelayanan_id);
        $(row_tindakan).show();
        $(row_tindakan).find('#tbl_returtindakan').show();
        $(row_tindakan).addClass('animation-loading-1');
        $(row_tindakan).find('#tbl_returtindakan').find('tbody').html('');

        $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('loadReturTindakan'); ?>',
            data: {tindakanpelayanan_id:tindakanpelayanan_id, tindakansudahbayar_id: tindakansudahbayar_id},
            dataType: "json",
            success:function(data){


                if(data.pesan != ''){
                    $(row_tindakan).find('.alert_returtindakan').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
                    setTimeout(function(){
                        $(row_tindakan).find('.alert_returtindakan').html('');
                    }, 5000);
                }
                if(data.issudahretur == false){
                    $(row_tindakan).find('#tbl_returtindakan').find('tbody').html(data.form);
                    $(row_tindakan).find('#tbl_returtindakan .integer').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":"","thousands":",","precision":0}
                    );
                }else{
                    $(row_tindakan).find('#tbl_returtindakan').hide();
                    $('#returtindakan_riwayat').attr('checked',false);
                }
                
                $(row_tindakan).removeClass('animation-loading-1');

                $(row_tindakan).find('#tbl_returtindakan').find('tbody').find('.detail_komp').each(function(){
                    if($(this).find('input[name*="[pembebasantarif_id]"]').val() == ''){
                        $(this).find(".checklist").attr('checked',true);
                    }
                    changeReturTagihan($(this).find(".checklist"), tindakanpelayanan_id);
                });

                if($(row_tindakan).find('#tbl_returtindakan').find('tbody').find('.detail_komp').length == 0){
                    hitungTotalRetur(tindakanpelayanan_id); 
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(row_tindakan).removeClass('animation-loading-1');}
        });
        
    }else{
        $(row_tindakan).hide();
        $(row_tindakan).find('tbody').html('');
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
    $('#returtindakan_transaksi_'+tindakanpelayanan_id).find(".integer, .integer-decimal, .integer2, .float2").each(function(){
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

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
<?php if(!empty($modKunjungan->pasienmasukpenunjang_id)){ ?>
    $("#form-datakunjungan > legend > .judul").html('Data Kunjungan <?php echo $modKunjungan->no_masukpenunjang ?>');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .box").addClass("well").removeClass("box");
	$("#form-datakunjungan :input").attr("readonly",true);
	$(".add-on").hide();
	$("#form-dialogtindakan > div > div > div > span.add-on").show();
	$("#form-masukpenunjang > div > div > div > span.add-on").show();
    setTindakanPelayanan();
    setTindakanRegistrasi();
<?php } ?>
});
</script>