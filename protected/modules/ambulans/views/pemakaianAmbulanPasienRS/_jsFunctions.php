<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
    /**
     * set form kunjungan
     * @param {type} pasien_id
     * @returns {undefined}
     */
    function setKunjungan(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id) {
        $("#form-datakunjungan > div").addClass("animation-loading");
//    var instalasi_id = $("#instalasi_id").val();
        var instalasi_id = $("#instalasi_id").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDataKunjungan'); ?>',
            data: {instalasi_id: instalasi_id, pendaftaran_id: pendaftaran_id, no_pendaftaran: no_pendaftaran, no_rekam_medik: no_rekam_medik, pasienadmisi_id: pasienadmisi_id},
            dataType: "json",
            success: function (data) {
                $("#cari_pendaftaran_id").val(data.pendaftaran_id);
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasien_id").val(data.pasien_id);
                $("#pasienadmisi_id").val(data.pasienadmisi_id);
                $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                $("#carabayar_id").val(data.carabayar_id);
                $("#penjamin_id").val(data.penjamin_id);
                $("#penanggungjawab_id").val(data.penanggungjawab_id);
                $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                if (data.ruangan_id)
                    $("#ruangan_id").val(data.ruangan_id);
                else
                    $("#ruangan_id").val(data.ruanganakhir_id);
                $("#instalasi_id").val(data.instalasi_id);
                $("#instalasi_nama").val(data.instalasi_nama);
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
                $("#<?php echo CHtml::activeId($modPemakaian, 'norekammedis'); ?>").val(data.no_rekam_medik);
                $("#<?php echo CHtml::activeId($modPemakaian, 'noidentitas'); ?>").val(data.no_identitas_pasien);
                $("#<?php echo CHtml::activeId($modPemakaian, 'namapasien'); ?>").val(data.nama_pasien);
                $("#<?php echo CHtml::activeId($modPemakaian, 'pasien_id'); ?>").val(data.pasien_id);
                $("#<?php echo CHtml::activeId($modPemakaian, 'pendaftaran_id'); ?>").val(data.pendaftaran_id);
                if (data.photopasien === null || data.photopasien === "") { //set photo
                    $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
                } else {
                    $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
                }
                $("#form-datakunjungan > legend > .judul").html('Data Kunjungan ' + data.no_pendaftaran);
                $("#form-datakunjungan > legend > .tombol").attr('style', 'display:true;');
                $("#form-datakunjungan > .box").addClass("well").removeClass("box");

                $("#form-datakunjungan > div").removeClass("animation-loading");
                $("#nama_pasien").focus();
                refreshDialogTarifAmbulans();
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
    function setKunjunganReset() {
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
        $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
        $("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
        $("#form-datakunjungan > legend > .tombol").attr('style', 'display:none;');
        $("#form-datakunjungan > .well").addClass("box").removeClass("well");
    }
    /**
     * refresh dialog kunjungan
     * @returns {undefined}
     */
    function refreshDialogKunjungan() {
//    var instalasi_id = $("#instalasi_id").val();
        var instalasi_id = $("#instalasi_pemakaianambulance").val();
        var instalasi_nama = $("#instalasi_id option:selected").text();
        $.fn.yiiGridView.update('datakunjungan-grid', {
            data: {
                "AMInfokunjunganrjV[instalasi_id]": instalasi_id,
                "AMInfokunjunganrjV[instalasi_nama]": instalasi_nama,
            }
        });
    }
    /**
     * refresh dialog tarif ambulans
     * @returns {undefined}
     */
    function refreshDialogTarifAmbulans() {
        var penjamin_id = $("#penjamin_id").val();
        $.fn.yiiGridView.update('tarifambulans-t-grid', {
            data: {
                "AMTarifambulansM[penjamin_id]": penjamin_id,
            }
        });
    }
    /**
     * menambahkan form obatalkespasien ke tabel
     * copy dari: laboratorium.views.pemakaianBmhp
     * @type Arguments
     */

    function tambahObatAlkesPasien(obj)
    {
        var pendaftaran_id = $('#pendaftaran_id').val();
        var obatalkes_id = $('#obatalkes_id').val();
        var obatalkes_kode = $('#obatalkes_kode').val();
        var obatalkes_nama = $('#pakaiBahan').val();
//    var jumlah = $(obj).parents().find('#qty_input').val(); //RND-11929
        var jumlah = $(obj).parents().find('#jmlkonversi').val();
        if (pendaftaran_id == '') {
            alert('Pilih Pasien Kunjungan terlebih dahulu!');
            return false;
        }
        if (obatalkes_id != '')
        {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('setFormPemakaianBahan'); ?>',
                data: {obatalkes_id: obatalkes_id, jumlah: jumlah, pendaftaran_id: pendaftaran_id},
                dataType: "json",
                success: function (data) {
                    if (data.pesan !== "") {
                        myAlert(data.pesan);
                        var params = [];
                        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi: 'Stok Obat Alkes Habis', isinotifikasi: obatalkes_kode + ' ' + obatalkes_nama + '  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                        simpanNotifikasi(params);
                        return false;
                    }
                    var tambahkandetail = true;
                    var pemakaianbahanyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
                    if (pemakaianbahanyangsama.val()) { //jika ada obat sudah ada di table
                        myConfirm('Apakah Anda akan input ulang obat ini?', 'Perhatian!', function (r)
                        {
                            if (r) {
                                $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function () {
                                    $(this).parents('tr').detach();
                                });
                            } else {
                                tambahkandetail = false;
                            }
                        });
                    }
                    if (tambahkandetail) {
                        $('#table-obatalkespasien > tbody').append(data.form);
                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                        );
                        renameInputRowObatAlkes($("#table-obatalkespasien"));
                    }
                    $(obj).parents('fieldset').find('#obatalkes_id').val('');
                    formatNumberSemua();
                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                    hitungTotal();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            myAlert("Silakan pilih pemakaian bmhp terlebih dahulu!");
        }
        setPemakaianBahanReset();
        $("#obatalkes_nama").focus();
    }

    function renameInputRowObatAlkes(obj_table) {
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
    /**
     * reset form obat
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    function setPemakaianBahanReset() {
        $('#form-tambahobatalkes :input').val("");
        $('#qty_input').val("1");
        $('#obatalkes_nama').focus();
    }
    /**
     * membatalkan form input obat alkes pasien 
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    function batalOaPasien(obj)
    {
        myConfirm("Apakah Anda akan membatalkan obat / alat kesehatan ini?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents('tr').remove();
                renameInputRowObatAlkes($("#table-obatalkespasien"));
            }
        });
    }
    /**
     * membatalkan form input tarif ambulans
     */
    function batalTarif(obj)
    {
        myConfirm("Apakah Anda akan membatalkan tarif ambulans ini?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parents('tr').remove();
            }
        });
    }
    /**
     * menghapus obat alkes pasien yang sudah tersimpan di ObatalkespasienT
     * berdasarkan obatalkespasien_id
     */
    function hapusOaPasien(obatalkespasien_id)
    {
        myConfirm("Apakah Anda akan menghapus obat / alat kesehatan ini?", "Perhatian!", function (r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/laboratorium/pemakaianBmhp/hapusObatAlkesPasien'); ?>',
                    data: {obatalkespasien_id: obatalkespasien_id},
                    dataType: "json",
                    success: function (data) {
                        if (data.sukses) {
                            var delete_row = $("#riwayat-obatalkespasien-t").find('input[name$="[obatalkespasien_id]"][value="' + obatalkespasien_id + '"]').parents('tr');
                            delete_row.detach();
                            renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
                        }
                        myAlert(data.pesan);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
            }
        });
    }
    /**
     * load obatalkespasien_t yang sudah tersimpan berdasarkan:
     * - pasienmasukpenunjang_id
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    function setRiwayatObatAlkesPasien() {
        $('#riwayat-obatalkespasien-t').addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setRiwayatObatAlkesPasien'); ?>',
            data: {pendaftaran_id: $("#<?php echo CHtml::activeId($modPemakaian, 'pendaftaran_id') ?>").val()},
            dataType: "json",
            success: function (data) {
                $('#riwayat-obatalkespasien-t table > tbody').html(data.rows);
                $('#riwayat-obatalkespasien-t table > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                $('#riwayat-obatalkespasien-t').removeClass("animation-loading");
                renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * load pemeriksaan yang sudah tersimpan berdasarkan:
     * - pendaftaran_id
     */
    function setTindakanPelayanan() {
        $('#form-tindakanpemeriksaan').addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetTindakanPelayanan'); ?>',
            data: {pendaftaran_id: $("#<?php echo CHtml::activeId($modPemakaian, 'pendaftaran_id') ?>").val()},
            dataType: "json",
            success: function (data) {
                $('#tblTarifAmbulans tbody').html(data.rows);
                $('#tblTarifAmbulans').removeClass("animation-loading");
                renameInputRow($("#tblTarifAmbulans"));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * javascript yang di running setelah halaman ready / load sempurna
     * posisi script ini harus tetap dibawah
     */

    function inputKendaraan(idAmbulans, noPol, jenis, kode, kmAwal, isiBbm)
    {
        $("#AMPemakaianambulansT_mobilambulans_id").val(idAmbulans);
        $("#AMPemakaianambulansT_mobilambulans_nama").val(noPol);
        $("#AMPemakaianambulansT_nopolisi").val(noPol);
        $("#AMPemakaianambulansT_jeniskendaraan").val(jenis);
        $("#AMPemakaianambulansT_kmawal").val(kmAwal);
        $("#AMPemakaianambulansT_jmlbbmliter").val(isiBbm);
        $("#dialogKendaraan").dialog('close');
        $('.integer').each(function () {
            this.value = formatNumber(this.value)
        });
        $('.number').each(function () {
            this.value = formatNumber(this.value)
        });
    }

    function inputParamedis1(idPegawai, namaPegawai)
    {
        var paramedisKe = 1;
        $("#AMPemakaianambulansT_paramedis" + paramedisKe + "_id").val(idPegawai);
        $("#AMPemakaianambulansT_paramedis" + paramedisKe + "_nama").val(namaPegawai);
        $("#dialogParamedis1").dialog('close');
    }
    function inputParamedis2(idPegawai, namaPegawai)
    {
        var paramedisKe = 2;
        $("#AMPemakaianambulansT_paramedis" + paramedisKe + "_id").val(idPegawai);
        $("#AMPemakaianambulansT_paramedis" + paramedisKe + "_nama").val(namaPegawai);
        $("#dialogParamedis2").dialog('close');
    }
    function inputPelaksana(idPegawai, namaPegawai)
    {
        $("#AMPemakaianambulansT_pelaksana_id").val(idPegawai);
        $("#AMPemakaianambulansT_pelaksana_nama").val(namaPegawai);
        $("#dialogPelaksana").dialog('close');
    }
    function inputDokPendamping(idPegawai, namaPegawai)
    {
        $("#AMPemakaianambulansT_dokterpendampingambulance_id").val(idPegawai);
        $("#AMPemakaianambulansT_pendampingdokter_nama").val(namaPegawai);
        $("#dialogDokPendamping").dialog('close');
    }
    function inputSupir(idSupir, namaSupir)
    {
        $("#AMPemakaianambulansT_supir_id").val(idSupir);
        $("#AMPemakaianambulansT_supir_nama").val(namaSupir);
        $("#dialogSupir").dialog('close');
    }
    function inputTarifAmbulans(jmlKM, tarifKM, tarif, propinsi, kabupaten, kecamatan, kelurahan, daftatindakanId)
    {
        var tambahkantarif = true;
        var jmlTr = $("#tblTarifAmbulans > tbody > tr").length;

        var tr = '<tr><td><input type="text" value="' + propinsi + '" name="tarif[propinsi][]" class="span2"></td>' +
                '<td><input type="text" value="' + kabupaten + '" name="tarif[kabupaten][]" class="span2"></td>' +
                '<td><input type="text" value="' + kecamatan + '" name="tarif[kecamatan][]" class="span2"></td>' +
                '<td><input type="text" value="' + kelurahan + '" name="tarif[kelurahan][]" class="span2"></td>' +
                '<td><input type="text" value="' + jmlKM + '" name="tarif[jmlKM][]" onblur="hitungTarif(this);" class="span1 integer">' +
                '    <input type="hidden" value="' + daftatindakanId + '" name="tarif[daftartindakanId][]" class="span1 integer"></td>' +
                '<td><input type="text" value="' + tarifKM + '" name="tarif[tarifKM][]" onblur="hitungTarif(this);" class="span2 integer2"></td>' +
                '<td><input type="text" value="0" name="tarif[biayatol][]" onblur="hitungTarif(this);" class="span2 integer2"></td>' +
                '<td><input type="text" value="' + tarif + '" name="tarif[tarifAmbulans][]" onblur="hitungTarif(this);" readonly="readonly" class="span2 integer2"></td>' +
                '<td><i class="icon-form-silang" onclick="batalTarif(this);return false;"></i></td>'
        '</tr>';
        if (jmlTr >= 1) {
            myConfirm("Apakah Anda akan input ulang tarif ambulans ini?", "Perhatian!",
                    function (r) {
                        if (r) {
                            $("#tblTarifAmbulans > tbody > tr:first").each(function () {
                                $(this).detach();
                            });
                            if (tambahkantarif) {
                                $("#tblTarifAmbulans > tbody").append(tr);
                                $("#dialogTarif").dialog('close');
                                $("#tblTarifAmbulansAPI").find('input[class*="integer"]').maskMoney(
                                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": "", "thousands": "", "precision": 0}
                                );
                                $("#tblTarifAmbulans > tbody > tr:last .integer").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ",", "thousands": "", "precision": 0, "symbol": null});
                                $("#tblTarifAmbulans > tbody > tr:last .integer2").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 0, "symbol": null});
                                $('.integer2').each(function () {
                                    this.value = formatNumber(this.value);
                                });
                                hitungTotalTarif();
                            }
                        } else {
                            $("#tblTarifAmbulans > tbody > tr:last").each(function () {
                                $(this).detach();
                            });
                            tambahkantarif = false;
                        }
                    });
        } else {
            if (tambahkantarif) {
                $("#tblTarifAmbulans > tbody").append(tr);
                $("#dialogTarif").dialog('close');
                $("#tblTarifAmbulansAPI").find('input[class*="integer"]').maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#tblTarifAmbulans > tbody > tr:last .integer").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ",", "thousands": "", "precision": 0, "symbol": null});
                $("#tblTarifAmbulans > tbody > tr:last .integer2").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 0, "symbol": null});
                $('.integer2').each(function () {
                    this.value = formatNumber(this.value)
                });
                hitungTotalTarif();
            }
        }
        $("#tblTarifAmbulansAPI tbody").empty();
    }

    function refreshTarif() {
        var tipe = $("#<?php echo CHtml::activeId($modPemakaian, "tipekendaraan") ?>").val();
        var jenis = $("#<?php echo CHtml::activeId($modPemakaian, "jeniskendaraan") ?>").val();

        var judul = '';

        if (tipe != '') {
            judul += "Berdasarkan Tipe Kendaraan " + tipe;
        }

        if (jenis != '') {
            if (judul == '') {
                judul += "Berdasarkan Jenis Kendaraan " + jenis;
            } else {
                judul += " dan Jenis Kendaraan " + jenis;
            }
        }

        $("#judul-tarif").html(judul);

        $(".dlg-tipekendaraan").val(tipe);
        $(".dlg-jeniskendaraan").val(jenis);

        $.fn.yiiGridView.update('tarifambulans-t-grid', {
            data: {
                "AMTarifambulansM[tipekendaraan]": tipe,
                "AMTarifambulansM[jeniskendaraan]": jenis,
            }
        });
    }

    function inputTarifAmbulansAPI()
    {
        var tambahkantarif = true;
        var jmlTr = $("#tblTarifAmbulansAPI > tbody > tr").length;

        var jmlKM = $("#km_value").val();
        var jmlKM = (jmlKM / 1000);
//	var alamatTujuan = $("#alamat_value").val();
        var rutetujuan_ambulan = $("#alamat_value").val();
        var ruteasal_ambulan = $("#FromsearchTextField").val();
        var durasipemakaian_ambulan = $("#durasi").val();
        var jenispelayanan_ambulans_id = $("#AMPemakaianambulansT_pelayanan_ambulan").val();
        var jenispelayanan_ambulans = $("#AMPemakaianambulansT_pelayanan_ambulan option:selected").text();
        var jasasarana_ambulans = 0; //$("#jasa_sarana").val();
        var harga_bbm = parseFloat(unformatNumber($("#AMPemakaianambulansT_harga_bbm_hargasatuan").val()));
        var bbm_hari = $("#AMPemakaianambulansT_tarif_hari").val();
        var bhp = $("#bhp").val();
        var jasapengemudi = $("#jasa_pengemudi").val();
        var daftartindakanId = $("#AMPemakaianambulansT_daftartindakanId").val();
        
        var tarif_bbm = bbm_hari * harga_bbm * Math.round(jmlKM);
        if (isNaN(tarif_bbm)) {
            tarif_bbm = 0;
        }
        tarif_bbm = formatNumber(tarif_bbm);
        

        var jasapendamping = 0;
        var jasapendamping_satuan = parseFloat(unformatNumber($("#AMPemakaianambulansT_jasapendamping_hargasatuan").val()));
        var jasapendamping_qty = parseFloat(unformatNumber($("#AMPemakaianambulansT_jasapendamping_qty").val()));
        var jasapendamping_hari = parseFloat(unformatNumber($("#AMPemakaianambulansT_jasapendamping_hari").val()));
        
        jasapendamping = jasapendamping_satuan * jasapendamping_qty * jasapendamping_hari;
        if (isNaN(jasapendamping_hari)) {
            jasapendamping_hari = 0;
        }
        jasapendamping = formatNumber(jasapendamping);
        
        var akomodasipendamping = 0;
        var akomodasipendamping_satuan = parseFloat(unformatNumber($("#AMPemakaianambulansT_akomodasipendamping_hargasatuan").val()));
        var akomodasipendamping_qty = parseFloat(unformatNumber($("#AMPemakaianambulansT_akomodasipendamping_qty").val()));
        var akomodasipendamping_hari = parseFloat(unformatNumber($("#AMPemakaianambulansT_akomodasipendamping_hari").val()));
        
        akomodasipendamping = akomodasipendamping_satuan * akomodasipendamping_qty * akomodasipendamping_hari;
        if (isNaN(akomodasipendamping)) {
            akomodasipendamping = 0;
        }
        akomodasipendamping = formatNumber(akomodasipendamping);
        
        
        
        
        /*
        var isPendamping = $('#AMPemakaianambulansT_isPendamping').attr('checked');
        if (isPendamping) {
            jasapendamping = $("#jasa_pendamping").val();
        }
        */

        
        /*
        var isDokter = $('#AMPemakaianambulansT_isDokter').attr('checked');
        if (isDokter) {
            jasadokter = $("#jasa_dokter").val();
        }
        */
       
       
        

        // tol
        var biaya_tol_satuan = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayatol_hargasatuan").val()));
        var biaya_tol_qty = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayatol_qty").val()));
        var biaya_tol_hari = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayatol_hari").val()));
        var biaya_tol = biaya_tol_satuan * biaya_tol_qty * biaya_tol_hari;
        
        if (isNaN(biaya_tol)) {
            biaya_tol = 0;
        }
        biaya_tol = formatNumber(biaya_tol);
        
        // hotel
        var biayahotel_satuan = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayahotel_hargasatuan").val()));
        var biayahotel_qty = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayahotel_qty").val()));
        var biayahotel_hari = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayahotel_hari").val()));
        var biayahotel = biayahotel_satuan * biayahotel_qty * biayahotel_hari;
        
        if (isNaN(biayahotel)) {
            biayahotel = 0;
        }
        biayahotel = formatNumber(biayahotel);
        
        // tiket
        var biayatiket_satuan = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayatiket_hargasatuan").val()));
        var biayatiket_qty = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayatiket_qty").val()));
        var biayatiket_hari = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayatiket_hari").val()));
        var biayatiket = biayatiket_satuan * biayatiket_qty * biayatiket_hari;
        
        if (isNaN(biayatiket)) {
            biayatiket = 0;
        }
        biayatiket = formatNumber(biayatiket);
        
        
        // uang harian dokter
        var jasadokter_satuan = parseFloat(unformatNumber($("#AMPemakaianambulansT_jasadokter_hargasatuan").val()));
        var jasadokter_qty = parseFloat(unformatNumber($("#AMPemakaianambulansT_jasadokter_qty").val()));
        var jasadokter_hari = parseFloat(unformatNumber($("#AMPemakaianambulansT_jasadokter_hari").val()));
        var jasadokter = jasadokter_satuan * jasadokter_qty * jasadokter_hari;
        
        if (isNaN(jasadokter)) {
            jasadokter = 0;
        }
        jasadokter = formatNumber(jasadokter);
        
        // uang makan dokter
        var uangmakandokter_satuan = parseFloat(unformatNumber($("#AMPemakaianambulansT_uangmakandokter_hargasatuan").val()));
        var uangmakandokter_qty = parseFloat(unformatNumber($("#AMPemakaianambulansT_uangmakandokter_qty").val()));
        var uangmakandokter_hari = parseFloat(unformatNumber($("#AMPemakaianambulansT_uangmakandokter_hari").val()));
        var uangmakandokter = uangmakandokter_satuan * uangmakandokter_qty * uangmakandokter_hari;
        
        if (isNaN(uangmakandokter)) {
            uangmakandokter = 0;
        }
        uangmakandokter = formatNumber(uangmakandokter);
        
        // hotel dokter
        var biayahoteldokter_satuan = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayahoteldokter_hargasatuan").val()));
        var biayahoteldokter_qty = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayahoteldokter_qty").val()));
        var biayahoteldokter_hari = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayahoteldokter_hari").val()));
        var biayahoteldokter = biayahoteldokter_satuan * biayahoteldokter_qty * biayahoteldokter_hari;
        
        if (isNaN(biayahoteldokter)) {
            biayahoteldokter = 0;
        }
        biayahoteldokter = formatNumber(biayahoteldokter);
        
        // tiket dokter
        var biayatiketdokter_satuan = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayatiketdokter_hargasatuan").val()));
        var biayatiketdokter_qty = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayatiketdokter_qty").val()));
        var biayatiketdokter_hari = parseFloat(unformatNumber($("#AMPemakaianambulansT_biayatiketdokter_hari").val()));
        var biayatiketdokter = biayatiketdokter_satuan * biayatiketdokter_qty * biayatiketdokter_hari;
        
        if (isNaN(biayatiketdokter)) {
            biayatiketdokter = 0;
        }
        biayatiketdokter = formatNumber(biayatiketdokter);
        
        
        var total_tarif = $(".total_tarif").val();

        var tr = '<tr><td><input type="text" value="' + rutetujuan_ambulan + '" name="tarif[rutetujuan_ambulan][]" class="span3" readonly="readonly"></td>' +
                '<td><input type="text" value="' + jmlKM + '" name="tarif[jmlKM][]" class="span1" readonly="readonly"></td>' +
                '<td><input type="text" value="' + durasipemakaian_ambulan + '" name="tarif[durasipemakaian_ambulan][]" class="span2x" readonly="readonly"></td>' +
                //'<td><input type="text" value="' + tarif_bbm + '" name="tarif[tarif_bbm][]" class="span2x integer2" readonly="readonly"></td>' +
                
                '<td><input type="text" value="' + tarif_bbm + '" name="tarif[tarif_bbm][]" class="span2x integer2" readonly="readonly">' +
                '<input type="hidden" value="' + harga_bbm + '" name="tarif[harga_bbm][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + bbm_hari + '" name="tarif[hari_bbm][]" class="span2x" readonly="readonly"></td>' +
                
                '<td><input type="text" value="' + jasapendamping + '" name="tarif[jasapendamping][]" class="span2x integer2" readonly="readonly">' +
                '<input type="hidden" value="' + jasapendamping_satuan + '" name="tarif[jasapendamping_satuan][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + jasapendamping_qty + '" name="tarif[jasapendamping_qty][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + jasapendamping_hari + '" name="tarif[jasapendamping_hari][]" class="span2x" readonly="readonly"></td>' +
                
                '<td><input type="text" value="' + akomodasipendamping + '" name="tarif[akomodasipendamping][]" class="span2x integer2" readonly="readonly">' +
                '<input type="hidden" value="' + akomodasipendamping_satuan + '" name="tarif[akomodasipendamping_satuan][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + akomodasipendamping_qty + '" name="tarif[akomodasipendamping_qty][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + akomodasipendamping_hari + '" name="tarif[akomodasipendamping_hari][]" class="span2x" readonly="readonly"></td>' +
                
                '<td><input type="text" value="' + biaya_tol + '" name="tarif[biayatol][]" class="span2x integer2" readonly="readonly">' +
                '<input type="hidden" value="' + biaya_tol_satuan + '" name="tarif[biaya_tol_satuan][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + biaya_tol_qty + '" name="tarif[biaya_tol_qty][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + biaya_tol_hari + '" name="tarif[biaya_tol_hari][]" class="span2x" readonly="readonly"></td>' +
                
                '<td><input type="text" value="' + biayahotel + '" name="tarif[biayahotel][]" class="span2x integer2" readonly="readonly">' +
                '<input type="hidden" value="' + biayahotel_satuan + '" name="tarif[biayahotel_satuan][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + biayahotel_qty + '" name="tarif[biayahotel_qty][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + biayahotel_hari + '" name="tarif[biayahotel_hari][]" class="span2x" readonly="readonly"></td>' +
                
                '<td><input type="text" value="' + biayatiket + '" name="tarif[biayatiket][]" class="span2x integer2" readonly="readonly">' +
                '<input type="hidden" value="' + biayatiket_satuan + '" name="tarif[biayatiket_satuan][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + biayatiket_qty + '" name="tarif[biayatiket_qty][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + biayatiket_hari + '" name="tarif[biayatiket_hari][]" class="span2x" readonly="readonly"></td>' +
                
                '<td><input type="text" value="' + jasadokter + '" name="tarif[jasadokter][]" class="span2x integer2" readonly="readonly">' +
                '<input type="hidden" value="' + jasadokter_satuan + '" name="tarif[jasadokter_satuan][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + jasadokter_qty + '" name="tarif[jasadokter_qty][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + jasadokter_hari + '" name="tarif[jasadokter_hari][]" class="span2x" readonly="readonly"></td>' +
                
                '<td><input type="text" value="' + uangmakandokter + '" name="tarif[uangmakandokter][]" class="span2x integer2" readonly="readonly">' +
                '<input type="hidden" value="' + uangmakandokter_satuan + '" name="tarif[uangmakandokter_satuan][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + uangmakandokter_qty + '" name="tarif[uangmakandokter_qty][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + uangmakandokter_hari + '" name="tarif[uangmakandokter_hari][]" class="span2x" readonly="readonly"></td>' +
                
                '<td><input type="text" value="' + biayahoteldokter + '" name="tarif[biayahoteldokter][]" class="span2x integer2" readonly="readonly">' +
                '<input type="hidden" value="' + biayahoteldokter_satuan + '" name="tarif[biayahoteldokter_satuan][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + biayahoteldokter_qty + '" name="tarif[biayahoteldokter_qty][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + biayahoteldokter_hari + '" name="tarif[biayahoteldokter_hari][]" class="span2x" readonly="readonly"></td>' +
                
                '<td><input type="text" value="' + biayatiketdokter + '" name="tarif[biayatiketdokter][]" class="span2x integer2" readonly="readonly">' +
                '<input type="hidden" value="' + biayatiketdokter_satuan + '" name="tarif[biayatiketdokter_satuan][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + biayatiketdokter_qty + '" name="tarif[biayatiketdokter_qty][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + biayatiketdokter_hari + '" name="tarif[biayatiketdokter_hari][]" class="span2x" readonly="readonly"></td>' +
                
                '<td hidden><input type="text" value="' + jenispelayanan_ambulans + '" name="tarif[jenispelayanan_ambulans][]" class="span2" readonly="readonly">' +
                '<input type="hidden" value="' + jenispelayanan_ambulans_id + '" name="tarif[jenispelayanan_ambulans_id][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + ruteasal_ambulan + '" name="tarif[ruteasal_ambulan][]" class="span2x" readonly="readonly">' +
                '<input type="hidden" value="' + daftartindakanId + '" name="tarif[daftartindakanId][]" class="span2x" readonly="readonly"></td>' +
                
                '<td hidden><input type="text" value="' + jasasarana_ambulans + '" name="tarif[jasasarana_ambulans][]" class="span2x integer2" readonly="readonly"></td>' +
                '<td hidden><input type="text" value="' + bhp + '" name="tarif[bhp][]" class="span2x integer2" readonly="readonly"></td>' +
                '<td hidden><input type="text" value="' + jasapengemudi + '" name="tarif[jasapengemudi][]" class="span2x integer2" readonly="readonly"></td>' +
                //'<td><input type="text" value="' + jasadokter + '" name="tarif[jasadokter][]" class="span2x integer2" readonly="readonly"></td>' +
                '<td><input type="text" value="' + total_tarif + '" name="tarif[tarifAmbulans][]" class="span2x integer2" readonly="readonly"></td>' +
//            '<td><input type="text" value="" name="tarif[tarifKM][]" onblur="hitungTarifAPI(this);" class="span1 integer"></td>'+
//				'<td><input type="text" value="" name="tarif[tarifAmbulans][]" onblur="hitungTarifAPI(this);" class="span2 integer"></td>'+
                '<td><i class="icon-form-silang" onclick="batalTarif(this);return false;"></i></td>'
        '</tr>';
        
        $("#input_tarif :input").not(".cb_akomodasi").val(0);
        
        
        if (jmlTr >= 1) {
            myConfirm("Apakah Anda akan input ulang tarif ambulans ini?", "Perhatian!",
                    function (r) {
                        if (r) {
                            $("#tblTarifAmbulansAPI > tbody > tr:first").each(function () {
                                $(this).detach();
                            });
                            if (tambahkantarif) {
                                $("#tblTarifAmbulansAPI > tbody").append(tr);
                                $("#tblTarifAmbulansAPI").find('input[class*="integer"]').maskMoney(
                                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                                );
                                $("#tblTarifAmbulansAPI > tbody > tr:last .number").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 0, "symbol": null});
                                $('.number').each(function () {
                                    this.value = formatNumber(this.value)
                                });
                                hitungTotalTarifAPI();
                            }
                        } else {
                            $("#tblTarifAmbulansAPI > tbody > tr:last").each(function () {
                                $(this).detach();
                            });
                            tambahkantarif = false;
                        }
                    });
        } else {
            if (tambahkantarif) {
                $("#tblTarifAmbulansAPI > tbody").append(tr);
                $("#tblTarifAmbulansAPI").find('input[class*="integer"]').maskMoney(
                        {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
                );
                $("#tblTarifAmbulansAPI > tbody > tr:last .number").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 0, "symbol": null});
                $('.number').each(function () {
                    this.value = formatNumber(this.value)
                });
                hitungTotalTarifAPI();
                clearTarifAmbulans();
            }
        }

        $("#tblTarifAmbulans tbody").empty();
    }

    function hitungTol(obj) {
        unformatNumberSemua();
        var biaya = parseFloat(obj);
        var totalawal = parseFloat($('#total_tarif').val());
        var totalakhir = totalawal + biaya;
        $('#total_tarif').val(totalakhir);
        formatNumberSemua();
    }

    function hitungTarif(obj)
    {
        unformatNumberSemua();
        var km = $(obj).parent().parent().find('input[name$="[jmlKM][]"]');
        var tarifkm = $(obj).parent().parent().find('input[name$="[tarifKM][]"]');
        var biayatol = $(obj).parent().parent().find('input[name$="[biayatol][]"]');
        var tarif = $(obj).parent().parent().find('input[name$="[tarifAmbulans][]"]');

        tarif.val(formatNumber(unformatNumber(km.val()) * unformatNumber(tarifkm.val()) + unformatNumber(biayatol.val())));
        formatNumberSemua();
    }

    function hitungTotalTarif(obj)
    {
        unformatNumberSemua();
        totaltarif = 0;
        $('#tblTarifAmbulans > tbody > tr').each(function () {
            totaltarif = parseFloat($(this).find('input[name*="[jmlKM]"]').val() * $(this).find('input[name*="[tarifKM]"]').val());
            $(this).find('input[name*="[tarifAmbulans]"]').val(totaltarif);
        });

        formatNumberSemua();
    }

    function hitungTarifAPI(obj)
    {
        unformatNumberSemua();
        var km = $(obj).parent().parent().find('input[name$="[jmlKM][]"]');
        var tarifkm = $(obj).parent().parent().find('input[name$="[tarifKM][]"]');
        var tarif = $(obj).parent().parent().find('input[name$="[tarifAmbulans][]"]');

        tarif.val(formatNumber(unformatNumber(km.val()) * unformatNumber(tarifkm.val())));
        formatNumberSemua();
    }

    function hitungTotalTarifAPI(obj)
    {
        unformatNumberSemua();
        totaltarif = 0;
        $('#tblTarifAmbulans > tbody > tr').each(function () {
            totaltarif = parseFloat($(this).find('input[name*="[jmlKM]"]').val() * $(this).find('input[name*="[tarifKM]"]').val());
            $(this).find('input[name*="[tarifAmbulans]"]').val(totaltarif);
        });

        formatNumberSemua();
    }

    /**
     * class integer di unformat 
     * @returns {undefined}
     */
    function unformatNumberSemua() {
        $(".integer").each(function () {
            $(this).val(parseInt(unformatNumber($(this).val())));
        });
        $(".float").each(function () {
            $(this).val(parseFloat(unformatNumber($(this).val())));
        });
    }
    /**
     * class integer di format kembali
     * @returns {undefined}
     */
    function formatNumberSemua() {
        $(".integer").each(function () {
            $(this).val(formatInteger($(this).val()));
        });
        $(".float").each(function () {
            $(this).val(formatFloat($(this).val()));
        });
    }

    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    /**
     * rename input row yang terakhir di tambahkan
     * @param {type} obj_table
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span[name*="[ii]"]').each(function () { //element <span>
                var new_name = $(this).attr("name").replace("ii", (row));
                $(this).attr("name", new_name);
            });
            $(this).find('span[name$="[tindakan_nama]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 2) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[1] + "]");
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
    function renameInput(modelName, attributeName)
    {
        var i = -1;
        $('#tblInputPemakaianBahan tr').each(function () {
            if ($(this).has('input[name$="[obatalkes_id]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function removeObat(obj)
    {
        myConfirm("Apakah Anda akan menghapus obat?", "Perhatian!", function (r) {
            if (r) {
                $(obj).parent().parent().remove();
            }
        });
        hitungTotal();
    }

    function hitungSubTotal(obj)
    {
        var qty = obj.value;
        var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargajual]"]').val());
        var subtotal = qty * harga;
        $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[qty]"]').val(formatNumber(subtotal));
        hitungTotal();
    }

    function hitungTotal()
    {
        var total = 0;
        $('#tblInputPemakaianBahan').find('input[name$="[qty]"]').each(function () {
            total = total + unformatNumber(this.value);
        });
        $('#totPemakaianBahan').val(formatNumber(total));
    }
    function validasi() {
        var idObat = $('#idObat').val();
        var jumlahObat = $('#qty').val();
        if (idObat == '') {

            myAlert('Obat Belum Diisi');
        } else if (jumlahObat == '') {
            myAlert('jumlah Obat Belum Diisi')
        } else if (jumlahObat < 1) {
            myAlert('jumlah Obat Tidak Sesuai')
        } else {
            inputPemakaianBahan(idObat);
        }

    }

    function cekInput()
    {
        $('.integer').each(function () {
            this.value = unformatNumber(this.value)
        });
        $('.number').each(function () {
            this.value = unformatNumber(this.value)
        });
        return true;
    }
    function clearDataPasien()
    {

        $("#<?php echo CHtml::activeId($modPemakaian, 'noidentitas') ?>").val('');
    }
    /**
     * print status 
     */
    function printStatus()
    {
        var pemakaianambulans_id = '<?php echo isset($_GET['pemakaian_id']) ? $_GET['pemakaian_id'] : null; ?>';
        if (pemakaianambulans_id != "") {
            window.open('<?php echo $this->createUrl('printStatusAmbulans'); ?>&pemakaianambulans_id=' + pemakaianambulans_id, 'printwin', 'left=100,top=100,width=480,height=640');
        } else {
            myAlert("Silakan pilih data rujukan pasien!");
        }
    }

// untuk menjumlahkan konversi dari qty input / jmlkemasan terkecil
    function totalKonversi() {
        var qty_input = parseFloat($('#qty_input').val());
        var jmlkemasan = parseFloat($('#jmlkemasan').val());
        var jmlkonversi = parseFloat($('#jmlkonversi').val());

        var jml = qty_input / jmlkemasan;
        if (!jQuery.isNumeric(jml)) {
            jml = 0;
        }
        $('#jmlkonversi').val(jml);
    }

    function totalJumlah() {
        var qty_input = parseFloat($('#qty_input').val());
        var jmlkemasan = parseFloat($('#jmlkemasan').val());
        var jmlkonversi = parseFloat($('#jmlkonversi').val());

        var jumlah = jmlkonversi * jmlkemasan;
        if (!jQuery.isNumeric(jumlah)) {
            jumlah = 0;
        }
        $('#qty_input').val(jumlah);
    }

    function setSatuanObat(obatalkes_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setSatuanObat'); ?>',
            data: {obatalkes_id: obatalkes_id},
            dataType: "json",
            success: function (data) {
                if (data.pesan != "") {
                    myAlert(data.pesan);
                } else {
                    $('#satuankecil_nama').html(data.satuankecil);
                    $('#satuanterkecil_nama').html(data.satuanterkecil);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                myAlert("Data Obat tidak ditemukan!");
                console.log(errorThrown);
            }
        });
    }

    function setTarifAmbulans() {
        var komponenunit_id = $('#AMPemakaianambulansT_pelayanan_ambulan').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setTarifAmbulans'); ?>',
            data: {komponenunit_id: komponenunit_id},
            dataType: "json",
            success: function (data) {
                if (data.pesan != "") {
                    myAlert(data.pesan);
                } else {
                    $('#jasa_sarana').val(formatNumber(data.modKonfigTarifAmbulas['tarifjasasarana']));
                    $('#harga_bbm, #AMPemakaianambulansT_harga_bbm_hargasatuan').val(formatNumber(data.harga_bbm));
                    $('#AMPemakaianambulansT_daftartindakanId').val(data.daftartindakan_id);
                    $("#AMPemakaianambulansT_jasapendamping_hargasatuan").val(formatNumber(data.modKonfigTarifAmbulas['jasaparamedis']));
                    $("#AMPemakaianambulansT_akomodasipendamping_hargasatuan").val(formatNumber(data.modKonfigTarifAmbulas['akomodasimedis']));
                    $("#AMPemakaianambulansT_jasadokter_hargasatuan").val(formatNumber(data.modKonfigTarifAmbulas['uanghariandokter']));
                    $("#AMPemakaianambulansT_uangmakandokter_hargasatuan").val(formatNumber(data.modKonfigTarifAmbulas['uangmakandokter']));
                    
                    hitungTotalTarifMap();
                    hitungTotalTarifAmbulan();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                myAlert("Setting Konfig tarif ambulans!");
                console.log(errorThrown);
            }
        });
    }

    function hitungBHP(harga_bbm) {
        var km_value = $('#km_value').val();
        if (km_value == '') {
            km_value = 0;
        }
        var jarak = Math.round(km_value / 1000);
        var totalBhp = 0;
        totalBhp = (2 * jarak) * 0.4 * harga_bbm;

        $('#bhp').val(formatNumber(totalBhp));
    }
    function hitungJasaPengemudi(jasapengemudi_prosentase) {
        /*
         var jasa = unformatNumber($('#jasa_sarana').val());
         var bhp = unformatNumber($('#bhp').val());
         
         var total = (eval(jasapengemudi_prosentase) * (eval(jasa) + eval(bhp))) / 100 ; // 20 * (100.000 + 0) / 100
         */

        $('#jasa_pengemudi').val(0);
    }
    function hitungJasaPendamping(jasapendamping_prosentase) {
        var jasa = unformatNumber($('#jasa_sarana').val());
        var bhp = unformatNumber($('#bhp').val());
        var total = (eval(jasapendamping_prosentase) * (eval(jasa) + eval(bhp))) / 100;

        $('#jasa_pendamping').val(formatNumber(total));
    }
    function hitungJasaDokter(jasadokter_persentase) {
        var jasa = unformatNumber($('#jasa_sarana').val());
        var bhp = unformatNumber($('#bhp').val());
        var total = (eval(jasadokter_persentase) * (eval(jasa) + eval(bhp))) / 100;

        $('#jasa_dokter').val(formatNumber(total));
    }

    function cekPendamping() {
        var checklist = $('#AMPemakaianambulansT_isPendamping');
        var pilih = checklist.attr('checked');
        if (pilih) {
            $("#jasa_pendamping").attr("readonly", false);
        } else {
            $("#jasa_pendamping").attr("readonly", true);
        }
        hitungTotalTarifAmbulan();
    }

    function cekDokter() {
        var checklist = $('#AMPemakaianambulansT_isDokter');
        var pilih = checklist.attr('checked');
        if (pilih) {
            $("#jasa_dokter").attr("readonly", false);
        } else {
            $("#jasa_dokter").attr("readonly", true);
        }
        hitungTotalTarifAmbulan();
    }

    function hitungTotalTarifAmbulan() {
        var isDokter = $('#AMPemakaianambulansT_isDokter').attr('checked');
        var isPendamping = $('#AMPemakaianambulansT_isPendamping').attr('checked');

        var jasa_sarana = parseFloat(unformatNumber($('#jasa_sarana').val()));
        var bhp = parseFloat(unformatNumber($('#bhp').val()));
        var jasa_pengemudi = parseFloat(unformatNumber($('#jasa_pengemudi').val()));
        var jasa_pendamping = parseFloat(unformatNumber($('#jasa_pendamping').val()));
        var jasa_dokter = parseFloat(unformatNumber($('#jasa_dokter').val()));

        var biaya_tol = parseFloat(unformatNumber($('#biaya_tol').val()));

        var total;
        if (isDokter && isPendamping) {
            total = eval(jasa_sarana) + eval(bhp) + eval(jasa_pengemudi) + eval(jasa_pendamping) + eval(jasa_dokter);
        } else if (isDokter && !(isPendamping)) {
            total = eval(jasa_sarana) + eval(bhp) + eval(jasa_pengemudi) + eval(jasa_dokter);
        } else if (!(isDokter) && isPendamping) {
            total = eval(jasa_sarana) + eval(bhp) + eval(jasa_pengemudi) + eval(jasa_pendamping);
        } else {
            total = eval(jasa_sarana) + eval(bhp) + eval(jasa_pengemudi);
        }

        total += biaya_tol;

        $('#total_tarif').val(formatNumber(total));

    }

    function clearTarifAmbulans() {
//    $("#AMPemakaianambulansT_pelayanan_ambulan option:selected").text("-- Pilih --");
        $("#AMPemakaianambulansT_pelayanan_ambulan").val("");
        $("#jasa_sarana").val("");
        $("#harga_bbm").val("");
        $("#bhp").val("");
        $("#jasa_pengemudi").val("");
        $("#jasa_pendamping").val("");
        $("#jasa_dokter").val("");
        $("#total_tarif").val("");
        $("#biaya_tol").val("");
    }

    function ceklisInputAkomodasiMap() {
        $(".panel_akomodasi").each(function () {
            console.log("Ceklis", $(this).find(".cb_akomodasi").is(":checked"));
            if ($(this).find(".cb_akomodasi").is(":checked")) {
                $(this).find(":input").not(".cb_akomodasi").prop("disabled", false);
            } else {
                $(this).find(":input").not(".cb_akomodasi").val(0).prop("disabled", true);
            }
        });
        hitungTotalTarifMap();
    }
    
    function hitungTotalTarifMap() {
        var total_tarif = 0;
        $("#input_tarif .tarif_harga:not(:disabled)").each(function() {
            var harga = parseFloat(unformatNumber($(this).val()));
            var qty = parseFloat(unformatNumber($(this).parents(".controls").find(".tarif_qty").val()));
            var hari = parseFloat(unformatNumber($(this).parents(".controls").find(".tarif_hari").val()));
            
            if (isNaN(harga)) {
                harga = 0;
            }
            if (isNaN(hari)) {
                hari = 0;
            }
            if (isNaN(qty)) {
                qty = 0;
            }
            
            total_tarif += harga * hari * qty;
        });
        
        $(".total_tarif").val(formatNumber(total_tarif));
    }

    /**
     * print pemakaian bahan
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    function printPemakaianOa(pemakaian_id)
    {
        window.open('<?php echo $this->createUrl('printPemakaianBmhp'); ?>&pemakaian_id=' + pemakaian_id, 'printwin', 'left=100,top=100,width=480,height=640');
    }
    /**
     * javascript yang di running setelah halaman ready / load sempurna
     * posisi script ini harus tetap dibawah
     */
    $(document).ready(function () {
        $("#btn_submit").click(function () {
            unformatNumberSemua();
        });

<?php if ((!$modPemakaian->isNewRecord)) { ?>
            setTindakanPelayanan();
            setRiwayatObatAlkesPasien();
            $("input, select, textarea").attr("readonly", true);
<?php } ?>
<?php if (isset($_GET['pendaftaran_id']) && (!empty($_GET['pendaftaran_id'])) && $this->id != "pemakaianAmbulanPasienLuar") { ?>
            setKunjungan(<?php echo $_GET['pendaftaran_id']; ?>, '', '', '');
<?php } ?>

        // Notifikasi Pasien
<?php
if (isset($_GET['smspasien'])) {
    if ($_GET['smspasien'] == 0) {
        ?>
                var params = [];
                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'GAGAL KIRIM SMS PASIEN', isinotifikasi: 'Pasien <?php echo $modPemakaian->namapasien; ?> tidak memiliki nomor mobile'}; // 16 
                simpanNotifikasi(params);
        <?php
    }
}
?>
        $(".cb_akomodasi").on("click", ceklisInputAkomodasiMap);
        $("#input_tarif :input").on("change", hitungTotalTarifMap);
        ceklisInputAkomodasiMap();
        
        
        cekDisabled($('#pemakaianambulans-t-form'));
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', '.ui-dialog-content', function () {
            cekDisabled('form');
        });
        
        $("#form-riwayatpasien .accordion-toggle").on("click", function() {
            setTimeout(ceklisInputAkomodasiMap, 500);
        });
    });
</script>