<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<style>
    .checked td {
        background-color: yellow;
    }
</style>

<?php $konfig = KonfigsystemK::model()->find(); ?>
<?php $ctr = Yii::app()->controller->id ?>

<script type="text/javascript">
    var kk_id = "";
    var pemilik_bpjs = "";

    /**
     * set pasien lama
     * @param {type} pasien_id
     * @returns {undefined}
     */
    var otoval = 1; // untuk hitung rekam medik
    var isSetLama = false;

    function printRM1(pendaftaran_id) {
        window.open('<?php echo $this->createUrl('printRM1'); ?>&id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function printCasemixIdentitas(pendaftaran_id) {
        window.open('<?php echo $this->createUrl('printCasemixIdentitas'); ?>&id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function printKepalaLes(pendaftaran_id) {
        window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/infoKunjunganRJ/printKepalaLes'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=860,height=480');
    }




    function setPegawai(pegawai_id, nip) {
        $.post('<?php echo $this->createUrl('getDataPegawaiUntukPasienBaru'); ?>', {
            pegawai_id: pegawai_id,
            nip: nip
        }, function(data) {
            if (data.ok == 0) {
                myAlert(data.msg);
                $("#PPPasienM_nomorindukpegawai").val("").focus();
            } else {
                $("#<?php echo CHtml::activeId($modPasien, "pegawai_id"); ?>").val(data.res.pegawai_id);
                $("#<?php echo CHtml::activeId($modPasien, "jenisidentitas"); ?>").val(data.res.jenisidentitas.trim());
                $("#<?php echo CHtml::activeId($modPasien, "no_identitas_pasien"); ?>").val(data.res.noidentitas);
                $("#<?php echo CHtml::activeId($modPasien, "nama_pasien"); ?>").val(data.res.nama_pegawai.toUpperCase());
                $("#<?php echo CHtml::activeId($modPasien, "tempat_lahir"); ?>").val(data.res.tempatlahir_pegawai);
                $("#<?php echo CHtml::activeId($modPasien, "tanggal_lahir"); ?>").val(data.res.tgl_lahirpegawai);
                $("#<?php echo CHtml::activeId($modPasien, "statusperkawinan"); ?>").val(data.res.statusperkawinan);
                $("#<?php echo CHtml::activeId($modPasien, "golongandarah"); ?>").val(data.res.golongandarah);
                $("#<?php echo CHtml::activeId($modPasien, "rhesus"); ?>").val(data.res.rhesus);
                $("#<?php echo CHtml::activeId($modPasien, "alamat_pasien"); ?>").val(data.res.alamat_pegawai);
                $("#<?php echo CHtml::activeId($modPasien, "no_telepon_pasien"); ?>").val(data.res.notelp_pegawai);
                $("#<?php echo CHtml::activeId($modPasien, "no_mobile_pasien"); ?>").val(data.res.nomobile_pegawai).blur();
                $("#<?php echo CHtml::activeId($modPasien, "suku_id"); ?>").val(data.res.suku_id).change('rebuild');
                $("#<?php echo CHtml::activeId($modPasien, "alamatemail"); ?>").val(data.res.alamatemail);
                $("#<?php echo CHtml::activeId($modPasien, "pendidikan_id"); ?>").val(data.res.pendidikan_id);
                $("#<?php echo CHtml::activeId($modPasien, "warga_negara"); ?>").val(data.res.warganegara_pegawai);
                $("#<?php echo CHtml::activeId($modPasien, "agama"); ?>").val(data.res.agama);
                $("#<?php echo CHtml::activeId($modPasien, "is_ambilfoto"); ?>").val(0);

                setJenisKelaminPasien(data.res.jeniskelamin);
                setRhesusPasien(data.res.rhesus);
                setDaerahPasien(data.res.propinsi_id, data.res.kabupaten_id, data.res.kecamatan_id, data.res.kelurahan_id);
                setUmur(data.res.tgl_lahirpegawai);
                setKarcis();
            }
        }, 'json');
    }

    function setPasienLama(pasien_id, no_rekam_medik, is_manual) {

        console.log('cek pendaftaran rawat darurat');
        console.log('controller: <?= $ctr ?>');

        var ctr = '<?= $ctr ?>';

        if (isSetLama) return false;

        $("#form-pasien > div").addClass("animation-loading");
        setPasienBaru();
        isSetLama = true;

        var beforeOto = otoval;

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDataPasien'); ?>',
            data: {
                pasien_id: pasien_id,
                no_rekam_medik: no_rekam_medik,
                is_manual: is_manual
            },
            dataType: "json",
            success: function(data) {
                if (data.lebih) {
                    myAlert("No. RM digunakan untuk hitungan otomatis. Pilih antara 000001 - 347499");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#no_rekam_medik_baru").val("");
                    return false;
                }

                <?php // if ($this->id == "pendaftaranRawatInap"): 
                ?>

                if (data.adaInap) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang dirawat inap di " + data.listDaftar.ruangan.ruangan_nama + ".");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val("");
                    setPasienBaru();
                    isSetLama = false;
                    return false;
                }
                if (data.tindakLanjut) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                    Hari ini menunggu tindak lanjut ke rawat inap di " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + ".");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val("");
                    setPasienBaru();
                    isSetLama = false;
                    return false;
                }
                if (data.adaDaftar) {
                    myAlert("Pasien " + data.listDaftar.pasien.namadepan + data.listDaftar.pasien.nama_pasien + " (" + data.listDaftar.no_pendaftaran + ")\n\
                Hari ini sedang di instalasi " + data.listDaftar.instalasi.instalasi_nama + " -> " + data.listDaftar.ruangan.ruangan_nama + " dengan status pemeriksan '" +
                        data.listDaftar.statusperiksa + "'.");
                    $("#form-pasien > div").removeClass("animation-loading");
                    $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val("");
                    setPasienBaru();
                    isSetLama = false;
                    return false;
                }
                if (data.is_kabur) {
                    myAlert("PASIEN BELUM MENYELESAIKAN ADMINISTRASI KUNJUNGAN SEBELUMNYA!!!");
                }

                var ctrl = '<?php echo Yii::app()->controller->id; ?>';

                if (data.statusrekammedis.trim() == "<?php echo Params::STATUSREKAMMEDIS_AKTIF ?>") {
                    $("#cari_nomorindukpegawai").val(data.nomorindukpegawai); // untuk load filed NIP
                    $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                    $("#<?php echo CHtml::activeId($modPasien, 'pasien_id'); ?>").val(data.pasien_id);
                    $("#<?php echo CHtml::activeId($modPasien, "jenisidentitas"); ?>").val(data.jenisidentitas);
                    $("#<?php echo CHtml::activeId($modPasien, "no_jamkespa"); ?>").val(data.no_jamkespa);
                    $("#<?php echo CHtml::activeId($modPasien, "no_identitas_pasien"); ?>").val(data.no_identitas_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "namadepan"); ?>").val(data.namadepan);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_pasien"); ?>").val(data.nama_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_bin"); ?>").val(data.nama_bin);
                    $("#<?php echo CHtml::activeId($modPasien, "tempat_lahir"); ?>").val(data.tempat_lahir);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_ayah"); ?>").val(data.nama_ayah);
                    $("#<?php echo CHtml::activeId($modPasien, "nama_ibu"); ?>").val(data.nama_ibu);
                    $("#<?php echo CHtml::activeId($modPasien, "tanggal_lahir"); ?>").val(data.tanggal_lahir);
                    $("#<?php echo CHtml::activeId($modPasien, "kelompokumur_id"); ?>").val(data.kelompokumur_id);
                    $("#<?php echo CHtml::activeId($modPasien, "statusperkawinan"); ?>").val(data.statusperkawinan);
                    $("#<?php echo CHtml::activeId($modPasien, "golongandarah"); ?>").val(data.golongandarah);
                    $("#<?php echo CHtml::activeId($modPasien, "rhesus"); ?>").val(data.rhesus);
                    $("#<?php echo CHtml::activeId($modPasien, "alamat_pasien"); ?>").val(data.alamat_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "alamat_domisili_pasien"); ?>").val(data.alamat_domisili_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "rt"); ?>").val(data.rt);
                    $("#<?php echo CHtml::activeId($modPasien, "rw"); ?>").val(data.rw);
                    $("#<?php echo CHtml::activeId($modPasien, "no_telepon_pasien"); ?>").val(data.no_telepon_pasien);
                    $("#<?php echo CHtml::activeId($modPasien, "no_mobile_pasien"); ?>").val(data.no_mobile_pasien).blur();
                    $("#no_mobile_pasien").val(data.no_mobile_pasien).blur();
                    $("#<?php echo CHtml::activeId($modPasien, "suku_id"); ?>").val(data.suku_id).change('rebuild');
                    $("#<?php echo CHtml::activeId($modPasien, "alamatemail"); ?>").val(data.alamatemail);
                    $("#<?php echo CHtml::activeId($modPasien, "anakke"); ?>").val(data.anakke);
                    $("#<?php echo CHtml::activeId($modPasien, "jumlah_bersaudara"); ?>").val(data.jumlah_bersaudara);
                    $("#<?php echo CHtml::activeId($modPasien, "pendidikan_id"); ?>").val(data.pendidikan_id);
                    $("#<?php echo CHtml::activeId($modPasien, "pekerjaan_id"); ?>").val(data.pekerjaan_id);
                    $("#<?php echo CHtml::activeId($modPasien, "agama"); ?>").val(data.agama);
                    $("#<?php echo CHtml::activeId($modPasien, "warga_negara"); ?>").val(data.warga_negara);
                    $("#<?php echo CHtml::activeId($modPasien, "is_ambilfoto"); ?>").val(0);


                    if (data.nofingerprint != null) {
                        $("#pesanVerifikasi").html("Pasien Sudah Melakukan Pendaftaran Sidik Jari " + data.nofingerprint)
                    } else {
                        $("#pesanVerifikasi").html("Pasien Belum Melakukan Pendaftaran Sidik jari ")
                    }

                    if (data.pegawai_id !== "" && data.pegawai_id !== null) {
                        $("#<?php echo CHtml::activeId($modPasien, 'pegawai_id'); ?>").val(data.pegawai_id);
                        $("#<?php echo CHtml::activeId($modPegawai, 'nomorindukpegawai'); ?>").val(data.nomorindukpegawai);
                        $("#<?php echo CHtml::activeId($modPegawai, 'nama_pegawai'); ?>").val(data.nama_pegawai);
                        $("#<?php echo CHtml::activeId($modPegawai, 'gelardepan'); ?>").val(data.gelardepan);
                        $("#<?php echo CHtml::activeId($modPegawai, 'gelarbelakang_nama'); ?>").val(data.gelarbelakang_nama);
                        $("#<?php echo CHtml::activeId($modPegawai, 'unit_perusahaan'); ?>").val(data.unit_perusahaan);
                        $("#<?php echo CHtml::activeId($modPegawai, 'jabatan_nama'); ?>").val(data.jabatan_nama);
                        tampilFormPegawai();
                    } else {
                        sembunyiFormPegawai();
                    }

                    $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
                    if (data.photopasien != null && data.photopasien != "") { //set photo
                        $("#<?php echo CHtml::activeId($modPasien, "photopasien"); ?>").val(data.photopasien);
                        $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
                    }

                    setJenisKelaminPasien(data.jeniskelamin);
                    setRhesusPasien(data.rhesus);
                    setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, data.kelurahan_id);
                    setUmur(data.tanggal_lahir);
                    setKarcis();
                    setRiwayatKunjunganPasien(data.pasien_id);
                    setAsuransiPasienLama(data.pasien_id);
                    getRuanganPoliklinikPasien();

                    if (getDataRiwayatVaksinasi != null) {
                        getDataRiwayatVaksinasi(data.pasien_id);
                    }

                    if (ctr == 'pendaftaranRawatDarurat') {
                        $("#<?php echo CHtml::activeId($model, 'kelaspelayanan_id'); ?>").val(6).change(); //<<RND-820 (custom)
                    }



                    // $(".rmlama").prop("checked",true);
                    // $(".rb_rm").eq(1).click();
                    // switchOtomatis($(".rb_rm").eq(1));

                    $(".rb_rm").eq(0).click();
                    $(".rmlama").prop("checked", true);

                    switchOtomatis($(".rb_rm").eq(0));
                    $('.pj_sb').show()
                    $("#form-pasien > legend > .judul").html('Data Pasien Lama ');
                    $("#form-pasien > legend > .tombol").attr('style', 'display:true;');
                    $("#form-pasien > .box").addClass("well").removeClass("box");

                    validasiBpjs();
                } else {
                    if (confirm("Apakah anda akan menggunakan No. Rekam Medik Non-Aktif ?")) {
                        $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                        $("#<?php echo CHtml::activeId($modPasien, 'pasien_id'); ?>").val(data.pasien_id);

                        $("#form-pasien > legend > .judul").html('Data Pasien No. Rekam Medik Lama ');
                        $("#form-pasien > legend > .tombol").attr('style', 'display:true;');
                        $("#form-pasien > .box").addClass("well").removeClass("box");
                        $("#<?php echo CHtml::activeId($modPasien, 'jenisidentitas'); ?>").focus();
                    }
                }
                $("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").focus(); //<<RND-820 (custom)
                window.scrollBy(0, 380); //<<RND-820 (custom)
                $("#form-pasien > div").removeClass("animation-loading");
                isSetLama = false;
                hideHitunganRM();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (!is_manual) myAlert("Data Pasien tidak ditemukan!");
                else $("#no_rekam_medik_baru").val(no_rekam_medik);

                isSetLama = false;
                $("#form-pasien > div").removeClass("animation-loading");

            }
        });
    }



    function setPasienLamaNomor() {
        var nik = $(".nik").val();

        if (nik == "") return false;

        $("#form-pasien > div").addClass("animation-loading");

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getDataPasienNIK'); ?>',
            data: {
                nik: nik
            },
            dataType: "json",
            success: function(data) {
                $("#form-pasien > div").removeClass("animation-loading");

                if (data.id != 0) {
                    setPasienLama(data.id);
                }
            }
        });

    }

    /**
     * set form pasien ke pasien baru
     * @returns {undefined} */
    function setPasienBaru() {
        if (setPasienLama) return false;


        $("#<?php echo CHtml::activeId($model, 'umur'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'pasien_id'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "jenisidentitas"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "no_identitas_pasien"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "namadepan"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "alamat_domisili_pasien"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "nama_pasien"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "nama_bin"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "tempat_lahir"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "nama_ayah"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "nama_ibu"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "tanggal_lahir"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "kelompokumur_id"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "jeniskelamin"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "statusperkawinan"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "golongandarah"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "rhesus"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "alamat_pasien"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "rt"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "rw"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "propinsi_id"); ?>").val(<?php echo $modPasien->propinsi_id; ?>).multiselect('rebuild');
        $("#<?php echo CHtml::activeId($modPasien, "kabupaten_id"); ?>").val(<?php echo $modPasien->kabupaten_id; ?>).multiselect('rebuild');
        $("#<?php echo CHtml::activeId($modPasien, "kecamatan_id"); ?>").val(<?php echo $modPasien->kecamatan_id; ?>).multiselect('rebuild');
        $("#<?php echo CHtml::activeId($modPasien, "kelurahan_id"); ?>").val("<?php echo $modPasien->kelurahan_id; ?>").multiselect('rebuild');
        $("#<?php echo CHtml::activeId($modPasien, "no_telepon_pasien"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "no_mobile_pasien"); ?>").val("").blur();
        $("#<?php echo CHtml::activeId($modPasien, "suku_id"); ?>").val('<?php echo $modPasien->suku_id; ?>').change('rebuild');
        $("#<?php echo CHtml::activeId($modPasien, "alamatemail"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "anakke"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "jumlah_bersaudara"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "pendidikan_id"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "pekerjaan_id"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "agama"); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, "warga_negara"); ?>").val("<?php echo $modPasien->warga_negara; ?>");
        $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val("");
        $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").val("");
        setAsuransiBadakReset();

        $("#<?php echo CHtml::activeId($modPasien, "photopasien"); ?>").val("");
        $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');

        setJenisKelaminPasien("");
        setKarcis();
        setPegawaiReset();
        showHitunganRM();

        $("#form-pasien > legend > .judul").html('Data Pasien Baru ');
        $("#form-pasien > legend > .tombol").attr('style', 'display:none;');
        $("#form-pasien > .well").addClass("box").removeClass("well");
        $("#cari_no_rekam_medik").val("");
        $("#cari_nomorindukpegawai").val("");
    }



    function cekNoRM() {
        // var norm = $("#no_rekam_medik_baru").val();
        // var digit = <?php echo $konfig->jmldigitrm; ?>;

        // if ($(".rb_rm").eq(1).is(":checked")) {
        //     if (norm != '') {
        //         if (norm.trim().length != digit) {
        //             myAlert("No. Rekam Medik harus berisi " + digit + " digit angka");
        //             $("#no_rekam_medik_baru").val('');
        //             return false;
        //         } else {
        //             $.ajax({
        //                 type: 'POST',
        //                 url: '<?php echo $this->createUrl('/ActionAjax/cekNoRM/'); ?>',
        //                 data: {
        //                     no_rekam_medik: norm
        //                 },
        //                 dataType: "json",
        //                 success: function(data) {
        //                     if (norm > data.no_rekam_medik) {
        //                         myAlert("<p style=\"margin: 0; text-align: center;\">Maaf No. Rekam Medik <b>Invalid</b>, \n\
        //                          No. Rekam Medik Terakhir [<b>" + data.no_rekam_medik + "</b>]</p>");
        //                         $("#no_rekam_medik_baru").val("");
        //                         return false;
        //                     } else {

        //                     }

        //                 },
        //                 //error: function (jqXHR, textStatus, errorThrown) {

        //                 //}
        //             });
        //             //return false;
        //         }
        //     }
        // }
    }
    /**
     * untuk refresh / reset form pegawai
     * @returns {undefined}
     */
    function setPegawaiReset() {
        $("#<?php echo CHtml::activeId($modPasien, 'pegawai_penanggungjawab_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'nomorindukpegawai') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'nama_pegawai') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'gelardepan') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'gelarbelakang_nama') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'unit_perusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'jabatan_nama') ?>").val("");
    }

    function setAsuransiLama() {
        $(".judulasuransi").html("Asuransi Lama");
        $(".refreshasuransi").attr("style", "display:true;");
    }

    function setAsuransiBadak() {
        var pasien_id = $("#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>").val();
        var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
        var pegawai_id = $("#PPPasienM_pegawai_id").val();
        //	if(pasien_id!=''){
        $("#form-asubadak").addClass("animation-loading");
        $("#form-asudepartemen").addClass("animation-loading");
        $("#form-asupekerja").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetAsuransiBadak'); ?>',
            data: {
                pasien_id: pasien_id,
                penjamin_id: penjamin_id,
                pegawai_id: pegawai_id
            },
            dataType: "json",
            success: function(data) {
                setAsuransiBadakReset();
                if (data != null) {
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nopeserta') ?>").val(data.nopeserta);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'asuransipasien_id') ?>").val(data.asuransipasien_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'namaperusahaan') ?>").val(data.namaperusahaan);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'hubkeluarga') ?>").val(data.hubkeluarga);

                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'asuransipasien_id') ?>").val(data.asuransipasien_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'namaperusahaan') ?>").val(data.namaperusahaan);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nomorpokokperusahaan') ?>").val(data.nomorpokokperusahaan);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nopeserta') ?>").val(data.nopeserta);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);

                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'asuransipasien_id') ?>").val(data.asuransipasien_id);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nopeserta') ?>").val(data.nopeserta);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
                    $("#<?php echo CHtml::activeId($modPegawai, 'alamat_pegawai') ?>").val(data.alamat_pegawai);
                    $("#<?php echo CHtml::activeId($modPegawai, 'notelp_pegawai') ?>").val(data.notelp_pegawai);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
                }
                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") { ?>
                    // getAsuransiNoKartuIGD(data.nopeserta);
                <?php }; ?>

                $("#form-asubadak").removeClass("animation-loading");
                $("#form-asudepartemen").removeClass("animation-loading");
                $("#form-asupekerja").removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        //	}
    }

    function setAsuransiBadakReset() {
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'tgl_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, 'hubkeluarga') ?>").val("");

        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'tgl_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, 'hubkeluarga') ?>").val("");

        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'tgl_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienPekerja, 'hubkeluarga') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'alamat_pegawai') ?>").val("");
        $("#<?php echo CHtml::activeId($modPegawai, 'notelp_pegawai') ?>").val("");
    }

    function setAsuransiBaru() {
        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namaperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'tgl_konfirmasi') ?>").val("");

        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'asuransipasien_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nomorpokokperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namaperusahaan') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'status_konfirmasi') ?>").val("");
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'tgl_konfirmasi') ?>").val("");

        setAsuransiBadakReset();

        $(".judulasuransi").html("Asuransi Baru");
        $(".refreshasuransi").attr("style", "display:none;");
    }
    /**
     * load otomatis asuransi pasien terakhir
     * @returns {undefined}
     */
    function setAsuransiPasienLama(pasien_id) {
        var pegawai_id = $("#PPPasienM_pegawai_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetAsuransiPasienLama'); ?>',
            data: {
                pasien_id: pasien_id
            },
            dataType: "json",
            success: function(data) {
                if (data != null) {
                    if (data.carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?>) {
                        validasiBpjs(data.carabayar_id, pasien_id);
                    }

                    var ctr = '<?= Yii::app()->controller->id ?>';

                    if (ctr == 'pendaftaranRawatDarurat') {
                        console.log('lah, gak berubah?');
                        $("#<?php echo CHtml::activeId($model, 'kelaspelayanan_id'); ?>").val(6).change(); //<<RND-820 (custom)
                    }

                    if (confirm("Apakah pasien ini akan menggunakan penjamin " + data.penjamin_nama + "?")) {


                        //				}
                        //				confirm("Apakah pasien ini akan menggunakan penjamin "+data.penjamin_nama+"?","Konfirmasi!",function(r) {
                        //					if(r){

                        var datacarabayar_id = data.carabayar_id;
                        var datalistPenjamin = data.listPenjamin;
                        var datapenjamin_id = data.penjamin_id;
                        var datanopeserta = data.nopeserta;
                        var dataasuransipasien_id = data.asuransipasien_id;
                        var datanokartuasuransi = data.nokartuasuransi;
                        var datanamapemilikasuransi = data.namapemilikasuransi;
                        var datanomorpokokperusahaan = data.nomorpokokperusahaan;
                        var datakelastanggunganasuransi_id = data.kelastanggunganasuransi_id;
                        var datanamaperusahaan = data.namaperusahaan;
                        var datastatus_konfirmasi = data.status_konfirmasi;
                        var datatgl_konfirmasi = data.tgl_konfirmasi;

                        $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val(datacarabayar_id).multiselect('rebuild');
                        $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").html(datalistPenjamin).multiselect('rebuild');
                        $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").val(datapenjamin_id).multiselect('rebuild');

                        // $.ajax({
                        //	type:'POST',
                        //	url:'<?php echo $this->createUrl('CekCaraBayarBadak'); ?>',
                        //	data: {pasien_id: pasien_id,pegawai_id:pegawai_id},
                        //	dataType: "json",
                        //	success:function(data){
                        //		if(data.status === true){

                        setFormAsuransi(datacarabayar_id);
                        $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val(datacarabayar_id);
                        $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").html(datalistPenjamin).change();
                        setTimeout('$("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").val(' + datapenjamin_id + ');', 1000);

                        setKelasTanggunganDrop();
                        if (datacarabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?>) {
                            //alert('asdasd');
                            <?php if (Yii::app()->user->getState('isbridging') == true) { ?>
                                <?php if (strtolower($this->id) != "pendaftaranrawatdarurat") { ?>
                                    getAsuransiNoKartu(datanopeserta, data);
                                <?php }; ?>

                                //alert('asdad');
                                //alert("asd");
                            <?php } else { ?>

                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nopeserta') ?>").val(datanopeserta);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') ?>").val(dataasuransipasien_id);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') ?>").val(datanokartuasuransi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') ?>").val(datanamapemilikasuransi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') ?>").val(datanomorpokokperusahaan);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?>").val(datakelastanggunganasuransi_id);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namaperusahaan') ?>").val(datanamaperusahaan).change().multiselect('rebuild');
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'status_konfirmasi') ?>").val(datastatus_konfirmasi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'tgl_konfirmasi') ?>").val(datatgl_konfirmasi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nominal_tanggungan') ?>").val(formatNumber(data.nominal_tanggungan));
                            <?php } ?>
                            validasiBpjs();
                            //}else if((datacarabayar_id == <?php echo Params::CARABAYAR_ID_BADAK; ?>) || (datacarabayar_id == <?php echo Params::CARABAYAR_ID_DEP_BADAK; ?>) || (datacarabayar_id == <?php echo Params::CARABAYAR_ID_PEKERJA; ?>)){
                            //	setAsuransiBadak(data);
                        } else {
                            $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nopeserta') ?>").val(datanopeserta);
                            $("#<?php echo CHtml::activeId($modAsuransiPasien, 'asuransipasien_id') ?>").val(dataasuransipasien_id);
                            $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') ?>").val(datanokartuasuransi);
                            $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') ?>").val(datanamapemilikasuransi);
                            $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nomorpokokperusahaan') ?>").val(datanomorpokokperusahaan);
                            $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?>").val(datakelastanggunganasuransi_id);
                            $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namaperusahaan') ?>").val(datanamaperusahaan).change().multiselect('rebuild')
                            $("#<?php echo CHtml::activeId($modAsuransiPasien, 'status_konfirmasi') ?>").val(datastatus_konfirmasi);
                            $("#<?php echo CHtml::activeId($modAsuransiPasien, 'tgl_konfirmasi') ?>").val(datatgl_konfirmasi);
                            $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nominal_tanggungan') ?>").val(formatNumber(data.nominal_tanggungan));
                        }

                        //}else{
                        //	myAlert(data.pesan);
                        //	$("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").val("");
                        //	$("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val("");
                        //}
                        //},
                        //	error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                        //});

                        setKarcis(2);
                    }
                    //				});
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set input radio button jenis kelamin
     * @param {type} jk
     * @returns {undefined}
     */
    function setJenisKelaminPasien(jk) {
        $('input[name$="[jeniskelamin]"][type="radio"]').each(function() {
            if ($(this).val() == $.trim(jk)) {
                $(this).attr('checked', true);
            }
        });
    }
    /**
     * set input radio button rhesus
     * @param {type} rh
     * @returns {undefined}
     */
    function setRhesusPasien(rh) {
        $('input[name*="[rhesus]"]').each(function() {
            if (this.value == $.trim(rh))
                $(this).attr('checked', true);
        });
    }


    //VALIDASI BPJS
    function validasiBpjs(carabayarid, pasien_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('ValidasiBpjs'); ?>',
            data: {
                carabayar_id: carabayarid,
                pasien_id: pasien_id
            },
            dataType: "json",
            success: function(data) {
                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                    setChangeStatusKecelakaan();

                <?php endif  ?>
                if (data.message != "") {
                    $('#PPPendaftaranT_carabayar_id').val(null);
                    $('#PPPendaftaranT_penjamin_id').val(null);
                    // sembunyiFormBpjs()
                    $('#form-bpjs').hide()

                    myAlert(data.message);

                    return false;
                }
                // console.log(data)
                //$('#dialog-verifikasi > .dialog-content').html(data.content);
                // if (data.ok == 1){							
                // 	$('#dialog-verifikasi > .dialog-content').html(data.content);
                // }else{
                // 	$('#dialog-verifikasi > .dialog-content').html('');
                // 	$('#dialog-verifikasi').dialog("close");
                // 	alert(data.msg);
                // }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set propinsi, kabupaten, kecamatan, dan kelurahan
     * @param {type} propinsi_id
     * @param {type} kabupaten_id
     * @param {type} kecamatan_id
     * @param {type} kalurahan_id
     * @returns {undefined}
     */
    function setDaerahPasien(propinsi_id, kabupaten_id, kecamatan_id, kelurahan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownDaerahPasien'); ?>',
            data: {
                propinsi_id: propinsi_id,
                kabupaten_id: kabupaten_id,
                kecamatan_id: kecamatan_id,
                kelurahan_id: kelurahan_id
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPasien, "propinsi_id"); ?>").html(data.listPropinsi).multiselect('rebuild');
                $("#<?php echo CHtml::activeId($modPasien, "kabupaten_id"); ?>").html(data.listKabupaten).multiselect('rebuild');
                $("#<?php echo CHtml::activeId($modPasien, "kecamatan_id"); ?>").html(data.listKecamatan).multiselect('rebuild');
                $("#<?php echo CHtml::activeId($modPasien, "kelurahan_id"); ?>").html(data.listKelurahan).multiselect('rebuild');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set nama depan berdasarkan umur, jenis kelamin dan status perkawinan
     *
     * @returns {undefined} */
    function setNamaDepan() {

        var statusperkawinan = $('#PPPasienM_statusperkawinan').val();
        var namadepan = $('#PPPasienM_namadepan');
        var umur = $("#<?php echo CHtml::activeId($model, 'umur'); ?>").val().substr(0, 2);

        if (isNaN(umur)) {
            umur = 0;
        }
        umur = parseInt(umur);



        if (umur <= 5) {
            var namadepan = $('#PPPasienM_namadepan').val('By. ');
            if (statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR") {
                $('#PPPasienM_statusperkawinan').val('');
                alert('Maaf status perkawinan belum cukup usia');
            }
        } else if (umur <= 14) { //
            var namadepan = $('#PPPasienM_namadepan').val('An. ');
            if (statusperkawinan.length > 0 && statusperkawinan != "DIBAWAH UMUR") {
                $('#PPPasienM_statusperkawinan').val('');
                alert('Maaf status perkawinan belum cukup usia');
            }
        } else {
            ;
            if ($('#PPPasienM_jeniskelamin_0').is(':checked')) {
                if (statusperkawinan !== 'JANDA') {
                    var namadepan = $('#PPPasienM_namadepan').val('Tn. ');
                } else {
                    alert('Silakan pilih status pernikahan yang sesuai!');
                    $('#PPPasienM_statusperkawinan').val('KAWIN');
                    var namadepan = $('#PPPasienM_namadepan').val('Tn. ')
                }

            }

            if ($('#PPPasienM_jeniskelamin_1').is(':checked')) {
                $('#PPPasienM_namadepan').val('Nn. ');
                if (statusperkawinan !== 'DUDA') {
                    var namadepan = $('#PPPasienM_namadepan').val('Nn. ');
                    if (statusperkawinan === 'KAWIN' || statusperkawinan == 'JANDA' || statusperkawinan == 'NIKAH SIRIH' || statusperkawinan == 'POLIGAMI') {
                        var namadepan = $('#PPPasienM_namadepan').val('Ny. ');
                    } else {
                        var namadepan = $('#PPPasienM_namadepan').val('Nn. ');
                    }
                } else {
                    alert('Silakan pilih status pernikahan yang sesuai!');
                    $('#PPPasienM_statusperkawinan').val('KAWIN');
                    var namadepan = $('#PPPasienM_namadepan').val('Ny. ');
                }
            }

            if (statusperkawinan == "DIBAWAH UMUR") {
                alert('Silakan pilih status pernikahan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
            }
        }
    }
    /**
     * set nilai tanggal_lahir dari umur
     * @param {type} obj
     * @returns {undefined} */
    function setTglLahir(obj) {
        var str = obj.value;
        obj.value = str.replace(/_/gi, "0");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetTanggalLahir'); ?>',
            data: {
                umur: obj.value
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPasien, "tanggal_lahir"); ?>").val(data.tanggal_lahir);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set nilai umur dari tanggal_lahir
     * @param {type} tanggal_lahir
     * @returns {undefined} */
    function setUmur(tanggal_lahir) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetUmur'); ?>',
            data: {
                tanggal_lahir: tanggal_lahir
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "umur"); ?>").val(data.umur);
                setNamaDepan();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set nilai tanggal_lahir dari umur
     * @param {type} obj
     * @returns {undefined} */
    function setTglLahirPjp(obj) {
        var str = obj.value;
        obj.value = str.replace(/_/gi, "0");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetTanggalLahir'); ?>',
            data: {
                umur: obj.value
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPenanggungJawab, "tgllahir_pj"); ?>").val(data.tanggal_lahir);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set nilai umur dari tanggal_lahir
     * @param {type} tanggal_lahir
     * @returns {undefined} */
    function setUmurPjp(tanggal_lahir) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetUmur'); ?>',
            data: {
                tanggal_lahir: tanggal_lahir
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPenanggungJawab, "umur_pj"); ?>").val(data.umur);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /** bersihkan dropdown kecamatan */
    function setClearDropdownKecamatan() {
        $(input_kecamatan).find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        $(input_kecamatan).multiselect('rebuild');
    }
    /** bersihkan dropdown kelurahan */
    function setClearDropdownKelurahan() {
        $(input_kelurahan).find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        $(input_kelurahan).multiselect('rebuild');
    }
    /**
     * set dropdown dokter ruangan
     * @param {type} ruangan_id
     * @param {type} pegawai_id
     * @returns {undefined}
     */
    function setDropdownDokter(ruangan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownDokter'); ?>',
            data: {
                ruangan_id: ruangan_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "pegawai_id"); ?>").html(data.listDokter);
                cekPilihSatu($("#<?php echo CHtml::activeId($model, "pegawai_id"); ?>"));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set dropdown jeniskasuspenyakit_id
     * @param {type} ruangan_id
     * @returns {undefined} */
    function setDropdownJeniskasuspenyakit(ruangan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownJeniskasuspenyakit'); ?>',
            data: {
                ruangan_id: ruangan_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "jeniskasuspenyakit_id"); ?>").html(data.listKasuspenyakit);
                $("#<?php echo CHtml::activeId($model, "jeniskasuspenyakit_id"); ?>").val(kk_id);
                cekPilihSatu($("#<?php echo CHtml::activeId($model, "jeniskasuspenyakit_id"); ?>"));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setDropDownRuangan(jeniskasuspenyakit_id) {
        <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
            var instalasi_id = "<?php echo Params::INSTALASI_ID_RD; ?>";
        <?php elseif (strtolower($this->id) == "pendaftaranrawatjalan") : ?>
            var instalasi_id = "<?php echo Params::INSTALASI_ID_RJ; ?>";
        <?php elseif (strtolower($this->id) == "pendaftaranpersalinan") : ?>
            var instalasi_id = "<?php echo Params::INSTALASI_ID_PERSALINAN; ?>";
        <?php endif; ?>
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setDropDownRuangan'); ?>',
            data: {
                jeniskasuspenyakit_id: jeniskasuspenyakit_id,
                instalasi_id: instalasi_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($model, "ruangan_id"); ?>").html(data.listRuangan).multiselect('rebuild');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setSMF(kodePenyakit) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setSMF'); ?>',
            data: {
                kodePenyakit: kodePenyakit
            }, //
            dataType: "json",
            success: function(data) {
                console.log(data, 'data');
                $("#<?php echo CHtml::activeId($model, "jeniskasuspenyakit_id"); ?>").val(data.listSMF).multiselect('rebuild');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set dropdown status hubungan keluarga pada form asuransi pt badak
     * @param {type} ruangan_id
     * @returns {undefined} */
    function setDropdownStatushubungankeluarga(penjamin_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setDropdownStatushubungankeluarga'); ?>',
            data: {
                penjamin_id: penjamin_id
            }, //
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modAsuransiPasienBadak, "hubkeluarga"); ?>").html(data.statushubungankeluarga);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * menampilkan karcis
     */
    function setKarcis(asalrujukan_idd = null) {
        var kelaspelayanan_id = $("#<?php echo CHtml::activeId($model, "kelaspelayanan_id"); ?>").val();
        var ruangan_id = $("#<?php echo CHtml::activeId($model, "ruangan_id"); ?>").val();
        var penjamin_id = $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").val();
        var carabayar_id = $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val();
        var pasien_id = $("#<?php echo CHtml::activeId($modPasien, "pasien_id"); ?>").val();
        var no_rekam_medik = $("#no_rekam_medik_baru").val();
        if (asalrujukan_idd == 2) {
            asalrujukan_id = $("#PPRujukanbpjsT_asalrujukan_id").val()
        } else if (asalrujukan_idd == 1) {
            asalrujukan_id = $("#PPRujukanT_asalrujukan_id").val()
        } else {
            asalrujukan_id = "";
        }

        if (carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?>) {
            asalrujukan_id = $("#PPRujukanbpjsT_asalrujukan_id").val()
        }

        if (asalrujukan_idd == 4) {
            asalrujukan_id = $("#PPRujukanbpjsT_asalrujukan_id").val()
        } else if (asalrujukan_idd == 3) {
            asalrujukan_id = ""
        }



        //alert(kelaspelayanan_id);


        if (kelaspelayanan_id !== "" && ruangan_id !== "" && penjamin_id !== "") {
            $("#form-karcis").addClass("animation-loading");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('SetKarcis'); ?>',
                data: {
                    kelaspelayanan_id: kelaspelayanan_id,
                    ruangan_id: ruangan_id,
                    penjamin_id: penjamin_id,
                    pasien_id: pasien_id,
                    no_rekam_medik: no_rekam_medik,
                    asalrujukan_id: asalrujukan_id,
                }, //
                dataType: "json",
                success: function(data) {
                    $("#form-karcis #content-karcis-html").html(data.listKarcis);
                    $("#form-karcis").removeClass("animation-loading");
                    $("form").find('.integer-decimal').each(function() {
                        $(this).val(formatThousandDecimal($(this).val()));
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            $("#content-karcis-html").html("");
        }

    }
    /** control accordion detail pasien */
    $('#form-detailpasien > div > .accordion-heading').click(function() {
        //    console.log("Detail Pasien Di Klik!");
    });
    /** control accordion kunjungan */
    $('#form-kunjungan > div > .accordion-heading').click(function() {
        //    console.log("Rujukan Di Klik!");

        var is_kunjungan = $("#<?php echo CHtml::activeId($model, "is_kunjungan"); ?>");
        if (is_kunjungan.val() > 0) { //hide
            is_kunjungan.val(0);
        } else { //show
            is_kunjungan.val(1);
            $(".multiselect").attr("disabled", false);
            $(".multiselect").removeClass("disabled");

        }
    });
    /** control accordion rujukan */
    $('#form-rujukan > div > .accordion-heading').click(function() {
        //    console.log("Rujukan Di Klik!");
        var is_pasienrujukan = $("#<?php echo CHtml::activeId($model, "is_pasienrujukan"); ?>");
        if (is_pasienrujukan.val() > 0) { //hide
            is_pasienrujukan.val(0);
        } else { //show
            is_pasienrujukan.val(1);
        }
    });
    /** control accordion rujukan */
    $('#form-bpjs > div > .accordion-heading').click(function() {
        //    console.log("Rujukan Di Klik!");
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
        if (is_bpjs.val() > 0) { //hide
            is_bpjs.val(0);
        } else { //show
            is_bpjs.val(2);
        }
    });
    /** control accordion rujukan */
    $('#form-karcis > div > .accordion-heading').click(function() {
        //    console.log("Karcis Di Klik!");
        var is_adakarcis = $("#<?php echo CHtml::activeId($model, "is_adakarcis"); ?>");
        if (is_adakarcis.val() > 0) { //hide
            is_adakarcis.val(1); // dipaksakan ada meskipun accordion disembunyikan
        } else { //show
            is_adakarcis.val(1);
        }
    });
    /** control accordion penanggung jawab pasien */
    $('#form-pjpasien > div > .accordion-heading').click(function() {
        //    console.log("Detail PJ Pasien Di Klik!");
        var is_adapjpasien = $("#<?php echo CHtml::activeId($model, "is_adapjpasien"); ?>");
        if (is_adapjpasien.val() > 0) { //hide
            is_adapjpasien.val(0);
        } else { //show
            is_adapjpasien.val(1);
        }
    });

    function clearRujukan() {
        $('#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id') ?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        $('#<?php echo CHtml::activeId($modRujukan, 'nama_perujuk') ?>').val('');
    }
    /**
     * set otomatis nama_perujuk dari dropdown rujukandari_id
     * @returns {Boolean}
     */
    function setNamaPerujuk() {
        var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id') ?>").val();
        var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukan, 'rujukandari_id') ?>").find('option[value="' + rujukandari_id + '"]').text();
        $("#<?php echo CHtml::activeId($modRujukan, 'nama_perujuk') ?>").val(nama_perujuk);
        $("#<?php echo CHtml::activeId($modRujukan, 'namaperujuk2') ?>").val(nama_perujuk);
    }

    function clearRujukanBpjs() {
        $('#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        $('#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>').val('');
        $('#<?php echo CHtml::activeId($modRujukanBpjs, 'namaperujuk2') ?>').val('');
    }
    /**
     * set otomatis nama_perujuk dari dropdown rujukandari_id Untuk BPJS
     * @returns {Boolean}
     */
    function setNamaPerujukBpjs() {
        var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").val();
        var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").find('option[value="' + rujukandari_id + '"]').text();
        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(nama_perujuk);
        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'namaperujuk2') ?>").val(nama_perujuk);
    }

    function getPPK(obj) {
        var id = $(obj).val();
        $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val("");
        $.post('<?php echo $this->createUrl('getPPKRujukan'); ?>', {
            rujukan_id: id
        }, function(data) {
            $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val(data);
        });
    }

    /**
     * menambahkan asal rujukan
     * @returns {Boolean}
     */
    function addAsalRujukan() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/sistemAdministrator/AsalRujukanM/addAsalRujukan'); ?>',
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.status == 'create_form') {
                    $('#dialogAddAsalRujukan div.divForFormAsalRujukan').html(data.div);
                    $('#dialogAddAsalRujukan div.divForFormAsalRujukan form').submit(addAsalRujukan);
                } else {
                    $('#dialogAddAsalRujukan div.divForFormAsalRujukan').html(data.div);
                    $('#PPRujukanT_asalrujukan_id').html(data.asalrujukan);
                    setTimeout("$('#dialogAddAsalRujukan').dialog('close')", 1000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        return false;
    }
    /**
     * menambahkan rujukan dari
     * @returns {Boolean}
     */
    function addRujukanDari() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/sistemAdministrator/RujukandariM/addRujukanDari'); ?>',
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.status == 'create_form') {
                    $('#dialogAddRujukanDari div.divForFormRujukanDari').html(data.div);
                    $('#dialogAddRujukanDari div.divForFormRujukanDari form').submit(addRujukanDari);
                } else {
                    $('#dialogAddRujukanDari div.divForFormRujukanDari').html(data.div);
                    $('#PPRujukanT_nama_perujuk').html(data.namarujukan);
                    $('#PPRujukanT_rujukandari_id').html(data.namarujukan);
                    setTimeout("$('#dialogAddRujukanDari').dialog('close'); $('.rujukandari_id').change(); ", 1000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        return false;
    }
    /**
     * menambah data propinsi
     * @returns {Boolean} */
    function addPropinsi() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/sistemAdministrator/PropinsiM/addPropinsi'); ?>',
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.status == 'create_form') {
                    $('#dialog-addpropinsi div.dialog-content').html(data.div);
                    $('#dialog-addpropinsi div.dialog-content form').submit(addPropinsi);
                } else {
                    $('#dialog-addpropinsi div.dialog-content').html(data.div);
                    $('#PPPasienM_propinsi_id').html(data.propinsi).multiselect('rebuild');
                    setTimeout("$('#dialog-addpropinsi').dialog('close')", 1000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        return false;
    }

    function afterGetAjaxKabupaten(data) {
        $("<?php echo "#" . CHtml::activeId($modPasien, 'kabupaten_id'); ?>").html(data).multiselect('rebuild');
    }

    /**
     * menambah data Kabupaten
     * @returns {Boolean} */
    function addKabupaten() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/sistemAdministrator/KabupatenM/addKabupaten'); ?>',
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.status == 'create_form') {
                    $('#dialog-addkabupaten div.dialog-content').html(data.div);
                    $('#dialog-addkabupaten div.dialog-content form').submit(addKabupaten);
                } else {
                    $('#dialog-addkabupaten div.dialog-content').html(data.div);
                    $('#PPPasienM_kabupaten_id').html(data.kabupaten).multiselect('rebuild');
                    setTimeout("$('#dialog-addkabupaten').dialog('close')", 1000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

        return false;
    }
    /**
     * Menambah data Kecamatan
     * @returns {Boolean} */
    function addKecamatan() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/sistemAdministrator/KecamatanM/addKecamatan'); ?>',
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.status == 'create_form') {
                    $('#dialogAddKecamatan div.dialog-content').html(data.div);
                    $('#dialogAddKecamatan div.dialog-content form').submit(addKecamatan);
                } else {
                    $('#dialogAddKecamatan div.dialog-content').html(data.div);
                    $('#PPPasienM_kecamatan_id').html(data.kecamatan).multiselect('rebuild');
                    setTimeout("$('#dialogAddKecamatan').dialog('close')", 1000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

        return false;
    }

    function addKelurahan() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/sistemAdministrator/KelurahanM/addKelurahan'); ?>',
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.status == 'create_form') {
                    $('#dialog-addkelurahan div.dialog-content').html(data.div);
                    $('#dialog-addkelurahan div.dialog-content form').submit(addKelurahan);
                } else {
                    $('#dialog-addkelurahan div.dialog-content').html(data.div);
                    $('#PPPasienM_kelurahan_id').html(data.kelurahan).multiselect('rebuild');
                    setTimeout("$('#dialog-addkelurahan').dialog('close')", 1000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

        return false;
    }
    /**
     * set antrian ruangan
     * @param {type} obj
     * @returns {undefined} */
    function setAntrianRuangan() {
        var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetAntrianRuangan'); ?>',
            data: {
                ruangan_id: ruangan_id
            },
            dataType: "json",
            success: function(data) {
                $('#max-antrian-ruangan').val(null);
                // $('#jam_awal').val(null);
                // $('#jam_tutup').val(null);
                $('#jammulaipendaftaran').val(null);
                $('#jamakhirpendaftaran').val(null);
                $('#jam_awal_a').val(null);
                $('#jam_tutup_a').val(null);
                $('#nama_ruangan').val(null);
                $('#sisa-antrian-ruangan').val(null);
                if (data.maxantrianruangan != null) {
                    if (data.no_urutantri > data.maxantrianruangan) {
                        myAlert("Pasien Sudah Mencapai Maksimal Antrian Poliklinik " + data.maxantrianruangan + " Pasien");
                        $("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").val("").multiselect('rebuild');
                    }

                    $('#max-antrian-ruangan').val(data.maxantrianruangan);
                    $('#jam_awal').val(data.jammulaipendaftaran);
                    $('#jam_tutup').val(data.jamakhirpendaftaran);
                    $('#jam_awal_a').val(data.jammulai_a);
                    $('#jam_tutup_a').val(data.jamtutup_a);
                    $('#nama_ruangan').val(data.nama_ruangan);
                    $('#sisa-antrian-ruangan').val(data.maxantrianruangan - data.sisaantrian);

                    cur = new Date();
                    console.log(jam_awal)

                    jam_awal = new Date($("#jam_awal").val());
                    jam_tutup = new Date($("#jam_tutup").val());

                    if (cur.getTime() < jam_awal.getTime() || cur.getTime() > jam_tutup.getTime()) {
                        myAlert("Tidak bisa mendaftarkan pasien diluar jadwal.\n" +
                            $("#nama_ruangan").val() + " : " + $("#jam_awal_a").val() + " - " + $("#jam_tutup_a").val());

                        return false;
                    }


                } else {
                    $('#sisa-antrian-ruangan').val(0);
                    $('#max-antrian-ruangan').val(0);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set antrian ruangan
     * @param {type} obj
     * @returns {undefined} */
    function setAntrianDokter(ruangan_id) {
        var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();
        var pegawai_id = $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetAntrianDokter'); ?>',
            data: {
                ruangan_id: ruangan_id,
                pegawai_id: pegawai_id
            },
            dataType: "json",
            success: function(data) {
                $('#max-antrian-dokter').val(data.maxantriandokter);
                $('#sisa-antrian-dokter').val(data.maxantriandokter - data.sisaantriandokter);

                <?php if ($this->id == "pendaftaranRawatJalan") : ?>
                    listKuota();
                <?php endif; ?>
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    <?php if (Yii::app()->user->getState('isbridging') == TRUE) { ?>
        /**
         * set form asuransi
         * @returns {undefined} */
        function setFormAsuransi(carabayar_id) {
            var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>;
            var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS; ?>;
            var carabayar_id_badak = <?php echo Params::CARABAYAR_ID_BADAK; ?>;
            var carabayar_id_departemen = <?php echo Params::CARABAYAR_ID_DEP_BADAK; ?>;
            var carabayar_id_pekerja = <?php echo Params::CARABAYAR_ID_PEKERJA; ?>;
            var carabayar_id_jamkespa = <?php echo Params::CARABAYAR_ID_JAMKESPA; ?>;
            var carabayar_id_asuransi = <?php echo Params::CARABAYAR_ID_ASURANSI; ?>;
            var carabayar_id_perusahaan = <?php echo Params::CARABAYAR_ID_PERUSAHAAN; ?>

            /*Form inhealth harus selalu disabled/tutup saat ubah dropdown cara bayar*/
            sembunyiInhealth();
            $('#form-inhealth').hide();

            if (carabayar_id == carabayar_id_umum) {
                sembunyiFormAsuBadak();
                sembunyiFormAsuDepartemen();
                sembunyiFormAsuPekerja();

                sembunyiFormAsuransi();
                sembunyiFormBpjs();
                sembunyiFormAsuransi();

                $('#form-bpjs').hide();
                $('#form-asuransi').hide();
                $('#form-rujukan').show();
                $('#form-asubadak').hide();
                $('#form-asudepartemen').hide();
                $('#form-asupekerja').hide();
                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                    $('#form-asuransi-igd').hide();
                    sembunyiFormAsuransi_IGD();
                <?php endif; ?>

            } else if (carabayar_id == carabayar_id_bpjs) {
                sembunyiFormAsuBadak();
                sembunyiFormAsuDepartemen();
                sembunyiFormAsuPekerja();

                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                    tampilFormAsuransi_IGD();
                    sembunyiFormBpjs();
                    sembunyiFormAsuransi();
                    $('#form-bpjs').hide();
                    $('#form-asuransi-igd').show();
                    $('#form-asuransi').hide();
                    $('.cekBPJS').removeClass('hidden');
                <?php else : ?>
                    tampilFormBpjs();
                    $('.cekBPJSJalan').removeClass('hidden');
                    // $('.carabayar').find('.cekBPJS').removeClass('hidden');
                    // $("#PPPendaftaranT_is_bpjs_manual").attr('checked', true);
                    // $("#PPPendaftaranT_is_bpjs_manual").attr('disabled', true);
                    sembunyiFormAsuransi();
                    sembunyiFormAsuransi_IGD();
                    $('#form-bpjs').show();
                    $('#form-asuransi-igd').hide();
                    $('#form-asuransi').hide();
                <?php endif; ?>

                sembunyiFormRujukan();

                $('#form-rujukan').hide();
                $('#form-asubadak').hide();
                $('#form-asudepartemen').hide();

                validasiBpjs();
            } else if (carabayar_id == carabayar_id_badak) {
                tampilFormAsuBadak();
                sembunyiFormAsuDepartemen();
                sembunyiFormAsuPekerja();

                sembunyiFormBpjs();
                sembunyiFormAsuransi();
                sembunyiFormRujukan();

                $('#form-asubadak').show();
                $('#form-asuransi').hide();
                $('#form-bpjs').hide();
                $('#form-rujukan').hide();
                $('#form-asudepartemen').hide();
                $('#form-asupekerja').hide();
                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                    $('#form-asuransi-igd').hide();
                    sembunyiFormAsuransi_IGD();
                <?php endif; ?>
            } else if (carabayar_id == carabayar_id_departemen) {
                sembunyiFormAsuBadak();
                tampilFormAsuDepartemen();
                sembunyiFormAsuPekerja();

                sembunyiFormBpjs();
                sembunyiFormAsuransi();
                sembunyiFormRujukan();

                $('#form-asudepartemen').show();
                $('#form-asubadak').hide();
                $('#form-asuransi').hide();
                $('#form-bpjs').hide();
                $('#form-rujukan').hide();
                $('#form-asupekerja').hide();
                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                    $('#form-asuransi-igd').hide();
                    sembunyiFormAsuransi_IGD();
                <?php endif; ?>
            } else if (carabayar_id == carabayar_id_pekerja) {
                sembunyiFormAsuBadak();
                sembunyiFormAsuDepartemen();
                tampilFormAsuPekerja();

                sembunyiFormBpjs();
                sembunyiFormAsuransi();
                sembunyiFormRujukan();

                $('#form-asupekerja').show();
                $('#form-asudepartemen').hide();
                $('#form-asubadak').hide();
                $('#form-asuransi').hide();
                $('#form-bpjs').hide();
                $('#form-rujukan').hide();
                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                    $('#form-asuransi-igd').hide();
                    sembunyiFormAsuransi_IGD();
                <?php endif; ?>
            } else if (carabayar_id == carabayar_id_jamkespa) {
                sembunyiFormAsuBadak();
                sembunyiFormAsuDepartemen();
                sembunyiFormAsuPekerja();
                tampilFormAsuransi();
                sembunyiFormBpjs();
                $('#form-bpjs').hide();
                $('#form-asuransi').show();
                $('#form-rujukan').show();
                $('#form-asubadak').hide();
                $('#form-asudepartemen').hide();
                $('#form-asupekerja').hide();
                cekTanggalKonfirmasi();
                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                    $('#form-asuransi-igd').hide();
                    sembunyiFormAsuransi_IGD();
                <?php endif; ?>
            } else if ((carabayar_id == carabayar_id_asuransi) || (carabayar_id == carabayar_id_perusahaan)) {
                sembunyiFormAsuBadak();
                sembunyiFormAsuDepartemen();
                sembunyiFormAsuPekerja();
                tampilFormAsuransi();
                sembunyiFormBpjs();
                $('#form-bpjs').hide();
                $('#form-asuransi').show();
                $('#form-rujukan').show();
                $('#form-asubadak').hide();
                $('#form-asudepartemen').hide();
                $('#form-asupekerja').hide();
                cekTanggalKonfirmasi();
                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                    $('#form-asuransi-igd').hide();
                    sembunyiFormAsuransi_IGD();
                <?php endif; ?>
            } else if (carabayar_id == carabayar_id_perusahaan) {
                sembunyiFormAsuBadak();
                sembunyiFormAsuDepartemen();
                sembunyiFormAsuPekerja();
                tampilFormAsuransi();
                sembunyiFormBpjs();
                $('#form-bpjs').hide();
                $('#form-asuransi').show();
                $('#form-rujukan').show();
                $('#form-asubadak').hide();
                $('#form-asudepartemen').hide();
                $('#form-asupekerja').hide();
                cekTanggalKonfirmasi();
                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                    $('#form-asuransi-igd').hide();
                    sembunyiFormAsuransi_IGD();
                <?php endif; ?>
            } else {
                sembunyiFormAsuBadak();
                sembunyiFormAsuDepartemen();
                sembunyiFormAsuPekerja();
                sembunyiFormAsuransi();
                //tampilFormAsuransi();
                sembunyiFormBpjs();
                $('#form-bpjs').hide();
                $('#form-asuransi').show();
                $('#form-rujukan').show();
                $('#form-asubadak').hide();
                $('#form-asudepartemen').hide();
                $('#form-asupekerja').hide();
                cekTanggalKonfirmasi();
                <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
                    $('#form-asuransi-igd').hide();
                    sembunyiFormAsuransi_IGD();
                <?php endif; ?>

                //		$(".judulasuransi").html("Asuransi Baru");
                //
                //		$(".refreshasuransi").attr("style","display:none;");
            }
            cekJamkespa();
        }
    <?php } else { ?>
        /**
         * set form asuransi
         * @returns {undefined} */
        function setFormAsuransi(carabayar_id) {
            /*Form inhealth harus selalu disabled/tutup saat ubah dropdown cara bayar*/
            sembunyiInhealth();
            $('#form-inhealth').hide();

            var carabayar_id_umum = <?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>;
            var carabayar_id_bpjs = <?php echo Params::CARABAYAR_ID_BPJS; ?>;
            if (carabayar_id == carabayar_id_umum) {
                sembunyiFormAsuransi();
                cekJamkespa();
            } else if (carabayar_id == carabayar_id_bpjs) {
                sembunyiFormAsuransi();
                cekJamkespa();
                validasiBpjs();
            } else {
                tampilFormAsuransi();
                cekJamkespa();
            }
        }
    <?php } ?>

    function setFormAsuransiInhealth(penjamin_id) {
        var penjamin_id_umum = <?php echo Params::PENJAMIN_ID_UMUM; ?>;
        var penjamin_id_inhealth = <?php echo Params::PENJAMIN_ID_INHEALTH; ?>;
        var penjamin_id_bpjs1 = <?php echo Params::PENJAMIN_ID_BPJS_KESEHATAN; ?>;
        var penjamin_id_bpjs2 = <?php echo Params::PENJAMIN_ID_BPJS_KETENAGAKERJAAN; ?>;
        var pasien_id = $("#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>").val();
        var carabayar_id_asuransi = <?php echo Params::CARABAYAR_ID_ASURANSI; ?> //;
        //var carabayar_id_perusahaan = <?php //echo Params::CARABAYAR_ID_PERUSAHAAN; 
                                        ?>

        sembunyiInhealth();
        $('#form-inhealth').hide();


        if (penjamin_id == penjamin_id_inhealth) {
            <?php //if(Yii::app()->user->getState('bridging_inhealth')==TRUE){ 
            ?>
            sembunyiFormAsuransi();
            $('#form-asuransi').hide();

            if (pasien_id != '') { //briging berjalan jika no RM/pasien sudah ada ini untuk pasien lama
                tampilInhealth();
                $('#form-inhealth').show();
            }
            <?php //} 
            ?>
        } else {
            if ($("#<?php echo CHtml::activeId((!empty($modPasienAdmisi) ? $modPasienAdmisi : $model), "carabayar_id"); ?>").val() == carabayar_id_asuransi) { // || carabayar_id_perusahaan){
                tampilFormAsuransi();
                $('#form-asuransi').show();
            }
        }
    }

    function tampilFormPegawai() {
        $('#form-pegawai > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-pegawai > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-pegawai').removeClass().addClass("accordion-body in collapse");
        $('#content-pegawai').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-pegawai').removeAttr("style").attr("style", "height:auto");
        $('#content-pegawai').find("input,select,textarea").removeAttr("disabled");

    }

    function sembunyiFormPegawai() {
        $('#content-pegawai').find(".required").addClass("not-required").removeClass("required");
        $('#form-pegawai > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-pegawai > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-pegawai').removeClass().addClass("accordion-body collapse");
        $('#content-pegawai').removeAttr("style").attr("style", "height:0px");
        $('#content-pegawai').find("input,select,textarea").attr("disabled", true);
    }

    function sembunyiFormAsuransi() {
        $('#content-asuransi').find(".required").addClass("not-required").removeClass("required");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asuransi').removeClass().addClass("accordion-body collapse");
        $('#content-asuransi').removeAttr("style").attr("style", "height:0px");
        $('#content-asuransi').find("input,select,textarea").attr("disabled", true);
        if (typeof setAsuransiField == 'function') {
            setAsuransiField('sembunyi');
        }


    }

    function tampilFormAsuransi() {
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asuransi > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asuransi').removeClass().addClass("accordion-body in collapse");
        $('#content-asuransi').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asuransi').removeAttr("style").attr("style", "height:auto");
        $('#content-asuransi').find("input,select,textarea").removeAttr("disabled");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "status_konfirmasi"); ?>").prop("checked", true);
        if (typeof setAsuransiField == 'function') {
            setAsuransiField('tampil');
        }



    }

    function sembunyiFormAsuransi_IGD() {
        $('#content-asuransi-igd').find(".required").addClass("not-required").removeClass("required");
        $('#form-asuransi-igd > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asuransi-igd > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asuransi-igd').removeClass().addClass("accordion-body collapse");
        $('#content-asuransi-igd').removeAttr("style").attr("style", "height:0px");
        $('#content-asuransi-igd').find("input,select,textarea").attr("disabled", true);
        if (typeof setAsuransiField == 'function') {
            setAsuransiField('sembunyi');
        }
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
        is_bpjs.val(0);
        $('.cekBPJS').addClass('hidden');


    }

    function tampilFormAsuransi_IGD() {
        $('#form-asuransi-igd > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asuransi-igd > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asuransi-igd').removeClass().addClass("accordion-body in collapse");
        $('#content-asuransi-igd').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asuransi-igd').removeAttr("style").attr("style", "height:auto");
        $('#content-asuransi-igd').find("input,select,textarea").removeAttr("disabled");
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "status_konfirmasi"); ?>").prop("checked", true);
        // if (typeof setAsuransiField == 'function') {
        //     setAsuransiField('tampil');
        // }
        $('#skdp').hide();
        $('.rujukanTombol').show();
        $('.hideDpjpDialog').show();

        $('#rujukanBpjs').hide();
        $('.rujukanTombol').hide();
        $('.hideDpjpDialog').hide();

        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
        is_bpjs.val(1);

        $('.cekBPJS').removeClass('hidden');
        $('#content-asuransi-igd').find(".bpjs-manual").find("input,select,textarea,label").attr("disabled", true);
    }

    function sembunyiFormAsuBadak() {
        $('#content-asubadak').find(".required").addClass("not-required").removeClass("required");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asubadak').removeClass().addClass("accordion-body collapse");
        $('#content-asubadak').removeAttr("style").attr("style", "height:0px");
        $('#content-asubadak').find("input,select,textarea").attr("disabled", true);
    }

    function tampilFormAsuBadak() {
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asubadak > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asubadak').removeClass().addClass("accordion-body in collapse");
        $('#content-asubadak').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asubadak').removeAttr("style").attr("style", "height:auto");
        $('#content-asubadak').find("input,select,textarea").removeAttr("disabled");

    }

    function sembunyiFormAsuDepartemen() {
        $('#content-asudepartemen').find(".required").addClass("not-required").removeClass("required");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asudepartemen').removeClass().addClass("accordion-body collapse");
        $('#content-asudepartemen').removeAttr("style").attr("style", "height:0px");
        $('#content-asudepartemen').find("input,select,textarea").attr("disabled", true);
    }

    function tampilFormAsuDepartemen() {
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asudepartemen > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asudepartemen').removeClass().addClass("accordion-body in collapse");
        $('#content-asudepartemen').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asudepartemen').removeAttr("style").attr("style", "height:auto");
        $('#content-asudepartemen').find("input,select,textarea").removeAttr("disabled");

    }

    function sembunyiFormAsuPekerja() {
        $('#content-asupekerja').find(".required").addClass("not-required").removeClass("required");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-asupekerja').removeClass().addClass("accordion-body collapse");
        $('#content-asupekerja').removeAttr("style").attr("style", "height:0px");
        $('#content-asupekerja').find("input,select,textarea").attr("disabled", true);
    }

    function tampilFormAsuPekerja() {
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-asupekerja > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-asupekerja').removeClass().addClass("accordion-body in collapse");
        $('#content-asupekerja').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-asupekerja').removeAttr("style").attr("style", "height:auto");
        $('#content-asupekerja').find("input,select,textarea").removeAttr("disabled");

    }

    function sembunyiFormBpjs() {
        $('#content-bpjs').find(".required").addClass("not-required").removeClass("required");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-bpjs').removeClass().addClass("accordion-body collapse");
        $('#content-bpjs').removeAttr("style").attr("style", "height:0px");
        $('#content-bpjs').find("input,select,textarea").attr("disabled", true);
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs_rj"); ?>");
        is_bpjs.val(0);
        $('.cekBPJSJalan').addClass('hidden');


    }

    function tampilFormBpjs() {
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-bpjs > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-bpjs').removeClass().addClass("accordion-body in collapse");
        $('#content-bpjs').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-bpjs').removeAttr("style").attr("style", "height:auto");
        $('#content-bpjs').find("input,select,textarea").removeAttr("disabled");
        $('#content-bpjs').find(".nosep").attr("disabled", true);
        var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs_rj"); ?>");
        is_bpjs.val(1);

        $('.cekBPJSJalan').removeClass('hidden');
        $('#content-bpjs').find(".bpjs-manual").find("input,select,textarea,label").attr("disabled", true);
    }

    function bpjsManual() {
        // console.log(obj);
        //if ($(obj).is(':checked') ) {
        <?php if (strtolower($this->id) == 'pendaftaranrawatdarurat') : ?>
            if ($('.permanent').is(':checked')) {
                $('#content-asuransi-igd').find(".bpjs-igd").find("input,select,textarea,label").attr("disabled", true);
                $('#content-asuransi-igd').find(".bpjs-igd").addClass('hidden');

                $('#content-asuransi-igd').find(".bpjs-manual").find("input,select,textarea,label").attr("disabled", false);
                $('#content-asuransi-igd').find(".bpjs-manual").removeClass('hidden');

                var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
                is_bpjs.val(0);

            } else {
                $('#content-asuransi-igd').find(".bpjs-igd").find("input,select,textarea,label").attr("disabled", false);
                $('#content-asuransi-igd').find(".bpjs-igd").removeClass('hidden');

                $('#content-asuransi-igd').find(".bpjs-manual").find("input,select,textarea,label").attr("disabled", true);
                $('#content-asuransi-igd').find(".bpjs-manual").addClass('hidden');


                var carabayar_id = $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val();
                if (carabayar_id != <?php echo Params::CARABAYAR_ID_BPJS; ?>) {
                    var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
                    is_bpjs.val(0);
                } else {
                    var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
                    is_bpjs.val(1);
                }
            }
        <?php else : ?>
            if ($('.permanent').is(':checked')) {
                $('#content-bpjs').find(".bpjs").find("input,select,textarea,label").attr("disabled", true);
                $('#content-bpjs').find(".bpjs").addClass('hidden');

                $('#content-bpjs').find(".bpjs-manual").find("input,select,textarea,label").attr("disabled", false);
                $('#content-bpjs').find(".bpjs-manual").removeClass('hidden');
                var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
                is_bpjs.val(0);

                var is_bpjs_rj = $("#<?php echo CHtml::activeId($model, "is_bpjs_rj"); ?>");
                is_bpjs_rj.val(0);


                setKarcis(3);
            } else {
                $('#content-bpjs').find(".bpjs").find("input,select,textarea,label").attr("disabled", false);
                $('#content-bpjs').find(".bpjs").removeClass('hidden');

                $('#content-bpjs').find(".bpjs-manual").find("input,select,textarea,label").attr("disabled", true);
                $('#content-bpjs').find(".bpjs-manual").addClass('hidden');
                var carabayar_id = $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val();
                if (carabayar_id != <?php echo Params::CARABAYAR_ID_BPJS; ?>) {
                    var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
                    is_bpjs.val(0);

                    var is_bpjs_rj = $("#<?php echo CHtml::activeId($model, "is_bpjs_rj"); ?>");
                    is_bpjs_rj.val(0);
                } else {
                    var is_bpjs = $("#<?php echo CHtml::activeId($model, "is_bpjs"); ?>");
                    is_bpjs.val(1);

                    var is_bpjs_rj = $("#<?php echo CHtml::activeId($model, "is_bpjs_rj"); ?>");
                    is_bpjs_rj.val(1);
                }
                setKarcis(4)
            }
        <?php endif; ?>
    }


    function sembunyiFormRujukan() {
        $('#content-rujukan').find(".required").addClass("not-required").removeClass("required");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-rujukan').removeClass().addClass("accordion-body collapse");
        $('#content-rujukan').removeAttr("style").attr("style", "height:0px");
        $('#content-rujukan').find("input,select,textarea").attr("disabled", true);
        var is_pasienrujukan = $("#<?php echo CHtml::activeId($model, "is_pasienrujukan"); ?>");
        is_pasienrujukan.val(0);
    }

    function tampilFormRujukan() {
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-rujukan > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-rujukan').removeClass().addClass("accordion-body in collapse");
        $('#content-rujukan').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-rujukan').removeAttr("style").attr("style", "height:auto");
        $('#content-rujukan').find("input,select,textarea").removeAttr("disabled");
        var is_pasienrujukan = $("#<?php echo CHtml::activeId($model, "is_pasienrujukan"); ?>");
        is_pasienrujukan.val(0);
    }

    function tampilInhealth() {
        $('#form-inhealth > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-inhealth > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $('#content-inhealth').removeClass().addClass("accordion-body in collapse");
        $('#content-inhealth').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-inhealth').removeAttr("style").attr("style", "height:auto");
        $('#content-inhealth').find("input,select,textarea").removeAttr("disabled");
        $('#content-inhealth').find(".nosep").attr("readonly", true);
    }

    function sembunyiInhealth() {
        $('#content-inhealth').find(".required").addClass("not-required").removeClass("required");
        $('#form-inhealth > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-inhealth > .accordion-group > .accordion-heading').find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
        $('#content-inhealth').removeClass().addClass("accordion-body collapse");
        $('#content-inhealth').removeAttr("style").attr("style", "height:0px");
        $('#content-inhealth').find("input,select,textarea").attr("disabled", true);
    }

    function cekJamkespa() {
        if ($("#<?php echo CHtml::activeId((!empty($modPasienAdmisi) ? $modPasienAdmisi : $model), "carabayar_id"); ?>").val() == 18) {
            // $(".jks_spec").addClass("not-required").removeClass("required").parents(".control-group").hide();
            $("#<?php echo CHtml::activeId($modAsuransiPasien, "nopeserta"); ?>").val($("#<?php echo CHtml::activeId($modPasien, "no_rekam_medik"); ?>").val());
            $("#<?php echo CHtml::activeId($modAsuransiPasien, "nokartuasuransi"); ?>").val($("#<?php echo CHtml::activeId($modPasien, "no_rekam_medik"); ?>").val());
            $("#<?php echo CHtml::activeId($modAsuransiPasien, "namapemilikasuransi"); ?>").val($("#<?php echo CHtml::activeId($modPasien, "nama_pasien"); ?>").val());
            $("#<?php echo CHtml::activeId($modAsuransiPasien, "kelastanggunganasuransi_id"); ?>").val(<?php echo Params::KELASPELAYANAN_ID_KELAS_III; ?>);
            $(".rb_kon").eq(0).change();
        } else {
            //$(".jks_spec").parents(".control-group").show();
            //$(".jks_spec").removeClass("not-required").addClass("required").parents(".control-group").show();
            $("#<?php echo CHtml::activeId($modAsuransiPasien, "nopeserta"); ?>").val("");
            $("#<?php echo CHtml::activeId($modAsuransiPasien, "nokartuasuransi"); ?>").val("");
            $("#<?php echo CHtml::activeId($modAsuransiPasien, "namapemilikasuransi"); ?>").val("");
            $("#<?php echo CHtml::activeId($modAsuransiPasien, "kelastanggunganasuransi_id"); ?>").val("");
        }
    }

    // check jumlah saudara
    function cekJumlahSaudara(obj) {
        var anakke = $("#<?php echo CHtml::activeId($modPasien, 'anakke') ?>").val();
        var jumlahbersaudara = $("#<?php echo CHtml::activeId($modPasien, 'jumlah_bersaudara') ?>").val();

        if (anakke != '' && jumlahbersaudara != '') {
            if (anakke > jumlahbersaudara) {
                myAlert('Jumlah Anak ke, tidak boleh lebih besar dari jumlah bersaudara');
                // toastr.error("Jumlah Anak ke, tidak boleh lebih besar dari jumlah bersaudara","Perhatian");
                $("#<?php echo CHtml::activeId($modPasien, 'anakke') ?>").val('');
                $("#<?php echo CHtml::activeId($modPasien, 'jumlah_bersaudara') ?>").val('');
                return false;
            }
        }
    }

    /**
     * pilih karcis (check - uncheck)
     * harus pilih salah satu
     * @param {type} obj
     * @returns {undefined} */
    function pilihKarcis(obj) {
        var is_pilihtindakan = $(obj).parents('tr').find('input[name$="[is_pilihtindakan]"]');

        /*
    $(obj).parents('table').find('tr').each(function(){
        $(this).find('input[name$="[is_pilihtindakan]"]').val(0);
        $(this).removeClass('checked');
		$(this).find('i').removeClass('icon-form-silang');
		$(this).find('i').addClass('icon-form-check');
    });
    */

        if (is_pilihtindakan.val() > 0) {
            is_pilihtindakan.val(0);
            $(obj).parents('tr').removeClass('checked');
            $(obj).children('i').removeClass('icon-form-check');
            $(obj).children('i').addClass('icon-form-silang');
        } else {
            is_pilihtindakan.val(1);
            $(obj).parents('tr').addClass('checked');
            $(obj).children('i').removeClass('icon-form-silang');
            $(obj).children('i').addClass('icon-form-check');
        }
    }

    /**
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     *
     * Menampilkan form verifikasi
     * sebelum menampilkan verifikasi, terlebih dahulu dilakukan validasi Input Keseluruhan
     * terlebih dahulu. Kemudian, divalidasi lagi Nomor Identitas beserta Input Nama Ibu-nya.
     * Dan yang terahir, validasi apakah Nomot KTP atau Tgl. Lahir+Nama Ibu sudah dipakai oleh
     * Pasien lain.
     *
     * @returns {undefined}
     */
    function setVerifikasi() {

        var is_kunjungan = $("#<?php echo CHtml::activeId($model, "is_kunjungan"); ?>").val();
        var carabayar_id = $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val();

        $("#<?php echo CHtml::activeId($model, "is_kunjungan"); ?>").val(is_kunjungan);

        $(".nik").removeClass('error');
        $(".nik").parents(".control-group").removeClass('error');
        $(".nik_pj").removeClass('error');
        $(".nik_pj").parents(".control-group").removeClass('error');
        $(".nama_ibu").removeClass('error');
        $(".nama_ibu").parents(".control-group").removeClass('error');

        var email = $('#<?php echo CHtml::activeId($modPasien, 'alamatemail') ?>').val();
        // untuk mengecek email valid atau tidak RSSA-464
        if (email.length === 0) {
            console.log('email kosong');
        } else {
            if (!isEmail(email)) {
                $('#<?php echo CHtml::activeId($modPasien, 'alamatemail') ?>').focus();
                myAlert("Email yang dimasukan tidak valid.");
                return false;
            };
        }

        if (typeof cekValidasiRiwayatVaksinasi != "undefined" && cekValidasiRiwayatVaksinasi != null) {
            if (!cekValidasiRiwayatVaksinasi()) {
                return false;
            }
        }


        if (requiredCheck($(".form_pendaftaran"))) {
            if ($(".rb_rm").eq(1).is(":checked")) {
                /*if ($("#no_rekam_medik_baru").val().trim() == '') {
                    myAlert("No. Rekam Medik harus diisi");
                    return false;
                }else if($("#no_rekam_medik_baru").val().trim().length != 6 ){
                    myAlert("No. Rekam Medik harus berisi 6 digit angka");
                    return false;
                }*/
            }
            var cek_bpjs_bridging = $('#<?php echo CHtml::activeId($model, 'is_bpjs_rj') ?>').val();
            if (!cekNoIdentitas()) return false;
            if (!cekNoPonsel()) return false;
            if (carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?> && cek_bpjs_bridging == 1) {
                if (!cekNoPonselSEP()) return false;
            }

            if (!cekNoIdentitasPJ()) return false;
            if (!cekIbu()) return false;
            if (!cekNoAsuransiBpjs()) return false;

            $.post('<?php echo $this->createUrl('validasiPasien'); ?>', $("form").serialize(), function(data) {
                if (data.ok == 1) {
                    $(".form_pendaftaran").find('.integer-decimal, .float').each(function() {
                        $(this).val(unformatNumber($(this).val()));
                        console.log($(this).val())
                    });
                    $('#dialog-verifikasi').dialog("open");
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->createUrl('verifikasi'); ?>',
                        data: $("form").serialize(),
                        dataType: "json",
                        success: function(data) {
                            if (data.ok == 1) {
                                $('#dialog-verifikasi > .dialog-content').html(data.content);
                            } else {
                                $('#dialog-verifikasi > .dialog-content').html('');
                                $('#dialog-verifikasi').dialog("close");
                                alert(data.msg);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                    //untuk verifikasi hilangkan srbac loading
                    $(".animation-loading").removeClass("animation-loading");
                    $(".form_pendaftaran").find('.float').each(function() {
                        $(this).val(formatFloat($(this).val()));
                    });
                    // $("form").find('.integer').each(function(){
                    //     $(this).val(unformatNumber($(this).val()));
                    // });
                    $(".form_pendaftaran").find('.integer-decimal').each(function() {
                        $(this).val(formatThousandDecimal($(this).val()));
                    });
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }

        return false;
    }

    /**
     * Validasi input Nama Ibu nermama 'IBU'
     *
     * @returns {Boolean} true jika selain bernama 'IBU', false jika sebaliknya. */
    function cekIbu() {

        var nama_ibu = $(".nama_ibu").val().trim().toLowerCase();

        if (nama_ibu == 'ibu') {
            $(".nama_ibu").addClass('error');
            $(".nama_ibu").parents(".control-group").addClass('error');
            $(".nama_ibu")[0].focus();
            myAlert("Nama Ibu Tidak boleh diisi dengan nama 'IBU'");
            return false;
        }

        return true;
    }

    /** validasi untuk mengecek email yang valid */

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    /**
    * @author Deni Hamdani <denihamdani@piindonesia.co.id>
    *
    * Validasi nomor Identitas pada Panel Pasien.  Validasinya berupa Pengecekan Ada
    * tidaknya Jenis identitas, kemudian Jika pasien-nya 17 tahun keatas dan ber KTP
    * maka dilakukan validasi jumlah digit pada KTP, dan kemudian periksa pengulangan angka di awal.

     * @returns {Boolean} Data-nya sudah divalidasikan, false jika tidak */
    function cekNoIdentitas() {

        var jenis = null;
        var nomor = null;
        var umur = 1;

        $(".jenisidentitas").removeClass('error');
        $(".jenisidentitas").parents(".control-group").removeClass('error');

        if ($(".jenisidentitas").val() == "") {

            <?php
            // rawat darurat tidak mandatory
            if (strtolower($this->id) == 'pendaftaranrawatdarurat') : ?>

                console.log("RD");
                return true;

            <?php else : ?>

                console.log("RJ");

                $(".jenisidentitas").addClass('error');
                $(".jenisidentitas").parents(".control-group").addClass('error');
                $(".jenisidentitas")[0].focus();
                myAlert("Masukkan Jenis Identitas");
                return false;

            <?php endif; ?>
        }

        jenis = $(".jenisidentitas").val();
        nomor = $(".nik").val().trim();

        // set umut
        if ($(".umur").val().trim() != null) {
            umur = $(".umur").val();
            umur = umur.split(" ");
            umur = umur[0];
        }

        console.log("KTP", umur, nomor);

        if (jenis.trim() == "KTP" && umur > 16) {

            if (nomor == "") {
                $(".nik").addClass('error');
                $(".nik").parents(".control-group").addClass('error');
                $(".nik")[0].focus();
                myAlert("Nomor KTP Harus Diisi.");
                return false;

            }

            if (nomor.length != 16) {
                $(".nik").addClass('error');
                $(".nik").parents(".control-group").addClass('error');
                $(".nik")[0].focus();
                myAlert("Nomor KTP harus diinput 16 digit.");
                return false;
            }

            if (!cekRendundansiNomor(nomor)) {
                $(".nik").addClass('error');
                $(".nik").parents(".control-group").addClass('error');
                $(".nik")[0].focus();
                myAlert("No KTP yang anda masukan tidak sesuai. 4 digit diawal tidak boleh sama.");
                return false;
            }
        }

        return true;
    }





    function cekNoPonsel() {


        var nomor = $("#no_mobile_pasien").val();

        if (nomor.length < 10) {
            myAlert("No. Handphone yang diinputkan kurang dari 10 karakter");
            return false;

        } else if (nomor.length != 10 && nomor.length > 14) {
            $("#no_mobile_pasien").focus();
            myAlert("No. Handphone yang diinputkan lebih dari 14 karakter");
            return false;
        }

        return true;

    }


    /**
    * @author Deni Hamdani <denihamdani@piindonesia.co.id>
    *
    * Validasi nomor Identitas pada Panel Penanggunjawab Pasien (Jika aktif).
    * Validasinya berupa Pengecekan Ada tidaknya Jenis identitas, kemudian Jika
    * Pasien-nya 17 tahun keatas dan ber KTP maka dilakukan validasi jumlah digit
    * pada KTP, dan kemudian periksa pengulangan angka di awal.

     * @returns {Boolean} Data-nya sudah divalidasikan, false jika tidak */
    function cekNoIdentitasPJ() {

        if ($(".is_adapjpasien").val() != 1) {
            return true;
        }
        // if ($(".is_adapjpasien").val() != 1)
        //     return true;

        var jenis = null;
        var nomor = null;

        jenis = $(".jenisidentitas_pj").val();
        nomor = $(".nik_pj").val().trim();

        console.log("KTP", nomor);

        if (jenis.trim() == "KTP") {

            if (nomor == "") {
                $(".nik_pj").addClass('error');
                $(".nik_pj").parents(".control-group").addClass('error');
                $(".nik_pj")[0].focus();
                myAlert("Nomor KTP Penanggung Jawab Harus Diisi.");
                return false;

            }

            if (nomor.length != 16) {
                $(".nik_pj").addClass('error');
                $(".nik_pj").parents(".control-group").addClass('error');
                $(".nik_pj")[0].focus();
                myAlert("Nomor KTP Penanggung Jawab harus diinput 16 digit.");
                return false;
            }

            if (!cekRendundansiNomor(nomor)) {
                $(".nik_pj").addClass('error');
                $(".nik_pj").parents(".control-group").addClass('error');
                $(".nik_pj")[0].focus();
                myAlert("No KTP Penanggung Jawab yang anda masukan tidak sesuai. 4 digit diawal tidak boleh sama.");
                return false;
            }
        }

        return true;
    }

    function cekRendundansiNomor(nomor) {
        var redundant = 0;
        var arr_nomor = nomor.split("");
        var current_char = arr_nomor[0];

        for (var i = 0; i < arr_nomor.length; i++) {
            if (current_char != arr_nomor[i]) break;
            redundant++;
        }

        return (redundant < 4);
    }

    /**
     * tombol batal pada dialogbox
     * @param {type} dialog_id
     * @returns {undefined}
     */
    function batalDialog(dialog_id) {
        if (confirm("Apakah anda yakin akan membatalkan ini ?"))
            $('#' + dialog_id).dialog("close");
    }
    /**
     * refresh daftar pasien rj
     * @returns {Boolean} */
    function refreshDaftarPasien() {
        $.fn.yiiGridView.update('pendaftarterakhir-rj-grid', {
            data: $(this).serialize()
        });
        return false;
    }
    /**
     * set tabel riwayat kunjungan pasien
     * @param {type} pasien_id
     * @returns {undefined} */
    function setRiwayatKunjunganPasien(pasien_id) {
        $("#content-riwayatpasien > .accordion-inner").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetRiwayatKunjunganPasien'); ?>',
            data: {
                pasien_id: pasien_id
            },
            dataType: "json",
            success: function(data) {
                $("#content-riwayatpasien > .accordion-inner").html(data.table);
                $("#content-riwayatpasien > .accordion-inner").removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function simpanDataPendaftaran() {
        $(".integer2, .float2, .integer-decimal").each(function() {
            $(this).val(unformatNumber($(this).val()));
        });
        $("#pppendaftaran-t-form").submit();
    }

    /**
     * print kartu pasien
     */
    function printKartuPasien() {
        window.open('<?php echo $this->createUrl('PendaftaranRawatJalan/printKartuPasien', array('pasien_id' => $model->pasien_id)); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
    }
    /**
     * print status
     */
    function printStatus() {
        window.open('<?php echo $this->createUrl('printStatus', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }
    /**
     * print karcis
     */
    function printKarcis() {
        window.open('<?php echo $this->createUrl('printKarcis', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=0,width=480,height=640');
    }

    function autoPrint() {
        setTimeout(function() {
            window.scrollBy(0, 768);
        }, 1000);
        var carabayar_id = $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val();
        if (carabayar_id == <?php echo Params::CARABAYAR_ID_BPJS; ?>) {
            // printLabel();
            <?php if (Yii::app()->user->getState('isbridging') && isset($modSep->sep_id)) { ?>
                printSEP();
            <?php } ?>
            printKarcis();
            printCasemixIdentitas('<?php echo $model->pendaftaran_id ?>');
            // printStiker();
            // printKlaim();

        };
        if (carabayar_id == <?php echo Params::SYARAT_CARABAYAR_TUNAI ?> || carabayar_id == <?php echo Params::CARABAYAR_ID_ASURANSI ?>) {
            // printLabel()
            printKarcis()
            // printStiker()
            // printKlaim()
        }
        // <?php //if (Yii::app()->user->getState('printkartulsng') == TRUE) { 
            ?>
        // //printKartuPasien()
        // <?php  //} 
            ?>
        // <?php //if (Yii::app()->user->getState('printkunjunganlsng') == TRUE) { 
            ?>
        // //printStatus();
        // <?php  //} 
            ?>
        <?php //if (Yii::app()->user->getState('isbridging') && isset($modSep->sep_id)) { 
        ?>
        //printSEP();
        <?php //} 
        ?>

        <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
            socket.emit('send', {
                conversationID: 'infoAntrian',
                panggil: 3
            });
        <?php } ?>

        setTimeout(function() {
            window.location.href = '<?php echo $this->createUrl("index"); ?>';
        }, 3000);
    }

    function printSEP() {
        window.open('<?php echo $this->createUrl('printSep', array('sep_id' => $modSep->sep_id, 'pendaftaran_id' => $model->pendaftaran_id)); ?>', '_blank', 'printwin_sep', 'left=100,top=100,width=860,height=480');
    }

    function printSJP() {
        window.open('<?php echo $this->createUrl('printSjp', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function printLabel() {
        window.open('<?php echo $this->createUrl('printLabel', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', '_blank', 'printwin', 'left=100,top=100,width=860,height=480');
    }


    function printStiker() {
        window.open('<?php echo $this->createUrl('printStiker', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', '_blank', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function printKlaim() {
        window.open('<?php echo $this->createUrl('printKlaim', array('pendaftaran_id' => $model->pendaftaran_id, 'caraPrint' => 'Print')); ?>', '_blank', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function printLabelRD() {
        window.open('<?php echo $this->createUrl('printLabelRD', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function printLabelRM() {
        window.open('<?php echo $this->createUrl('printLabelRM', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function printSKP() {
        window.open('<?php echo $this->createUrl('printSkp', array('skp_id' => $model->skp_id, 'pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    function printLabelHD() {
        window.open('<?php echo $this->createUrl('printLabelHD', array('pendaftaran_id' => $model->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }

    /**
     * fungsi BPJS
     */

    function getAsuransiNoKartuIGD(isi) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        }

        var tglsep = $('.tglsep').val(); //$('#<?php //echo CHtml::activeId($model, 'tglsep') 
                                                ?>').val();

        var aksi = 1; // 4 untuk mencari data peserta berdasarkan Nomor Kartu
        console.log('testtttt12', isi);
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi + '&tgl=' + tglsep,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                sembunyiKecelakaan();
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);
                console.log(obj, 'data dah lah');
                if (obj.metaData.code != '200') {
                    if (typeof obj.metaData !== 'undefined') {
                        myAlert(obj.metaData.message);
                    }
                    return false;
                }
                console.log('testtttt');
                if (obj.response != null) {

                    var peserta = obj.response.peserta;



                    // if (obj.response.asalFaskes != '' && obj.response.asalFaskes != undefined) {
                    //     setRadioButton($(".jenisfaskes_bpjs"), obj.response.asalFaskes);
                    // }


                    if (peserta.statusPeserta.keterangan == 'AKTIF') {
                        var prolanis = peserta.informasi.prolanisPRB;
                        var dinsos = peserta.informasi.noSKTM;

                        if (prolanis == null) {
                            prolanis = "-";
                        }

                        if (dinsos == null) {
                            dinsos = "-";
                        }

                        $("#bpjs_prolanis").val(prolanis);
                        $("#bpjs_dinsos").val(dinsos);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
                        $("#PPAsuransipasienbpjsM_jenispeserta_bpjs").val(peserta.jenisPeserta.keterangan);
                        $("#<?php echo CHtml::activeId($modSep, 'nopeserta') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modSep, 'nokartuasuransi') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nopeserta') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'nokartuasuransi') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'namapemilikasuransi') ?>").val(peserta.nama);
                        $('.namapemilikasuransiIGD').val(peserta.nama);
                        $('.kelastanggunganasuransi_idIGD').val(peserta.hakKelas.kode);
                        $('#PPSepT_klsrawat').val(peserta.hakKelas.kode);

                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'tglcetakkartuasuransi') ?>").val(peserta.tglCetakKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?>").val(peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($modSep, 'hakkelas_kode') ?>").val(peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($modSep, 'kelastanggungan_id') ?>").val(peserta.hakKelas.kode); // <<tidak sama dengan kelaspelayanan_id
                        $("#<?php echo CHtml::activeId($modSep, 'kelastanggungan') ?>").val(peserta.hakKelas.kode); // <<tidak sama dengan kelaspelayanan_id
                        $("#<?php echo CHtml::activeId($modSep, 'kelastanggunganasuransi_nama') ?>").val(peserta.hakKelas.keterangan);
                        // $("#<?php //echo CHtml::activeId($modSep, 'ppkrujukan') 
                                ?>").val(rujukan.provPerujuk.kode);
                        // $("#<?php //echo CHtml::activeId($modSep, 'ppkrujukan_nama') 
                                ?>").val(rujukan.provPerujuk.nama);
                        $("#<?php echo CHtml::activeId($modSep, 'no_telpon_peserta') ?>").val(peserta.mr.noTelepon);


                        if (peserta.cob.nmAsuransi == null && peserta.cob.noAsuransi == null) {
                            $("#<?php echo CHtml::activeId($modSep, 'is_cob') ?>").val(0);
                            $("#<?php echo CHtml::activeId($modSep, 'status_nosep') ?>").val("TIDAK");
                        } else {
                            $("#<?php echo CHtml::activeId($modSep, 'is_cob') ?>").val(1);
                            $("#<?php echo CHtml::activeId($modSep, 'no_asuransi_cob') ?>").val(peserta.cob.noAsuransi);
                            $("#<?php echo CHtml::activeId($modSep, 'namaasuransi_cob') ?>").val(peserta.cob.nmAsuransi);
                            $("#<?php echo CHtml::activeId($modSep, 'status_nosep') ?>").val("YA");
                        }
                        $('#PPSepT_jnspelayanan').val(2);

                        // if (rujukan != null && rujukan != undefined) {
                        //     $("#<?php //echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') 
                                    ?>").val(rujukan.noKunjungan);
                        //     $("#<?php //echo CHtml::activeId($modSep, 'jnspelayanan') 
                                    ?>").val(rujukan.pelayanan.kode);
                        //     $("#<?php //echo CHtml::activeId($modSep, 'politujuan') 
                                    ?>").val(rujukan.poliRujukan.kode);
                        //     $("#<?php //echo CHtml::activeId($modSep, 'diagnosaawal') 
                                    ?>").val(rujukan.diagnosa.kode);
                        //     $("#<?php //echo CHtml::activeId($modSep, 'nama_diagnosaawal') 
                                    ?>").val(rujukan.diagnosa.nama);
                        //     setDiagnosaBpjs(rujukan.diagnosa.kode, rujukan.diagnosa.nama);
                        // }

                        // setTimeout(function() {
                        //     if (isadarujukan == 1) {
                        //         getRujukanNoRujukan(rujukan.noKunjungan);
                        //     }
                        //     getPPKPelayanan();
                        //     cekPerbedaanKelas();

                        // }, 1000);
                        cekPerbedaanKelas();
                        getPPKPelayanan();

                        <?php if (isset($_GET['pengajuanapprovalsep_id']) && !empty($_GET['pengajuanapprovalsep_id'])) { ?> setInfoPasien('<?php echo $modPendaftaran->pendaftaran_id; ?>', '<?php echo $modPendaftaran->no_pendaftaran; ?>', '<?php echo $modPasien->no_rekam_medik; ?>', '<?php echo (!empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pasienadmisi_id : ""); ?>') <?php } ?>
                            cekPilihSatu($("#PPPendaftaranT_ruangan_id"));


                    } else {

                        // OVERWRITES old selecor
                        jQuery.expr[':'].contains = function(a, i, m) {
                            return jQuery(a).text().toUpperCase()
                                .indexOf(m[3].toUpperCase()) >= 0;
                        };
                        //					$("#<?php // echo CHtml::activeId($model, 'kelastanggungan_id') 
                                                    ?>").find("option:contains('" + peserta.kelasTanggungan.nmKelas + "')").attr("selected", true);
                        $("#<?php echo CHtml::activeId($modSep, 'klsrawat') ?>").val(peserta.hakKelas.kode);

                        myAlert('Peserta Tidak Aktif');
                    }
                    $("#<?php echo CHtml::activeId($modSep, 'politujuan') ?>").val("IGD");
                    cekDisabled('form');
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }


    function getAsuransiNoKartu(isi, databpjs) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        };
        var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu
        var tgl = $("#PPSepT_tglsep").val();

        resetFormBpjs();

        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi + '&tgl=' + tgl,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);

                var rujukan = null;

                if (obj != null && obj.response != null) {
                    if (obj.response.rujukan != null && obj.response.rujukan != undefined) {
                        rujukan = obj.response.rujukan;
                        var peserta = rujukan.peserta;
                    } else {
                        var peserta = obj.response.peserta;
                    }

                    // rujukan = null;

                    if (peserta.statusPeserta.keterangan == 'AKTIF') {

                        var provRujukan = (rujukan != null) ? rujukan.provPerujuk : null;

                        setKelasTanggunganDrop();

                        if (provRujukan != null) {
                            getRujukanDari(provRujukan.kode, provRujukan.nama);
                        }

                        var prolanis = peserta.informasi.prolanisPRB;
                        var dinsos = peserta.informasi.noSKTM;

                        if (prolanis == null) {
                            prolanis = "-";
                        }

                        if (dinsos == null) {
                            dinsos = "-";
                        }

                        $("#bpjs_prolanis").val(prolanis);
                        $("#bpjs_dinsos").val(dinsos);

                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);

                        if (provRujukan != null) {
                            $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val(provRujukan.kode);
                            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(provRujukan.nama);
                            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'namaperujuk2') ?>").val(provRujukan.nama);
                        }

                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val(peserta.noKartu);
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') ?>").val(peserta.nama);
                        $("#PPSepT_no_telpon_peserta").val(peserta.mr.noTelepon);
                        $("#PPAsuransipasienbpjsM_kelastanggunganasuransi_id").val(peserta.hakKelas.kode);
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);

                        if (peserta.cob.nmAsuransi != null) {
                            $("#<?php echo CHtml::activeId($modSep, 'cob') ?>").prop("disabled", false).prop("checked", true);
                        } else {
                            $("#<?php echo CHtml::activeId($modSep, 'cob') ?>").prop("disabled", true).prop("checked", false);
                        }

                        <?php if ($this->id == "pendaftaranRawatDarurat") { ?>
                            getPPKPelayanan();
                        <?php } else if ($this->id == "pendaftaranRawatInapDariRJRD") { ?>
                            if ($('#instalasiasalRI_id').val() != undefined && $('#instalasiasalRI_id').val() == '<?php echo Params::INSTALASI_ID_RD; ?>') {
                                getPPKPelayanan();
                            }
                        <?php } ?>

                        if (rujukan != null && rujukan != undefined) {
                            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val(rujukan.noKunjungan);
                            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(rujukan.provPerujuk.nama);
                            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'namaperujuk2') ?>").val(rujukan.provPerujuk.nama);
                            $("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan') ?>").val(rujukan.tglKunjungan);
                            setDiagnosaBpjs(rujukan.diagnosa.kode, rujukan.diagnosa.nama);
                        }
                        // $("#<?php //echo CHtml::activeId($modSep, 'no_telpon_peserta') 
                                ?>").val($("#<?php //echo CHtml::activeId($modPasien, 'no_mobile_pasien') 
                                                ?>").val());
                        cekPerbedaanKelas();

                        setPenjaminJenisBPJS();
                        $('#dialogNoRujukan #norujukan').val($('#PPAsuransipasienbpjsM_nopeserta').val());
                        $('#dialogNoRujukan').dialog('open');
                        cariDataNoRujukan();
                    } else {
                        myAlert("Nomor Kartu Peserta NON AKTIF");
                        resetFormBpjs();
                    }

                } else {
                    if (obj != null) {
                        if (typeof obj.metaData !== 'undefined') {
                            if (obj.metaData.message != 'Rujukan Tidak Ada') {
                                myAlert(obj.metaData.message);
                            } else {
                                $('#dialogNoRujukan #norujukan').val($('#cari_nomor_pasien').val());
                                $('#dialogNoRujukan').dialog('open');
                                myAlert(obj.metaData.message);
                            }
                        } else {
                            if (typeof databpjs !== 'undefined') {
                                $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') ?>").val(databpjs.nopeserta);
                                $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'asuransipasien_id') ?>").val(databpjs.asuransipasien_id);
                                $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val(databpjs.nokartuasuransi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') ?>").val(databpjs.namapemilikasuransi);
                                $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') ?>").val(databpjs.jenispeserta_id);
                                $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') ?>").val(databpjs.kelastanggunganasuransi_id); // <<tidak sama dengan kelaspelayanan_id
                            }
                        }
                    } else {

                        if (typeof databpjs !== 'undefined') {
                            $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') ?>").val(databpjs.nopeserta);
                            $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'asuransipasien_id') ?>").val(databpjs.asuransipasien_id);
                            $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val(databpjs.nokartuasuransi);
                            $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') ?>").val(databpjs.namapemilikasuransi);
                            $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') ?>").val(databpjs.jenispeserta_id);
                            $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') ?>").val(databpjs.kelastanggunganasuransi_id); // <<tidak sama dengan kelaspelayanan_id
                        }
                    }
                    //alert(3);
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function getAsuransiNoPeserta(isi) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        };
        var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu

        resetFormBpjs();

        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);

                if (obj != null && obj.response != null) {
                    var peserta = obj.response.peserta;

                    getAsuransiNoKartu(peserta.noKartu);
                    setKelasTanggunganDrop();
                    getRujukanDari(peserta.provUmum.kdProvider, '');
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
                    $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') ?>").val(peserta.noKartu);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val(peserta.noKartu);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') ?>").val(peserta.nama);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);

                    // $("#<?php //echo CHtml::activeId($modSep, 'no_telpon_peserta') 
                            ?>").val($("#<?php //echo CHtml::activeId($modPasien, 'no_mobile_pasien') 
                                            ?>").val());



                    //              $("#<?php // echo CHtml::activeId($modRujukanBpjs,'no_rujukan') 
                                        ?>").val(noKunjungan);
                    //              $("#<?php // echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') 
                                        ?>").val(provRujukan.nama);
                    //              $("#<?php // echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') 
                                        ?>").val(tglKunjungan);

                    //              setDiagnosaBpjs(diagnosa.kode,diagnosa.nama);
                    //              $("#PPSepT_ppkrujukan").val(provRujukan.kode);
                    $("#PPAsuransipasienbpjsM_nopeserta").val(peserta.noKartu);
                    $("#PPAsuransipasienbpjsM_nokartuasuransi").val(peserta.noKartu);
                    $("#PPAsuransipasienbpjsM_namapemilikasuransi").val(peserta.nama);
                    //              $("#PPAsuransipasienbpjsM_jenispeserta_id").val(peserta.jenisPeserta.kode);
                    $("#PPAsuransipasienbpjsM_kelastanggunganasuransi_id").val(peserta.hakKelas.kode);
                    <?php if ($this->id == "pendaftaranRawatDarurat") { ?>
                        getPPKPelayanan();
                    <?php } else if ($this->id == "pendaftaranRawatInapDariRJRD") { ?>
                        if ($('#instalasiasalRI_id').val() != undefined && $('#instalasiasalRI_id').val() == '<?php echo Params::INSTALASI_ID_RD; ?>') {
                            getPPKPelayanan();
                        }
                    <?php } ?>
                    //              pemilik_bpjs = peserta.nama;
                    //            jQuery.expr[':'].contains = function(a, i, m) {
                    //              return jQuery(a).text().toUpperCase()
                    //                      .indexOf(m[3].toUpperCase()) >= 0;
                    //            };
                    //				if (peserta != null){
                    //
                    ////                                        getJenisPesertaBpjs(peserta.jenisPeserta.kode);
                    //
                    //
                    ////					$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') 
                                                ?>").val(peserta.hakKelas.kode); // <<tidak sama dengan kelaspelayanan_id
                    //					// OVERWRITES old selecor
                    //
                    //					// $("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') 
                                                    ?>").find(peserta.kelasTanggungan.nmKelas).attr("selected",true);
                    //				}else{
                    //
                    //					if (typeof databpjs !== 'undefined'){
                    //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta') 
                                                    ?>").val(databpjs.nopeserta);
                    //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'asuransipasien_id') 
                                                    ?>").val(databpjs.asuransipasien_id);
                    //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') 
                                                    ?>").val(databpjs.nokartuasuransi);
                    //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi') 
                                                    ?>").val(databpjs.namapemilikasuransi);
                    //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_id') 
                                                    ?>").val(databpjs.jenispeserta_id);
                    //						$("#<?php // echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') 
                                                    ?>").val(databpjs.kelastanggunganasuransi_id); // <<tidak sama dengan kelaspelayanan_id
                    //					}
                    //				}
                } else {
                    if (obj != null) {
                        if (typeof obj.metaData !== 'undefined') {
                            myAlert(obj.metaData.message);
                        }
                    }
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function getRujukanDari(kodeppk, nama) {
        var asarujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id') ?>").val();
        var jenisfaskes = $('#ytPPSepT_jenisfaskes').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetRujukanDariBpjs'); ?>',
            data: {
                kodeppk: kodeppk,
                asarujukan: asarujukan,
                jenisfaskes: jenisfaskes,
                nama: nama
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id') ?>").val(data.asalrujukan);
                $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").html(data.datarujukandari);
                $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").val(data.rujukandari);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function getRujukanDariIGD(kodeppk) {
        var asarujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id') ?>").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetRujukanDariBpjs'); ?>',
            data: {
                kodeppk: kodeppk,
                asarujukan: asarujukan
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id') ?>").val(data.asalrujukan);
                $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").html(data.datarujukandari);
                $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").val(data.rujukandari);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function getRujukanNoRujukan(isi) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (isi == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        };
        var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Nomor rujukan
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);

                if (obj.response.rujukan != null) {
                    var rujukan = obj.response.rujukan;
                    var noKunjungan = rujukan.noKunjungan;
                    var tglKunjungan = rujukan.tglKunjungan;
                    var peserta = rujukan.peserta; //array
                    var provKunjungan = rujukan.provKunjungan; //array
                    var keluhan = rujukan.keluhan;
                    var diagnosa = rujukan.diagnosa; //array
                    var catatan = rujukan.catatan;
                    var pemFisikLain = rujukan.pemFisikLain;
                    var provRujukan = rujukan.provPerujuk; //array
                    var poliRujukan = rujukan.poliRujukan; //array
                    getRujukanDari(provRujukan.kode, provRujukan.nama);
                    cekSepRujukan(noKunjungan, peserta.noKartu);
                    //              getJenisPesertaBpjs(peserta.jenisPeserta.kode);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispersertakode_bpjs') ?>").val(peserta.jenisPeserta.kode);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_bpjs') ?>").val(peserta.jenisPeserta.keterangan);
                    $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val(peserta.provUmum.kdProvider);

                    $("#<?php echo CHtml::activeId($modSep, 'politujuan') ?>").val(poliRujukan.kode);
                    $("#<?php echo CHtml::activeId($modSep, 'politujuan_id') ?>").val(poliRujukan.kode);

                    setSMF(poliRujukan.kode);

                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val(noKunjungan);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val(provRujukan.nama);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'namaperujuk2') ?>").val(provRujukan.nama);
                    $("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan') ?>").val(tglKunjungan);

                    setRuanganDariKodeBPJS();
                    resetDiagnosaBpjs();
                    setDiagnosaBpjs(diagnosa.kode, diagnosa.nama);

                    $('#PPPendaftaranT_diagnosamasuk_id').val(diagnosa.id);
                    $('#PPPendaftaranT_diagnosamasuk').val(diagnosa.kode + "-" + diagnosa.nama);

                    console.log('diagnosa id set bpjs: ' + diagnosa);

                    $("#PPSepT_ppkrujukan").val(provRujukan.kode);
                    $("#PPAsuransipasienbpjsM_nopeserta").val(peserta.noKartu);
                    $("#PPAsuransipasienbpjsM_nokartuasuransi").val(peserta.noKartu);
                    $("#PPAsuransipasienbpjsM_namapemilikasuransi").val(peserta.nama);
                    //              $("#PPAsuransipasienbpjsM_jenispeserta_id").val(peserta.jenisPeserta.kode);
                    $("#PPAsuransipasienbpjsM_kelastanggunganasuransi_id").val(peserta.hakKelas.kode);
                    setSuratKontrolDariRujukanRuangan();
                } else {
                    myAlert(obj.metadata.message);
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }


    function verifikasiBpjs(btn) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        var nokartu = $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nosep'); ?>").val();

        // var tglsep = ubahFormatTanggalBpjs($("#<?php echo CHtml::activeId($modSep, 'tglsep'); ?>").val());
        // var tglrujukan = ubahFormatTanggalBpjs($("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan'); ?>").val());
        var tglsep = $("#<?php echo CHtml::activeId($modSep, 'tglsep'); ?>").val();
        var tglrujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan'); ?>").val();
        var norujukan = $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan'); ?>").val();
        var ppkrujukan = $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan'); ?>").val();
        var ppkpelayanan = $("#<?php echo CHtml::activeId($modSep, 'ppkpelayanan'); ?>").val(); // "1001R012"
        var jnspelayanan = $("#<?php echo CHtml::activeId($modSep, 'jnspelayanan'); ?>").val();
        var catatan = $("#<?php echo CHtml::activeId($modSep, 'catatan'); ?>").val();
        var diagawal = $("#diagnosaRujukanKodeBpjs option:first-child").val();
        var politujuan = $("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").val();
        var klsrawat = $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id'); ?>").val();
        <?php
        $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);
        ?>
        var user = "<?php echo isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : '-'; ?>";
        var nomr = $("#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik'); ?>").val();
        var notrans = '<?php echo $model->no_pendaftaran; ?>';

        var aksi = 6; // 6 untuk menCreate SEP
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&no_kartu=' + nokartu + '&tgl_sep=' + tglsep + '&tgl_rujukan=' + tglrujukan + '&no_rujukan=' + norujukan + '&ppk_rujukan=' + ppkrujukan + '&ppk_pelayanan=' + ppkpelayanan + '&jns_pelayanan=' + jnspelayanan + '&catatan=' + catatan + '&diag_awal=' + diagawal + '&poli_tujuan=' + politujuan + '&kls_rawat=' + klsrawat + '&user=' + user + '&no_mr=' + nomr + '&no_trans=' + notrans,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var res = JSON.parse(data);
                if (res.response != null) {
                    var noSep = res.response;
                    $("#<?php echo CHtml::activeId($modSep, 'nosep') ?>").val(noSep);
                } else {
                    myAlert(res.metadata.message);
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);


        $(btn).hide();
        $('.verified').show();
    }

    function ubahFormatTanggalBpjs(str) {
        tgl = str.substr(0, 10).split("/");
        tanggal = tgl[2] + '-' + tgl[1] + '-' + tgl[0]
        jam = str.substr(11, 8);
        return tanggal + ' ' + jam;
    }


    function setDiagnosa(kode_diagnosa, nama_diagnosa) {

        var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var randomId = '';
        for (var i = 0; i < 32; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomId += chars.substring(rnum, rnum + 1);
        }

        var op = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + nama_diagnosa + '">' + nama_diagnosa + '</option>';
        var list = '<li id="pt_' + randomId + '" class="bit-box" rel="' + nama_diagnosa + '">' + nama_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
        var opKode = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + kode_diagnosa + '">' + kode_diagnosa + '</option>';
        var listKode = '<li id="pt_' + randomId + '" class="bit-box" rel="' + kode_diagnosa + '">' + kode_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
        var objSelect = $('select#diagnosaRujukan').parent().find('select');
        var objList = $('select#diagnosaRujukan').parent().find('ul li.bit-input');
        var objSelectKode = $('select#diagnosaRujukanKode').parent().find('select');
        var objListKode = $('select#diagnosaRujukanKode').parent().find('ul li.bit-input');

        objSelect.append(op);
        objList.before(list);
        objSelectKode.append(opKode);
        objListKode.before(listKode);

    }

    function setDiagnosaBpjs(kode_diagnosa, nama_diagnosa) {

        var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
        var randomId = '';
        for (var i = 0; i < 32; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomId += chars.substring(rnum, rnum + 1);
        }

        var op = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + nama_diagnosa + '">' + nama_diagnosa + '</option>';
        var list = '<li id="pt_' + randomId + '" class="bit-box" rel="' + nama_diagnosa + '">' + nama_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
        var opKode = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + kode_diagnosa + '">' + kode_diagnosa + '</option>';
        var listKode = '<li id="pt_' + randomId + '" class="bit-box" rel="' + kode_diagnosa + '">' + kode_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
        var objSelect = $('select#diagnosaRujukanBpjs').parent().find('select');
        var objList = $('select#diagnosaRujukanBpjs').parent().find('ul li.bit-input');
        var objSelectKode = $('select#diagnosaRujukanKodeBpjs').parent().find('select');
        var objListKode = $('select#diagnosaRujukanKodeBpjs').parent().find('ul li.bit-input');

        objSelect.append(op);
        objList.before(list);
        objSelectKode.append(opKode);
        objListKode.before(listKode);

    }

    function removeItemDiagnosa(id) {
        $('li#' + id).remove();
        var id_opt = id.replace('pt_', 'opt_');
        $('option#' + id_opt).remove();
    }

    function setNoKartuAsuransi() {
        var nopeserta = $("input[name$='[nopeserta]']").val();
        $("input[name$='[nokartuasuransi]']").val(nopeserta);
    }

    function setNoBpjs() {
        var nopeserta = $("#PPAsuransipasienbpjsM_nopeserta").val();
        $("#PPAsuransipasienbpjsM_nokartuasuransi").val(nopeserta);
    }

    function setNoBpjsReverse() {
        var nokartuasuransi = $("#PPAsuransipasienbpjsM_nokartuasuransi").val();
        //alert(nokartuasuransi);
        $("#PPAsuransipasienbpjsM_nopeserta").val(nokartuasuransi);
    }

    var data_kontrol = null;

    function cariSuratKontrol() {
        var isi = $("#PPSepT_no_surat").val();
        var aksi = 18;


        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                // console.log(data);
                $("#content-bpjs").removeClass("animation-loading");
                var res = JSON.parse(data);
                if (res.response != null) {
                    data_kontrol = res.response;
                    showDialogSuratKontrol();
                } else {
                    myAlert(res.metaData.message);
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);



    }

    function cariSuratKontrolTombol() {
        if (event.key === "Enter") {
            var isi = $("#PPSepT_no_surat").val();
            var aksi = 18;


            var setting = {
                url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
                type: 'GET',
                dataType: 'html',
                data: 'param=' + aksi + '&query=' + isi,
                beforeSend: function() {
                    $("#content-bpjs").addClass("animation-loading");
                },
                success: function(data) {
                    // console.log(data);
                    $("#content-bpjs").removeClass("animation-loading");
                    var res = JSON.parse(data);
                    if (res.response != null) {
                        data_kontrol = res.response;
                        showDialogSuratKontrol();
                    } else {
                        myAlert(res.metaData.message);
                    }
                },
                error: function(data) {
                    $("#content-bpjs").removeClass("animation-loading");
                }
            }

            if (typeof ajax_request !== 'undefined')
                ajax_request.abort();
            ajax_request = $.ajax(setting);
        }


    }

    function showDialogSuratKontrol() {
        $("#tab_sc #sc_nama_pasien").html(data_kontrol.sep.peserta.nama);
        $("#tab_sc #sc_jeniskelamin").html((data_kontrol.sep.peserta.kelamin == null || data_kontrol.sep.peserta.kelamin == "") ? "-" : (data_kontrol.sep.peserta.kelamin == "L" ? "LAKI-LAKI" : "PEREMPUAN"));
        $("#tab_sc #sc_tanggal_lahir").html(data_kontrol.sep.peserta.tglLahir);
        $("#tab_sc #sc_nosurat").html(data_kontrol.noSuratKontrol);
        $("#tab_sc #sc_tanggal_entri").html(data_kontrol.tglTerbit);
        $("#tab_sc #sc_tanggal_rencana").html(data_kontrol.tglRencanaKontrol);
        $("#tab_sc #sc_poli_tujuan").html(data_kontrol.namaPoliTujuan); // mengambil data nama politujuan dari response bpjs
        $("#tab_sc #sc_dokter_kontrol").html(data_kontrol.namaDokter);
        $("#tab_sc #sc_no_sep").html(data_kontrol.sep.noSep);
        $("#tab_sc #sc_tgl_sep").html(data_kontrol.sep.tglSep);

        if (data_kontrol.status_kontrol == 1) {
            $("#tab_sc #sc_status").html("Sudah melewati jadwal kontrol yang Direncanakan!");
        } else if (data_kontrol.status_kontrol == -1) {
            $("#tab_sc #sc_status").html("Belum Masuk jadwal kontrol yang Direncanakan!");
        } else {
            $("#tab_sc #sc_status").html("")
        }

        $("#dialogSuratKontrol").dialog("open");
    }



    function setSuratKontrol() {
        $("#dialogSuratKontrol").dialog("close");
        if (data_kontrol.status_kontrol != 0) {
            $("#PPSepT_no_surat").val("");
        } else {
            $("#PPSepT_nama_dpjp").val(data_kontrol.namaDokter);
            $("#PPSepT_kode_dpjp").val(data_kontrol.kodeDokter);
            $("#PPSepT_no_surat").val(data_kontrol.noSuratKontrol);
            $("#isSepManual").prop("checked", false).change();
            $("#PPSepT_nosep").val("");
            var kodeperujuk = $('#<?php echo CHtml::activeId($modSep, 'ppkrujukan'); ?>').val();
            if (kodeperujuk == '<?php echo Yii::app()->user->getState('ppkpelayanan'); ?>') {
                $('#PPSepT_jenis_kunjungan').val(0);
                $('#PPSepT_asesmen_pelayanan').val("");
            } else {
                $('#PPSepT_jenis_kunjungan').val(2);
                $('#PPSepT_asesmen_pelayanan').val(5);
            }

            /*
            if (data_kontrol.sep.noSep) {
                $("#isSepManual").prop("checked", true).change();
                $("#PPSepT_nosep").val(data_kontrol.sep.noSep);
            }
            */
            $("#PPSepT_politujuan").val(data_kontrol.poliTujuan);
        }
    }

    <?php
    if (empty($modPasienAdmisi)) {
    ?>

        function cekAsuransi() {
            var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
            var pasien_id = $("#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>").val();
            if (pasien_id == "") {
                myAlert('Masukan terlebih dahulu data pasien!');
            } else if (penjamin_id == "") {
                myAlert('Masukan terlebih dahulu penjamin!');
            } else {
                $.fn.yiiGridView.update('asuransi-m-grid', {
                    data: {
                        "<?php echo get_class($modAsuransiPasien); ?>[pasien_id]": pasien_id,
                        "<?php echo get_class($modAsuransiPasien); ?>[penjamin_id]": penjamin_id,
                    }
                });
                $("#dialogAsuransi").dialog('open');
            }
            return false;
        }

        <?php if (strtolower($this->id) != 'pendaftaranrawatdarurat') : ?>

            function cekAsuransiBpjs() {
                var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
                var pasien_id = $("#<?php echo CHtml::activeId($modPasien, 'pasien_id') ?>").val();

                if (pasien_id == "") {
                    myAlert('Masukan terlebih dahulu data pasien!');
                } else if (penjamin_id == "") {
                    myAlert('Masukan terlebih dahulu penjamin!');
                } else {
                    $.fn.yiiGridView.update('asuransibpjs-m-grid', {
                        data: {
                            "<?php echo get_class($modAsuransiPasienBpjs); ?>[pasien_id]": pasien_id,
                            "<?php echo get_class($modAsuransiPasienBpjs); ?>[penjamin_id]": penjamin_id,
                        }
                    });
                    $("#dialogAsuransiBpjs").dialog('open');
                }
                return false;
            }
        <?php endif; ?>


    <?php } ?>

    function resetDiagnosaBpjs() {
        $("#diagnosaRujukanKodeBpjs").each(function() {
            $(this).find('option').detach();
        });
        $("#diagnosaRujukanKodeBpjs").each(function() {
            $(this).parent().find('.holder .bit-box').detach();
        });
        $("#diagnosaRujukanBpjs").each(function() {
            $(this).find('option').detach();
        });
        $("#diagnosaRujukanBpjs").each(function() {
            $(this).parent().find('.holder .bit-box').detach();
        });
    }

    function resetFormBpjs() {
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'asuransipasien_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nopeserta') ?>").val('');
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val('');
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namapemilikasuransi') ?>").val('');
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'nomorpokokperusahaan') ?>").val('');
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'namaperusahaan') ?>").val('');
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'kelastanggunganasuransi_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val('');
        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk') ?>").val('');
        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'namaperujuk2') ?>").val('');
        $("#<?php echo CHtml::activeId($modRujukanBpjs, 'tanggal_rujukan') ?>").val('');
        $("#diagnosaRujukanKodeBpjs").each(function() {
            $(this).find('option').detach();
        });
        $("#diagnosaRujukanKodeBpjs").each(function() {
            $(this).parent().find('.holder .bit-box').detach();
        });
        $("#diagnosaRujukanBpjs").each(function() {
            $(this).find('option').detach();
        });
        $("#diagnosaRujukanBpjs").each(function() {
            $(this).parent().find('.holder .bit-box').detach();
        });
        $("#<?php echo CHtml::activeId($modSep, 'sep_id') ?>").val('');
        $("#<?php echo CHtml::activeId($modSep, 'ppkrujukan') ?>").val('');
        $("#<?php echo CHtml::activeId($modSep, 'catatansep') ?>").val('-');
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispersertakode_bpjs') ?>").val('');
        $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs, 'jenispeserta_bpjs') ?>").val('');
    }

    /* set dokter ruangan dari dialog jadwal dokter
     * @param {type} pegawai_id
     * @returns {undefined}
     */
    function setDokterJadwal(pegawai_id) {
        $("#<?php echo CHtml::activeId($model, "pegawai_id"); ?>").val(pegawai_id);
        setAntrianDokter();
        $('#jadwalDokter').dialog('close');
        <?php if ($this->id == "pendaftaranRawatJalan") : ?>
            listKuota();
        <?php endif; ?>
    }

    function setRuanganJadwalDokter() {
        var ruangan_id = $("#<?php echo CHtml::activeId($model, "ruangan_id"); ?>").val();

        if (ruangan_id == "") {
            myAlert('Silakan pilih ruangan terlebih dahulu!');
        } else {
            $.fn.yiiGridView.update('rdjadwaldokter-m-grid', {
                data: {
                    // "PPJadwaldokterM[ruangan_id]": ruangan_id,
                    "PPJadwaldokterM[pegawai_id]": '',
                    "PPJadwaldokterM[jadwaldokter_hari]": '<?php echo strtoupper(MyFormatter::getDayUser(date('w'))) ?>',
                    "PPJadwaldokterM[jadwaldokter_buka]": '',
                    "PPJadwaldokterM_page": "1",
                }
            });
            $('#jadwalDokter').dialog('open');
        }
        return false;

    }

    function setSEP(obj) {
        if ($(obj).is(':checked')) {
            $('#content-bpjs').find(".nosep").removeAttr("disabled");
        } else {
            $('#content-bpjs').find(".nosep").attr("disabled", true);
        }

    }

    /**
     * checking penjamin pegawai badak apakah msh aktif / tidak
     * @returns {undefined}
     * LNG-48
     */
    function cekCaraBayarBadak(carabayar_id) {
        var pegawai_id = $("#PPPasienM_pegawai_id").val();

        if ((carabayar_id == <?= Params::CARABAYAR_ID_BADAK; ?>) || (carabayar_id == <?= Params::CARABAYAR_ID_DEP_BADAK; ?>) || (carabayar_id == <?= Params::CARABAYAR_ID_PEKERJA; ?>)) {
            if (pegawai_id == '') {
                myAlert("Pilih data pegawai penanggung jawab terlebih dahulu!");
                $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val("");
                $("#PPPasienAdmisiT_carabayar_id").val("");
            } else {
                $("#content-asubadak").addClass("animation-loading");
                $("#content-asudepartemen").addClass("animation-loading");
                $("#content-asupekerja").addClass("animation-loading");
                var pasien_id = $("#<?php echo CHtml::activeId($modPasien, "pasien_id"); ?>").val();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('CekCaraBayarBadak'); ?>',
                    data: {
                        pasien_id: pasien_id,
                        pegawai_id: pegawai_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.status === true) {
                            setAsuransiBadak();
                        } else {
                            myAlert(data.pesan);
                            $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val("");
                            $("#PPPasienAdmisiT_carabayar_id").val("");
                        }
                        $("#content-asubadak").removeClass("animation-loading");
                        $("#content-asudepartemen").removeClass("animation-loading");
                        $("#content-asupekerja").removeClass("animation-loading");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }

        }

    }

    /**
     * checking validasi penjamin (This Function Dedicate For LNG Projects Only)
     * @returns {undefined}
     * LNG-3
     */
    function cekValiditasPenjamin(penjamin_id) {
        var carabayar_id = $("#<?php echo CHtml::activeId($model, "carabayar_id"); ?>").val();
        var pegawai_id = $("#PPPasienM_pegawai_id").val();
        if (carabayar_id == <?= Params::CARABAYAR_ID_BADAK; ?>) {

            if ((penjamin_id == <?= Params::PENJAMIN_ID_PISA; ?>) || (penjamin_id == <?= Params::PENJAMIN_ID_PROKESPEN; ?>)) {
                var pasien_id = $("#<?php echo CHtml::activeId($modPasien, "pasien_id"); ?>").val();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('cekValiditasPenjamin'); ?>',
                    data: {
                        type: "badak",
                        pasien_id: pasien_id,
                        penjamin_id: penjamin_id,
                        pegawai_id: pegawai_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if ((data.status == 'Empty') || (data.status == 'Fail')) {
                            myAlert(data.pesan);
                            $("#<?php echo CHtml::activeId($model, "penjamin_id"); ?>").html(data.html);
                        } else {

                            if (data.penj == <?= Params::PENJAMIN_ID_PISA; ?>) {
                                if (data.status == 'Tidak Tetap') {
                                    myAlert(data.pesan);
                                    $("#PPPendaftaranT_penjamin_id").html(data.html);
                                }
                            } else {
                                myAlert("Prokespen hanya menjamin Pensiunan dan Istri/Suami Pensiunan");
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
            setDropdownStatushubungankeluarga(penjamin_id);

        } else if (carabayar_id == <?= Params::CARABAYAR_ID_DEP_BADAK; ?>) {

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('cekValiditasPenjamin'); ?>',
                data: {
                    type: "departemen",
                    penjamin_id: penjamin_id
                },
                dataType: "json",
                success: function(data) {
                    $("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen, "namaperusahaan"); ?>").val(data.data.penjamin_nama);
                    $(".judulasuransi").html("Asuransi " + data.data.penjamin_nama);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }

    }

    function cekStatusPekerjaan(obj) {
        var namaDepan = $('#PPPasienM_namadepan').val();
        var namaPekerjaan = obj.value;
        var umur = $("#<?php echo CHtml::activeId($model, 'umur'); ?>").val().substr(0, 3);
        umur = parseInt(umur);
        if (namaDepan.length > 0) {
            if (umur < 15) {
                if (namaPekerjaan !== '13' && namaPekerjaan != '10') {
                    if (namaPekerjaan !== '') {
                        alert('Pasien masih di bawah umur, silakan cek kembali!');
                    }
                    $(obj).val('');
                } else {
                    $(obj).val(namaPekerjaan);
                }
            } else {
                if (namaPekerjaan === '12') {
                    if (namaDepan === 'Ny. ') {
                        $(obj).val('9');
                    } else if (namaDepan === 'Nn. ' && namaPekerjaan === '9') {
                        alert('Pasien belum menikah, silakan cek kembali!');
                        $(obj).val('');
                    } else {
                        $(obj).val('');
                    }
                    alert('Silakan pilih pekerjaan yang tepat!');
                } else {
                    if (namaPekerjaan === '9') {
                        if (namaDepan !== 'Ny. ') {
                            if ($("#PPPasienM_jeniskelamin_0").is(":checked")) alert("Silakan Cek Kembali Jenis Kelamin Yang Dipilih!");
                            else alert('Silakan Cek Kembali Status Perkawinan Anda!');
                            $(obj).val('');
                        }
                    }
                }
            }
            /*
                    if(namaPekerjaan === '12' && umur < 17)
                    {
                        if(namaDepan !== 'BY. Ny.' && namaDepan !== 'An.' && namaDepan !== 'Nn')
                        {
                            alert('Silakan pilih pekerjaan yang sesuai!');
                            $(obj).val('');
                        }
                    }else{
                        if(namaDepan === 'BY. Ny.')
                        {
                            alert('Silakan pilih pekerjaan yang sesuai!');
                            $(obj).val('');
                        }else{
                            if(namaPekerjaan === '11' || namaPekerjaan === '10')
                            {
                                if(namaDepan !== 'An.' && namaDepan !== 'Nn'){
                                    alert('Silakan pilih pekerjaan yang sesuai!');
                                    $(obj).val('');
                                }
                            }else{
                                if(namaPekerjaan !== '13' && namaPekerjaan !== '14')
                                {
                                    if(namaPekerjaan === '9' && namaDepan !== 'Ny.')
                                    {
                                        alert('Silakan pilih pekerjaan yang sesuai!');
                                        $(obj).val('');
                                    }else{
                                        if((namaDepan === 'An.' || namaDepan === 'Nn') && umur < 25){
                                            alert('Silakan pilih pekerjaan yang sesuai!');
                                            $(obj).val('');
                                        }
                                    }
                                }
                            }
                        }
                    }
            */
        } else {
            $(obj).val('');
            alert('Silakan pilih gelar kehormatan terlebih dahulu!');
        }

    }

    /**
     * load ruangan pasien terakhir
     * @returns {undefined}
     */
    function getRuanganPoliklinikPasien() {
        var pasien_id = $("#<?php echo CHtml::activeId($modPasien, "pasien_id"); ?>").val();
        var ruangan_id = $("#<?php echo CHtml::activeId($model, "ruangan_id"); ?>").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getRuanganPoliklinikPasien'); ?>',
            data: {
                pasien_id: pasien_id,
                ruangan_id: ruangan_id
            },
            dataType: "json",
            success: function(data) {
                if (data.status == 'Ya') {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function resetFormPegawai() {
        $('#PPPasienM_pegawai_id').val('');
        $('#PPPegawaiM_nomorindukpegawai').val('');
        $('#PPPegawaiM_nama_pegawai').val('');
        $('#PPPegawaiM_unit_perusahaan').val('');
        $('#PPPegawaiM_jabatan_nama').val('');
    }

    function cekPilihSatu(obj) {
        // console.log($(obj).find('option').length);
        if ($(obj).find('option').length == 2) {
            $(obj).val($(obj).find('option').eq(1).val());
            $(obj).change();
        }
        if ($(obj).find('option').length == 1) {
            $(obj).change();
        }
    }

    function cekPilihKelasRJ() {
        $('#PPPendaftaranT_kelaspelayanan_id option').each(function() {
            if ($(this).val() === 6) {
                $('#PPPendaftaranT_kelaspelayanan_id option').val(6);
                console.log('kudune milih rawat jalan iki');
            }
        });
    }

    function switchOtomatis(obj) {
        otoval = $(obj).val();
        checkOto();
    }

    function checkOto() {
        $(".no_rekam_medik_manual").prop("disabled", true);
        console.log("otoval", otoval);
        if (otoval == 1) {
            $(".labelrm").show();
            $(".rm_lama").hide();
            $(".rm_baru").hide();
            $(".rm_manual").show();
            $("#lb_rm_lama").removeClass("required").find("span").removeClass("required").hide();
            <?php
            if ($model->buatjanjipoli_id == '') {
            ?>
                $("#no_rekam_medik_baru, #PPPasienM_nomorindukpegawai").val("");
            <?php
            }
            ?>

            $(".rm_lama.rm_state").find("label.control-label").removeClass("required");

            $("#pendaftaranFP").hide();
            // $("#btn_hak_pasien").prop("disabled", false);
            $(".rm_nip_baru").show().find(":input").prop("disabled", false);
            $(".normpilihan").removeClass('hide');
            $("#no_rekam_medik_baru").prop("disabled", true);
            pilihIsManual();
        } else {

            $(".rm_lama.rm_state").find("label.control-label").addClass("required");

            $(".labelrm").hide();
            $(".rm_baru").show();
            $(".rm_lama").hide();
            $(".rm_manual").hide();
            $("#lb_rm_lama").addClass("required").find("span").addClass("required").show();
            <?php
            if ($model->buatjanjipoli_id == '') {
            ?>
                $("#no_rekam_medik_baru, #PPPasienM_nomorindukpegawai").val("");
            <?php
            }
            ?>
            $("#pendaftaranFP").show();
            // $("#btn_hak_pasien").prop("disabled", true);
            $(".rm_nip_baru").hide().find(":input").prop("disabled", true);
            $(".normpilihan").addClass('hide');
            $(".is_rm_manual").eq(1).click();
            $("#no_rekam_medik_baru").prop("disabled", false);
            pilihIsManual();
        }

    }

    function pilihIsManual() {
        if ($(".is_rm_manual:checked").val() == 1) {
            $(".no_rekam_medik_manual").prop("disabled", false);
        } else {
            $(".no_rekam_medik_manual").prop("disabled", true).val("");
        }
    }

    function hideHitunganRM() {
        $(".rm_control").hide();
        $(".rm_state").show();
    }

    function showHitunganRM() {
        $(".rm_control").show();
        checkOto();
    }

    function setNamaAsuransiDariPenjamin(obj) {
        var t = ($(obj).find(":selected").text()).toUpperCase();
        $("#<?php echo CHtml::activeId($modAsuransiPasien, "namaperusahaan"); ?>").val(t);
    }

    function cekTanggalKonfirmasi() {
        if ($(".rb_kon").eq(0).is(":checked")) {
            var d = new Date();
            var ds = numPads(d.getDate(), "00") + "/" + numPads(d.getMonth() + 1, "00") + "/" + d.getFullYear();
            var dt = numPads(d.getHours(), "00") + ":" + numPads(d.getMinutes(), "00") + ":" + numPads(d.getSeconds(), "00");

            $("#<?php echo CHtml::activeId($modAsuransiPasien, "tgl_konfirmasi"); ?>").val(ds + " " + dt);
        } else {
            $("#<?php echo CHtml::activeId($modAsuransiPasien, "tgl_konfirmasi"); ?>").val("");
        }
    }

    function numPads(str, pad) {
        return (pad + str).slice(-pad.length);
    }

    function getBpjsPPKRujukan(ppk) {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        if (ppk == "") {
            myAlert('Isi data terlebih dahulu!');
            return false;
        }
        if (ppk.trim().length != 8) {
            myAlert('PPK Rujukan harus 8 Digit');
            return false;
        }
        var aksi = 12; // 12 cari ppk rujukan
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&ppkrujukan=' + ppk + '&start=0&limit=1',
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);
                console.log(obj, 'obje');
                var asalrujukan_id = $('#<?php echo CHtml::activeId($modRujukanBpjs, 'asalrujukan_id'); ?>');
                var asalrujukan2 = $('#<?php echo CHtml::activeId($modRujukanBpjs->asalrujukan, 'asalrujukan_nama'); ?>');
                if (obj.response != null) {
                    myAlert("PKK : " + obj.response.faskes[0].kode + "\n" +
                        "Nama : " + obj.response.faskes[0].nama + "\n");
                    $('#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk'); ?>').val(obj.response.faskes[0].nama);
                    $('#<?php echo CHtml::activeId($modRujukanBpjs, 'namaperujuk2'); ?>').val(obj.response.faskes[0].nama);
                    $('#<?php echo CHtml::activeId($modSep, 'ppkrujukan'); ?>').val(obj.response.faskes[0].kode);
                    asalrujukan_id.val(obj.response.faskes[0].asalrujukan_id);
                    asalrujukan2.val(asalrujukan[obj.response.faskes[0].asalrujukan_id]);

                } else {
                    myAlert(obj.metadata.message);
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    $(".rb_kon").change(function() {
        cekTanggalKonfirmasi();
    });

    function cekJamPoli() {

        if ($("#jam_awal").val() == "" || $("#jam_tutup").val() == "") return true;

        jam_awal = new Date($("#jam_awal").val());
        jam_tutup = new Date($("#jam_tutup").val());
        cur = new Date();
        console.log(jam_awal)
        if (cur.getTime() < jam_awal.getTime() || cur.getTime() > jam_tutup.getTime()) {
            myAlert("Tidak bisa mendaftarkan pasien diluar jadwal.\n" +
                $("#nama_ruangan").val() + " : " + $("#jam_awal_a").val() + " - " + $("#jam_tutup_a").val());

            return false;
        }

        return true;
    }

    function cekSEP(nosep) {
        var setting = {
            url: "<?php echo $this->createUrl('cekSEP'); ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                nosep: nosep
            },
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                console.log(data);
                var obj = data;
                if (obj.response != null) {
                    myAlert(
                        "Nama Peserta : " + obj.response.peserta.nama + "\n" +
                        "Nomor Kartu : " + obj.response.peserta.noKartu + "\n" +
                        "No. Sep : " + obj.response.noSep
                    );
                    $("#PPSepT_ppkrujukan").val(obj.response.provRujukan.kdProvider);
                    $("#PPRujukanbpjsT_no_rujukan").val(obj.response.noRujukan);
                    getAsuransiNoKartu(obj.response.peserta.noKartu);
                    if (obj.rujukan.rujukandari_id.toString().trim() != "") {
                        $("#PPRujukanbpjsT_asalrujukan_id").val(obj.rujukan.asalrujukan_id);
                        $("#PPRujukanbpjsT_rujukandari_id")
                            .html(obj.rujukan.listrujukandari_id)
                            .val(obj.rujukan.rujukandari_id)
                            .change();
                    }
                } else {
                    myAlert(obj.metadata.message);
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }




    /**
     * javascript yang di running setelah halaman ready / load sempurna
     * posisi script ini harus tetap dibawah
     */
    $(document).ready(function() {
        $(".rb_rm").eq(1).click();
        <?php if (isset($_GET['pasien_id']) && !empty($_GET['pasien_id'])) : ?>
            $(".rb_rm").eq(1).click();
            $("#no_rekam_medik_baru").val('<?php echo $modPasien->no_rekam_medik; ?>');
            setTimeout(function() {
                $("#no_rekam_medik_baru").blur();
            }, 1500);
            <?php if (isset($ruangan) && !empty($ruangan)) : ?>
                $("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").val(<?php echo $ruangan; ?>).change().multiselect('rebuild');
            <?php endif; ?>
        <?php else : ?>
            checkOto();
        <?php endif; ?>

        $("#form-karcis .accordion-heading a").click(function() {
            return false;
        });

        $("#form-bpjs .accordion-heading a").click(function() {
            return false;
        });

        $("#form-asuransi-igd .accordion-heading a").click(function() {
            return false;
        });

        $("#form-asuransi .accordion-heading a").click(function() {
            return false;
        });


        <?php if (strtolower($this->id) == "pendaftaranrawatdarurat") : ?>
            $('#form-asuransi-igd').hide();
            sembunyiFormAsuransi_IGD();
            setChangeStatusKecelakaan();
        <?php endif; ?>

        $("#form-pjpasien .accordion-heading a").click(function() {
            // return false;
        });
        <?php $modKonfigsystem = KonfigsystemK::model()->find();
        if (!$modKonfigsystem->isbridging) : ?>
            $("#PPPendaftaranT_is_bpjs_manual").attr('checked', true);
        <?php endif; ?>

        <?php $modKonfigsystem = KonfigsystemK::model()->find();
        if ($modKonfigsystem->jenisrujukan == 1) : ?>
            $('#PPSepT_jenisfaskes_0').prop('checked', true).change();
            $('#PPRujukanbpjsT_asalrujukan_id').val(5)
        <?php elseif ($modKonfigsystem->jenisrujukan == 2) : ?>
            $('#PPSepT_jenisfaskes_1').prop('checked', true).change();
            $('#PPRujukanbpjsT_asalrujukan_id').val(6)
        <?php endif; ?>

        <?php if (!empty($model->pendaftaran_id)) { ?>
            console.log("Start AUTOPRINT");
            autoPrint();
            $("input, select, textarea").attr("disabled", true);
            $("#bth-lihatantrian").parent().parent().hide();
            $(".add-on").hide();
        <?php } ?>
        <?php
        if (!empty($model->antrian_id)) {
            $antrian = AntrianT::model()->findByPk($model->antrian_id);
            if ($konfig->is_nodejsaktif) {
        ?>
                socket.emit('send', {
                    conversationID: 'antrian',
                    loket_id: <?php echo $antrian->loket_id; ?>
                });
        <?php
            }
        } ?>
        setUmur($("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir'); ?>").val());

        // Notifikasi Pasien
        <?php
        if (isset($_GET['smspasien'])) {
            if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $model->pasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16
                insert_notifikasi(params);
        <?php
            }
        }
        ?>
        // Notifikasi Dokter
        <?php
        if (isset($_GET['smsdokter'])) {
            if ($_GET['smsdokter'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS DOKTER',
                    isinotifikasi: 'dr. <?php echo $model->pegawai->nama_pegawai; ?> tidak memiliki nomor mobile'
                }; // 16
                insert_notifikasi(params);
        <?php
            }
        }
        ?>
        // Notifikasi Penanggungjawab
        <?php
        if (isset($_GET['smspenanggungjawab'])) {
            if ($_GET['smspenanggungjawab'] == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PENANGGUNG JAWAB',
                    isinotifikasi: 'Penanggung jawab pasien <?php echo $model->pasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16
                insert_notifikasi(params);
        <?php
            }
        }
        ?>
        setTimeout(function() {
            $(".f_rm:first").focus();
        }, 500);

        $("#btn_hak_pasien").on('click', setHakPasien);

        <?php if (isset($_GET['sukses'])) { ?>
            $("#no_rekam_medik_baru").val('<?php echo $modPasien->no_rekam_medik; ?>');
            $("#pendaftaranFP").prop("disabled", false);
            $("#verifikasiFP").prop("disabled", false);
        <?php } ?>

        setInputWilayah();


    });

    var input_propinsi = $("<?php echo "#" . CHtml::activeId($modPasien, 'propinsi_id'); ?>");
    var input_kabupaten = $("<?php echo "#" . CHtml::activeId($modPasien, 'kabupaten_id'); ?>");
    var input_kecamatan = $("<?php echo "#" . CHtml::activeId($modPasien, 'kecamatan_id'); ?>");
    var input_kelurahan = $("<?php echo "#" . CHtml::activeId($modPasien, 'kelurahan_id'); ?>");
    var input_ruangan = $("<?php echo "#" . CHtml::activeId($model, 'ruangan_id'); ?>");
    var smf = $("<?php echo "#" . CHtml::activeId($model, 'jeniskasuspenyakit_id'); ?>");

    function setInputWilayah() {

        jQuery(input_propinsi).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                setClearDropdownKelurahan();
                setClearDropdownKecamatan();
                $.post('<?php echo $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($modPasien))) ?>', {
                    "PPPasienM": {
                        propinsi_id: $(input_propinsi).val()
                    }
                }, function(data) {
                    $(input_kabupaten).html(data);
                    $(input_kabupaten).multiselect("rebuild");
                });
            }
        }).hide();

        jQuery(input_kabupaten).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                setClearDropdownKelurahan();
                $.post('<?php echo $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($modPasien))) ?>', {
                    "PPPasienM": {
                        kabupaten_id: $(input_kabupaten).val()
                    }
                }, function(data) {
                    $(input_kecamatan).html(data);
                    $(input_kecamatan).multiselect("rebuild");
                });
            }
        }).hide();

        jQuery(input_kecamatan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                $.post('<?php echo $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($modPasien))) ?>', {
                    "PPPasienM": {
                        kecamatan_id: $(input_kecamatan).val()
                    }
                }, function(data) {
                    $(input_kelurahan).html(data);
                    $(input_kelurahan).multiselect("rebuild");
                });
            }
        }).hide();

        jQuery(input_kelurahan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(input_ruangan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                setDropdownDokter($(element).val());
                // setDropdownJeniskasuspenyakit($(element).val());
                setKarcis();
                setAntrianRuangan();
                getRuanganPoliklinikPasien();


                $("#PPPendaftaranT_nursestation_id").val($(element).data('nursestation_id'));
                $("#nursestation_nama").val($(element).data('nursestation_nama'));

                <?php if ($this->id == "pendaftaranRawatJalan") : ?>
                    listKuota();
                <?php endif; ?>
            }
        }).hide();

        jQuery(smf).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                <?php if ($this->id != "pendaftaranPersalinan") : ?>
                    setDropDownRuangan($(element).val());
                <?php endif; ?>
                setKarcis();
                listKuota();
            }
        }).hide();

    }



    //pengantar

    function cekPengantar() {
        var pengantar = $('#<?php echo CHtml::activeId($modPenanggungJawab, 'pengantar') ?>').val();

        if (pengantar == '<?php echo Params::PENGANTAR_DIRI_SENDIRI; ?>') {
            setPengantar();
        } else {
            setResetPengantar();
        }
    }

    function setPengantar() {
        var nama = $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val();
        var laki = $("#<?php echo CHtml::activeId($modPasien, 'jeniskelamin') ?>_0");
        var perempuan = $("#<?php echo CHtml::activeId($modPasien, 'jeniskelamin') ?>_1");
        var noiden = $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").val();
        var jenisiden = $("#<?php echo CHtml::activeId($modPasien, 'jenisidentitas') ?>").val();
        var tanggallahir = $("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir') ?>").val();
        var tempatlahir = $("#<?php echo CHtml::activeId($modPasien, 'tempat_lahir') ?>").val();
        var umur = $("#<?php echo CHtml::activeId($model, 'umur') ?>").val();
        var alamat = $("#<?php echo CHtml::activeId($modPasien, 'alamat_pasien') ?>").val();
        var telepon = $("#<?php echo CHtml::activeId($modPasien, 'no_telepon_pasien') ?>").val();
        var mobile = $("#no_mobile_pasien").val();
        var gender = '';

        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pj') ?>").val(nama);
        if (laki.is(":checked")) {
            gender = laki.attr("value");
        } else if (perempuan.is(":checked")) {
            gender = perempuan.attr("value");
        }

        $("#form-pjpasien").find('input[name$="[jeniskelamin]"][type="radio"]').each(function() {
            if ($(this).val() == $.trim(gender)) {
                $(this).attr('checked', true);
            }
        });

        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jeniskelamin') ?>_1").val();
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").val(noiden);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jenisidentitas') ?>").val(jenisiden);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tgllahir_pj') ?>").val(tanggallahir);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tempatlahir_pj') ?>").val(tempatlahir);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'umur_pj') ?>").val(umur);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'alamat_pj') ?>").val(alamat);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_teleponpj') ?>").val(telepon);
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_mobilepj') ?>").val(mobile);
    }

    function setResetPengantar() {
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jeniskelamin') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jenisidentitas') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tgllahir_pj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tempatlahir_pj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'umur_pj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'alamat_pj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_teleponpj') ?>").val('');
        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_mobilepj') ?>").val('');
    }

    /**
     *
     * @param {type} obj
     * @returns {change attribute maxlength}
     */
    function cekLength(obj) {
        var cek = $(obj).val();

        if (cek == '<?php echo Params::JENIS_IDENTITAS_KTP ?>') {
            $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('maxlength', 16);
        } else {
            $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien') ?>").attr('maxlength', 30);
        }
    }

    /**
     *
     * @param {type} obj
     * @returns {change attribute maxlength}
     */
    function cekLengthPJ(obj) {
        var cek = $(obj).val();

        if (cek == '<?php echo Params::JENIS_IDENTITAS_KTP ?>') {
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").attr('maxlength', 16);
        } else {
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").attr('maxlength', 30);
        }
    }

    <?php

    $kelas_data  = KelaspelayananM::model()->findAllByAttributes(array(
        'kelaspelayanan_aktif' => true,
    ), array(
        'order' => 'kelaspelayanan_nama',
    ));
    $kelas = CHtml::listData($kelas_data, 'kelaspelayanan_id', 'kelasbpjs_id');

    $kelas_urut = CHtml::listData($kelas_data, 'kelaspelayanan_id', 'kelasnaikbpjs_id');


    ?>

    var data_kelas = <?php echo CJSON::encode($kelas); ?>;
    var data_kelas_naik_bpjs = <?php echo CJSON::encode($kelas_urut); ?>;

    /**
     * - digunakan untuk menginformasikan ada perbedaan kelas tanggunagn dan kelas pelayanan
     * @param {type} obj
     * @returns {give warning} */
    function cekPerbedaanKelas(obj) {
        var kelaspelayanan = $("#PPPasienAdmisiT_kelaspelayanan_id option:selected");

        var carabayar = $("#PPPasienAdmisiT_carabayar_id option:selected").val();

        if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>) {
            <?php if (Yii::app()->user->getState('isbridging') == true) { ?>
                var kelastanggungan = $("#PPAsuransipasienbpjsM_kelastanggunganasuransi_id option:selected");
            <?php } else { ?>
                var kelastanggungan = $("#PPAsuransipasienM_kelastanggunganasuransi_id option:selected");
            <?php } ?>
        } else {
            //var kelastanggungan = $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?> option:selected");
            var kelastanggungan = $("#tampungkelas option:selected"); // = $("#<?php echo CHtml::activeId($modAsuransiPasien, 'kelastanggunganasuransi_id') ?> option:selected");
        }
        //alert(kelaspelayanan.val()+'-'+kelastanggungan.val());

        $("#PPSepT_penanggungjwb_naikkls_id").prop("disabled", true).val("").parents(".control-group").hide();
        $("#PPSepT_klsRawatNaik").val("");

        if (typeof kelastanggungan.val() === 'undefined') {

        } else {

            if (kelaspelayanan.val() != '' && (kelastanggungan.val() != '')) {
                if (kelastanggungan.text() != kelaspelayanan.text()) {
                    myAlert("Anda memilih kelas pelayanan yang berbeda dengan tanggungan penjamin, maka pasien akan dikenakan selisih biaya", "Perhatin!");

                    if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>) {
                        cekBedaKelasBPJS(kelaspelayanan.val(), kelaspelayanan.val());
                    }
                }
            }
        }
    }


    function cekBedaKelasBPJS(kelaspelayanan_id, kelastanggungan_id) {
        console.log("Kelas BPJS", data_kelas[kelaspelayanan_id], kelastanggungan_id);

        if (data_kelas[kelaspelayanan_id] != null && data_kelas[kelaspelayanan_id] < kelastanggungan_id) {
            $("#PPSepT_penanggungjwb_naikkls_id").prop("disabled", false).val("").parents(".control-group").show();
            $("#PPSepT_klsRawatNaik").val(data_kelas_naik_bpjs[kelaspelayanan_id]);
        } else {
            $("#PPSepT_penanggungjwb_naikkls_id").prop("disabled", true).val("").parents(".control-group").hide();
            $("#PPSepT_klsRawatNaik").val("");
        }
    }

    /**
     * - digunakan untuk mmevalidasi bahwa no asuransi bpjs harus 13 karakter atau tidak boleh dan kurang dari 13 karakter
     * @param {type} obj
     * @returns {give warning} */
    function cekNoAsuransiBpjs() {
        <?php if (Yii::app()->user->getState('isbridging') == true) { ?>
            var nobpjs = $("#PPAsuransipasienbpjsM_nokartuasuransi").val();
        <?php } else { ?>
            var nobpjs = $("#PPAsuransipasienM_nokartuasuransi").val();
        <?php } ?>

        <?php if (isset($statusMenu)) { ?>
            var carabayar = $("#PPPasienAdmisiT_carabayar_id option:selected").val();
            var penjamin = $("#PPPasienAdmisiT_penjamin_id option:selected").val();
        <?php } else { ?>
            var carabayar = $("#PPPendaftaranT_carabayar_id option:selected").val();
            var penjamin = $("#PPPendaftaranT_penjamin_id option:selected").val();
        <?php } ?>

        if (typeof nobpjs === 'undefined') {

        } else {
            //alert('tenaga');
            if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>) {
                if (penjamin == <?php echo Params::PENJAMIN_ID_BPJS_KESEHATAN ?>) {
                    if (nobpjs.length != 13) {
                        myAlert("No. Kartu Asuransi BPJS Kesehatan tidak boleh lebih dan tidak boleh kurang dari sama dengan 13 karakter");
                        return false;
                    }
                } else if (penjamin == <?php echo Params::PENJAMIN_ID_BPJS_KETENAGAKERJAAN ?>) {

                    if (nobpjs.length < 7 || nobpjs.length > 13) {
                        myAlert("No. Kartu Asuransi BPJS Ketenagakerjaan tidak boleh kurang dari 7 dan lebih dari 13 karakter");
                        return false;
                    }
                }
            }
        }
        return true;
    }

    function setKelasTanggunganDrop() {
        <?php
        $drop_kelasbpjs = CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama');

        $drop_bpjs = '';

        $pilih_pertama = '';

        if (count((array)$drop_kelasbpjs) > 0) {

            if (count((array)$drop_kelasbpjs) > 1) {
                $drop_bpjs .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            }

            foreach ($drop_kelasbpjs as $value => $name) {
                $drop_bpjs .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }

        $drop_kelas = CHtml::listData(PPPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama');
        $drop_asuran = '';

        if (count((array)$drop_kelas) > 0) {

            if (count((array)$drop_kelas) > 1) {
                $drop_asuran .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            }

            foreach ($drop_kelas as $value1 => $name1) {
                $drop_asuran .= CHtml::tag('option', array('value' => $value1), CHtml::encode($name1), true);
            }
        }
        ?>
        var dropdown_kelasbpjs = '<?php echo $drop_bpjs; ?>';
        var dropdown_kelas = '<?php echo $drop_asuran; ?>';

        <?php if (isset($statusMenu)) { ?>
            var carabayar = $("#PPPasienAdmisiT_carabayar_id option:selected").val();
        <?php } else { ?>
            var carabayar = $("#PPPendaftaranT_carabayar_id option:selected").val();
        <?php } ?>

        if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>) {
            $("#PPAsuransipasienM_nokartuasuransi").attr('maxlength', 13);
            $("#PPAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelasbpjs);
        } else {
            $("#PPAsuransipasienM_nokartuasuransi").attr('maxlength', 24);
            $("#PPAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelas);
        }

    }

    function getPPKPelayanan() {
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        var jenis_rujukan = 2;
        var kodeppkpelayanan = '<?php echo Yii::app()->user->getState('ppkpelayanan'); ?>';

        var aksi = 16;
        var setting = {
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&kodeppkpelayanan=' + kodeppkpelayanan + '&jenis_rujukan=' + jenis_rujukan,
            beforeSend: function() {
                $("#content-bpjs").addClass("animation-loading");
            },
            success: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
                var obj = JSON.parse(data);
                if (obj.metaData.code == '201') {
                    //				myAlert(obj.metaData.message);
                } else {
                    if (obj.response != null) {
                        var faskes = obj.response.faskes;
                        $('#<?php echo CHtml::activeId($model, 'ppkpelayanan_nama'); ?>').val(faskes[0].nama);

                        <?php if ($this->id == "pendaftaranRawatDarurat") { ?>
                            $('#<?php echo CHtml::activeId($modSep, 'ppkrujukan'); ?>').val(faskes[0].kode);
                            $('#<?php echo CHtml::activeId($modSep, 'ppkpelayanan_nama'); ?>').val(faskes[0].nama);
                            $('#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk'); ?>').val(faskes[0].nama);
                        <?php } else if ($this->id == "pendaftaranRawatInapDariRJRD") { ?>
                            if ($('#instalasiasalRI_id').val() != undefined && $('#instalasiasalRI_id').val() == '<?php echo Params::INSTALASI_ID_RD; ?>') {
                                $('#<?php echo CHtml::activeId($modSep, 'ppkrujukan'); ?>').val(faskes[0].kode);
                                $('#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk'); ?>').val(faskes[0].nama);
                            }
                        <?php } ?>
                    }
                }
            },
            error: function(data) {
                $("#content-bpjs").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    function setHakPasien(e) {
        e.preventDefault();
        $("#dialog-hak-pasien").dialog("open");
    }

    function setInputBerdasarkanNoKTP() {
        var jenis = $('#<?php echo CHtml::activeId($modPasien, 'jenisidentitas'); ?>').val();
        var no_ktp = $('#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien'); ?>').val();


        if (otoval != 1 || jenis != 'KTP') {
            return false;
        }

        //$('#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien'); ?>').addClass("animation-loading");

        $.post('<?php echo $this->createUrl('inputDariNoKTP'); ?>', {
            no_ktp: no_ktp
        }, function(data) {
            $('#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir'); ?>').val(data.tanggal_lahir_format);
            setJenisKelaminPasien(data.jeniskelamin);
            if (data.propinsi_id != null && data.kabupaten_id != null && data.kecamatan_id != null) {
                setDaerahPasien(data.propinsi_id, data.kabupaten_id, data.kecamatan_id, null);
            }
            setUmur(data.tanggal_lahir);
            //$('#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien'); ?>').removeClass("animation-loading");
        }, 'json');

    }

    function cekDokter() {
        var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();

        if (ruangan_id == "") {
            myAlert('Silakan pilih ruangan terlebih dahulu!');
        } else {
            $.fn.yiiGridView.update('dokter-v-grid', {
                data: {
                    "PPDokterV[ruangan_id]": ruangan_id,
                }
            });
            $("#dialogDokter").dialog('open');
        }
        return false;
    }

    function setRuanganDariKodeBPJS() {
        var id = null;
        $("#PPPendaftaranT_ruangan_id option").each(function() {
            if ($(this).data("kode_bpjs") == $("#PPSepT_politujuan").val()) {
                id = $(this).prop("value");
            }
        });

        if (id != null) {
            $("#PPPendaftaranT_ruangan_id").val(id).multiselect('rebuild');
            setDropdownDokter(id);
            // setDropdownJeniskasuspenyakit(id);
            setKarcis();
            setAntrianRuangan();
            getRuanganPoliklinikPasien();
        }
    }

    function setPenjaminJenisBPJS() {

        var jenis = $("#PPAsuransipasienbpjsM_jenispeserta_bpjs").val();
        var id = null;

        if (jenis == null || jenis == "") {
            return false;
        }

        $("#PPPendaftaranT_penjamin_id option").each(function() {
            if ($(this).data('jenis') == jenis) {
                id = $(this).prop("value");
            }
        });

        if (id != null) {
            $("#PPPendaftaranT_penjamin_id").val(id).change();
        }
    }

    function setPenanggungjawabPS() {

        if ($('.pp_sb').is(':checked')) {
            setDataPJP();
        } else {
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'pengantar') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pj') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jeniskelamin') ?>").prop('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jenisidentitas') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_teleponpj') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_mobilepj') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'hubungankeluarga') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tempatlahir_pj') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tgllahir_pj') ?>").val('');
            $("#<?php echo CHtml::activeId($modPenanggungJawab, 'alamat_pj') ?>").val('');
        }
    }

    function setDataPJP() {

        var pasien_id = $('#PPPasienM_pasien_id').val();
        if (pasien_id) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('GetPJPasien'); ?>',
                data: {
                    pasien_id: pasien_id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (data) {
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'pengantar') ?>").val(data.pengantar);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'nama_pj') ?>").val(data.nama_pj);
                        if (data.jeniskelamin == "<?php echo Params::JENIS_KELAMIN_LAKI_LAKI; ?>") {
                            $("#PPPenanggungJawabM_jeniskelamin_0").prop('checked', true);
                        } else {
                            $("#PPPenanggungJawabM_jeniskelamin_1").prop('checked', true);
                        }
                        // $("#<?php //echo CHtml::activeId($modPenanggungJawab, 'jeniskelamin') 
                                ?>").prop(data.jeniskelamin);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'jenisidentitas') ?>").val(data.jenisidentitas);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_identitas') ?>").val(data.no_identitas);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_teleponpj') ?>").val(data.no_teleponpj);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'no_mobilepj') ?>").val(data.no_mobilepj);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'hubungankeluarga') ?>").val(data.hubungankeluarga);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tempatlahir_pj') ?>").val(data.tempatlahir_pj);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'tgllahir_pj') ?>").val(data.tgllahir_pj);
                        $("#<?php echo CHtml::activeId($modPenanggungJawab, 'alamat_pj') ?>").val(data.alamat_pj);
                        setUmurPjp(data.tgllahir_pj);
                    } else {
                        myAlert('Pasien balum memiliki penanggungjawab sebelumnya')
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    myAlert('ERORR');
                }
            });
        }

    }



    <?php
    if ($this->id == "pendaftaranRawatJalan") {
    ?>

        function addRowMultipoli(obj) {
            var table = $('#table-multipoli');
            var row_tindakanFirst = new String(<?php echo CJSON::encode($this->renderPartial('_formMultipoli', array('modPendaftaranMultiPoli' => $modPendaftaranMultiPoli, 'removeButton' => false), true)); ?>);
            var row_tindakan = new String(<?php echo CJSON::encode($this->renderPartial('_formMultipoli', array('modPendaftaranMultiPoli' => $modPendaftaranMultiPoli, 'removeButton' => true), true)); ?>);
            if (obj == null) {
                $('#table-multipoli').html(row_tindakanFirst.replace());
            } else {
                var tr = $(obj).parents('tr');
                $(row_tindakan.replace()).insertAfter(tr);
            }

            renameInputRowMulti($(table));
            $(table).find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
                "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
            });
        }


        function delRowMultipoli(obj) {
            $(obj).parents('tr').detach();
            renameInputRowMulti('#table-multipoli');
            $('#table-multipoli').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
                "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
            });
        }

        function renameInputRowMulti(obj_table) {
            var row = 0;
            var judulpoli = 1;
            $(obj_table).find("tbody > tr").each(function() {
                $(this).find('input[name*="nourut"]').val(row + 1);
                $(this).find('span[name*="judul"]').html(judulpoli + 1);
                $(this).find('span[name*="[ii]"]').each(function() { //element <span>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                    }
                });
                $(this).find('input,select,textarea').each(function() { //element <input>
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                    }
                });
                row++;
                judulpoli++;
            });
        }

        function setDropdownDokterMultiPoli(obj) {
            var ruangan_id = $(obj).val();
            var nourut = $(obj).parents('tr').find('input[name*="nourut"]').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('SetDropdownDokter'); ?>',
                data: {
                    ruangan_id: ruangan_id
                },
                dataType: "json",
                success: function(data) {
                    $("#PPPendaftaranMultipoli_" + (nourut - 1) + "_pegawai_id").html(data.listDokter);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }

        function setDropdownJeniskasuspenyakitMultiPoli(obj) {
            var ruangan_id = $(obj).val();
            var nourut = $(obj).parents('tr').find('input[name*="nourut"]').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('SetDropdownJeniskasuspenyakit'); ?>',
                data: {
                    ruangan_id: ruangan_id
                },
                dataType: "json",
                success: function(data) {
                    $("#PPPendaftaranMultipoli_" + (nourut - 1) + "_jeniskasuspenyakit_id").html(data.listKasuspenyakit);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    <?php } ?>


    $('input:radio[name="rb_rm"]').change(
        function() {
            if ($(this).is(':checked') && $(this).val() == '1') {
                $('.pj_sb').hide()
            } else {
                $('.pj_sb').show()
            }
        });

    function listKuota() {
        var pegawai_id = $("#PPPendaftaranT_pegawai_id").val();
        var tgl = $("#PPPendaftaranT_tgl_pendaftaran").val();
        var ruangan_id = $("#PPPendaftaranT_ruangan_id").val();
        var pasien_id = $("#PPPasienM_pasien_id").val();

        console.log(pegawai_id, ruangan_id, tgl);


        if (pegawai_id == "" || ruangan_id == "" || tgl == "") {
            return false;
        }

        $(".panel_jadwal").empty();

        return false;

        /*
        $.post("<?php echo $this->createUrl("/pendaftaranPenjadwalan/pembuatanJanjiPoli/getKuotaJanjiPoli") ?>", {
            pegawai_id: pegawai_id,
            ruangan_id: ruangan_id,
            tgl: tgl
        }, function(data) {

            $(".slot_jadwal").html(data.slot);
            $(".panel_jadwal").html(data.checkbox_jadwal);
            $(".no_luarjadwal").val(data.no_luarjadwal);
            setCeklisJadwalDokter();

            // set otomatis pasien
            var jadwal = null;
            var shift = null;
            $(".slot_jadwal option").each(function(data) {
                if ($(this).data('pasien') == pasien_id) {
                    jadwal = $(this).val();
                    shift = $(this).data("jadwal");
                }
            });
            if (jadwal != null) {
                $(".slot_jadwal").val(jadwal).change();
            }
            if (shift != null) {
                $(".panel_jadwal .ceklis_jadwal[value='" + shift + "']").click();
            }

        }, 'json');
        */
    }

    function setCeklisJadwalDokter() {
        var jadwal = $(".ceklis_jadwal:checked").val();

        $(".slot_jadwal option[data-item='1']").hide();

        if (jadwal != null) {
            $(".slot_jadwal option[data-jadwal='" + jadwal + "']").show();
        }
    }

    function cekSlotTersedia() {
        var pasien_id = $("#PPPasienM_pasien_id").val();
        $(".no_antrianjanji").val("");
        if ($(".slot_jadwal :selected").data('terisi') == 1 ||
            $(".slot_jadwal :selected").data('terisi-jadwal') == 1) {
            if ($(".slot_jadwal :selected").data('pasien') != pasien_id) {
                $(".slot_jadwal").val("");
                myAlert("Slot jadwal yang dipilih sudah terisi.");
            } else {
                $(".no_antrianjanji").val($(".slot_jadwal :selected").data('slot'));
            }
        } else {
            $(".no_antrianjanji").val($(".slot_jadwal :selected").data('slot'));
        }

    }


    $(document).ready(function() {
        <?php if (isset($_GET['is_triage']) && $_GET['is_triage'] == 1) : ?>
            switchOtomatis($(".rb_rm"));
            $('.rb_rm').eq(0).attr('checked', true);
        <?php endif; ?>
        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
        /**
         * multi select cara bayar dan penjamin
         */

        jQuery(cara).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
                var v = $(element).val();

                var brands = cara_all;
                var selected = [];

                setFormAsuransi(v);

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {

                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');

                            var v2 = $(element).val();

                            setKarcis();
                            setNamaAsuransiDariPenjamin();
                            setAsuransiBadak(v2);
                            cekValiditasPenjamin(v2);
                            setFormAsuransiInhealth();

                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
        }).hide();

        jQuery(penj).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {

                var v = $(element).val();

                setKarcis();
                setNamaAsuransiDariPenjamin();
                setAsuransiBadak(v);
                cekValiditasPenjamin(v);
                setFormAsuransiInhealth();
            }
        }).hide();


        $('#form-multipoli > div > .accordion-heading').click(function() {
            var is_multipoli = $("#<?php echo CHtml::activeId($model, "is_multipoli"); ?>");
            if (is_multipoli.val() > 0) { //hide
                is_multipoli.val(0);
            } else { //show
                is_multipoli.val(1);
            }
        });

        <?php
        if ($this->id == "pendaftaranRawatJalan") {
        ?>
            addRowMultipoli();
            listKuota();
        <?php } ?>
    });

    $(function() {
        $("#antrian").click(function() {
            if ($(this).is(":checked")) {
                $(".slot_jadwal").hide();
                $(".ceklis_jadwal").hide();
            } else {
                $(".slot_jadwal").show();
                $(".ceklis_jadwal").show();
                cekSlotTersedia();
            }
        });
    });

    function setSuratKontrolDariRujukanRuangan() {
        <?php if (strtolower($this->id) != "pendaftaranrawatjalan") : ?>

            return false;

        <?php else : ?>

            var ruangan_id = $("#<?= CHtml::activeId($modSep, 'politujuan') ?>").val();
            var no_kartu = $("#<?= CHtml::activeId($modAsuransiPasienBpjs, 'nokartuasuransi') ?>").val();
            var no_rujukan = $("#<?= CHtml::activeId($modRujukanBpjs, 'no_rujukan') ?>").val();

            console.log(ruangan_id, "-", no_kartu, "", no_rujukan);
            if (ruangan_id != "" && no_rujukan != "" && no_kartu != "") {

                $(".srk_form_no_surat").addClass("animation-loading");
                $.post('<?php echo $this->createUrl("bpjsLoadSuratKontrolDariRujukanRuangan") ?>', {
                    ruangan_id: ruangan_id,
                    no_rujukan: no_rujukan,
                    no_kartu: no_kartu
                }, function(data) {
                    if (data.ok == 1) {
                        if (data.kontrol.no_surat == '') {
                            $('#PPSepT_jenis_kunjungan').val(0);
                            $('#PPSepT_asesmen_pelayanan').val("");
                        } else {
                            $('#PPSepT_jenis_kunjungan').val(2);
                            $('#PPSepT_asesmen_pelayanan').val(5);
                        }
                        $('#PPSepT_no_surat').val(data.kontrol.no_surat);
                        $('#PPSepT_kode_dpjp').val(data.kontrol.kode_dpjp);
                        $('#PPSepT_nama_dpjp').val(data.kontrol.nama_dpjp);

                        $(".srk_form_no_surat").val(data.kontrol.no_surat);
                        $(".srk_form_nama_dpjp").val(data.kontrol.nama_dpjp);
                        $(".srk_form_kode_dpjp").val(data.kontrol.kode_dpjp);
                    } else {
                        $(".srk_form_no_surat").val("");
                        $(".srk_form_nama_dpjp").val("");
                        $(".srk_form_kode_dpjp").val("");
                    }
                    $(".srk_form_no_surat").removeClass("animation-loading");
                }, 'json');

            }

        <?php endif; ?>
    }

    function cekNoPonselSEP() {

        var nomor_sep = $("#<?php echo CHtml::activeId($modSep, 'no_telpon_peserta') ?>").val();
        var isValid = /^\d+$/.test(nomor_sep);

        if (!isValid) {
            myAlert('Nomor Telepon Harus Berupa Angka');
            $("#<?php echo CHtml::activeId($modSep, 'no_telpon_peserta') ?>").focus();
            return false;
        }

        if (nomor_sep.length < 10) {
            $("#<?php echo CHtml::activeId($modSep, 'no_telpon_peserta') ?>").focus();
            myAlert("No. Handphone yang diinputkan kurang dari 10 karakter");
            return false;

        } else if (nomor_sep.length != 10 && nomor_sep.length > 14) {
            $("#<?php echo CHtml::activeId($modSep, 'no_telpon_peserta') ?>").focus();
            myAlert("No. Handphone yang diinputkan lebih dari 14 karakter");
            return false;
        }

        return true;

    }

    function cekSepRujukan(norujukan, no_kartu) {
        <?php if (strtolower($this->id) != "pendaftaranrawatjalan") : ?>
            return false;
        <?php else : ?>
            $.post('<?php echo $this->createUrl("cekSepRujukan") ?>', {
                norujukan: norujukan,
                no_kartu: no_kartu,
            }, function(data) {
                console.log(data, 'hasil sep')
                if (data.ok == 0) {
                    $("#skdp").addClass('hidden');
                    $('#PPSepT_jenis_kunjungan').val(0);
                    $('#PPSepT_asesmen_pelayanan').val("");
                } else {
                    $("#skdp").removeClass('hidden');
                    $('#PPSepT_jenis_kunjungan').val(2);
                    $('#PPSepT_asesmen_pelayanan').val(5);
                }
            }, 'json');
        <?php endif; ?>
    }
</script>