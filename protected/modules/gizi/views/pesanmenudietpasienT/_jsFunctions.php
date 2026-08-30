<script type="text/javascript">
    function simpanUbahMenuDiet(){
        var form = $('#form-ubah-diet');
        var pesanmenudetail_id = form.find('#dlg_pesanmenudetail_id').val();
        var jenisdiet_id = form.find('#dlg_jenisdiet_id').val();
        var jenisdiet_nama = form.find("#dialog_jenisdiet_nama").val();
        var menudiet_id = [];
        var jeniswaktu_id = [];
    
        $('.table-jenis-diet table tbody > tr').each(function(){
            menudiet_id.push($(this).find('.id_menudiet').val());
            jeniswaktu_id.push($(this).find('.id_jeniswaktu').val());
        });
        console.log(menudiet_id, jeniswaktu_id)
        $.post('<?= $this->createUrl('simpanPerubahanMenu') ?>', {
            pesanmenudetail_id:pesanmenudetail_id,
            menudiet_id:menudiet_id,
            jeniswaktu_id:jeniswaktu_id,
            jenisdiet_id:jenisdiet_id
        }, function(data){
            console.log(data)
            if(data.sukses == 1) {

                $("#jenisdiet").val(jenisdiet_nama);
                $(".form_jenisdiet_id").val(jenisdiet_id);


                $('#dialogUbahMenu').dialog('close');
                window.parent.toastr.success('Data Berhasil DiUbah');
            } else {
                window.parent.toastr.error('Data Gagal DiUbah');
            }
        }, 'json');
    }

    function ubahMenu(obj){
        var pesanmenudiet_id = $(obj).parents("tr").find('.pesanmenudiet_id').val();
        var pasienadmisi_id = $(obj).parents("tr").find('.det_pasienadmisi_id').val();
        var kelaspelayanan_id = $(obj).parents("tr").find('.det_kelaspelayanan_id').val();
        var pendaftaran_id = $(obj).parents("tr").find('.det_pendaftaran_id').val();
        var pasien_id = $(obj).parents("tr").find('.det_pasien_id').val();
        $('#dialogUbahMenu').dialog('open');

        $.post('<?= $this->createUrl('ubahMenuDiet') ?>', {
            pesanmenudiet_id:pesanmenudiet_id,
            pendaftaran_id:pendaftaran_id,
            kelaspelayanan_id:kelaspelayanan_id,
            pasienadmisi_id:pasienadmisi_id,
            pasien_id:pasien_id
        }, function(data){
            $('#ubah-menu-diet').html(data.html);
            $('#dialogUbahMenu').dialog('open');
        }, 'json');
    }

    function hapusMenu(obj) {
        var tr = $(obj).parents("tr");
        var pesanmenudetail_id = tr.find(".det_pesanmenudetail_id").val();

        console.log("Hapus", pesanmenudetail_id);

        if (tr.find(".verifikasi_id").val() != "") {
            myAlert("Pemesanan menu ini sudah diverifikasi.");
            return false;
        }
        myConfirm("Anda yakin untuk menghapus menu ini ?", "Peringatan", function(r) {
            if (r) {
                tr.remove();
                if (pesanmenudetail_id != "") {
                    registerIDHapusDetail(pesanmenudetail_id);
                }
            }
        });
    }

    function registerIDHapusDetail(pesanmenudetail_id) {
        var id = $("#hapusdetaildiet_id").val();
        var arr_det = [];

        if (id != "") {
            arr_det = id.split(".");
        }

        arr_det.push(pesanmenudetail_id);
        $("#hapusdetaildiet_id").val(arr_det.join("."));
    }

    function resetChecked() {
        $('#dialogMenuDiet').find('table tbody > tr').each(function(){
            console.log($(this).find('.menudiet_id').val(), 'menuuuuuu');
            $(this).find('.ceklis_baris').removeAttr('checked');
        });
    }

    function pilihAllMenuUbah(obj, id, data){
        var tr = '';
        if($("." + obj.filterClass).find('.kelaspelayanan_id_Ubah').val() != '' && $($(data)[2]).find('.kelaspelayanan_id_Ubah').val() != '') {
            var jeniswaktu = [];
            
            $(".jeniswaktuUbah:checked").each(function(index) {            
                jeniswaktu[index] = $(this).attr('value');
            });
            console.log(jeniswaktu, 'jeniswaktu')
            $($(data)[2]).find('table').find('tbody > tr').each(function(){
                console.log('jeniswaktuUbah', $(this).find('.jeniswaktu_id_ubah').val())
                if($.inArray($(this).find('.jeniswaktu_id_ubah').val(), jeniswaktu) !== -1) {
                    tr += '<tr>';
                    // kolom pertama
                    tr += '<td>';
                    tr += $(this).find('.menudiet_nama_ubah').val();
                    tr += '<input type="hidden" name="Detail[menudiet_id]" value="' + $(this).find('.menudiet_id_ubah').val() + '" class="id_menudiet">';
                    tr += '<input type="hidden" name="Detail[jeniswaktu_id]" value="' + $(this).find('.jeniswaktu_id_ubah').val() + '" class="id_jeniswaktu">';
                    tr += '</td>';

                    // kolom kedua
                    tr += '<td>';
                    tr += $(this).find('.jeniswaktu_nama_ubah').val();
                    tr += '</td>';
                    tr += '</tr>';
                }
            });
            $('.table-jenis-diet').find('table tbody').html(tr);
            $('#menuDietNama').dialog('close');
        }
    }

    function pilihAllMenu(obj, id, data){
        console.log(id, 'id test', $(data)[3]);
        console.log($("." + obj.filterClass).find('.kelaspelayanan_id').val(), 'kelaspelayanan_id')
        if($("." + obj.filterClass).find('.kelaspelayanan_id').val() != '' && $($(data)[3]).find('.kelaspelayanan_id').val() != '') {
            var menudiet_id = [];
            var jenisdiet_id = [];
            var ukuranrumahtangga = [];
            var jeniswaktu_id = [];
            var jeniswaktu = [];
            $(".jeniswaktu:checked").each(function(index) {            
                jeniswaktu[index] = $(this).attr('value');
            });
            $($(data)[3]).find('table').find('tbody > tr').each(function(){
              
                if(jeniswaktu.indexOf($(this).find('.jeniswaktu_id').val()) !== -1) {
                    $(this).find('.ceklis_baris').attr('checked', true);
                }
                if($(this).find('.ceklis_baris').is(':checked')) {
                    var jenismenudiet_nama = $(this).find('.jenismenudiet_nama').val();
                    menudiet_id.push($(this).find('.menudiet_id').val());
                    jenisdiet_id.push($(this).find('.jenisdiet_id').val());
                    $('#jenisdiet_id').val($(this).find('.jenisdiet_id').val());
                    ukuranrumahtangga.push($(this).find('.ukuranrumahtangga').val());
                    jeniswaktu_id.push($(this).find('.jeniswaktu_id').val());
                }
            });
            $(obj.tableClass).find('tbody > tr').each(function(){
                if(jeniswaktu.indexOf($(this).find('.jeniswaktu_id').val()) !== -1) {
                    $(this).find('.ceklis_baris').attr('checked', true);
                }
            });
            inputMenuDietAutoCheck(menudiet_id, jenisdiet_id, ukuranrumahtangga, jeniswaktu_id);
            menudiet_id = [];
            jenisdiet_id = [];
            ukuranrumahtangga = [];
            jeniswaktu_id = [];
            jeniswaktu = [];
            console.log(menudiet_id, 'menusss');
            
        }
        $("." + obj.filterClass).find('.kelaspelayanan_id').val(null);
        $("." + obj.filterClass).find('.kelaspelayanan_id').find('option').each(function(){
            $(this).removeAttr('selected')
        });
    }
    
    function inputMenuDietAutoCheck(menudiet_id, jenisdiet_id, ukuranrumahtangga, jeniswaktudipilih_id) {
        var pasien_id = $('#pasien_id').val();
        var pendaftaran_id = $('#pendaftaran_id').val();
        var pasienadmisi_id = $('#pasienadmisi_id').val();
        var kelaspelayanan_id = $('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>').val();
        // var menudiet_id = $('#menudiet_id').val();
        var jumlah = $('#jumlah').val();
        var alatmakan = $('#alatmakanan_id').val();
        var jenismakanan_id = $('#<?php echo CHtml::activeId($model, 'jenismakanan_id') ?>').val();
        var tipediet_id = $('#tipediet_id').val();
        var jeniswaktu = new Array();
        var pendaftaranId = new Array();
        var pasienAdmisi = new Array();
        // var jenisdiet_id = $('#jenisdiet_id').val();
        var urt = $('#URT').val();
        var ruangan_id = $('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>').val();
        var instalasi_id = $('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>').val();
        var menudiet_lain_id = $('#menudiet_lain_id').val();
        var alergi = $('#GZPesanmenudietT_adaalergimakanan').val();
        var keterangan = $('#GZPesanmenudietT_keterangan_pesan').val();
        var i = 0;

        jenisdiet_id = $("#GZPesanmenudietT_jenisdiet_id").val();
        

        if (pendaftaran_id == '') {
            toastr.error("Data Pasien belum dipilih", "Perhatian!");
            return false;
        }

        var cekJenisWaktu = 0;
        $(".jeniswaktu:checked").each(function(index) {            
            jeniswaktu[index] = $(this).attr('value');
            cekJenisWaktu++;            
        });

        console.log('jenismakanan_id :', jenismakanan_id);
        console.log('menudiet_id :', menudiet_id);
        console.log('cekJenisWaktu :', cekJenisWaktu);
        console.log('tipediet_id :', tipediet_id);
        console.log('alatmakan :', alatmakan);
        console.log('jeniswaktu :', jeniswaktu);
        console.table('jeniswaktu :', jeniswaktu);

        //if (jenismakanan_id === '' || menudiet_id === '' || cekJenisWaktu < 1 || tipediet_id === '' || alatmakan === '') {
        if (jenisdiet_id === '' || cekJenisWaktu < 1) {
            toastr.error("Menu dan Jenis Waktu", "Perhatian!");
            return false;
        }

        var cekTabelDetail = 0;
        var cekJumlah = 0;
        $(".det_pendaftaran_id").each(function() {
            if (pendaftaran_id == $(this).attr('value')) {
                cekTabelDetail++;
            }
            if (pendaftaran_id > 1) {
                cekJumlah++;
            }
        });
        
        // if (cekJumlah > 0) {
        //     myAlert("Maaf, hanya boleh 1 pasien saja", "Perhatian!");
        //     return false;
        // }

        if (cekTabelDetail > 0) {
            myAlert("Pasien Sudah Ditambahkan", "Perhatian!");
            return false;
        }


        $.post('<?php echo $this->createUrl('GetMenuDietPerJenisWaktu'); ?>', {
            cekTabelDetail: cekTabelDetail,
            jenismakanan_id: jenismakanan_id,
            alatmakan: alatmakan,
            jenisdiet_id: jenisdiet_id,
            pasien_id: pasien_id,
            pasienAdmisi: pasienAdmisi,
            pasienadmisi_id: pasienadmisi_id,
            pendaftaranId: pendaftaranId,
            jeniswaktu: jeniswaktu,
            pendaftaran_id: pendaftaran_id,
            menudiet_id: menudiet_id,
            jumlah: jumlah,
            urt: urt,
            ruangan_id: ruangan_id,
            instalasi_id: instalasi_id,
            kelaspelayanan_id: kelaspelayanan_id,
            menudiet_lain_id: menudiet_lain_id,
            tipediet_id: tipediet_id,
            alergi: alergi,
            keterangan: keterangan,
            jeniswaktudipilih_id:jeniswaktudipilih_id
        }, function(data) {

            console.log('jenisDietPasien' + data.jenisDietPasien);
            //        
            if (data.tr === '') {
                toastr.error("Data pada master bahan menu diet belum ada,\n\
                silahkan melakukan penambahan data pada master terlebih dahulu", "Perhatian!");
            } else {
                if (typeof data.jenisDietPasien === "undefined" && cekDetail(data.jenisDietPasien) === true) {
                    if (cekDetail(data.jenisDietPasien) === true) {
                        $('#tableMenuDiet tbody').append(data.tr);
                        $("#cc tbody tr:last .numbersOnly").maskMoney({
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": "",
                            "precision": 0,
                            "symbol": null
                        });
                        $("#tableMenuDiet").find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
                            "placement": "left"
                        });
                        hitungSemua();
                        clearFormDetailPesan();
                        renameInputRowBarang($("#tableMenuDiet"));
                    } else {
                        myAlert("Maaf, Nama Pasien '<b>" + data.namaPasien + "</b>' Jenis Diet '<b>" + data.jenisDiet + "</b>' <br/> Pada Tabel Sudah Ada");
                        clearFormDetailPesan();
                    }

                } else {
                    toastr.error("Data pada master bahan menu diet belum ada,\n\
                silahkan melakukan penambahan data pada master terlebih dahulu  ", "Perhatian!");
                    clearFormDetailPesan();
                }
            }
            //        

        }, 'json');

        //clearAll(1);
    }

    const pesanKembali = (id, admisiId, daftarId) => {     
        let cekTabelDetail = 0;
        $(".det_pendaftaran_id").each(function() {
            if (daftarId == $(this).attr('value')) {
                cekTabelDetail++;
            }
        });

        if (cekTabelDetail > 0) {
            myAlert("Pasien Sudah Ditambahkan", "Perhatian!");
            return false;
        }
        
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('pesanKembali'); ?>',
            data: {
                id: id,   
                admisiId: admisiId, 
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1) {
                    $("#tableMenuDiet > tbody").append(data.html);
                    $('.det_menudiet_id').last().val($('.menudiet_id'));
                    renameInputRowBarang($("#tableMenuDiet"));
                } else {
                    showToast('error', data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        
        return false;
    }
    
    function checkAll(att, obj) {
        if ($(obj).prop("checked") == true) {
            $("#tableMenuDiet > tbody").find('.cekList').each(function() {
                $(this).prop("checked", true);
                pilihMenuDiet($(this));
            });
        } else {
            $("#tableMenuDiet > tbody").find('.cekList').each(function() {
                $(this).prop("checked", false);
                pilihMenuDiet($(this));
            });
        }
    }

    function setClearMenuDiet() {
        if ($('#cek_tambah_menu').val() == '') {
            $('#menudiet_id').val('');
            $('#menuDiet').val('');
            $('#jenisdiet_id').val('');
            $('#URT').val('');
        } else {
            $('#dlg_menudiet_id').val('');
            $('#dlg_menudiet_nama').val('');
            $('#dlg_jenisdiet_id').val('');
            $('#dlg_urt').val('');
            $("#load_jeniswaktu").html('');
            $("#tableMenuDiet > tbody").html('');
        }
    }

    function setMenuDiet(data) {

        if ($('#cek_tambah_menu').val() == '') {
            $('#menudiet_id').val(data.menudiet_id);
            $('#menuDiet').val(data.jenismenudiet_nama);
            $('#jenisdiet_id').val(data.jenisdiet_id);
            $('#URT').val(data.ukuranrumahtangga);
        } else {
            $('#dlg_menudiet_id').val(data.menudiet_id);
            $('#dlg_menudiet_nama').val(data.jenismenudiet_nama);
            $('#dlg_jenisdiet_id').val(data.jenisdiet_id);
            $('#dlg_urt').val(data.ukuranrumahtangga);
            loadJenisWaktu($('#dlg_jenismakanan_id'));
            cekJenisWaktuTerpilih();
        }
        $('#dialogMenuDiet').dialog('close');
        return false;
    }

    function setMenuDietDlg(data) {

        // console.log('masuk menu diet dialog', data);

        $('#dlg_menudiet_id').val(data.menudiet_id);
        $('#dlg_menudiet_nama').val(data.jenismenudiet_nama);
        $('#dlg_jenisdiet_id').val(data.jenisdiet_id);
        $('#dlg_urt').val(data.ukuranrumahtangga);
        loadJenisWaktu($('#dlg_jenismakanan_id'));
        cekJenisWaktuTerpilih();

        $('#dialogMenuDiet1').dialog('close');
        return false;
    }

    function setMenuDietLain(data) {

        if ($('#cek_tambah_menu').val() == '') {
            $('#menudiet_lain_id').val(data.menudiet_id);
            $('#jenisdietlain').val(data.jenismenudiet_nama);
        } else {
            $('#dlg_menudiet_lain_id').val(data.menudiet_id);
            $('#dlg_menudiet_lain_nama').val(data.jenismenudiet_nama);
        }
        $('#dialogMenuDietLain').dialog('close');
        return false;
    }

    function cekAdaDetail() {

    }

    var is_checked = {};

    function inputMenuDiet() {
        var pasien_id = $('#pasien_id').val();
        var pendaftaran_id = $('#pendaftaran_id').val();
        var pasienadmisi_id = $('#pasienadmisi_id').val();
        var kelaspelayanan_id = $('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>').val();
        var menudiet_id = $('#menudiet_id').val();
        var jumlah = $('#jumlah').val();
        var alatmakan = $('#alatmakanan_id').val();
        var jenismakanan_id = $('#<?php echo CHtml::activeId($model, 'jenismakanan_id') ?>').val();
        var tipediet_id = $('#tipediet_id').val();
        var jeniswaktu = new Array();
        var pendaftaranId = new Array();
        var pasienAdmisi = new Array();
        var jenisdiet_id = $('#jenisdiet_id').val();
        var urt = $('#URT').val();
        var ruangan_id = $('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>').val();
        var instalasi_id = $('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>').val();
        var menudiet_lain_id = $('#menudiet_lain_id').val();
        var alergi = $('#GZPesanmenudietT_adaalergimakanan').val();
        var keterangan = $('#GZPesanmenudietT_keterangan_pesan').val();
        var i = 0;

        jenisdiet_id = $("#GZPesanmenudietT_jenisdiet_id").val();
        

        if (pendaftaran_id == '') {
            toastr.error("Data Pasien belum dipilih", "Perhatian!");
            return false;
        }

        var cekJenisWaktu = 0;
        $(".jeniswaktu:checked").each(function(index) {            
            jeniswaktu[index] = $(this).attr('value');
            cekJenisWaktu++;            
        });

        console.log('jenismakanan_id :', jenismakanan_id);
        console.log('menudiet_id :', menudiet_id);
        console.log('cekJenisWaktu :', cekJenisWaktu);
        console.log('tipediet_id :', tipediet_id);
        console.log('alatmakan :', alatmakan);
        console.log('jeniswaktu :', jeniswaktu);
        console.table('jeniswaktu :', jeniswaktu);

        //if (jenismakanan_id === '' || menudiet_id === '' || cekJenisWaktu < 1 || tipediet_id === '' || alatmakan === '') {
        if (jenisdiet_id === '' || cekJenisWaktu < 1) {
            toastr.error("Menu dan Jenis Waktu", "Perhatian!");
            return false;
        }

        var cekTabelDetail = 0;
        var cekJumlah = 0;
        $(".det_pendaftaran_id").each(function() {
            if (pendaftaran_id == $(this).attr('value')) {
                cekTabelDetail++;
            }
            if (pendaftaran_id > 1) {
                cekJumlah++;
            }
        });
        
        // if (cekJumlah > 0) {
        //     myAlert("Maaf, hanya boleh 1 pasien saja", "Perhatian!");
        //     return false;
        // }

        if (cekTabelDetail > 0) {
            myAlert("Pasien Sudah Ditambahkan", "Perhatian!");
            return false;
        }


        $.post('<?php echo $this->createUrl('getMenuDietJenisWaktu'); ?>', {
            cekTabelDetail: cekTabelDetail,
            jenismakanan_id: jenismakanan_id,
            alatmakan: alatmakan,
            jenisdiet_id: jenisdiet_id,
            pasien_id: pasien_id,
            pasienAdmisi: pasienAdmisi,
            pasienadmisi_id: pasienadmisi_id,
            pendaftaranId: pendaftaranId,
            jeniswaktu: jeniswaktu,
            pendaftaran_id: pendaftaran_id,
            menudiet_id: menudiet_id,
            jumlah: jumlah,
            urt: urt,
            ruangan_id: ruangan_id,
            instalasi_id: instalasi_id,
            kelaspelayanan_id: kelaspelayanan_id,
            menudiet_lain_id: menudiet_lain_id,
            tipediet_id: tipediet_id,
            alergi: alergi,
            keterangan: keterangan
        }, function(data) {

            console.log('jenisDietPasien' + data.jenisDietPasien);
            //        
            if (data.tr === '') {
                toastr.error("Data pada master bahan menu diet belum ada,\n\
                silahkan melakukan penambahan data pada master terlebih dahulu", "Perhatian!");
            } else {
                if (typeof data.jenisDietPasien === "undefined" && cekDetail(data.jenisDietPasien) === true) {
                    if (cekDetail(data.jenisDietPasien) === true) {
                        $('#tableMenuDiet tbody').append(data.tr);
                        $("#cc tbody tr:last .numbersOnly").maskMoney({
                            "defaultZero": true,
                            "allowZero": true,
                            "decimal": ",",
                            "thousands": "",
                            "precision": 0,
                            "symbol": null
                        });
                        $("#tableMenuDiet").find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
                            "placement": "left"
                        });
                        hitungSemua();
                        clearFormDetailPesan();
                        renameInputRowBarang($("#tableMenuDiet"));
                    } else {
                        myAlert("Maaf, Nama Pasien '<b>" + data.namaPasien + "</b>' Jenis Diet '<b>" + data.jenisDiet + "</b>' <br/> Pada Tabel Sudah Ada");
                        clearFormDetailPesan();
                    }

                } else {
                    toastr.error("Data pada master bahan menu diet belum ada,\n\
                silahkan melakukan penambahan data pada master terlebih dahulu  ", "Perhatian!");
                    clearFormDetailPesan();
                }
            }
            //        

        }, 'json');

        //clearAll(1);
    }

    function inputMenuDietByDialog() {
        var pasien_id = $('#dlg_pasien_id').val();
        var pendaftaran_id = $('#dlg_pendaftaran_id').val();
        var pasienadmisi_id = $('#dlg_pasienadmisi_id').val();
        var kelaspelayanan_id = $('#dlg_kelaspelayanan_id').val();
        var menudiet_id = $('#dlg_menudiet_id').val();
        var menudiet_lain_id = $('#dlg_menudiet_lain_id').val();
        var jumlah = $('#dlg_jumlah').val();
        var alatmakan = $('#dlg_alatmakanan_id').val();
        var jenismakanan_id = $('#dlg_jenismakanan_id').val();
        var tipediet_id = $('#dlg_tipediet_id').val();
        var jeniswaktu = new Array();
        var jenisdiet_id = $('#dlg_jenisdiet_id').val();
        var urt = $('#dlg_urt').val();
        var alergi = $("#dlg_alergi").val();
        var keterangan = $("#dlg_keterangan").val();
        var i = 0;
        var cekTabelDetail = 0;

        $(".det_pendaftaran_id").each(function() {
            if (pendaftaran_id == $(this).attr('value')) {
                cekTabelDetail++;
            }
        });

        if (pendaftaran_id == '') {
            toastr.error("Data Pasien belum dipilih", "Perhatian!");
            return false;
        }

        var cekJenisWaktu = 0;
        $(".dis:checked").each(function(index) {
            jeniswaktu[index] = $(this).attr('value');
            cekJenisWaktu++;
        });

        //if (jenismakanan_id === '' || menudiet_id === '' || cekJenisWaktu < 1 || tipediet_id === '' || alatmakan === '') {
        if (jenisdiet_id === '' || cekJenisWaktu < 1 ) {
            toastr.error("Menu dan Jenis Waktu", "Perhatian!");
            return false;
        }


        $.post('<?php echo $this->createUrl('getMenuDietJenisWaktu'); ?>', {
            cekTabelDetail: cekTabelDetail,
            jenismakanan_id: jenismakanan_id,
            alatmakan: alatmakan,
            jenisdiet_id: jenisdiet_id,
            pasien_id: pasien_id,
            pasienadmisi_id: pasienadmisi_id,
            jeniswaktu: jeniswaktu,
            pendaftaran_id: pendaftaran_id,
            menudiet_id: menudiet_id,
            jumlah: jumlah,
            urt: urt,
            kelaspelayanan_id: kelaspelayanan_id,
            tipediet_id: tipediet_id,
            menudiet_lain_id: menudiet_lain_id,
            alergi: alergi,
            keterangan: keterangan,
        }, function(data) {

            console.log('jenisDietPasien' + data.jenisDietPasien);
            //        
            if (data.tr === '') {
                toastr.error("Data pada master bahan menu diet belum ada,\n\
                silahkan melakukan penambahan data pada master terlebih dahulu ", "Perhatian!");
            } else {

                if (typeof data.jenisDietPasien === "undefined" && cekDetail(data.jenisDietPasien) === true) {

                    if (data.sukses == 1) {
                        $('#tableMenuDiet > tbody').find('tr:last[class=' + pendaftaran_id + ']').after(data.tr);
                        $("#tableMenuDiet").find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
                            "placement": "left"
                        });
                        hitungSemua();
                        clearFormDetailPesanByDialog();
                        renameInputRowBarang($("#tableMenuDiet"));
                        changeRowspan((parseInt(data.totalJenisWaktu) + parseInt(data.cekTabelDetail)), pendaftaran_id);
                    } else {
                        toastr.error(data.pesan, "Perhatian!");
                    }
                } else {
                    toastr.error("Data pada master bahan menu diet belum ada,\n\
                silahkan melakukan penambahan data pada master terlebih dahulu ", "Perhatian!");
                    clearFormDetailPesan();
                }
            }
        }, 'json');

        //clearAll(1);
    }

    function ubahMenuDietByDialog() {
        var menudiet_id = $("#dlg_menudiet_id").val();
        var jenisdiet_id = $("#dlg_jenisdiet_id").val();
        var alatmakan = $('#dlg_alatmakanan_id').val();
        var jenismakanan_id = $("#dlg_jenismakanan_id").val();
        var jeniswaktu_id = $("#dlg_jeniswaktu_id").val();
        var menudiet_lain_id = $("#dlg_menudiet_lain_id").val();
        var menudiet_lain_nama = $("#dlg_menudiet_lain_nama").val();
        var adaalergimakanan = $("#dlg_adaalergimakanan").val();
        var keterangan = $("#dlg_keterangan").val();
        var rowdata = $("#dlg_rowdata").val();
        var pendaftaran_id = $("#dlg_pendaftaran_id").val();
        var tipediet_id = $('#dlg_tipediet_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('ubahDetailPerMenu'); ?>',
            data: {
                formdata: $("#tambah-menu-diet").find('input, select, textarea').serialize()
            },
            dataType: "json",
            success: function(data) {
                console.log()
                //        
                var cekJenisWaktu = 0;
                $(".jeniswaktu").each(function(index) {
                    if ($(this).prop('checked') == true) {
                        jeniswaktu[index] = $(this).attr('value');
                        cekJenisWaktu++;
                    }
                });

                //if (jenismakanan_id === '' || menudiet_id === '' || jeniswaktu_id == '' || tipediet_id === '' || alatmakan === '') {
                if (jenisdiet_id === '' || jeniswaktu_id == '') {
                    toastr.error("Menu dan Jenis Waktu tidak boleh kosong", "Perhatian!");
                    return false;
                } else if (data.detail === '') {
                    toastr.error("Data pada master bahan menu diet belum ada,\n\
                    silahkan melakukan penambahan data pada master terlebih dahulu ", "Perhatian!");
                } else {
                    if (typeof data.jenisDietPasien === "undefined" && cekDetail(data.jenisDietPasien) === true) {

                        if (data.sukses == 1) {

                            $('#tableMenuDiet > tbody').find('tr[class=' + pendaftaran_id + '][rowdata=' + rowdata + ']').each(function() {
                                $(this).find('.det_jenismakanan_id').val(data.jenismakanan_id);
                                $(this).find('.lbl-jenismakan').html(data.jenismakanan_nama);

                                $(this).find('.det_menudiet_id').val(data.menudiet_id);
                                $(this).find('.det_jenisdiet_id').val(data.jenisdiet_id);
                                $(this).find('.lbl-jenismenudiet').html(data.jenisdiet_nama);

                                $(this).find('.det_alatmakan_id').val(data.alatmakanan_id);
                                $(this).find('.lbl-alatmakanan_nama').html(data.alatmakanan_nama);
                                $(this).find('.keterangan').val(data.keterangan);
                                $(this).find('.adaalergimakanan').val(data.adaalergimakanan);

                                $(this).find('.det_jeniswaktu_id').val(data.jeniswaktu_id);
                                $(this).find('.lbl-jeniswaktu').html(data.jeniswaktu_nama);
                                $(this).find('.menudiet_lain_id').val(data.menudiet_lain_id);
                                $(this).find('.lbl-jenismenudietlain').html(data.menudiet_lain_nama);
                                $(this).find('.urldetail').html(data.detail);

                                $(this).find('.lbl-tipediet_id').html(data.tipediet_nama);
                                $(this).find('.det_tipediet_id').val(data.tipediet_id);
                            });

                            $("#dialogTambahMenu").dialog("close");
                            $("#tambah-menu-diet").html("");

                        } else {
                            showToast('error', data.pesan);
                        }
                    } else {
                        toastr.error("Data pada master bahan menu diet belum ada,\n\
                        silahkan melakukan penambahan data pada master terlebih dahulu ", "Perhatian!");
                        clearFormDetailPesan();
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hapusDetailPerMenu(obj) {
        var cekRow = $(obj).parents("tr").find('td').attr('rowspan');
        var pendaftaran_id = $(obj).parents("tr").find('.det_pendaftaran_id').val();
        var riwayatpesan_id = $(obj).parents("tr").find(".det_pesanmenudiet_riwayat_id").val();
        var pesanmenudetail_id = $(obj).parents("tr").find(".det_pesanmenudetail_id").val();

        var td = '';
        var tdbtn = '';

        var total = parseInt($('#tableMenuDiet > tbody').find('tr[class=' + pendaftaran_id + ']').length);

        myConfirm("Apakah Anda yakin ingin membatalkan pemesanan ini?", "Perhatian!", function(r) {
            if (r) {
                if (typeof cekRow === 'undefined') {
                    $(obj).parents("tr").detach();
                    changeRowspan((total - 1), pendaftaran_id);
                } else {
                    $(obj).parents("tr").find('td').each(function() {
                        if ($(this).hasClass('aturbaris')) {
                            if ($(this).hasClass('tombolaksi')) {
                                tdbtn += "<td class='aturbaris tombolaksi' rowspan='" + (total - 1) + "' style='vertical-align: middle;text-align: center;'>" + $(this).html() + "</td>";
                            } else if ($(this).hasClass('cekbox')) {
                                td += "<td class='aturbaris' rowspan='" + (total - 1) + "'  style='vertical-align: middle;text-align: center;'>" + $(this).html() + "</td>";
                            } else {
                                td += "<td class='aturbaris' rowspan='" + (total - 1) + "'  >" + $(this).html() + "</td>";
                            }
                        }
                    });

                    $(obj).parents("tr").detach();

                    $('#tableMenuDiet > tbody').find('tr:first[class=' + pendaftaran_id + '] > td:first ').before(td);
                    $('#tableMenuDiet > tbody').find('tr:first[class=' + pendaftaran_id + '] > td:last ').after(tdbtn);

                    changeRowspan((total - 1), pendaftaran_id);
                }
                if (riwayatpesan_id != '') {
                    $("#tabelpesandiet-hapus > tbody").append("<tr><td><input type='hidden' value='" + riwayatpesan_id + "' name='deleteriwayat[]'></td></tr>");
                }
                if (pesanmenudetail_id != '') {
                    $("#tabelpesandiet-det-hapus > tbody").append("<tr><td><input type='hidden' value='" + pesanmenudetail_id + "' name='deletedetail[]'></td></tr>");
                }
                renameInputRowBarang($("#tableMenuDiet"));
            }
        });
    }

    function changeRowspan(total, pendaftaran_id) {
        $('#tableMenuDiet > tbody').find('tr:first[class=' + pendaftaran_id + ']').find('td').each(function() {
            if (typeof $(this).attr('rowspan') !== 'undefined') {
                $(this).attr("rowspan", total);
            }
        });
    }

    function clearFormDetailPesan() {
        $("#formdetail-pemesananmenu").find('select:not(.permanent), input:text:not(.permanent), textarea:not(.permanent)').val('');
        $("#table-detailwaktu > tbody ").html('');
        $("#jumlah").val(1);
        $("#formdetail-pemesananmenu").find();
    }

    function clearFormDetailPesanByDialog() {
        $("#tambah-menu-diet").find('select:not(.permanent), input:not(.permanent), textarea:not(.permanent)').val('');
        //$("#load_jeniswaktu").html('');
        $("#dlg_jumlah").val(1);
        $("#dialogTambahMenu").dialog("close");
    }

    function clearPilihPasien() {
        $("#jenistarif_id").val('');
        $("#penjamin_id").val('');
        $("#pasien_id").val('');
        $("#pasienadmisi_id").val('');
        $("#pendaftaran_id").val('');
        $("#namaPasien").val('');
    }

    function generateFormTambahMenu(obj, jenis) {
        var pasienadmisi_id = $(obj).parents("tr").find('.det_pasienadmisi_id').val();
        var kelaspelayanan_id = $(obj).parents("tr").find('.det_kelaspelayanan_id').val();
        var tipediet_id = $(obj).parents("tr").find('.det_tipediet_id').val();
        var tipediet_nama = $("#tipediet_nama").val();
        var rowdata = $(obj).parents("tr").attr('rowdata');
        var jenismakanan_id = $(obj).parents("tr").find('.det_jenismakanan_id').val();
        var menudiet_id = $(obj).parents("tr").find('.det_menudiet_id').val();
        var jenisdiet_id = $(obj).parents("tr").find('.det_jenisdiet_id').val();
        var alatmakanan_id = $(obj).parents("tr").find('.det_alatmakan_id').val();
        var jeniswaktu_id = $(obj).parents("tr").find('.det_jeniswaktu_id').val();
        var menudiet_lain_id = $(obj).parents("tr").find('.menudiet_lain_id').val();
        var alergi = $(obj).parents("tr").find('.adaalergimakanan').val();
        var keterangan = $(obj).parents("tr").find('.keterangan').val();

        console.log('tipediet_id', tipediet_id);

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('generateForm'); ?>',
            data: {
                pasienadmisi_id: pasienadmisi_id,
                kelaspelayanan_id: kelaspelayanan_id,
                tipediet_id: tipediet_id,
                tipediet_nama: tipediet_nama,
                rowdata: rowdata,
                jenis: jenis,
                jenismakanan_id: jenismakanan_id,
                menudiet_id: menudiet_id,
                jenisdiet_id: jenisdiet_id,
                alatmakanan_id: alatmakanan_id,
                menudiet_lain_id: menudiet_lain_id,
                alergi: alergi,
                keterangan: keterangan,
                jeniswaktu_id: jeniswaktu_id
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1) {
                    if (jenis == 'tambah') {
                        $(".judul-tambah").html("Tambah Menu Diet Lain");
                    } else {
                        $(".judul-tambah").html("Ubah Menu Diet");
                    }


                    $("#dialogTambahMenu").dialog('open');
                    $("#tambah-menu-diet").html(data.html);

                    $("#tambah-menu-diet").find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
                        "placement": "top"
                    });

                    $("#tambah-menu-diet").find('.numbers-only').keyup(function(e) {
                        setNumbersOnly(this);
                    });
                    
                    //loadMenuDiet($("#dlg_jenisdiet_id"), menudiet_id);
                    if (jenis == 'ubah') {                            
                        cekJenisWaktuTerpilihByDropdown();
                        refreshDialogMenuDiet1();
                    }else if(jenis == 'tambah'){
                        loadJenisWaktuBaru();
                    }
                } else {
                    showToast('error', data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function pilihMenuDiet(obj) {
        var cek = $(obj).prop("checked");
        var pendaftaran_id = $(obj).attr('value');
        if (cek == true) {
            $('#tableMenuDiet > tbody').find('tr:[class=' + pendaftaran_id + ']').find('.ceklis_baris').prop("checked", true);
            $('#tableMenuDiet > tbody').find('tr:[class=' + pendaftaran_id + ']').find('.det_alatmakan_id').addClass("required");

            var cekAll = $('#tableMenuDiet > tbody ').find('.cekList:checked').length;
            var cekTr = $('#tableMenuDiet > tbody ').find('.cekList').length;

            if (cekAll == cekTr) {
                $("#checkListUtama").prop("checked", true);
            }
        } else {
            $("#checkListUtama").prop("checked", false);
            $('#tableMenuDiet > tbody').find('tr:[class=' + pendaftaran_id + ']').find('.ceklis_baris').prop("checked", false);
            $('#tableMenuDiet > tbody').find('tr:[class=' + pendaftaran_id + ']').find('.det_alatmakan_id').removeClass("required");
        }

        hitungSemua();
    }

    function hitungSemua() {
        var noUrut = 1;
        var jumlah = $('.cekList:checked').length;

        $('#<?php echo CHtml::activeId($model, 'totalPesan') ?>').val(jumlah);
    }

    function cekDetail(jenisDietPasien) {
        x = true;

        $('.jenisDiet').each(function() {
            if ($(this).val() == jenisDietPasien) {
                x = false;
            }
        });

        return x;
    }

    function clearAll(code) {
        var tempRuangan = $('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>').val();
        var tempInstalasi = $('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>').val();
        $('#fieldsetMenuDiet div').find('input,select').each(function() {
            if ($(this).attr('type') == 'checkbox') {

            } else {
                $(this).val('');
                $("#GZPesanmenudietT_instalasitampil").val(tempInstalasi);
                $("#GZPesanmenudietT_ruangantampil").val(tempRuangan);
            }
        });
        if (!jQuery.isNumeric(code)) {
            $('#fieldsetMenuDiet #tableMenuDiet tbody').find('tr').each(function() {
                $(this).remove();
            });
        }
        if (jQuery.isNumeric(tempRuangan)) {
            //            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
            //                   //data: "GZInfokunjunganriV[ruangan_id]="+tempRuangan
            //                   data: "GZInfopasienmasukkamarV[ruangan_id]="+tempRuangan 
            //        
            //            });
        }
        $('#jumlah').val(1);
        $('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>').val(tempRuangan);
        $('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>').val(tempInstalasi);
    }

    function dialogMenuPasien() {
        //        ruangan = $('#<?php //echo CHtml::activeId($model, 'ruangan_id')                           
                                ?>').val();
        //        if(!jQuery.isNumeric(ruangan)){
        //            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
        //                    //data: $("#dialogPasien :input").serialize() + "&" + "GZInfokunjunganriV[ruangan_id]=0"
        //                    data: $("#dialogPasien :input").serialize() + "&" + "GZInfopasienmasukkamarV[ruangan_id]=0"
        //            });
        //        }
        //        else{
        //            refreshDialogPasien();
        //            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
        //                    //data: $("#dialogPasien :input").serialize() + "&" + "GZInfokunjunganriV[ruangan_id]="+ruangan
        //                    data: $("#dialogPasien :input").serialize() + "&" + "GZInfopasienmasukkamarV[ruangan_id]="+ruangan
        //            });
        //        }
        //        if(!jQuery.isNumeric(ruangan)){
        //            myAlert('Isi ruangan terlebih dahulu');
        //            return false;
        //        }else{
        //            $('#dialogPasien').dialog('open');
        //        }
        var kelaspelayanan_id = $("#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>").val();
        var temp_ins_id = $("#temp_instalasi_id").val();
        var temp_ru_id = $("#temp_ruangan_id").val();
        var def = 'ada';

        if (kelaspelayanan_id != '' && temp_ins_id != '' && temp_ru_id != '') {
            def = '';
        }

        $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
            data: {
                "GZInfopasienmasukkamarV[instalasi_id]": temp_ins_id,
                "GZInfopasienmasukkamarV[ruangan_id]": temp_ru_id,
                "GZInfopasienmasukkamarV[kelaspelayanan_id]": kelaspelayanan_id,
                "GZInfopasienmasukkamarV[default]": def,
            }
        });

        $('#dialogPasien').dialog('open');
    }
    
    function cekKelasKunjungan(obj) {
        var kelaspelayanan_id = $('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>').val();
        var tipediet_id = $(obj).val();
        if(kelaspelayanan_id == 3 || kelaspelayanan_id == 4 || kelaspelayanan_id == 5){
            if(tipediet_id == 230 || tipediet_id == 231){
                $("#formdetail-pemesananmenu").find('#jeniswaktu_0').prop("checked", false);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_1').prop("checked", true);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_2').prop("checked", true);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_3').prop("checked", true);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_4').prop("checked", true);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_5').prop("checked", true);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_6').prop("checked", true);
            }else if (tipediet_id == 227){
                $("#formdetail-pemesananmenu").find('#jeniswaktu_0').prop("checked", true);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_1').prop("checked", false);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_2').prop("checked", false);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_3').prop("checked", false);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_4').prop("checked", false);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_5').prop("checked", false);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_6').prop("checked", false);
            }else{
                $("#formdetail-pemesananmenu").find('#jeniswaktu_0').prop("checked", false);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_1').prop("checked", true);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_2').prop("checked", false);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_3').prop("checked", true);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_4').prop("checked", true);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_5').prop("checked", false);
                $("#formdetail-pemesananmenu").find('#jeniswaktu_6').prop("checked", true);
            }
        }else{
            $("#formdetail-pemesananmenu").find('#jeniswaktu_0').prop("checked", false);
            $("#formdetail-pemesananmenu").find('#jeniswaktu_1').prop("checked", true);
            $("#formdetail-pemesananmenu").find('#jeniswaktu_2').prop("checked", false);
            $("#formdetail-pemesananmenu").find('#jeniswaktu_3').prop("checked", true);
            $("#formdetail-pemesananmenu").find('#jeniswaktu_4').prop("checked", false);
            $("#formdetail-pemesananmenu").find('#jeniswaktu_5').prop("checked", false);
            $("#formdetail-pemesananmenu").find('#jeniswaktu_6').prop("checked", true);
        }
    }

    function batal(obj) {
        if (!confirm('Apakah anda yakin akan menghapus jenis waktu ini ?')) {
            return false;
        } else {
            $(obj).parents('tr').remove();
            rename();
        }
    }

    function deleteRecord(id) {
        var id = id;
        //var url = '<?php //echo $url."/delete";                           
                        ?>';
        myConfirm('Yakin Akan Menghapus Data Pemesanan ini ?', 'Perhatian!', function(r) {
            if (r) {
                /*$.post(url, {id: id},
                 function(data){
                 if(data.status == 'proses_form'){
                 $.fn.yiiGridView.update('detectability-m-grid');
                 }else{
                 myAlert('Data Gagal di Hapus')
                 }
                 },"json");*/
                return false;
            }
        });
    }

    function cariPasien() {
        var instalasi_id = $("#GZPesanmenudietT_instalasi_id").val();
        var ruangan_id = $("#GZPesanmenudietT_ruangan_id").val();
        var ruangan_nama = $("#GZPesanmenudietT_ruangan_id option:selected").text();
        var no_pendaftaran = $('#GZPesanmenudietT_no_pendaftaran').val();
        var no_rekam_medik = $('#GZPesanmenudietT_no_rekam_medik').val();
        var nama_pasien = $('#GZPesanmenudietT_nama_pasien').val();
        if (instalasi_id != '' && ruangan_id != '') {
            setTimeout(function() {
                var cekTabelDiet = $("#tableMenuDiet > tbody > tr").length;
                var jumDet = $("#tableMenuDiet > tbody > tr").length;

                if (jumDet > 0) {
                    myConfirm("Data pada tabel pemesanan menu diet pasien, sudah terisi. Apakah Anda yakin ingin mengulang data inputan ini ?", "Perhatian!", function(r) {
                        if (r) {
                            loadPasienPulang(instalasi_id, ruangan_id, no_pendaftaran, no_rekam_medik, nama_pasien);
                            loadPasienBaruInap(instalasi_id, ruangan_id, no_pendaftaran, no_rekam_medik, nama_pasien);
                            $("#namaRuangan").html(ruangan_nama);
                            $("#tableMenuDiet > tbody").html('');

                            $("#temp_instalasi_id").val(instalasi_id);
                            $("#temp_ruangan_id").val(ruangan_id);

                        }
                    });
                } else {
                    loadPasienPulang(instalasi_id, ruangan_id, no_pendaftaran, no_rekam_medik, nama_pasien);
                    loadPasienBaruInap(instalasi_id, ruangan_id, no_pendaftaran, no_rekam_medik, nama_pasien);
                    $("#namaRuangan").html(ruangan_nama);

                    $("#temp_instalasi_id").val(instalasi_id);
                    $("#temp_ruangan_id").val(ruangan_id);
                }

            }, 500);
        } else {

            $("#namaRuangan").html('');
            myAlert(" Instalasi, Ruangan dan Bentuk Diet harus dipilih ");
            return false;
        }
    }

    function cariPasienUbah() {
        var instalasi_id = $("#GZPesanmenudietT_instalasi_id").val();
        var ruangan_id = $("#GZPesanmenudietT_ruangan_id").val();
        var ruangan_nama = $("#GZPesanmenudietT_ruangan_id option:selected").text();
        //        var tipediet_id   = $("#GZPesanmenudietT_tipediet_id").val();   
        //        var tipediet_nama = $("#GZPesanmenudietT_tipediet_id option:selected").text();   

        $("#namaRuangan").html(ruangan_nama);

        $("#temp_instalasi_id").val(instalasi_id);
        $("#temp_ruangan_id").val(ruangan_id);
        //        $("#tipediet_id").val(tipediet_id);
        //        $("#tipediet_nama").val(tipediet_nama);

    }

    function loadRiwayatPesan() {
        var pesanmenudiet_id = '<?php echo $model->pesanmenudiet_id; ?>';

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadRiwayatMenuDiet'); ?>',
            data: {
                pesanmenudiet_id: pesanmenudiet_id
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1) {
                    $("#tableMenuDiet > tbody").html(data.html);
                    renameInputRowBarang($("#tableMenuDiet"));
                    <?php if(isset($_GET['id'])) : ?>
                        $('#pasien_id').val(data.biodata.pasien_id);
                        $('#pendaftaran_id').val(data.biodata.pendaftaran_id);
                        $('#pasienadmisi_id').val(data.biodata.pasienadmisi_id);
                        $('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>').val(data.biodata.kelaspelayanan_id);
                        $('#GZPendaftaranT_nama_pasien').val(data.biodata.nama_pasien);
                    <?php endif ?>
                } else {
                    showToast('error', data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }



    function loadPasienPulang(instalasi_id, ruangan_id, no_pendaftaran, no_rekam_medik, nama_pasien) {
        $.fn.yiiGridView.update('pasienpulang-m-grid', {
            data: {
                "GZPendaftaranT[instalasi_id]": instalasi_id,
                "GZPendaftaranT[ruangan_id]": ruangan_id,
                "GZPendaftaranT[no_pendaftaran]": no_pendaftaran,
                "GZPendaftaranT[no_rekam_medik]": no_rekam_medik,
                "GZPendaftaranT[nama_pasien]": nama_pasien,
            }
        });
    }

    function loadPasienBaruInap(instalasi_id, ruangan_id, no_pendaftaran, no_rekam_medik, nama_pasien) {
        $.fn.yiiGridView.update('pasienbaru-m-grid', {
            data: {
                "GZPendaftaranT[instalasi_id]": instalasi_id,
                "GZPendaftaranT[ruangan_id]": ruangan_id,
                "GZPendaftaranT[no_pendaftaran]": no_pendaftaran,
                "GZPendaftaranT[no_rekam_medik]": no_rekam_medik,
                "GZPendaftaranT[nama_pasien]": nama_pasien,
            }
        });
    }

    function loadJenisDiet(obj, dialog) {
        $("#dlg_menudiet_id").val('');
        $("#dlg_jenisdiet_id").val('');
        $("#dlg_menudiet_nama").val('');
        $("#dlg_urt").val('');

        var jenis = $("#dlg_jenis").val();

        if (jenis == 'ubah') {
            $("#dlg_jeniswaktu_id").html('');
        }
    }

    function loadJenisWaktu(obj) {
        var jenismakanan_id = $(obj).val();
        var jenisdiet_id = $("#dlg_jenisdiet_id").val();
        var menudiet_id = $("#dlg_menudiet_id").val();
        var jenis = $("#dlg_jenis").val();

        if (jenis == 'tambah') {
            var url = '<?php echo $this->createUrl('/actionAjax/getJenisWaktuForCheckBox'); ?>';
        } else {
            var url = '<?php echo $this->createUrl('/actionAjax/getJenisWaktuForDrop'); ?>';
        }

        if (jenisdiet_id != '' && menudiet_id != '') {
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    jenismakanan_id: jenismakanan_id,
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses == 1) {
                        if (jenis == 'tambah') {
                            $("#load_jeniswaktu").html(data.checkbox);
                            cekJenisWaktuTerpilih();
                        } else {
                            $("#dlg_jeniswaktu_id").html(data.drop);
                            cekJenisWaktuTerpilihByDropdown();
                        }
                    } else {
                        showToast('error', data.pesan);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            //$("#load_jeniswaktu").html('');
            // $("#dlg_menudiet_id").val('');
            // $("#dlg_jenidiet_id").val('');
            // $("#dlg_menudiet_nama").val('');
            // $("#dlg_urt").val('');
        }
    }
    
    function loadJenisWaktuBaru() {
        var jenismakanan_id = $("#dlg_jenismakanan_id").val();
        var jenisdiet_id = $("#dlg_jenisdiet_id").val();
        var menudiet_id = $("#dlg_menudiet_id").val();
        
        var url = '<?php echo $this->createUrl('/actionAjax/getJenisWaktuForCheckBox'); ?>';
        

        if (jenisdiet_id != '') {
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    jenismakanan_id: jenismakanan_id,
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses == 1) {
                        $("#load_jeniswaktu").html(data.checkbox);
                        cekJenisWaktuTerpilih();
                    } else {
                        showToast('error', data.pesan);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } 
    }

    function loadAlatMakan() {
        var kelaspelayanan_id = $("#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/actionDynamic/getAlatMakanan'); ?>',
            data: {
                kelaspelayanan_id: kelaspelayanan_id,
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1) {
                    $("#alatmakanan_id").html(data.drop);
                } else {
                    showToast('error', data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function loadMenuDiet(obj, menudiet_id) {
        var jenisdiet_id = $(obj).val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getMenuDiet'); ?>',
            data: {
                jenisdiet_id: jenisdiet_id,
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1) {
                    $(obj).parents().parents().find(".menudiet_id").html(data.drop);
                    $(obj).parents().parents().find(".menudiet_id").val(menudiet_id);
                } else {
                    showToast('error', data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }

    function cekJenisWaktuTerpilih() {
        var id = $("#dlg_pendaftaran_id").val();
        var pilih = [];

        $("#tableMenuDiet > tbody > tr:not([class!=" + id + "])").each(function() {
            var jenismakanan_id = $(this).find('.det_jenismakanan_id').val();
            var jenisdiet_id = $(this).find('.det_jenisdiet_id').val();
            var jeniswaktu_id = $(this).find('.det_jeniswaktu_id').val();

            //pilih[jenismakanan_id + '-' + jenisdiet_id + '-' + jeniswaktu_id] = 'ada';
            pilih[jenisdiet_id + '-' + jeniswaktu_id] = 'ada';
        });

        var dlg_jenismakanan_id = $("#dlg_jenismakanan_id").val();
        var dlg_jenisdiet_id = $("#dlg_jenisdiet_id").val();
        $("#load_jeniswaktu").find('input:checkbox').each(function() {
            var dlg_jeniswaktu_id = $(this).attr('value');
//            if (typeof pilih[dlg_jenismakanan_id + '-' + dlg_jenisdiet_id + '-' + dlg_jeniswaktu_id] != 'undefined') {
            // if (typeof pilih[dlg_jenisdiet_id + '-' + dlg_jeniswaktu_id] != 'undefined') {
            //     $(this).attr('disabled', true);
            //     $(this).prop("checked", true);
            //     $(this).removeClass("dis");
            // } else {
                $(this).removeAttr('disabled');
                $(this).addClass("dis");
            // }
        });
    }

    function cekJenisWaktuTerpilihByDropdown() {
        var id = $("#dlg_pendaftaran_id").val();
        var pilih = [];

        $("#tableMenuDiet > tbody > tr[class=" + id + "]").each(function() {
            var jenismakanan_id = $(this).find('.det_jenismakanan_id').val();
            var jenisdiet_id = $(this).find('.det_jenisdiet_id').val();
            var jeniswaktu_id = $(this).find('.det_jeniswaktu_id').val();

            pilih[jenismakanan_id + '-' + jenisdiet_id + '-' + jeniswaktu_id] = 'ada';
        });
        console.log(pilih);
        var dlg_jenismakanan_id = $("#dlg_jenismakanan_id").val();
        var dlg_jenisdiet_id = $("#dlg_jenisdiet_id").val();
        var dlg_jeniswaktutemp_id = $("#dlg_jeniswaktutemp_id").val();
        $("#dlg_jeniswaktu_id").find('option').each(function() {
            var option = $(this).attr('value');
            if (dlg_jeniswaktutemp_id != option) {
                if (typeof pilih[dlg_jenismakanan_id + '-' + dlg_jenisdiet_id + '-' + option] === 'undefined') {

                } else {
                    $(this).remove();
                }
            }
        });
    }

    function cekForm() {
        var pendaftaran_id = $('#pendaftaran_id').val();
        
        if (requiredCheck($("#gzpesanmenudiet-t-form"))) {

            var count = $("#tableMenuDiet > tbody > tr").length;

            $("#tableMenuDiet > tbody > tr").each(function() {
                if ($(this).find('.cekList').prop("checked") == false) {
                    $(this).parents("#tableMenuDiet").find('tbody > tr[class=' + $(this).find('.cekList').attr('value') + ']').remove();
                } else {

                }
            });

            if (count == 0) {
                toastr.warning("List menu diet yang akan dipesan belum ditambahkan", "Perhatian!");
                return false;
            }

            var is_ubah = <?= isset($_GET['id']) ? '1' : '0' ?>;

            if(is_ubah == '1') {
                $("#gzpesanmenudiet-t-form").submit();
                disableOnSubmit($("#btn_data_submit"));
            } else {
                $.post('<?= $this->createUrl('cekPemesanan') ?>', {
                    pendaftaran_id:pendaftaran_id
                }, function(data){
                    console.log(data);
                    if(data.sudahpesan == 0) {
                        // jika belum ada pemesanan
                        $("#gzpesanmenudiet-t-form").submit();
                        disableOnSubmit($("#btn_data_submit"));
                    } else {
                        myAlert('Pasien sudah dilakukan pemesanan menu diet, jika ada perubahan silahkan menggunakan fitur edit');
                        return false;
                    }
                
                }, 'json');
            }


        }
    }

    function cariPasienUbah() {
        var instalasi_id = $("#GZPesanmenudietT_instalasi_id").val();
        var ruangan_id = $("#GZPesanmenudietT_ruangan_id").val();
        var ruangan_nama = $("#GZPesanmenudietT_ruangan_id option:selected").text();
        //        var tipediet_id   = $("#GZPesanmenudietT_tipediet_id").val();   
        //        var tipediet_nama = $("#GZPesanmenudietT_tipediet_id option:selected").text();   

        $("#namaRuangan").html(ruangan_nama);

        $("#temp_instalasi_id").val(instalasi_id);
        $("#temp_ruangan_id").val(ruangan_id);
        //        $("#tipediet_id").val(tipediet_id);
        //        $("#tipediet_nama").val(tipediet_nama);

    }

    function formUbahDisabled() {
        $("#form-cari-pasien").find('input, select, textarea').attr('disabled', true);
        $("#form-cari-pasien").find('.add-on').hide();
    }

    $(document).ready(function() {
        cekDisabled($('#gzpesanmenudiet-t-form'));
        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', '.ui-dialog-content', function() {
            cekDisabled('form');
        });

        <?php if (!isset($_GET['sukses']) && !empty($model->pesanmenudiet_id)) { ?>
            cariPasienUbah();
            formUbahDisabled();
            loadRiwayatPesan()
        <?php } ?>

        loadAlatMakan();
        jeniswaktu();


    });
</script>