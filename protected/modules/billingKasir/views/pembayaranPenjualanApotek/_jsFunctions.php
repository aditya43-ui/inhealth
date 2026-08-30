<script type="text/javascript">
var carapembayaran = "";
/**
 * set form penjualan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setPenjualan(penjualanresep_id, noresep, no_rekam_medik, pasienadmisi_id ){
    $("#form-datapenjualan > div").addClass("animation-loading");
    var jenispenjualan = $("#jenispenjualan").val();
    var pendaftaran_id = $("#pendaftaran_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPenjualan'); ?>',
        data: {pendaftaran_id:pendaftaran_id, jenispenjualan:jenispenjualan, penjualanresep_id:penjualanresep_id, noresep:noresep, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
        dataType: "json",
        success:function(data){
            // $("#jenispenjualan").val(data.jenispenjualan);
            $("#penjualanresep_id").val(data.penjualanresep_id);
            $("#pendaftaran_id").val(data.pendaftaran_id);
            $("#pasien_id").val(data.pasien_id);
            $("#pasienadmisi_id").val(data.pasienadmisi_id);
            $("#carabayar_id").val(data.carabayar_id);
            $("#penjamin_id").val(data.penjamin_id);
            if(data.ruangan_id){
                $("#ruangan_id").val(data.ruangan_id);
            }else{
                $("#ruangan_id").val(data.ruanganakhir_id);
            }
            $("#noresep").val(data.noresep);
            $("#tglpenjualan").val(data.tglpenjualan);
            $("#ruangan_nama").val(data.ruangan_nama);
            $("#carabayar_nama").val(data.carabayar_nama);
            $("#penjamin_nama").val(data.penjamin_nama);
            $("#no_rekam_medik").val(data.no_rekam_medik);
            $("#namadepan").val(data.namadepan);
            $("#nama_pasien").val(data.nama_pasien);
            $("#nama_bin").val(data.nama_bin);
            $("#tanggal_lahir").val(data.tanggal_lahir);
            $("#umur").val(data.umur);
            $("#jeniskelamin").val(data.jeniskelamin);
            $("#alamat_pasien").val(data.alamat_pasien);
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
            $("#<?php echo CHtml::activeId($model, 'noresep') ?>").val(data.noresep);
            //uangmuka
            $("#<?php echo CHtml::activeId($modPemakaianuangmuka, 'totaluangmuka') ?>").val(data.jumlahuangmuka);

            setRincianObatalkes();
            setDataPembayar();

            $("#form-datapenjualan > legend > .judul").html('Data Penjualan '+data.noresep);
            $("#form-datapenjualan > legend > .tombol").attr('style','display:true;');
            $("#form-datapenjualan > .box").addClass("well").removeClass("box");

            carapembayaran = data.metode_pembayaran;

            if (data.dokterpenerima != '' || data.dpjp1 != '' || data.dpjp2 != '' || data.dpjp3 != '') {
                if (data.dokterpenerima != '') $("#dokterpenerima").val(data.dokterpenerima);
                if (data.dpjp1 != '') $("#dpjp1").val(data.dpjp1);
                if (data.dpjp2 != '') $("#dpjp2").val(data.dpjp2);
                if (data.dpjp3 != '') $("#dpjp3").val(data.dpjp3);
                $(".dpjp").show();
            } else {
                $(".dpjp :input").val("").hide();
            }

            $("#form-datapenjualan > div").removeClass("animation-loading");
            $("#nama_pasien").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            myAlert("Data penjualan tidak ditemukan !");
            console.log(errorThrown);
            setPenjualanReset();
            $("#form-datapenjualan > div").removeClass("animation-loading");
            $("#jenispenjualan").focus();
        }
    });

}
/**
 * untuk mereset form penjualan
 * @returns {undefined} */
function setPenjualanReset(){
    $("#penjualanresep_id").val("");
    $("#pendaftaran_id").val("");
    $("#pasien_id").val("");
    $("#pasienadmisi_id").val("");
    $("#carabayar_id").val("");
    $("#penjamin_id").val("");
    $("#ruangan_id").val("");
    $("#noresep").val("");
    $("#tglpenjualan").val("");
    $("#ruangan_nama").val("");
    $("#carabayar_nama").val("");
    $("#penjamin_nama").val("");
    $("#no_rekam_medik").val("");
    $("#namadepan").val("");
    $("#nama_pasien").val("");
    $("#nama_bin").val("");
    $("#tanggal_lahir").val("");
    $("#umur").val("");
    $("#jeniskelamin").val("");
    $("#alamat_pasien").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datapenjualan > div > .judul").html('Data Penjualan');
    $("#form-datapenjualan > div > .tombol").attr('style','display:none;');
    $("#form-datapenjualan > .well").addClass("box").removeClass("well");

    $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val("");
    $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val("");
    $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val("");

    $(".dpjp").hide().find("input").val("");

    carapembayaran = "";

    setRincianObatalkes();
}
/**
* menampilkan form verifikasi
* @returns {undefined}
*/
function setVerifikasi(){
    if(requiredCheck($("form"))){
        var penjualanresep_id=$("#penjualanresep_id").val();
            if(penjualanresep_id === ""){
                myAlert("Silahkan cari data penjualan terlabih dahulu !");
            }else{
                $('#dialog-verifikasi').dialog("open");
                $(".integer2, .float2, .integer-decimal").each(function(){
                    $(this).val(unformatNumber($(this).val()));
                });
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
                $(".animation-loading").removeClass("animation-loading");
                $("form").find('.float2').each(function(){
                    $(this).val(formatFloat(parseFloat($(this).val())));
                });
                $("form").find('.integer2').each(function(){
                    $(this).val(formatNumber($(this).val()));
                });
                $("form").find('.integer-decimal').each(function(){
                    $(this).val(formatThousandDecimal(parseFloat($(this).val())));
                });
            }
    }
    return false;
}

function simpanPembayaranPel(){
  $(".integer2, .float2, .integer-decimal").each(function(){
      $(this).val(unformatNumber($(this).val()));
  });
  $("#bkpembayaranpelayanan-t-form").submit();
}

/**
 * refresh dialog penjualan
 * @returns {undefined}
 */
function refreshDialogPenjualan(){
    var jenispenjualan = $("#jenispenjualan").val();
    $.fn.yiiGridView.update('datapenjualan-grid', {
        data: {
            "BKInformasipenjualanaresepV[jenispenjualan]":jenispenjualan,
        }
    });
}
/**
 * set form rincian tagihan apotek pasien
 * @returns {undefined}
 */
function setRincianObatalkes(){
    var jenispenjualan=$("#jenispenjualan").val();
    var penjualanresep_id=$("#penjualanresep_id").val();
    var pendaftaran_id=$("#pendaftaran_id").val();
    var pasienadmisi_id=$("#pasienadmisi_id").val();
    var kelaspelayanan_id=$("#kelaspelayanan_id").val();
    var penjamin_id=$("#penjamin_id").val();
    var pasien_id=$("#pasien_id").val();
    $("#form-rincianobatalkes").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetRincianObatalkes'); ?>',
        data: {pendaftaran_id:pendaftaran_id,jenispenjualan:jenispenjualan,penjualanresep_id:penjualanresep_id,pasienadmisi_id:pasienadmisi_id,kelaspelayanan_id:kelaspelayanan_id,penjamin_id:penjamin_id, pasien_id:pasien_id},//
        dataType: "json",
        success:function(data){
            $("#form-rincianobatalkes").html(data.form);
            $("#form-rincianobatalkes").removeClass("animation-loading");
            $("#form-rincianobatalkes .integer2").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
            );
            $("#form-rincianobatalkes").find('input:checkbox[name$="is_proporsioa"]').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});

            hitungTotalOa();
        },
         error: function (jqXHR, textStatus, errorThrown) { $("#form-rincianobatalkes").removeClass("animation-loading");console.log(errorThrown);}
    });
}

function setRincianTindakan(){
    //KARENA DISINI TIDAK ADA FORM OBAT ALKES
}

/**
 * menghitung total obat alkes
 * @returns {undefined}
 */
function hitungTotalOa(){
    unformatNumberSemua();
    var tot_hargajual_oa = 0;
    var tot_tarifcyto = 0;
    var tot_discount = 0;
    var tot_biayalain = 0;
    var tot_subsidiasuransi = 0;
    var tot_subsidipemerintah = 0;
    var tot_subsidirs = 0;
    var tot_iurbiaya = 0;
    var total_oa = 0;
    var subtotaloa = 0;
    var subiurbiayaoa = 0;
    var jasafarmasi = 0;

    $("#form-rincianobatalkes").find("input[name$='[is_pilihoa]'][type='checkbox']").each(function(){
        var qty_oa = parseFloat($(this).parents('tr').find("input[name$='[qty_oa]']").val());
        var hargasatuan_oa = parseFloat($(this).parents('tr').find("input[name$='[hargasatuan_oa]']").val());
        var tarifcyto = parseFloat($(this).parents('tr').find("input[name$='[tarifcyto]']").val());
        var jmlppn = parseFloat($(this).parents('tr').find("input[name$='[jumlahppn]']").val());
        var discount = parseFloat($(this).parents('tr').find("input[name$='[discount]']").val());
        var biayalain = parseFloat($(this).parents('tr').find("input[name$='[biayalain]']").val());
        var subsidiasuransi = parseFloat($(this).parents('tr').find("input[name$='[subsidiasuransi]']").val());
        var subsidipemerintah = parseFloat($(this).parents('tr').find("input[name$='[subsidipemerintah]']").val());
        var subsidirs = parseFloat($(this).parents('tr').find("input[name$='[subsidirs]']").val());
        var jasapelayanan_farmasi = parseFloat($(this).parents('tr').find("input[name$='[jasapelayanan_farmasi]']").val());

        if(jmlppn == undefined){
          jmlppn = 0;
        }
        if(isNaN(jmlppn)){
          jmlppn = 0;
        }
        if(jmlppn == undefined){
          jmlppn = 0;
        }

        if(isNaN(tarifcyto)){
          tarifcyto = 0;
        }
        if(isNaN(discount)){
          discount = 0;
        }
        if(isNaN(biayalain)){
          biayalain = 0;
        }

        if(isNaN(jasapelayanan_farmasi)){
            jasapelayanan_farmasi = 0;
        }

        var jmlQty = hargasatuan_oa * qty_oa;
        if (jmlQty > 0){
            jmlQty = parseFloat(jmlQty.toFixed(2));
        }
        // subtotaloa = (hargasatuan_oa * qty_oa) + jmlppn - tarifcyto-discount - biayalain;
        // subiurbiayaoa = subtotaloa-subsidiasuransi-subsidirs-subsidipemerintah;
        // subtotaloa = jmlQty - discount - biayalain - subsidiasuransi;
        subtotaloa = jmlQty - discount - subsidiasuransi - subsidirs;
        subiurbiayaoa = subtotaloa;

        if($(this).is(":checked")){
            $(this).parents('tr').find("input[name$='[subtotaloa]']").val(subtotaloa);
            $(this).parents('tr').find("input[name$='[iurbiaya]']").val(subiurbiayaoa);

            tot_hargajual_oa += jmlQty;
            tot_iurbiaya += subiurbiayaoa;
            tot_tarifcyto += tarifcyto;
            tot_discount += discount;
            tot_biayalain += biayalain;
            tot_subsidiasuransi += subsidiasuransi;
            tot_subsidipemerintah += subsidipemerintah;
            tot_subsidirs += subsidirs;
            total_oa += subtotaloa;
            jasafarmasi += jasapelayanan_farmasi;
        }else{
            $(this).parents('tr').find("input[name$='[subtotaloa]']").val(0);
            $(this).parents('tr').find("input[name$='[iurbiaya]']").val(0);
        }

        //console.log("TOTAL HARGA OA ", hargasatuan_oa, qty_oa, hargasatuan_oa * qty_oa, tot_hargajual_oa);

    });
    //console.log("TOTAL HARGA OA", tot_hargajual_oa);
	if($("#is_proporsioa").is(":checked")){
		// var tot_discount = parseFloat($("#form-rincianobatalkes #tot_discount").val());
		// var tot_biayalain = parseFloat($("#form-rincianobatalkes #tot_biayalain").val());
		// var tot_subsidiasuransi = parseFloat($("#form-rincianobatalkes #tot_subsidiasuransi").val());
    var tot_subsidipemerintah = parseFloat($("#form-rincianobatalkes #tot_subsidipemerintah").val());
		// var tot_subsidirs = parseFloat($("#form-rincianobatalkes #tot_subsidirs").val());
		// total_oa = tot_hargajual_oa+tot_tarifcyto-tot_discount+tot_biayalain;

    // total_oa = tot_hargajual_oa - tot_discount;
    // tot_iurbiaya = total_oa - tot_subsidiasuransi - tot_subsidirs;
		// tot_iurbiaya = parseFloat(total_oa-(parseFloat(tot_subsidiasuransi)+parseFloat(tot_subsidirs)+parseFloat(tot_subsidipemerintah)));
                //tot_iurbiaya = (total_oa-(tot_subsidiasuransi+tot_subsidirs+tot_subsidipemerintah));
	}else{
		
        $("#form-rincianobatalkes #tot_subsidipemerintah").val(tot_subsidipemerintah);
		
	}
	$("#form-rincianobatalkes #tot_hargajual_oa").val((tot_hargajual_oa));
	$("#form-rincianobatalkes #tot_tarifcyto").val(tot_tarifcyto);
    $("#form-rincianobatalkes #tot_discount").val(tot_discount);
    $("#form-rincianobatalkes #tot_biayalain").val(tot_biayalain);
    $("#form-rincianobatalkes #tot_subsidiasuransi").val(tot_subsidiasuransi);
    $("#form-rincianobatalkes #tot_subsidirs").val(tot_subsidirs);
	$("#form-rincianobatalkes #tot_iurbiaya").val(tot_iurbiaya);
	$("#form-rincianobatalkes #total_oa").val(total_oa);

    if(jasafarmasi > 0){
        $("#<?php echo CHtml::activeId($model,'jasapelayanan_farmasi');?>").val(jasafarmasi);
        $(".jasapelayananfarmasi_div").show();
    }else{
        $(".jasapelayananfarmasi_div").hide();
    }
    
        

    formatNumberSemua();

    <?php if($this->id == "pembayaranTagihanPasien"){  ?>
        hitungMultiPenjamin();
    <?php } ?>

    hitungTotalSemua();
    hitungBiayaAdministrasi();
    hitungDiskonBayar();
}
/**
 * menghitung total semua = total obat alkes
 * @returns {undefined}
 */
function hitungTotalSemua(){

    unformatNumberSemua();
    var tot_tarif_tindakan = 0; // parseFloat($("#form-rinciantindakan #tot_tarif_tindakan").val());
    var tot_tarifcyto_tindakan = 0; // parseFloat($("#form-rinciantindakan #tot_tarifcyto_tindakan").val());
    var tot_discount_tindakan = 0; // parseFloat($("#form-rinciantindakan #tot_discount_tindakan").val());
    var tot_pembebasan_tindakan = 0; // parseFloat($("#form-rinciantindakan #tot_pembebasan_tindakan").val());
    var tot_subsidiasuransi_tindakan = 0; // parseFloat($("#form-rinciantindakan #tot_subsidiasuransi_tindakan").val());
    var tot_subsisidirumahsakit_tindakan = 0; // parseFloat($("#form-rinciantindakan #tot_subsisidirumahsakit_tindakan").val());
    var tot_subsidipemerintah_tindakan = 0; // parseFloat($("#form-rinciantindakan #tot_subsidipemerintah_tindakan").val());
    var tot_iurbiaya_tindakan = 0; // parseFloat($("#form-rinciantindakan #tot_iurbiaya_tindakan").val());
    var total_tindakan = 0; // parseFloat($("#form-rinciantindakan #total_tindakan").val());
    var tot_jmlselisihbpjs_tindakan = 0; // parseFloat($("#form-rinciantindakan #tot_jmlselisihbpjs_tindakan").val());

    var tot_hargajual_oa = parseFloat($("#form-rincianobatalkes #tot_hargajual_oa").val());
    var tot_tarifcyto = parseFloat($("#form-rincianobatalkes #tot_tarifcyto").val());
    var tot_discount = parseFloat($("#form-rincianobatalkes #tot_discount").val());
    var tot_biayalain = parseFloat($("#form-rincianobatalkes #tot_biayalain").val());
    var tot_subsidiasuransi = parseFloat($("#form-rincianobatalkes #tot_subsidiasuransi").val());
    var tot_subsidipemerintah = parseFloat($("#form-rincianobatalkes #tot_subsidipemerintah").val());
    var tot_subsidirs = parseFloat($("#form-rincianobatalkes #tot_subsidirs").val());
    var tot_iurbiaya = parseFloat($("#form-rincianobatalkes #tot_iurbiaya").val());
    var total_oa = parseFloat($("#form-rincianobatalkes #total_oa").val());
    var tot_jmlselisihbpjs = parseFloat($("#form-rincianobatalkes #tot_jmlselisihbpjs").val());
    // - (tot_discount_tindakan+tot_discount)
    var tot_tarif_semua = (tot_tarif_tindakan+tot_hargajual_oa);


    var tot_tarifcyto_semua = tot_tarifcyto_tindakan+tot_tarifcyto;
    var tot_discount_semua = tot_discount_tindakan+tot_discount;
    var tot_subsidiasuransi_semua = tot_subsidiasuransi_tindakan+tot_subsidiasuransi;

    var tot_inacbg_semua = parseFloat($("#form-rinciansemua #tot_inacbg").val());
    var tot_subsidirumahsakit_semua = tot_subsisidirumahsakit_tindakan+tot_subsidirs;
    var tot_subsidipemerintah_semua = tot_subsidipemerintah_tindakan+tot_subsidipemerintah;
    var tot_iurbiaya_semua = tot_iurbiaya_tindakan+tot_iurbiaya;
    var tot_jmlselisihbpjs_semua = (tot_jmlselisihbpjs_tindakan + tot_jmlselisihbpjs);

    var biayaadministrasi = parseFloat($("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val());
    var biayamaterai = parseFloat($("#<?php echo CHtml::activeId($modTandabukti,'biayamaterai');?>").val());
    var diskon = parseFloat($("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val());

    var tot_discount_global = tot_discount_semua;
    var tot_subsidi_asuransi_global = tot_subsidiasuransi_semua;
    var tot_subsidi_pemerintah_global = tot_subsidipemerintah_semua;
    var tot_subsidi_rs_global = tot_subsidirumahsakit_semua;

    var tot_discount_semua_persen = tot_discount_semua * 100 / tot_tarif_semua;
    var tot_subsidiasuransi_semua_persen = tot_subsidiasuransi_semua * 100 / tot_tarif_semua;
    var tot_subsidirumahsakit_semua_persen = tot_subsidirumahsakit_semua * 100 / tot_tarif_semua;
    var tot_subsidipemerintah_semua_persen = tot_subsidipemerintah_semua * 100 / tot_tarif_semua;

    var total_semua = total_tindakan+total_oa;

    // tot_iurbiaya_semua += biayaadministrasi + biayamaterai - diskon;
    // tot_iurbiaya_semua = biayaadministrasi + biayamaterai - diskon;

	if($("#is_proporsisemua").is(":checked")){
		tot_discount_semua = parseFloat($("#form-rinciansemua #tot_discount_semua").val());
    tot_inacbg_semua = parseFloat($("#form-rinciansemua #tot_inacbg").val());
    tot_subasrSemua = parseFloat($("#form-rinciansemua #tot_subsidiasuransi_semua").val());
		//tot_subsidiasuransi_semua = parseFloat($("#form-rinciansemua #tot_subsidiasuransi_semua").val());
		//tot_subsidirumahsakit_semua = parseFloat($("#form-rinciansemua #tot_subsidirumahsakit_semua").val());
    tot_subsidipemerintah_semua = parseFloat($("#form-rinciansemua #tot_subsidipemerintah_semua").val());
    tot_subsidiasuransi_semua = (tot_inacbg_semua + tot_subasrSemua);
        /*tot_iurbiaya_semua = total_semua - tot_discount_semua - tot_inacbg_semua - tot_subsidiasuransi_semua - tot_subsidirumahsakit_semua;
        if (tot_iurbiaya_semua < 0 || tot_inacbg_semua > 0) {
            tot_iurbiaya_semua = 0;
            total_semua = total_semua - tot_inacbg_semua;
            if (total_semua < 0) {
                total_semua = 0;
            }
        }*/
        // tot_iurbiaya_semua = tot_tarif_semua - tot_tarifcyto_semua - tot_discount_semua - tot_subsidirumahsakit_semua;
        //
        // if(tot_inacbg_semua > 0){
        //   tot_iurbiaya_semua = tot_iurbiaya_semua - tot_inacbg_semua;
        // }else{
        //   tot_iurbiaya_semua = tot_iurbiaya_semua - tot_subsidiasuransi_semua;
        // }

        $(".ina_vip").val(Math.round(tot_inacbg_semua * 1.75));
	}

	$("#form-rinciansemua #tot_tarif_semua").val(tot_tarif_semua);
	$("#form-rinciansemua #tot_tarifcyto_semua").val(tot_tarifcyto_semua);
//	$("#form-rinciansemua #tot_discount_semua").val((tot_discount_semua_persen));
        $("#form-rinciansemua #tot_discount_semua").val((tot_discount_semua));
//	$("#form-rinciansemua #tot_subsidiasuransi_semua").val((tot_subsidiasuransi_semua_persen));
        // $("#form-rinciansemua #tot_subsidiasuransi_semua").val((tot_subsidiasuransi_semua));


        if (carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?> || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA; ?>) {
          $("#form-rinciansemua #tot_inacbg").val((tot_subsidiasuransi_semua));
        }else{
          $("#form-rinciansemua #tot_subsidiasuransi_semua").val((tot_subsidiasuransi_semua));
        }

//	$("#form-rinciansemua #tot_subsidirumahsakit_semua").val((tot_subsidirumahsakit_semua_persen));
        $("#form-rinciansemua #tot_subsidirumahsakit_semua").val((tot_subsidirumahsakit_semua));
        $("#form-rinciansemua #tot_subsidipemerintah_semua").val((tot_subsidipemerintah_semua_persen));
	$("#form-rinciansemua #tot_iurbiaya_semua").val(tot_iurbiaya_semua);
	$("#form-rinciansemua #total_semua").val(total_semua);
  $("#form-rinciansemua #tot_jmlselisihbpjs_semua").val(tot_jmlselisihbpjs_semua);
  var totdiskon_tindakan = (tot_tarif_tindakan - tot_discount_tindakan);
  var totdiskon_oa = (tot_hargajual_oa - tot_discount);
  var tot_tarifDiskon_semua = (totdiskon_tindakan + totdiskon_oa);

    $("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val(Math.round(tot_tarifDiskon_semua));
    $("#<?php echo CHtml::activeId($model,'totalbiayatindakan');?>").val(Math.round(totdiskon_tindakan));
    $("#<?php echo CHtml::activeId($model,'totalbiayaoa');?>").val(Math.round(totdiskon_oa));
    // $("#<?php //echo CHtml::activeId($model,'totaldiscount');?>").val(diskon);
    $("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(Math.round(tot_subsidi_asuransi_global));
    $("#<?php echo CHtml::activeId($model,'totalsubsidipemerintah');?>").val(Math.round(tot_subsidi_pemerintah_global));
    $("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val(Math.round(tot_subsidi_rs_global));
    // $("#<?php //echo CHtml::activeId($model,'totaliurbiaya');?>").val(tot_iurbiaya_semua);
    $("#<?php echo CHtml::activeId($model,'totalpembebasan');?>").val(Math.round(tot_pembebasan_tindakan));


    total_subsidi_asuransi = tot_subsidi_asuransi_global;


    formatNumberSemua();
    hitungJmlpembulatan();
    hitungJmlpembayaran();
    hitungUangKembalian();

    var tot_inacbg = $("#tot_inacbg").val();
    $('.subsidi_asuransi').val(tot_inacbg);
    // $('.total_inacbg_form').val(tot_inacbg);

}
/**
 * set default / otomatis data pembayar
 * @returns {undefined}
 */
function setDataPembayar(){
    var darinama_bkm = $("#noresep").val()+"-"+$("#no_rekam_medik").val()+"-"+$("#namadepan").val()+" "+$("#nama_pasien").val();
    var alamat_bkm = $("#alamat_pasien").val();
    var jenispenjualan = $("#jenispenjualan option:selected").text();
    var sebagaipembayaran_bkm = "BIAYA PELAYANAN "+jenispenjualan.toUpperCase();
    $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val(darinama_bkm);
    $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val(alamat_bkm);
    $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val(sebagaipembayaran_bkm);
}

/**
 * print rincian
 */
function printRincian(caraPrint)
{
    var tandabuktibayar_id = "<?php echo $modTandabukti->tandabuktibayar_id; ?>";
    var penjualanresep_id = "<?php echo $modPenjualan->penjualanresep_id; ?>";

    if(tandabuktibayar_id){
        window.open("<?php echo $this->createUrl('informasipenjualanresep/fakturPembayaranApotek') ?>&penjualanresep_id="+penjualanresep_id+"&tandabuktibayar_id="+tandabuktibayar_id+"&caraPrint="+caraPrint,'printwin','location=_new, width=1024px');
    }else{
        myAlert("Silahkan cari data penjualan terlabih dahulu !");
    }
}

/**
 * print rincian sudah bayar
 */
function printBkm(caraPrint)
{
    var tandabuktibayar_id = "<?php echo $modTandabukti->tandabuktibayar_id; ?>";
    var penjualanresep_id = "<?php echo $modPenjualan->penjualanresep_id; ?>";

    if(tandabuktibayar_id){
        window.open("<?php echo $this->createUrl('informasipenjualanresep/buktiKasMasukFarmasi') ?>&penjualanresep_id="+penjualanresep_id+"&tandabuktibayar_id="+tandabuktibayar_id+"&caraPrint="+caraPrint,'printwin','location=_new, width=1024px');
    }else{
        myAlert("Silahkan cari data penjualan terlabih dahulu !");
    }
}

/**
 * print rincian belum bayar (PERLU PENYESUAIAN LAGI)
 */
function printRincianPenunjangBelumBayar()
{
    var instalasi_id = $("#instalasi_id").val();
    var pendaftaran_id = $("#pendaftaran_id").val();
    if(instalasi_id && pendaftaran_id){
        window.open("<?php echo $this->createUrl('printRincianPenunjangBelumBayar') ?>&instalasi_id="+instalasi_id+"&pendaftaran_id="+pendaftaran_id,"",'location=_new, width=1024px');
    }else{
        myAlert("Silahkan cari data penjualan terlabih dahulu !");
    }
}

/**
* print rincian sudah bayar (PERLU PENYESUAIAN LAGI)
* @returns {undefined} */
function printRincianSudahBayar()
{
   var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id?>";
   window.open("<?php echo $this->createUrl('printRincianSudahBayar') ?>&pembayaranpelayanan_id="+pembayaranpelayanan_id,"",'location=_new, width=1024px');
}


$( document ).ready(function(){
    <?php if(!empty($modPenjualan->penjualanresep_id)){ ?>
           setRincianObatalkes();
           setDataPembayar();
           $("#form-datapenjualan :input").attr("readonly",true);
           $("#form-datapenjualan .add-on").remove();
    <?php } ?>

    // Notifikasi Pasien
    <?php
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $model->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16
        insert_notifikasi(params);
    <?php
            }
        }
    ?>
    // Notifikasi Pegawai
    <?php
        if(isset($_GET['smspegawai'])){
            if($_GET['smspegawai']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PEGAWAI', isinotifikasi:'dr. <?php echo PegawaiM::model()->findByPk($modPenjualan->pegawai_id)->nama_pegawai; ?> tidak memiliki nomor mobile'}; // 16
        insert_notifikasi(params);
    <?php
            }
        }
    ?>
});
</script>
