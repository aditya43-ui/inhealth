<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pasienanastesi_id, pendaftaran_id, pasienmasukpenunjang_id
 * @returns {undefined}
 */
function setKunjungan(pasienanastesi_id,pendaftaran_id,pasienmasukpenunjang_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {
            pasienanastesi_id:pasienanastesi_id,
            pendaftaran_id:pendaftaran_id,
            pasienmasukpenunjang_id:pasienmasukpenunjang_id
        },
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
                $("#<?php echo CHtml::activeId($modKunjungan,'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);
                $("#<?php echo CHtml::activeId($modPraAnestesi,'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'pendaftaran_id'); ?>").val(data.pendaftaran_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'pasien_id'); ?>").val(data.pasien_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'pasienmasukpenunjang_id'); ?>").val(data.pasienmasukpenunjang_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'noanestesi'); ?>").val(data.noanestesi);
                $("#<?php echo CHtml::activeId($modKunjungan,'tglanastesi'); ?>").val(data.tglanastesi);
                $("#<?php echo CHtml::activeId($modKunjungan,'umur'); ?>").val(data.umur);
                $("#<?php echo CHtml::activeId($modKunjungan,'jeniskasuspenyakit_id'); ?>").val(data.jeniskasuspenyakit_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'jeniskasuspenyakit_nama'); ?>").val(data.jeniskasuspenyakit_nama);
                $("#<?php echo CHtml::activeId($modKunjungan,'pegawai_id'); ?>").val(data.nama_pegawai);
                $("#<?php echo CHtml::activeId($modKunjungan,'no_rekam_medik'); ?>").val(data.no_rekam_medik);
                $("#<?php echo CHtml::activeId($modKunjungan,'nama_pasien'); ?>").val(data.nama_pasien);
                $("#<?php echo CHtml::activeId($modKunjungan,'jeniskelamin'); ?>").val(data.jeniskelamin);
                $("#<?php echo CHtml::activeId($modKunjungan,'pekerjaan_id'); ?>").val(data.pekerjaan_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'pekerjaan_nama'); ?>").val(data.pekerjaan_nama);
                $("#<?php echo CHtml::activeId($modKunjungan,'kelaspelayanan_id'); ?>").val(data.kelaspelayanan_id);
                $("#<?php echo CHtml::activeId($modKunjungan,'kelaspelayanan_nama'); ?>").val(data.kelaspelayanan_nama);
                $("#<?php echo CHtml::activeId($modKunjungan,'alamat_pasien'); ?>").val(data.alamat_pasien);
				
                    
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_circuit'); ?>").val(data.ventilasi_circuit);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_spontan'); ?>").val(data.ventilasi_spontan);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_assisted'); ?>").val(data.ventilasi_assisted);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_cmv'); ?>").val(data.ventilasi_cmv);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_pcv'); ?>").val(data.ventilasi_pcv);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_tv'); ?>").val(data.ventilasi_tv);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_rate'); ?>").val(data.ventilasi_rate);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'ventilasi_peep'); ?>").val(data.ventilasi_peep);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_n2o_keterangan'); ?>").val(data.gasflow_n2o_keterangan);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_o2_keterangan'); ?>").val(data.gasflow_o2_keterangan);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_air_keterangan'); ?>").val(data.gasflow_air_keterangan);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_n2o'); ?>").val(data.gasflow_n2o);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_o2'); ?>").val(data.gasflow_o2);
                $("#<?php echo CHtml::activeId($modIntraAnestesi, 'gasflow_air'); ?>").val(data.gasflow_air);

                $("#<?php echo CHtml::activeId($modObatAnestesi, 's_dan_i'); ?>").val(data.s_dan_i);
                $("#<?php echo CHtml::activeId($modObatAnestesi, 'urin'); ?>").val(data.urin);
                $("#<?php echo CHtml::activeId($modObatAnestesi, 'darah'); ?>").val(data.darah);
                $("#<?php echo CHtml::activeId($modObatAnestesi, 'ebl'); ?>").val(data.ebl);
                
                if(data.photopasien === null || data.photopasien === "" || data.photopasien === undefined){ //set photo
                    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                }else{
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }
                if(data.noanestesi == '' || data.noanestesi == null){
                        var noanestesi = data.no_masukpenunjang;
                }else{
                        var noanestesi = data.noanestesi;
                }
                loadDataPraAnestesi(data.pasienanastesi_id);							
                $("#form-datakunjungan > legend > .judul").html('Data Pasien '+noanestesi);
                $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
                $("#form-datakunjungan > .box").addClass("well").removeClass("box");				
            }
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#<?php echo CHtml::activeId($modKunjungan,'noanestesi'); ?>").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan !"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#<?php echo CHtml::activeId($modKunjungan,'noanestesi'); ?>").focus();
        }
    });

}

//
///**
// * untuk mereset form kunjungan
// * @returns {undefined} */
//function setKunjunganReset(){
//    $("#form-datakunjungan input,textarea").each(function(){
//        $(this).val("");
//    });
//    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
//    $("#form-datakunjungan > legend > .judul").html('Data Pasien');
//    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
//    $("#form-datakunjungan > .well").addClass("box").removeClass("well");
//}
//
///*
// * load data
// * @returns {undefined}
// */
//function loadDataPraAnestesi(pasienanastesi_id){
//	$("#form-datarencana > div").addClass("animation-loading");
//    $.ajax({
//        type:'POST',
//        url:'<?php echo $this->createUrl('GetDataPraAnestesi'); ?>',
//        data: {pasienanastesi_id:pasienanastesi_id},
//        dataType: "json",
//        success:function(data){
//            if(data.pesan != ""){
//                myAlert(data.pesan);
//                setKunjunganReset();
//            }else{
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'pasienanastesi_id'); ?>").val(data.pasienanastesi_id);
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'praanestesi_id'); ?>").val(data.praanestesi_id);
//                $("#<?php echo CHtml::activeId($modIntraAnestesi,'praanestesi_id'); ?>").val(data.praanestesi_id);
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'tglpraanestesi'); ?>").val(data.tglpraanestesi);
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'dokter_id'); ?>").val(data.dokter_id);
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'perawat1_id'); ?>").val(data.perawat1_id);
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'perawat2_id'); ?>").val(data.perawat2_id);
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'ruangan_id'); ?>").val(data.ruangan_id);
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'kamarruangan_id'); ?>").val(data.kamarruangan_id);
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'tekniksedasi'); ?>").val(data.tekniksedasi);
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'tglpuasa'); ?>").val(data.tglpuasa);
//                $("#<?php echo CHtml::activeId($model,'typeanastesi_id'); ?>").val(data.typeanastesi_id);			
//                $("#<?php echo CHtml::activeId($modPraAnestesi,'ketpraanestesi'); ?>").val(data.ketpraanestesi);	
//				if(data.monitoring != null){
//				$("#<?php echo CHtml::activeId($modPraAnestesi,'monitoring'); ?>").val(data.monitoring.split(","));
//				}
//				SetRuanganPasien(data.ruangan_id, data.kamarruangan_id);
//				loadDataTindakanAnestesi(data.praanestesi_id);
//				loadDataPemakaianBahan(data.praanestesi_id);
//				loadDataPemakaianBmhp(data.praanestesi_id);
//				loadDataAlatMedis(data.praanestesi_id);	
//            }
//            $("#form-datarencana > div").removeClass("animation-loading");
//        },
//        error: function (jqXHR, textStatus, errorThrown) { 
//            myAlert("Data Pra Anestesi tidak ditemukan !"); 
//            console.log(errorThrown);
//            $("#form-datarencana > div").removeClass("animation-loading");
//        }
//    });
//}
//
///**
//* set ruangan, kamar ruangan
//* @param {type} ruangan_id
//* @param {type} kamarruangan_id
//* @returns {undefined}
//*/
//function SetRuanganPasien(ruangan_id, kamarruangan_id) {
//   $.ajax({
//	   type: 'POST',
//	   url: '<?php echo $this->createUrl('SetDropDownKamarRuangan'); ?>',
//	   data: {ruangan_id:ruangan_id, kamarruangan_id:kamarruangan_id},
//	   dataType: "json",
//	   success: function (data) {
//		   $("#<?php echo CHtml::activeId($modPraAnestesi, "ruangan_id"); ?>").html(data.listRuangan);
//		   $("#<?php echo CHtml::activeId($modPraAnestesi, "kamarruangan_id"); ?>").html(data.listKamarruangan);
//	   },
//	   error: function (jqXHR, textStatus, errorThrown) {
//		   console.log(errorThrown);
//	   }
//   });
//}
//	
//function loadDataTindakanAnestesi(praanestesi_id){
//	$("#table-tindakan > div").addClass("animation-loading");
//	var form_index = $('#form_index').val();
//    $.ajax({
//        type:'POST',
//        url:'<?php echo $this->createUrl('SetDataTindakanAnestesi'); ?>',
//        data: {praanestesi_id:praanestesi_id},
//        dataType: "json",
//        success:function(data){
//            if(data.pesan != ""){
//                myAlert(data.pesan);
//            }else{
//                $('#table-tindakan > tbody').html(data.form);
//				$("#table-tindakan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
//					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
//				);
//				renameInputRow($("#table-tindakan")); 
//				tambahTindakanPemakaianBahan($("#table-tindakan"));
//				setCheckedPemeriksaan($("#table-tindakan"),$('#dialog-pilihpemeriksaan .dialog-content'));
//            }
//            $("#table-tindakan > div").removeClass("animation-loading");
//        },
//        error: function (jqXHR, textStatus, errorThrown) { 
//            myAlert("Data Tindakan Anestesi tidak ditemukan !"); 
//            console.log(errorThrown);
//            $("#form-tindakan > div").removeClass("animation-loading");
//        }
//    });
//}
//
//function tambahTindakanPemakaianBahan(obj_table)
//{
//	$(obj_table).find("tbody > tr").each(function(){
//		var anastesi_id = $(this).find('input[name$="[anastesi_id]"]').val();
//		var anastesi_nama = $(this).find('span[name$="[anastesi_nama]"]').text();
//		$('#daftartindakanPemakaianBahan').append('<option value="'+anastesi_id+'">'+anastesi_nama+'</option>');
//	});
//}
//
//function loadDataPemakaianBahan(praanestesi_id){
//	$("#table-pemakaian-bahan > div").addClass("animation-loading");
//    $.ajax({
//        type:'POST',
//        url:'<?php echo $this->createUrl('SetDataPemakaianBahan'); ?>',
//        data: {praanestesi_id:praanestesi_id},
//        dataType: "json",
//        success:function(data){
//            if(data.pesan != ""){
//                myAlert(data.pesan);
//            }else{
//				$('#table-pemakaian-bahan > tbody').html(data.form);
//				$("#table-pemakaian-bahan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
//					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
//				);
//				renameInputRow($("#table-pemakaian-bahan"));
//            }
//            $("#table-pemakaian-bahan > div").removeClass("animation-loading");
//        },
//        error: function (jqXHR, textStatus, errorThrown) { 
//            myAlert("Data Pemakaian Bahan tidak ditemukan !"); 
//            console.log(errorThrown);
//            $("#table-pemakaian-bahan > div").removeClass("animation-loading");
//        }
//    });
//}
//
//function loadDataPemakaianBmhp(praanestesi_id){
//	$("#table-pemakaian-bmhp > div").addClass("animation-loading");
//    $.ajax({
//        type:'POST',
//        url:'<?php echo $this->createUrl('SetDataPemakaianBmhp'); ?>',
//        data: {praanestesi_id:praanestesi_id},
//        dataType: "json",
//        success:function(data){
//            if(data.pesan != ""){
//                myAlert(data.pesan);
//            }else{
//				$('#table-pemakaian-bmhp > tbody').html(data.form);
//				$("#table-pemakaian-bmhp").find('input[name*="[ii]"][class*="integer"]').maskMoney(
//					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
//				);
//				renameInputRow($("#table-pemakaian-bmhp"));
//            }
//            $("#table-pemakaian-bmhp > div").removeClass("animation-loading");
//        },
//        error: function (jqXHR, textStatus, errorThrown) { 
//            myAlert("Data Pemakaian Bmhp tidak ditemukan !"); 
//            console.log(errorThrown);
//            $("#table-pemakaian-bmhp > div").removeClass("animation-loading");
//        }
//    });
//}
//
//function loadDataAlatMedis(praanestesi_id){
//	$("#table-pemakaian-alatmedis > div").addClass("animation-loading");
//    $.ajax({
//        type:'POST',
//        url:'<?php echo $this->createUrl('SetDataAlatMedis'); ?>',
//        data: {praanestesi_id:praanestesi_id},
//        dataType: "json",
//        success:function(data){
//            if(data.pesan != ""){
//                myAlert(data.pesan);
//            }else{
//				$('#table-pemakaian-alatmedis > tbody').html(data.form);
//				$("#table-pemakaian-alatmedis").find('input[name*="[ii]"][class*="integer"]').maskMoney(
//					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
//				);
//				renameInputRow($("#table-pemakaian-alatmedis"));
//            }
//            $("#table-pemakaian-alatmedis > div").removeClass("animation-loading");
//        },
//        error: function (jqXHR, textStatus, errorThrown) { 
//            myAlert("Data Pemakaian Alat Medis tidak ditemukan !"); 
//            console.log(errorThrown);
//            $("#table-pemakaian-alatmedis > div").removeClass("animation-loading");
//        }
//    });
//}
//
//
///**
//* Set checklist pemeriksaan anestesi
//* obj = div yang berisi elemen
//*/
//function setChecklistPemeriksaanAnestesi(obj) {
//	var pasienanastesi_id = $('#<?php echo CHtml::activeId($modPraAnestesi,'pasienanastesi_id'); ?>').val();	
//	var ruangan_id = $('#<?php echo CHtml::activeId($modPraAnestesi,'pasienanastesi_id'); ?>').val();	
//	if (pasienanastesi_id == "") {
//		myAlert("Silahkan pilih Pasien Anestesi!");
//	}else{
//		 $.ajax({
//			type: 'POST',
//			url: '<?php echo $this->createUrl('getDataPasien'); ?>',
//			data: {pasienanastesi_id:pasienanastesi_id},
//			dataType: "json",
//			success: function (data) {
//				$("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
//				$("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(data.kelaspelayanan_id);
//				$("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(data.penjamin_id);
//				updateChecklistPemeriksaanAnestesi();
//				$('#dialog-pilihpemeriksaan').dialog('open');
//			},
//			error: function (jqXHR, textStatus, errorThrown) {
//				console.log(errorThrown);
//			}
//		});		
//	}
//}
///**
//* reset pencarian & checklist pemeriksaan anestesi
//*/
//function setChecklistPemeriksaanAnestesiReset() {
//   $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function () {
//	   $(this).val("");
//   });
//   updateChecklistPemeriksaanAnestesi();
//}
///**
//* update (refresh) checklist pemeriksaan anestesi
//* harus include /js/jquery.tiler.js
//* @param {obj} form_checklist
//*/
//function updateChecklistPemeriksaanAnestesi() {
//   $('#dialog-pilihpemeriksaan .dialog-content').addClass("animation-loading");
//   var form_index = $('#form_index').val();
//   $.ajax({
//	   type: 'POST',
//	   url: '<?php echo $this->createUrl('SetChecklistPemeriksaanAnestesi'); ?>',
//	   data: {data: $("#form-caripemeriksaan :input").serialize()},
//	   dataType: "json",
//	   success: function (data) {
//		   $('#dialog-pilihpemeriksaan .dialog-content').html(data.content);
//		   $('.checkboxlist-tile').tile({widths: [256]});
//		   $('#dialog-pilihpemeriksaan .dialog-content').removeClass("animation-loading");
//		   setCheckedPemeriksaan($("#table-tindakan"),$('#dialog-pilihpemeriksaan .dialog-content'));
//	   },
//	   error: function (jqXHR, textStatus, errorThrown) {
//		   console.log(errorThrown);
//	   }
//   });
//}
//
///**
// * Centang pemeriksaan anestesi dari checkboxlist
// * di copy dari radiologi/pendaftaranRadiologiRujukanRS
// */
//function pilihPemeriksaanIni(obj){
//	unformatNumberSemua();
//    var anastesi_id = $(obj).val();
//    var anastesi_nama = $(obj).parent().find('input[name$="[anastesi_nama]"]').val();
//    var jenisanastesi_nama = $(obj).parent().find('input[name$="[jenisanastesi_nama]"]').val();
//    var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
//    var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
//    var hargaanestesi = $(obj).parent().find('input[name$="[hargaanestesi]"]').val();
//    var rowtindakan = [];
//    rowtindakan = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPemeriksaan',array('i'=>0,'modTindakanAnestesi'=>$modTindakanAnestesi),true));?>';
//    if($(obj).is(':checked')){
//        $("#table-tindakan").find('tbody').append(rowtindakan);
//        $("#table-tindakan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
//        $("#table-tindakan").find('input[name$="[ii][anastesi_id]"]').val(anastesi_id);
//        $("#table-tindakan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
//        $("#table-tindakan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
//		$("#table-tindakan").find('span[name$="[ii][jenisanastesi_nama]"]').html(jenisanastesi_nama);
//		$("#table-tindakan").find('span[name$="[ii][anastesi_nama]"]').html(anastesi_nama);
//        $("#table-tindakan").find('input[name$="[ii][qty_tindakan]"]').val(1);
//        $("#table-tindakan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
//        $("#table-tindakan").find('input[name$="[ii][tarif_satuan]"]').val(hargaanestesi);
//        $("#table-tindakan").find('input[name$="[ii][tarif_tindakan]"]').val(hargaanestesi);
//        $("#table-tindakan").find('a').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
//		tambahTindakanPemakaianBahan(anastesi_id, anastesi_nama);
//    }else{
//        var delete_row = $("#table-tindakan").find('input[name$="[anastesi_id]"][value="'+anastesi_id+'"]').parents('tr');
//        delete_row.detach();
//    }
//    renameInputRow($("#table-tindakan"));
//	formatNumberSemua();
//}
//
///**
// * set checked pemeriksaan yang sudah ada di daftar
// */
// function setCheckedPemeriksaan(obj_table,obj_dialog){
//    var form_index = $('#form_index').val();
//    $(obj_table).find('input[name$="[anastesi_id]"]').each(function(){
//        var anastesi_id = $(this).val();
//        $(obj_dialog).find('input[name$="[is_pilih]"][value='+anastesi_id+']').attr('checked',true);
//    });
//    
//}
///**
//* load pemeriksaan anamnesa yang sudah tersimpan berdasarkan:
//* - pasienmasukpenunjang_id
//*/ 
//function setRiwayatAnamnesa(){
//	var pasienanastesi_id = $('#<?php echo CHtml::activeId($modPraAnestesi,'pasienanastesi_id'); ?>').val();	
//    $('#riwayat-anamnesa').addClass("animation-loading");
//    $.ajax({
//        type:'POST',
//        url:'<?php echo $this->createUrl('setRiwayatAnamnesa'); ?>',
//        data: {pasienanastesi_id:pasienanastesi_id},
//        dataType: "json",
//        success:function(data){
//            $('#riwayat-anamnesa .content').html(data.rows);
//            $('#riwayat-anamnesa').removeClass("animation-loading");
//        },
//        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//    });
//}
//
///**
//* load pemeriksaan anamnesa yang sudah tersimpan berdasarkan:
//* - pasienmasukpenunjang_id
//*/ 
//function setRiwayatPemeriksaanFisik(){
//	var pasienanastesi_id = $('#<?php echo CHtml::activeId($modPraAnestesi,'pasienanastesi_id'); ?>').val();	
//    $('#riwayat-pemeriksaan-fisik').addClass("animation-loading");
//    $.ajax({
//        type:'POST',
//        url:'<?php echo $this->createUrl('setRiwayatPemeriksaanFisik'); ?>',
//        data: {pasienanastesi_id:pasienanastesi_id},
//        dataType: "json",
//        success:function(data){
//            $('#riwayat-pemeriksaan-fisik .content').html(data.rows);
//            $('#riwayat-pemeriksaan-fisik').removeClass("animation-loading");
//        },
//        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//    });
//}
//
///**
//* load pemeriksaan penunjang yang sudah tersimpan berdasarkan:
//* - pasienmasukpenunjang_id
//*/ 
//function setRiwayatPemeriksaanPenunjang(){
//	var pasienanastesi_id = $('#<?php echo CHtml::activeId($modPraAnestesi,'pasienanastesi_id'); ?>').val();
//    $('#riwayat-pemeriksaan-penunjang').addClass("animation-loading");
//    $.ajax({
//        type:'POST',
//        url:'<?php echo $this->createUrl('setRiwayatPemeriksaanPenunjang'); ?>',
//        data: {pasienanastesi_id:pasienanastesi_id},
//        dataType: "json",
//        success:function(data){
//            $('#riwayat-pemeriksaan-penunjang .content').html(data.rows);
//            $('#riwayat-pemeriksaan-penunjang').removeClass("animation-loading");
//        },
//        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//    });
//}	
//
//function tambahObatAlkesPasien(obj)
//{
//	unformatNumberSemua();
//	var pasienanastesi_id = $('#<?php echo CHtml::activeId($modPraAnestesi,'pasienanastesi_id'); ?>').val();
//	var penjamin_id = $("#penjamin_id").val();
//	var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
//	var obatalkes_kode = $(obj).parents('fieldset').find('#obatalkes_kode').val();
//	var obatalkes_nama = $(obj).parents('fieldset').find('#obatalkes_nama').val();
////		var jumlah = $(obj).parents('fieldset').find('#qty_input').val(); //RND-11723
//	var jumlah = $(obj).parents('fieldset').find('#jmlkonversi').val();
//
//	if ((obatalkes_id != '') && (pasienanastesi_id != '') && (jumlah > 0)) {
//		$.ajax({
//			type: 'POST',
//			url: '<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
//			data: {obatalkes_id: obatalkes_id, jumlah: jumlah, pasienanastesi_id:pasienanastesi_id}, //
//			dataType: "json",
//			success: function (data) {
//				if (data.pesan !== "") {
//					myAlert(data.pesan);
//					var params = [];
//					params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi: 'Stok Obat Alkes Habis', isinotifikasi: obatalkes_kode + ' ' + obatalkes_nama + '  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
//					simpanNotifikasi(params);
//					return false;
//				}
//				var tambahkandetail = false;
//				var obatalkesyangsama = $("#table-pemakaian-bahan input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
//				if (obatalkesyangsama.val()) { //jika ada obat sudah ada di table
//					myConfirm('Apakah anda akan input ulang obat ini?', 'Perhatian!', function (r)
//					{
//						if (r) {
//							$("#table-pemakaian-bahan input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function () {
//								$(this).parents('tr').detach();
//							});
//						}
//						else {
//							tambahkandetail = false;
//						}
//					});
//				}else{
//					tambahkandetail = true;
//				}
//				
//				if (tambahkandetail) {
//					$('#table-pemakaian-bahan > tbody').append(data.form);
//					$("#table-pemakaian-bahan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
//							{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
//					);
//					renameInputRow($("#table-pemakaian-bahan"));
//				}
//				$(obj).parents('fieldset').find('#obatalkes_id').val('');
//				$('#obatalkes_nama').val('');
//				$('#qty_input').val(1);
//				formatNumberSemua();
//				renameInputRow($("#table-pemakaian-bahan"));
//			},
//			error: function (jqXHR, textStatus, errorThrown) {
//				console.log(errorThrown);
//			}
//		});
//	} else {
//		if (pasienanastesi_id == '') {
//			myAlert("Silahkan isi data kunjungan terlebih dahulu !");
//		} else if (obatalkes_id == '') {
//			myAlert("Silahkan pilih obat alkes terlebih dahulu !");
//		} else if (jumlah == 0) {
//			myAlert("Stok obat kosong !");
//		}
//	}
//	setObatAlkesPasienReset();
//}
//
//function setObatAlkesPasienReset() {
//	$('#form-tambahobatalkes :input').val("");
//	$('#qty_input').val("1");
//	$('#jmlkemasan').val("1");
//	$('#jmlkonversi').val("1");
//	$('#obatalkes_nama').focus();
//}
//
//function batalOaPasien(obj)
//{
//	myConfirm('Apakah anda akan membatalkan obat / alat kesehatan ini?', 'Perhatian!', function (r)
//	{
//		if (r) {
//			$(obj).parents('tr').remove();
//			renameInputRow($("#table-pemakaian-bahan"));
//		}
//	});
//}
//
//function hitungSubTotal(obj)
//{
//	unformatNumberSemua();
//	var subtotal = 0;
//	var qty = parseInt($(obj).val());
//	var qty_stok = parseInt($(obj).parents('tr').find('input[name$="[qty_oa]"]').val());
//	var hargajual_oa = parseInt($(obj).parents('tr').find('input[name$="[hargajual_oa]"]').val());
//	subtotal = qty * hargajual_oa;
//	$(obj).parents('tr').find('input[name$="[iurbiaya]"]').val(formatInteger(subtotal));
//	if (qty > qty_stok) {
//		$(obj).val(qty_stok);
//		myAlert("Jumlah tidak boleh lebih besar dari stok!");
//	}
//	formatNumberSemua();
//}
//
//// untuk menjumlahkan konversi dari qty input / jmlkemasan terkecil
//function totalKonversi(){
//	unformatNumberSemua();
//	var qty_input = parseFloat($('#qty_input').val());
//	var jmlkemasan = parseFloat($('#jmlkemasan').val());
//	var jmlkonversi = parseFloat($('#jmlkonversi').val());
//
//	var jml = qty_input / jmlkemasan;
//	if(!jQuery.isNumeric(jml)){
//		jml = 0;
//	}
//	$('#jmlkonversi').val(jml);
//}
//
//function totalJumlah(){
//	unformatNumberSemua();
//	var qty_input = parseFloat($('#qty_input').val());
//	var jmlkemasan = parseFloat($('#jmlkemasan').val());
//	var jmlkonversi = parseFloat($('#jmlkonversi').val());
//
//	var jumlah = jmlkonversi * jmlkemasan;
//	if(!jQuery.isNumeric(jumlah)){
//		jumlah = 0;
//	}
//	$('#qty_input').val(jumlah);
//}
//
//function setSatuanObat(obatalkes_id){
//	$.ajax({
//		type:'POST',
//		url:'<?php echo $this->createUrl('setSatuanObat'); ?>',
//		data: {obatalkes_id:obatalkes_id},
//		dataType: "json",
//		success:function(data){
//			if(data.pesan != ""){
//				myAlert(data.pesan);
//			}else{
//				$('#satuankecil_nama').html(data.satuankecil);
//				$('#satuanterkecil_nama').html(data.satuanterkecil);
//			}
//		},
//		error: function (jqXHR, textStatus, errorThrown) { 
//			myAlert("Data Obat tidak ditemukan !"); 
//			console.log(errorThrown);
//		}
//	});
//}
//	
///**
//* javascript untuk alat medis
//*/
//function inputAlatMedis(alatmedis_id)
//{
//    var anastesi_id = $('#daftartindakanPemakaianBahan option:selected').val();
//    if(anastesi_id == ''){
//        myAlert('Belum ada Tindakan Anestesi');
//        return false;
//    }
//    
//    jQuery.ajax({'url':'<?php echo $this->createUrl('setFormPemakaianAlat')?>',
//		'data':{alatmedis_id:alatmedis_id, anastesi_id:anastesi_id},
//		'type':'post',
//		'dataType':'json',
//		'success':function(data) {
//			if(!sudahAdaAlat(alatmedis_id)){
//				$('#table-pemakaian-alatmedis #trPemakaianBahan').detach();
//				$('#table-pemakaian-alatmedis > tbody').append(data.form);
//				renameInputRow($("#table-pemakaian-alatmedis")); 
//			}
//			$("#table-pemakaian-alatmedis > tbody tr:last .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
//			$('.integer').each(function(){this.value = formatNumber(this.value)});
//		} ,
//	'cache':false});
//}
//function sudahAdaAlat(alatmedis_id)
//{
//	var ada;
//	$('#table-pemakaian-alatmedis').find('input[name$="[alatmedis_id]"]').each(function(){
//		var cek = true;
//		if(this.value!=alatmedis_id){
//			ada = cek && ada;
//		} else {
//			myAlert('Sudah ada!');
//			ada = cek && true;
//		}
//	});
//
//	return ada;
//}
// 
//function hapusAlatMedis(obj){
//    myConfirm("Apakan anda ingin menghapus ini ?","Perhatian!",function(r) {
//        if(r){
//            $(obj).parent().parent().remove();
//            renameInputRow($("#table-pemakaian-alatmedis"));
//        }
//    });
//    return false;
//}
//
///**
//* javascript untuk pemakaian BMHP
//* */
//function inputBMHP(daftartindakan_id,kelumur_id)
//{
//	var pasienanastesi_id = $('#<?php echo CHtml::activeId($modPraAnestesi,'pasienanastesi_id'); ?>').val();	
//    var ketemu = false;
//	var anastesi_id = $('#daftartindakanPemakaianBahan option:selected').val();
//    if(anastesi_id == ''){
//        myAlert('Belum ada Tindakan Anastesis');
//        return false;
//    }
//    $('#table-tindakan').find('input[name$="[daftartindakan_id]"]').each(function(){
//	ketemu = true;
//	jQuery.ajax({'url':'<?php echo $this->createUrl('setFormPemakaianBmhp')?>',
//		'data':{daftartindakan_id:daftartindakan_id,pasienanastesi_id:pasienanastesi_id,anastesi_id:anastesi_id},
//		'type':'post',
//		'dataType':'json',
//		'success':function(data) {
//			if(data.pesan !== ""){
//				myAlert(data.pesan);
//				return false;
//			}
//			$('#table-pemakaian-bmhp > tbody').append(data.form);
//			$("#table-pemakaian-bmhp").find('input[name*="[ii]"][class*="integer"]').maskMoney(
//				{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
//			);
//			renameInputRowPemakaianBahan($("#table-pemakaian-bmhp"));  
//			$('#obatalkes_id').val('');
//			$('#paketBMHP').val('');
//			formatNumberSemua();
//			renameInputRowPemakaianBahan($("#table-pemakaian-bmhp")); 
//			hitungTotalBMHP();
//		} ,
//		'cache':false});
//    });
//    if(!ketemu) {
//        myAlert('Tidak ada tindakan yang dimaksud.');
//    }
//}
//    
//function hitungTotalBMHP()
//{ 
//    var total = 0;
//    $('#table-pemakaian-bmhp').find('input[name$="[hargapemakaian]"]').each(function(){
//        total = total + unformatNumber(this.value);
//    });
//    $('#totHargaBmhp').val(formatNumber(total));
//}
//
///**
//* rename input grid
//*/ 
//function renameInputRowPemakaianBahan(obj_table){
//	var row = 0;
//	$(obj_table).find("tbody > tr").each(function(){
//		$(this).find("#no_urut").val(row+1);
//		$(this).find('span').each(function(){ //element <input>
//			var old_name = $(this).attr("name").replace(/]/g,"");
//			var old_name_arr = old_name.split("[");
//			if(old_name_arr.length == 3){
//				$(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
//			}
//		});
//		$(this).find('input,select,textarea').each(function(){ //element <input>
//			var old_name = $(this).attr("name").replace(/]/g,"");
//			var old_name_arr = old_name.split("[");
//			if(old_name_arr.length == 3){
//				$(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
//				$(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
//			}
//		});
//		row++;
//	});
//}
//
//function hapusBMHP(obj){
//    myConfirm("Apakan anda ingin menghapus ini ?","Perhatian!",function(r) {
//        if(r){
//            $(obj).parent().parent().remove();
//            renameInputRowPemakaianBahan();
//            hitungTotalBMHP();
//        }
//    });
//    return false;
//}
//
///**
// * javascript untuk tambah dan hapus baris pemantauan kondisi pasien
// */
//// the subviews rendered with placeholders
//var trTindakan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowPemantauanKondisi',array('modKondisiPasienAnestesi'=>$modKondisiPasienAnestesi,'removeButton'=>true),true));?>);
//var trTindakanFirst = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowPemantauanKondisi',array('modKondisiPasienAnestesi'=>$modKondisiPasienAnestesi,'removeButton'=>false),true));?>);
//
//function addRowPemantauan(obj)
//{
//    $(obj).parents('table').children('tbody').append(trTindakan.replace());
//	renameInputRowPemantauan($("#table-pemantauan-kondisi-pasien"));
//    $('#table-pemantauan-kondisi-pasien tbody').each(function(){
//        jQuery('input[name$="[tglpemantauan]"]').datepicker(
//            jQuery.extend(
//                {
//                    showMonthAfterYear:false
//                }, 
//                jQuery.datepicker.regional['id'],
//                {
//                    'dateFormat':'dd M yy',
//                    'showSecond':false,
//                    'timeOnlyTitle':'Pilih Waktu',
//                    'timeFormat':'hh:mm:ss',
//                    'changeYear':true,
//                    'changeMonth':true,
//                    'showAnim':'fold',
//                    'yearRange':'-80y:+20y',
//                }
//            )
//        );
//
//		jQuery('input[name$="[jammulai]"]').timepicker(
//            jQuery.extend(
//                {
//                    showMonthAfterYear:false
//                }, 
//                jQuery.datepicker.regional['id'],
//                {
//                    'dateFormat':'dd M yy',
//                    'timeText':'Waktu',
//                    'hourText':'Jam',
//                    'minuteText':'Menit',
//                    'secondText':'Detik',
//                    'showSecond':true,
//                    'timeOnlyTitle':'Pilih Waktu',
//                    'timeFormat':'hh:mm:ss',
//                    'changeYear':true,
//                    'changeMonth':true,
//                    'showAnim':'fold',
//                    'yearRange':'-80y:+20y'
//                }
//            )
//        );
//
//		jQuery('input[name$="[jamselesai]"]').timepicker(
//            jQuery.extend(
//                {
//                    showMonthAfterYear:false
//                }, 
//                jQuery.datepicker.regional['id'],
//                {
//                    'dateFormat':'dd M yy',
//                    'timeText':'Waktu',
//                    'hourText':'Jam',
//                    'minuteText':'Menit',
//                    'secondText':'Detik',
//                    'showSecond':true,
//                    'timeOnlyTitle':'Pilih Waktu',
//                    'timeFormat':'hh:mm:ss',
//                    'changeYear':true,
//                    'changeMonth':true,
//                    'showAnim':'fold',
//                    'yearRange':'-80y:+20y'
//                }
//            )
//        );
//    });  
//}
//
//function batalPemantauan(obj)
//{
//    myConfirm("Apakah anda yakin akan membatalkan pemantauan kondisi ini?","Perhatian!",function(r) {
//        if(r){
//            $(obj).parents('tr').next('tr').detach();
//            $(obj).parents('tr').detach();
//			renameInputRowPemantauan($("#table-pemantauan-kondisi-pasien"));
//        }
//    });
//}
//
///**
// * rename input row yang terakhir di tambahkan
// * @param {type} obj_table
// */
//function renameInputRow(obj_table){
//    var row = 0;
//    $(obj_table).find("tbody > tr").each(function(){
//        $(this).find("#no_urut").val(row+1);
//        $(this).find('span').each(function(){ //element <span>
//            var old_name = $(this).attr("name").replace(/]/g,"");
//            var old_name_arr = old_name.split("[");
//            if(old_name_arr.length == 3){
//                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
//            }
//        });
//		$(this).find('input,select,textarea').each(function(){ //element <input>
//            var old_name = $(this).attr("name").replace(/]/g,"");
//            var old_name_arr = old_name.split("[");
//            if(old_name_arr.length == 3){
//                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
//                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
//            }
//        });
//        $(this).find('input,select,textarea').each(function(){ //element <input>
//            var old_name = $(this).attr("name").replace(/]/g,"");
//            var old_name_arr = old_name.split("[");
//            if(old_name_arr.length == 4){
//                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
//                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
//            }
//        });
//        row++;
//    });
//    
//}
//
//function renameInputRowPemantauan(obj_table){
//    var row = 0;
//    var mntke = 1;
//    $(obj_table).find("tbody > tr").each(function(){
//        $(this).find("#no_urut").val(row+1);
//        $(this).find('input[name$="[menitke]"]').val(mntke * 5);
//		$(this).find('input,select,textarea').each(function(){ //element <input>
//            var old_name = $(this).attr("name").replace(/]/g,"");
//            var old_name_arr = old_name.split("[");
//            if(old_name_arr.length == 3){
//                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
//                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
//            }
//        });
//        $(this).find('input,select,textarea').each(function(){ //element <input>
//            var old_name = $(this).attr("name").replace(/]/g,"");
//            var old_name_arr = old_name.split("[");
//            if(old_name_arr.length == 4){
//                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
//                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
//            }
//        });
//        row++;
//        mntke++;
//    });
//}
//
///**
//* untuk print intra anestesia
// */
//function printHasil(caraPrint)
//{
//    var intraanestesi_id = '<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>';
//    window.open('<?php echo $this->createUrl('printHasil'); ?>&intraanestesi_id='+intraanestesi_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
//}
///**
// * javascript yang di running setelah halaman ready / load sempurna
// * posisi script ini harus tetap dibawah
// */
//$( document ).ready(function(){
//	<?php if(!empty($_GET['pasienanastesi_id'])){ ?>
//			var pasienanastesi_id = '<?php echo isset($_GET['pasienanastesi_id']) ? $_GET['pasienanastesi_id'] : null; ?>';
//			var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
//			var pasienmasukpenunjang_id = '<?php echo isset($_GET['pasienmasukpenunjang_id']) ? $_GET['pasienmasukpenunjang_id'] : null; ?>';
//			setKunjungan(pasienanastesi_id,pendaftaran_id,pasienmasukpenunjang_id)
//
//	<?php } ?> 
//            
//            $('form').bind('click keyup select change', function(event) {
//                cekDisabled(this);
//            });
//            $(document).on('click keyup select change',function(){
//                cekDisabled('form');
//            }); 
//            cekDisabled('form');
//});
</script>