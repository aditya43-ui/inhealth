<script type="text/javascript">
    /**
     * refresh dialog kunjungan
     * @returns {undefined}
     */
    function refreshDialogKunjungan(){
        var instalasi_id = $("#instalasi_id").val();
        $.fn.yiiGridView.update('datakunjungan-grid', {
            data: {
                "BKRinciantagihanpasienpenunjangV[instalasi_id]":instalasi_id,
            }
        });
    }
    /**
     * set form rincian tagihan tindakan penunjang
     * @returns {undefined}
     */
    function setRincianTindakan(){
        var instalasi_id=$("#instalasi_id").val();
        var pendaftaran_id=$("#pendaftaran_id").val();
        var pasienadmisi_id=$("#pasienadmisi_id").val();
        var kelaspelayanan_id=$("#kelaspelayanan_id").val();
        var penjamin_id=$("#penjamin_id").val();
        var pasien_id=$("#pasien_id").val();
        var pembayaranpelayanan_id=$("#<?php echo CHtml::activeId($model,'pembayaranpelayanan_id') ?>").val();

        $("#form-rinciantindakan").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetRincianTindakanPenunjang'); ?>',
            data: {instalasi_id:instalasi_id,pendaftaran_id:pendaftaran_id,pasienadmisi_id:pasienadmisi_id,kelaspelayanan_id:kelaspelayanan_id,penjamin_id:penjamin_id, pasien_id:pasien_id, pembayaranpelayanan_id:pembayaranpelayanan_id},//
            dataType: "json",
            success:function(data){
                $("#form-rinciantindakan").html(data.form);
                $("#form-rinciantindakan").removeClass("animation-loading");
                $("#form-rinciantindakan .integer2").maskMoney (
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                );
                $("#form-rinciantindakan").find('input:checkbox[name$="is_proporsitindakan"]').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                is_load = false;
                hitungTotalTindakan();
                hitungTotalSemua();
            },
             error: function (jqXHR, textStatus, errorThrown) { $("#form-rinciantindakan").removeClass("animation-loading");console.log(errorThrown);}
        });
    }
    function setRincianObatalkes(){
        //KARENA DISINI TIDAK ADA FORM OBAT ALKES
    }

    function hitungTotalTindakan(){
    unformatNumberSemua();
    var tot_tarif_tindakan = 0;
    var tot_tarifcyto_tindakan = 0;
    var tot_discount_tindakan = 0;
    var tot_pembebasan_tindakan = 0;
    var tot_subsidiasuransi_tindakan = 0;
    var tot_subsisidirumahsakit_tindakan = 0;
    var tot_subsidipemerintah_tindakan = 0;
    var tot_iurbiaya_tindakan = 0;
    var tot_sisatagihan = 0;
    var total_tindakan = 0;
    var subiurbiaya = 0;
    var subtotal = 0;
    var sisatagihan = 0;

    $("#form-rinciantindakan").find("input[name$='[is_pilihtindakan]'][type='checkbox']").each(function(){
        var qty_tindakan = parseFloat($(this).parents('tr').find("input[name$='[qty_tindakan]']").val());
        var tarif_satuan = parseFloat($(this).parents('tr').find("input[name$='[tarif_satuan]']").val());
        var tarifcyto_tindakan = parseFloat($(this).parents('tr').find("input[name$='[tarifcyto_tindakan]']").val());
        var discount_tindakan = parseFloat($(this).parents('tr').find("input[name$='[discount_tindakan]']").val());
        var pembebasan_tindakan = parseFloat($(this).parents('tr').find("input[name$='[pembebasan_tindakan]']").val());
        var subsidiasuransi_tindakan = parseFloat($(this).parents('tr').find("input[name$='[subsidiasuransi_tindakan]']").val());
        var subsisidirumahsakit_tindakan = parseFloat($(this).parents('tr').find("input[name$='[subsisidirumahsakit_tindakan]']").val());
        var subsidipemerintah_tindakan = parseFloat($(this).parents('tr').find("input[name$='[subsidipemerintah_tindakan]']").val());

        subtotal = ((tarif_satuan * qty_tindakan) - subsidiasuransi_tindakan - subsisidirumahsakit_tindakan);
        // subtotal = (tarif_satuan * qty_tindakan) - discount_tindakan - pembebasan_tindakan - subsidiasuransi_tindakan;
        subiurbiaya = subtotal;

        // subtotal = (tarif_satuan * qty_tindakan)+tarifcyto_tindakan-discount_tindakan;
        // subiurbiaya = subtotal-pembebasan_tindakan-subsidiasuransi_tindakan-subsisidirumahsakit_tindakan - subsidipemerintah_tindakan;
        sisatagihan = ((qty_tindakan * tarif_satuan) - discount_tindakan - subsidiasuransi_tindakan - subsisidirumahsakit_tindakan - pembebasan_tindakan - subsidipemerintah_tindakan);

        if($(this).is(":checked")){
            $(this).parents('tr').find("input[name$='[subtotal]']").val(subtotal);
            $(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val(subiurbiaya);
            $(this).parents('tr').find("input[name$='[jmlbayar_iurtindakan]']").val(subtotal);

            tot_tarif_tindakan += (tarif_satuan * qty_tindakan);
            tot_tarifcyto_tindakan += tarifcyto_tindakan;
            tot_discount_tindakan += discount_tindakan;
            tot_iurbiaya_tindakan += subiurbiaya;
            tot_pembebasan_tindakan += pembebasan_tindakan;
            tot_subsidiasuransi_tindakan += subsidiasuransi_tindakan;
            tot_subsidipemerintah_tindakan += subsidipemerintah_tindakan;
            tot_subsisidirumahsakit_tindakan += subsisidirumahsakit_tindakan;
            tot_sisatagihan += sisatagihan;
            total_tindakan += subtotal;
        }else{
            $(this).parents('tr').find("input[name$='[subtotal]']").val(0);
            $(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val(0);
            $(this).parents('tr').find("input[name$='[jmlbayar_iurtindakan]']").val(0);
        }
    });

	if($("#is_proporsitindakan").is(":checked")){
		var tot_discount_tindakan = $("#form-rinciantindakan #tot_discount_tindakan").val();
		var tot_pembebasan_tindakan = $("#form-rinciantindakan #tot_pembebasan_tindakan").val();
		var tot_subsidiasuransi_tindakan = $("#form-rinciantindakan #tot_subsidiasuransi_tindakan").val();
		var tot_subsisidirumahsakit_tindakan = $("#form-rinciantindakan #tot_subsisidirumahsakit_tindakan").val();
    var tot_subsidipemerintah_tindakan = $("#form-rinciantindakan #tot_subsidipemerintah_tindakan").val();
		// total_tindakan = tot_tarif_tindakan + tot_tarifcyto_tindakan - tot_discount_tindakan;
		// tot_iurbiaya_tindakan = total_tindakan - tot_pembebasan_tindakan - tot_subsidiasuransi_tindakan - tot_subsisidirumahsakit_tindakan - tot_subsidipemerintah_tindakan;
	}else{
		$("#form-rinciantindakan #tot_discount_tindakan").val(tot_discount_tindakan);
		$("#form-rinciantindakan #tot_pembebasan_tindakan").val(tot_pembebasan_tindakan);
		$("#form-rinciantindakan #tot_subsidiasuransi_tindakan").val(tot_subsidiasuransi_tindakan);
    $("#form-rinciantindakan #tot_subsidipemerintah_tindakan").val(tot_subsidipemerintah_tindakan);
		$("#form-rinciantindakan #tot_subsisidirumahsakit_tindakan").val(tot_subsisidirumahsakit_tindakan);
	}
	$("#form-rinciantindakan #tot_tarif_tindakan").val(tot_tarif_tindakan);
    $("#form-rinciantindakan #tot_tarifcyto_tindakan").val(tot_tarifcyto_tindakan);
    $("#form-rinciantindakan #tot_iurbiaya_tindakan").val(tot_iurbiaya_tindakan);
    $("#form-rinciantindakan #total_tindakan").val(total_tindakan);
    $("#<?php echo CHtml::activeId($model,'totalsisatagihan');?>").val(tot_sisatagihan);
    formatNumberSemua();

    hitungMultiPenjamin();
    
    hitungTotalSemua();
    hitungBiayaAdministrasi();
}
function hitungBiayaAdministrasi() {

    // console.log(is_load);

    // return false;
    if (is_load) {

        if (nilai_admin != 0) {
            // console.log("Kicker");
            hitungPersenBiayaAdministrasi();
            return false;
        }
    }

    var persenAdmin = parseFloat(unformatNumber($("#persen_admin").val()));
    var totalBiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val()));
    var total = totalBiaya * persenAdmin / 100;
    $("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val(formatNumber(total));

    // console.log("Total Administrasi", total);
    hitungDiskonBayar();
}

function hitungDiskonBayar() {
    var biayaAdmin = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val()));
    var totalBiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val()));
    var persenDiskon = parseFloat(unformatNumber($("#persen_diskon_bayar").val()));
    var total = (biayaAdmin + totalBiaya) * persenDiskon / 100;

    $("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val(formatNumber(total));

    hitungJmlpembayaran();
    //hitungTotalSemua();
    hitungJmlpembulatan();
}

var jmlpembulatan_main = 0;

function hitungJmlpembulatan(){
    //unformatNumberSemua();
    var totaliurbiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val()));
    var totaldibayarpasien = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val()));
    var carabayar_id = $("#carabayar_id").val();
    var asuransi = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val()));
    var pem = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidipemerintah');?>").val()));
    var rs = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val()));

    // totaliurbiaya += asuransi + pem + rs;

    var totaldiscount = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val()));
    var biayaadministrasi = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val()));
    var biayamaterai = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'biayamaterai');?>").val()));
    var jmlpembulatan = 0;

    //RSPMC-859
    var konfig_pembulatan = <?php echo Yii::app()->user->getState('pembulatanhargakasir'); ?>;
    if(konfig_pembulatan > 0 && totaldibayarpasien > 0) {
        // console.log("PEMBULATAN", totaliurbiaya, biayaadministrasi, biayamaterai, konfig_pembulatan);
        var nilai_total = totaldibayarpasien;
        // var nilai_total = totaliurbiaya+biayaadministrasi+biayamaterai-totaldiscount;
        var nilai_bulat = Math.round((nilai_total)/konfig_pembulatan) * konfig_pembulatan;

        jmlpembulatan = nilai_bulat - nilai_total;
        if(konfig_pembulatan == jmlpembulatan || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?> || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA; ?>){
            jmlpembulatan = 0;
        }
    }

    // console.log(konfig_pembulatan, jmlpembulatan)

//    $("#<?php // echo CHtml::activeId($modTandabukti,'jmlpembulatan');?>").val(formatNumber(jmlpembulatan));
    jmlpembulatan_main = jmlpembulatan;
    $("#pembulatankasir").val(formatNumber(jmlpembulatan));

    // formatNumberSemua();
}

    /**
     * menghitung total semua = total tindakan
     * @returns {undefined}
     */
    function hitungTotalSemua(){
        unformatNumberSemua();
        var tot_tarif_tindakan = parseFloat($("#form-rinciantindakan #tot_tarif_tindakan").val());
        var tot_tarifcyto_tindakan = parseFloat($("#form-rinciantindakan #tot_tarifcyto_tindakan").val());
        var tot_discount_tindakan = parseFloat($("#form-rinciantindakan #tot_discount_tindakan").val());
        var tot_pembebasan_tindakan = parseFloat($("#form-rinciantindakan #tot_pembebasan_tindakan").val());
        var tot_subsidiasuransi_tindakan = parseFloat($("#form-rinciantindakan #tot_subsidiasuransi_tindakan").val());
        var tot_subsisidirumahsakit_tindakan = parseFloat($("#form-rinciantindakan #tot_subsisidirumahsakit_tindakan").val());
        var tot_subsidipemerintah_tindakan = parseFloat($("#form-rinciantindakan #tot_subsidipemerintah_tindakan").val());
        var tot_iurbiaya_tindakan = parseFloat($("#form-rinciantindakan #tot_iurbiaya_tindakan").val());
        var total_tindakan = parseFloat($("#form-rinciantindakan #total_tindakan").val());
        var tot_jmlselisihbpjs_tindakan = parseFloat($("#form-rinciantindakan #tot_jmlselisihbpjs_tindakan").val());

        var tot_tarif_semua = tot_tarif_tindakan;
        var tot_tarifcyto_semua = tot_tarifcyto_tindakan;
        var tot_discount_semua = tot_discount_tindakan;
        var tot_subsidiasuransi_semua = tot_subsidiasuransi_tindakan;
        var tot_inacbg_semua = parseFloat($("#form-rinciansemua #tot_inacbg").val());
        var tot_subsidirumahsakit_semua = tot_subsisidirumahsakit_tindakan;
        var tot_subsidipemerintah_semua = tot_subsidipemerintah_tindakan;
        var tot_iurbiaya_semua = tot_iurbiaya_tindakan;
        var tot_jmlselisihbpjs_semua = tot_jmlselisihbpjs_tindakan;

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

        var total_semua = total_tindakan;

        tot_iurbiaya_semua += biayaadministrasi + biayamaterai - diskon;

        if($("#is_proporsisemua").is(":checked")){
            tot_discount_semua = parseFloat($("#form-rinciansemua #tot_discount_semua").val());
            tot_inacbg_semua = parseFloat($("#form-rinciansemua #tot_inacbg").val());
            tot_subasrSemua = parseFloat($("#form-rinciansemua #tot_subsidiasuransi_semua").val());
            tot_subsidipemerintah_semua = parseFloat($("#form-rinciansemua #tot_subsidipemerintah_semua").val());

            tot_subsidiasuransi_semua = (tot_inacbg_semua + tot_subasrSemua);

            // tot_iurbiaya_semua = total_semua - tot_discount_semua - tot_inacbg_semua - tot_subsidiasuransi_semua - tot_subsidirumahsakit_semua;
            // if (tot_iurbiaya_semua < 0 || tot_inacbg_semua > 0) {
            //     tot_iurbiaya_semua = 0;
            //     total_semua = total_semua - tot_inacbg_semua;
            //     if (total_semua < 0) {
            //         total_semua = 0;
            //     }
            // }

            $(".ina_vip").val(Math.round(tot_inacbg_semua * 1.75));
	}

        $("#form-rinciansemua #tot_tarif_semua").val(tot_tarif_semua);
	$("#form-rinciansemua #tot_tarifcyto_semua").val(tot_tarifcyto_semua);
        $("#form-rinciansemua #tot_discount_semua").val((tot_discount_semua));
        // $("#form-rinciansemua #tot_subsidiasuransi_semua").val((tot_subsidiasuransi_semua));
        $("#form-rinciansemua #tot_subsidirumahsakit_semua").val((tot_subsidirumahsakit_semua));
        $("#form-rinciansemua #tot_subsidipemerintah_semua").val((tot_subsidipemerintah_semua_persen));
	$("#form-rinciansemua #tot_iurbiaya_semua").val(tot_iurbiaya_semua);
	$("#form-rinciansemua #total_semua").val(total_semua);
  if (carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?> || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA; ?>) {
    $("#form-rinciansemua #tot_inacbg").val((tot_subsidiasuransi_semua));
  }else{
    $("#form-rinciansemua #tot_subsidiasuransi_semua").val((tot_subsidiasuransi_semua));
  }
  $("#form-rinciansemua #tot_jmlselisihbpjs_semua").val(tot_jmlselisihbpjs_semua);

        $("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val(tot_tarif_semua);
        $("#<?php echo CHtml::activeId($model,'totalbiayatindakan');?>").val(tot_tarif_semua);
        $("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(tot_subsidi_asuransi_global);
        $("#<?php echo CHtml::activeId($model,'totalsubsidipemerintah');?>").val(tot_subsidi_pemerintah_global);
        $("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val(tot_subsidi_rs_global);
        $("#<?php echo CHtml::activeId($model,'totalpembebasan');?>").val(tot_pembebasan_tindakan);

        var totalinabgAll = $('#tot_inacbg').val();
        $("#<?php echo CHtml::activeId($model,'total_inacbg');?>").val(totalinabgAll);
        total_subsidi_asuransi = tot_subsidi_asuransi_global;

        formatNumberSemua();
        hitungJmlpembulatan();
        hitungJmlpembayaran();
        hitungUangKembalian();

    }
    /**
     * set default / otomatis data pembayar
     * @returns {undefined}
     */
    function setDataPembayar(){
        var darinama_bkm = $("#no_rekam_medik").val()+" - "+$("#namadepan").val()+" "+$("#nama_pasien").val();
        var alamat_bkm = $("#alamat_pasien").val();
        var instalasi_nama = $("#instalasi_id option:selected").text();
        var sebagaipembayaran_bkm = "BIAYA PELAYANAN "+instalasi_nama.toUpperCase();
        $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val(darinama_bkm);
        $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val(alamat_bkm);
        $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val(sebagaipembayaran_bkm);
    }
    /**
     * print rincian belum bayar (PERLU PENYESUAIAN LAGI)
     */
    function printRincianPenunjangBelumBayar()
    {
        var instalasi_id = $("#instalasi_id").val();
        var pendaftaran_id = $("#pendaftaran_id").val();
        //if(instalasi_id && pendaftaran_id){
            window.open("<?php echo $this->createUrl('printRincianPenunjangBelumBayar') ?>&instalasi_id="+instalasi_id+"&pendaftaran_id="+pendaftaran_id,"",'location=_new, width=1024px');
        //}else{
        //    myAlert("Silakan cari data kunjungan terlabih dahulu!");
        //}
    }

    function hitungSubsidiPenunjang() {
        var subsidi = parseFloat(unformatNumber($("#BKPembayaranpelayananT_totalsubsidiasuransi").val()));
        var total = parseFloat(unformatNumber($("#total_tindakan").val()));

        if (subsidi > total) {
            subsidi = total;
            $("#BKPembayaranpelayananT_totalsubsidiasuransi").val(formatNumber(subsidi));
        }

        $("#tot_subsidiasuransi_tindakan").val(formatNumber(subsidi));
        proporsiSubsidiAsuransiTindakan();
    }

    function hitungSubsidiRS() {
        var subsidi = parseFloat(unformatNumber($("#BKPembayaranpelayananT_totalsubsidirs").val()));
        var total = parseFloat(unformatNumber($("#total_tindakan").val()));

        if (subsidi > total) {
            subsidi = total;
            $("#BKPembayaranpelayananT_totalsubsidirs").val(formatNumber(subsidi));
        }

        $("#tot_subsisidirumahsakit_tindakan").val(formatNumber(subsidi));
        proporsiSubsidiRsTindakan();
    }

    /**
        * menghitung jumlah pembayaran
        * @returns {undefined}
        */
       function hitungJmlpembayaran(){
           // unformatNumberSemua();
           var tagihan_old = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'jmlpembayaran');?>").val()));

           var totaliurbiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val()));
           var tagihanpasien = totaliurbiaya;
           var pembebasan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalpembebasan');?>").val()));
           var asuransi = total_subsidi_asuransi; //parseInt(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val()));
           var asuransi_old = asuransi;
           var pem = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidipemerintah');?>").val()));
           var rs = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val()));
           var carabayar_id = $("#carabayar_id").val();
           var diskon = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val()));
           // var pembebasan = parseInt(unformatNumber($("#<?php //echo CHtml::activeId($model,'totalpembebasan');?>").val()));
           // totaliurbiaya -= asuransi + pem + rs;
           var tanggunganpasien_semua = parseFloat(unformatNumber($("#form-rinciansemua #tot_iurbiaya_semua").val()));

           var dat_asuransi = {};
           var dat_cnt = 0;

           var total_inacbg = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'total_inacbg');?>").val()));
           var totalsubsidiasuransi = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val()));
           var total_inakelas = parseFloat(unformatNumber($(".total_inacbg_form").val()));

           if(isNaN(total_inacbg) && total_inacbg == undefined){
               total_inacbg = 0;
           }

           if(isNaN(totalsubsidiasuransi) && totalsubsidiasuransi == undefined){
               totalsubsidiasuransi = 0;
           }

           if(isNaN(total_inakelas) && total_inakelas == undefined){
               total_inakelas = 0;
           }

           var totalsubsidiasuransiAll = (total_inacbg - totalsubsidiasuransi - total_inakelas);

           var biayaadministrasi = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val()));
           var biayamaterai = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'biayamaterai');?>").val()));
           var jmlpembulatan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'jmlpembulatan');?>").val()));
           if(isNaN(totaliurbiaya)){
               totaliurbiaya = 0;
           }
           if(isNaN(biayaadministrasi)){
               biayaadministrasi = 0;
           }
           if(isNaN(biayamaterai)){
               biayamaterai = 0;
           }
           if(isNaN(jmlpembulatan)){
               jmlpembulatan = 0;
           }
           if(isNaN(diskon)){
               diskon = 0;
           }

           var jmlpembayaran = (totaliurbiaya + biayaadministrasi + biayamaterai + jmlpembulatan) - diskon;

           var uangmuka = parseFloat(unformatNumber($("#BKPemakaianuangmukaT_pemakaianuangmuka").val()));

           if (asuransi > jmlpembayaran) {
               asuransi = jmlpembayaran - rs - pembebasan;
           }

           if (carabayar_id != <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?> && dat_cnt == 0) {
               asuransi = asuransi * ((jmlpembayaran - rs - pembebasan + biayaadministrasi - diskon) / (jmlpembayaran - rs - pembebasan));
               $("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(formatNumber(asuransi));
           }

           // if (carabayar_id != <?php //echo Params::CARABAYAR_ID_MEMBAYAR; ?> && dat_cnt == 0) {
           //     // asuransi = asuransi * ((jmlpembayaran - rs - pembebasan - biayaadministrasi + diskon) / (jmlpembayaran - rs - pembebasan));
           //     $("#<?php //echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(formatThousandDecimal(asuransi));
           //     $("#tot_subsidiasuransi_tindakan").val(formatThousandDecimal(asuransi));
           //     proporsiSubsidiAsuransiTindakan(true);
           // }

        //    var jmliurbiaya = (tagihanpasien - totalsubsidiasuransiAll - rs - pembebasan);
        //    var jmliurbiaya = tanggunganpasien_semua;
           var jmliurbiaya = (jmlpembayaran - asuransi - rs - uangmuka - pembebasan);
           // var jmliurbiaya = jmlpembayaran - (asuransi + rs + pembebasan + uangmuka);

           // if (jmliurbiaya < 0 && uangmuka > 0) {
           //
           //     console.log("HITUNG", uangmuka, jmliurbiaya, uangmuka, uangmuka + jmliurbiaya);
           //     uangmuka = uangmuka + jmliurbiaya;
           //     jmliurbiaya = 0;
           //
           //     $("#BKPemakaianuangmukaT_pemakaianuangmuka").val(formatNumber(uangmuka));
           // }

           $("#<?php echo CHtml::activeId($modTandabukti,'jmlpembayaran');?>").val(formatNumber(jmlpembayaran));
           $("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val(formatNumber(jmliurbiaya));

           var ina_tanggungan = parseFloat(unformatNumber($(".total_inacbg").not(".total_inacbg_form").val()));

           var selisih = 0;
           var selisih_bulat = 0;
           var selisih_untungrugi = 0;

           $("#<?php echo CHtml::activeId($model,'selisihuntungrugibpjs');?>").val(formatNumber(0));

           // if ($(".total_inacbg").length == 2) {
           //     var ina_pelayanan = parseFloat(unformatNumber($(".total_inacbg_form").val()));
           //
           //     if (ina_pelayanan < ina_tanggungan) {
           //         $(".total_inacbg").not(".total_inacbg_form").val(formatNumber(ina_pelayanan));
           //         myAlert("Nilai tanggungan lebih tinggi dari nilai pelayanan");
           //         hitungJmlpembayaran();
           //         return false;
           //     } else {
           //
           //         selisih = ina_pelayanan - ina_tanggungan;
           //         selisih_bulat = Math.round(selisih/100) * 100;
           //
           //         // hitung untung rugi
           //         selisih_untungrugi = ina_pelayanan - jmlpembayaran;
           //
           //         $("#<?php //echo CHtml::activeId($model,'totaliurbiaya');?>").val(formatNumber(selisih));
           //         $("#<?php //echo CHtml::activeId($model,'selisihuntungrugibpjs');?>").val(formatNumber(selisih_untungrugi));
           //         $("#pembulatankasir").val(formatNumber(selisih_bulat - selisih));
           //         $("#<?php //echo CHtml::activeId($modTandabukti,'uangditerima');?>").val(formatNumber(selisih_bulat));
           //
           //
           //
           //         hitungPemakaianUangMukaPasien();
           //         cekBayarBank();
           //         hitungUangKembalian();
           //         return false;
           //     }
           // }

           if (carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?> || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA; ?>) {
               asuransi = ina_tanggungan;
               //jmliurbiaya = 0; //jmlpembayaran - (asuransi + rs + pembebasan + uangmuka);
               // selisih_untungrugi = asuransi - jmlpembayaran;

               var selisih_untungrugiBpjs = parseFloat(unformatNumber($("#form-rinciansemua #tot_jmlselisihbpjs_semua").val()));
               //if (jmliurbiaya < 0) {
               //    jmliurbiaya = 0;
               //}

               selisih_bulat = Math.round(jmliurbiaya/100) * 100;
               jmliurbiaya = (jmliurbiaya - selisih_untungrugiBpjs);

               $("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val(formatNumber(jmliurbiaya));
               $("#<?php echo CHtml::activeId($model,'selisihuntungrugibpjs');?>").val(formatNumber(selisih_untungrugiBpjs));
               $("#pembulatankasir").val(formatNumber(selisih_bulat - jmliurbiaya));
               // $("#<?php //echo CHtml::activeId($modTandabukti,'uangditerima');?>").val(formatThousandDecimal(selisih_bulat));
               hitungPemakaianUangMukaPasien();
               cekBayarBank();
               hitungUangKembalian();

               return false;
           }

           var total_terima = 0;


           // jmlpembayaran -= asuransi + pem + rs + jmlpembulatan;



           //if (carabayar_id != <?php //echo Params::CARABAYAR_ID_MEMBAYAR; ?>) {
           total_terima = jmlpembayaran + biayamaterai - (asuransi + rs + pembebasan);
           if (total_terima < 0) total_terima = 0;

           selisih = total_terima;
           selisih_bulat = Math.round(selisih/100) * 100;;

           //} else {
           //    total_terima = jmlpembayaran + biayamaterai - pembebasan;
           //}



           $("#pembulatankasir").val(formatNumber(selisih_bulat - selisih));
           $("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val(formatNumber(selisih_bulat));





           // formatNumberSemua();
           hitungPemakaianUangMukaPasien();
           cekBayarBank();
           hitungUangKembalian();
       }

    function proporsiDiskonSemua(){
        unformatNumberSemua();
        var tot_discount_semua = parseFloat($("#tot_discount_semua").val());
        var tot_tarif_semua = parseFloat($("#tot_tarif_tindakan").val());

        $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
            if($(this).is(":checked")){
                var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
                var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
                var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
                var proporsi = Math.round(((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_discount_semua);
                $(this).parents('tr').find('input[name$="[discount_tindakan]"]').val(proporsi);
            }else{
                $(this).parents('tr').find('input[name$="[discount_tindakan]"]').val(0);
            }
        });
    formatNumberSemua();
    hitungTotalTindakan();
    unformatNumberSemua();
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseInt($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = Math.round(((hargasatuan * qty + tarifcyto)/ tot_tarif_semua) * tot_discount_semua);
            $(this).parents('tr').find('input[name$="[discount]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[discount]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalOa();

    var tot_discount_semua_baru = parseFloat(unformatNumber($("#tot_discount_semua").val()));
    var selisih = tot_discount_semua_baru - tot_discount_semua;

    if (selisih != 0) {
//        var obj_subsidi_oa = $("#form-rincianobatalkes tr input[name$='[discount]']");

//        if (obj_subsidi_oa.length > 0) {
//            obj_subsidi_oa = obj_subsidi_oa.eq(0);
//
//            var nilai_oa = parseFloat(unformatNumber($(obj_subsidi_oa).val()));
//
//            nilai_oa -= selisih;
//            $(obj_subsidi_oa).val(formatNumber(nilai_oa));
//            hitungTotalOa();
//        } else {
            var obj_subsidi = $("#form-rinciantindakan tr input[name$='[discount_tindakan]']");
            if (obj_subsidi.length > 0) {
                obj_subsidi = obj_subsidi.eq(0);

                var nilai_tindakan = parseFloat(unformatNumber($(obj_subsidi).val()));

                nilai_tindakan -= selisih;
                $(obj_subsidi).val(formatNumber(nilai_tindakan));
                hitungTotalTindakan();
            }
//        }
    }

    function setAsuransiKelas() {
        var pendaftaran_id = $('pendaftaran_id').val();
        var carabayar_id = $('carabayar_id').val();
        var penjamin_id = $('penjamin_id').val();
        $.post('<?php echo $this->createUrl('setKelasAsuransi'); ?>', {
            pendaftaran_id: pendaftaran_id,
            carabayar_id: carabayar_id,
            penjamin_id: penjamin_id
        }, function(data) {
            $("#input_subsidi").html(data.row);
            $(".subsidi_asuransi").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
            );

            $(".total_inacbg_form").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
            );

            if (carabayar_id == <?php echo Params::CARABAYAR_ID_ASURANSI; ?>) {
                $("#BKPembayaranpelayananT_totalsubsidirs").prop("readonly", false);
            } else {
                $("#BKPembayaranpelayananT_totalsubsidirs").prop("readonly", true);
            }

            setRincianTindakan(true);
            // setRincianObatalkes();
        }, 'json');
    }

function proporsiSubsidiAsuransiSemua(){
    unformatNumberSemua();
    var tot_subsidiasuransi_semua = parseFloat($("#tot_subsidiasuransi_semua").val());
    var tot_tarif_semua = parseFloat($("#tot_tarif_tindakan").val());

    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_subsidiasuransi_semua);
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalTindakan();

    var tot_subsidiasuransi_semua_baru = parseFloat(unformatNumber($("#tot_subsidiasuransi_semua").val()));
    var selisih = tot_subsidiasuransi_semua_baru - tot_subsidiasuransi_semua;

    if (selisih != 0) {
        var obj_subsidi = $("#form-rinciantindakan tr input[name$='[subsidiasuransi_tindakan]']");
        if (obj_subsidi.length > 0) {
            obj_subsidi = obj_subsidi.eq(0);

            var nilai_tindakan = parseFloat(unformatNumber($(obj_subsidi).val()));

            nilai_tindakan -= selisih;
            $(obj_subsidi).val(formatNumber(nilai_tindakan));
            hitungTotalTindakan();
        }
    }
}

function proporsiSubsidiRsSemua(){
    unformatNumberSemua();
    var tot_subsidirumahsakit_semua = parseFloat($("#tot_subsidirumahsakit_semua").val());
    var tot_tarif_semua = parseFloat($("#tot_tarif_tindakan").val());

    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_subsidirumahsakit_semua);
            $(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalTindakan();

    var tot_subsidirumahsakit_semua_baru = parseFloat(unformatNumber($("#tot_subsidirumahsakit_semua").val()));
    var selisih = tot_subsidirumahsakit_semua_baru - tot_subsidirumahsakit_semua;

    if (selisih != 0) {
        var obj_subsidi = $("#form-rinciantindakan tr input[name$='[subsisidirumahsakit_tindakan]']");
        if (obj_subsidi.length > 0) {
            obj_subsidi = obj_subsidi.eq(0);

            var nilai_tindakan = parseFloat(unformatNumber($(obj_subsidi).val()));

            nilai_tindakan -= selisih;
            $(obj_subsidi).val(formatNumber(nilai_tindakan));
            hitungTotalTindakan();
        }
    }
}

function simpanPembayaranPel(){
  $(".integer2, .float2, .integer-decimal").each(function(){
      $(this).val(unformatNumber($(this).val()));
  });
  $("#bkpembayaranpelayanan-t-form").submit();
}

    $( document ).ready(function(){
        setAsuransiKelas();
    });
}

</script>
