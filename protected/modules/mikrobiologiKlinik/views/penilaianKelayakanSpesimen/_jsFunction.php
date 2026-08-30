<script type="text/javascript">

    /**
     * Load Data Rincian
     * @returns {undefined}     
     */
    function loadRincian() {
        var kelaspelayanan_id = $("#kelaspelayanan_id").val();
        var penjamin_id = $("#penjamin_id").val();
        var pasienkirimkeunitlain_id = <?php echo!empty($_GET['pasienkirimkeunitlain_id']) ? $_GET['pasienkirimkeunitlain_id'] : 0; ?>;
        if (kelaspelayanan_id !== '' && kelaspelayanan_id !== '') {
            $("#tabel-pemeriksaan2").addClass("animation-loading");

            $.post('<?php echo $this->createUrl('setDetail'); ?>', {
                kelaspelayanan_id: kelaspelayanan_id,
                penjamin_id: penjamin_id,
                pasienkirimkeunitlain_id: pasienkirimkeunitlain_id
            },
                    function (data) {
                        if (data.message == 'sukses') {
                            $("#tabel-pemeriksaan2 > tbody > tr").remove();
                            $('#tabel-pemeriksaan2 > tbody').append(data.form);
                            $("#tabel-pemeriksaan2").removeClass("animation-loading");

                        } else if (data.message == 'gagal') {
                            var div = new String(<?php echo CJSON::encode($this->renderPartial('_tabelSpesimenDetail', array('modSpesimen' => $modSpesimen, 'i' => 1), true)); ?>);

                            $("#tabel-pemeriksaan2 > tbody > tr").remove();
                            $('#tabel-pemeriksaan2 > tbody').append(row);
                            $("#tabel-pemeriksaan2").removeClass("animation-loading");
                        }
                    }, "json");
        }
    }

    /**
     * Tambah Baris
     * @returns {undefined}     
     */
    function tambahBaris() {
        var row = '<?php echo CJSON::encode($this->renderPartial('_tabelSpesimenDetail', array('modSpesimen' => $modSpesimen, 'i' => 1), true)); ?>';
        var idsample = $('#KirimspesimenlabT_samplelab_id').val();
        var namasample = $('#KirimspesimenlabT_samplelab_nama').val();
        $('#tabel-pemeriksaan2 > tbody').append(row);
        $('.id_samplelab').val(idsample);
        $('.nama_samplelab').val(namasample);
        $('.status_spesimen').val('Biasa');

        var x = 0;
        $('.tabelnyasispesimen').each(function () {
            setWigdet(); 
            $(this).find('.no_urut').html(x + 1);
            $(this).attr('data-row', x);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + x + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + x + "][" + old_name_arr[2] + "]");
                }
            });
            x++;
        });
    }

    /**
     * Hapus Baris yang belum disimpan
     * @param {type} obj
     * @returns {undefined}     
     */
    function hapusBaris(obj) {
        myConfirm("Apakah Anda yakin, ingin menghapus data ini ?", "Perhatian !", function (r) {
            if (r) {
                $(obj).parents("tr").remove();
                var x = 0;
                $('.tabelnyasispesimen').each(function () {
                    setWigdet(); 
                    $(this).find('.no_urut').html(x + 1);
                    $(this).attr('data-row', x);
                    $(this).find('input,select,textarea').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 3) {
                            $(this).attr("id", old_name_arr[0] + "_" + x + "_" + old_name_arr[2]);
                            $(this).attr("name", old_name_arr[0] + "[" + x + "][" + old_name_arr[2] + "]");
                        }
                    });
                    x++;
                });
               
            }
        });
    }

    /**
     * Hapus baris yang sudah disimpan
     * @param {type} obj
     * @returns {undefined}     
     */
    function hapusData(obj) {
        var spesimen_id = $(obj).parents("tr").find("input[name$='[spesimen_id]']").val();
        var permintaankepenunjang_id = $(obj).parents("tr").find("input[name$='[permintaankepenunjang_id]']").val();

        myConfirm('Apakah anda akan menghapus data ini?', 'Perhatian!', function (r) {
            if (r) {
                $(obj).parents('tr').hide();
                $(obj).parents("tr").find(".statusspesimen").val(1);
                var x = 0;
                $('.tabelnyasispesimen').each(function () {
                    setWigdet();
                    $(this).find('.no_urut').html(x + 1);
                    $(this).attr('data-row', x);
                    $(this).find('input,select,textarea').each(function () { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 3) {
                            $(this).attr("id", old_name_arr[0] + "_" + x + "_" + old_name_arr[2]);
                            $(this).attr("name", old_name_arr[0] + "[" + x + "][" + old_name_arr[2] + "]");
                        }
                    });
                    x++;
                });
            }
        });
    }

    function cekWajib() {
        $("#penilaiankelayakanspesimen-form").submit();
    }

    /**
     * rename input row yang terakhir di tambahkan
     * @param {type} obj_table
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function () { //element <span>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + old_name_arr[1] + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + old_name_arr[1] + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });
            row++;
        });
    }

    function tambahSpesimen(obj) {
        var div = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view_spesimen . '_formLoadSpesimen', array('modSpesimen' => $modSpesimen), true)); ?>);
        $("#input-spesimen").append(div.replace());

        x = 0;
        $('.tabelnyasispesimen').each(function () {
            $(this).find('.no_urut').html(x + 1);
            $(this).attr('data-row', x);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + x + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + x + "][" + old_name_arr[2] + "]");
                }
            });
            x++;
        });

        $('.tabelnyasispesimen').each(function () {
            setWigdet();
            jQuery('input[name$="[waktu_pengambilan_spesimen]"]').datetimepicker(
                    jQuery.extend(
                            {showMonthAfterYear: true},
                            jQuery.datepicker.regional['id'],
                            {
                                'timeText': 'Waktu',
                                'hourText': 'Jam',
                                'minuteText': 'Menit',
                                'secondText': 'Detik',
                                'showSecond': true,
                                'timeOnlyTitle': 'Pilih Waktu',
                                'timeFormat': 'hh:mm:ss',
                                'dateFormat': 'dd M yy',
                                'changeYear': true,
                                'changeMonth': true,
                                'showAnim': 'fold',
                                'yearRange': '-0y:+10y'
                            }
                    )
                    );
            $('input[name$="[waktu_pengambilan_spesimen]"]').each(function () {
                var obj = $(this);
                $(this).parent().find(".add-on").click(function () {
                    $(obj).focus();
                });
            });
        });
    }

    function setDialogSampleLab(obj) {
        parent = $(obj).parents(".tabelnyasispesimen").find("input").attr("id");
        dialog = "#dialogPemeriksaanSpesimen";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    function setDialogPemeriksaan(obj) {
        parent = $(obj).parents(".tabelnyasispesimen").find("input").attr("id");
        dialog = "#dialogTindakanSpesimen";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");

        x = 0;
        is_pilih_pemeriksaan = [];
        while (is_pilih_pemeriksaan.length > 0) {
            is_pilih_pemeriksaan.pop();
        }
        $("#tabel-pemeriksaan2 > tbody > tr").each(function () {
            val = $(this).find('.idDaftarTindakan').val();
            is_pilih_pemeriksaan[x] = val;
            x++;
        });

        var ruangan_id = $("#ruangan_id").val();
        var penjamin_id = $("#penjamin_id").val();
        var kelaspelayanan_id = $("#kelaspelayanan_id").val();

        $("#dialogTindakanSpesimen").addClass('animation-loading');
        $.post('<?php echo $this->createUrl('SetTabelPemeriksaanSpesimen'); ?>', {
            is_pilih_pemeriksaan: is_pilih_pemeriksaan,
            ruangan_id: ruangan_id,
            penjamin_id: penjamin_id,
            kelaspelayanan_id: kelaspelayanan_id,
        }, function (data) {
            $("#dialogTindakanSpesimen").removeClass("animation-loading");
            $("#pemeriksaan_spesimen > tbody").html(data.tr);
        }, 'json');

    }

    function setTindakanSpesimen(pemeriksaanlab_id, pemeriksaanlab_nama, daftartindakan_id, tarif) {
        dialog = "#dialogTindakanSpesimen";
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        var ada = 0;
        $("#tabel-pemeriksaan2 > tbody > tr").each(function () {
            var daftartindakan_id_temp = $(this).find('input[name$="[daftartindakan_id]"]').val();
            if (daftartindakan_id == daftartindakan_id_temp) {
                ada++;
            }
        });

        if (ada == 0) {
            $(obj).parents('.tabelnyasispesimen').find('input[name$="[pemeriksaanlab_nama]"]').val(pemeriksaanlab_nama);
            $(obj).parents('.tabelnyasispesimen').find('input[name$="[pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
            $(obj).parents('.tabelnyasispesimen').find('input[name$="[daftartindakan_id]"]').val(daftartindakan_id);
            $(obj).parents('.tabelnyasispesimen').find('input[name$="[tarif_pelayananan]"]').val(tarif);
        } else {
            toastr.error('Data Pemeriksaan sudah ditambahkan di tabel. Silahkan memilih pemeriksaan yang lain.', 'Perhatian!');
        }

    }

    function setTindakanSpesimen2(pemeriksaanlab_id, pemeriksaanlab_nama, tindakanpelayanan_id, obj) {
        $(obj).parents('.tabelnyasispesimen').find('input[name$="[pemeriksaanlab_nama]"]').val(pemeriksaanlab_nama);
        $(obj).parents('.tabelnyasispesimen').find('input[name$="[pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
//        $(obj).parents('.tabelnyasispesimen').find('input[name$="[tindakanpelayanan_id]"]').val(tindakanpelayanan_id);
    }

    function setPemeriksaanSpesimen(samplelab_nama, samplelab_id) {
        $("#KirimspesimenlabT_samplelab_nama").val(samplelab_nama);
        $("#KirimspesimenlabT_samplelab_id").val(samplelab_id);
        $('.tabelnyasispesimen').each(function () {
            $(this).find('.nama_samplelab').val(samplelab_nama);
            $(this).find('.id_samplelab').val(samplelab_id);
        });
    }

    function setPemeriksaanSpesimen2(samplelab_nama, samplelab_id, obj) {
        $(obj).parents('.tabelnyasispesimen').find('input[name$="[samplelab_nama]"]').val(samplelab_nama);
        $(obj).parents('.tabelnyasispesimen').find('input[name$="[samplelab_id]"]').val(samplelab_id);
    }

    function setWigdet() {
        jQuery('input[name$="[samplelab_nama]"]').autocomplete(
                {
                    'showAnim': 'fold',
                    'minLength': 3,
                    'focus': function (event, ui)
                    {
                        return false;
                    },
                    'select': function (event, ui)
                    {
                        $(this).val(ui.item.samplelab_nama);
                        setPemeriksaanSpesimen2(ui.item.samplelab_nama, ui.item.samplelab_id, this);
                        return false;
                    },
                    'source': function (request, response)
                    {
                        $.ajax({
                            url: "<?php echo $this->createUrl('AutoCompleteSampleLab'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }
                });

        jQuery('input[name$="[pemeriksaanlab_nama]"]').autocomplete(
                {
                    'showAnim': 'fold',
                    'minLength': 3,
                    'focus': function (event, ui)
                    {
                        $(this).val("");
                        return false;
                    },
                    'select': function (event, ui)
                    {
                        setTindakanSpesimen2(ui.item.pemeriksaanlab_id, ui.item.pemeriksaanlab_nama, ui.item.tindakanpelayanan_id, this);
                        return false;
                    },
                    'source': function (request, response)
                    {
                        ruangan_id = $("#ruangan_id").val();
                        penjamin_id = $("#penjamin_id").val();
                        kelaspelayanan_id = $("#kelaspelayanan_id").val();

                        x = 0;
                        is_pilih_pemeriksaan = [];
                        $("#tabel-pemeriksaan2 > tbody > tr").each(function () {
                            val = $(this).find('.idDaftarTindakan').val();
                            is_pilih_pemeriksaan[x] = val;
                            x++;
                        });

                        $.ajax({
                            url: "<?php echo $this->createUrl('AutocompletePemeriksaan'); ?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                                ruangan_id: ruangan_id,
                                penjamin_id: penjamin_id,
                                kelaspelayanan_id: kelaspelayanan_id,
                                daftartindakan_id: is_pilih_pemeriksaan,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }
                });
    }

    function printBarcode(spesimen_id)
    {
        var spesimen_id = spesimen_id;
        var pasienkirimkeunitlain_id = '<?php echo isset($_GET['pasienkirimkeunitlain_id']) ? $_GET['pasienkirimkeunitlain_id'] : '' ?>';
        if (spesimen_id != "") {
            window.open('<?php echo $this->createUrl('printBarcodeSample'); ?>&spesimen_id=' + spesimen_id + '&pasienkirimkeunitlain_id=' + pasienkirimkeunitlain_id, 'printwin', 'left=100,top=0,width=768,height=640');
        } else {
            myAlert("Tidak Ada Data Pasien");
        }
    }

    function printQr(spesimen_id) {

        var spesimen_id = spesimen_id;
        var pasienkirimkeunitlain_id = '<?php echo isset($_GET['pasienkirimkeunitlain_id']) ? $_GET['pasienkirimkeunitlain_id'] : '' ?>';
        if (spesimen_id != "") {
            window.open('<?php echo $this->createUrl('printQrSample'); ?>&spesimen_id=' + spesimen_id + '&pasienkirimkeunitlain_id=' + pasienkirimkeunitlain_id, 'printwin', 'left=100,top=0,width=768,height=640');
        } else {
            myAlert("Tidak Ada Data Pasien");
        }

    }
    $(document).ready(function () {
        loadRincian();
        <?php if (isset($_GET['pasienkirimkeunitlain_id'])) { ?>
            $("#form-datakunjungan :input").attr("readonly", true);
            $("#form-datakunjungan .add-on").remove();
        <?php } ?>
        <?php if (isset($_GET['sukses'])) { ?>
            $("#penilaiankelayakanspesimen-form :input").attr("readonly", true);
            $("#penilaiankelayakanspesimen-form .add-on").remove();
        <?php } ?>

        $('.tabelnyasispesimen').each(function () {

            setWigdet();

        });
    })
</script>