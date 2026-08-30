<script type="text/javascript">
    function cekForm() {
        var jumlahtr = $('#form-tindakanpemeriksaan').find('table tbody > tr').length;

        console.log(jumlahtr);
        if(jumlahtr < 1) {
            myAlert('Silahkan Pilih Rencana Operasi');
            return false;
        }
        if (requiredCheck($("#rencanaoperasi-form"))) {
            $('#BSTarifoperasiruanganV_operasi_nama').val('----------');
            updateChecklistPemeriksaanBedah();

            $('.form-actions').addClass('animation-loading');

            setTimeout(() => {
                $('#rencanaoperasi-form').submit();
            }, 1700);
        }
        return false;
    }
    /**
     * set form kunjungan
     * @param {type} pasien_id
     * @returns {undefined}
     */
    function setKunjungan(pasienkirimkeunitlain_id) {
        $("#form-datakunjungan > div").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDataKunjungan'); ?>',
            data: {
                pasienkirimkeunitlain_id: pasienkirimkeunitlain_id
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id') ?>").val(data.pasienkirimkeunitlain_id);
                $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'jeniskasuspenyakit_id') ?>").val(data.jeniskasuspenyakit_id);
                $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'kelaspelayanan_id') ?>").val(data.kelaspelayanan_id);
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasien_id").val(data.pasien_id);
                $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                $("#carabayar_id").val(data.carabayar_id);
                $("#penjamin_id").val(data.penjamin_id);
                $("#penanggungjawab_id").val(data.penanggungjawab_id);
                $("#instalasiasal_id").val(data.instalasiasal_id);
                $("#ruanganasal_id").val(data.ruanganasal_id);
                $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#tglmasukpenunjang").val(data.tglmasukpenunjang);
                $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
                $("#instalasiasal_nama").val(data.instalasiasal_nama);
                $("#ruanganasal_nama").val(data.ruanganasal_nama);
                $("#nama_pegawai").val(data.namalengkapdokter);
                $("#catatandokterpengirim").val(data.catatandokterpengirim);
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
                if (data.photopasien === null || data.photopasien === "") { //set photo
                    $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
                } else {
                    $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
                }

                setPermintaanKePenunjang();
                setTimeout(function() {
                    setCheckedPemeriksaanDariPermintaan();
                }, 3000); //auto check permintaan
                $("#form-datakunjungan > legend > .judul").html('Data Rujukan ' + data.no_pendaftaran);
                $("#form-datakunjungan > legend > .tombol").attr('style', 'display:true;');
                $("#form-datakunjungan > .box").addClass("well").removeClass("box");

                $("#form-datakunjungan > div").removeClass("animation-loading");
                $("#no_pendaftaran").focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert("Data rujukan tidak ditemukan!");
                console.log(errorThrown);
                setKunjunganReset();
                $("#form-datakunjungan > div").removeClass("animation-loading");
                $("#no_pendaftaran").focus();
            }
        });

    }
    /**
     * untuk mereset form kunjungan
     * @returns {undefined} */
    function setKunjunganReset() {
        $("#form-datakunjungan input,textarea").each(function() {
            $(this).val("");
        });
        $("#ruangan_id").val(<?php echo $modKunjungan->ruangan_id; ?>);
        $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
        $("#form-datakunjungan > legend > .judul").html('Data Rujukan');
        $("#form-datakunjungan > legend > .tombol").attr('style', 'display:none;');
        $("#form-datakunjungan > .well").addClass("box").removeClass("well");

        $('#form-permintaankepenunjang table > tbody').html("");
        $('#form-tindakanpemeriksaan table > tbody').html("");
        $('#content-pemeriksaan-bedah .checklists').html("");
        $('#content-pemeriksaan-bedah input').each(function() {
            $(this).val("");
        });
    }
    /**
     * hitung tarif tindakan RND-4169
     */
    function hitungTotal(obj) {
        unformatNumberSemua();
        var qty = $(obj).val();
        var harga = parseFloat($(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val());
        var subTotal = 0;

        subTotal = parseFloat(harga * qty);
        if ($.isNumeric(subTotal)) {
            $(obj).parents('tr').find('input[name$="[tarif_tindakan]"]').val(subTotal);
        }

        formatNumberSemua();
    }

    /**
     * update (refresh) checklist pemeriksaan bedah
     * harus include /js/jquery.tiler.js
     * @param {obj} form_checklist
     */
    function updateChecklistPemeriksaanBedah() {
        var sukses = '<?= isset($_GET['sukses']) ? 1 : 0; ?>';
        $('#content-pemeriksaan-bedah .checklists').addClass("animation-loading");

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetChecklistPemeriksaanBedah'); ?>',
            data: {
                data: $("#form-caripemeriksaan :input").serialize(),
                sukses: sukses
            },
            dataType: "json",
            success: function(data) {
                $('#content-pemeriksaan-bedah .checklists').html(data.content);
                $('.checkboxlist-tile').tile({
                    widths: [256]
                });
                $('#content-pemeriksaan-bedah .checklists').removeClass("animation-loading");
                setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Set checklist pemeriksaan bedah
     */
    function setChecklistPemeriksaanBedah() {
        var penjamin_id = $("#penjamin_id").val();
        var ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'ruangan_id') ?>").val();
        var kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'kelaspelayanan_id') ?>").val();
        if (penjamin_id == "" && kelaspelayanan_id == "") {
            myAlert("Silakan pilih data rujukan!");
            setChecklistPemeriksaanBedahReset();
        } else {
            $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
            $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
            $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
            updateChecklistPemeriksaanBedah();
        }
    }
    /**
     * reset pencarian & checklist pemeriksaan bedah
     */
    function setChecklistPemeriksaanBedahReset() {
        $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function() {
            $(this).val("");
        });
        updateChecklistPemeriksaanBedah();
    }
    /**
     * Centang pemeriksaan bedah dari checkboxlist
     */
    function pilihPemeriksaanIni(obj) {
        var operasi_id = $(obj).val();
        var operasi_nama = $(obj).parent().find('input[name$="[operasi_nama]"]').val();
        var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
        var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
        var hargaoperasi = $(obj).parent().find('input[name$="[hargaoperasi]"]').val();
        var persencyto_tind = $(obj).parent().find('input[name$="[persencyto_tind]"]').val();
        setRencanaTindakanOperasi
        var rowtindakan = [];
        rowtindakan = '<?php echo CJSON::encode($this->renderPartial('_rowTindakanPemeriksaan', array('i' => 0, 'modRencanaOperasi' => new BSRencanaOperasiT()), true)); ?>';
        if ($(obj).is(':checked')) {
            $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][operasi_id]"]').val(operasi_id);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
            $("#form-tindakanpemeriksaan").find('span[name$="[ii][operasi_nama]"]').html(operasi_nama);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(formatInteger(hargaoperasi));
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][qty_tindakan]"]').val(1);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(hargaoperasi));
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][persencyto_tind]"]').val(persencyto_tind);
            $("#form-tindakanpemeriksaan").find('a').tooltip({
                "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
            });
        } else {
            var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[operasi_id]"][value="' + operasi_id + '"]').parents('tr');
            delete_row.detach();
        }
        renameInputRow($("#form-tindakanpemeriksaan"));
    }
    /**
     * rename input row yang terakhir di tambahkan
     * @param {type} obj_table
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span[name*="[ii]"]').each(function() { //element <span>
                var new_name = $(this).attr("name").replace("ii", (row));
                $(this).attr("name", new_name);
            });
            $(this).find('span[name$="[operasi_nama]"]').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 2) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[1] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                console.log(old_name, old_name_arr, old_name_arr.length);
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });
            row++;
        });

    }
    /**
     * set checked pemeriksaan yang sudah ada di daftar
     */
    function setCheckedPemeriksaan(obj_table) {
        $("div.checklists").find('input[name$="[is_pilih]"]').removeAttr('checked');
        $(obj_table).find('input[name$="[operasi_id]"]').each(function() {
            var operasi_id = $(this).val();
            $("div.checklists").find('input[name$="[is_pilih]"][value=' + operasi_id + ']').prop('checked', true);
        });

    }
    /**
     * set otomatis pilih pemeriksaan dari tabel permintaan ke penunjang 
     */
    function setCheckedPemeriksaanDariPermintaan() {
        $('#form-tindakanpemeriksaan table > tbody').html("");
        setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        $("#form-permintaankepenunjang").find('input[name$="[operasi_id]"]').each(function() {
            var operasi_id = $(this).val();
            var checkbox_pemeriksaan = $("div.checklists").find('input[name$="[is_pilih]"][value=' + operasi_id + ']');
            checkbox_pemeriksaan.prop('checked', true);
            pilihPemeriksaanIni(checkbox_pemeriksaan);
        });
    }

    function setCheckedTindakanOperasi() {
        $('#form-tindakanpemeriksaan table > tbody').html("");
        setCheckedPemeriksaan($("#form-tindakanpemeriksaan"));
        $("#form-permintaankepenunjang").find('input[name$="[operasi_id]"]').each(function() {
            var operasi_id = $(this).val();
            var checkbox_pemeriksaan = $("div.checklists").find('input[name$="[is_pilih]"][value=' + operasi_id + ']');
            checkbox_pemeriksaan.attr('checked', true);
            pilihPemeriksaanIni(checkbox_pemeriksaan);
        });
    }
    /**
     * bersihkan tabel tindakan pemeriksaan jika ada perubahan kelaspelayanan, ruangan 
     **/
    function setTindakanPemeriksaanReset() {
        $("#form-tindakanpemeriksaan table > tbody").html("");
        setTimeout(function() {
            setCheckedPemeriksaanDariPermintaan();
        }, 3000); //auto check permintaan
    }
    /**
     * load permintaan ke penunjang:
     * - pasienkirimkeunitlain_id
     */
    function setPermintaanKePenunjang() {
        $('#form-permintaankepenunjang').addClass("animation-loading");
        var penjamin_id = $("#penjamin_id").val();
        var pasienkirimkeunitlain_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienkirimkeunitlain_id') ?>").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetPermintaanKePenunjang'); ?>',
            data: {
                penjamin_id: penjamin_id,
                pasienkirimkeunitlain_id: pasienkirimkeunitlain_id
            },
            dataType: "json",
            success: function(data) {
                $('#form-permintaankepenunjang table > tbody').html(data.rows);
                $('#form-permintaankepenunjang').removeClass("animation-loading");
                renameInputRow($("#form-permintaankepenunjang"));
                setChecklistPemeriksaanBedah();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * load pemeriksaan yang sudah tersimpan berdasarkan:
     * - pasienmasukpenunjang_id
     */
    function setRencanaTindakanOperasi() {
        $('#form-tindakanpemeriksaan').addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetRencanaTindakanOperasi'); ?>',
            data: {
                pasienmasukpenunjang_id: $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienmasukpenunjang_id') ?>").val()
            },
            dataType: "json",
            success: function(data) {
                $('#form-tindakanpemeriksaan table > tbody').html(data.rows);
                $('#form-tindakanpemeriksaan').removeClass("animation-loading");
                renameInputRow($("#form-tindakanpemeriksaan"));
                setChecklistPemeriksaanBedah();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hitungTarifCyto(obj) {
        var tarifTindakan = unformatNumber($(obj).parents('tr').find('input[name*="[tarif_satuan]"]').val());
        var persen = unformatNumber($(obj).parents('tr').find('input[name*="[persencyto_tind]"]').val());
        var tarifCyto = 0;
        var cyto = obj.value;
        if (cyto == 1) {
            tarifCyto = tarifTindakan + (tarifTindakan * (persen / 100));
            $(obj).parents('tr').find('input[name*="[tarif_cyto]"]').val(formatNumber(tarifCyto));
        } else {
            $(obj).parents('tr').find('input[name*="[tarif_cyto]"]').val(0);
        }
    }

    /*  *
     * 
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * 
     * Mengambil data pegawai_v dari pencarian autocomplete.
     * Berdasarkan nama pegawai (jika ada).
     * 
     * @param type $term input pencarian autocomplete.
     * 
     */
    function simpanKruPegawai() {
        var id = $("#kruBedahId").val();
        var lookup = $("#lookupKruBedah").val();

        if (lookup == '') {
            $("#lookupKruBedah").attr("style", "border:1px solid red;");
        } else {
            $("#lookupKruBedah").attr("style", "");
        }

        if (id == '') {
            $("#kruBedahNama").attr("style", "border:1px solid red;");
        } else {
            $("#kruBedahNama").attr("style", "");
        }



        if (id != '' && lookup != '') {
            var length = $("#urut-" + lookup.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").length;

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('AddKruBedah'); ?>',
                data: {
                    id: id,
                    lookup: lookup,
                    length: length
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses == 1) {
                        var cek = true;
                        $("#urut-" + lookup.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").each(function() {
                            if ($(this).find(".krubedah_id").val() == data.id) {
                                alert("Maaf, pegawai ini sudah ditambahkan pada Kru Bedah " + data.look);
                                cek = false;
                            }
                        });

                        if (cek == true) {
                            $("#urut-" + data.lookup).append(data.div);
                            renameInputRowPelaksanaOperasi();
                            $("#kruBedahId").val('');
                            $("#kruBedahNama").val('');
                            $("#lookupKruBedah").val('');
                            $('#dialogKruBedah').dialog('close');
                        } else {
                            return false;
                        }

                    } else {
                        alert(data.pesan);
                        return false;
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            alert("Maaf, Kru Bedah dan Nama Pegawai harus diisi, untuk nama pegawai harus dipilih (dari hasil auto complete)");
            return false;
        }
    }

    function renameInputRowPelaksanaOperasi() {
        var row = 0;

        $(".pelaksanaoperasi").each(function() {
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });


            if (($(this).hasClass('awal'))) {

            } else {
                row++;
            }
        });
    }

    function removeData(obj, st) {
        $(obj).parents('.pelaksanaoperasi').attr('style', 'border:1px solid red;');

        var conf = confirm("Apakah Anda ingin menghapus data ini ?");


        if (conf == true) {
            $(obj).parents('.pelaksanaoperasi').remove();
            renameInputRowPelaksanaOperasi();
            var row = 0;
            $("#urut-" + st.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").each(function() {
                if (($(this).hasClass('awal'))) {

                } else {
                    if (row == 0) {
                        $(this).find('.gantilabel').html(st);
                    }
                }
                row++;
            });

        } else {
            $(obj).parents('.pelaksanaoperasi').attr('style', '');
            return false;
        }

    }

    /**
     * - digunakan untuk mengupdate data pegawai kru bedah, yang sudah tersimpan dengan cara dibatalkan
     * @param {type} obj
     * @param {type} st
     * @returns {Boolean} */
    function removeDataFromDb(obj, st) {

        var id = $(obj).attr('krubedah_id');
        $(obj).parents('.pelaksanaoperasi').attr('style', 'border:1px solid red;');

        var conf = confirm("Apakah Anda ingin membatalkan data ini ?");


        if (conf == true) {

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('BatalKruBedah'); ?>',
                data: {
                    id: id,
                    lookup: st
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses == 1) {
                        $(obj).parents('.pelaksanaoperasi').remove();
                        renameInputRowPelaksanaOperasi();
                        var row = 0;
                        $("#urut-" + st.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").each(function() {
                            if (($(this).hasClass('awal'))) {

                            } else {
                                if (row == 0) {
                                    $(this).find('.gantilabel').html(st);
                                }
                            }
                            row++;
                        });
                        alert(data.pesan);

                    } else {
                        alert(data.pesan);
                        return false;
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            $(obj).parents('.pelaksanaoperasi').attr('style', '');
            return false;
        }

    }

    function tambahLookup() {
        var p = prompt("Tambah Kru Bedah Baru ");

        if (p === null) {
            return false;
        } else if (p == '') {
            alert("Maaf, kru bedah belum diisi!");
            return false;
        } else {
            var yes = confirm("Apakah Anda yakin ingin menambahkan kru bedah baru ? ");

            if (yes) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('AddLookupKruBedah'); ?>',
                    data: {
                        krubedah: p
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses == 1) {
                            var lookup = data.look;
                            alert(data.pesan);
                            $("#lookupKruBedah").html(data.drop);
                            $(".lookupkrubedah:last").after("<span id='urut-" + lookup.toLowerCase().replace(/\s/g, '-') + "' class='lookupkrubedah'></span>");
                        } else {
                            alert(data.pesan);
                            return false;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            } else {
                return false;
            }
        }
        /*myPrompt("Tambah Kru Bedah Baru", "", "", function(r) {
        var v = r;
        
        if (v.trim() == "") return false;
        
        myConfirm("Anda yakin untuk menambah kru bedah '" + r + "'?", "Peringatan", function(yes) {
            if (yes) {
                $.ajax({
					type:'POST',
					url:'<?php echo $this->createUrl('AddLookupKruBedah'); ?>',
					data: {krubedah:v},
					dataType: "json",
					success:function(data){
						if (data.sukses == 1){							
							alert(data.pesan);
						}else{
							alert(data.pesan);
							return false;
						}

					},
					error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
				});
            }
        });
    });*/
    }


    //add multiselect 
    var dokterpelaksana2_id = $("<?php echo "#" . CHtml::activeId($modRencanaOperasi, 'dokterpelaksana2_id'); ?>");
    var dokterresusitasi_id = $("<?php echo "#" . CHtml::activeId($modRencanaOperasi, 'dokterresusitasi_id'); ?>");
    var dokterpelaksana1_id = $("<?php echo "#" . CHtml::activeId($modRencanaOperasi, 'dokterpelaksana1_id'); ?>");
    var dokteranastesi_id = $("<?php echo "#" . CHtml::activeId($modRencanaOperasi, 'dokteranastesi_id'); ?>");
    var paramedis_id = $("<?php echo "#" . CHtml::activeId($modRencanaOperasi, 'paramedis_id'); ?>");
    var suster_id = $("<?php echo "#" . CHtml::activeId($modRencanaOperasi, 'suster_id'); ?>");
    var bidan_id = $("<?php echo "#" . CHtml::activeId($modRencanaOperasi, 'bidan_id'); ?>");
    var perawatsirkuler_id = $("<?php echo "#" . CHtml::activeId($modRencanaOperasi, 'perawatsirkuler_id'); ?>");
    var ppds_id = $("<?php echo "#" . CHtml::activeId($modRencanaOperasi, 'ppds_id'); ?>");

    function setKruBedah() {

        jQuery(dokterpelaksana2_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();

        jQuery(dokterresusitasi_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();

        jQuery(dokterpelaksana1_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();

        jQuery(dokteranastesi_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();

        jQuery(paramedis_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();

        jQuery(bidan_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();

        jQuery(suster_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();

        jQuery(perawatsirkuler_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();

        jQuery(ppds_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                console.log(element, 'data')
            }
        }).hide();



    }


    /**
     * print status 
     */
    //function printStatus()
    //{
    //    var pendaftaran_id = $("#pendaftaran_id").val();
    //    if(pendaftaran_id != ""){
    //        window.open('<?php echo $this->createUrl('pendaftaranRadiologi/printStatusRad'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
    //    }else{
    //        myAlert("Silakan pilih data rujukan pasien!");
    //    }
    //}

    /**
     * menambahkan form obatalkespasien ke tabel
     * copy dari: laboratorium.views.pemakaianBmhp
     * @type Arguments
     */
    //function tambahObatAlkesPasien(obj)
    //{
    //    unformatNumberSemua();
    //    var pasienmasukpenunjang_id = $('#pasienmasukpenunjang_id').val();
    //    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    //    var jumlah = $(obj).parents('fieldset').find('#qty_input').val();
    //    
    //    if((obatalkes_id!='') && (pasienmasukpenunjang_id!='') && (jumlah > 0)){
    //        $.ajax({
    //            type:'POST',
    //            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
    //            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
    //            dataType: "json",
    //            success:function(data){
    //                if(data.pesan !== ""){
    //                    myAlert(data.pesan);
    //                    return false;
    //                }
    //                var tambahkandetail = true;
    //                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
    //                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
    //                    myConfirm("Apakah Anda akan input ulang obat ini?","Perhatian!",function(r) {
    //                        if(r){
    //                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
    //                                $(this).parents('tr').detach();
    //                            });
    //                        }else{
    //                            tambahkandetail = false;
    //                        }
    //                    });
    //                }
    //                if(tambahkandetail){
    //                    $('#table-obatalkespasien > tbody').append(data.form);
    //                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
    //                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
    //                    );
    //                    renameInputRowObatAlkes($("#table-obatalkespasien"));  
    //                }
    //                $(obj).parents('fieldset').find('#obatalkes_id').val('');
    //                $('#obatalkes_nama').val('');
    //                $('#qty_input').val(1);
    //                formatNumberSemua();
    //                renameInputRowObatAlkes($("#table-obatalkespasien")); 
    //            },
    //            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    //        });
    //    }else{
    //        if(pasienmasukpenunjang_id == ''){
    //            myAlert("Silakan isi data kunjungan terlebih dahulu!");
    //        }else if(obatalkes_id == ''){
    //            myAlert("Silakan pilih obat alkes terlebih dahulu!");
    //        }else if(jumlah == 0){
    //            myAlert("Stok obat kosong!");
    //        }
    //    }
    //    setObatAlkesPasienReset();  
    //}
    //function tambahObatAlkesPasien(){
    //    unformatNumberSemua();
    //    var pasienmasukpenunjang_id = $('#pasienmasukpenunjang_id').val();
    //    var obatalkes_id = $('#obatalkes_id').val();
    //    var obatalkes_nama = $('#obatalkes_nama').val();
    //    var satuankecil_id = $('#satuankecil_id').val();
    //    var satuankecil_nama = $('#satuankecil_nama').val();
    //    var sumberdana_id = $('#sumberdana_id').val();
    //    var qty = parseInt($('#qty_input').val());
    //    var qty_stok = parseInt($('#qty_stok').val());
    //    var hargajual = parseInt($('#hargajual').val());
    //    var harganetto = parseInt($('#harganetto').val());
    //
    //    var rowtindakan = "";
    //    rowtindakan = '<?php // echo CJSON::encode($this->renderPartial('_rowObatAlkesPasien',array('modObatAlkesPasien'=>$modObatAlkesPasien),true));
                            ?>';
    //    if((obatalkes_id!='') && (pasienmasukpenunjang_id!='') && (qty_stok > 0) && (qty <= qty_stok)){
    //        $("#table-obatalkespasien").find('tbody').append(rowtindakan);
    //        $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
    //        $("#table-obatalkespasien").find('span[name$="[ii][obatalkes_nama]"]').html(obatalkes_nama);
    //        $("#table-obatalkespasien").find('span[name$="[ii][satuankecil_nama]"]').html(satuankecil_nama);
    //        $("#table-obatalkespasien").find('input[name$="[ii][qty_stok]"]').val(qty_stok);
    //        $("#table-obatalkespasien").find('input[name$="[ii][qty_oa]"]').val(qty);
    //        $("#table-obatalkespasien").find('input[name$="[ii][hargajual_oa]"]').val(hargajual);
    //        $("#table-obatalkespasien").find('input[name$="[ii][harganetto_oa]"]').val(harganetto);
    //        $("#table-obatalkespasien").find('input[name$="[ii][sumberdana_id]"]').val(sumberdana_id);
    //        $("#table-obatalkespasien").find('input[name$="[ii][satuankecil_id]"]').val(satuankecil_id);
    //        $("#table-obatalkespasien").find('input[name$="[ii][iurbiaya]"]').val(qty*hargajual);
    //        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
    //            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
    //        );
    //        $('#table-obatalkespasien').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    //        renameInputRowObatAlkes($("#table-obatalkespasien"));
    //        formatNumberSemua();
    //    }else{
    //        if(pasienmasukpenunjang_id == ''){
    //            myAlert("Silakan isi data kunjungan terlebih dahulu!");
    //        }else if(obatalkes_id == ''){
    //            myAlert("Silakan pilih obat alkes terlebih dahulu!");
    //        }else if(qty_stok == 0){
    //            myAlert("Stok obat kosong!");
    //        }else if(qty > qty_stok){
    //            myAlert("Jumlah tidak boleh lebih besar dari stok tersedia "+qty_stok+".");
    //        }
    //    }
    //    setObatAlkesPasienReset();
    //}
    /**
     * reset form obat
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    //function setObatAlkesPasienReset(){
    //    $('#form-tambahobatalkes :input').val("");
    //    $('#qty_input').val("1");
    //    $('#obatalkes_nama').focus();
    //}
    /**
     * load obatalkespasien_t yang sudah tersimpan berdasarkan:
     * - pasienmasukpenunjang_id
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    //function setRiwayatObatAlkesPasien(){
    //    $('#riwayat-obatalkespasien-t').addClass("animation-loading");
    //    $.ajax({
    //        type:'POST',
    //        url:'<?php echo $this->createUrl('/laboratorium/PemakaianBahan/setRiwayatObatAlkesPasien'); ?>',
    //        data: {pasienmasukpenunjang_id:$("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'pasienmasukpenunjang_id') ?>").val()},
    //        dataType: "json",
    //        success:function(data){
    //            $('#riwayat-obatalkespasien-t table > tbody').html(data.rows);
    //            $('#riwayat-obatalkespasien-t table > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    //            $('#riwayat-obatalkespasien-t').removeClass("animation-loading");
    //            renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
    //        },
    //        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    //    });
    //}
    /**
     * rename input grid
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    //function renameInputRowObatAlkes(obj_table){
    //        var row = 0;
    //        $(obj_table).find("tbody > tr").each(function(){
    //            $(this).find("#no_urut").val(row+1);
    //            $(this).find('span').each(function(){ //element <input>
    //                var old_name = $(this).attr("name").replace(/]/g,"");
    //                var old_name_arr = old_name.split("[");
    //                if(old_name_arr.length == 3){
    //                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
    //                }
    //            });
    //            $(this).find('input,select,textarea').each(function(){ //element <input>
    //                var old_name = $(this).attr("name").replace(/]/g,"");
    //                var old_name_arr = old_name.split("[");
    //                if(old_name_arr.length == 3){
    //                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
    //                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
    //                }
    //            });
    //            row++;
    //        });
    //}
    /**
     * membatalkan form input obat alkes pasien 
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    //function batalOaPasien(obj)
    //{
    //    myConfirm("Apakah Anda akan membatalkan obat / alat kesehatan ini?","Perhatian!",function(r) {
    //        if(r){
    //            $(obj).parents('tr').remove();
    //            renameInputRowObatAlkes($("#table-obatalkespasien"));
    //        }
    //    });
    //}
    /**
     * menghapus obat alkes pasien yang sudah tersimpan di ObatalkespasienT
     * berdasarkan obatalkespasien_id
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    //function hapusOaPasien(obatalkespasien_id)
    //{
    //    myConfirm("Apakah Anda akan menghapus obat / alat kesehatan ini?","Perhatian!",function(r) {
    //        if(r){
    //            $.ajax({
    //                type:'POST',
    //                url:'<?php echo $this->createUrl('/laboratorium/PemakaianBmhp/hapusObatAlkesPasien'); ?>',
    //                data: {obatalkespasien_id:obatalkespasien_id},
    //                dataType: "json",
    //                success:function(data){
    //                    if(data.sukses){
    //                        var delete_row = $("#riwayat-obatalkespasien-t").find('input[name$="[obatalkespasien_id]"][value="'+obatalkespasien_id+'"]').parents('tr');
    //                        delete_row.detach();
    //                        renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
    //                    }
    //                    myAlert(data.pesan);
    //                },
    //                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    //            });
    //            renameInputRowObatAlkes($("#riwayat-obatalkespasien-t"));
    //        }
    //    });
    //}
    /**
     * menghitung subtotal obat alkes per baris
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    //function hitungSubTotal(obj)
    //{
    //    unformatNumberSemua();
    //    var subtotal = 0;
    //    var qty = parseInt($(obj).val());
    //    var qty_stok = parseInt($(obj).parents('tr').find('input[name$="[qty_stok]"]').val());
    //    var hargajual_oa = parseInt($(obj).parents('tr').find('input[name$="[hargajual_oa]"]').val());
    //    subtotal = qty * hargajual_oa;
    //    $(obj).parents('tr').find('input[name$="[iurbiaya]"]').val(formatInteger(subtotal));
    //    if(qty > qty_stok){
    //        $(obj).val(qty_stok);
    //        myAlert("Jumlah tidak boleh lebih besar dari stok!");
    //    }
    //    formatNumberSemua();
    //}
    /**
     * print pemakaian bahan
     * copy dari: laboratorium.views.pemakaianBmhp
     */
    //function printPemakaianOa(pasienmasukpenunjang_id)
    //{
    //    window.open('<?php // echo $this->createUrl('/laboratorium/PemakaianBahan/print'); 
                        ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=100,width=480,height=640');
    //}

    /**
     * javascript yang di running setelah halaman ready / load sempurna
     * posisi script ini harus tetap dibawah
     */




    $(document).ready(function() {

        <?php // if(!$modPasienMasukPenunjang->isNewRecord){ 
        ?>
        //        setTindakanPelayanan();
        //        setRiwayatObatAlkesPasien();
        //        $("input, select, textarea").attr("readonly",true);
        <?php // } 
        ?>
        <?php if (isset($_GET['pasienkirimkeunitlain_id'])) { ?>
            setPermintaanKePenunjang();
            setTimeout(function() {
                setCheckedPemeriksaanDariPermintaan();
            }, 3000); //auto check permintaan
        <?php } ?>
        <?php if (isset($_GET['pasienmasukpenunjang_id'])) { ?>
            setRencanaTindakanOperasi();
            //        setTimeout(function(){setCheckedTindakanOperasi();}, 3000);//auto check permintaan
        <?php } ?>
        <?php if (isset($_GET['pendaftaran_id'])) { ?>
            setChecklistPemeriksaanBedah();
            $("#form-datakunjungan :input").attr("readonly", true);
            $("#form-datakunjungan .add-on").remove();
        <?php } ?>

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
                    isinotifikasi: 'Pasien <?php echo $modKunjungan->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>

        renameInputRowPelaksanaOperasi();
        setKruBedah();
    });
</script>