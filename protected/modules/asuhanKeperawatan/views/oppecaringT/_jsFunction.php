<script>
    $(document).ready(function () {
        generateBulan();
    });

    /**
     * Generate Bulan 
     * @returns {undefined}     */
    function generateBulan() {
        jQuery('input[name$="ASOppecaringT[bulan_caring]"]').monthpicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.monthpicker.regional['en-GB'],
                        {

                            'dateFormat': 'M yy',
                            'timeOnlyTitle': 'Pilih Waktu',
                            'changeYear': true,
                            'changeMonth': true,
                            'finalYear': 'y',
                            'yearRange': "-10",
                            'showAnim': 'fold'
                        }
                ));
    }

    function hitungNilai() {
        var pasien = parseFloat(unformatNumber($("#ASOppecaringT_nilai_pasien").val()));
        var keluarga = parseFloat(unformatNumber($("#ASOppecaringT_nilai_keluarga").val()));
        var rata = 0; 
        if (pasien !== 0 && keluarga !== 0) {
            var jumlah = pasien + keluarga;
            var rata = jumlah / 2;
        } else if (pasien !== 0 && keluarga == 0) {
            var rata = pasien;
        } else if (pasien == 0 && keluarga !== 0) {
            var rata = keluarga;
        }

        $("#ASOppecaringT_nilai_rata").val(rata.toFixed(2));
        formatNumberSemua(); 
    }

    function cekNilai1(obj) {
        var nilai = parseFloat(unformatNumber(obj.value));
        if (nilai > 100) {
            toastr.error('Nilai tidak boleh lebih dari 100', "Perhatian");
            $('#ASOppecaringT_nilai_pasien').val('0,00');
            return false;
        } else {
            hitungNilai();
        }
    }

    function cekNilai2(obj) {
        var nilai = parseFloat(unformatNumber(obj.value));
        if (nilai > 100) {
            toastr.error('Nilai tidak boleh lebih dari 100', "Perhatian");
            $('#ASOppecaringT_nilai_keluarga').val('0,00');
            return false;
        } else {
            hitungNilai();
        }
    }

    /**
     * Submit Caring
     * @returns {undefined}
     */
    function submitCaring()
    {
        bulan_caring = $('#ASOppecaringT_bulan_caring').val();
        pegawai_id = $('#ASOppecaringT_pegawai_id').val();
        nama_pegawai = $('#ASOppecaringT_nama_perawat').val();
        nip = $('#ASOppecaringT_nip_perawat').val();
        namaunitkerja = $('#ASOppecaringT_namaunitkerja').val();
        perawat_unitkerja_id = $('#ASOppecaringT_perawat_unitkerja_id').val();
        tanggal_kuisioner = $('#ASOppecaringT_tgl_kuisioner').val();
        nilai_pasien = $('#ASOppecaringT_nilai_pasien').val();
        nilai_keluarga = $('#ASOppecaringT_nilai_keluarga').val();
        nilai_rata = $('#ASOppecaringT_nilai_rata').val();

        if (bulan_caring == '' || pegawai_id == '' || nama_pegawai == '' || nip == '' || perawat_unitkerja_id == '' || namaunitkerja == '' || nilai_pasien == '' || nilai_keluarga == '' || nilai_rata == '' || tanggal_kuisioner == '') {
            toastr.error('Input field yang bertanda merah', "Perhatian!");
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('GenerateTabel'); ?>',
                data: {bulan_caring: bulan_caring, pegawai_id: pegawai_id, nama_pegawai: nama_pegawai, nip: nip,
                    perawat_unitkerja_id: perawat_unitkerja_id, namaunitkerja: namaunitkerja, tanggal_kuisioner: tanggal_kuisioner,
                    nilai_pasien: nilai_pasien, nilai_keluarga: nilai_keluarga, nilai_rata: nilai_rata
                },
                dataType: "json",
                success: function (data) {
                    $("#tabelCaring > tbody").append(data.return);
                    $("#tabelCaring tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
                    renameInputRow($("#tabelCaring"));
                    resetData();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    /**
     * Hapus data sebelum disimpan
     * @param {type} obj
     * @returns {undefined}     
     */
    function hapusBaris(obj) {
        var id = $(obj).parents("tr").find("input[name$='[oppecaring_id]']").val();
        if (id == "") {
            $(obj).parents('tr').detach();
            renameInputRow($("#tabelCaring"));
        } else {
            myConfirm("Apakah Anda yakin akan menghapus data ini dari database?", "Perhatian!",
                    function (r) {
                        if (r) {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo $this->createUrl('HapusCaring'); ?>&id=' + id,
                                data: {id: id}, //
                                dataType: "json",
                                success: function (data) {
                                    if (data.sukses == 1) {
                                        toastr.success(data.pesan, 'Perhatian!');
                                        $(obj).parents('tr').detach();
                                        renameInputRow($("#tabelCaring"));
                                    } else {
                                        toastr.error(data.pesan);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");
                                }
                            });
                        }
                    });
        }

    }

    function renameInputRow(obj_table) {
        var row = 0;
        var count = $(obj_table).find('tbody > tr').length;
        $(obj_table).find('tbody > tr').each(function () {
            $(this).attr('no-row', row);
            $(this).find('.no-urut').html(row + 1);
            $(this).find('#no_urut').val(row + 1);
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

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    function resetData() {
        bulan_caring = $('#ASOppecaringT_bulan_caring').val("");
        perawat_id = $('#ASOppecaringT_pegawai_id').val('');
        nama_pegawai = $('#ASOppecaringT_nama_perawat').val('');
        nip = $('#ASOppecaringT_nip_perawat').val('');
        namaunitkerja = $('#ASOppecaringT_namaunitkerja').val('');
        perawat_unitkerja_id = $('#ASOppecaringT_perawat_unitkerja_id').val('');
        tanggal_kuisioner = $('#ASOppecaringT_tgl_kuisioner').val('');
        nilai_pasien = $('#ASOppecaringT_nilai_pasien').val('');
        nilai_keluarga = $('#ASOppecaringT_nilai_keluarga').val('');
        nilai_rata = $('#ASOppecaringT_nilai_rata').val('');

    }

    function cekCaring() {
        var ada = 0;
        var pegawai_id = $('#ASOppecaringT_pegawai_id').val();
        var bulan = $("#ASOppecaringT_bulan_caring").val();
        var cek_bulan = bulan.substr(0, 3); 
        var cek_tahun = bulan.substr(4, 4); 
        var semester = 0;
        
        if (cek_bulan == 'Jan' || cek_bulan == 'Feb' || cek_bulan == 'Mar' || cek_bulan == 'Apr' || cek_bulan == 'May' || cek_bulan == 'Jun') {
            semester = 1;
        } else {
            semester = 2;
        }
        
        
        
        var row = 0;
        $('#tabelCaring tbody tr').each(function () {
            var bulan = $(this).find('.bulan_caring').val();
            var this_bulan = bulan.substr(0, 3); 
            var this_tahun = bulan.substr(4, 4);
            var this_semester = 0;
            if (this_bulan == 'Jan' || this_bulan == 'Feb' || this_bulan == 'Mar' || this_bulan == 'Apr' || this_bulan == 'May' || this_bulan == 'Jun') {
                this_semester = 1;
            } else {
                this_semester = 2;
            }
            
            if ($(this).find(".pegawai_id").val() == pegawai_id && this_semester == semester && this_tahun == cek_tahun) {
                row++; 
            }
        });
        
        
        $.ajax({
            type: 'POST',
            data: {pegawai_id: pegawai_id, bulan: bulan},
            url: '<?php echo $this->createUrl('GetPerawat'); ?>',
            dataType: "json",
            success: function (data) {
                $("#riwayatCaring > tbody ").html(data.tr);
                $("#riwayatCaring > tfoot ").html(data.tfoot);
                var panjang_riwayat = $("#riwayatCaring > tbody > tr").length;
                var jumlah_row = row + panjang_riwayat; 
                
                console.log('ada :'+data.ada);
                console.log('jumlah_row :'+jumlah_row);
                console.log('hitung: '+data.hitung);
                if (data.ada === 1) {
                    toastr.error(data.pesan, 'Perhatian!');
                    resetData(); 
                } else if (jumlah_row >= 3) {
                    toastr.error('Data Caring <b>'+data.nama_pegawai+'</b> sudah dalam 1 semester', 'Perhatian!');
                    resetData(); 
                } else if (data.ada === 0){
                    $('#ASOppecaringT_pegawai_id').val(data.pegawai_id);
                    $('#ASOppecaringT_nama_perawat').val(data.nama_pegawai);
                    $('#ASOppecaringT_nip_perawat').val(data.nomorindukpegawai);
                    $('#ASOppecaringT_perawat_unitkerja_id').val(data.unitkerja_id);
                    $('#ASOppecaringT_namaunitkerja').val(data.namaunitkerja);
                }
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hitungNilaiRow() {
        var rata = 0;
        var jumlah = 0;
//        unformatNumberSemua();
        $('#tabelCaring tbody tr').each(function () {
            var pasien = parseFloat(unformatNumber($(this).find(".nilai_pasien").val()));
            var keluarga = parseFloat(unformatNumber($(this).find(".nilai_keluarga").val()));
            if (pasien !== 0 && keluarga !== 0) {
                var jumlah = pasien + keluarga;
                var rata = jumlah / 2;
            } else if (pasien !== 0 && keluarga == 0) {
                var rata = pasien;
            } else if (pasien == 0 && keluarga !== 0) {
                var rata = keluarga;
            }
            console.log(rata);
            $(this).find('.nilai_rata').val(rata.toFixed(2));
        });
        formatNumberSemua();
    }
    
    function cekForm() {

        var length = $("#tabelCaring > tbody > tr").length;

        if (length == 0) {
            toastr.error("Isi data terlebih dahulu", "Perhatian!");
            return false;
        }
        $("#oppecaring-t-form").submit();
        disableOnSubmit($("#btn_submit"));
    }

    $(document).ready(function () {
        renameInputRow($("#tabelCaring"));
    });
</script>