<?php
/**
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 *
 * Fungsi javascript ditulis disini.
 */
?>
<script type="text/javascript">

var is_signa_select = false;

function form_tambah_signa() {
    myPrompt("Tambah Signa Baru", "", "", function(r) {
        var v = r;

        if (v.trim() == "") return false;

        myConfirm("Anda yakin untuk menambah signa '" + r + "'?", "Peringatan", function(yes) {
            if (yes) {
                $.post('<?php echo $this->createUrl('/actionAjax/tambahSigna'); ?>', {signa: v.trim()}, function(data) {
                    myAlert(data.msg);
                }, 'json');
            }
        });
    });
}

function setDokterReseptur(nama, id) {
    $("#nama_pegawai_reseptur").val(nama);
    $("#pegawai_reseptur").val(id);
    $("#dialogDokterDPJP").dialog("close");
}


function cekObat(){
	var deposit = $('#deposit').val();
	var totalHargaReseptur = unformatNumber($('#totalHargaReseptur').val());
	// requiredCheck
	var no_resep = $('#RIResepturT_noresep').val();
	var jumlah_obat = $('#table-obatalkespasien tbody tr').length;
	if (no_resep == ""){
     myAlert('Isi No. Resep!');
     return false;
	}else if(jumlah_obat<= 0){
     myAlert('Anda Belum memilih Obat Yang Akan Diminta');
     return false;
	} else{
    $(".integer2, .float2, .integer-decimal").each(function(){
        $(this).val(unformatNumber($(this).val()));
    });
		$('#rjreseptur-t-form').submit();
		$("#btn_submit").attr("disabled",true);
	}
   return false;
}
function hitungQtyRacikan()
{
    var permintaan = $('#permintaan').val();
    var jmlKemasan = $('#jmlKemasanObat').val();
    var kekuatan = $('#kekuatanObat').val();
    var qty = permintaan * jmlKemasan / kekuatan;

    if (jQuery.isNumeric(permintaan)){
        $('#jmlPermintaan').val(permintaan);
    }
    if (jQuery.isNumeric(kekuatan)){
        $('#kekuatan').val(kekuatan);
    }
    if (jQuery.isNumeric(jmlKemasan)){
        $('#jmlKemasan').val(jmlKemasan);
    }
    if (jQuery.isNumeric(qty)){
        $('#qty').val(qty);
    }
    if (jQuery.isNumeric(qty)){
        $('#qtyRacik').val(qty);
    }
}

function tambahObatNonRacik(obj)
{
    var obatalkes_id = $(obj).parents('#form-nonracikan').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('#form-nonracikan').find('#qtyNonRacik').val();
    var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatNonRacik = $('#namaObatNonRacik').val();
    var ruangan_id = $('#<?php echo CHtml::activeId($modReseptur,"ruangan_id") ?>').val();
	var isRacikan = 0;
	var therapiobat_id = $(obj).parents('.row').find('#therapiobat_id2').val();
    if(rke==undefined){rke=1;}else{rke++;}
    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,ruangan_id:ruangan_id,isRacikan:isRacikan,therapiobat_id:therapiobat_id},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatNonRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;

				var therapiobatyangsama = $("#table-obatalkespasien input[name$='[therapiobat_id]'][value='"+therapiobat_id+"']");
				if(therapiobatyangsama.val()){ //jika ada therapi obat sudah ada
					myAlert('Obat ini memiliki kelas therapi yang sama dengan pilihan obat sebelumnya');
				}
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");

                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah Anda akan input ulang obat ini?","Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                rke = $(this).parents("tr").find(".rke").val();
                                $(this).parents('tr').remove();
                            });

                            if(tambahkandetail){
                                $('#table-obatalkespasien > tbody').append(data.form);
                                $("#table-obatalkespasien").find('input[name*="[ii]"][class*="qty"]').maskMoney(
                                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
                                );
                                addDataKeGridObat(obj,'nonracik',rke);
                                renameInputRowObatAlkes($("#table-obatalkespasien"));
                                hitungTotal();
                                // hitungtotalHargaReseptur();
                            }

                            $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
                            $('#namaObatNonRacik').val('');
                            $('#qtyNonRacik').val(1);
                            // formatNumberSemua();
                            renameInputRowObatAlkes($("#table-obatalkespasien"));

                        }else{
                            tambahkandetail = false;
                        }
                    });
                } else {

                    if (tambahkandetail) {
                        $('#table-obatalkespasien > tbody').append(data.form);
                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="qty"]').maskMoney(
                            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
                        );
                        addDataKeGridObat(obj,'nonracik',rke);
                        renameInputRowObatAlkes($("#table-obatalkespasien"));
                        hitungTotal();
                        // hitungtotalHargaReseptur();
                    }
                    $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
                    $('#namaObatNonRacik').val('');
                    $('#qtyNonRacik').val(1);
                    // formatNumberSemua();
                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatNonRacik").focus();
}

function tambahObatRacik(obj)
{
    var obatalkes_id = $(obj).parents('#form-racikan').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('#form-racikan').find('#qtyRacik').val();
	var ruangan_id = $('#<?php echo CHtml::activeId($modReseptur,"ruangan_id") ?>').val();
    var rke = $(obj).parents('#form-racikan').find('#racikanKe').val();
    var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatRacik = $('#namaObatRacik').val();
    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;
	var isRacikan = 1;

    if(obatalkes_id != '')
    {

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,ruangan_id:ruangan_id,isRacikan:isRacikan},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah Anda akan input ulang obat ini?","Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
						if(tambahkandetail){
							if (indexrke==0) {
									$('#table-obatalkespasien > tbody').append(data.form);
							}else{
								$('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
								$("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
							}
							$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
								{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
							);
							addDataKeGridObat(obj,'racik',rke);
							renameInputRowObatAlkes($("#table-obatalkespasien"));
							hitungTotal();
							// hitungtotalHargaReseptur();
						}
                        }else{
                            tambahkandetail = false;
                        }
                    });
                }else{
					$('#table-obatalkespasien > tbody > tr').each(function(){
						if($(this).find('input[name*="[rke]"]').val()==rke){
							if (marginrke==0) {
								if(statusmargin==0){
									marginrke=jmlrke;
									statusmargin = 1;
								}
							};
							indexrke++;
						}
						jmlrke++;
					});

					if(tambahkandetail){
						if (indexrke==0) {
								$('#table-obatalkespasien > tbody').append(data.form);
						}else{
							$('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
							$("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
						}
						$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
							{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
						);
						addDataKeGridObat(obj,'racik',rke);
						renameInputRowObatAlkes($("#table-obatalkespasien"));
						hitungTotal();
						// hitungtotalHargaReseptur();
					}
				}

                $(obj).parents('#form-racikan').find('#obatalkes_id').val('');
                $('#namaObatRacik').val('');
                $('#qtyNonRacik').val(1);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatRacik").focus();
    setTombolRacikanBaru();
}

function setTombolRacikanBaru(){
	$("#formanak").addClass("animation-loading-1");
	setTimeout(function(){
		$("#tombolracikanbaru").attr('disabled',false);
		$("#racikanKe").attr('disabled',true);
		$("#signaracikan").attr('disabled',true);
		$("#etiketracikan").attr('disabled',true);
		$("#jmlKemasanObat").attr('disabled',true);
		$("#satuansediaan").attr('disabled',true);
		$("#permintaan").val('');
		$("#kekuatanObat").val('');
		hitungJumlahObat();
		$("#formanak").removeClass("animation-loading-1");
	},500);
}

function hitungSubTotal(obj)
{
    var qty = unformatNumber($(obj).parents('tr').find('input[name="qty[]"]').val());
    var harga = unformatNumber($(obj).parents('tr').find('input[name="hargajual[]"]').val());
    subTotal = qty * harga;

    $(obj).parents('tr').find('input[name="subTotal[]"]').val(formatInteger(subTotal));
    // hitungTotalHargaReseptur();
}

//function hitungTotalHargaReseptur()
//{
//    totalHarga = 0;
//    $('#tblDaftarResep').find('input[name="subTotal[]"]').each(function(){
//        totalHarga = totalHarga + unformatNumber(this.value);
//    });
//    $('#totalHargaReseptur').val(formatInteger(totalHarga));
//}

function removeObat(obj)
{
    myConfirm("Apakah Anda akan menghapus obat?","Perhatian!",function(r) {
        if(r){
            $(obj).parent().parent().remove();
            hitungTotal();
            // hitungTotalHargaReseptur();
        }
    });

}

function adaRmax(Rke)
{
    var ada = false;
    $('#tblDaftarResep').find('input[name="Rke[]"]').each(function(){
       if(Rke == this.value)
           ada = true;
    });

    return ada;
}

function enableRacikan()
{
    $('#formRacikan input[type="text"]').removeAttr('disabled');
    $('#formRacikan input[type="text"]').removeAttr('readonly');
    $('#formRacikan select').removeAttr('disabled');
    $('#formRacikan button').removeAttr('disabled');
    $('#formNonRacikan input[type="text"]').attr('disabled','disabled');
    $('#formNonRacikan select').attr('disabled','disabled');
    $('#formNonRacikan button').attr('disabled','disabled');
    $('#formNonRacikan input[type="radio"]').removeAttr('checked');
    $('#racikanKe').focus();
}

function enableNonRacikan()
{
    $('#formNonRacikan input[type="text"]').removeAttr('disabled');
    $('#formNonRacikan select').removeAttr('disabled');
    $('#formNonRacikan button').removeAttr('disabled');
    $('#formRacikan input[type="text"]').attr('disabled','disabled');
    $('#formRacikan select').attr('disabled','disabled');
    $('#formRacikan button').attr('disabled','disabled');
    $('#formRacikan input[type="radio"]').removeAttr('checked');
}

function clearRacikan()
{
    $('#formRacikan input[type="text"]').val('');
    $('#satuanKekuatanObat').html('');
    $('#racikanKe').focus();
}

function clearNonRacikan()
{
    $('#formNonRacikan input[type="text"]').val('');
    $('#satuanKekuatanObat').html('');
    $('#racikanKe').focus();
}

function clearInputan()
{
    $('#idObat').val('');
    $('#hargaSatuan').val('');
    $('#hargaNetto').val('');
    $('#hargaJual').val('');
    $('#kekuatan').val('');
    $('#satuanKekuatan').val('');
    $('#jmlPermintaan').val('');
    $('#jmlKemasan').val('');
    $('#qty').val('');
    $('#signa').val('');
    $('#namaObat').val('');
    $('#idSumberDana').val('');
    $('#namaSumberDana').val('');
    $('#idSatuanKecil').val('');
    clearRacikan(); clearNonRacikan();
	$('#therapiobat_id2').val('');
}

function terapiobat_reset(){
	$("#formNonRacikan").addClass("animation-loading");
	var ruangantujuan_id = $('#RIResepturT_ruangan_id').val();
		$('#therapiobat_id').val('');
		$('#therapiobat_nama').val('');
		$('#RIObatAlkesM_therapiobat_id').val('');
//		if(therapiobat_id != ''){
			$.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
				data: {
					"RIObatalkesM[ruangan_id]":ruangantujuan_id,
				}
			});
//		}

		clearInputan();
	setTimeout(function(){
		$("#formNonRacikan").removeClass("animation-loading");
	},500);
}

// function untuk men set dialog oa agar berelasi dengan therapiobatmap_m
function setOAJoinTerapi(){
	var therapiobat_id = $('#therapiobat_id').val();
	var ruangantujuan_id = $('#RIResepturT_ruangan_id').val();
	$("#namaObatNonRacik").addClass("animation-loading-1");
		<?php $modObatDialog->therapiobat_id = true; ?>
		$.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
			data: {
				"RIObatalkesM[ruangan_id]":ruangantujuan_id,
				"RIObatalkesM[therapiobat_id]":therapiobat_id,
			}
		});
	setTimeout(function(){
		$("#namaObatNonRacik").removeClass("animation-loading-1");
	},500);
}

function setOaByRuangTujuan(){
	$("#formNonRacikan").addClass("animation-loading");
	clearInputan();
	setTimeout(function(){
		$("#formNonRacikan").removeClass("animation-loading");
	},500);
}

$('#tombolDialogOa').click(function(){
	var therapiobat_id = $('#therapiobat_id').val();
	var ruangantujuan_id = $('#RIResepturT_ruangan_id').val();
	$.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
		data: {
			"RIObatalkesM[ruangan_id]":ruangantujuan_id,
			"RIObatalkesM[therapiobat_id]":therapiobat_id,
		}
	});
});

$('#tombolDialogOaRacikan').click(function(){
	var therapiobat_id = $('#therapiobat_id').val();
	var ruangantujuan_id = $('#RIResepturT_ruangan_id').val();
	$.fn.yiiGridView.update('obatAlkesDialogRacikan-m-grid', {
		data: {
			"RIObatalkesM[ruangan_id]":ruangantujuan_id,
			"RIObatalkesM[therapiobat_id]":therapiobat_id,
		}
	});
});

function setThreapiobat_id(obatalkes_id){
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('setTherapiobatid'); ?>',
		data: {obatalkes_id : obatalkes_id},//
		dataType: "json",
		success:function(data){
			if(data){
				$("#therapiobat_id2").val(data);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function formjenisresep(jenisresep){
	$("#formjenisresep").addClass("animation-loading");
	setTimeout(function(){
		if(jenisresep==1){
			$("#form-nonracikan, #judul_non_racikan").hide();
			$("#form-racikan, #judul_racikan").show();
		}else{
			$("#form-nonracikan, #judul_non_racikan").show();
			$("#form-racikan, #judul_racikan").hide();
		}
		$("#formjenisresep").removeClass("animation-loading");
	},500);
}

function hitungJumlahObat(){
    // unformatNumberSemua();
	$("#qtyRacik").addClass("animation-loading-1");
	var jmlkemasanobat = $('#jmlKemasanObat').val();
	var permintaan = parseFloat(unformatNumber($('#permintaan').val()));
	var kekuatanobat = parseFloat(unformatNumber($('#kekuatanObat').val()));

    console.log(permintaan);
    console.log(permintaan, jmlkemasanobat, kekuatanobat);

	setTimeout(function(){
		if((jmlkemasanobat != '')&&(permintaan != '')&&(kekuatanobat != '')){
			var jmlobat = permintaan*jmlkemasanobat/kekuatanobat;
			$("#tomboltambahracikan").attr("disabled",false);
		}else{
			var jmlobat = 0;
			$("#tomboltambahracikan").attr("disabled",true);
		}

		$("#qtyRacik").val(formatFloat(jmlobat));
		$("#qtyRacik").removeClass("animation-loading-1");
	},500);

}

function hitungJumlahObatQty(){
    // unformatNumberSemua();
	$("#permintaan").addClass("animation-loading-1");
    var jmlkemasanobat = $('#jmlKemasanObat').val();
	// var permintaan = parseFloat(unformatNumber($('#permintaan').val()));
	var kekuatanobat = $('#kekuatanObat').val();
    var qtyRacik = parseFloat(unformatNumber($("#qtyRacik").val()));

    console.log(jmlkemasanobat);
    console.log(jmlkemasanobat, qtyRacik, kekuatanobat);

	setTimeout(function(){
		if((qtyRacik != '')&&(jmlkemasanobat != '')&&(kekuatanobat != '')){
			var permintaan = qtyRacik*kekuatanobat/jmlkemasanobat;
			$("#tomboltambahracikan").attr("disabled",false);
		}else{
			var permintaan = 0;
			$("#tomboltambahracikan").attr("disabled",true);
		}

		$("#permintaan").val(formatFloat(permintaan));
		$("#permintaan").removeClass("animation-loading-1");
	},500);

}

function racikanBaru(){
	$("#formanak").addClass("animation-loading-1");
	setTimeout(function(){
		$("#tombolracikanbaru").attr('disabled',true);
		$("#racikanKe").attr('disabled',false);
		$("#signaracikan").attr('disabled',false);
		$("#etiketracikan").attr('disabled',false);
		$("#jmlKemasanObat").attr('disabled',false);
		$("#satuansediaan").attr('disabled',false);
		$("#jmlKemasanObat").val('');
		$("#permintaan").val('');
		$("#kekuatanObat").val('');
		hitungJumlahObat();
		setDropDownRke();
		$("#formanak").removeClass("animation-loading-1");
	},500);
}

function setDropDownRke(){
	var rmax = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetDropdownRke'); ?>',
		data: {rmax : rmax++},//
		dataType: "json",
		success:function(data){
			$('#racikanKe').html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function addDataKeGridObat(obj,tipe,rke){
    if(tipe=='racik'){
        var obatalkes_id = $(obj).parents('#form-racikan').find('#obatalkes_id').val();
        var signa = $(obj).parents('#form-racikan').find('#signaracikan').val();
		var iterRacik = $('#iter').val();
        var permintaan = $(obj).parents('#form-racikan').find('#permintaan').val();
        var kemasan = $(obj).parents('#form-racikan').find('#jmlKemasanObat').val();
        var kekuatan = $(obj).parents('#form-racikan').find('#kekuatanObat').val();
//        var etiket = $(obj).parents('#form-racikan').find('#etiketracikan').val();
        var etiket = setEtiket($(obj).parents('#form-racikan').find('#etiketracikan1').val(), $(obj).parents('#form-racikan').find('#etiketracikan2').val(), $(obj).parents('#form-racikan').find('#etiketracikan3').val(), $(obj).parents('#form-racikan').find('#etiketracikan4').val());
        var satuansediaan = $(obj).parents('#form-racikan').find('#satuansediaan').val();
        var satuan_kekuatan = $(obj).parents('#form-racikan').find('#satuan_kekuatan_reseptur').val();
        var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_reseptur]"]');
        input_signa.val(signa);
        var input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_reseptur]"]');
        input_permintaan.val(permintaan);
        var input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jmlkemasan_reseptur]"]');
        input_kemasan.val(kemasan);
        var input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][kekuatan_reseptur]"]');
        input_kekuatan.val(kekuatan);
		var input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][iter]"]');
        input_iter.val(iterRacik);
		var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        input_etiket.val(etiket);
		var input_satuansediaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][satuansediaan]"]');
        input_satuansediaan.val(satuansediaan);
		var input_satuankekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][satuankekuatan]"]');
        input_satuankekuatan.val(satuan_kekuatan);

        var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);
    }else{
        var obatalkes_id = $(obj).parents('#form-nonracikan').find('#obatalkes_id').val();
        var signa = $(obj).parents('#form-nonracikan').find('#signa').val();
		var iterNonRacik = $('#iter').val();
//		var etiket = $(obj).parents('#form-nonracikan').find('#etiketnonracikan').val();
	var etiket = setEtiket($(obj).parents('#form-nonracikan').find('#etiketnonracikan1').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan2').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan3').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan4').val());
        var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_reseptur]"]');
        input_signa.val(signa);
		var input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][iter]"]');
        input_iter.val(iterNonRacik);
        var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        input_etiket.val(etiket);

        var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);

    }
}

function setEtiket(etiket_1,etiket_2,etiket_3,etiket_4){
    var etiket_final = "";
    var count = 0;

    if(etiket_1==" " || etiket_1==""){
    }else{
        count++;
        etiket_final += etiket_1;
    }
    if(etiket_2==" " || etiket_2==""){
    }else{
        if(count==1)
            etiket_final += " - ";
        count++;
        etiket_final += etiket_2;
    }
    if(etiket_3==" " || etiket_3==""){
    }else{
        if(count==2 || count==1)
            etiket_final += " - ";
        count++;
        etiket_final += etiket_3;
    }
    if(etiket_4==" " || etiket_4==""){
    }else{
        if(count==3 || count==2 || count==1)
            etiket_final += " - ";
        count++;
        etiket_final += etiket_4;
    }

    return etiket_final;
}

function renameInputRowObatAlkes(obj_table){
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
    obj_totalharganetto =  $('#<?php echo CHtml::activeId($modReseptur,"totharganetto") ?>');
    obj_totalhargajual =  $('#<?php echo CHtml::activeId($modReseptur,"totalhargajual") ?>');
    totalharganetto = 0;
    totalhargajual = 0;
    $('#table-obatalkespasien > tbody > tr').each(function(){
      var ppnpersen = parseFloat($(this).find('input[name*="[persenppnjual]"]').val());
      var hargasatuan = parseFloat($(this).find('input[name*="[hargasatuan_reseptur]"]').val());
      var qty = parseFloat($(this).find('input[name*="[qty_reseptur]"]').val());

      var jmlqty = (hargasatuan * qty);
      if (jmlqty > 0){
         jmlqty = parseFloat(jmlqty.toFixed(0));
     }

      var jmlppn = ((jmlqty * ppnpersen)/100);
      if (jmlppn > 0){
         jmlppn = parseFloat(jmlppn.toFixed(0));
     }

       var subtotal = jmlqty + jmlppn;
       $(this).find('input[name*="[jumlahppn]"]').val(jmlppn);
       $(this).find('input[name*="[hargajual_reseptur]"]').val(subtotal);

        totalharganetto += parseFloat( $(this).find('input[name*="[harganetto_oa]"]').val() * $(this).find('input[name*="[qty_oa]"]').val() );
        totalhargajual += subtotal;
    });

    obj_totalharganetto.val(totalharganetto);
    obj_totalhargajual.val(totalhargajual);
    $('#totalHargaReseptur').val(totalhargajual);

    formatNumberSemua();
}

function hitungtotalHargaReseptur(){
unformatNumberSemua();
	$("#totalHargaReseptur").addClass("animation-loading-1");
	var total = 0;
	$("#table-obatalkespasien > tbody > tr").each(function(){
		total =+ parseInt($(this).find('input[name$="[hargajual_reseptur]"]').val());
	});
	setTimeout(function(){
		$('#totalHargaReseptur').val(total);
		$("#totalHargaReseptur").removeClass("animation-loading-1");
		formatNumberSemua();
	},300);

}

function batalObatAlkesPasienDetail(obj){
    myConfirm("Apakah Anda akan membatalkan penjualan obat alkes ini?","Perhatian!",
    function(r){
        if(r){
            var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[obatalkes_id]"][value="'+obatalkes_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
            hitungTotal();
			// hitungtotalHargaReseptur();
        }
    });
}

$(document).ready(function(){
	formjenisresep(0); // load awal form non racikan yang dimunculkan
});

</script>
