<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">

const INSTALASI_ID_RI = <?php echo Params::INSTALASI_ID_RI; ?>;
const INSTALASI_ID_ICU = <?php echo Params::INSTALASI_ID_ICU; ?>;
const CARABAYAR_ID_BPJS = <?php echo Params::CARABAYAR_ID_BPJS; ?>;
const CARABAYAR_ID_MEMBAYAR = <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>;
const KELASPELAYANAN_ID_KELAS_I = <?php echo Params::KELASPELAYANAN_ID_KELAS_I; ?>;
const KELASPELAYANAN_ID_KELAS_II = <?php echo Params::KELASPELAYANAN_ID_KELAS_II; ?>;
const KELASPELAYANAN_ID_KELAS_III = <?php echo Params::KELASPELAYANAN_ID_KELAS_III; ?>;
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

var iurbea_tipe = null;

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

    if (data.ada_iurbea == 1) {
        myAlert('Pasien sudah ditransaksikan Input Iur Bea, Jika ingin dilakukan penginputan kembali silahkan lakukan order batal terlebih dahulu');
        setKunjunganReset();
        $('.body_naikkelas').addClass('hide');
        $("#checkBoxNaikKelas").prop("checked", false).prop("disabled", true);
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
    


    carapembayaran = data.metode_pembayaran;

    // setAsuransiKelas();
    // setDataPembayar();
    console.log('sebelum penjamin 1: ' + '<?php echo $this->id ?>');

    if (data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?> || data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS_TENAGAKERJA ?>){


        $(".form_naik_kelas .totalbiayarumahsakit").val(formatThousandDecimal(data.total_tagihan));

        $(".input_admin_diskon").show();
        $(".input_selisih_bpjs").show();

        // console.log("KELAS PASIEN", data.kelaspelayanan_id, KELASPELAYANAN_ID_KELAS_III);
    
        var is_ri = false;
        $.each(instalasi_ri, function(i, v) {
            if (data.instalasi_id == v) {
                is_ri = true;
            }
        });
    
    
        /*
        if (!is_ri) {
            console.log("Kondisi 1");
            $('.body_naikkelas').addClass('hide');
            $("#checkBoxNaikKelas").prop("checked", false).prop("disabled", true);
        } else 
        */
        if (data.kelastanggungan_id == KELASPELAYANAN_ID_KELAS_III || data.kelastanggungan_id == null) {
            console.log("Kondisi 2");
            $('.body_naikkelas').addClass('hide');
            $("#checkBoxNaikKelas").prop("checked", false).prop("disabled", true);
            iurbea_tipe = null;
        } else {

            iurbea_tipe = null;
            if (data.kelastanggungan_id == KELASPELAYANAN_ID_KELAS_II && data.kelaspelayanan_id == KELASPELAYANAN_ID_KELAS_I) {
                iurbea_tipe = 'a';
            } else if (data.kelastanggungan_id == KELASPELAYANAN_ID_KELAS_I && (data.kelaspelayanan_id == KELASPELAYANAN_ID_VIP || data.kelaspelayanan_id == KELASPELAYANAN_ID_VVIP)) {
                iurbea_tipe = 'b';
            } else if (data.kelastanggungan_id == KELASPELAYANAN_ID_KELAS_II && (data.kelaspelayanan_id == KELASPELAYANAN_ID_VIP || data.kelaspelayanan_id == KELASPELAYANAN_ID_VVIP)) {
                iurbea_tipe = 'c';
            }

            setFormIurBiaya();


            console.log("Kondisi 3");
            $('.body_naikkelas').removeClass('hide');
            console.log("SET CEKLIS");
            $("#checkBoxNaikKelas").prop("checked", true).prop("disabled", false);
        }

        
    


    } else {
        $(".input_admin_diskon").show();
        $(".input_selisih_bpjs").show();

        $('.body_naikkelas').addClass('hide');
        $("#checkBoxNaikKelas").prop("checked", false).prop("disabled", true);

        $(".form_naik_kelas .input_naikkelas_manual").val("0,00");
        $(".form_naik_kelas .totalinacbg_naikkelasperawatan").val("0,00");
    }


    

    $("#form-datakunjungan > div > div > .judul").html('Data Kunjungan '+data.no_pendaftaran);
    $("#form-datakunjungan > div > div > .tombol").attr('style','display:block;');
    $("#form-datakunjungan > .box").addClass("well").removeClass("box");

    $("#form-datakunjungan > div").removeClass("animation-loading");
    $("#nama_pasien").focus();
}

function setFormIurBiaya() {
    $(".form_naik_kelas .control-group").hide().find(":input").prop("disabled", true);
    $(".form_naik_kelas .btn").hide();
    $(".form_naik_kelas .form_naikkelas_" + iurbea_tipe).show().find(":input").prop("disabled", false);

    $(".form_naik_kelas .input_naikkelas_manual").val("0,00");
    $(".form_naik_kelas .totalinacbg_naikkelasperawatan").val("0,00");

    $(".form_naik_kelas").data('tipe', iurbea_tipe);


    $(".btn_hitung").prop("title", "");

    switch (iurbea_tipe) {
        case "a":
            $(".label_inacbg_kelasperawatan").html("InaCBGS Kelas I");
            $(".label_inacbg_kelastanggungan").html("InaCBGS Kelas II");
            $(".btn_hitung").prop("title", "Iur Bea = InaCBGS Kelas I - InaCBGS Kelas II");
            break;
        case "b":
            $(".label_inacbg_kelastanggungan").html("InaCBGS Kelas I");
            $(".btn_hitung").prop("title", "- Jika (total biaya rumah sakit) < (InaCBGS Kelas I), maka selisih iur bea = 0\n"
                + "- Jika (total biaya rumah sakit) = (InaCBGS Kelas I), maka selisih iur bea = 0\n"
                + "- Jika (total biaya rumah sakit) > (InaCBGS Kelas I), maka: \n"
                + "    + jika (total biaya rs) - (InaCBGS Kelas I) < (iur bea maks 75%), maka selisih iur bea = (total biaya rs) - (InaCBGS Kelas I)\n"
                + "    + jika (total biaya rs) - (InaCBGS Kelas I) > (iur bea maks 75%), maka selisih iur bea = (InaCBGS Kelas I)"
            );
            break;
        case "c":
            $(".label_inacbg_kelasperawatan").html("InaCBGS Kelas I");
            $(".label_inacbg_kelastanggungan").html("InaCBGS Kelas II");
            $(".label_totalselisihkelastanggunganperawatan").html("Selisih InaCBGS Kelas I dan InaCBGS Kelas II");
            $(".btn_hitung").prop("title", 
                "- Parameter Perhitungan Iur Bea : (InaCBGS Kelas II) + (Selisih InaCBGS Kelas I dan InaCBGS Kelas II) + Iur Bea Max. 75%\n"
                + "- Parameter Perhitungan Iur Bea > Total Biaya Rumah Sakit, maka selisih iur bea = 0\n"
                + "- Parameter Perhitungan Iur Bea = Total Biaya Rumah Sakit, maka selisih iur bea = 0\n"
                + "- Parameter Perhitungan Iur Bea > Total Biaya Rumah Sakit, maka:\n"
                + "    + Jika (Total Biaya Rumah Sakit - Parameter Perhitungan Iur Bea) > Iur Bea Max. 75%, maka Iur Bayar Pasien = Iur Bea Max. 75% + (Selisih InaCBGS Kelas I dan InaCBGS Kelas II)\n"
                + "    + Jika (Total Biaya Rumah Sakit - Parameter Perhitungan Iur Bea) < Iur Bea Max. 75%, maka Iur Bayar Pasien = (Total Biaya Rumah Sakit - Parameter Perhitungan Iur Bea))"
            );
    }

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

    $(".dpjp").hide().find("input").val("");

    carapembayaran = "";

    console.log('sebelum penjamin 2');
}

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


function setVerifikasi() {
    if (requiredCheck($("#iurbeapasien-form"))) {

        $(".integer2, .float2, .integer-decimal").each(function(){
            $(this).val(unformatNumber($(this).val()));
        });
        disableOnSubmit($("#btn_submit"));

        $("#iurbeapasien-form").submit();
    }
}

function printBea() {
    var id = '<?php echo $model->iurbea_id; ?>';

    window.open('<?php echo $this->createUrl('printBea'); ?>&id=' + id + '&caraPrint=PRINT' , 'printwin', 'left=100,top=100,width=1000,height=640');
}

</script>