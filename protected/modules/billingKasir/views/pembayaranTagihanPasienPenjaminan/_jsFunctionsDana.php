<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">

var pendaftaran_id = "";
var carabayar_id = "";
var penjamin_id = "";
var carapembayaran = "";

var nilai_admin = 0;
var persen_admin = 0;
var is_load = false;


var total_subsidi_asuransi = 0;

/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id, instalasi_id ){
    $("#form-datakunjungan > div").addClass("animation-loading");

    if (instalasi_id == null) {
        instalasi_id = $("#instalasi_id").val();
    } else {
        $("#instalasi_id").val(instalasi_id);
    }

    carapembayaran = "";
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {instalasi_id:instalasi_id, pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
        dataType: "json",
        success:function(data){
			if (data.notif.ok == 0) {
				myAlert(data.notif.msg);
				$("#form-datakunjungan > div").removeClass("animation-loading");
				return false;
			} else if (data.notif.ok == 9) {
                myConfirm(data.notif.msg, "Peringatan!", function(r) {
                    if (r) {
                        loadTagihanPasien(data);
                    }
                });
                $("#form-datakunjungan > div").removeClass("animation-loading");
                return false;
            }

            $("#tot_inacbg").val(0);
			loadTagihanPasien(data);


        },
        error: function (jqXHR, textStatus, errorThrown) {
            myAlert("Data kunjungan tidak ditemukan !");
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#instalasi_id").focus();
        }
    });

}



function loadTagihanPasien(data) {
    pendaftaran_id = data.pendaftaran_id;
    carabayar_id = data.carabayar_id;
    penjamin_id = data.penjamin_id;

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
    $(".statusperiksa").val(data.statusperiksa);
    $("#kunjungan_statusperiksa").val(data.statusperiksa);
    $("#tindakan_kosong").val(data.jumlah_tindakan);
    if(data.photopasien === null || data.photopasien === ""){ //set photo
        $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    }else{
        $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
    }

    if (data.dokterpenerima != '' || data.dpjp1 != '' || data.dpjp2 != '' || data.dpjp3 != '') {
        if (data.dokterpenerima != '') $("#dokterpenerima").val(data.dokterpenerima);
        if (data.dpjp1 != '') $("#dpjp1").val(data.dpjp1);
        if (data.dpjp2 != '') $("#dpjp2").val(data.dpjp2);
        if (data.dpjp3 != '') $("#dpjp3").val(data.dpjp3);
        $(".dpjp").show();
    } else {
        $(".dpjp").val("").hide();
    }

    if (data.kelastanggungan_id != '') {
        $(".kelastanggungan").show();
        $("#kelastanggungan_nama").val(data.kelastanggungan_nama);
        $(".info_kelastanggungan_id").data('weight', data.kelaspelayanan_nilai);
    } else {
        $(".kelastanggungan").hide();
        $(".info_kelastanggungan_id").data('weight', 0);
    }

    $("#persen_diskon_bayar").val(data.persen_diskon);
    $("#persen_admin").val(data.persen_admin);
    // $("#BKTandabuktibayarT_biayaadministrasi").val(data.nilai_admin);
    // $("#BKTandabuktibayarT_biayaadministrasi").val(data.nilai_admin);


    // insert field pasien berhutang
    // console.log(namadepan);
    if(data.namadepan == null){
        $("#BKPembayaranpelayananT_penanggungjawabhutang").val(data.nama_pasien);
    }else{
        $("#BKPembayaranpelayananT_penanggungjawabhutang").val(data.namadepan + data.nama_pasien);
    }
    
    $("#BKPembayaranpelayananT_noktp_hutang").val(data.no_identitas_pasien);
    $("#BKPembayaranpelayananT_notelp_hutang").val(data.no_mobile);


    nilai_admin = data.nilai_admin;
    persen_admin = data.persen_admin;
    is_load = true;


    //uangmuka
    $("#<?php echo CHtml::activeId($modPemakaianuangmuka, 'totaluangmuka') ?>").val(data.jumlahuangmuka);

    if (data.jumlahuangmuka > 0) {
        $("#<?php echo CHtml::activeId($modPemakaianuangmuka, 'pemakaianuangmuka') ?>").prop("readonly", false).val(data.jumlahuangmuka);
    } else {
        $("#<?php echo CHtml::activeId($modPemakaianuangmuka, 'pemakaianuangmuka') ?>").prop("readonly", true);
    }

    carapembayaran = data.metode_pembayaran;

    setAsuransiKelas();
    setDataPembayar();
    console.log('sebelum penjamin 1: ' + '<?php echo $this->id ?>');
    <?php if($this->id == "pembayaranTagihanPasien" || $this->id == "pembayaranTagihanPasienPenunjang" || $this->id == "alokasiDana"){  ?>
        setMultiPenjamin();
    <?php }?>


    if (data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?> || data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA ?>){
        $(".input_admin_diskon").show();
        $(".input_selisih_bpjs").show();

        if(data.instalasi_id == 4 || data.instalasi_id == 76){
            if(data.kelaspelayanan_id != data.kelastanggungan_id){
                myAlert('Pasien '+data.namadepan+' '+data.nama_pasien+' memiliki kelas tanggungan dan kelas pelayanan yang berbeda !!');
            }
        }
    } else {
        $(".input_admin_diskon").show();
        $(".input_selisih_bpjs").show();
    }

    

    $("#form-datakunjungan > div > div > .judul").html('Data Kunjungan '+data.no_pendaftaran);
    $("#form-datakunjungan > div > div > .tombol").attr('style','display:block;');
    $("#form-datakunjungan > .box").addClass("well").removeClass("box");

    $("#form-datakunjungan > div").removeClass("animation-loading");
    $("#nama_pasien").focus();
}

function resetPencarianRuangan() {
    $("#dialog_pasien_ruangan_id").val("");
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
    $("#form-datakunjungan > div > div > .judul").html('Data Kunjungan');
    $("#form-datakunjungan > div > div >.tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well");

    $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val("");
    $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val("");
    $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val("");

    $(".dpjp").hide().find("input").val("");

    carapembayaran = "";

    setRincianTindakan();
    setRincianObatalkes();
    console.log('sebelum penjamin 2');
    <?php if($this->id == "pembayaranTagihanPasien" || $this->id == "pembayaranTagihanPasienPenunjang" || $this->id == "alokasiDana"){  ?>
        setMultiPenjamin();
    <?php }?>
}


function setAsuransiKelas() {
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
            // $("#BKPembayaranpelayananT_totalsubsidirs").prop("readonly", false);
            $("#BKPembayaranpelayananT_totalsubsidirs").prop("readonly", true);
        } else {
            $("#BKPembayaranpelayananT_totalsubsidirs").prop("readonly", true);
        }
        $('.labelincbgTotal').html(data.labelIncbgTot);
        setRincianTindakan(true);
    }, 'json');
}

/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
// function refreshDialogKunjungan(){
//     var instalasi_id = $("#instalasi_id").val();
//     var instalasi_nama = $("#instalasi_id option:selected").text();
//     $.fn.yiiGridView.update('datakunjungan-grid', {
//         data: {
//             "BKInformasikasirrawatjalanV[instalasi_id]":instalasi_id,
//             "BKInformasikasirrawatjalanV[instalasi_nama]":instalasi_nama,
//         }
//     });
// }

 /**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogKunjungan() {
    var instalasi_id = $("#instalasi_id").val();
    var instalasi_nama = $("#instalasi_id option:selected").text();
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
            "BKInformasikasirrawatjalanV[instalasi_id]": instalasi_id,
            "BKInformasikasirrawatjalanV[instalasi_nama]": instalasi_nama,
        }
    });
}
function loadSelisiBpjsDiv(){
  if ($("#carabayar_id").val() == <?php echo Params::CARABAYAR_ID_BPJS ?> || $("#carabayar_id").val()== <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA ?>){
    $(".selisibpjsClass").show();
      // $(".selisibpjsClass").find('input').each(function(){
      //   $(this).val(0);
      // });
  } else {
      $(".selisibpjsClass").hide();
      $(".selisibpjsClass").find('input').each(function(){
        $(this).val(0);
      });
  }
}
/**
 * set form rincian tagihan tindakan
 * @returns {undefined}
 */
function setRincianTindakan(loaded) {
        var pendaftaran_id = $("#pendaftaran_id").val();
        var pasienadmisi_id = $("#pasienadmisi_id").val();
        var kelaspelayanan_id = $("#kelaspelayanan_id").val();
        var penjamin_id = $("#penjamin_id").val();
        var pasien_id = $("#pasien_id").val();
        var instalasi_id = $("#instalasi_id").val();
        var pembayaranpelayanan_id=$("#<?php echo CHtml::activeId($model,'pembayaranpelayanan_id') ?>").val();
        // console.log(penjamin_id)
        $("#form-rinciantindakan").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetRincianTindakan'); ?>',
            data: {
                pembayaranpelayanan_id:pembayaranpelayanan_id, 
                pendaftaran_id: pendaftaran_id,
                pasienadmisi_id: pasienadmisi_id,
                kelaspelayanan_id: kelaspelayanan_id,
                penjamin_id: penjamin_id,
                pasien_id: pasien_id,
                instalasi_id: instalasi_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#form-rinciantindakan").html(data.form);
                $("#form-rinciantindakan").removeClass("animation-loading");
                $("#form-rinciantindakan .integer2").maskMoney({
                    "symbol": "",
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 0
                });

                $("#form-rinciantindakan").find('input:checkbox[name$="is_proporsitindakan"]').tooltip({
                    "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
                });
                hitungTotalTindakan();
                setProporsiSemua();
                loadSelisiBpjsDiv();

                if (loaded) {
                    hitungMultiPenjamin();
                    setRincianObatalkes();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#form-rinciantindakan").removeClass("animation-loading");
                console.log(errorThrown);
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
    var pembayaranpelayanan_id=$("#<?php echo CHtml::activeId($model,'pembayaranpelayanan_id') ?>").val();
    var instalasi_id = $("#instalasi_id").val();

    $("#form-rincianobatalkes").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetRincianObatalkes'); ?>',
        data: {pembayaranpelayanan_id:pembayaranpelayanan_id, pendaftaran_id:pendaftaran_id,pasienadmisi_id:pasienadmisi_id,kelaspelayanan_id:kelaspelayanan_id,penjamin_id:penjamin_id, pasien_id:pasien_id, instalasi_id:instalasi_id},//
        dataType: "json",
        success:function(data){
            $("#form-rincianobatalkes").html(data.form);
            $("#form-rincianobatalkes").removeClass("animation-loading");
            $("#form-rincianobatalkes .integer2").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
            );
            $("#form-rincianobatalkes .integer-decimal").maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
            );
            $("#form-rincianobatalkes").find('input:checkbox[name$="is_proporsioa"]').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
            if (is_load == true) {
                $("#BKPemakaianuangmukaT_pemakaianuangmuka").val($("#BKPemakaianuangmukaT_totaluangmuka").val());
            }
            hitungTotalOa();
            setProporsiSemua();
            hitungJmlpembayaran();
            is_load = false;
            loadSelisiBpjsDiv();
            hitungMultiPenjamin();
        },
         error: function (jqXHR, textStatus, errorThrown) { $("#form-rincianobatalkes").removeClass("animation-loading");console.log(errorThrown);}
    });
}
/** control accordion menggunakan kartu */
$('#form-kartupembayaran > div > .accordion-heading').click(function(){
//    console.log("Rujukan Di Klik!");

    var iurbiaya = parseFloat(unformatNumber($("#BKPembayaranpelayananT_totaliurbiaya").val()));
    var bulat = parseFloat(unformatNumber($("#pembulatankasir").val()));

    var is_menggunakankartu = $("#<?php echo CHtml::activeId($modTandabukti, "is_menggunakankartu"); ?>");
    if(is_menggunakankartu.val() > 0){ //hide
        is_menggunakankartu.val(0);
        bulat = jmlpembulatan_main;
        $("#pembulatankasir").val(formatNumber(jmlpembulatan_main));
        $("#BKTandabuktibayarT_uangditerima").val(formatInteger(iurbiaya + bulat)).blur();
        $("#BKTandabuktibayarT_bank_nominal").val(0);
    }else{//show
        is_menggunakankartu.val(1);
          cekBayarBank();
        //$("#BKTandabuktibayarT_bank_nominal").val(formatNumber(iurbiaya)).blur();
        //$("#BKTandabuktibayarT_uangditerima").val(0);
    }
    $("#BKTandabuktibayarT_uangkembalian").val(0);
});
/**
 * set checked/unchecked semua is_pilihtindakan
 * @returns {undefined}
 */
function setPilihTindakanChecked(){
    if($("#is_pilihsemuatindakan").is(':checked')){
        $("#form-rinciantindakan").find("input[name$='[is_pilihtindakan]'][type='checkbox']").each(function(){
            $(this).attr('checked',true);
        });
    }else{
        $("#form-rinciantindakan").find("input[name$='[is_pilihtindakan]'][type='checkbox']").each(function(){
            $(this).removeAttr('checked');
        });
    }
    hitungTotalTindakan();
}
/**
 * set checked/unchecked semua is_pilihoa
 * @returns {undefined}
 */
function setPilihOaChecked(){
    if($("#is_pilihsemuaoa").is(':checked')){
        $("#form-rincianobatalkes").find("input[name$='[is_pilihoa]'][type='checkbox']").each(function(){
            $(this).attr('checked',true);
        });
    }else{
        $("#form-rincianobatalkes").find("input[name$='[is_pilihoa]'][type='checkbox']").each(function(){
            $(this).removeAttr('checked');
        });
    }
    hitungTotalOa();
}
/**
 * menghitung total tindakan
 * @returns {undefined}
 */
function hitungTotalTindakan() {
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
        var instalasi_id = $("#instalasi_id").val();
        var carabayar_id = $("#carabayar_id").val();
        var selisih = 0;
        var tot_selisih_bpjs = 0;

        $("#form-rinciantindakan").find("input[name$='[is_pilihtindakan]'][type='checkbox']").each(function() {
            var qty_tindakan = parseFloat($(this).parents('tr').find("input[name$='[qty_tindakan]']").val());
            var tarif_satuan = parseFloat($(this).parents('tr').find("input[name$='[tarif_satuan]']").val());
            var tarifcyto_tindakan = parseFloat($(this).parents('tr').find("input[name$='[tarifcyto_tindakan]']").val());
            var discount_tindakan = parseFloat($(this).parents('tr').find("input[name$='[discount_tindakan]']").val());
            var pembebasan_tindakan = parseFloat($(this).parents('tr').find("input[name$='[pembebasan_tindakan]']").val());
            var subsidiasuransi_tindakan = parseFloat($(this).parents('tr').find("input[name$='[subsidiasuransi_tindakan]']").val());
            var subsisidirumahsakit_tindakan = parseFloat($(this).parents('tr').find("input[name$='[subsisidirumahsakit_tindakan]']").val());
            var subsidipemerintah_tindakan = parseFloat($(this).parents('tr').find("input[name$='[subsidipemerintah_tindakan]']").val());

            // subtotal = (tarif_satuan * qty_tindakan) - discount_tindakan;
            // subtotal = (tarif_satuan * qty_tindakan) - discount_tindakan - pembebasan_tindakan - subsidiasuransi_tindakan;
            // subiurbiaya = subtotal;
            var nilai = ((tarifcyto_tindakan + tarif_satuan) * qty_tindakan);
            subtotal = nilai - discount_tindakan - subsidiasuransi_tindakan - subsisidirumahsakit_tindakan;
            subiurbiaya = subtotal;
            // subiurbiaya = subtotal - subsidiasuransi_tindakan - subsisidirumahsakit_tindakan;
            // subtotal = (tarif_satuan * qty_tindakan)+tarifcyto_tindakan-discount_tindakan;
            // subiurbiaya = subtotal-pembebasan_tindakan-subsidiasuransi_tindakan-subsisidirumahsakit_tindakan - subsidipemerintah_tindakan;
            sisatagihan = ((qty_tindakan * (tarif_satuan + tarifcyto_tindakan)) - discount_tindakan - subsidiasuransi_tindakan - subsisidirumahsakit_tindakan - pembebasan_tindakan - subsidipemerintah_tindakan);

            if ($(this).is(":checked")) {
                $(this).parents('tr').find("input[name$='[subtotal]']").val(subtotal);
                $(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val(subiurbiaya);
                $(this).parents('tr').find("input[name$='[jmlbayar_iurtindakan]']").val(subtotal);
                
                if (carabayar_id == '<?= Params::CARABAYAR_ID_BPJS?>' && (instalasi_id == '<?= Params::INSTALASI_ID_RI ?>' || instalasi_id == '<?= Params::INSTALASI_ID_PERAWATAN_INTENSIF ?>')) {
                    selisih = 0;
                    
                    if (nilai == subiurbiaya) {
                        selisih = 0;
                    } else if (subiurbiaya < nilai) {
                        selisih = subtotal;
                    }

                    $(this).parents('tr').find("input[name$='[jmlselisihbpjs]']").val(selisih);
                }

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
                tot_selisih_bpjs += selisih;
            } else {
                $(this).parents('tr').find("input[name$='[subtotal]']").val(0);
                $(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val(0);
                $(this).parents('tr').find("input[name$='[jmlbayar_iurtindakan]']").val(0);
            }
        });

        if ($("#is_proporsitindakan").is(":checked")) {
            // var tot_discount_tindakan = parseFloat($("#form-rinciantindakan #tot_discount_tindakan").val());
            // var tot_pembebasan_tindakan = parseFloat($("#form-rinciantindakan #tot_pembebasan_tindakan").val());
            // var tot_subsidiasuransi_tindakan = parseFloat($("#form-rinciantindakan #tot_subsidiasuransi_tindakan").val());
            // var tot_subsisidirumahsakit_tindakan = parseFloat($("#form-rinciantindakan #tot_subsisidirumahsakit_tindakan").val());
            var tot_subsidipemerintah_tindakan = parseFloat($("#form-rinciantindakan #tot_subsidipemerintah_tindakan").val());
            // total_tindakan = tot_tarif_tindakan - tot_discount_tindakan;
            // tot_iurbiaya_tindakan = total_tindakan - tot_subsidiasuransi_tindakan - tot_subsisidirumahsakit_tindakan;

            // total_tindakan = tot_tarif_tindakan + tot_tarifcyto_tindakan - tot_discount_tindakan;
            // tot_iurbiaya_tindakan = total_tindakan - tot_pembebasan_tindakan - tot_subsidiasuransi_tindakan - tot_subsisidirumahsakit_tindakan - tot_subsidipemerintah_tindakan;
        } else {



            $("#form-rinciantindakan #tot_subsidipemerintah_tindakan").val(tot_subsidipemerintah_tindakan);

        }
        // $("#form-rinciantindakan #tot_tarif_tindakan").val(total_tindakan);
        $("#form-rinciantindakan #tot_tarif_tindakan").val(tot_tarif_tindakan);
        $("#form-rinciantindakan #tot_tarifcyto_tindakan").val(tot_tarifcyto_tindakan);
        $("#form-rinciantindakan #tot_discount_tindakan").val(tot_discount_tindakan);
        $("#form-rinciantindakan #tot_pembebasan_tindakan").val(tot_pembebasan_tindakan);
        $("#form-rinciantindakan #tot_subsidiasuransi_tindakan").val(tot_subsidiasuransi_tindakan);
        $("#form-rinciantindakan #tot_subsisidirumahsakit_tindakan").val(tot_subsisidirumahsakit_tindakan);
        $("#form-rinciantindakan #tot_iurbiaya_tindakan").val(tot_iurbiaya_tindakan);
        $("#form-rinciantindakan #total_tindakan").val(total_tindakan);
        $("#form-rinciantindakan #tot_jmlselisihbpjs_tindakan").val(tot_selisih_bpjs);

        $("#<?php echo CHtml::activeId($model, 'totalsisatagihan'); ?>").val(tot_sisatagihan);
        formatNumberSemua();

        <?php if($this->id == "pembayaranTagihanPasien"){  ?>
            hitungMultiPenjamin();
        <?php } ?>

        hitungTotalSemua();
        hitungBiayaAdministrasi();
        hitungDiskonBayar();
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
        // var biayaR = parseFloat($(this).parents('tr').find("input[name$='[biayaR]']").val());
        // console.log(biayaR);

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
        // subtotaloa = jmlQty + biayaR - discount - subsidiasuransi - subsidirs;
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
 * menghitung total semua = total tindakan + total obat alkes
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
    var instalasi_id = $("#instalasi_id").val();

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
  if(instalasi_id == <?= Params::INSTALASI_ID_RI?> || instalasi_id == <?= Params::INSTALASI_ID_PI?> || instalasi_id == <?= Params::INSTALASI_ID_PERSALINAN?>){
      var persen = 5;
  }else {
      var persen = 0;
  }

  
    $("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val(Math.round(tot_tarifDiskon_semua));
    $("#<?php echo CHtml::activeId($model,'totalbiayatindakan');?>").val(Math.round(totdiskon_tindakan));
    $("#<?php echo CHtml::activeId($model,'totalbiayaoa');?>").val(Math.round(totdiskon_oa));
    // $("#persen_admin").val(persen);
    // $("#<?php //echo CHtml::activeId($model,'totaldiscount');?>").val(diskon);
    console.log('tot_subsidi_asuransi_global = '+tot_subsidi_asuransi_global);
    $("#persen_admin").val(persen);
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

    var tot_inacbg = parseFloat(unformatNumber($("#tot_inacbg").val()));
    $('.subsidi_asuransi').val(formatNumber(tot_inacbg));
    // $('.total_inacbg_form').val(tot_inacbg);

}
/**
 * menentukan pembulatan
 * @returns {undefined}
 */
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
    /*
    var konfig_pembulatan = 100; //<?php // echo Yii::app()->user->getState('pembulatanharga'); ?>;
    if(konfig_pembulatan > 0){
        jmlpembulatan = konfig_pembulatan - ((totaliurbiaya+biayaadministrasi+biayamaterai-totaldiscount) % konfig_pembulatan);
        if(konfig_pembulatan == jmlpembulatan){
            jmlpembulatan = 0;
        }
    }
    */
    //RSPMC-859
    var konfig_pembulatan = <?php echo Yii::app()->user->getState('pembulatanhargakasir'); ?>;
    // if(konfig_pembulatan > 0 && $("#BKTandabuktibayarT_carapembayaran").val() == 'TUNAI') {
    if(konfig_pembulatan > 0 && totaldibayarpasien > 0) {
        // var nilai_total = totaliurbiaya+biayaadministrasi+biayamaterai-totaldiscount;
        var nilai_total = totaldibayarpasien;
        var nilai_mod = Math.round((nilai_total)/konfig_pembulatan) * konfig_pembulatan;
        jmlpembulatan = nilai_mod - nilai_total;

        // var nilai_mod = nilai_total % konfig_pembulatan;
        // jmlpembulatan = konfig_pembulatan - nilai_mod;

        if(jmlpembulatan > 0){
            jmlpembulatan = parseFloat(jmlpembulatan.toFixed(2));
        }

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
 * menghitung jumlah pembayaran
 * @returns {undefined}
 */
function hitungJmlpembayaran(){
    // unformatNumberSemua();
    var totaliurbiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val()));
    var tagihanpasien = totaliurbiaya;
    var pembebasan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalpembebasan');?>").val()));
    var asuransi = parseFloat(unformatNumber($("#form-rinciansemua #tot_inacbg").val())) + parseFloat(unformatNumber($("#form-rinciansemua #tot_subsidiasuransi_semua").val()));

    // var asuransi = total_subsidi_asuransi; //parseInt(unformatNumber($("#<?php //echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val()));
    var asuransi_old = asuransi;
    var pem = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidipemerintah');?>").val()));
    var rs = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val()));
    var carabayar_id = $("#carabayar_id").val();
    var diskon = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val()));
    var tanggunganpasien_semua = parseFloat(unformatNumber($("#form-rinciansemua #tot_iurbiaya_semua").val()));

    // var pembebasan = parseInt(unformatNumber($("#<?php //echo CHtml::activeId($model,'totalpembebasan');?>").val()));
    // totaliurbiaya -= asuransi + pem + rs;

    var dat_asuransi = {};
    var dat_cnt = 0;

    var biayaadministrasi = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val()));
    var biayamaterai = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'biayamaterai');?>").val()));
    var jmlpembulatan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'jmlpembulatan');?>").val()));

    var jasafarmasi = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'jasapelayanan_farmasi');?>").val()));
    var asuransi = Math.round(asuransi)
    if(isNaN(jasafarmasi)){
        jasafarmasi = 0;
    }

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
    if(isNaN(asuransi)){
        asuransi = 0;
    }

    var uangmuka = parseFloat(unformatNumber($("#BKPemakaianuangmukaT_pemakaianuangmuka").val()));
    
    if(isNaN(uangmuka)){
        uangmuka = 0;
    }

    // var jmlpembayaran = (totaliurbiaya + biayaadministrasi + biayamaterai + jmlpembulatan) - diskon;
    // var jmlpembayaran = (totaliurbiaya + biayaadministrasi + biayamaterai) - diskon + jasafarmasi;
    // var jmlpembayaran = (totaliurbiaya + biayamaterai) + jasafarmasi;
    // var jmlpembayaran = (totaliurbiaya + biayamaterai) + jasafarmasi + biayaadministrasi;
    // var jmlpembayaran = (totaliurbiaya + biayamaterai + jasafarmasi + biayaadministrasi) - pembebasan;
    // var jmlpembayaran = (totaliurbiaya + biayamaterai + jasafarmasi + biayaadministrasi) - (pembebasan-rs-pem)-diskon;
    var jmlpembayaran = (totaliurbiaya + biayamaterai + jasafarmasi + biayaadministrasi) - diskon;
    // console.log(totaliurbiaya , biayamaterai, jasafarmasi, biayaadministrasi)
    // console.log("diskon :"+diskon, "pembebasan:"+pembebasan, "rs:"+rs, "pem:"+pem);
    // var jmlpembayaran = (totaliurbiaya + biayaadministrasi + biayamaterai) - diskon + jasafarmasi;

    // if (carabayar_id == <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>) {
    //     jmlpembayaran = ((jmlpembayaran + biayaadministrasi) - diskon);
    // }
    // uangmuka = Math.round(uangmuka/100) * 100;
    // $("#BKPemakaianuangmukaT_pemakaianuangmuka").val(formatThousandDecimal(uangmuka));


    // if (asuransi > jmlpembayaran) {
    //     asuransi = jmlpembayaran - rs - pembebasan;
    // }
        
    if (carabayar_id != <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?> && dat_cnt == 0) {
        // asuransi = asuransi + biayaadministrasi - diskon;
        // asuransi = asuransi;
        // asuransi = (asuransi + biayaadministrasi) - (pembebasan-diskon-rs-pem);
        asuransi = (asuransi + biayaadministrasi);
        $("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(formatNumber(asuransi));
    }

    // var jmliurbiaya = jmlpembayaran - (asuransi + rs + pembebasan);
    // var jmliurbiaya = (totaliurbiaya - asuransi - pembebasan - tanggunganpasien_semua);
    
    // var jmliurbiaya = ((tanggunganpasien_semua + biayaadministrasi + biayamaterai) - diskon);
    var jmlbayardikurangi = (jmlpembayaran - asuransi - rs);
    
    if(jmlbayardikurangi <= uangmuka){
        uangmuka = jmlbayardikurangi;
        $("#BKPemakaianuangmukaT_pemakaianuangmuka").val(formatNumber(uangmuka));
    }

    // var jmliurbiaya = (jmlpembayaran - asuransi - rs - pembebasan - uangmuka);
    // var jmliurbiaya = (jmlpembayaran - asuransi - rs - uangmuka);
    // console.log("jml:"+jmlpembayaran, "asuransi:"+asuransi, "rs:"+rs, "uang muka:"+uangmuka, "Pembebasan")
    if(carabayar_id == <?php echo Params::CARABAYAR_ID_MEMBAYAR?>){
        var jmliurbiaya = (jmlpembayaran - asuransi - rs - pem - uangmuka - pembebasan);
    }else{
        var jmliurbiaya = (jmlpembayaran - asuransi - rs - pem - uangmuka);
    }

    // var jmliurbiaya = jmlpembayaran;
    /*
    if (jmliurbiaya < 0 && uangmuka > 0) {
        console.log("HITUNG", uangmuka, jmliurbiaya, uangmuka, uangmuka + jmliurbiaya);
        uangmuka = uangmuka + jmliurbiaya;
        jmliurbiaya = 0;

        $("#BKPemakaianuangmukaT_pemakaianuangmuka").val(formatNumber(uangmuka));
    }
    */


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
    //         $(".total_inacbg").not(".total_inacbg_form").val(formatThousandDecimal(ina_pelayanan));
    //         myAlert("Nilai tanggungan lebih tinggi dari nilai pelayanan");
    //         hitungJmlpembayaran();
    //         return false;
    //     } else {
    //
    //         selisih = ina_pelayanan - ina_tanggungan;
    //         selisih_bulat = Math.round(selisih/100) * 100;
    //
    //         // hitung untung rugi
    //         // selisih_untungrugi = ina_pelayanan - jmlpembayaran;
    //         // if($('#instalasi_id').val() == <?php //echo Params::INSTALASI_ID_RI; ?>){
    //         //   selisih_untungrugi = jmlpembayaran - ina_pelayanan - ina_tanggungan - selisih;
    //         // }
    //
    //         $("#<?php //echo CHtml::activeId($model,'totaliurbiaya');?>").val(formatThousandDecimal(selisih));
    //         // $("#<?php //echo CHtml::activeId($model,'selisihuntungrugibpjs');?>").val(formatThousandDecimal(selisih_untungrugi));
    //         $("#pembulatankasir").val(formatThousandDecimal(selisih_bulat - selisih));
    //
    //
    //
    //         if (selisih_bulat < uangmuka) {
    //             uangmuka = selisih_bulat;
    //             $("#<?php //echo CHtml::activeId($modPemakaianuangmuka,'pemakaianuangmuka');?>").val(formatThousandDecimal(uangmuka));
    //         }
    //
    //
    //
    //         $("#<?php //echo CHtml::activeId($modTandabukti,'uangditerima');?>").val(formatThousandDecimal(selisih_bulat - uangmuka));
    //
    //
    //
    //         hitungPemakaianUangMukaPasien();
    //         cekBayarBank();
    //         // hitungUangKembalian();
    //         return false;
    //     }
    // }

    if (carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?> || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA; ?>) {
        asuransi = ina_tanggungan;
        var selisih_untungrugiBpjs = parseFloat(unformatNumber($("#form-rinciansemua #tot_jmlselisihbpjs_semua").val()));
        // jmliurbiaya = 0; //jmlpembayaran - (asuransi + rs + pembebasan + uangmuka);
        // selisih_untungrugi = asuransi - jmlpembayaran;

        //if (jmliurbiaya < 0) {
        //    jmliurbiaya = 0;
        //}

        selisih_bulat = Math.round(jmliurbiaya/100) * 100;

        var konfig_pembulatan_bpjs = <?php echo Yii::app()->user->getState('pembulatanhargakasir'); ?>;
        
        if(konfig_pembulatan_bpjs > 0) {
            var nilai_mod = Math.round((jmliurbiaya)/konfig_pembulatan_bpjs) * konfig_pembulatan_bpjs;
            jmlpembulatan = nilai_mod - jmliurbiaya;

            // var nilai_mod = jmliurbiaya % konfig_pembulatan_bpjs;
            // jmlpembulatan = konfig_pembulatan_bpjs - nilai_mod;

            if(jmlpembulatan > 0){
                jmlpembulatan = parseFloat(jmlpembulatan.toFixed(2));
            }
            if(konfig_pembulatan_bpjs == jmlpembulatan || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?> || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA; ?>){
                jmlpembulatan = 0;
            }
        }


        $("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val(formatNumber(jmliurbiaya));
        $("#<?php echo CHtml::activeId($model,'selisihuntungrugibpjs');?>").val(formatNumber(selisih_untungrugiBpjs));
        $("#pembulatankasir").val(formatNumber(jmlpembulatan));


        // if (selisih_bulat < uangmuka) {
        //     uangmuka = selisih_bulat;
        //     $("#<?php //echo CHtml::activeId($modPemakaianuangmuka,'pemakaianuangmuka');?>").val(formatThousandDecimal(uangmuka));
        // }

        $("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val(formatInteger(jmlpembulatan + jmliurbiaya));

        hitungPemakaianUangMukaPasien();
        cekBayarBank();
        hitungUangKembalian();

        return false;
    }


    var total_terima = jmliurbiaya;

    // jmlpembayaran -= asuransi + pem + rs + jmlpembulatan;

    //if (carabayar_id != <?php //echo Params::CARABAYAR_ID_MEMBAYAR; ?>) {
    // total_terima = jmlpembayaran + biayamaterai - (asuransi + rs + pembebasan);
    if (total_terima < 0) total_terima = 0;

    selisih = total_terima;
    // selisih_bulat = Math.round(selisih/100) * 100;;
    var konfig_pembulatan = <?php echo Yii::app()->user->getState('pembulatanhargakasir'); ?>;
        
    if(konfig_pembulatan > 0) {
        // var nilai_mod = selisih % konfig_pembulatan;
        // jmlpembulatan = konfig_pembulatan - nilai_mod;

        var nilai_mod = Math.round((selisih)/konfig_pembulatan) * konfig_pembulatan;
        jmlpembulatan = nilai_mod - selisih;

        if(jmlpembulatan > 0){
            jmlpembulatan = parseFloat(jmlpembulatan.toFixed(2));
        }
        if(konfig_pembulatan == jmlpembulatan || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?> || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA; ?>){
            jmlpembulatan = 0;
        }
    }

    //} else {
    //    total_terima = jmlpembayaran + biayamaterai - pembebasan;
    //}

    //console.log("SELISIH BULAT AKHIR", selisih_bulat);
    //console.log("UANG MUKA AKHIR", uangmuka);

    // if (selisih_bulat < uangmuka) {
    //     uangmuka = selisih_bulat;
    //     $("#<?php //echo CHtml::activeId($modPemakaianuangmuka,'pemakaianuangmuka');?>").val(formatThousandDecimal(uangmuka));
    // }

    $("#pembulatankasir").val(formatNumber(jmlpembulatan));
    $("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val(formatInteger(jmlpembulatan + selisih));


    // formatNumberSemua();
    hitungPemakaianUangMukaPasien();
    cekBayarBank();
    hitungUangKembalian();
}


function hitungPemakaianUangMukaPasien() {
    var iurbiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val()));
    var total_terima = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val()));
    var uangmuka = parseFloat(unformatNumber($("#BKPemakaianuangmukaT_pemakaianuangmuka").val()));
    var totaluangmuka = parseFloat(unformatNumber($("#BKPemakaianuangmukaT_totaluangmuka").val()));

    if (iurbiaya < 0) return false;

    if (uangmuka > totaluangmuka) {
        // uangmuka = totaluangmuka;
    }

    if (uangmuka < iurbiaya) {
        // iurbiaya -= uangmuka;
    } else {
        // uangmuka = iurbiaya;
        // iurbiaya = 0;
    }

    // total_terima -= uangmuka;
    if (total_terima < 0) total_terima = 0;

    $("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val(formatNumber(iurbiaya));
    $("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val(formatInteger(total_terima));
    $("#BKPemakaianuangmukaT_pemakaianuangmuka").val(formatNumber(uangmuka));
}

function hitungAllJumlahBayarSemua(){
  var uangditerima = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val()));
  var totaliurbiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val()));
  var bank_nominal = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'bank_nominal');?>").val()));
  var totalpembayaran = (uangditerima + bank_nominal);
  var totalAll = 0;

  $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
      if($(this).is(":checked")){
          var subtotal = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[subtotal]"]').val()));
          var jmlbayar = ((subtotal/totaliurbiaya) * (uangditerima + bank_nominal));
          if (jmlbayar > 0){
             jmlbayar = parseFloat(jmlbayar.toFixed(2));
         }
         $(this).parents('tr').find('input[name$="[jmlbayar_iurtindakan]"]').val(formatThousandDecimal(jmlbayar));
         totalAll += jmlbayar;
      }else{
          $(this).parents('tr').find('input[name$="[jmlbayar_iurtindakan]"]').val(formatThousandDecimal(0));
      }
  });

  $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
      if($(this).is(":checked")){
        var subtotal = parseFloat(unformatNumber($(this).parents('tr').find('input[name$="[subtotaloa]"]').val()));
        var jmlbayar = ((subtotal/totaliurbiaya) * (uangditerima + bank_nominal));
        if (jmlbayar > 0){
           jmlbayar = parseFloat(jmlbayar.toFixed(2));
       }
       $(this).parents('tr').find('input[name$="[jmlbayar_oa]"]').val(formatThousandDecimal(jmlbayar));
       totalAll += jmlbayar;
      }else{
          $(this).parents('tr').find('input[name$="[jmlbayar_oa]"]').val(formatThousandDecimal(0));
      }
  });

    var selisih = totalAll - totalpembayaran;

    if (selisih !== 0) {
        var obj_subsidi_oa = $("#form-rincianobatalkes tr input[name$='[jmlbayar_oa]']");

        if (obj_subsidi_oa.length > 0) {
            obj_subsidi_oa = obj_subsidi_oa.eq(0);

            var nilai_oa = parseFloat(unformatNumber($(obj_subsidi_oa).val()));

            nilai_oa -= selisih;
            $(obj_subsidi_oa).val(formatThousandDecimal(nilai_oa));
        } else {
            var obj_subsidi = $("#form-rinciantindakan tr input[name$='[jmlbayar_iurtindakan]']");
            if (obj_subsidi.length > 0) {
                obj_subsidi = obj_subsidi.eq(0);

                var nilai_tindakan = parseFloat(unformatNumber($(obj_subsidi).val()));

                nilai_tindakan -= selisih;
                $(obj_subsidi).val(formatThousandDecimal(nilai_tindakan));
            }
        }
    }
}

function hitungInaKelas(){
  var total_inacbg = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'total_inacbg');?>").val()));
  var total_inakelas = parseFloat(unformatNumber($(".total_inacbg_form").val()));

    var totaltanggunganKelas = (total_inakelas - total_inacbg);
    if (totaltanggunganKelas > 0){
       totaltanggunganKelas = parseFloat(totaltanggunganKelas.toFixed(2));
    }

    $("#tot_iurbiaya_semua").val(formatThousandDecimal(totaltanggunganKelas));
    proporsiTanggunganRsSemua();
}

/**
 * menghitung uang kembalian
 * @returns {undefined}
 */
function hitungUangKembalian(){
    // unformatNumberSemua();

    var is_menggunakankartu = $("#<?php echo CHtml::activeId($modTandabukti, "is_menggunakankartu"); ?>").val();
    var asuransi = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val()));
    var pem = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidipemerintah');?>").val()));
    var rs = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val()));
    var jmlpembulatan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'jmlpembulatan');?>").val()));
    var jmlpembulatan2 = parseFloat(unformatNumber($("#pembulatankasir").val()));

    var totaluangmuka = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modPemakaianuangmuka,'totaluangmuka');?>").val()));
    var pemakaianuangmuka = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modPemakaianuangmuka,'pemakaianuangmuka');?>").val()));
    var uangditerima = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val()));
    var jmlpembayaran = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'jmlpembayaran');?>").val()));
    var totalbiayapelayanan = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val()));
    var totalsubsidiasuransi = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val()));
    var totalsubsidirs = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val()));

    var totaliurbiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val()));
    var bank_nominal = 0;//parseInt(unformatNumber($("#<?php // echo CHtml::activeId($modTandabukti,'bank_nominal');?>").val()));

    $(".main_nominal").each(function() {
        bank_nominal += parseFloat(unformatNumber($(this).val()));
    });
//     var uangmasuk = uangditerima + pemakaianuangmuka;

    // console.log("PAKE KARTU", is_menggunakankartu, bank_nominal, totaliurbiaya);


    if (is_menggunakankartu == 1 && (bank_nominal == totaliurbiaya)) {
        uangditerima = 0;
        jmlpembulatan2 = 0;
    }

    totaliurbiaya += jmlpembulatan2;

    // var uangmasuk = uangditerima + bank_nominal + pemakaianuangmuka; // + jmlpembulatan;
    var uangmasuk = uangditerima + bank_nominal;
    var uangkembalian = uangmasuk - totaliurbiaya;
    var totalsisatagihan = 0;
    var sisauangmuka = 0;
    var nilaiterendah = Math.min(totaluangmuka,totaliurbiaya);

    hitungAllJumlahBayarSemua();
    /*
    if(pemakaianuangmuka > nilaiterendah){ //tidak boleh lebih besar dari jmlpembayaran dan totaluangmuka
        pemakaianuangmuka = nilaiterendah;
        $("#<?php //echo CHtml::activeId($modPemakaianuangmuka,'pemakaianuangmuka');?>").val(formatNumber(pemakaianuangmuka));
        myAlert("Pemakaian uang muka tidak boleh lebih besar dari jumlah harus bayar atau total uang muka!");
        setTimeout(function(){$("#<?php //echo CHtml::activeId($modPemakaianuangmuka,'pemakaianuangmuka');?>").focus();},1000);
    }
    */

    sisauangmuka = totaluangmuka-pemakaianuangmuka;

    if (carapembayaran.trim() !== "") {
        $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val(carapembayaran);

    } else {
        $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_TUNAI; ?>");
//        getCarabayar();
    }

    setEnablePasienBerhutang(false);

   //console.log("HITUNG AKHIR", uangmasuk, totaliurbiaya);

    if((uangmasuk == 0) && totaliurbiaya > 0){
        uangkembalian = 0;
        totalsisatagihan = totaliurbiaya;

        // console.log("Asuransi", totalsubsidiasuransi, totalsubsidirs);

        if((totalsubsidiasuransi+totalsubsidirs) > 0){
            $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_PIUTANG; ?>");
//            getCarabayar();
        }else{
            $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_HUTANG; ?>");
//            getCarabayar();
        }

        setEnablePasienBerhutang(true);
    } else if((uangmasuk) < totaliurbiaya){
        uangkembalian = 0;
        totalsisatagihan = totaliurbiaya - (uangmasuk);
        if((totalsubsidiasuransi+totalsubsidirs) > 0) {
            $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_PIUTANG; ?>");
//            getCarabayar();
        } else {
            $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_CICILAN; ?>");
//            getCarabayar();
        }
        setEnablePasienBerhutang(true);
    }
    /* else if(uangmasuk < jmlpembayaran){
        uangkembalian = 0;
        totalsisatagihan = jmlpembayaran - uangmasuk;
        $("#<?php // echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php // echo Params::CARAPEMBAYARAN_CICILAN; ?>");
    } */
    var totalbayartindakan = 0;
    if(totalbiayapelayanan < uangditerima){
        totalbayartindakan = totalbiayapelayanan;
    }else{
        totalbayartindakan = uangditerima;
    }

    $("#<?php echo CHtml::activeId($model,'totalbayartindakan');?>").val(formatNumber(totalbayartindakan));
    $("#<?php echo CHtml::activeId($modPemakaianuangmuka,'sisauangmuka');?>").val(formatNumber(sisauangmuka));
    $("#<?php echo CHtml::activeId($modTandabukti,'uangkembalian');?>").val(formatNumber(uangkembalian));
    $("#<?php echo CHtml::activeId($model,'totalsisatagihan');?>").val(formatNumber(totalsisatagihan));
    //formatNumberSemua();
    getCarabayar();
}


function setEnablePasienBerhutang(status) {
    if (status == true) {
        $(".panel-berhutang").show().find(":input").prop("disabled", false);
    } else {
        $(".panel-berhutang").hide().find(":input").prop("disabled", true);
    }

    $("#BKPembayaranpelayananT_totalbiayapelayanan").blur();
}

/**
 * set default / otomatis data pembayar
 * @returns {undefined}
 */
function setDataPembayar(){
    var darinama_bkm =
            //$("#no_pendaftaran").val()+"-"+
    $("#no_rekam_medik").val()+" - "+$("#namadepan").val()+" "+$("#nama_pasien").val();
    var alamat_bkm = $("#alamat_pasien").val();
    var sebagaipembayaran_bkm = "BIAYA PELAYANAN RUMAH SAKIT TANGGAL "+($("#tgl_pendaftaran").val());
    //if($("#instalasi_id").val() == <?php //echo Params::INSTALASI_ID_RI; ?>){
    //    sebagaipembayaran_bkm = "BIAYA PELAYANAN RUMAH SAKIT DARI TANGGAL "+($("#tgl_pendaftaran").val())+" SAMPAI DENGAN "+($("#tglselesaiperiksa").val());
    //}
    $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val(darinama_bkm);
    $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val(alamat_bkm);
    $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val(sebagaipembayaran_bkm);
}
/**
 * set proporsi dari total tindakan
 */
function setProporsiTindakan(){
  $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
      if($(this).is(":checked")){
        if ($("#carabayar_id").val() != '<?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>') {
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').removeAttr("readonly");
        }else{
          $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').attr("readonly", true);
        }
      }else{
          $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').attr("readonly", true);
      }
  });

    if($("#is_proporsitindakan").is(":checked")){
        $("#tot_discount_tindakan").removeAttr("readonly");
        $("#tot_pembebasan_tindakan").removeAttr("readonly");
        $("#tot_subsidiasuransi_tindakan").removeAttr("readonly");
        $("#tot_subsisidirumahsakit_tindakan").removeAttr("readonly");
        $("#tot_subsidipemerintah_tindakan").removeAttr("readonly");
    }else{
        $("#tot_discount_tindakan").attr("readonly", true);
        $("#tot_pembebasan_tindakan").attr("readonly", true);
        $("#tot_subsidiasuransi_tindakan").attr("readonly", true);
        $("#tot_subsisidirumahsakit_tindakan").attr("readonly", true);
        $("#tot_subsidipemerintah_tindakan").attr("readonly", true);
        hitungTotalTindakan();
    }
}
/**
 * set proporsi dari total obat alkes
 */
function setProporsiOa(){
  $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
    if($(this).is(":checked")){
      if ($("#carabayar_id").val() != '<?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>') {
          $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').removeAttr("readonly");
      }else{
        $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').attr("readonly", true);
      }
    }else{
        $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').attr("readonly", true);
    }
  });

    if($("#is_proporsioa").is(":checked")){
        $("#tot_discount").removeAttr("readonly");
        $("#tot_biayalain").removeAttr("readonly");
        $("#tot_subsidiasuransi").removeAttr("readonly");
        $("#tot_subsidipemerintah").removeAttr("readonly");
        $("#tot_subsidirs").removeAttr("readonly");
    }else{
        $("#tot_discount").attr("readonly", true);
        $("#tot_biayalain").attr("readonly", true);
        $("#tot_subsidiasuransi").attr("readonly", true);
        $("#tot_subsidipemerintah").attr("readonly", true);
        $("#tot_subsidirs").attr("readonly", true);
        hitungTotalOa();
    }
}
/**
 * set proporsi dari seluruh total (semua)
 */
function setProporsiSemua(){
    if($("#is_proporsisemua").is(":checked")){
        $("#is_proporsitindakan").attr("checked", false);
        setProporsiTindakan();
        $("#is_proporsioa").attr("checked", false);
        setProporsiOa();
        // $("#tot_discount_semua").removeAttr("readonly");
        // $("#tot_subsidiasuransi_semua").removeAttr("readonly");
        $("#tot_subsidirumahsakit_semua").removeAttr("readonly");
        $("#tot_subsidipemerintah_semua").removeAttr("readonly");
        $("#tot_inacbg").removeAttr("readonly");



        if ($("#carabayar_id").val() == '<?php echo Params::CARABAYAR_ID_BPJS; ?>' || $("#carabayar_id").val() == '<?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA; ?>') {
            $("#tot_inacbg").removeAttr("readonly");
            $("#tot_subsidiasuransi_semua").attr("readonly", true);
            $("#tot_iurbiaya_semua").removeAttr("readonly");

        }else if($("#carabayar_id").val() =='<?php echo Params::CARABAYAR_ID_PERUSAHAAN; ?>'){
            $("#tot_inacbg").attr("readonly", true);
            $("#tot_subsidiasuransi_semua").removeAttr("readonly", true);
            $("#tot_iurbiaya_semua").attr("readonly", true);
        }else if($("#carabayar_id").val() == 3){
            $("#tot_inacbg").attr("readonly", true);
            $("#tot_subsidiasuransi_semua").removeAttr("readonly", true);
            $("#tot_iurbiaya_semua").attr("readonly", true);

        } else {
            // $("#tot_inacbg").attr("readonly", true);
            $("#tot_inacbg").removeAttr("readonly");
            $("#tot_subsidiasuransi_semua").attr("readonly", true);
            $("#tot_iurbiaya_semua").attr("readonly", true);
        }
    }else{
        $("#tot_discount_semua").attr("readonly", true);
        $("#tot_subsidiasuransi_semua").attr("readonly", true);
        $("#tot_subsidirumahsakit_semua").attr("readonly", true);
        $("#tot_subsidipemerintah_semua").attr("readonly", true);
	       $("#tot_inacbg").attr("readonly", true);
         $("#tot_iurbiaya_semua").attr("readonly", true);
    }
}

/**
 * menghitung proporsi diskon tindakan
 */
function proporsiDiskonTindakan(){
    unformatNumberSemua();
    var tot_discount_tindakan = parseFloat($("#tot_discount_tindakan").val());
    var tot_tarif_tindakan = parseFloat($("#tot_tarif_tindakan").val());
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = (((tarifsatuan * qty + tarifcyto) / tot_tarif_tindakan) * tot_discount_tindakan);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }
            $(this).parents('tr').find('input[name$="[discount_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[discount_tindakan]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalTindakan();
}
/**
 * menghitung proporsi pembebasan tindakan
 */
function proporsiPembebasanTindakan(){
    unformatNumberSemua();
    var tot_pembebasan_tindakan = parseFloat($("#tot_pembebasan_tindakan").val());
    var tot_tarif_tindakan = parseFloat($("#tot_tarif_tindakan").val());
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = (((tarifsatuan * qty + tarifcyto) / tot_tarif_tindakan) * tot_pembebasan_tindakan);
            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }
            $(this).parents('tr').find('input[name$="[pembebasan_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[pembebasan_tindakan]"]').val(0);
        }
    });
    hitungTotalTindakan();
    formatNumberSemua();
}
/**
 * menghitung proporsi subsidi asuransi tindakan
 */
function proporsiSubsidiAsuransiTindakan(ignore_total){
    unformatNumberSemua();
    var tot_subsidiasuransi_tindakan = parseFloat($("#tot_subsidiasuransi_tindakan").val());
    var tot_tarif_tindakan = parseFloat($("#tot_tarif_tindakan").val());
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = (((tarifsatuan * qty + tarifcyto)/ tot_tarif_tindakan) * tot_subsidiasuransi_tindakan);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(0);
        }
    });
    formatNumberSemua();
    if (ignore_total == null || !ignore_total) {
        hitungTotalTindakan();
    }
}
/**
 * menghitung proporsi subsidi asuransi tindakan
 */
function proporsiSubsidiRsTindakan(ignore_total){
    unformatNumberSemua();
    var tot_subsisidirumahsakit_tindakan = parseFloat($("#tot_subsisidirumahsakit_tindakan").val());
    var tot_tarif_tindakan = parseFloat($("#tot_tarif_tindakan").val());
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = (((tarifsatuan * qty + tarifcyto)/ tot_tarif_tindakan) * tot_subsisidirumahsakit_tindakan);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(0);
        }
    });
    formatNumberSemua();
    if (ignore_total == null || !ignore_total) {
        hitungTotalTindakan();
    }
}

/**
 * menghitung proporsi subsidi pemerintah
 */
function proporsiSubsidiPemerintahTindakan(){
    unformatNumberSemua();
    var tot_subsisidirumahsakit_tindakan = parseFloat($("#tot_subsidipemerintah_tindakan").val());
    var tot_tarif_tindakan = parseFloat($("#tot_tarif_tindakan").val());
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = (((tarifsatuan * qty + tarifcyto)/ tot_tarif_tindakan) * tot_subsisidirumahsakit_tindakan);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalTindakan();
}

/**
 * menghitung proporsi diskon obat alkes
 */
function proporsiDiskonOa(){
    unformatNumberSemua();
    var tot_discount = parseFloat($("#tot_discount").val());
    var tot_hargajual_oa = parseFloat($("#tot_hargajual_oa").val());
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = (((hargasatuan * qty + tarifcyto)/ tot_hargajual_oa) * tot_discount);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[discount]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[discount]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalOa();
}
/**
 * menghitung proporsi biaya admin/lain obat alkes
 */
function proporsiBiayaAdminOa(){
    unformatNumberSemua();
    var tot_biayalain = parseFloat($("#tot_biayalain").val());
    var tot_hargajual_oa = parseFloat($("#tot_hargajual_oa").val());
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = (((hargasatuan * qty + tarifcyto)/ tot_hargajual_oa) * tot_biayalain);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[biayalain]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[biayalain]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalOa();
}
/**
 * menghitung proporsi subsidi asuransi obat alkes
 */
function proporsiSubsidiAsuransiOa(){
    unformatNumberSemua();
    var tot_subsidiasuransi = parseFloat($("#tot_subsidiasuransi").val());
    var tot_hargajual_oa = parseFloat($("#tot_hargajual_oa").val());
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = (((hargasatuan * qty + tarifcyto)/ tot_hargajual_oa) * tot_subsidiasuransi);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalOa();
}
/**
 * menghitung proporsi subsidi rumah sakit obat alkes
 */
function proporsiSubsidiRsOa(){
    unformatNumberSemua();
    var tot_subsidirs = parseFloat($("#tot_subsidirs").val());
    var tot_hargajual_oa = parseFloat($("#tot_hargajual_oa").val());
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = (((hargasatuan * qty + tarifcyto)/ tot_hargajual_oa) * tot_subsidirs);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[subsidirs]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidirs]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalOa();
}

/**
 * menghitung proporsi subsidi pemerintah obat alkes
 */
function proporsiSubsidiPemerintahOa(){
    unformatNumberSemua();
    var tot_subsidirs = parseFloat($("#tot_subsidipemerintah").val());
    var tot_hargajual_oa = parseFloat($("#tot_hargajual_oa").val());
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = (((hargasatuan * qty + tarifcyto)/ tot_hargajual_oa) * tot_subsidirs);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[subsidipemerintah]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidipemerintah]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalOa();
}

/**
 * menghitung proporsi diskon semua
 */
function proporsiDiskonSemua(){
    unformatNumberSemua();
    var tot_discount_semua = parseFloat($("#tot_discount_semua").val());
    var tot_tarif_semua = (parseFloat($("#tot_tarif_tindakan").val()) + parseInt($("#tot_hargajual_oa").val()));

//    if (tot_discount_semua > 100) {
//        tot_discount_semua = 100;
//        $("#tot_discount_semua").val(tot_discount_semua);
//    }


//    var tot_diskon_nominal = tot_tarif_semua * tot_discount_semua / 100;
//
//    tot_discount_semua = tot_diskon_nominal;

    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = (((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_discount_semua);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
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
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = (((hargasatuan * qty + tarifcyto)/ tot_tarif_semua) * tot_discount_semua);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
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
        var obj_subsidi_oa = $("#form-rincianobatalkes tr input[name$='[discount]']");

        if (obj_subsidi_oa.length > 0) {
            obj_subsidi_oa = obj_subsidi_oa.eq(0);

            var nilai_oa = parseFloat(unformatNumber($(obj_subsidi_oa).val()));

            nilai_oa -= selisih;
            $(obj_subsidi_oa).val(formatThousandDecimal(nilai_oa));
            hitungTotalOa();
        } else {
            var obj_subsidi = $("#form-rinciantindakan tr input[name$='[discount_tindakan]']");
            if (obj_subsidi.length > 0) {
                obj_subsidi = obj_subsidi.eq(0);

                var nilai_tindakan = parseFloat(unformatNumber($(obj_subsidi).val()));

                nilai_tindakan -= selisih;
                $(obj_subsidi).val(formatThousandDecimal(nilai_tindakan));
                hitungTotalTindakan();
            }
        }
    }

}

function proporsiInacbgSemua(){
    unformatNumberSemua();
    var tot_tarif_tindakan = 0;
    var tot_hargajual_oa = 0;

    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var discount = parseFloat($(this).parents('tr').find('input[name$="[discount_tindakan]"]').val());
            var pembebasan = parseFloat($(this).parents('tr').find('input[name$="[pembebasan_tindakan]"]').val());
            
            var proporsi = ((tarifsatuan * qty) - discount - pembebasan);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }

            tot_tarif_tindakan += proporsi;
        }
    });
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var discount = parseFloat($(this).parents('tr').find('input[name$="[discount]"]').val());
            
            var proporsi = ((hargasatuan * qty) - discount);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }
           tot_hargajual_oa += proporsi;
        }
    });

    var tot_inacbg = parseFloat($("#tot_inacbg").val());
    var tot_tarif_semua = (tot_tarif_tindakan + tot_hargajual_oa);
    if (tot_tarif_semua > 0){
        tot_tarif_semua = parseFloat(tot_tarif_semua.toFixed(2));
    }
    var totalAll = 0;

    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var discount = parseFloat($(this).parents('tr').find('input[name$="[discount_tindakan]"]').val());
            var pembebasan = parseFloat($(this).parents('tr').find('input[name$="[pembebasan_tindakan]"]').val());

            var proporsi = (((tarifsatuan * qty - discount - pembebasan) / tot_tarif_semua) * tot_inacbg);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }

            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(proporsi);
           totalAll += proporsi;
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(0);
        }
    });
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var discount = parseFloat($(this).parents('tr').find('input[name$="[discount]"]').val());
            
            var proporsi = (((hargasatuan * qty - discount) / tot_tarif_semua) * tot_inacbg);
            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }
            $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val(proporsi);
            totalAll += proporsi;
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val(0);
        }
    });
    var selisih = totalAll - tot_inacbg;
    if (selisih > 0){
        selisih = parseFloat(selisih.toFixed(2));
    }

    if (selisih !== 0) {
        var obj_subsidi_oa = $("#form-rincianobatalkes tr input[name$='[subsidiasuransi]']");

        if (obj_subsidi_oa.length > 0) {
            obj_subsidi_oa = obj_subsidi_oa.eq(0);

            var nilai_oa = parseFloat($(obj_subsidi_oa).val());

            nilai_oa -= selisih;
            $(obj_subsidi_oa).val(nilai_oa);
        } else {
            var obj_subsidi = $("#form-rinciantindakan tr input[name$='[subsidiasuransi_tindakan]']");
            if (obj_subsidi.length > 0) {
                obj_subsidi = obj_subsidi.eq(0);

                var nilai_tindakan = parseFloat($(obj_subsidi).val());

                nilai_tindakan -= selisih;
                $(obj_subsidi).val(nilai_tindakan);
            }
        }
    }
    formatNumberSemua();
    hitungTotalTindakan();
    hitungTotalOa();

}

function proporsiTanggunganRsSemua(){
    unformatNumberSemua();
    var tot_iurbiayasemua = parseFloat($("#tot_iurbiaya_semua").val());
    var tot_tarif_semua = (parseFloat($("#tot_tarif_tindakan").val()) + parseFloat($("#tot_hargajual_oa").val()));
    var tot_inacbg = parseFloat($("#tot_inacbg").val());
    var tot_subsidiasuransi = parseFloat($("#tot_subsidiasuransi_semua").val());
    var tot_inakelas = parseFloat($("#total_inacbg_form").val());

    if(tot_inakelas == undefined || isNaN(tot_inakelas)){
      tot_inakelas = 0;
    }

    var totalIurAll = (tot_tarif_semua - tot_subsidiasuransi - tot_inacbg - tot_inakelas);
    if((totalIurAll - tot_iurbiayasemua) < 0){
      myAlert('Total Tanggungan Pasien tidak boleh melebihi Total Tagihan !!');
      tot_iurbiayasemua = totalIurAll;
    }
    var totalAll = 0;

    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var iurbiaya_tindakan = parseFloat($(this).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val());
            var tarifAsRs = parseFloat($(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val());

            var proporsi = (((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_iurbiayasemua);
            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }
           var tarifTotalDitanggung = ((tarifsatuan * qty) - tarifAsRs - iurbiaya_tindakan);
           if (tarifTotalDitanggung > 0){
              tarifTotalDitanggung = parseFloat(tarifTotalDitanggung.toFixed(2));
            }

            $(this).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(proporsi);
            // $(this).parents('tr').find('input[name$="[iurbiaya_tindakan_temporary]"]').val(tarifTotalDitanggung);
           totalAll += proporsi;
        }else{
            $(this).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(0);
            $(this).parents('tr').find('input[name$="[iurbiaya_tindakan_temporary]"]').val(0);
        }
    });
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var iurbiaya_oa = parseFloat($(this).parents('tr').find('input[name$="[iurbiaya]"]').val());
            var tarifAsRs = parseFloat($(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val());

            var proporsi = (((hargasatuan * qty + tarifcyto) / tot_tarif_semua) * tot_iurbiayasemua);
            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }

           var tarifTotalDitanggung = ((hargasatuan * qty) - tarifAsRs - iurbiaya_oa);
           if (tarifTotalDitanggung > 0){
              tarifTotalDitanggung = parseFloat(tarifTotalDitanggung.toFixed(2));
            }

            $(this).parents('tr').find('input[name$="[iurbiaya]"]').val(proporsi);
            // $(this).parents('tr').find('input[name$="[iurbiaya_temporary]"]').val(tarifTotalDitanggung);
            totalAll += proporsi;
        }else{
            $(this).parents('tr').find('input[name$="[iurbiaya]"]').val(0);
            $(this).parents('tr').find('input[name$="[iurbiaya_temporary]"]').val(0);
        }
    });
    var selisih = totalAll - tot_iurbiayasemua;

    if (selisih !== 0) {
        var obj_subsidi_oa = $("#form-rincianobatalkes tr input[name$='[iurbiaya]']");

        if (obj_subsidi_oa.length > 0) {
            obj_subsidi_oa = obj_subsidi_oa.eq(0);

            var nilai_oa = parseFloat($(obj_subsidi_oa).val());

            nilai_oa -= selisih;
            $(obj_subsidi_oa).val(nilai_oa);
        } else {
            var obj_subsidi = $("#form-rinciantindakan tr input[name$='[iurbiaya_tindakan]']");
            if (obj_subsidi.length > 0) {
                obj_subsidi = obj_subsidi.eq(0);

                var nilai_tindakan = parseFloat($(obj_subsidi).val());

                nilai_tindakan -= selisih;
                $(obj_subsidi).val(nilai_tindakan);
            }
        }
    }
    var tot_iurbiaya_tindakan = 0;
    var tot_jmlselisihbpjs_tindakan = 0;
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
          var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
          var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
          var tarifAsRs = parseFloat($(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val());
          var iurbiaya_tindakan = parseFloat($(this).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val());

          var iurbiaya_tindakan_tempo = parseFloat($(this).parents('tr').find('input[name$="[iurbiaya_tindakan_temporary]"]').val());

            var selisih = ((tarifsatuan * qty) - tarifAsRs - iurbiaya_tindakan);
            if (selisih > 0){
               selisih = parseFloat(selisih.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[jmlselisihbpjs]"]').val(selisih);

            tot_iurbiaya_tindakan += iurbiaya_tindakan;
            tot_jmlselisihbpjs_tindakan += selisih;
        }
    });
    $("#form-rinciantindakan #tot_iurbiaya_tindakan").val(tot_iurbiaya_tindakan);
    $("#form-rinciantindakan #tot_jmlselisihbpjs_tindakan").val(tot_jmlselisihbpjs_tindakan);

    var tot_iurbiaya_oa = 0;
    var tot_jmlselisihbpjs_oa = 0;
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var iurbiaya_oa = parseFloat($(this).parents('tr').find('input[name$="[iurbiaya]"]').val());
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifAsRs = parseFloat($(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val());

            var iurbiaya_oa_tempo = parseFloat($(this).parents('tr').find('input[name$="[iurbiaya_temporary]"]').val());

            var selisih = ((hargasatuan * qty) - tarifAsRs - iurbiaya_oa);
            if (selisih > 0){
               selisih = parseFloat(selisih.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[jmlselisihbpjs]"]').val(selisih);

            tot_iurbiaya_oa += iurbiaya_oa;
            tot_jmlselisihbpjs_oa += selisih;
        }
    });

    $("#form-rincianobatalkes #tot_iurbiaya").val(tot_iurbiaya_oa);
    $("#form-rincianobatalkes #tot_jmlselisihbpjs").val(tot_jmlselisihbpjs_oa);

    var $total_jmlselisihbpjs_semua = (tot_jmlselisihbpjs_tindakan + tot_jmlselisihbpjs_oa);
    $("#form-rinciansemua #tot_jmlselisihbpjs_semua").val($total_jmlselisihbpjs_semua);

    // var $total_jmlselisihbpjs_semua = (tot_iurbiaya_tindakan + tot_iurbiaya_oa);

    formatNumberSemua();
    hitungTotalSemua();
    // hitungTotalTindakan();
    // hitungTotalOa();

}

/**
 * menghitung proporsi subsidi asuransi semua
 */
function proporsiSubsidiAsuransiSemua(){
    unformatNumberSemua();
    var tot_subsidiasuransi_semua = parseFloat($("#tot_subsidiasuransi_semua").val());
    var tot_tarif_semua = parseFloat($("#tot_tarif_semua").val());
    var tot_diskon_semua = parseFloat($("#tot_discount_semua").val());
    var totaltarif_diskon = (tot_tarif_semua - tot_diskon_semua);
    var tot_tarif_semuaAll = (parseFloat($("#tot_tarif_tindakan").val()) + parseInt($("#tot_hargajual_oa").val()));

    if(tot_subsidiasuransi_semua > totaltarif_diskon){
      myAlert('Total Subsidi Asuransi melebihi Total Tagihan');
      tot_subsidiasuransi_semua = totaltarif_diskon;
    }
    // var tot_tarif_semua = (parseFloat($("#tot_tarif_tindakan").val()) + parseInt($("#tot_hargajual_oa").val()));

    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = (((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_subsidiasuransi_semua);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalTindakan();
    unformatNumberSemua();
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = (((hargasatuan * qty + tarifcyto)/ tot_tarif_semua) * tot_subsidiasuransi_semua);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalOa();

    var tot_subsidiasuransi_semua_baru = parseFloat(unformatNumber($("#tot_subsidiasuransi_semua").val()));
    var selisih = tot_subsidiasuransi_semua_baru - tot_subsidiasuransi_semua;

    if (selisih != 0) {
        var obj_subsidi_oa = $("#form-rincianobatalkes tr input[name$='[subsidiasuransi]']");

        if (obj_subsidi_oa.length > 0) {
            obj_subsidi_oa = obj_subsidi_oa.eq(0);

            var nilai_oa = parseFloat(unformatNumber($(obj_subsidi_oa).val()));

            nilai_oa -= selisih;
            $(obj_subsidi_oa).val(formatThousandDecimal(nilai_oa));
            hitungTotalOa();
        } else {
            var obj_subsidi = $("#form-rinciantindakan tr input[name$='[subsidiasuransi_tindakan]']");
            if (obj_subsidi.length > 0) {
                obj_subsidi = obj_subsidi.eq(0);

                var nilai_tindakan = parseFloat(unformatNumber($(obj_subsidi).val()));

                nilai_tindakan -= selisih;
                $(obj_subsidi).val(formatThousandDecimal(nilai_tindakan));
                hitungTotalTindakan();
            }
        }
    }
}
/**
 * menghitung proporsi subsidi rumah sakit semua
 */
function proporsiSubsidiRsSemua(){
    unformatNumberSemua();
    var tot_tarif_tindakan = 0;
    var tot_hargajual_oa = 0;

    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var discount = parseFloat($(this).parents('tr').find('input[name$="[discount_tindakan]"]').val());
            var pembebasan = parseFloat($(this).parents('tr').find('input[name$="[pembebasan_tindakan]"]').val());
            var asuransi = parseFloat($(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val());
            
            var proporsi = ((tarifsatuan * qty) - discount - pembebasan - asuransi);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }

            tot_tarif_tindakan += proporsi;
        }
    });
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var discount = parseFloat($(this).parents('tr').find('input[name$="[discount]"]').val());
            var asuransi = parseFloat($(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val());
            
            var proporsi = ((hargasatuan * qty) - discount - asuransi);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }
           tot_hargajual_oa += proporsi;
        }
    });

    var tot_subsidirumahsakit_semua = parseFloat($("#tot_subsidirumahsakit_semua").val());
    var tot_tarif_semua = (tot_tarif_tindakan + tot_hargajual_oa);
    if (tot_tarif_semua > 0){
        tot_tarif_semua = parseFloat(tot_tarif_semua.toFixed(2));
    }

    var totalAll = 0;

    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var discount = parseFloat($(this).parents('tr').find('input[name$="[discount_tindakan]"]').val());
            var pembebasan = parseFloat($(this).parents('tr').find('input[name$="[pembebasan_tindakan]"]').val());
            var asuransi = parseFloat($(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val());

            var proporsi = ((((tarifsatuan * qty) - discount - pembebasan - asuransi) / tot_tarif_semua) * tot_subsidirumahsakit_semua);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }

            $(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(proporsi);
           totalAll += proporsi;
        }else{
            $(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(0);
        }
    });
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var discount = parseFloat($(this).parents('tr').find('input[name$="[discount]"]').val());
            var asuransi = parseFloat($(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val());

            var proporsi = ((((hargasatuan * qty) - discount - asuransi) / tot_tarif_semua) * tot_subsidirumahsakit_semua);
            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
           }
           
            $(this).parents('tr').find('input[name$="[subsidirs]"]').val(proporsi);
            totalAll += proporsi;
        }else{
            $(this).parents('tr').find('input[name$="[subsidirs]"]').val(0);
        }
    });
    var selisih = totalAll - tot_subsidirumahsakit_semua;
    if (selisih > 0){
        selisih = parseFloat(selisih.toFixed(2));
    }

    if (selisih !== 0) {
        var obj_subsidi_oa = $("#form-rincianobatalkes tr input[name$='[subsidirs]']");

        if (obj_subsidi_oa.length > 0) {
            obj_subsidi_oa = obj_subsidi_oa.eq(0);

            var nilai_oa = parseFloat($(obj_subsidi_oa).val());

            nilai_oa -= selisih;
            $(obj_subsidi_oa).val(nilai_oa);
        } else {
            var obj_subsidi = $("#form-rinciantindakan tr input[name$='[subsisidirumahsakit_tindakan]']");
            if (obj_subsidi.length > 0) {
                obj_subsidi = obj_subsidi.eq(0);

                var nilai_tindakan = parseFloat($(obj_subsidi).val());

                nilai_tindakan -= selisih;
                $(obj_subsidi).val(nilai_tindakan);
            }
        }
    }
    formatNumberSemua();
    hitungTotalTindakan();
    hitungTotalOa();
}

/**
 * menghitung proporsi subsidi pemerintah semua
 */
function proporsiSubsidiPemerintahSemua(){
    unformatNumberSemua();
    var tot_subsidipemerintah_semua = parseFloat($("#tot_subsidipemerintah_semua").val());
    var tot_tarif_semua = (parseFloat($("#tot_tarif_tindakan").val()) + parseFloat($("#tot_hargajual_oa").val()));

    if (tot_subsidipemerintah_semua > 100) {
        tot_subsidipemerintah_semua = 100;
        $("#tot_subsidipemerintah_semua").val(tot_subsidipemerintah_semua);
    }


    var tot_subsidipemerintah_nominal = tot_tarif_semua * tot_subsidipemerintah_semua / 100;

    tot_subsidipemerintah_semua = tot_subsidipemerintah_nominal;


    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = (((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_subsidipemerintah_semua);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalTindakan();
    unformatNumberSemua();
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseFloat($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseFloat($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = (((hargasatuan * qty + tarifcyto)/ tot_tarif_semua) * tot_subsidipemerintah_semua);

            if (proporsi > 0){
               proporsi = parseFloat(proporsi.toFixed(2));
            }
            $(this).parents('tr').find('input[name$="[subsidipemerintah]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidipemerintah]"]').val(0);
        }
    });
    formatNumberSemua();
    hitungTotalOa();
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
    hitungJmlpembayaran();
}

function hitungPersenBiayaAdministrasi() {
    var totalBiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val()));
    var biayaAdmin = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val()));
    var total = parseFloat(biayaAdmin * 100 / totalBiaya);

    $("#persen_admin").val(formatThousandDecimal(total));
    hitungJmlpembayaran();

    // hitungDiskonBayar();
}

function hitungDiskonBayar() {
    var totalBiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val()));
    var persenDiskon = parseFloat(unformatNumber($("#persen_diskon_bayar").val()));

    if(Math.ceil(persenDiskon) > 100){
      myAlert('Keringanan (%) Lebih dari 100%');
      persenDiskon = 0;
      $("#persen_diskon_bayar").val(formatFloat(0));
    }

    var jmldiskon = (totalBiaya * (persenDiskon/100));
    if (jmldiskon > 0){
       jmldiskon = parseFloat(jmldiskon.toFixed(2));
   }

    $("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val(formatNumber(jmldiskon));

    hitungJmlpembayaran();
}

function hitungPersenDiskonBayar() {
  var totalBiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val()));
  var totalDiskon = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val()));

  var diskoPersen = 0;

  diskoPersen =((totalDiskon/totalBiaya)*100);
  if (diskoPersen > 0){
       diskoPersen = parseFloat(diskoPersen.toFixed(2));
   }

   if(Math.ceil(diskoPersen) > 100){
     myAlert('Keringanan (%) Lebih dari 100%');
     diskoPersen = 0;
     $("#persen_diskon_bayar").val(formatThousandDecimal(0));
   }

  $("#persen_diskon_bayar").val(formatThousandDecimal(diskoPersen));
  hitungJmlpembayaran();
}

/**
 * menampilkan form verifikasi
 * @returns {undefined}
 */
function setVerifikasi(){

    var biaya_pasien = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val()));

    var is_ina_nol = false;

    var total_uangmuka = parseFloat(unformatNumber($("#BKPemakaianuangmukaT_totaluangmuka").val()));
    var pemakaian_uangmuka = parseFloat(unformatNumber($("#BKPemakaianuangmukaT_pemakaianuangmuka").val()));

    // console.log("Validasi ", carabayar_id, $("#instalasi_id").val());

    //RSPMC-1068 dikomen karena textbox INA kelas I atau INA kelas II di hide
//    if (carabayar_id == <?php // echo Params::CARABAYAR_ID_BPJS; ?> && $("#instalasi_id").val() == <?php // echo Params::INSTALASI_ID_RI; ?>) {
//        $(".subsidi_bpjs").each(function() {
//            v = parseFloat(unformatNumber($(this).val()));
//            if (v == 0) is_ina_nol = true;
//        });
//
//        if (is_ina_nol) {
//            myAlert("INA BPJS tidak boleh nol.");
//            return false;
//        }
//    }

    if (biaya_pasien < 0) {totalBiaya
        myAlert("Tanggungan Pasien tidak boleh negatif!");
        return false;
    }

    if (!cekIurBiayaNegatif()) {
        myAlert("Iur Biaya pada Rincian Tindakan/Obat Alkes tidak boleh negatif!");
        return false;
    }

//    RSPMC-1068
//    if (!cekHitunganPersentase()) {
//        myAlert("Jumlah persen dan subsidi melebihi Total Pelayanan");
//        return false;
//    }


    if (total_uangmuka > 0 && pemakaian_uangmuka == 0) {
        myConfirm("Uang muka pasien sebesar <nilai uangmuka> tidak dipakai, apakah anda akan melanjutkan ?", "Peringatan", function(r) {
            if (r) {
                setTrueVerifikasi();
            }
        });
    } else {
        setTrueVerifikasi();
    }

    return false;
}

function setTrueVerifikasi() {
    if(requiredCheck($("form"))){
        var pendaftaran_id=$("#pendaftaran_id").val();
        if(pendaftaran_id === ""){
            myAlert("Silahkan cari data kunjungan terlabih dahulu !");
        }else{
          $(".integer2, .float2, .integer-decimal").each(function(){
              $(this).val(unformatNumber($(this).val()));
          });
            $('#dialog-verifikasi').dialog("open");
            $('#dialog-verifikasi > .dialog-content').empty();
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('verifikasi'); ?>',
                data: $("form").serialize(),
                dataType: "json",
                success:function(data){
                    if (data.antri == 1) {
                        myAlert("Belum Ada Transaksi Pemeriksaan Pada Pasien","Perhatian");
                        $('#dialog-verifikasi').dialog("close");
                        return false;
                    }

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
}

function cekIurBiayaNegatif() {
    var is_negatif = false;
    $(".iurbiaya").each(function() {
        var v = parseFloat(unformatNumber($(this).val()));
        $(this).parents("tr").removeClass('yellow');
        if (v < 0) {
            is_negatif = true;
            $(this).parents("tr").addClass('yellow');
        }
    });

    return !is_negatif;
}

function cekHitunganPersentase() {
    var tot_discount_semua = parseFloat(unformatNumber($("#tot_discount_semua").val()));
    var tot_subsidiasuransi_semua = parseFloat(unformatNumber($("#tot_subsidiasuransi_semua").val()));
    var tot_subsidipemerintah_semua = parseFloat(unformatNumber($("#tot_subsidipemerintah_semua").val()));
    var tot_subsidirumahsakit_semua = parseFloat(unformatNumber($("#tot_subsidirumahsakit_semua").val()));

    if ((tot_discount_semua + tot_subsidiasuransi_semua + tot_subsidipemerintah_semua + tot_subsidirumahsakit_semua) > 100) {
        return false;
    }

    return true;
}

/**
 * tombol batal pada dialogbox
 * @param {type} dialog_id
 * @returns {undefined}
 */
function batalDialog(dialog_id){
   myConfirm("Apakah anda yakin akan membatalkan ini?","Perhatian!",function(r){if(r){$('#'+dialog_id).dialog("close");}});
}
/**
 * print rincian belum bayar >> RND-3122
 * @returns {undefined} */
function printRincianBelumBayar(type = undefined)
{
    var instalasi_id = $("#instalasi_id").val();
    var pendaftaran_id = $("#pendaftaran_id").val();
    var pasienadmisi_id = $("#pasienadmisi_id").val();
    if(instalasi_id && pendaftaran_id){
        if(type != undefined && type == 'frame'){
            $('#iframeRincianTagihan').attr('src', "<?php echo $this->createUrl('printRincianBelumBayar') ?>&instalasi_id="+instalasi_id+"&pendaftaran_id="+pendaftaran_id+"&pasienadmisi_id="+pasienadmisi_id+"&frame=true");
            $('#dialogRincianTagihan').dialog('open');        
        }else{
            window.open("<?php echo $this->createUrl('printRincianBelumBayar') ?>&instalasi_id="+instalasi_id+"&pendaftaran_id="+pendaftaran_id+"&pasienadmisi_id="+pasienadmisi_id,"",'location=_new, width=1024px');
        }
    }else{
        myAlert("Silahkan cari data kunjungan terlabih dahulu !");
    }
}
/**
 * print rincian sudah bayar >> RND-3122
 * @returns {undefined} */
function printRincianSudahBayar()
{
    var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id?>";
    window.open("<?php echo $this->createUrl('printRincianSudahBayar2') ?>&pembayaranpelayanan_id="+pembayaranpelayanan_id,"",'location=_new, width=1024px');
}
/**
 * print rincian sudah bayar untuk rumah sakit >> RND-3114
 * @returns {undefined} */
function printRincianRSSudahBayar()
{
    var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id?>";
    window.open("<?php echo $this->createUrl('printRincianRSSudahBayar') ?>&pembayaranpelayanan_id="+pembayaranpelayanan_id,"",'location=_new, width=1024px');
}
/**
 * print bukti kas masuk  (PERLU PENYESUAIAN LAGI)
 * @returns {undefined} */
function printBuktiKasMasuk()
{
    var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id?>";
    //harusnya menggunakan controller yang sama
    window.open("<?php echo $this->createUrl('/billingKasir/daftarPasien/printdetailKasMasuk') ?>&idPembayaran="+pembayaranpelayanan_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
}
/**
 * print bukti kas masuk  (PERLU PENYESUAIAN LAGI)
 * @returns {undefined} */
function printKuitansi()
{
    var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id?>";
    //harusnya menggunakan controller yang sama
    window.open("<?php echo $this->createUrl('printKuitansi') ?>&pembayaranpelayanan_id="+pembayaranpelayanan_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
}


// function formatNumberSemua(){
//     $('.integer2').each(function(){
//         $(this).val(formatNumber($(this).val()));
//     });
// }


function cekBayarBank(obj) {
    var iurbiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val()));
    var pembulatan = parseFloat(unformatNumber($("#pembulatankasir").val()));
    var konfig_pembulatan = <?php echo Yii::app()->user->getState('pembulatanhargakasir'); ?>;
    //var nominal = Math.round(parseFloat(unformatNumber($("#BKTandabuktibayarT_bank_nominal").val())));
    var uangmuka = parseFloat(unformatNumber($("#BKPemakaianuangmukaT_pemakaianuangmuka").val()));
    var nominal = 0; //Math.round(parseFloat(unformatNumber($("#BKTandabuktibayarT_bank_nominal").val()))/100) * 100;
    var nominal_kotor = 0;
    var nominal_non_input = 0;

    $(".main_nominal").each(function() {
        var nilai = parseFloat(unformatNumber($(this).val()));
        nominal += nilai;
    });
    nominal_kotor = nominal;

    if (typeof obj == "undefined" || obj == null) {
        obj = $(".row_main").not(".ada_data").find(".main_nominal").eq(0);
    }

    var nominal_obj = parseFloat(unformatNumber($(obj).val()));

    $(".main_nominal").not(obj).each(function() {
        var nilai = parseFloat(unformatNumber($(this).val()));
        nominal_non_input += nilai;
    });



    var iurbiayaBulat = iurbiaya;
    //var iurbiayaBulat = iurbiaya;

    if (nominal > 0) {
        iurbiayaBulat = iurbiaya;
        pembulatan = 0;
        $("#pembulatankasir").val(formatNumber(pembulatan));
    }

    // console.log('=== pembulatan '+pembulatan);
    // console.log('=== nominal A '+nominal);
    // if (nominal + uangmuka > (iurbiaya)) {
    //     nominal = (iurbiaya) - uangmuka;
    // }



    // if (nominal + uangmuka > (iurbiaya + pembulatan)) {
    //     nominal = (iurbiaya + pembulatan) - uangmuka;
    // }

    if (typeof obj != "undefined" || obj != null) {
        $(obj).val(formatNumber(nominal_obj - (nominal_kotor - nominal)));
    }
    //console.log("NOMINAL BANK", nominal);

    // $("#BKTandabuktibayarT_bank_nominal").val(formatNumber(nominal));

    // iurbiayaBulat -= nominal + uangmuka;
    iurbiayaBulat -= nominal;
        
    if(konfig_pembulatan > 0) {
        var nilai_mod = Math.round((iurbiayaBulat)/konfig_pembulatan) * konfig_pembulatan;
        pembulatan = nilai_mod - iurbiayaBulat;

        // var nilai_mod = iurbiayaBulat % konfig_pembulatan;
        // pembulatan = konfig_pembulatan - nilai_mod;

        if(pembulatan > 0){
            pembulatan = parseFloat(pembulatan.toFixed(2));
        }
        if(konfig_pembulatan == pembulatan || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?> || carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA; ?>){
            pembulatan = 0;
        }
    }

    // var iurbiayaBulat_real = Math.round((iurbiayaBulat)/konfig_pembulatan) * konfig_pembulatan;
    
    
    // pembulatan = iurbiayaBulat_real - iurbiayaBulat;
    $("#pembulatankasir").val(formatNumber(pembulatan));
    
    

//    var tot_inacbg_semua = parseInt(unformatNumber($("#form-rinciansemua #tot_inacbg").val()));
//    if(tot_inacbg_semua > 0){
//        iurbiaya = iurbiaya - tot_inacbg_semua;
//    }
    //$("#pembulatankasir").val(formatNumber(pembulatan));
    // $("#BKTandabuktibayarT_uangditerima").val(formatThousandDecimal(iurbiayaBulat + pembulatan));
    $("#BKTandabuktibayarT_uangditerima").val(formatInteger(iurbiayaBulat + pembulatan));
    
    hitungUangKembalian();
}

function setOtomatisNominal(obj) {
    var total = 0;
    var iurbiaya = parseFloat(unformatNumber($("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val()));
    var uang_terima = parseInt(unformatNumber($("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val()));
    
    // $(obj).val(formatThousandDecimal(iurbiaya));
    $(obj).val(formatThousandDecimal(uang_terima));
    cekBayarBank(obj);
}

function getCarabayar(){
    var carapembayaran =  $('#<?php echo CHtml::activeId($modTandabukti, 'carapembayaran') ?>').val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getCaraPembayaranLookup'); ?>',
        data: {'carapembayaran':carapembayaran},
        dataType: "json",
        success:function(data){
            $('#<?php echo CHtml::activeId($modTandabukti, 'carapembayaran_nama') ?>').val(data.value);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
    });
}

function simpanPembayaranPel(){

    if ($("#instalasi_id").val() == <?php echo Params::INSTALASI_ID_RJ; ?>) {
        //  myConfirm('Anda yakin untuk mengubah status periksa menjadi "<?php echo Params::STATUSPERIKSA_SUDAH_PULANG ?>" ?', "Perhatian", function(r) {
        //      if (r) {
        //          $("#is_ubah_status").val(1);
        //      } else {
                $("#is_ubah_status").val(0);
            //  }

            // return false;

            $(".integer2, .float2, .integer-decimal").each(function(){
                $(this).val(unformatNumber($(this).val()));
            });
            disableOnSubmit($("#btn_submit"));
            $("#bkpembayaranpelayanan-t-form").submit();
        //  });
    } else if ($("#instalasi_id").val() == <?php echo Params::INSTALASI_ID_FARMASI; ?>) {
        //  myConfirm('Anda yakin untuk mengubah status periksa menjadi "<?php echo Params::STATUSPERIKSA_SUDAH_PULANG ?>" ?', "Perhatian", function(r) {
        //      if (r) {
        //          $("#is_ubah_status").val(1);
        //      } else {
                $("#is_ubah_status").val(0);
            //  }
            $(".integer2, .float2, .integer-decimal").each(function(){
                $(this).val(unformatNumber($(this).val()));
            });
            disableOnSubmit($("#btn_submit"));
            $("#bkpembayaranpelayanan-t-form").submit();
        //  });
    }else{
        $(".integer2, .float2, .integer-decimal").each(function(){
                $(this).val(unformatNumber($(this).val()));
        });
        disableOnSubmit($("#btn_submit"));
        $("#bkpembayaranpelayanan-t-form").submit();
    }



}

<?php if($this->id == "pembayaranTagihanPasien" || $this->id == "pembayaranTagihanPasienPenunjang" || $this->id == "alokasiDana"){  ?>

function setMultiPenjamin() {
    var pendaftaran_id = $("#pendaftaran_id").val();
    $('#tabel-multipenjamin > tbody > tr').detach();
    $("#form-multipenjamin").addClass("animation-loading");

    if(pendaftaran_id != ''){
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetMultiPenjamin'); ?>',
            data: {pendaftaran_id: pendaftaran_id}, //
            dataType: "json",
            success: function (data) {
                $('#tabel-multipenjamin > tbody').append(data.form);
                $('#tabel-multipenjamin > tbody tr').each(function() {
                    $(this).find(".jmlpiutangasuransi_multi").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                    );
                });

                renameInputRowulti('#tabel-multipenjamin');
                $('#BKPiutangasuransiT_0_carabayar_id').attr('readonly', true);
                $('#BKPiutangasuransiT_0_penjamin_id').attr('readonly', true);
                if (data.ismembayar) {
                    $('#BKPiutangasuransiT_0_jmlpiutangasuransi').attr('readonly', true);
                }
                $("#form-multipenjamin").removeClass("animation-loading");
                hitungMultiPenjamin();
                
                // setTimeout(function () {
                //     var tot_subsidiasuransi_semua = $("#form-rinciansemua #tot_subsidiasuransi_semua").val();
                //     $('#BKPiutangasuransiT_0_jmlpiutangasuransi').val(tot_subsidiasuransi_semua);
                //     $("#form-multipenjamin").removeClass("animation-loading");
                // }, 2000);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#form-multipenjamin").removeClass("animation-loading");
                console.log(errorThrown);
            }
        });
    }
}

function hitungMultiPenjamin() {
    unformatNumberSemua();

    var iur_biaya_tindakan = 0;
    var iur_biaya_oa = 0;

    $("#form-multipenjamin").find("tbody > tr").each(function () {
        var totalpenjamin = 0;
        var penjamin_id = $(this).find("select[name$='[penjamin_id]']").val();
        var objpenjamin = $(this).find("input[name$='[jmlpiutangasuransi]']");
        var totaltindakan = 0;
        var totaloa = 0;

        iur_biaya_tindakan = 0;
        iur_biaya_oa = 0;
        
        $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
            if($(this).is(":checked")){
                iur_biaya_tindakan += parseFloat($(this).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val());
                var tarif = parseFloat($(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val());
                if($(this).parents('tr').find('select[name$="[penjamin_id]"]').val() == <?php echo Params::PENJAMIN_ID_UMUM; ?>){
                    tarif = parseFloat($(this).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val());
                }
                
                
                if (penjamin_id == $(this).parents('tr').find('select[name$="[penjamin_id]"]').val()) {
                    totalpenjamin += tarif;
                    // var total = parseFloat($(objpenjamin).val());
                    // total = (total + tarif);
                    $(objpenjamin).val(totalpenjamin);
                    
                    totaltindakan += tarif;
                }
            }
        });

        $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
            if($(this).is(":checked")){
                iur_biaya_oa += parseFloat($(this).parents('tr').find('input[name$="[iurbiaya]"]').val());
                var tarif = parseFloat($(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val());
                if($(this).parents('tr').find('select[name$="[penjamin_id]"]').val() == <?php echo Params::PENJAMIN_ID_UMUM; ?>){
                    tarif = parseFloat($(this).parents('tr').find('input[name$="[iurbiaya]"]').val());
                }
                
                if (penjamin_id == $(this).parents('tr').find('select[name$="[penjamin_id]"]').val()) {
                    totalpenjamin = totalpenjamin + tarif;
                    // var total = parseFloat($(objpenjamin).val());
                    // total = (total + tarif);
                    $(objpenjamin).val(totalpenjamin);
                    totaloa += tarif;
                }
            }
        });

        $(this).find("input[name$='[jmltindakanasuransi]']").val(totaltindakan);
        $(this).find("input[name$='[jmloaasuransi]']").val(totaloa);
    });

    console.log("Iur Biaya", iur_biaya_tindakan, iur_biaya_oa);

    $("#form-multipenjamin").find("tbody > tr").each(function () {
        var penjamin_id = $(this).find("select[name$='[penjamin_id]']").val();
        var objpenjamin = $(this).find("input[name$='[jmlpiutangasuransi]']");
        if (penjamin_id == <?php echo Params::PENJAMIN_ID_UMUM; ?>) {
            $(this).find("input[name$='[jmltindakanasuransi]']").val(iur_biaya_tindakan);
            $(this).find("input[name$='[jmloaasuransi]']").val(iur_biaya_oa);
            $(objpenjamin).val(iur_biaya_tindakan + iur_biaya_oa);
        }
    });

    
    formatNumberSemua();
}

function addRowPenjamin(obj)
{
    <?php if ($this->id == "alokasiDana"): ?>
    var trPenjamin = new String(<?php echo CJSON::encode($this->renderPartial('billingKasir.views.pembayaranTagihanPasien._rowsMultiPenjaminDana', array(
        'modPiutangAsuransi' => $modPiutangAsuransi), true)); ?>);
    <?php else: ?>
    var trPenjamin = new String(<?php echo CJSON::encode($this->renderPartial('billingKasir.views.pembayaranTagihanPasien._rowsMultiPenjamin', array(
        'modPiutangAsuransi' => $modPiutangAsuransi), true)); ?>);
    <?php endif; ?>
    $(obj).parents('table').children('tbody').append(trPenjamin.replace());
    var last = $(obj).parents('table').last();

    $(last).find(".jmlpiutangasuransi_multi").maskMoney(
        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
    );

    renameInputRowulti('#tabel-multipenjamin');
}

function batalRowPenjamin(obj) {
    $(obj).parents('tr').addClass("animation-loading-1");
    setTimeout(function () {
        $(obj).parents('tr').detach();
        renameInputRowulti('#tabel-multipenjamin');

        setDropDownPenjaminOnList();
        $(obj).parents('tr').removeClass("animation-loading-1");
    }, 500);
}

function renameInputRowulti(obj_table) {
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

function setDropDownPenjamin(obj)
{
    var i = obj.id.replace("BKPiutangasuransiT_", "").replace("_carabayar_id", "");
    var carabayar_id = obj.value;

    if(carabayar_id != ''){
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownPenjamin'); ?>',
            data: {carabayar_id: carabayar_id},
            dataType: "json",
            success: function (data) {
                $("#BKPiutangasuransiT_" + i + "_penjamin_id").html(data.listPenjamin);
                hitungMultiPenjamin();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
}

function setDropDownPenjaminOnList() {
    var trmultipenjamin = $('#tabel-multipenjamin > tbody > tr').length;
    var arr_penjamin_id = [];
    for (ii = 0; ii < trmultipenjamin; ii++) {
        var multipenjamin_id = $('#BKPiutangasuransiT_' + ii + '_penjamin_id').val();
        arr_penjamin_id.push(multipenjamin_id);
    }
    var penjamin_id = <?= !empty($modKunjungan->penjamin_id) ? $modKunjungan->penjamin_id : 'null'; ?>;
    var total = $('#BKPembayaranpelayananT_totalbiayapelayanan').val();

    if(penjamin_id != '' && arr_penjamin_id.length !== 0){
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropDownPenjaminOnList'); ?>',
            data: {penjamin_id: penjamin_id, arr_penjamin_id: arr_penjamin_id},
            dataType: "json",
            success: function (data) {
                $("#form-rinciantindakan").find("tbody > tr").each(function () {
                    var penjamintemp_id = $(this).find("select[name$='[penjamin_id]']").val();
                    $(this).find("select[name$='[penjamin_id]']").html(data.listPenjamin);
                    $(this).find("select[name$='[penjamin_id]']").val(penjamintemp_id);
                    var classname = $(this).find("select[name$='[penjamin_id]']").prop("class");
                    $(this).find("select[name$='[penjamin_id]']").removeClass(classname);
                    $(this).find("select[name$='[penjamin_id]']").addClass('penjamin_' + penjamintemp_id + ' penjamin_tindakan');
                    
                });

                $("#form-rincianobatalkes").find("tbody > tr").each(function () {
                    var penjamintemp_id = $(this).find("select[name$='[penjamin_id]']").val();
                    $(this).find("select[name$='[penjamin_id]']").html(data.listPenjamin);
                    $(this).find("select[name$='[penjamin_id]']").val(penjamintemp_id);
                    var classname = $(this).find("select[name$='[penjamin_id]']").prop("class");
                    $(this).find("select[name$='[penjamin_id]']").removeClass(classname);
                    $(this).find("select[name$='[penjamin_id]']").addClass('penjamin_' + penjamintemp_id + ' penjamin_oa');
                });

                // $("#form-multipenjamin").find("tbody > tr").each(function () {
                //     var penjamintemp_id = $(this).find("select[name$='[penjamin_id]']").val();
                //     if (($(this).find("select[name$='[penjamin_id]']").val() == penjamintemp_id) && (penjamintemp_id != <?php echo Params::PENJAMIN_ID_UMUM; ?>)) {
                //         $(this).find("input[name$='[jmlpiutangasuransi]']").val(total);
                //     } else {
                //         $(this).find("input[name$='[jmlpiutangasuransi]']").val(0);
                //     }
                // });
                hitungMultiPenjamin();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
}
<?php } ?>
/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(isset($modKunjungan->pendaftaran_id)){ ?>
            var pendaftaran_id = $("#pendaftaran_id").val();
            var pasienadmisi_id = $("#pasienadmisi_id").val();
            setKunjungan(pendaftaran_id,"","",pasienadmisi_id);
            $("#form-datakunjungan :input").attr("readonly",true);
            $("#form-datakunjungan .add-on").remove();
    <?php } ?>
    <?php if(!empty($_GET['sukses'])){ ?>
                $("input, select, textarea").attr("disabled",true);
                window.scrollBy(0,10000);
                formatNumberSemua();
    <?php } else {?>
            hitungTotalSemua();
    <?php }?>

    // Notifikasi Pasien
    <?php
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $model->pasien->nama_pasien; ?> tidak memiliki nomor mobile'};
        insert_notifikasi(params);
    <?php
            }
        }
    ?>

    <?php
        if(isset($model->pembayaranpelayanan_id)){
            if(isset($modKunjungan->nama_pasien)){
    ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_KEUANGAN ?>, judulnotifikasi:'Pembayaran Tagihan', isinotifikasi:'Telah dibayarkan tagihan atas nama <?php echo $modKunjungan->nama_pasien ?>  dengan  <?php echo $modKunjungan->no_rekam_medik ?>  pada <?php echo $model->tglpembayaran ?>'};
            insert_notifikasi(params);
    <?php
            }
        }
    ?>

    <?php
        if(isset($model->pembayaranpelayanan_id)){
            if(isset($modPenjualan->nama_pasien)){
    ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_KEUANGAN ?>, judulnotifikasi:'Pembayaran Penjualan Apotek', isinotifikasi:' Telah dilakukan pembayaran atas penjualan resep pada <?php echo $model->tglpembayaran ?>'};
            insert_notifikasi(params);
    <?php
            }
        }
    ?>
});

function setAsuransiKelas() {
        var pendaftaran_id = $("#pendaftaran_id").val();
        var carabayar_id = $("#carabayar_id").val();
        var penjamin_id = $("#penjamin_id").val();

        console.log("asuransi "+penjamin_id, pendaftaran_id, carabayar_id);

        $.post('<?php echo $this->createUrl('setKelasAsuransi'); ?>', {
            pendaftaran_id: pendaftaran_id,
            carabayar_id: carabayar_id,
            penjamin_id: penjamin_id
        }, function(data) {
            $("#input_subsidi").html(data.row);
            $(".subsidi_asuransi").maskMoney({
                "symbol": "",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ",",
                "thousands": ".",
                "precision": 0
            });

            $(".total_inacbg_form").maskMoney({
                "symbol": "",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ",",
                "thousands": ".",
                "precision": 0
            });

            if (carabayar_id == <?php echo Params::CARABAYAR_ID_ASURANSI; ?>) {
                $("#BKPembayaranpelayananT_totalsubsidirs").prop("readonly", false);
            } else {
                $("#BKPembayaranpelayananT_totalsubsidirs").prop("readonly", true);
            }
            $('.labelincbgTotal').html(data.labelIncbgTot);
            setRincianTindakan(true);
        }, 'json');
    }

    const refresh_tagihan = (jenis) => {
        unformatNumberSemua();

        $("#form-rinciantindakan").addClass("animation-loading");
        $("#form-rincianobatalkes").addClass("animation-loading");

        $("#form-rinciantindakan").find("input[name$='[is_pilihtindakan]'][type='checkbox']").each(function() {
            var qty = parseFloat($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseFloat($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var jml = qty * tarifsatuan;
            var subsidiasuransi_tindakan = parseFloat($(this).parents('tr').find("input[name$='[subsidiasuransi_tindakan]']").val());
            var iurbiaya_tindakan = parseFloat($(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val());

            if (jenis == "umum") {
                $(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val(jml);
                $(this).parents('tr').find("input[name$='[subsidiasuransi_tindakan]']").val(0);
                $(this).parents('tr').find("input[name$='[jmlselisihbpjs]']").val(0);
            } else {
                $(this).parents('tr').find("input[name$='[subsidiasuransi_tindakan]']").val(jml);
                $(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val(0);
            }

        });

        $("#form-rincianobatalkes").find("input[name$='[is_pilihoa]'][type='checkbox']").each(function() {
            var qty_oa = parseFloat($(this).parents('tr').find("input[name$='[qty_oa]']").val());
            var hargasatuan_oa = parseFloat($(this).parents('tr').find("input[name$='[hargasatuan_oa]']").val());
            var jml = qty_oa * hargasatuan_oa;
            var subsidiasuransi = parseFloat($(this).parents('tr').find("input[name$='[subsidiasuransi]']").val());
            var iurbiaya = parseFloat($(this).parents('tr').find("input[name$='[iurbiaya]']").val());

            if (jenis == "umum") {
                $(this).parents('tr').find("input[name$='[iurbiaya]']").val(jml);
                $(this).parents('tr').find("input[name$='[subsidiasuransi]']").val(0);
                $(this).parents('tr').find("input[name$='[jmlselisihbpjs]']").val(0);
            } else {
                $(this).parents('tr').find("input[name$='[subsidiasuransi]']").val(jml);
                $(this).parents('tr').find("input[name$='[iurbiaya]']").val(0);
            }

        });

        formatNumberSemua();
        hitungTotalTindakan();
        hitungTotalOa();

        $("#form-rinciantindakan").removeClass("animation-loading");
        $("#form-rincianobatalkes").removeClass("animation-loading");
    }

    function printRincianGabung(caraPrint) {
        var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id ?>";
        window.open("<?php echo $this->createUrl('cetakGabung') ?>&pembayaranpelayanan_id=" + pembayaranpelayanan_id + "&caraPrint=" + caraPrint, "", 'location=_new, width=1024px');
    }


function setProporsionalMultiPenjaminDana() {

    unformatNumberSemua();

    const penjamin_id_umum = <?php echo Params::PENJAMIN_ID_UMUM; ?>;

    // hitung total berdasarkan baris yang di-ceklis
    // kemudian set penjamin jadi umum
    var total_semua = 0;
    $("#form-rinciantindakan tbody tr").each(function() {

        var tarif = parseFloat($(this).find(".tarif_kotor").val());
        $(this).find(".penjamin_tindakan")
            .attr('data-is_set', 0)
            .val(penjamin_id_umum);
        $(this).find(".subsidiasuransi_tindakan").val(0);

        if ($(this).find(".pilih_tindakan").is(":checked")) {
            total_semua += tarif;
        }
    });
    $("#form-rincianobatalkes tbody tr").each(function() {
        
        var tarif = parseFloat($(this).find(".tarif_kotor").val());
        $(this).find(".penjamin_oa")
            .attr('data-is_set', 0)
            .val(penjamin_id_umum);
        $(this).find(".subsidiasuransi_oa").val(0);

        if ($(this).find(".pilih_oa").is(":checked")) {
            total_semua += tarif;
        }
    });



    // menentukan hitungan penjamin
    var total_umum = total_semua;
    var is_ada_umum = false;
    $("#tabel-multipenjamin tbody tr").each(function() {

        var total_penjamin = $(this).find(".jmlpiutangasuransi_multi").val();

        if ($(this).find(".penjamin_id_multi").val() != penjamin_id_umum) {
            if (total_penjamin < total_umum) {
                total_umum -= total_penjamin;
            } else {
                total_penjamin = total_umum;
                total_umum = 0;

                $(this).find(".jmlpiutangasuransi_multi").val(total_penjamin);
            }
        } else {
            is_ada_umum = true;
        }
    });

    // jika tidak ada penjamin umum sedangkan sisa nilai umum-nya ada, maka akan di-set di baris terakhir
    if (!is_ada_umum) {
        var row_akhir = $("#tabel-multipenjamin tbody tr").last();
        var nilai_penjamin_akhir = $(row_akhir).find(".jmlpiutangasuransi_multi").val() + total_umum;

        $(row_akhir).find(".jmlpiutangasuransi_multi").val(nilai_penjamin_akhir);
    } else {
        $("#tabel-multipenjamin tbody tr").each(function() {
            if ($(this).find(".penjamin_id_multi").val() == penjamin_id_umum) {
                $(this).find(".jmlpiutangasuransi_multi").val(total_umum);
            }
        });
    }

    // set mappingan proposional penjamin
    var total_semua_sisa = total_semua;
    $("#tabel-multipenjamin tbody tr").each(function() {

        var penjamin_id = $(this).find(".penjamin_id_multi").val();
        var jumlah = $(this).find(".jmlpiutangasuransi_multi").val();

        // hanya untuk penjamin selain umum yang di-set
        if (penjamin_id != penjamin_id_umum) {

            // tindakan yang di-ceklis
            $("#form-rinciantindakan tbody tr").each(function() {

                var tarif = parseFloat($(this).find(".tarif_kotor").val());

                if (
                    $(this).find(".pilih_tindakan").is(":checked")
                    && $(this).find(".penjamin_tindakan").data('is_set') == 0 
                    && jumlah != 0
                ) {
                    if (tarif < jumlah) {
                        $(this).find(".penjamin_tindakan")
                            .attr('data-is_set', 1)
                            .val(penjamin_id);
                        $(this).find(".subsidiasuransi_tindakan").val(tarif);
                        jumlah -= tarif;
                    } else {
                        $(this).find(".penjamin_tindakan").val(penjamin_id);
                        $(this).find(".subsidiasuransi_tindakan").val(jumlah);
                        jumlah = 0;
                    }
                } 

            });

            // obat yang di-ceklis
            $("#form-rincianobatalkes tbody tr").each(function() {

                var tarif = parseFloat($(this).find(".tarif_kotor").val());

                if (
                    $(this).find(".pilih_oa").is(":checked")
                    && $(this).find(".penjamin_oa").data('is_set') == 0  
                    && jumlah != 0
                ) {
                    $(this).find(".penjamin_oa")
                        .attr('data-is_set', 1)
                        .val(penjamin_id);
                    $(this).find(".subsidiasuransi_oa").val(tarif);
                    jumlah -= tarif;
                } else {
                    $(this).find(".penjamin_oa")
                        .attr('data-is_set', 1)
                        .val(penjamin_id);
                    $(this).find(".subsidiasuransi_oa").val(jumlah);
                    jumlah = 0;
                }

            });

        }


    });







    /*
    $("#tabel-multipenjamin tbody tr").each(function() {
        var penjamin_id = $(this).find(".penjamin_id_multi").val();
        var jumlah = $(this).find(".jmlpiutangasuransi_multi").val();

        var total_tindakan = 0;
        var total_oa = 0;

        $("#form-rinciantindakan tbody tr").each(function() {
            if ($(this).find(".penjamin_tindakan").val() == penjamin_id && $(this).find(".pilih_tindakan").is(":checked")) {
                total_tindakan += parseFloat($(this).find(".tarif_kotor").val());
            }
        });
        $("#form-rincianobatalkes tbody tr").each(function() {
            if ($(this).find(".penjamin_oa").val() == penjamin_id && $(this).find(".pilih_oa").is(":checked")) {
                total_oa += parseFloat($(this).find(".tarif_kotor").val());
            }
        });

        console.log("Total Tindakan", total_tindakan);
        console.log("Total OA", total_oa);


        $("#form-rinciantindakan tbody tr").each(function() {

            if ($(this).find(".pilih_tindakan").is(":checked")) {

                var tarif = parseFloat($(this).find(".tarif_kotor").val());
                console.log("HITUNG", tarif, jumlah, total_tindakan + total_oa);

                var tarif_distribusi = tarif * jumlah / (total_tindakan + total_oa);


                if ($(this).find(".penjamin_tindakan").val() == penjamin_id) {


                    if (penjamin_id == <?php echo Params::PENJAMIN_ID_UMUM ?>) {
                        $(this).find(".subsidiasuransi_tindakan").val(0);
                    } else {
                        $(this).find(".subsidiasuransi_tindakan").val(tarif_distribusi);
                    }
                }
            }
        });

        $("#form-rincianobatalkes tbody tr").each(function() {

            if ($(this).find(".pilih_oa").is(":checked")) {

                var tarif = parseFloat($(this).find(".tarif_kotor").val());
                if ($(this).find(".penjamin_oa").val() == penjamin_id) {

                    var tarif_distribusi = tarif * jumlah / (total_tindakan + total_oa);

                    if (penjamin_id == <?php echo Params::PENJAMIN_ID_UMUM ?>) {
                        $(this).find(".subsidiasuransi_oa").val(0);
                    } else {
                        $(this).find(".subsidiasuransi_oa").val(tarif_distribusi);
                    }
                }
            }
        });
    });
    */

    formatNumberSemua();
    hitungTotalTindakan();
    hitungTotalOa();
    hitungMultiPenjamin();
}
</script>