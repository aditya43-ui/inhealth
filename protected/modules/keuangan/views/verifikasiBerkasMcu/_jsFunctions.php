<script type="text/javascript">
/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
/**
 * untuk mengambil data tagihan pasien untuk di verifikasi
 * @returns {undefined}
 */
function setInfoPasien(pendaftaran_id, no_pendaftaran, no_rekam_medik){
	$("#form-infopasien > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataInfoPasien'); ?>',
        data: {pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik},
        dataType: "json",
        success:function(data){
            $("#pendaftaran_id").val(data.pendaftaran_id);
            $("#pasien_id").val(data.pasien_id);
            $("#no_pendaftaran").val(data.no_pendaftaran);
            $("#no_rekam_medik").val(data.no_rekam_medik);
            $("#namadepan").val(data.nama_depan);
            $("#nama_pasien").val(data.nama_pasien);
            $("#nama_bin").val(data.nama_bin);
            $("#jeniskelamin").val(data.jeniskelamin);
            $("#tanggal_lahir").val(data.tanggal_lahir);
            
			setDataVerifikasi(data.pendaftaran_id,data.no_pendaftaran,data.no_rekam_medik);
            $("#form-infopasien > div").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan!"); 
            console.log(errorThrown);
            $("#form-infopasien > div").removeClass("animation-loading");
        }
    });
}

/*
* untuk mereset data pasien
 * @returns {undefined} */
function setInfoPasienReset(){
	$("#pendaftaran_id").val("");
	$("#pasien_id").val("");
	$("#no_pendaftaran").val("");
	$("#no_rekam_medik").val("");
	$("#namadepan").val("");
	$("#nama_pasien").val("");
	$("#nama_bin").val("");
	$("#jeniskelamin").val("");
	$("#tanggal_lahir").val("");
}

function setDataVerifikasi(pendaftaran_id,no_pendaftaran,no_rekam_medik){
	if(pendaftaran_id != '')
	{
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('loadFormVerifikasi'); ?>',
			data: {pendaftaran_id:pendaftaran_id,no_pendaftaran:no_pendaftaran,no_rekam_medik:no_rekam_medik},//
			dataType: "json",
			success:function(data){
				if(data.pesan !== ""){
                    myAlert(data.pesan);
                }
				$('#tabel-verifikasi > tbody').append(data.form);
				renameInputRowVerifikasi($("#tabel-verifikasi"));                    
				setInfoPasienReset();
				hitungTotal();
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}else{
		myAlert("Isikan data pasien terlebih dahulu");
	}
}
/**
* rename input grid
*/ 
function renameInputRowVerifikasi(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    
}

function hitungTotal(){
    unformatNumberSemua();
    var total_tagihan = 0;
    $('#tabel-verifikasi tbody tr').each(function(){
        var tagihan  = parseInt($(this).find('input[name$="[tagihan]"]').val());
		
        total_tagihan += tagihan;
		
    });
	
    $('#total_tagihan').val(total_tagihan);  
    formatNumberSemua();
}

function setDialog(obj){
	unformatNumberSemua();
	
    parent = $(obj).parents("tr").find("input").attr("id");
    dialog = "#dialogVerifikasiBerkas";
	var namarumahsakit = $(obj).parents('tr').find('input[name$="[rumahsakitrujukan]"]').val();
	var totaltagihan = $(obj).parents('tr').find('input[name$="[tagihan]"]').val();
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('loadFormVerifikasiBerkas'); ?>',
		data: {namarumahsakit:namarumahsakit, totaltagihan:totaltagihan},
		dataType: "json",
		success:function(data){
			$('#dialogVerifikasiBerkas div.divForForm').html(data.form);
			$(dialog).attr("parent-dialog",parent);
			$(dialog).dialog("open");
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
	formatNumberSemua();
}

function verifikasi(){
	unformatNumberSemua();
	var form = $('#dataverifikasi-form').serialize();
	
	if(requiredCheck($("dataverifikasi-form"))){
		dialog = "#dialogVerifikasiBerkas";
		parent = $(dialog).attr("parent-dialog");
		obj = $("#"+parent);
		
		jQuery.ajax({'url':'<?php echo $this->createUrl('setDataVerifikasi')?>',
			'data':form,
			'type':'post',
			'dataType':'json',
			'success':function(data){
//				$(obj).val(data[0].namarumahsakit);
//				$(obj).val(data[0].tgl_jatuhtempo);
				setVerifikasi(obj,data);
			},
			'cache':false
		});
		$(dialog).dialog("close");
	}
	formatNumberSemua();
	return false;
}

function verifikasiBerkas(){
	unformatNumberSemua();	
	if(requiredCheck($("verifikasiberkasmcu-t-form"))){
		var jmlVerifikasi = $('#tabel-verifikasi tbody tr').length;
		if(jmlVerifikasi <= 0){
			myAlert('Silakan isikan daftar pasien yang akan diverifikasi berkas terlebih dahulu!');
            return false;
        }else{
            $('#verifikasiberkasmcu-t-form').submit();
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

function setVerifikasi(obj,item)
{
    $(obj).parents('tr').find('input[name$="[berkas_1]"]').val(item.berkas_1);
    $(obj).parents('tr').find('input[name$="[berkas_2]"]').val(item.berkas_2);
    $(obj).parents('tr').find('input[name$="[berkas_3]"]').val(item.berkas_3);
    $(obj).parents('tr').find('input[name$="[nosurat_rs]"]').val(item.nosurat_rs);
    $(obj).parents('tr').find('input[name$="[tglsurat_rs]"]').val(item.tglsurat_rs);
    $(obj).parents('tr').find('input[name$="[tgljatuhtempo]"]').val(item.tgljatuhtempo);
    $(obj).parents('tr').find('input[name$="[tglverifikasiberkasmcu]"]').val(item.tglverifikasiberkasmcu);
    $(obj).parents('tr').find('input[name$="[tglberkasmcumasuk]"]').val(item.tglberkasmcumasuk);
    $(obj).parents('tr').find('input[name$="[statusverifikasiberkas]"]').val(item.statusverifikasiberkas);
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

function cekSemua(obj){
	$('#tabel-verifikasi tbody tr').each(function(){
		if($(obj).is(":checked")){
			$(this).find('input[name$="[checklist]"]').attr('checked',true);
		}else{
			$(this).find('input[name$="[checklist]"]').removeAttr('checked',true);
		}
	});
}
/*
 * untuk print verifikasi berkas mcu
 */
function print(caraPrint)
{
    var noverifikasiberkasmcu = '<?php echo isset($_GET['noverifikasiberkasmcu']) ? $_GET['noverifikasiberkasmcu'] : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&noverifikasiberkasmcu='+noverifikasiberkasmcu+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$( document ).ready(function(){
	renameInputRowVerifikasi($("#tabel-verifikasi"));
	hitungTotal();
});
</script>
    