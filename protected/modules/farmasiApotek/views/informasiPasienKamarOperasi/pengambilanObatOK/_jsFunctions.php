<?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasienLama&id=' . $modPasien->pasien_id); ?>

<script>

    function setRiwayatPasien() {
        var frameObj = document.getElementById("riwayatPasien");
        var jsframe = $("#riwayatPasien");

        jsframe.attr("src", "<?php echo $riwayatPasien; ?>");
        jsframe.parent().addClass("animation-loading");
        jsframe.on('load', function() {
            resizeIframeJs(jsframe);
            jsframe.parent().removeClass("animation-loading");
        });

        $('.accordion-inner').removeClass("animation-loading");
        
        return false;
    }

    $(document).ready(function () {
        setRiwayatPasien();
    });

    function setObatDariApi(kode_obat, sumberdana, stfornas, hargasatuanreseptur, satuan, HPP, nama) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatJalan/reseptur/getObat'); ?>',
            data: {
                kode_obat: kode_obat,
                sumberdana: sumberdana,
                stfornas:stfornas,
                harga_jual:hargasatuanreseptur,
                satuan:satuan,
                HPP:HPP,
                nama:nama
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if(data.sukses == 1) {
                    if(data.obatalkes.sukses == 1) {
                        $("#obatalkes_id").val(data.obatalkes.id);
                        $("#hargasatuanreseptur").val(hargasatuanreseptur); 
                        $("#sumberdana_id").val(data.sumberdana.id); 
                        $("#stfornas").val(stfornas); 
                        $("#dialogObatDariApi").dialog("close");
                    } else {
                        myAlert(data.pesan);
                    }
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function tambahRowObat(obj) {
        var obatalkes_id = $(obj).parents('form').find('#obatalkes_id').val();
        var jumlah = $(obj).parents('form').find('#jumlah').val();
        var keterangan = $(obj).parents('form').find('#keterangan').val();
        var petugasfarmasi_id = $(obj).parents('form').find('.petugasfarmasi_id').val();
        var paket_obat = $(obj).parents('form').find('.paket_obat').val();
        var tgl_resep = $('#tglresep_ok').val();
        var noresep = $('.noresep').val();
        var nama_pasien = $(obj).parents('form').find('.nama_pasien').val();

        var hargasatuanreseptur = $("#hargasatuanreseptur").val(); 
        var sumberdana_id = $("#sumberdana_id").val(); 
        var stfornas = $("#stfornas").val(); 
        console.log(obatalkes_id, jumlah, keterangan, petugasfarmasi_id, tgl_resep, noresep, nama_pasien, hargasatuanreseptur, sumberdana_id, stfornas);
        $('#table-reseptur').addClass('animation-loading');
        if (jumlah < 1) {
            myAlert("Jumlah tidak boleh nol");
            $('#table-reseptur').removeClass('animation-loading');
            return false;
        }
        if (obatalkes_id == '') {
            myAlert("Silahkan Pilih Obat Terlebih Dahulu");
            $('#table-reseptur').removeClass('animation-loading');
            return false;
        }
        if (paket_obat == '') {
            myAlert("Silahkan Isi Nama Paket Obat Operasi");
            $('#table-reseptur').removeClass('animation-loading');
            return false;
        }

        $.post('<?= $this->createUrl('setRowObat') ?>', {
            obatalkes_id:obatalkes_id,
            jumlah:jumlah,
            keterangan:keterangan,
            petugasfarmasi_id:petugasfarmasi_id,
            tgl_resep:tgl_resep,
            noresep:noresep,
            nama_pasien:nama_pasien,
            hargasatuanreseptur:hargasatuanreseptur,
            sumberdana_id:sumberdana_id,
            stfornas:stfornas,
            paket_obat:paket_obat
        }, function(data){
            $('#table-reseptur tbody').append(data.html);
            renameInputRowObatAlkes($('#table-reseptur'));
            $('#obatalkes_id').val('');
            $('#obatalkes_id_nama').val('');
            $('#jumlah').val(1);
            $('#keterangan').val('');
            $('#table-reseptur').removeClass('animation-loading');
        }, 'json');


    }

    function renameInputRowObatAlkes(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
           
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

    function batalRowObat(obj){
        myConfirm('Apakah Anda akan membatalkan penjualan obat alkes ini?','Perhatian!',
        function(r){
            if(r){
                $(obj).parents('tr').detach();
            }
        }); 
    }

    function validasiSingle(resepturokdet_id, obj) {
        
        myConfirm('Yakin Ingin memvalidasi ?', '! Perhatian', function(r){
            if(r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('validasiSingle'); ?>',
                    data: {
                        resepturokdet_id: resepturokdet_id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if(data.sukses == 1) {
                           window.parent.toastr.success('Data berhasil divalidasi');
                        } else {
                            window.parent.toastr.error('Data gagal divalidasi');
                        }
                        $.fn.yiiGridView.update('reseppasien-grid');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        })
    }

    function validasiAll(resepturok_id) {
        if(resepturok_id != '') {
            myConfirm('Yakin Ingin memvalidasi Semua Obat?', '! Perhatian', function(r){
                if(r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->createUrl('validasiAll'); ?>',
                        data: {
                            resepturok_id: resepturok_id,
                        },
                        dataType: "json",
                        success: function(data) {
                            if(data.sukses == 1) {
                                window.parent.toastr.success('Data berhasil divalidasi');
                                // $('#table-riwayat tbody').html(data.html);
                            } else {
                                window.parent.toastr.error('Data gagal divalidasi');
                            }
                            $.fn.yiiGridView.update('reseppasien-grid');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        }
    }

    function hapusresep(resepturokdet_id) {
        window.parent.myConfirm('Apakah anda akan menghapus Reseptur ini?', 'Perhatian!', function(r)
        {
            if(r){
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('hapus'); ?>',
                    data: {resepturokdet_id:resepturokdet_id},
                    dataType: "json",
                    success:function(data){
                        if(data.sukses == 1){
                            window.parent.toastr.success('Data Berhasil Dihapus');
                            updateTableRiwayat();
                            
                        } else {
                            if(data.sukses == 2) {
                                window.parent.toastr.warning(data.pesan);
                            } else {
                                window.parent.toastr.error(data.pesan);
                            }
                            updateTableRiwayat();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });

            }
        });
    }

    function buatPenjualan() {
        var pendaftaran_id = <?php echo $_GET['pendaftaran_id'] ?>;
        var pasienmasukpenunjang_id = <?php echo $_GET['pasienmasukpenunjang_id'] ?>;

        $('.kumpulanTombol').addClass('animation-loading');
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('buatPenjualanResepRS'); ?>',
            data: {
                pendaftaran_id:pendaftaran_id,
                pasienmasukpenunjang_id:pasienmasukpenunjang_id
            },
            dataType: "json",
            success: function(data) {
                if(data.sukses == 1) {
                    myAlert('Data berhasil dilakukan penjualan');
                    // $('#table-riwayat tbody').html('');
                    $.fn.yiiGridView.update('penjualanresepriwayat-v-grid');
                } else if(data.sukses == 2) {
                    myAlert(data.pesan);
                }else {
                    myAlert('Data gagal dilakukan penjualan');
                }
                $.fn.yiiGridView.update('reseppasien-grid');
                $('.kumpulanTombol').removeClass('animation-loading');
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }


    $(document).ready(function() {
        // Menonaktifkan elemen select saat halaman dimuat
        $('.petugasfarmasi_id').prop('disabled', true);

        // Mengaktifkan kembali elemen select saat formulir diajukan
        $('form').submit(function(event) {
            $('.petugasfarmasi_id').prop('disabled', false);
            $('.petugasfarmasi_id').prop('readonly', true);
            $('.form-actions').addClass('animation-loading');
            $('#btn_submit').prop('disabled', true);
        });

        $('.number-char').on('keypress', function(event) {
            var karakter = String.fromCharCode(event.which);

            // Regular expression untuk memeriksa apakah karakter adalah titik, koma, atau slash
            var pattern = /^[0-9.,\/]+$/;

            if (!pattern.test(karakter)) {
                event.preventDefault();
            }
        });
    });
    
    function updateTableRiwayat() {
        $('#table-riwayat').addClass('animation-loading');
        $.post('<?= $this->createUrl('updateTableRiwayat') ?>', {
           pendaftaran_id: <?= $_GET['pendaftaran_id'] ?>,
           pasienmasukpenunjang_id: <?= $_GET['pasienmasukpenunjang_id'] ?>
        }, function(data){
            $('#table-riwayat tbody').html(data.html);
            $('#table-riwayat').removeClass('animation-loading');
        }, 'json');
    }

    function printEtiketOK(resepturokdet_id) {
        window.open('<?php echo $this->createUrl('printEtiketOK'); ?>&resepturokdet_id=' + resepturokdet_id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>