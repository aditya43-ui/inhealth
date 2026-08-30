<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
/**
* set form kunjungan
* @param {type} pasien_id
* @returns {undefined}
*/
function setKunjungan(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id , penjualanresep_id){
	$("#form-datakunjungan > div").addClass("animation-loading");
	var instalasi_id = $("#instalasi_id").val();
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
		data: {instalasi_id:instalasi_id, pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id, penjualanresep_id:penjualanresep_id},
		dataType: "json",
		success:function(data){
			$("#cari_pendaftaran_id").val(data.pendaftaran_id);
			$("#pendaftaran_id").val(data.pendaftaran_id);
			$("#pasien_id").val(data.pasien_id);
			$("#pasienadmisi_id").val(data.pasienadmisi_id);
			$("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
			$("#carabayar_id").val(data.carabayar_id);
			$("#penjamin_id").val(data.penjamin_id);
			$("#penanggungjawab_id").val(data.penanggungjawab_id);
			$("#kelaspelayanan_id").val(data.kelaspelayanan_id);
			if(data.ruangan_id)
				$("#ruangan_id").val(data.ruangan_id);
			else
				$("#ruangan_id").val(data.ruanganakhir_id);
			$("#no_pendaftaran").val(data.no_pendaftaran);
			$("#tgl_pendaftaran").val(data.tgl_pendaftaran);
			$("#ruangan_nama").val(data.ruangan_nama);
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
			if(data.photopasien === null || data.photopasien === ""){ //set photo
				$('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
			}else{
				$('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
			}
			
			$("#<?php echo CHtml::activeId($model, 'penjualanresep_id') ?>").val(data.penjualanresep_id);

			setRincianObatalkes();

			$("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_pendaftaran);
			$("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
			$("#form-datakunjungan > .box").addClass("well").removeClass("box");

			$("#form-datakunjungan > div").removeClass("animation-loading");
			$("#<?php echo CHtml::activeId($model, 'alasanretur') ?>").focus();
			
		},
		error: function (jqXHR, textStatus, errorThrown) { 
			myAlert("Data kunjungan tidak ditemukan!"); 
			console.log(errorThrown);
			setKunjunganReset();
			$("#form-datakunjungan > div").removeClass("animation-loading");
			$("#instalasi_id").focus();
		}
	});

}
/**
 * untuk mereset form kunjungan
 * @returns {undefined} */
function setKunjunganReset(){
    $("#cari_pendaftaran_id").val("");
    $("#pendaftaran_id").val("");
    $("#pasien_id").val("");
    $("#pasienadmisi_id").val("");
    $("#jeniskasuspenyakit_id").val("");
    $("#carabayar_id").val("");
    $("#penjamin_id").val("");
    $("#penanggungjawab_id").val("");
    $("#kelaspelayanan_id").val("");
    $("#ruangan_id").val("");
    $("#no_pendaftaran").val("");
    $("#tgl_pendaftaran").val("");
    $("#ruangan_nama").val("");
    $("#jeniskasuspenyakit_nama").val("");
    $("#carabayar_nama").val("");
    $("#penjamin_nama").val("");
    $("#no_rekam_medik").val("");
    $("#namadepan").val("");
    $("#nama_pasien").val("");
    $("#nama_bin").val("");
    $("#tanggal_lahir").val("");
    $("#umur").val("");
    $("#jeniskelamin").val("");
    $("#nama_pj").val("");
    $("#pengantar").val("");
    $("#kelaspelayanan_nama").val("");
    $("#alamat_pasien").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well");
    
    setRincianObatalkes();
}
/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogKunjungan(){
    var instalasi_id = $("#instalasi_id").val();
    var instalasi_nama = $("#instalasi_id option:selected").text();
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
            "BKInformasikasirrawatjalanV[instalasi_id]":instalasi_id,
            "BKInformasikasirrawatjalanV[instalasi_nama]":instalasi_nama,
        }
    });
}
/**
 * set form rincian tagihan tindakan
 * @returns {undefined}
 */
function setRincianObatalkes(){
    var pendaftaran_id=$("#pendaftaran_id").val();
    var pasienadmisi_id=$("#pasienadmisi_id").val();
    var kelaspelayanan_id=$("#kelaspelayanan_id").val();
    var penjamin_id=$("#penjamin_id").val();
    var pasien_id=$("#pasien_id").val();
	var penjualanresep_id=$("#<?php echo CHtml::activeId($model, 'penjualanresep_id') ?>").val();
    $("#form-returresepdet").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetRincianObatalkes'); ?>',
        data: {pendaftaran_id:pendaftaran_id,pasienadmisi_id:pasienadmisi_id,kelaspelayanan_id:kelaspelayanan_id,penjamin_id:penjamin_id, pasien_id:pasien_id,penjualanresep_id:penjualanresep_id},//
        dataType: "json",
        success:function(data){
            $("#form-returresepdet").html(data.form);
            $("#form-returresepdet").removeClass("animation-loading");
            $("#form-returresepdet .integer2").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
            );
            $("#form-returresepdet .float2").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
            );
            $("#form-returresepdet .qty").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0}
            );
            $("#form-returresepdet").find('input:checkbox[name$="is_proporsioa"]').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
            hitungTotalOa();
        },
         error: function (jqXHR, textStatus, errorThrown) { $("#form-returresepdet").removeClass("animation-loading");console.log(errorThrown);}
    });
}
/**
 * set checked/unchecked semua pilihObat
 * @returns {undefined}
 */
function setPilihOaChecked(){
    if($("#is_pilihsemuaoa").is(':checked')){
        $("#form-returresepdet").find("input[name$='[pilihObat]'][type='checkbox']").each(function(){
            $(this).attr('checked',true);
        });
		$(".pilihperresep").attr('checked',true);
    }else{
        $("#form-returresepdet").find("input[name$='[pilihObat]'][type='checkbox']").each(function(){
            $(this).removeAttr('checked');
        });
		$(".pilihperresep").removeAttr('checked');
    }
    hitungTotalOa();
}
/**
 * set checked/unchecked semua pilihObat
 * @returns {undefined}
 */
function setPilihResepOaChecked(obj){
	var penjualan_id = $(obj).attr("penjualanresep_id");
    if($(obj).is(':checked')){
        $("#form-returresepdet").find("input[name$='[pilihObat]'][type='checkbox'][penjualanresep_id='"+penjualan_id+"']").each(function(){
            $(this).attr('checked',true);
        });
    }else{
        $("#form-returresepdet").find("input[name$='[pilihObat]'][type='checkbox'][penjualanresep_id='"+penjualan_id+"']").each(function(){
            $(this).removeAttr('checked');
        });
    }
    hitungTotalOa();
}

/**
 * menghitung total obat alkes
 * @returns {undefined}
 */
function hitungTotalOa(){
    unformatNumberSemua();
    var total_oa = 0;
    var total_retur = 0;
    var subtotal = 0;
    $("#form-returresepdet").find("input[name$='[pilihObat]'][type='checkbox']").each(function(){
        var qty_oa = parseFloat($(this).parents('tr').find("input[name$='[qty_oa]']").val());
        var qty_retur = parseFloat($(this).parents('tr').find("input[name$='[qty_retur]']").val());
        var hargasatuan = parseFloat($(this).parents('tr').find("input[name$='[hargasatuan]']").val());
        subtotal = (hargasatuan * qty_retur);
        total_oa += subtotal;
        if($(this).is(":checked")){
            $(this).parents('tr').find("input[name$='subtotal']").val(subtotal);
            total_retur += subtotal;
        }else{
            $(this).parents('tr').find("input[name$='subtotal']").val(0);
        }
    });
    $("#form-returresepdet #total_oa").val(total_oa);
    $("input[name*='[totalretur]']").val(total_retur);
    formatNumberSemua();
}

function cekQtyRetur(obj){
	var qty_oa = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[qty_oa]"]').val()));
	var qty_retur = parseFloat(unformatNumber($(obj).val()));
	if(qty_retur > qty_oa){
		$(obj).val(formatNumber(qty_oa));
		myAlert("Jumlah retur tidak boleh lebih besar dari jumlah penjualan!");
		$(obj).focus();
	}
}
/**
 * menampilkan form verifikasi
 * @returns {undefined}
 */
function setVerifikasi(){
    if(requiredCheck($("form"))){
        var pendaftaran_id=$("#pendaftaran_id").val();
        if(pendaftaran_id === ""){
            myAlert("Silakan cari data kunjungan terlabih dahulu!");
        }else{
            $('#dialog-verifikasi').dialog("open");
            $.ajax({
               type:'POST',
               url:'<?php echo $this->createUrl('verifikasi'); ?>',
               data: $("form").serialize(),
               dataType: "json",
               success:function(data){
                    $('#dialog-verifikasi > .dialog-content').html(data.content);
               },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
            });
            //untuk verifikasi hilangkan srbac loading
            $(".srbacLoading").removeClass("animation-loading");
            unformatNumberSemua();
        }
    }
    return false;
}
/**
 * tombol batal pada dialogbox
 * @param {type} dialog_id
 * @returns {undefined} 
 */
function batalDialog(dialog_id){
   myConfirm(' Apakah Anda yakin akan membatalkan ini ? ', 'Perhatian!', function(r){
        if(r){
            $('#'+dialog_id).dialog("close");
			formatNumberSemua();
        }
    });
}

/**
 * print rincian obat alkes belum bayar
 * @returns {undefined} */ 
function printRincian(){
	window.open("<?php echo $this->createUrl('returResepPasien/printRincian',array('returresep_id'=>$model->returresep_id)) ?>","",'location=_new, width=1024px');
}

$(document).ready(function(){
	<?php if(isset($_GET['sukses'])){ ?>
			$("input, select, textarea").attr("disabled",true);
	<?php } ?>

    <?php 
        if(isset($model->returresep_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_KEUANGAN ?>, judulnotifikasi:'Retur Resep', isinotifikasi:'Telah dilakukan retur resep pada <?php echo $model->tglretur ?>' }; 
        insert_notifikasi(params);
    <?php
        }
    ?>
});
</script>