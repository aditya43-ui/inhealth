<script type="text/javascript">
function setTarifAmbulans(){
    var komponenunit_id = $('#PJPemakaianambulansT_pelayanan_ambulan').val();
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setTarifAmbulans'); ?>',
        data: {komponenunit_id:komponenunit_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
            }else{
                $('#jasa_sarana').val(formatNumber(data.modKonfigTarifAmbulas['tarifjasasarana']));
                $('#harga_bbm').val(formatNumber(data.harga_bbm));
                $('#PJPemakaianambulansT_daftartindakanId').val(data.daftartindakan_id);
                hitungBHP((data.harga_bbm));
                hitungJasaPengemudi((data.modKonfigTarifAmbulas['jasapengemudi_prosentase']));
                hitungJasaPendamping((data.modKonfigTarifAmbulas['jasapendamping_prosentase']));
                hitungJasaDokter((data.modKonfigTarifAmbulas['jasadokter_persentase']));
                
                hitungTotalTarifAmbulan();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Setting Konfig tarif ambulans!"); 
            console.log(errorThrown);
        }
    });
}

function hitungBHP(harga_bbm){
    var km_value = $('#km_value').val();
    if(km_value == ''){
        km_value = 0;
    }
    var jarak = Math.round(km_value / 1000);
    var totalBhp = 0;
    totalBhp = (2 * jarak) * 0.4 * harga_bbm;
    
    $('#bhp').val(formatNumber(totalBhp));
}
function hitungJasaPengemudi(jasapengemudi_prosentase){
    var jasa = unformatNumber($('#jasa_sarana').val());
    var bhp = unformatNumber($('#bhp').val());
    var total = (eval(jasapengemudi_prosentase) * (eval(jasa) + eval(bhp))) / 100 ; // 20 * (100.000 + 0) / 100
    
    $('#jasa_pengemudi').val(formatNumber(total));
}
function hitungJasaPendamping(jasapendamping_prosentase){
    var jasa = unformatNumber($('#jasa_sarana').val());
    var bhp = unformatNumber($('#bhp').val());
    var total = (eval(jasapendamping_prosentase) * (eval(jasa) + eval(bhp))) / 100;
    
    $('#jasa_pendamping').val(formatNumber(total));
}
function hitungJasaDokter(jasadokter_persentase){
    var jasa = unformatNumber($('#jasa_sarana').val());
    var bhp = unformatNumber($('#bhp').val());
    var total = (eval(jasadokter_persentase) * (eval(jasa) + eval(bhp))) / 100;
    
    $('#jasa_dokter').val(formatNumber(total));
}
function cekPendamping(){
    var checklist = $('#PJPemakaianambulansT_isPendamping');
    var pilih = checklist.attr('checked');
    if(pilih){
        $("#jasa_pendamping").attr("readonly",false);
    }else{
        $("#jasa_pendamping").attr("readonly",true);
    }
    hitungTotalTarifAmbulan();
} 

function cekDokter(){
    var checklist = $('#PJPemakaianambulansT_isDokter');
    var pilih = checklist.attr('checked');
    if(pilih){
        $("#jasa_dokter").attr("readonly",false);
    }else{
        $("#jasa_dokter").attr("readonly",true);
    }
    hitungTotalTarifAmbulan();
} 

function hitungTotalTarifAmbulan(){
    var isDokter = $('#PJPemakaianambulansT_isDokter').attr('checked');
    var isPendamping = $('#PJPemakaianambulansT_isPendamping').attr('checked');
    
    var jasa_sarana = parseFloat(unformatNumber($('#jasa_sarana').val()));
    var bhp = parseFloat(unformatNumber($('#bhp').val()));
    var jasa_pengemudi = parseFloat(unformatNumber($('#jasa_pengemudi').val()));
    var jasa_pendamping = parseFloat(unformatNumber($('#jasa_pendamping').val()));
    var jasa_dokter = parseFloat(unformatNumber($('#jasa_dokter').val()));
    
    var biaya_tol = parseFloat(unformatNumber($('#biaya_tol').val()));
    
    var total;
    if(isDokter && isPendamping){
        total = eval(jasa_sarana) + eval(bhp) + eval(jasa_pengemudi) + eval(jasa_pendamping) + eval(jasa_dokter);
    }
    else if (isDokter && !(isPendamping)){
        total = eval(jasa_sarana) + eval(bhp) + eval(jasa_pengemudi) + eval(jasa_dokter);
    }
    else if (!(isDokter) && isPendamping){
        total = eval(jasa_sarana) + eval(bhp) + eval(jasa_pengemudi) + eval(jasa_pendamping);
    }
    else{
        total = eval(jasa_sarana) + eval(bhp) + eval(jasa_pengemudi);
    }
    
    total += biaya_tol;
    
    $('#total_tarif').val(formatNumber(total));
    
}

function clearTarifAmbulans(){
//    $("#AMPemakaianambulansT_pelayanan_ambulan option:selected").text("-- Pilih --");
    $("#PJPemakaianambulansT_pelayanan_ambulan").val("");
	$("#jasa_sarana").val("");
    $("#harga_bbm").val("");
    $("#bhp").val("");
    $("#jasa_pengemudi").val("");
    $("#jasa_pendamping").val("");
    $("#jasa_dokter").val("");
    $("#total_tarif").val("");
    $("#biaya_tol").val("");
}

function inputTarifAmbulansAPI()
{
	var tambahkantarif = true;
	var jmlTr = $("#tblTarifAmbulansAPI > tbody > tr").length;
	
	var jmlKM = $("#km_value").val();
	var jmlKM = (jmlKM/1000);
//	var alamatTujuan = $("#alamat_value").val();
        var rutetujuan_ambulan = $("#alamat_value").val();
        var ruteasal_ambulan = $("#FromsearchTextField").val();
        var durasipemakaian_ambulan = $("#durasi").val();
        var jenispelayanan_ambulans_id = $("#PJPemakaianambulansT_pelayanan_ambulan").val();
        var jenispelayanan_ambulans = $("#PJPemakaianambulansT_pelayanan_ambulan option:selected").text();
        var jasasarana_ambulans = $("#jasa_sarana").val();
        var harga_bbm = $("#harga_bbm").val();
        var bhp = $("#bhp").val();
        var jasapengemudi = $("#jasa_pengemudi").val();
        var daftartindakanId = $("#PJPemakaianambulansT_daftartindakanId").val();
        
        var jasapendamping = 0;
        var isPendamping = $('#PJPemakaianambulansT_isPendamping').attr('checked');
        if(isPendamping){
            jasapendamping = $("#jasa_pendamping").val();
        }
        
        var jasadokter = 0;
        var isDokter = $('#PJPemakaianambulansT_isDokter').attr('checked');
        if(isDokter){
            jasadokter = $("#jasa_dokter").val();
        }
        
        var biaya_tol = $("#biaya_tol").val();
        var total_tarif = $("#total_tarif").val();
        
	
	var tr = '<tr><td><input type="text" value="'+rutetujuan_ambulan+'" name="tarif[rutetujuan_ambulan][]" class="span3" readonly="readonly"></td>'+
                        '<td><input type="text" value="'+jmlKM+'" name="tarif[jmlKM][]" class="span1" readonly="readonly"></td>'+
                        '<td><input type="text" value="'+durasipemakaian_ambulan+'" name="tarif[durasipemakaian_ambulan][]" class="span2x" readonly="readonly"></td>'+
                        '<td><input type="text" value="'+jenispelayanan_ambulans+'" name="tarif[jenispelayanan_ambulans][]" class="span2" readonly="readonly">'+
                            '<input type="hidden" value="'+jenispelayanan_ambulans_id+'" name="tarif[jenispelayanan_ambulans_id][]" class="span2x" readonly="readonly">'+
                            '<input type="hidden" value="'+ruteasal_ambulan+'" name="tarif[ruteasal_ambulan][]" class="span2x" readonly="readonly"></td>'+
                            '<input type="hidden" value="'+daftartindakanId+'" name="tarif[daftartindakanId][]" class="span2x" readonly="readonly"></td>'+
				'<td><input type="text" value="'+jasasarana_ambulans+'" name="tarif[jasasarana_ambulans][]" class="span2x integer2" readonly="readonly"></td>'+
				'<td><input type="text" value="'+harga_bbm+'" name="tarif[harga_bbm][]" class="span2x integer2" readonly="readonly"></td>'+
                                '<td><input type="text" value="'+bhp+'" name="tarif[bhp][]" class="span2x integer2" readonly="readonly"></td>'+
                                '<td><input type="text" value="'+jasapengemudi+'" name="tarif[jasapengemudi][]" class="span2x integer2" readonly="readonly"></td>'+
                                '<td><input type="text" value="'+jasapendamping+'" name="tarif[jasapendamping][]" class="span2x integer2" readonly="readonly"></td>'+
                                '<td><input type="text" value="'+jasadokter+'" name="tarif[jasadokter][]" class="span2x integer2" readonly="readonly"></td>'+
                                '<td><input type="text" value="'+biaya_tol+'" name="tarif[biayatol][]" class="span2x integer2" readonly="readonly"></td>'+
                                '<td><input type="text" value="'+total_tarif+'" name="tarif[tarifAmbulans][]" class="span2x integer2" readonly="readonly"></td>'+
				
//            '<td><input type="text" value="" name="tarif[tarifKM][]" onblur="hitungTarifAPI(this);" class="span1 integer"></td>'+
//				'<td><input type="text" value="" name="tarif[tarifAmbulans][]" onblur="hitungTarifAPI(this);" class="span2 integer"></td>'+
				'<td><i class="icon-form-silang" onclick="batalTarif(this);return false;"></i></td>'
			'</tr>';	
	if(jmlTr >= 1){
		myConfirm("Apakah Anda akan input ulang tarif ambulans ini?","Perhatian!",
		function(r){
			if(r){
				$("#tblTarifAmbulansAPI > tbody > tr:first").each(function(){
					$(this).detach();
				});
				if(tambahkantarif){
					$("#tblTarifAmbulansAPI > tbody").append(tr);
					$("#tblTarifAmbulansAPI").find('input[class*="integer"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
					);
					$("#tblTarifAmbulansAPI > tbody > tr:last .number").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
					$('.number').each(function(){this.value = formatNumber(this.value)});
					hitungTotalTarifAPI();
				}
			}else{
				$("#tblTarifAmbulansAPI > tbody > tr:last").each(function(){
					$(this).detach();
				});
				tambahkantarif = false;
			}
		}); 
	}else{
		if(tambahkantarif){
			$("#tblTarifAmbulansAPI > tbody").append(tr);
			$("#tblTarifAmbulansAPI").find('input[class*="integer"]').maskMoney(
				{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
			);
			$("#tblTarifAmbulansAPI > tbody > tr:last .number").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
			$('.number').each(function(){this.value = formatNumber(this.value)});
			hitungTotalTarifAPI();
                        clearTarifAmbulans();
		}
	}
}

function hitungTarif(obj)
{
	unformatNumberSemua();
    var km = $(obj).parent().parent().find('input[name$="[jmlKM][]"]');
    var tarifkm = $(obj).parent().parent().find('input[name$="[tarifKM][]"]');
    var biayatol = $(obj).parent().parent().find('input[name$="[biayatol][]"]');
    var tarif = $(obj).parent().parent().find('input[name$="[tarifAmbulans][]"]');
    
    tarif.val(formatNumber(unformatNumber(km.val()) * unformatNumber(tarifkm.val()) + unformatNumber(biayatol.val())) );
	formatNumberSemua();	
}

function hitungTotalTarifAPI(obj)
{
	unformatNumberSemua();
    totaltarif = 0;
    $('#tblTarifAmbulans > tbody > tr').each(function(){
        totaltarif = parseFloat( $(this).find('input[name*="[jmlKM]"]').val() * $(this).find('input[name*="[tarifKM]"]').val() );
		 $(this).find('input[name*="[tarifAmbulans]"]').val(totaltarif);
    });
    
    formatNumberSemua();	
}

function batalTarif(obj)
{
    myConfirm("Apakah Anda akan membatalkan tarif mobil ini?","Perhatian!",function(r) {
        if(r){
            $(obj).parents('tr').remove();
        }
    });
}

/**
* menambahkan form obatalkespasien ke tabel
* copy dari: laboratorium.views.pemakaianBmhp
* @type Arguments
*/
function tambahObatAlkesPasien(obj)
{
   unformatNumberSemua();
   var daftartindakan_id = $('#daftartindakanPemakaianBahan').val();
   var pendaftaran_id = $('#<?php echo CHtml::activeId($modKunjungan,'pendaftaran_id'); ?>').val();
   var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
   var satuankecil_id = $(obj).parents('fieldset').find('#satuankecil_id').val();
   var obatalkes_kode = $(obj).parents('fieldset').find('#obatalkes_kode').val();
   var obatalkes_nama = $(obj).parents('fieldset').find('#obatalkes_nama').val();
//		var jumlah = $(obj).parents('fieldset').find('#qty_input').val(); //RND-11723
   var jumlah = $(obj).parents('fieldset').find('#jmlkonversi').val();

   if ((obatalkes_id != '') && (jumlah > 0)) {
	   $.ajax({
		   type: 'POST',
		   url: '<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
		   data: {obatalkes_id: obatalkes_id, daftartindakan_id:daftartindakan_id, jumlah: jumlah, pendaftaran_id:pendaftaran_id, satuankecil_id:satuankecil_id},
		   dataType: "json",
		   success: function (data) {
			   if (data.pesan !== "") {
				   myAlert(data.pesan);
				   var params = [];
				   params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi: 'Stok Obat Alkes Habis', isinotifikasi: obatalkes_kode + ' ' + obatalkes_nama + '  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
				   simpanNotifikasi(params);
				   return false;
			   }
			   var tambahkandetail = true;
			   var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
			   if (obatalkesyangsama.val()) { //jika ada obat sudah ada di table
				   myConfirm('Apakah Anda akan input ulang obat ini?', 'Perhatian!', function (r)
				   {
					   if (r) {
						   $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function () {
							   $(this).parents('tr').detach();
						   });
					   }
					   else {
						   tambahkandetail = false;
					   }
				   });
			   }
			   if (tambahkandetail) {
				   $('#table-obatalkespasien > tbody').append(data.form);
				   $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
						   {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				   );
				   $("#table-obatalkespasien").find('input[name*="[ii]"][class*="float"]').maskMoney(
						   {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				   );
				   renameInputRowObatAlkes($("#table-obatalkespasien"));
			   }
			   $(obj).parents('fieldset').find('#obatalkes_id').val('');
			   $('#obatalkes_nama').val('');
			   $('#qty_input').val(1);
			   formatNumberSemua();
			   renameInputRowObatAlkes($("#table-obatalkespasien"));
		   },
		   error: function (jqXHR, textStatus, errorThrown) {
			   console.log(errorThrown);
		   }
	   });
   } else {
		if (obatalkes_id == '') {
		   myAlert("Silakan pilih obat alkes terlebih dahulu!");
		} else if (jumlah == 0) {
		   myAlert("Stok obat kosong!");
		}
   }
   setObatAlkesPasienReset();
}
	
/**
* reset form obat
* copy dari: laboratorium.views.pemakaianBmhp
*/
function setObatAlkesPasienReset() {
   $('#form-tambahobatalkes :input').val("");
   $('#qty_input').val("1");
   $('#obatalkes_nama').focus();
}

/**
* rename input grid
* copy dari: laboratorium.views.pemakaianBmhp
*/
function renameInputRowObatAlkes(obj_table) {
   var row = 0;
   $(obj_table).find("tbody > tr").each(function () {
	   $(this).find("#no_urut").val(row + 1);
	   $(this).find('span').each(function () { //element <input>
		   var old_name = $(this).attr("name").replace(/]/g, "");
		   var old_name_arr = old_name.split("[");
		   if (old_name_arr.length == 3) {
			   $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
		   }
	   });
	   $(this).find('input,select,textarea').each(function () { //element <input>
		   var old_name = $(this).attr("name").replace(/]/g, "");
		   var old_name_arr = old_name.split("[");
		   if (old_name_arr.length == 3) {
			   $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
			   $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
		   }
	   });
	   row++;
   });
}
/**
* membatalkan form input obat alkes pasien 
* copy dari: laboratorium.views.pemakaianBmhp
*/
function batalOaPasien(obj)
{
   myConfirm('Apakah Anda akan membatalkan obat / alat kesehatan ini?', 'Perhatian!', function (r)
   {
	   if (r) {
		   $(obj).parents('tr').remove();
		   renameInputRowObatAlkes($("#table-obatalkespasien"));
	   }
   });
}

function setSatuanObat(obatalkes_id){
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('setSatuanObat'); ?>',
		data: {obatalkes_id:obatalkes_id},
		dataType: "json",
		success:function(data){
			if(data.pesan != ""){
				myAlert(data.pesan);
			}else{
				$('#satuankecil_nama').html(data.satuankecil);
				$('#satuanterkecil_nama').html(data.satuanterkecil);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { 
			myAlert("Data Obat tidak ditemukan!"); 
			console.log(errorThrown);
		}
	});
}
	
// untuk menjumlahkan konversi dari qty input / jmlkemasan terkecil
function totalKonversi(){
	unformatNumberSemua();
	var qty_input = parseFloat($('#qty_input').val());
	var jmlkemasan = parseFloat($('#jmlkemasan').val());
	var jmlkonversi = parseFloat($('#jmlkonversi').val());

	var jml = qty_input / jmlkemasan;
	if(!jQuery.isNumeric(jml)){
		jml = 0;
	}
	$('#jmlkonversi').val(jml);
}

function totalJumlah(){
	var qty_input = parseFloat($('#qty_input').val());
	var jmlkemasan = parseFloat($('#jmlkemasan').val());
	var jmlkonversi = parseFloat($('#jmlkonversi').val());

	var jumlah = jmlkonversi * jmlkemasan;
	if(!jQuery.isNumeric(jumlah)){
		jumlah = 0;
	}
	$('#qty_input').val(jumlah);
}

/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
    $(".float").each(function(){
        $(this).val(parseFloat(unformatNumber($(this).val())));
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
    $(".float").each(function(){
        $(this).val(formatFloat($(this).val()));
    });
}
$( document ).ready(function(){
    cekDisabled($('#pemakaianambulans-t-form')); 
    $("#no_pendaftaran").blur(cekDisabled($('#pemakaianambulans-t-form')));
});
</script>