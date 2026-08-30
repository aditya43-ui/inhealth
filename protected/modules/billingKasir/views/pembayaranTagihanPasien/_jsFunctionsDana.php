<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">

const INSTALASI_ID_RI = <?php echo Params::INSTALASI_ID_RI; ?>;
const INSTALASI_ID_ICU = <?php echo Params::INSTALASI_ID_ICU; ?>;
const CARABAYAR_ID_BPJS = <?php echo Params::CARABAYAR_ID_BPJS; ?>;
const CARABAYAR_ID_MEMBAYAR = <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>;
const KELASPELAYANAN_ID_KELAS_III = <?php echo Params::KELASPELAYANAN_ID_KELAS_III; ?>;
const KELASPELAYANAN_ID_KELAS_VIP = <?php echo Params::KELASPELAYANAN_ID_KELAS_III; ?>;
const KELASPELAYANAN_ID_VIP = <?php echo Params::KELASPELAYANAN_ID_VIP; ?>;
const KELASPELAYANAN_ID_VVIP = <?php echo Params::KELASPELAYANAN_ID_VVIP; ?>;
const instalasi_ri = [INSTALASI_ID_RI, INSTALASI_ID_ICU, 79, 38, 14, 85, 100];

var pendaftaran_id = "";
var carabayar_id = "";
var penjamin_id = "";
var carapembayaran = "";

var nilai_admin = 0;
var persen_admin = 0;
var is_load = false;
var max_penjamin = 5; // MAX PENJAMIN


var total_subsidi_asuransi = 0;
var total_subsidi_bpjs = 0;

var is_naikkelas = false;


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
        if ($.inArray(instalasi_id, instalasi_ri) != -1) {
            $("#instalasi_id").val(INSTALASI_ID_RI);
        } else {
            $("#instalasi_id").val(instalasi_id);
        }
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

            if(data.instalasi_id == INSTALASI_ID_RI && data.pasiennaikkelas == 1) {
                $('#checkBoxNaikKelas').attr('checked', true);
                $('.body_naikkelas').removeClass('hide');
            }

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

function setIurBiaya() {
    var kelasperawatan = parseFloat(unformatNumber($('.form_naik_kelas .kelasperawatan').val()));
    var kelastanggungan = parseFloat(unformatNumber($('.form_naik_kelas .kelastanggungan').val()));

    console.log(kelasperawatan, kelastanggungan, 'cek ini')
    var persentase = Math.abs((kelasperawatan - kelastanggungan) * 100 / kelastanggungan);

    
    if (persentase >= 75) {
        myAlert("Persentase tidak boleh melebihi 75%");
        $('.form_naik_kelas .kelasperawatan').val(formatThousandDecimal(kelastanggungan));
        setIurBiaya();
        return false;
    }

    var idx_tagihan = null;
    var cnt = 0;
    $("#tabel-multipenjamin tbody tr").each(function() {
        if ($(this).find(".multi_carabayar_id").val() == CARABAYAR_ID_BPJS) {
            idx_tagihan = cnt;
        }
        cnt++;
    });


    
    // ================ Total Tagihan ====================
    var total_tagihan = parseFloat(unformatNumber($("#tot_tarif_semua").val()));
    var iurbayar = total_tagihan * persentase / 100;
    //if (idx_tagihan != null) {
    //    var total_tindakan = parseFloat(unformatNumber($(".total_subsidiasuransi_tindakan").eq(idx_tagihan).val()));
    //    var total_oa = parseFloat(unformatNumber($(".total_subsidiasuransi_oa").eq(idx_tagihan).val()));

    //    iurbayar = (total_tindakan + total_oa) * persentase / 100;
    //} else {
    //    iurbayar = 0;
    //}

    // console.log("IDX", idx_tagihan, persentase, iurbayar);

    $('.form_naik_kelas .iurbayar').val(formatThousandDecimal(iurbayar));
    // hitungMultiPenjamin();
    // setNilaiInacbgNaikKelas();
}


function setIurBiayaSelisih() {
    var kelasperawatan = parseFloat(unformatNumber($('.form_naik_kelas .kelasperawatan').val()));
    var kelastanggungan = parseFloat(unformatNumber($('.form_naik_kelas .kelastanggungan').val()));
    var iurbayar = Math.abs(kelasperawatan - kelastanggungan);

    $('.form_naik_kelas .iurbayar').val(formatThousandDecimal(iurbayar));

    
    // setNilaiInacbgNaikKelas();
    // hitungMultiPenjamin();
}

$(function() { 
    $('#checkBoxNaikKelas').on('change', function(){
        var pendaftaran_id = $("#pendaftaran_id").val();
        if(pendaftaran_id == '') {
            $(this).prop('checked', false);
            myAlert('Silahkan Pilih Data Kunjungan');
            return false;
        }
        if($(this).is(':checked')) {
            $('.body_naikkelas').removeClass('hide');
            // setNilaiInacbgNaikKelas();
            // setMultiPenjamin(1);
        } else {
            $('.body_naikkelas').addClass('hide');
            $("#tabel-multipenjamin tbody tr").each(function() {
                if ($(this).find(".multi_carabayar_id").val() == CARABAYAR_ID_MEMBAYAR) {
                    $(this).find('.jmlpiutangasuransi_multi').val(formatThousandDecimal(0));
                }
            });
            setProporsionalMultiPenjaminDana();
            setBiayaUmumDariUangMuka();
            // $('#tabel-multipenjamin tbody > tr').each(function(){
            //     $(this).find('.naikkelas').parents('tr').detach();
            // });
            hitungTotalSemua();
        }
    });
});


function loadTagihanPasien(data) {


    if (data.belumVerifBatalUangMuka == 1) {
        myAlert("Mohon Order Batal Uang Muka Terlebih Dahulu");
        setKunjunganReset();
        $("#form-datakunjungan > div > div > .tombol").attr('style','display:block;');
        $("#form-datakunjungan > .box").addClass("well").removeClass("box");
        $("#form-datakunjungan > div").removeClass("animation-loading");
        return false;
    }

    if (data.ada_iurbea == 0) {
        myAlert(data.ada_iurbea_pesan);
        setKunjunganReset();
        $("#form-datakunjungan > div > div > .tombol").attr('style','display:block;');
        $("#form-datakunjungan > .box").addClass("well").removeClass("box");
        $("#form-datakunjungan > div").removeClass("animation-loading");
        return false;
    }



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
    $("#totaluangmuka").val(data.jumlahuangmuka);

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
        if(data.pasiennaikkelas == 1) {
            $('#')
            setTimeout(() => {
            //    setMultiPenjamin(data.pasiennaikkelas);
            }, 1000);
        }
    <?php }?>

    var total_iur_bea = 0;
    is_naikkelas = false;

    if (data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?> || data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA ?>){
        $(".input_admin_diskon").show();
        $(".input_selisih_bpjs").show();

        /*
        if(data.instalasi_id == 4 || data.instalasi_id == 76){
            if(data.kelaspelayanan_id != data.kelastanggungan_id){
                myAlert('Pasien '+data.namadepan+' '+data.nama_pasien+' memiliki kelas tanggungan dan kelas pelayanan yang berbeda !!');
            }
        }
        */
        console.log("KELAS PASIEN", data.kelaspelayanan_id, KELASPELAYANAN_ID_KELAS_III);
    
        var is_ri = false;
        $.each(instalasi_ri, function(i, v) {
            if (data.instalasi_id == v) {
                is_ri = true;
            }
        });
    
    
        if (!is_ri) {
            console.log("Kondisi 1");
            $('.body_naikkelas').addClass('hide');
            $("#checkBoxNaikKelas").prop("checked", false).prop("disabled", true);
        } else if (data.kelastanggungan_id == KELASPELAYANAN_ID_KELAS_III) {
            console.log("Kondisi 2");
            $('.body_naikkelas').addClass('hide');
            $("#checkBoxNaikKelas").prop("checked", false).prop("disabled", true);
        } else {
            console.log("Kondisi 3");
            $('.body_naikkelas').removeClass('hide');
            console.log("SET CEKLIS");
            $("#checkBoxNaikKelas").prop("checked", true).prop("disabled", false);
        }

        if (data.iurbea.iurbea_id != null) {
            $(".form_naik_kelas .totalbiayarumahsakit").val(formatThousandDecimal(parseFloat(data.iurbea.totalbiayarumahsakit)));
            $(".form_naik_kelas .kelasperawatan").val(formatThousandDecimal(parseFloat(data.iurbea.inacbg_kelasperawatan)));
            $(".form_naik_kelas .kelastanggungan").val(formatThousandDecimal(parseFloat(data.iurbea.inacbg_kelastanggungan)));
            $(".form_naik_kelas .totalselisihkelastanggunganperawatan").val(formatThousandDecimal(parseFloat(data.iurbea.totalselisihkelastanggunganperawatan)));
            $(".form_naik_kelas .iurbeatujuhpuluhpersen").val(formatThousandDecimal(parseFloat(data.iurbea.iurbeatujuhpuluhpersen)));
            $(".form_naik_kelas .iurbayar").val(formatThousandDecimal(parseFloat(data.iurbea.totalinacbg_naikkelasperawatan)));
            $(".form_naik_kelas .iurbea_id").val(data.iurbea.iurbea_id);

            var label_kelas1 = data.kelaspelayanan_nama;
            if (data.kelaspelayanan_id == KELASPELAYANAN_ID_VIP || data.kelaspelayanan_id == KELASPELAYANAN_ID_VVIP) {
                label_kelas1 = "Kelas I";
            }


            $(".form_naik_kelas .label_ina_1").html(label_kelas1);
            $(".form_naik_kelas .label_ina_2").html(data.kelastanggungan_nama);

            total_iur_bea = data.iurbea.totalinacbg_naikkelasperawatan;

            is_naikkelas = true;

            if (parseFloat(data.iurbea.totalinacbg_naikkelasperawatan) != 0) {
                $(".btn_tambah_iur_bea").prop("disabled", false);
            }
        }

    } else {
        $(".input_admin_diskon").show();
        $(".input_selisih_bpjs").show();

        $('.body_naikkelas').addClass('hide');
           $("#checkBoxNaikKelas").prop("checked", false).prop("disabled", true);
    }

    $("#totaliurbea").val(formatThousandDecimal(parseFloat(total_iur_bea)));


    

    $("#form-datakunjungan > div > div > .judul").html('Data Kunjungan '+data.no_pendaftaran);
    $("#form-datakunjungan > div > div > .tombol").attr('style','display:block;');
    $("#form-datakunjungan > .box").addClass("well").removeClass("box");

    $("#form-datakunjungan > div").removeClass("animation-loading");
    $("#nama_pasien").focus();
}

function resetPencarianRuangan() {
    $("#dialog_pasien_ruangan_id").val("");
}

function setTambahIurBea() {
    $(".btn_tambah_iur_bea").prop("disabled", true);
    setMultiPenjamin(1);
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
                setDropDownPenjaminOnList();

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
    var on_load = is_load;

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
                // $(".form_naik_kelas .kelasperawatan").val();
            }
            hitungTotalOa();
            setProporsiSemua();
            hitungJmlpembayaran();

            if (is_load == true) {
                $("#BKPemakaianuangmukaT_pemakaianuangmuka").val($("#BKPemakaianuangmukaT_totaluangmuka").val());
                // $(".form_naik_kelas .kelasperawatan").val($("#tot_tarif_semua").val());
            }

            is_load = false;
            loadSelisiBpjsDiv();
            hitungMultiPenjamin();
            setDropDownPenjaminOnList();

            if (on_load) {
                setBiayaUmumDariUangMuka();
            }

        },
         error: function (jqXHR, textStatus, errorThrown) { $("#form-rincianobatalkes").removeClass("animation-loading");console.log(errorThrown);}
    });
}


function setBiayaUmumDariUangMuka() {
    
    unformatNumberSemua();

    var uang_muka = parseFloat($("#totaluangmuka").val());
    // var iurbea = parseFloat($("#totaliurbea").val());
    var total_tanggungan = 0;
    var input_umum = null;
    var count_input = 0;

    $("#tabel-multipenjamin tbody tr").each(function() {
        total_tanggungan += parseFloat($(this).find(".jmlpiutangasuransi_multi").val());
        count_input++;
    });

    if (count_input > 1) {

        // uang_muka += iurbea;

        $("#tabel-multipenjamin tbody tr").each(function() {
            var input_carabayar = $(this).find(".multi_carabayar_id");
            var input_nilai = $(this).find(".jmlpiutangasuransi_multi");
    
            if (input_carabayar.val() == CARABAYAR_ID_MEMBAYAR && input_nilai.val() < uang_muka) {
                if (total_tanggungan < uang_muka) {
                    uang_muka = total_tanggungan
                }
    
                input_nilai.val(uang_muka);
                input_umum = input_nilai;
    
    
            }
    
        });
    }

    formatNumberSemua();

    if (input_umum != null) {
        setProporsionalMultiPenjaminDana(input_umum);
    }
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


function hitungTanggunganTindakan(obj) {

    unformatNumberSemua();

    var input_nilai = $(obj).val();
    var input_idx = $(obj).data('input_idx');
    var row_tindakan = $(obj).parents('tr');

    var qty_tindakan = parseFloat(row_tindakan.find("input[name$='[qty_tindakan]']").val());
    var tarif_satuan = parseFloat(row_tindakan.find("input[name$='[tarif_satuan]']").val());
    var discount_tindakan = parseFloat(row_tindakan.find("input[name$='[discount_tindakan]']").val());
    
    var kolom_tanggungan = new Array;
    var kolom_idx_umum = null;

    var nilai = (tarif_satuan * qty_tindakan) - discount_tindakan;
    var nilai_sisa = nilai;

    $("#form-rinciantindakan thead .col_th_penjamin").each(function() {
        var c_idx = $(this).data("col_index");
        var c_is_umum = $(this).data("is_umum");

        kolom_tanggungan[c_idx] = {is_umum: c_is_umum, total: 0};

        if (c_is_umum == 1) {
            kolom_idx_umum = c_idx;
        }
    });

    if (input_idx == 0) {

        // cek apakah ada sisa nilai tagihan
        $(row_tindakan).find(".input_subsidi").each(function() {
            var nilai_tanggungan = parseFloat($(this).val());
            if (nilai_tanggungan < nilai_sisa) {
                nilai_sisa -= nilai_tanggungan;
            } else {
                $(this).val(nilai_sisa);
                nilai_sisa = 0;
            }
        });

        // sisa tersebut akan di-set ke tanggungan selain penjamin umum
        $(row_tindakan).find(".input_subsidi").each(function() {
            var nilai_tanggungan = parseFloat($(this).val());
            if ($(this).data("input_idx") != 0) {
                nilai_tanggungan += nilai_sisa;
                $(this).val(nilai_tanggungan);
                nilai_sisa = 0;
            }
        });

    } else {

        $(row_tindakan).find(".input_subsidi").each(function() {
            
            var nilai_tanggungan = parseFloat($(this).val());
            if ($(this).data("input_idx") != 0) {
                nilai_sisa -= nilai_tanggungan;
            }

        });

        if (nilai_sisa >= 0) {
            $(row_tindakan).find(".subsidiasuransi_tindakan_0").val(nilai_sisa);
        } else {

            // nilai negatif
            nilai_sisa = Math.abs(nilai_sisa);

            $(row_tindakan).find(".subsidiasuransi_tindakan_0").val(0);

            $(row_tindakan).find(".input_subsidi").each(function() {
            
                var nilai_tanggungan = parseFloat($(this).val());
                if ($(this).data("input_idx") != 0 && $(this).data("input_idx") != input_idx) {
                    if (nilai_tanggungan > nilai_sisa) {
                        nilai_tanggungan = nilai_sisa;
                        nilai_sisa = 0;
                    } else {
                        nilai_sisa -= nilai_tanggungan;
                        nilai_tanggungan = 0;
                    }
                    $(this).val(nilai_tanggungan);
                }

            });

            if (nilai_sisa > 0) {
                input_nilai -= nilai_sisa;
                $(obj).val(input_nilai);   
            }
        }


    }

    var total_tanggung = 0;

    formatNumberSemua();


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

        // set kolom umum
        kolom_is_umum = new Array();
        kolom_idx_umum = null; // kunci untuk row pertama
        kolom_idx_penjamin_umum = null; // cek apakah kolom tersebut berpenjamin umum atau nggak
        
        $("#form-rinciantindakan thead .col_th_penjamin").each(function(data) {
            var c_idx = $(this).data("col_index");
            var c_is_umum = $(this).data("is_umum");
            var c_penjamin = $(this).data("penjamin_id");

            var c_is_penjamin_umum = c_penjamin == <?php echo Params::PENJAMIN_ID_UMUM; ?>;

            kolom_is_umum[c_idx] = {is_penjamin_umum: c_is_penjamin_umum, is_umum: c_is_umum, total: 0};

            if (c_is_umum == 1) {
                kolom_idx_umum = c_idx;
            }

            if (c_is_penjamin_umum) {
                kolom_idx_penjamin_umum = c_idx;
            }

        });



        $("#form-rinciantindakan").find("input[name$='[is_pilihtindakan]'][type='checkbox']").each(function() {
            var row_tindakan = $(this).parents('tr');

            var qty_tindakan = parseFloat(row_tindakan.find("input[name$='[qty_tindakan]']").val());
            var tarif_satuan = parseFloat(row_tindakan.find("input[name$='[tarif_satuan]']").val());
            var tarifcyto_tindakan = parseFloat(row_tindakan.find("input[name$='[tarifcyto_tindakan]']").val());
            var discount_tindakan = parseFloat(row_tindakan.find("input[name$='[discount_tindakan]']").val());
            var pembebasan_tindakan = parseFloat(row_tindakan.find("input[name$='[pembebasan_tindakan]']").val());
            var subsidiasuransi_tindakan = parseFloat(row_tindakan.find("input[name$='[subsidiasuransi_tindakan]']").val());
            var subsisidirumahsakit_tindakan = parseFloat(row_tindakan.find("input[name$='[subsisidirumahsakit_tindakan]']").val());
            var subsidipemerintah_tindakan = parseFloat(row_tindakan.find("input[name$='[subsidipemerintah_tindakan]']").val());


            var nilai = (tarif_satuan * qty_tindakan) - discount_tindakan;

            var subtotal = nilai;
            var arr_tanggungan = new Array();
            for (i = 0; i < max_penjamin; i++) {

                var nilai_tanggungan = parseFloat(row_tindakan.find(".subsidiasuransi_tindakan_" + i).val());

                if (kolom_is_umum[i].is_umum != 1) {
                    console.log("KURANG", nilai_tanggungan);

                    subtotal -= nilai_tanggungan;
                    
                    if ($(this).is(":checked")) {
                        kolom_is_umum[i].total += nilai_tanggungan;
                    }
                }
            }

            // console.log("UMUM", kolom_idx_umum);

            if (kolom_idx_umum != null) {
                row_tindakan.find(".subsidiasuransi_tindakan_" + kolom_idx_umum).val(subtotal);

                if ($(this).is(":checked")) {
                    kolom_is_umum[kolom_idx_umum].total += subtotal;
                }
            }



            // set biaya dibayar pasien dari kolom penjamin umum
            for (i = 0; i < max_penjamin; i++) {
                arr_tanggungan[i] = parseFloat(row_tindakan.find(".subsidiasuransi_tindakan_" + i).val());
            }
            subtotal = 0;
            if (kolom_idx_penjamin_umum != null) {
                subtotal = arr_tanggungan[kolom_idx_penjamin_umum];
            }
            



            /*
            if (kolom_is_umum[kolom_idx_umum].is_penjamin_umum != true) {
                subtotal = 0;
            } 
            */



            
            // subtotal = nilai - discount_tindakan - subsidiasuransi_tindakan - subsisidirumahsakit_tindakan;
            subiurbiaya = subtotal;

            row_tindakan.find(".tarif_kotor").val(nilai);

            console.log("BIAYA TINDAKAN", subiurbiaya);
            
            

            // sisatagihan = ((qty_tindakan * (tarif_satuan + tarifcyto_tindakan)) - discount_tindakan - subsidiasuransi_tindakan - subsisidirumahsakit_tindakan - pembebasan_tindakan - subsidipemerintah_tindakan);
            console.log("-- SLIP --");
            if ($(this).is(":checked")) {
                $(this).parents('tr').find("input[name$='[subtotal]']").val(subtotal);
                $(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val(subiurbiaya);
                $(this).parents('tr').find("input[name$='[jmlbayar_iurtindakan]']").val(subtotal);
                
                console.log("TOT", subtotal);

                tot_tarif_tindakan += (tarif_satuan * qty_tindakan);
                tot_tarifcyto_tindakan += tarifcyto_tindakan;
                tot_discount_tindakan += discount_tindakan;
                tot_iurbiaya_tindakan += subiurbiaya;
                tot_pembebasan_tindakan += pembebasan_tindakan;
                tot_subsidiasuransi_tindakan += subsidiasuransi_tindakan;
                tot_subsidipemerintah_tindakan += subsidipemerintah_tindakan;
                tot_subsisidirumahsakit_tindakan += subsisidirumahsakit_tindakan;
                // tot_sisatagihan += sisatagihan;
                total_tindakan += subtotal;
                tot_selisih_bpjs += selisih;
            } else {
                $(this).parents('tr').find("input[name$='[subtotal]']").val(0);
                $(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val(0);
                $(this).parents('tr').find("input[name$='[jmlbayar_iurtindakan]']").val(0);
            }
        });

        // $("#form-rinciantindakan #tot_tarif_tindakan").val(total_tindakan);
        $("#form-rinciantindakan #tot_tarif_tindakan").val(tot_tarif_tindakan);
        $("#form-rinciantindakan #tot_tarifcyto_tindakan").val(tot_tarifcyto_tindakan);
        $("#form-rinciantindakan #tot_discount_tindakan").val(tot_discount_tindakan);
        $("#form-rinciantindakan #tot_pembebasan_tindakan").val(tot_pembebasan_tindakan);

        for (i = 0; i < max_penjamin; i++) {
            $("#form-rinciantindakan .total_subsidiasuransi_tindakan_" + i).val(kolom_is_umum[i].total);
        }


        // $("#form-rinciantindakan #tot_subsidiasuransi_tindakan").val(tot_subsidiasuransi_tindakan);
        // $("#form-rinciantindakan #tot_subsisidirumahsakit_tindakan").val(tot_subsisidirumahsakit_tindakan);
        $("#form-rinciantindakan #tot_iurbiaya_tindakan").val(tot_iurbiaya_tindakan);
        $("#form-rinciantindakan #total_tindakan").val(total_tindakan);
        $("#form-rinciantindakan #tot_jmlselisihbpjs_tindakan").val(tot_selisih_bpjs);

        $("#<?php echo CHtml::activeId($model, 'totalsisatagihan'); ?>").val(tot_sisatagihan);
        formatNumberSemua();

        <?php // if($this->id == "pembayaranTagihanPasien"){  ?>
            // hitungMultiPenjamin();
        <?php // } ?>

        hitungMultiPenjamin();
        hitungTotalSemua();
        hitungBiayaAdministrasi();
        hitungDiskonBayar();
    }

    function hitungTanggunganOA(obj) {

        unformatNumberSemua();

        var input_nilai = $(obj).val();
        var input_idx = $(obj).data('input_idx');
        var row_oa = $(obj).parents('tr');

        var qty_oa = parseFloat(row_oa.find("input[name$='[qty_oa]']").val());
        var hargasatuan_oa = parseFloat(row_oa.find("input[name$='[hargasatuan_oa]']").val());

        var kolom_tanggungan = new Array;
        var kolom_idx_umum = null;

        var nilai = (hargasatuan_oa * qty_oa);
        var nilai_sisa = nilai;

        $("#form-rincianobatalkes thead .col_th_penjamin").each(function(data) {
            var c_idx = $(this).data("col_index");
            var c_is_umum = $(this).data("is_umum");

            kolom_tanggungan[c_idx] = {is_umum: c_is_umum, total: 0};

            if (c_is_umum == 1) {
                kolom_idx_umum = c_idx;
            }

        });

        if (input_idx == 0) {

            // cek apakah ada sisa nilai tagihan
            $(row_oa).find(".input_subsidi").each(function() {
                var nilai_tanggungan = parseFloat($(this).val());
                if (nilai_tanggungan < nilai_sisa) {
                    nilai_sisa -= nilai_tanggungan;
                } else {
                    $(this).val(nilai_sisa);
                    nilai_sisa = 0;
                }
            });

            // sisa tersebut akan di-set ke tanggungan selain penjamin umum
            $(row_oa).find(".input_subsidi").each(function() {
                var nilai_tanggungan = parseFloat($(this).val());
                if ($(this).data("input_idx") != 0) {
                    nilai_tanggungan += nilai_sisa;
                    $(this).val(nilai_tanggungan);
                    nilai_sisa = 0;
                }
            });

        } else {

            $(row_oa).find(".input_subsidi").each(function() {
                
                var nilai_tanggungan = parseFloat($(this).val());
                if ($(this).data("input_idx") != 0) {
                    nilai_sisa -= nilai_tanggungan;
                }

            });

            if (nilai_sisa >= 0) {
                $(row_oa).find(".subsidiasuransi_oa_0").val(nilai_sisa);
            } else {

                // nilai negatif (pengurang)
                nilai_sisa = Math.abs(nilai_sisa);

                $(row_oa).find(".subsidiasuransi_oa_0").val(0);

                $(row_oa).find(".input_subsidi").each(function() {
                
                    var nilai_tanggungan = parseFloat($(this).val());
                    if ($(this).data("input_idx") != 0 && $(this).data("input_idx") != input_idx) {
                        if (nilai_tanggungan > nilai_sisa) {
                            nilai_tanggungan = nilai_sisa;
                            nilai_sisa = 0;
                        } else {
                            nilai_sisa -= nilai_tanggungan;
                            nilai_tanggungan = 0;
                        }
                        $(this).val(nilai_tanggungan);
                    }

                });

                if (nilai_sisa > 0) {
                    input_nilai -= nilai_sisa;
                    $(obj).val(input_nilai);   
                }


            }


        }
        
        formatNumberSemua();


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


    // set kolom umum
    kolom_is_umum = new Array();
    kolom_idx_umum = null;
    kolom_idx_penjamin_umum = null; // cek apakah kolom tersebut berpenjamin umum atau nggak
    
    $("#form-rincianobatalkes thead .col_th_penjamin").each(function(data) {
        var c_idx = $(this).data("col_index");
        var c_is_umum = $(this).data("is_umum");
        var c_penjamin = $(this).data("penjamin_id");

        var c_is_penjamin_umum = c_penjamin == <?php echo Params::PENJAMIN_ID_UMUM; ?>;

        kolom_is_umum[c_idx] = {is_penjamin_umum: c_is_penjamin_umum, is_umum: c_is_umum, total: 0};

        if (c_is_umum == 1) {
            kolom_idx_umum = c_idx;
        }

        if (c_is_penjamin_umum) {
            kolom_idx_penjamin_umum = c_idx;
        }

    });


    $("#form-rincianobatalkes").find("input[name$='[is_pilihoa]'][type='checkbox']").each(function(){
        
        var row_oa = $(this).parents('tr');
        
        var qty_oa = parseFloat(row_oa.find("input[name$='[qty_oa]']").val());
        var hargasatuan_oa = parseFloat(row_oa.find("input[name$='[hargasatuan_oa]']").val());
        var tarifcyto = parseFloat(row_oa.find("input[name$='[tarifcyto]']").val());
        var jmlppn = parseFloat(row_oa.find("input[name$='[jumlahppn]']").val());
        var discount = parseFloat(row_oa.find("input[name$='[discount]']").val());
        var biayalain = parseFloat(row_oa.find("input[name$='[biayalain]']").val());
        var subsidiasuransi = parseFloat(row_oa.find("input[name$='[subsidiasuransi]']").val());
        var subsidipemerintah = parseFloat(row_oa.find("input[name$='[subsidipemerintah]']").val());
        var subsidirs = parseFloat(row_oa.find("input[name$='[subsidirs]']").val());
        var jasapelayanan_farmasi = parseFloat(row_oa.find("input[name$='[jasapelayanan_farmasi]']").val());
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
        subtotaloa = jmlQty - discount; // - subsidiasuransi - subsidirs;
        // subtotaloa = jmlQty + biayaR - discount - subsidiasuransi - subsidirs;



        var nilai = subtotaloa;
        var arr_tanggungan = new Array();

        for (i = 0; i < max_penjamin; i++) {

            var nilai_tanggungan = parseFloat(row_oa.find(".subsidiasuransi_oa_" + i).val());

            if (kolom_is_umum[i].is_umum != 1) {
                console.log("KURANG", nilai_tanggungan);

                subtotaloa -= nilai_tanggungan;
                if ($(this).is(":checked")) {
                    kolom_is_umum[i].total += nilai_tanggungan;
                }
            }
        }

        // console.log("UMUM", kolom_idx_umum);

        if (kolom_idx_umum != null) {
            row_oa.find(".subsidiasuransi_oa_" + kolom_idx_umum).val(subtotaloa);
            if ($(this).is(":checked")) {
                kolom_is_umum[kolom_idx_umum].total += subtotaloa;
            }
        }

        // set biaya dibayar pasien dari kolom penjamin umum
        for (i = 0; i < max_penjamin; i++) {
            arr_tanggungan[i] = parseFloat(row_oa.find(".subsidiasuransi_oa_" + i).val());
        }
        subtotaloa = 0;
        if (kolom_idx_penjamin_umum != null) {
            subtotaloa = arr_tanggungan[kolom_idx_penjamin_umum];
        }


        subiurbiayaoa = subtotaloa;

        row_oa.find(".tarif_kotor").val(nilai);

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

    for (i = 0; i < max_penjamin; i++) {
        $("#form-rincianobatalkes .total_subsidiasuransi_oa_" + i).val(kolom_is_umum[i].total);
    }
    
    
	$("#form-rincianobatalkes #total_oa").val(total_oa);

    if(jasafarmasi > 0){
        $("#<?php echo CHtml::activeId($model,'jasapelayanan_farmasi');?>").val(jasafarmasi);
        $(".jasapelayananfarmasi_div").show();
    }else{
        $(".jasapelayananfarmasi_div").hide();
    }
    
        

    formatNumberSemua();

    hitungMultiPenjamin();
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

    var tot_tanggungan_tindakan = 0;
    var tot_tanggungan_oa = 0;
    for (i = 0; i < max_penjamin; i++) {
        tot_tanggungan_tindakan = parseFloat($("#form-rinciantindakan .total_subsidiasuransi_tindakan_" + i).val());
        tot_tanggungan_oa = parseFloat($("#form-rincianobatalkes .total_subsidiasuransi_oa_" + i).val());

        $("#form-rinciansemua .total_subsidiasuransi_semua_" + i).val(tot_tanggungan_tindakan + tot_tanggungan_oa);
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

    // setNilaiInacbgNaikKelas();

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

    // hitungAllJumlahBayarSemua();
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

function setMultiPenjamin(naikkelas) {
    var pendaftaran_id = $("#pendaftaran_id").val();
    var total_bea = parseFloat(unformatNumber($("#totaliurbea").val()));
    if(naikkelas != 1) {
        $('#tabel-multipenjamin > tbody > tr').detach();
    }
    $("#form-multipenjamin").addClass("animation-loading");

    if(pendaftaran_id != ''){
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetMultiPenjamin'); ?>',
            data: {pendaftaran_id: pendaftaran_id, naikkelas:naikkelas}, //
            dataType: "json",
            success: function (data) {
                $('#tabel-multipenjamin > tbody').append(data.form);
                console.log(naikkelas, 'ini naik kelas')
                if(naikkelas == 1) {
                    $('#tabel-multipenjamin > tbody').find('tr:last').find('.jmlpiutangasuransi_multi').addClass('naikkelas');
                    if (total_bea != 0) {
                        $('#tabel-multipenjamin > tbody').find('tr:last').find('.jmlpiutangasuransi_multi').val(
                            $("#totaliurbea").val()
                        );
                    }
                    $(".btn_tambah_iur_bea").prop("disabled", true);
                }
                $('#tabel-multipenjamin > tbody tr').each(function() {
                    $(this).find(".jmlpiutangasuransi_multi").unmaskMoney();
                    $(this).find(".jmlpiutangasuransi_multi").maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                    );
                });

                renameInputRowulti('#tabel-multipenjamin');
                $('#BKPiutangasuransiT_0_carabayar_id').attr('readonly', true);
                $('#BKPiutangasuransiT_0_penjamin_id').attr('readonly', true);
                // if (data.ismembayar) {
                //     $('#BKPiutangasuransiT_0_jmlpiutangasuransi').attr('readonly', false);
                // }
                $("#form-multipenjamin").removeClass("animation-loading");
                setDropDownPenjaminOnList();
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

                if (naikkelas && total_bea != 0) {
                    $(".btn_tambah_iur_bea").prop("disabled", true);
                }
            }
        });
    }
}

function hitungMultiPenjamin() {
    unformatNumberSemua();

    var iur_biaya_tindakan = 0;
    var iur_biaya_oa = 0;

    var row_umum_naikkelas = null;

    $("#tabel-multipenjamin tbody tr").each(function() {
        if (isBPJSNaikKelas($(this).find(".multi_carabayar_id"))) {
            row_umum_naikkelas = $(this);
        }
    });

    $("#form-multipenjamin tbody > tr").not(row_umum_naikkelas).each(function () {
        var totalpenjamin = 0;
        var penjamin_id = $(this).find("select[name$='[penjamin_id]']").val();
        var objpenjamin = $(this).find("input[name$='[jmlpiutangasuransi]']");
        var totaltindakan = 0;
        var totaloa = 0;

        var tanggungan_idx = null;

        iur_biaya_tindakan = 0;
        iur_biaya_oa = 0;

        $("#form-rinciantindakan .col_th_penjamin").each(function(data) {
            if ($(this).data('penjamin_id') == penjamin_id) {
                tanggungan_idx = $(this).data('col_index');
            }
        });

        console.log("IDX", tanggungan_idx);
        
        $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
            

            var row_tindakan = $(this).parents("tr");
            var tanggungan = 0;
            
            if($(this).is(":checked")){

                tanggungan = parseFloat(row_tindakan.find(".subsidiasuransi_tindakan_" + tanggungan_idx).val());
                totaltindakan += tanggungan;

            }
        });

        $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
            
            var row_oa = $(this).parents("tr");
            var tanggungan = 0;
            
            if($(this).is(":checked")){

                tanggungan = parseFloat(row_oa.find(".subsidiasuransi_oa_" + tanggungan_idx).val());
                totaloa += tanggungan;

            }
        });

        $(this).find("input[name$='[jmlpiutangasuransi]']").val(totaltindakan + totaloa);
        $(this).find("input[name$='[jmltindakanasuransi]']").val(totaltindakan);
        $(this).find("input[name$='[jmloaasuransi]']").val(totaloa);
    });

    console.log("Iur Biaya", iur_biaya_tindakan, iur_biaya_oa);

    /*

    $("#form-multipenjamin").find("tbody > tr").each(function () {
        var penjamin_id = $(this).find("select[name$='[penjamin_id]']").val();
        var objpenjamin = $(this).find("input[name$='[jmlpiutangasuransi]']");
        if (penjamin_id == <?php echo Params::PENJAMIN_ID_UMUM; ?>) {
            $(this).find("input[name$='[jmltindakanasuransi]']").val(iur_biaya_tindakan);
            $(this).find("input[name$='[jmloaasuransi]']").val(iur_biaya_oa);
            $(objpenjamin).val(iur_biaya_tindakan + iur_biaya_oa);
        }
    });

    */

    
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

    $('.penjamin_td').attr('disabled', true);

    $(last).find(".jmlpiutangasuransi_multi").unmaskMoney();
    $(last).find(".jmlpiutangasuransi_multi").last().maskMoney(
        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
    );

    renameInputRowulti('#tabel-multipenjamin');
}

function batalRowPenjamin(obj, is_beaumum) {

    var index_hapus = $(obj).parents("tr").index("#tabel-multipenjamin tbody tr");

    $(obj).parents('tr').addClass("animation-loading-1");
    setTimeout(function () {
        $(obj).parents('tr').detach();
        renameInputRowulti('#tabel-multipenjamin');

        shiftTanggunganPenjamin(index_hapus);
        setDropDownPenjaminOnList();
        hitungMultiPenjamin();
        $(obj).parents('tr').removeClass("animation-loading-1");

        if (is_beaumum != null && is_beaumum == 1) {
            $(".btn_tambah_iur_bea").prop("disabled", false);
        }


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


function shiftTanggunganPenjamin(idx) {
    $("#form-rinciantindakan tbody tr").each(function() {
        for (var i = idx + 1; i < max_penjamin; i++) {
            $(this).find(".subsidiasuransi_tindakan_" + (i - 1)).val($(this).find(".subsidiasuransi_tindakan_" + (i)).val());
            $(this).find(".subsidiasuransi_tindakan_" + (i)).val("0,00");
        }
    });

    $("#form-rincianobatalkes tbody tr").each(function() {
        for (var i = idx + 1; i < max_penjamin; i++) {
            $(this).find(".subsidiasuransi_oa_" + (i - 1)).val($(this).find(".subsidiasuransi_oa_" + (i)).val());
            $(this).find(".subsidiasuransi_oa_" + (i)).val("0,00");
        }
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
                setDropDownPenjaminOnList();
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
        data_penjamin = {
            penjamin_id:null,
            penjamin_nama:null,
        };
        var multipenjamin_id = $('#BKPiutangasuransiT_' + ii + '_penjamin_id').val();
        data_penjamin.penjamin_id = $('#BKPiutangasuransiT_' + ii + '_penjamin_id').val();
        data_penjamin.penjamin_nama = $('#BKPiutangasuransiT_' + ii + '_penjamin_id :selected').html();
        arr_penjamin_id.push(data_penjamin);
    }
    // var penjamin_id = <?= !empty($modKunjungan->penjamin_id) ? $modKunjungan->penjamin_id : 'null'; ?>;
    // var total = $('#BKPembayaranpelayananT_totalbiayapelayanan').val();   
    
    var row_header_tanggungan = null;

    for (var ci = 0; ci < max_penjamin; ci++) {
        row_header_tanggungan = $("#form-rinciantindakan .col_th_penjamin[data-col_index=" + ci + "]");
        row_header_tanggungan_oa = $("#form-rincianobatalkes .col_th_penjamin[data-col_index=" + ci + "]");
        row_header_tanggungan_semua = $("#form-rinciansemua .col_th_penjamin[data-col_index=" + ci + "]");
        
        if (arr_penjamin_id[ci] != null) {
            row_header_tanggungan.data("is_umum", ci == 0 ? 1 : 0); //arr_penjamin_id[ci].penjamin_id == <?php // echo Params::PENJAMIN_ID_UMUM; ?> ? 1 : 0);
            row_header_tanggungan.data("penjamin_id", arr_penjamin_id[ci].penjamin_id);
            row_header_tanggungan.find("#tindakanpenjamin_id_" + ci).val(arr_penjamin_id[ci].penjamin_id);
            row_header_tanggungan.find(".nama_tanggungan").html(arr_penjamin_id[ci].penjamin_nama);

            row_header_tanggungan_oa.data("is_umum", ci == 0 ? 1 : 0); //arr_penjamin_id[ci].penjamin_id == <?php // echo Params::PENJAMIN_ID_UMUM; ?> ? 1 : 0);
            row_header_tanggungan_oa.data("penjamin_id", arr_penjamin_id[ci].penjamin_id);
            row_header_tanggungan_oa.find("#tindakanpenjamin_id_" + ci).val(arr_penjamin_id[ci].penjamin_id);
            row_header_tanggungan_oa.find(".nama_tanggungan").html(arr_penjamin_id[ci].penjamin_nama);
        
            row_header_tanggungan_semua.data("is_umum", ci == 0 ? 1 : 0); //arr_penjamin_id[ci].penjamin_id == <?php // echo Params::PENJAMIN_ID_UMUM; ?> ? 1 : 0);
            row_header_tanggungan_semua.data("penjamin_id", arr_penjamin_id[ci].penjamin_id);
            row_header_tanggungan_semua.find("#tindakanpenjamin_id_" + ci).val(arr_penjamin_id[ci].penjamin_id);
            row_header_tanggungan_semua.find(".nama_tanggungan").html(arr_penjamin_id[ci].penjamin_nama);


            $(".col_subsidi_" + ci).show();
        
        
        } else {
            row_header_tanggungan.data("is_umum", 0);
            row_header_tanggungan.data("penjamin_id", "");
            row_header_tanggungan.find("#tindakanpenjamin_id_" + ci).val("");
            row_header_tanggungan.find(".nama_tanggungan").html("");

            row_header_tanggungan_oa.data("is_umum", 0);
            row_header_tanggungan_oa.data("penjamin_id", "");
            row_header_tanggungan_oa.find("#tindakanpenjamin_id_" + ci).val("");
            row_header_tanggungan_oa.find(".nama_tanggungan").html("");

            row_header_tanggungan_semua.data("is_umum", 0);
            row_header_tanggungan_semua.data("penjamin_id", "");
            row_header_tanggungan_semua.find("#tindakanpenjamin_id_" + ci).val("");
            row_header_tanggungan_semua.find(".nama_tanggungan").html("");

            $(".col_subsidi_" + ci).hide();
        }
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

    function cekPiutang() {

        // unformatNumberSemua();

        var terisi = true;

        $('.jmlpiutangasuransi_multi').each(function () {
            var piutang = parseFloat(unformatNumber($(this).val()));
            console.log('piutang: ' + piutang);

            if(piutang < 0.01) {
                terisi = false;
            }
        });

        console.log('terisi: ' + terisi);

        if(terisi == true) {
            console.log('terisi true');
            $('.penjamin_td, .penjamin_tindakan').removeAttr('disabled');
        } else {
            console.log('terisi false');
            $('.penjamin_td, .penjamin_tindakan').attr('disabled', true);
        }

        // formatNumberSemua();

    }


var nilai_sebelum_input_umum = 0;
var is_input_umum = false;

function setInputUmum(obj) {
    var tr = $(obj).parents("tr");
    if (tr.find(".multi_carabayar_id").val() == CARABAYAR_ID_MEMBAYAR) {
        nilai_sebelum_input_umum = parseFloat(unformatNumber($(obj).val()));
        is_input_umum = true;
    }
}


function setProporsionalMultiPenjaminDana(obj_input) {

    // cekPiutang();

    unformatNumberSemua();

    const penjamin_id_umum = <?php echo Params::PENJAMIN_ID_UMUM; ?>;


    // set dengan uang muka
    
    var uangmuka = parseFloat($("#totaluangmuka").val());
    // var iurbea = parseFloat($("#totaliurbea").val());
    if (is_input_umum) {
        is_input_umum = false;
        
        var nilai_umum = parseFloat($(obj_input).val());

        if (nilai_umum != nilai_sebelum_input_umum) {
            nilai_umum += uangmuka; // + iurbea;

            $(obj_input).val(nilai_umum);
        }
        nilai_sebelum_input_umum = 0;
    }




    // hitung total berdasarkan baris yang di-ceklis
    // kemudian set penjamin jadi umum
    var total_semua = 0;
    $("#form-rinciantindakan tbody tr").each(function() {

        var tarif = parseFloat($(this).find(".tarif_kotor").val());
        $(this).find(".input_subsidi").val(0);

        if ($(this).find(".pilih_tindakan").is(":checked")) {
            total_semua += tarif;
        }
    });

    $("#form-rincianobatalkes tbody tr").each(function() {
        
        var tarif = parseFloat($(this).find(".tarif_kotor").val());
        $(this).find(".input_subsidi").val(0);

        if ($(this).find(".pilih_oa").is(":checked")) {
            total_semua += tarif;
        }
    });

    // menentukan hitungan penjamin
    var total_umum = total_semua;
    var total_umum_fix = total_semua; // nilai tidak diubah
    var is_ada_umum = false;
    var cnt = 0;
    var row_umum_naikkelas = null;
    
    // console.log("TOTAL UMUM AWAL", total_umum);

    var tab_len_nk = 0;
    $("#tabel-multipenjamin tbody tr").each(function() {
        if (isBPJSNaikKelas($(this).find(".multi_carabayar_id"))) {
            row_umum_naikkelas = $(this);
        }
    });

    if (
        typeof(obj_input) != 'undefined' 
        && obj_input != null 
        && !(isBPJSNaikKelas($(obj_input).parents("tr").find(".multi_carabayar_id")))
    ) {

        var idx_input = $(obj_input).parents("tr").index();
        var idx_val = $(obj_input).val();

        if (idx_val > total_umum) {
            idx_val = total_umum;
            total_umum = 0;

            $(obj_input).val(idx_val);
        } else {
            total_umum -= idx_val;
        }

        


        if ($("#tabel-multipenjamin tbody tr").not(row_umum_naikkelas).length == 1) {
            // console.log("SET_ROW_1", $("#tabel-multipenjamin tbody tr").not(row_umum_naikkelas).find(".jmlpiutangasuransi_multi"), total_semua);
            $("#tabel-multipenjamin tbody tr").not(row_umum_naikkelas).find(".jmlpiutangasuransi_multi").val(total_umum_fix);
        } else {

            var input_last = null;
            var input_last_val = null;
            var input_last_index = null;

            // console.log("IDX_INPUT", idx_input, idx_val);
    
            $("#tabel-multipenjamin tbody tr").not(row_umum_naikkelas).each(function() {
    
                // console.log("CHECK", cnt, idx_input);

                if (cnt != idx_input) {
                    // console.log("DING");
                    input_last = $(this).find('.jmlpiutangasuransi_multi');
                    input_last_val = $(input_last).val();
                    input_last_index = cnt;

                }
                
                cnt++;
            });
            // console.log("LAST_VAL", input_last, input_last_val, input_last_index, total_umum);

            cnt = 0;
            $("#tabel-multipenjamin tbody tr").not(row_umum_naikkelas).each(function() {

                var current_val = $(this).find('.jmlpiutangasuransi_multi').val();

                if (cnt != idx_input && cnt != input_last_index) {

                    // console.log("NON IDX LAST RUN");
                    
                    if (current_val < total_umum) {
                        total_umum -= current_val;
                    } else {
                        current_val = total_umum;
                        total_umum = 0;
                        $(this).find('.jmlpiutangasuransi_multi').val(current_val)
                    }

                }

                cnt++;
            });

            $(input_last).val(total_umum);

        }



    } else {
        cnt = 0;
        $("#tabel-multipenjamin tbody tr").not(row_umum_naikkelas).each(function() {
    
            var total_penjamin = $(this).find(".jmlpiutangasuransi_multi").val();

            if (cnt != 0) { //($(this).find(".penjamin_id_multi").val() != penjamin_id_umum) {
    
                console.log("TOTAL AWAL", total_umum, total_penjamin);
    
                if (total_penjamin < total_umum) {
                    total_umum -= total_penjamin;
                } else {
                    total_penjamin = total_umum;
                    total_umum = 0;
    
                    $(this).find(".jmlpiutangasuransi_multi").val(total_penjamin);
                }
    
    
                console.log("TOTAL SETELAH", total_umum);
            } else {
                is_ada_umum = true;
            }
    
            cnt++;
        });

        // jika tidak ada penjamin umum sedangkan sisa nilai umum-nya ada, maka akan di-set di baris terakhir
        if (!is_ada_umum) {
            var row_akhir = $("#tabel-multipenjamin tbody tr").last();
            var nilai_penjamin_akhir = $(row_akhir).find(".jmlpiutangasuransi_multi").val() + total_umum;
    
            $(row_akhir).find(".jmlpiutangasuransi_multi").val(nilai_penjamin_akhir);
        } else {
            cnt = 0;
            $("#tabel-multipenjamin tbody tr").each(function() {
                if (cnt == 0) { //($(this).find(".penjamin_id_multi").val() == penjamin_id_umum) {
                    $(this).find(".jmlpiutangasuransi_multi").val(total_umum);
                }
                cnt++;
            });
        }
    }


    // /*


    var tarif_tanggungan = [];
    var ic = 0;
    $("#tabel-multipenjamin tbody tr").each(function() {
        var nilai_multi = parseFloat($(this).find(".jmlpiutangasuransi_multi").val());
        if (isBPJSNaikKelas($(this).find(".multi_carabayar_id"))) {
            nilai_multi = 0;
        }

        tarif_tanggungan[ic] = nilai_multi;
        ic++;
    });

    console.log("TARIF MULTI", tarif_tanggungan);

    // /* 
    // set mappingan proposional penjamin
    // var total_semua_sisa = total_semua;
    var ic = 0;
    
    $("#form-rinciantindakan tbody tr").each(function() {

        var tarif = parseFloat($(this).find(".tarif_kotor").val());
        var set_tarif = 0;
        
        while (tarif > 0) {
            set_tarif = 0;
            if (tarif <= tarif_tanggungan[ic]) {
                set_tarif = tarif;
                tarif_tanggungan[ic] -= tarif;
                tarif = 0;
            } else {
                set_tarif = tarif_tanggungan[ic];
                tarif -= set_tarif;
                tarif_tanggungan[ic] = 0;
            }

            console.log("TARIF KOTOR", tarif);

            $(this).find(".subsidiasuransi_tindakan_" + ic).val(set_tarif);

            if (tarif == 0) {
                break;
            }

            if (tarif_tanggungan[ic] == 0) {
                ic++;
            }
        }

    });

    $("#form-rincianobatalkes tbody tr").each(function() {

        var tarif = parseFloat($(this).find(".tarif_kotor").val());
        var set_tarif = 0;

        while (tarif > 0) {
            set_tarif = 0;
            if (tarif <= tarif_tanggungan[ic]) {
                set_tarif = tarif;
                tarif_tanggungan[ic] -= tarif;
                tarif = 0;
            } else {
                set_tarif = tarif_tanggungan[ic];
                tarif -= set_tarif;
                tarif_tanggungan[ic] = 0;
            }

            console.log("TARIF KOTOR", tarif);

            $(this).find(".subsidiasuransi_oa_" + ic).val(set_tarif);

            if (tarif == 0) {
                break;
            }

            if (tarif_tanggungan[ic] == 0) {
                ic++;
            }
        }

    });








    // */
    formatNumberSemua();
    hitungTotalTindakan();
    hitungTotalOa();
    hitungMultiPenjamin();
}

function isBPJSNaikKelas(obj) {
    return $(obj).val() == CARABAYAR_ID_MEMBAYAR && is_naikkelas;
}

function setNilaiInacbgNaikKelas() {
    if ($("#checkBoxNaikKelas").is(":checked")) {

        var iurbayar = $(".form_naik_kelas .iurbayar").val();

        $("#tabel-multipenjamin tbody tr").each(function() {
            if ($(this).find(".multi_carabayar_id").val() == CARABAYAR_ID_MEMBAYAR) {
                $(this).find('.jmlpiutangasuransi_multi').val(formatThousandDecimal(iurbayar));
            }
        });

        setProporsionalMultiPenjaminDana();

    }
}



</script>