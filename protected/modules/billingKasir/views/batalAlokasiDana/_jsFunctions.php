
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">


const INSTALASI_ID_RI = <?php echo Params::INSTALASI_ID_RI; ?>;
const INSTALASI_ID_ICU = <?php echo Params::INSTALASI_ID_ICU; ?>;

var pendaftaran_id = "";
var carabayar_id = "";
var penjamin_id = "";
var carapembayaran = "";
var alokasidana_id = null;

var nilai_admin = 0;
var persen_admin = 0;
var is_load = false;


var total_subsidi_asuransi = 0;
var tgl_alokasi = null;

/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id, instalasi_id, penjamin_id, var_tgl_alokasi){
    $("#form-datakunjungan > div").addClass("animation-loading");

    console.log("ALOK 1", var_tgl_alokasi);

    const instalasi_ri = [INSTALASI_ID_RI, INSTALASI_ID_ICU, 79, 38, 14, 85, 100];

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
        data: {
            instalasi_id:instalasi_id, 
            pendaftaran_id:pendaftaran_id, 
            no_pendaftaran:no_pendaftaran, 
            no_rekam_medik:no_rekam_medik,
            pasienadmisi_id:pasienadmisi_id,
            penjamin_id:penjamin_id
        },
        dataType: "json",
        success:function(data){
			if (data.notif.ok == 0) {
				myAlert(data.notif.msg);
				$("#form-datakunjungan > div").removeClass("animation-loading");
				return false;
			} else if (data.notif.ok == 9) {
                myConfirm(data.notif.msg, "Peringatan!", function(r) {
                    if (r) {
                        tgl_alokasi = var_tgl_alokasi;
                        loadTagihanPasien(data);
                    }
                });
                $("#form-datakunjungan > div").removeClass("animation-loading");
                return false;
            }

            tgl_alokasi = var_tgl_alokasi;
            loadTagihanPasien(data);

            $("#form-datakunjungan > div").removeClass("animation-loading");

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

    carapembayaran = data.metode_pembayaran;

    

    $("#form-datakunjungan > div > div > .judul").html('Data Kunjungan '+data.no_pendaftaran);
    $("#form-datakunjungan > div > div > .tombol").attr('style','display:block;');
    $("#form-datakunjungan > .box").addClass("well").removeClass("box");

    $("#form-datakunjungan > div").removeClass("animation-loading");
    $("#nama_pasien").focus();

    loadAlokasiDanaUntukBatal();
}

function loadAlokasiDanaUntukBatal() {
    $.post('<?php echo $this->createUrl('loadAlokasi'); ?>', {
        pendaftaran_id: $("#pendaftaran_id").val(),
        tgl_alokasi: tgl_alokasi
    }, function(data) {
        $("#tab_alokasi tbody").html(data.html);
    }, 'json');
}

function setVerifikasi() {
    $("#batalalokasidana-form").submit();
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

    tgl_alokasi = null;
}

function resetPencarianRuangan() {
    $("#dialog_pasien_ruangan_id").val("");
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

</script>