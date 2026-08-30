<script type="text/javascript">
/**
* Set checklist pemeriksaan anestesi
* obj = div yang berisi elemen
*/
function setChecklistPemeriksaanAnestesi(obj) {
	var pasienanastesi_id = '<?php echo isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null ?>';	
	var ruangan_id = '<?php echo isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null ?>';	
	if (pasienanastesi_id == "") {
		myAlert("Silahkan pilih Pasien Anestesi!");
	}else{
		 $.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('getDataPasien'); ?>',
			data: {pasienanastesi_id:pasienanastesi_id},
			dataType: "json",
			success: function (data) {
				$("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
				$("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(data.kelaspelayanan_id);
				$("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(data.penjamin_id);
				updateChecklistPemeriksaanAnestesi();
				$('#dialog-pilihpemeriksaan').dialog('open');
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});		
	}
}
/**
* reset pencarian & checklist pemeriksaan anestesi
*/
function setChecklistPemeriksaanAnestesiReset() {
   $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function () {
	   $(this).val("");
   });
   updateChecklistPemeriksaanAnestesi();
}
/**
* update (refresh) checklist pemeriksaan anestesi
* harus include /js/jquery.tiler.js
* @param {obj} form_checklist
*/
function updateChecklistPemeriksaanAnestesi() {
   $('#dialog-pilihpemeriksaan .dialog-content').addClass("animation-loading");
   $.ajax({
	   type: 'POST',
	   url: '<?php echo $this->createUrl('SetChecklistPemeriksaanAnestesi'); ?>',
	   data: {data: $("#form-caripemeriksaan :input").serialize()},
	   dataType: "json",
	   success: function (data) {
		   $('#dialog-pilihpemeriksaan .dialog-content').html(data.content);
		   $('.checkboxlist-tile').tile({widths: [256]});
		   $('#dialog-pilihpemeriksaan .dialog-content').removeClass("animation-loading");
		   setCheckedPemeriksaan($("#table-tindakan-"), $('#dialog-pilihpemeriksaan .dialog-content'));
	   },
	   error: function (jqXHR, textStatus, errorThrown) {
		   console.log(errorThrown);
	   }
   });
}

/**
 * Centang pemeriksaan anestesi dari checkboxlist
 * di copy dari radiologi/pendaftaranRadiologiRujukanRS
 */
function pilihPemeriksaanIni(obj){
	unformatNumberSemua();
    var anastesi_id = $(obj).val();
    var anastesi_nama = $(obj).parent().find('input[name$="[anastesi_nama]"]').val();
    var jenisanastesi_nama = $(obj).parent().find('input[name$="[jenisanastesi_nama]"]').val();
    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
    var hargaanestesi = $(obj).parent().find('input[name$="[hargaanestesi]"]').val();
    var rowtindakan = [];
    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakanAnestesi'=>$modTindakanAnestesi),true));?>';
    if($(obj).is(':checked')){
        $("#table-tindakan").find('tbody').append(rowtindakan);
        $("#table-tindakan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#table-tindakan").find('input[name$="[ii][anastesi_id]"]').val(anastesi_id);
        $("#table-tindakan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#table-tindakan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
		$("#table-tindakan").find('span[name$="[ii][jenisanastesi_nama]"]').html(jenisanastesi_nama);
		$("#table-tindakan").find('span[name$="[ii][anastesi_nama]"]').html(anastesi_nama);
        $("#table-tindakan").find('input[name$="[ii][qty_tindakan]"]').val(1);
        $("#table-tindakan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#table-tindakan").find('input[name$="[ii][tarif_satuan]"]').val(hargaanestesi);
        $("#table-tindakan").find('input[name$="[ii][tarif_tindakan]"]').val(hargaanestesi);
        $("#table-tindakan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});		
		tambahTindakanPemakaianBahan($("#table-tindakan"));
    }else{
        var delete_row = $("#table-tindakan").find('input[name$="[anastesi_id]"][value="'+anastesi_id+'"]').parents('tr');
        delete_row.detach();
    }	
    renameInputRow($("#table-tindakan"));
	formatNumberSemua();
}

function tambahTindakanPemakaianBahan(obj_table)
{
	$(obj_table).find("tbody > tr").each(function(){
		var anastesi_id = $(this).find('input[name$="[anastesi_id]"]').val();
		var anastesi_nama = $(this).find('span[name$="[anastesi_nama]"]').text();
		$('#daftartindakanPemakaianBahan').append('<option value="'+anastesi_id+'">'+anastesi_nama+'</option>');
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
    
}
/**
* load pemeriksaan anamnesa yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setRiwayatAnamnesa(){
	var pasienanastesi_id = '<?php echo isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null; ?>';
    $('#riwayat-anamnesa').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setRiwayatAnamnesa'); ?>',
        data: {pasienanastesi_id:pasienanastesi_id},
        dataType: "json",
        success:function(data){
            $('#riwayat-anamnesa .content').html(data.rows);
            $('#riwayat-anamnesa').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
* load pemeriksaan anamnesa yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setRiwayatPemeriksaanFisik(){
	var pasienanastesi_id = '<?php echo isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null; ?>';
    $('#riwayat-pemeriksaan-fisik').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setRiwayatPemeriksaanFisik'); ?>',
        data: {pasienanastesi_id:pasienanastesi_id},
        dataType: "json",
        success:function(data){
            $('#riwayat-pemeriksaan-fisik .content').html(data.rows);
            $('#riwayat-pemeriksaan-fisik').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
* load pemeriksaan penunjang yang sudah tersimpan berdasarkan:
* - pasienmasukpenunjang_id
*/ 
function setRiwayatPemeriksaanPenunjang(){
	var pasienanastesi_id = '<?php echo isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null; ?>';
    $('#riwayat-pemeriksaan-penunjang').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setRiwayatPemeriksaanPenunjang'); ?>',
        data: {pasienanastesi_id:pasienanastesi_id},
        dataType: "json",
        success:function(data){
            $('#riwayat-pemeriksaan-penunjang .content').html(data.rows);
            $('#riwayat-pemeriksaan-penunjang').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
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
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
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

function tambahObatAlkesPasien(obj)
{
	unformatNumberSemua();
	var pasienanastesi_id = '<?php echo isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null; ?>';
	var penjamin_id = $("#penjamin_id").val();
	var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
	var obatalkes_kode = $(obj).parents('fieldset').find('#obatalkes_kode').val();
	var obatalkes_nama = $(obj).parents('fieldset').find('#obatalkes_nama').val();
//		var jumlah = $(obj).parents('fieldset').find('#qty_input').val(); //RND-11723
	var jumlah = $(obj).parents('fieldset').find('#jmlkonversi').val();

	if ((obatalkes_id != '') && (pasienanastesi_id != '') && (jumlah > 0)) {
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
			data: {obatalkes_id: obatalkes_id, jumlah: jumlah, pasienanastesi_id:pasienanastesi_id}, //
			dataType: "json",
			success: function (data) {
				if (data.pesan !== "") {
					myAlert(data.pesan);
					var params = [];
					params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi: 'Stok Obat Alkes Habis', isinotifikasi: obatalkes_kode + ' ' + obatalkes_nama + '  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
					simpanNotifikasi(params);
					return false;
				}
				var tambahkandetail = false;
				var obatalkesyangsama = $("#table-pemakaian-bahan input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
				if (obatalkesyangsama.val()) { //jika ada obat sudah ada di table
					myConfirm('Apakah anda akan input ulang obat ini?', 'Perhatian!', function (r)
					{
						if (r) {
							$("#table-pemakaian-bahan input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function () {
								$(this).parents('tr').detach();
							});
						}
						else {
							tambahkandetail = false;
						}
					});
				}else{
					tambahkandetail = true;
				}
				
				if (tambahkandetail) {
					$('#table-pemakaian-bahan > tbody').append(data.form);
					$("#table-pemakaian-bahan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
							{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
					);
					renameInputRow($("#table-pemakaian-bahan"));
				}
				$(obj).parents('fieldset').find('#obatalkes_id').val('');
				$('#obatalkes_nama').val('');
				$('#qty_input').val(1);
				formatNumberSemua();
				renameInputRow($("#table-pemakaian-bahan"));
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	} else {
		if (pasienanastesi_id == '') {
			myAlert("Silahkan isi data kunjungan terlebih dahulu !");
		} else if (obatalkes_id == '') {
			myAlert("Silahkan pilih obat alkes terlebih dahulu !");
		} else if (jumlah == 0) {
			myAlert("Stok obat kosong !");
		}
	}
	setObatAlkesPasienReset();
}

function setObatAlkesPasienReset() {
	$('#form-tambahobatalkes :input').val("");
	$('#qty_input').val("1");
	$('#jmlkemasan').val("1");
	$('#jmlkonversi').val("1");
	$('#obatalkes_nama').focus();
}

function batalOaPasien(obj)
{
	myConfirm('Apakah anda akan membatalkan obat / alat kesehatan ini?', 'Perhatian!', function (r)
	{
		if (r) {
			$(obj).parents('tr').remove();
			renameInputRow($("#table-pemakaian-bahan"));
		}
	});
}

function hitungSubTotal(obj)
{
	unformatNumberSemua();
	var subtotal = 0;
	var qty = parseInt($(obj).val());
	var qty_stok = parseInt($(obj).parents('tr').find('input[name$="[qty_oa]"]').val());
	var hargajual_oa = parseInt($(obj).parents('tr').find('input[name$="[hargajual_oa]"]').val());
	subtotal = qty * hargajual_oa;
	$(obj).parents('tr').find('input[name$="[iurbiaya]"]').val(formatInteger(subtotal));
	if (qty > qty_stok) {
		$(obj).val(qty_stok);
		myAlert("Jumlah tidak boleh lebih besar dari stok!");
	}
	formatNumberSemua();
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
	unformatNumberSemua();
	var qty_input = parseFloat($('#qty_input').val());
	var jmlkemasan = parseFloat($('#jmlkemasan').val());
	var jmlkonversi = parseFloat($('#jmlkonversi').val());

	var jumlah = jmlkonversi * jmlkemasan;
	if(!jQuery.isNumeric(jumlah)){
		jumlah = 0;
	}
	$('#qty_input').val(jumlah);
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
			myAlert("Data Obat tidak ditemukan !"); 
			console.log(errorThrown);
		}
	});
}
	
/**
* javascript untuk alat medis
*/
function inputAlatMedis(alatmedis_id)
{
    var anastesi_id = $('#daftartindakanPemakaianBahan option:selected').val();
    if(anastesi_id == ''){
        myAlert('Belum ada Tindakan Anestesi');
        return false;
    }
    
    jQuery.ajax({'url':'<?php echo $this->createUrl('setFormPemakaianAlat')?>',
		'data':{alatmedis_id:alatmedis_id, anastesi_id:anastesi_id},
		'type':'post',
		'dataType':'json',
		'success':function(data) {
			if(!sudahAdaAlat(alatmedis_id)){
				$('#table-pemakaian-alatmedis #trPemakaianBahan').detach();
				$('#table-pemakaian-alatmedis > tbody').append(data.form);
				renameInputRow($("#table-pemakaian-alatmedis")); 
			}
			$("#table-pemakaian-alatmedis > tbody tr:last .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
			$('.integer').each(function(){this.value = formatNumber(this.value)});
		} ,
	'cache':false});
}
function sudahAdaAlat(alatmedis_id)
{
	 var ada;
	 $('#table-pemakaian-alatmedis').find('input[name$="[alatmedis_id]"]').each(function(){
		 var cek = true;
		 if(this.value!=alatmedis_id){
			 ada = cek && ada;
		 } else {
			 myAlert('Sudah ada!');
			 ada = cek && true;
		 }
	 });

	return ada;
}
 
function hapusAlatMedis(obj){
    myConfirm("Apakan anda ingin menghapus ini ?","Perhatian!",function(r) {
        if(r){
            $(obj).parent().parent().remove();
            renameInputRow($("#table-pemakaian-alatmedis"));
        }
    });
    return false;
}

/**
* javascript untuk pemakaian BMHP
* */
function inputBMHP(daftartindakan_id,kelumur_id)
{
	var pasienanastesi_id = '<?php echo isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null ?>';	
    var ketemu = false;
	var anastesi_id = $('#daftartindakanPemakaianBahan option:selected').val();
    if(anastesi_id == ''){
        myAlert('Belum ada Tindakan Anastesis');
        return false;
    }
    $('#table-tindakan').find('input[name$="[daftartindakan_id]"]').each(function(){
	ketemu = true;
	jQuery.ajax({'url':'<?php echo $this->createUrl('setFormPemakaianBmhp')?>',
		'data':{daftartindakan_id:daftartindakan_id,pasienanastesi_id:pasienanastesi_id,anastesi_id:anastesi_id},
		'type':'post',
		'dataType':'json',
		'success':function(data) {
			if(data.pesan !== ""){
				myAlert(data.pesan);
				return false;
			}
			$('#table-pemakaian-bmhp > tbody').append(data.form);
			$("#table-pemakaian-bmhp").find('input[name*="[ii]"][class*="integer"]').maskMoney(
				{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
			);
			renameInputRowPemakaianBahan($("#table-pemakaian-bmhp"));  
			$('#obatalkes_id').val('');
			$('#paketBMHP').val('');
			formatNumberSemua();
			renameInputRowPemakaianBahan($("#table-pemakaian-bmhp")); 
			hitungTotalBMHP();
		} ,
		'cache':false});
    });
    if(!ketemu) {
        myAlert('Tidak ada tindakan yang dimaksud.');
    }
}
    
function hitungTotalBMHP()
{ 
    var total = 0;
    $('#table-pemakaian-bmhp').find('input[name$="[hargapemakaian]"]').each(function(){
        total = total + unformatNumber(this.value);
    });
    $('#totHargaBmhp').val(formatNumber(total));
}

/**
* rename input grid
*/ 
function renameInputRowPemakaianBahan(obj_table){
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

function hapusBMHP(obj){
    myConfirm("Apakan anda ingin menghapus ini ?","Perhatian!",function(r) {
        if(r){
            $(obj).parent().parent().remove();
            renameInputRowPemakaianBahan();
            hitungTotalBMHP();
        }
    });
    return false;
}

/**
* untuk print rencana tindakan anestesia
 */
function printHasil(caraPrint)
{
    var pasienanastesi_id = '<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>';
    window.open('<?php echo $this->createUrl('printHasil'); ?>&pasienanastesi_id='+pasienanastesi_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function loadDataTindakanAnestesi(praanestesi_id){
	$("#table-tindakan > div").addClass("animation-loading");
	var form_index = $('#form_index').val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetDataTindakanAnestesi'); ?>',
        data: {praanestesi_id:praanestesi_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
            }else{
                $('#table-tindakan > tbody').html(data.form);
				$("#table-tindakan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);
				renameInputRow($("#table-tindakan")); 
				tambahTindakanPemakaianBahan($("#table-tindakan"));
				setCheckedPemeriksaan($("#table-tindakan"),$('#dialog-pilihpemeriksaan .dialog-content'));
            }
            $("#table-tindakan > div").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data Tindakan Anestesi tidak ditemukan !"); 
            console.log(errorThrown);
            $("#form-tindakan > div").removeClass("animation-loading");
        }
    });
}

function tambahTindakanPemakaianBahan(obj_table)
{
	$(obj_table).find("tbody > tr").each(function(){
		var anastesi_id = $(this).find('input[name$="[anastesi_id]"]').val();
		var anastesi_nama = $(this).find('span[name$="[anastesi_nama]"]').text();
		$('#daftartindakanPemakaianBahan').append('<option value="'+anastesi_id+'">'+anastesi_nama+'</option>');
	});
}

function loadDataPemakaianBahan(praanestesi_id){
	$("#table-pemakaian-bahan > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetDataPemakaianBahan'); ?>',
        data: {praanestesi_id:praanestesi_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
            }else{
				$('#table-pemakaian-bahan > tbody').html(data.form);
				$("#table-pemakaian-bahan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);
				renameInputRow($("#table-pemakaian-bahan"));
            }
            $("#table-pemakaian-bahan > div").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data Pemakaian Bahan tidak ditemukan !"); 
            console.log(errorThrown);
            $("#table-pemakaian-bahan > div").removeClass("animation-loading");
        }
    });
}

function loadDataPemakaianBmhp(praanestesi_id){
	$("#table-pemakaian-bmhp > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetDataPemakaianBmhp'); ?>',
        data: {praanestesi_id:praanestesi_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
            }else{
				$('#table-pemakaian-bmhp > tbody').html(data.form);
				$("#table-pemakaian-bmhp").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);
				renameInputRow($("#table-pemakaian-bmhp"));
            }
            $("#table-pemakaian-bmhp > div").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data Pemakaian Bmhp tidak ditemukan !"); 
            console.log(errorThrown);
            $("#table-pemakaian-bmhp > div").removeClass("animation-loading");
        }
    });
}

function loadDataAlatMedis(praanestesi_id){
	$("#table-pemakaian-alatmedis > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetDataAlatMedis'); ?>',
        data: {praanestesi_id:praanestesi_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
            }else{
				$('#table-pemakaian-alatmedis > tbody').html(data.form);
				$("#table-pemakaian-alatmedis").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);
				renameInputRow($("#table-pemakaian-alatmedis"));
            }
            $("#table-pemakaian-alatmedis > div").removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data Pemakaian Alat Medis tidak ditemukan !"); 
            console.log(errorThrown);
            $("#table-pemakaian-alatmedis > div").removeClass("animation-loading");
        }
    });
}


/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
<?php if(!empty($_GET['pasienanastesi_id'])){ ?>
    setRiwayatAnamnesa();
    setRiwayatPemeriksaanFisik();
    setRiwayatPemeriksaanPenunjang();
<?php } ?>

var praanestesi_id = '<?php echo isset($_GET['praanestesi_id']) ? $_GET['praanestesi_id'] : null; ?>';
var ruangan_id = '<?php echo isset($modPraAnestesi->ruangan_id) ? $modPraAnestesi->ruangan_id : null; ?>';
var kamarruangan_id = '<?php echo isset($modPraAnestesi->kamarruangan_id) ? $modPraAnestesi->kamarruangan_id : null; ?>';
	if(praanestesi_id != ''){
		loadDataTindakanAnestesi(praanestesi_id);
		loadDataPemakaianBahan(praanestesi_id);
		loadDataPemakaianBmhp(praanestesi_id);
		loadDataAlatMedis(praanestesi_id);		
	} 
        
        $('form').bind('click keyup select change', function(event) {
                cekDisabled(this);
        });
        $(document).on('click keyup select change',function(){
                cekDisabled('form');
        }); 
        cekDisabled('form');
}); 

</script>