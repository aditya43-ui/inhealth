<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">

    function verifikasi(obj, status) {
        $(obj).parents('tr').find('input[name$="[is_verifkasiapoteker]"]').val(status);
        if(status == 1) {
            $(obj).parents('tr').find('.statusVerifikasi').val('Di Setujui');
        } else if(status == 0) {
            $(obj).parents('tr').find('.statusVerifikasi').val('Tidak Di Setujui');
        } else {
            $(obj).parents('tr').find('.statusVerifikasi').val('Batal Verifikasi');
        }
    }

    var inv_petugas = null;
    var inv_jenis_layanan = null;
    var inv_tempat_layanan = null;


    function setObatDariApi(kode_obat, sumberdana, stok, hargajual, stFornas, satuan, nama, HPP) {
        hargajual = hargajual.replace(".", ",");
        console.log('cek ini ' + hargajual);
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatJalan/reseptur/getObat'); ?>',
            data: {
                kode_obat: kode_obat,
                sumberdana: sumberdana,
                stfornas:stFornas,
                harga_jual:hargajual,
                satuan:satuan,
                nama:nama,
                HPP:HPP
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if(data.sukses == 1) {
                    if(data.obatalkes.sukses == 1 && data.sumberdana.sukses == 1) {
                        var row_baru = $("#is_rowbaru").val();
                        pilihObatalkes(
                            data.obatalkes.id, 
                            data.obatalkes.nama, 
                            stok, 
                            hargajual, 
                            data.obatalkes.harganetto, 
                            data.obatalkes.kode, 
                            data.sumberdana.id, 
                            sumberdana, 
                            data.obatalkes.satuankecil_id, 
                            data.obatalkes.satuankecil_nama, 
                            row_baru
                        );
                    } else {
                        myAlert(data.pesan);
                    }
                    
                    $("#dialogOaAPI").dialog("close");
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setObatDariApiUntukAutoComplete(kode_obat, sumberdana, stok, hargajual, stfornas, satuan, nama, HPP) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatJalan/reseptur/getObat'); ?>',
            data: {
                kode_obat: kode_obat,
                sumberdana: sumberdana,
                stfornas:stfornas,
                harga_jual:hargajual,
                satuan:satuan,
                nama:nama,
                HPP:HPP
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if(data.sukses == 1) {
                    if(data.obatalkes.sukses == 1 && data.sumberdana.sukses == 1) {
                        var row_baru = $("#is_rowbaru").val();
                        pilihObatalkes(
                            data.obatalkes.id, 
                            data.obatalkes.nama, 
                            stok, 
                            hargajual, 
                            data.obatalkes.harganetto, 
                            data.obatalkes.kode, 
                            data.sumberdana.id, 
                            sumberdana, 
                            data.obatalkes.satuankecil_id, 
                            data.obatalkes.satuankecil_nama, 
                            row_baru
                        );
                    } else {
                        myAlert(data.pesan);
                    }
                    
                    $("#dialogOaAPI").dialog("close");
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    function set_kie_pilih_semua() {
        $(".kie_item").prop("checked", $(".kie_pilih_semua").is(":checked"));
    }

    var idx = null;

    function setDialogSigna(obj, i) {
        idx = i;

        // alert(i);
        $("#dialogSigna").dialog("open");
    }

    function setSigna(data) {

        // alert(idx);
        $('.signaoa').eq(idx).val(data.lookup_value);
        $("#dialogSigna").dialog("close");

    }

    function set_kie_pilih_semua() {
    $(".kie_item").prop("checked", $(".kie_pilih_semua").is(":checked"));
}
    /**
     * set form info pasien
     * @returns {undefined}
     */
    function setInfoPasien(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id) {
        $("#form-infopasien > .panel-body").addClass("animation-loading");
        var instalasi_id = $("#instalasi_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/farmasiApotek/penjualanResepRS/GetDataInfoPasien'); ?>',
            data: {
                instalasi_id: instalasi_id,
                pendaftaran_id: pendaftaran_id,
                no_pendaftaran: no_pendaftaran,
                no_rekam_medik: no_rekam_medik,
                pasienadmisi_id: pasienadmisi_id
            },
            dataType: "json",
            success: function(data) {
                $("#cari_pendaftaran_id").val(data.pendaftaran_id);
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasien_id").val(data.pasien_id);
                $("#pasienadmisi_id").val(data.pasienadmisi_id);
                $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                $("#carabayar_id").val(data.carabayar_id);
                $("#penjamin_id").val(data.penjamin_id);
                $("#penanggungjawab_id").val(data.penanggungjawab_id);
                $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                $("#ruangan_id").val(data.ruangan_id);
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
                $("#instalasi_nama").val(data.instalasi_nama);

                if (data.photopasien === null || data.photopasien === "") { //set photo
                    $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
                } else {
                    $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
                }

                $("#form-infopasien > .judul").html('Data Pasien <b>' + data.no_pendaftaran + '</b>');
                $("#form-infopasien > .tombol").attr('style', 'display:true;');
                //$("#form-infopasien > .box").addClass("well").removeClass("box");

                $("#form-infopasien > .panel-body").removeClass("animation-loading");
                $("#nama_pasien").focus();


                var carabayar_id = $("#carabayar_id").val();
                if (carabayar_id == '<?= Params::CARABAYAR_ID_BPJS ?>') {
                    var total = $('#<?php echo CHtml::activeId($modPenjualan, "totalhargajual"); ?>').val();
                    $('#<?php echo CHtml::activeId($modPenjualan, "totalinacbg"); ?>').val(total);
                    $(".total-ina").removeAttr('hidden');
                    $(".total-ina").show();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert("Data kunjungan tidak ditemukan !");
                console.log(errorThrown);
                setInfoPasienReset();
                $("#form-infopasien > .panel-body").removeClass("animation-loading");
                $("#instalasi_id").focus();
            }
        });
    }

    function form_tambah_signa() {
        myPrompt("Tambah Signa Baru", "", "", function(r) {
            var v = r;

            if (v.trim() == "") return false;

            myConfirm("Anda yakin untuk menambah signa '" + r + "'?", "Peringatan", function(yes) {
                if (yes) {
                    $.post('<?php echo $this->createUrl('/actionAjax/tambahSigna'); ?>', {
                        signa: v.trim()
                    }, function(data) {
                        myAlert(data.msg);
                    }, 'json');
                }
            });
        });
    }

    function hitungSubTotal(obj) {
        unformatNumberSemuaResep();
        var asd = $(obj).parents('tr').find('input[name$="[subtotal]"]');
        $(asd).addClass("animation-loading-1");

        //    console.log(unformatNumber($(obj).parents('tr').find('input[name$="[qty_dilayani]"]').val()));

        var harga = parseFloat($(obj).parents('tr').find('input[name$="[hargasatuan_reseptur]"]').val());
        var qty = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[qty_dilayani]"]').val()));
        var qty_reseptur = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[qty_reseptur]"]').val()));
        var stok = parseFloat($(obj).parents('tr').find('input[name$="[jmlstok]"]').val());

        var qty = Math.ceil(qty);
        $(obj).parents('tr').find('input[name$="[qty_dilayani]"]').val(qty);

        
        console.log("HARGA", harga);
        console.log($(obj).parents('tr').find('input[name$="[hargasatuan_reseptur]"]').val());

        //$(obj).parents('tr').find('input[name$="[qty_dilayani]"]').attr("style",'');

        console.log("P1", qty);

        // if (qty == 0) {
        //     qty = parseFloat($(obj).parents('tr').find('input[name$="[qty_reseptur]"]').val());
        //     $(obj).parents('tr').find('input[name$="[qty_dilayani]"]').val(qty);
        //     //$(obj).parents('tr').find('input[name$="[qty_dilayani]"]').attr("style",'border:red 1px solid;');

        //     myAlert("Jumlah dilayani tidak boleh nol!");
        // } else if (qty > stok) {
        //     qty = stok;
        //     $(obj).parents('tr').find('input[name$="[qty_dilayani]"]').val(qty);
        //     //$(obj).parents('tr').find('input[name$="[qty_dilayani]"]').attr("style",'border:red 1px solid;');

        //     myAlert("Jumlah dilayani tidak boleh melebihi stok farmasi!");
        // }

        var subtotal = (harga * qty);

        console.log("P2", harga, qty, subtotal);

        var obj_subtotal = $(obj).parents('tr').find('input[name$="[subtotal]"]');

        obj_subtotal.val(subtotal);


        setTimeout(function() {
            $(asd).removeClass("animation-loading-1");
        }, 300);


        //
        formatNumberSemuaResep();
        //
        hitungTotal();
    }

    function hitungEmbalase(obj) {
        obj_totalhargajual = $('#<?php echo CHtml::activeId($modPenjualan, "totalhargajual") ?>');
        var asd = $(obj_totalhargajual).parents('td');
        $(asd).addClass("animation-loading-1");
        var embalase = parseFloat(unformatNumber($(obj).val()));
        var totalhargajual = parseFloat(unformatNumber(obj_totalhargajual.val()));
        var hitung = 0

        hitung = totalhargajual + embalase;

        obj_totalhargajual.val(formatThousandDecimal(parseFloat(hitung)));

        setTimeout(function() {
            $(asd).removeClass("animation-loading-1");
        }, 300);
    }

    function hitungTotal() {
        unformatNumberSemuaResep();
        obj_totalharganetto = $('#<?php echo CHtml::activeId($modPenjualan, "totharganetto") ?>');
        obj_totalhargajual = $('#<?php echo CHtml::activeId($modPenjualan, "totalhargajual") ?>');
        var jasaembalase = parseFloat($('#<?php echo CHtml::activeId($modPenjualan, "jasaembalase") ?>').val());
        var asd = $(obj_totalhargajual).parents('td');
        $(asd).addClass("animation-loading-1");
        totalharganetto = 0;
        totalhargajual = 0;
        var totaldiskon = 0;
        var totalppn = 0;
        var total_inacbg = 0;
        var total_kronis = 0;
        var total_embalase = 0;
        var totalkeseluruhan = 0;
        var totalrke = 0;
        var cekrke = [];
        var row_racikan_1 = 0;
        var rke = $(this).find('input[name*="[rke]"]').val();


        var carabayar_id = $('#carabayar_id').val();

        $('#table-obatalkespasien > tbody > tr').each(function() {
            var ppnpersen = parseFloat($(this).find('input[name*="[ppnpersen]"]').val());
            var hargasatuan = parseFloat($(this).find('input[name*="[hargasatuan_reseptur]"]').val());
            console.log("harga_satuan 2 :" + hargasatuan);
            var qty = parseFloat(unformatNumber($(this).find('input[name*="[qty_dilayani]"]').val()));
            var persenDiskon = parseFloat($(this).find('input[name*="[persen_discount]"]').val());
            var biayadmn = parseFloat($(this).find('input[name*="[biayaadministrasi]"]').val());
            var racikan_id = parseFloat($(this).find('input[name*="[racikan_id]"]').val());
            var admracikan = parseFloat($('#admracikan').val());
            var administrasi = parseFloat($('#administrasi').val());

            if(racikan_id == 1 && !cekrke.includes(rke)){
                row_racikan_1 ++;
                cekrke.push(rke);
            }
            
            console.log("racikan_id= "+racikan_id);
            console.log("admracikan= "+admracikan);
            console.log("administrasi= "+administrasi);

            var jml_min = 0;
            var jml_max = 0;
            if ($(this).find('.is_obatkronis').is(':checked')) {
                var jml_min = parseFloat($(this).find('input[name*="[jml_min]"]').val());
                var jml_max = parseFloat($(this).find('input[name*="[jml_max]"]').val());
            }

            console.log("harga_satuan :" + hargasatuan);
            console.log("qty :" + qty);
            console.log("persenDiskon :" + persenDiskon);

            var jml_inacbg = 0;
            var jml_kronis = 0;

            if (isNaN(persenDiskon)) {
                persenDiskon = 0;
            }

            if (Math.ceil(persenDiskon) > 100) {
                myAlert('Diskon (%) Lebih dari 100%');
                persenDiskon = 0;
                $(this).find('input[name*="[persen_discount]"]').val(0);
            }

            var totalBiayaadmn = (biayadmn * qty);
            if (totalBiayaadmn > 0) {
                totalBiayaadmn = parseFloat(totalBiayaadmn.toFixed(2));
            }


            var jmlqty = 0;
            if (racikan_id==1){
                    jmlqty = (hargasatuan * qty);
                    totalrke = admracikan * row_racikan_1;
                }

            if (racikan_id==2){
                jmlqty = (hargasatuan * qty) + administrasi;
                totalrke = totalrke
            }

            if (jmlqty > 0) {
                jmlqty = parseFloat(jmlqty.toFixed(2));
            }

            var jmldiskon = (((jmlqty + totalBiayaadmn) * persenDiskon) / 100);
            if (jmldiskon > 0) {
                jmldiskon = parseFloat(jmldiskon.toFixed(2));
            }
            var subtotalSementara = ((jmlqty + totalBiayaadmn) - jmldiskon);

            var jmlppn = ((subtotalSementara * ppnpersen) / 100);
            if (jmlppn > 0) {
                jmlppn = parseFloat(jmlppn.toFixed(2));
            }

            var ppnperobat = jmlppn / qty;
            if (ppnperobat > 0) {
                ppnperobat = parseFloat(ppnperobat.toFixed(2));
            }

            var subtotal = (subtotalSementara + jmlppn);
            if (subtotal > 0) {
                subtotal = parseFloat(subtotal.toFixed(2));
            }

            $(this).find('input[name*="[jumlahppn]"]').val(jmlppn);
            $(this).find('input[name*="[subtotal]"]').val(subtotal);
            $(this).find('input[name*="[discount]"]').val(jmldiskon);
            $(this).find('input[name*="[totalbiayaadministrasi]"]').val(totalBiayaadmn);
            $(this).find('input[name*="[ppnperobat]"]').val(ppnperobat);


            if ($(this).find('.is_tanggungan_pasien').is(':checked')) {
                jml_inacbg = 0;
            } else {
                if ($(this).find('.is_obatkronis').is(':checked')) {
                    var hrg_satuan = subtotal / qty;
                    if (jml_min > 0) {
                        jml_inacbg = hrg_satuan * jml_min;
                    }

                    if (jml_max > 0) {
                        jml_kronis = hrg_satuan * jml_max;
                    }
                } else {
                    jml_inacbg = subtotal;
                }
            }

            totalharganetto += parseFloat($(this).find('input[name*="[hargasatuan_reseptur]"]').val() * $(this).find('input[name*="[qty_dilayani]"]').val());
            totalhargajual += subtotal;
            totaldiskon += jmldiskon;
            totalppn += jmlppn;
            total_inacbg += jml_inacbg;
            total_kronis += jml_kronis;

            totalkeseluruhan = (totalhargajual + totalrke);

        });
        
        obj_totalharganetto.val(totalharganetto);
        // obj_totalhargajual.val(totalhargajual + jasaembalase);
        obj_totalhargajual.val(totalkeseluruhan);
        $('#KonfigfarmasiK_admracikan').val(totalrke);

        var total_bpjs = 0;
        var tagihan_sebelum = parseFloat(unformatNumber($('#total_sebelumnya').val()));

        // total_bpjs = tagihan_sebelum + total_inacbg + jasaembalase;
        total_bpjs = tagihan_sebelum + total_inacbg;

        $('#<?php echo CHtml::activeId($modPenjualan, 'discount'); ?>').val(totaldiskon);
        $('#<?php echo CHtml::activeId($modPenjualan, "totalppn"); ?>').val(totalppn);
        $('#<?php echo CHtml::activeId($modPenjualan, "totalinacbg"); ?>').val(total_inacbg);
        $('#<?php echo CHtml::activeId($modPenjualan, "totalkronis"); ?>').val(total_kronis);
        $('#<?php echo CHtml::activeId($modPenjualan, "totaltanggunganbpjs"); ?>').val(total_bpjs);

        setTimeout(function() {
            $(asd).removeClass("animation-loading-1");
        }, 300);
        formatNumberSemuaResep();
    }

    function hitungJumlahEmbalase() {
        var jml_racikan = parseFloat($('#jml_racikan').val());
        var admracikan = parseFloat($('#admracikan').val());
        var total_embalase = 0;

        total_embalase = admracikan * jml_racikan;
        $('#<?php echo CHtml::activeId($modPenjualan, "jasaembalase"); ?>').val(total_embalase);
    }

    function hitungPersenDiskon() {
        unformatNumberSemuaResep();

        $('#table-obatalkespasien > tbody > tr').each(function() {
            var hargasatuan = parseFloat($(this).find('input[name*="[hargasatuan_reseptur]"]').val());
            var qty = parseFloat($(this).find('input[name*="[qty_dilayani]"]').val());
            var jmldiscount = parseFloat($(this).find('input[name*="[discount]"]').val());
            var totalbiayaadmin = parseFloat($(this).find('input[name*="[totalbiayaadministrasi]"]').val());

            var jmlqty = (hargasatuan * qty);
            if (jmlqty > 0) {
                jmlqty = parseFloat(jmlqty.toFixed(2));
            }


            var diskoPersen = ((jmldiscount / (jmlqty + totalbiayaadmin)) * 100);
            if (diskoPersen > 0) {
                diskoPersen = parseFloat(diskoPersen.toFixed(2));
            }
            console.log('diskoPersen ' + diskoPersen);

            if (Math.ceil(diskoPersen) > 100) {
                myAlert('Keringanan (%) Lebih dari 100%');
                diskoPersen = 0;
            }
            console.log('diskoPersen ' + diskoPersen);

            if (Math.ceil(diskoPersen) > 100) {
                myAlert('Keringanan (%) Lebih dari 100%');
                diskoPersen = 0;
            }

            $(this).find('input[name*="[persen_discount]"]').val(diskoPersen);
        });
        formatNumberSemuaResep();
        hitungTotal();
    }

    function hitungPersenPPN() {
        unformatNumberSemuaResep();

        $('#table-obatalkespasien > tbody > tr').each(function() {
            var hargasatuan = parseFloat($(this).find('input[name*="[hargasatuan_reseptur]"]').val());
            var qty = parseFloat($(this).find('input[name*="[qty_dilayani]"]').val());
            var jmlppnpersen = parseFloat($(this).find('input[name*="[jumlahppn]"]').val());
            var totalbiayaadmin = parseFloat($(this).find('input[name*="[totalbiayaadministrasi]"]').val());

            var jmlqty = (hargasatuan * qty);
            if (jmlqty > 0) {
                jmlqty = parseFloat(jmlqty.toFixed(2));
            }


            var ppnPersen = ((jmlppnpersen / (jmlqty + totalbiayaadmin)) * 100);
            if (ppnPersen > 0) {
                ppnPersen = parseFloat(ppnPersen.toFixed(2));
            }

            if (Math.ceil(ppnPersen) > 100) {
                myAlert('PPN (%) Lebih dari 100%');
                ppnPersen = 0;
            }

            if (Math.ceil(ppnPersen) > 100) {
                myAlert('PPN (%) Lebih dari 100%');
                ppnPersen = 0;
            }

            $(this).find('input[name*="[ppnpersen]"]').val(ppnPersen);
        });
        formatNumberSemuaResep();
        hitungTotal();
    }


    function unformatNumberSemuaResep() {
        $('.float2').each(function() {
            $(this).val(parseFloat(unformatNumber($(this).val())));
        });
        $('.integer2').each(function() {
            $(this).val(parseFloat(unformatNumber($(this).val())));
        });
        $('.integer-decimal').each(function() {
            $(this).val(parseFloat(unformatNumber($(this).val())));
        });
    }

    /**
     * untuk format number semua (class: float / integer)
     */
    function formatNumberSemuaResep() {
        $('.float2').each(function() {
            $(this).val(formatFloat(parseFloat($(this).val())));
        });
        $('.integer2').each(function() {
            $(this).val(formatInteger($(this).val()));
        });
        $('.integer-decimal').each(function() {
            $(this).val(formatThousandDecimal(parseFloat($(this).val())));
        });
    }


    /**
     * untuk print penjualan dokter
     */
    function print(caraPrint) {
        var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    /**
     * untuk print penjualan obat kronis
     */
    function printKronis(caraPrint) {
        var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
        window.open('<?php echo $this->createUrl('PrintKronisMax'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    /**
     * rename input grid
     */
    function renameInputRowObatAlkes(obj_table) {
        var row = 0;        
        $(obj_table).find("tbody > tr").each(function() {
            $(this).attr("row-data", row);
            $(this).find("#no_urut").val(row + 1);
            $(this).find(".no_urut").html(row+1);
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
                } else if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "]");
                }
            });
            row++;
        });

        set_aucotomplete(obj_table);
    }

    function batalObatAlkesPasienDetail(obj) {
        var asd = $(obj).parents('tr');
        var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
        const no = $(obj).parents("tr").attr("row-data");

        var adaracikan = 0;
        var r_now = $(obj).parents('tr').find('input[name*="[rke]"]').val();
        var racikan_id = $(obj).parents('tr').find('input[name*="[racikan_id]"]').val();

        console.log(r_now, racikan_id);

        if (obatalkes_id != '') {
            myConfirm("Apakah anda akan membatalkan obat ini?",
                "Perhatian!",
                function(r) {
                    if (r) {
                        $(asd).addClass("animation-loading-1");
                        setTimeout(function() {
                            $(obj).parents('tr').detach();
                            var len = $('#table-obatalkespasien tbody tr').find('input[name*="[rke]"][value=' + r_now + ']').length;
                            if (racikan_id = "<?= Params::RACIKAN_ID_RACIKAN ?>") {
                                if (len == 0) {
                                    set_rke(r_now);
                                }
                            } else {
                                set_rke(r_now);
                            }
                            renameInputRowObatAlkes($("#table-obatalkespasien"));
                            $(asd).removeClass("animation-loading-1");
                            $("#riwayat-jadwal-pemberian > tbody > tr[row-data='" + no + "']").detach();
                            renameInputRowObatAlkes($("#riwayat-jadwal-pemberian"));
                        }, 400);
                        setTimeout(function() {
                            hitungTotal();
                        }, 1000);
                    }
                });
        } else {
            $(obj).parents('tr').detach();
            renameInputRowObatAlkes($("#table-obatalkespasien"));
            $("#riwayat-jadwal-pemberian > tbody > tr[row-data='" + no + "']").detach();
            renameInputRowObatAlkes($("#riwayat-jadwal-pemberian"));
            var len = $('#table-obatalkespasien tbody tr').find('input[name*="[rke]"][value=' + r_now + ']').length;

            if (racikan_id = "<?= Params::RACIKAN_ID_RACIKAN ?>") {
                if (len == 0) {
                    set_rke(r_now);
                }
            } else {
                set_rke(r_now);
            }
        }

    }

    function setDialogOA(obj, is_rowbaru) {
        var tindakan_untuk = $(obj).parent().parent().find('input').attr('id');
        $("#tindakan_untuk").val(tindakan_untuk);
        $("#is_rowbaru").val(is_rowbaru);
        $("#dialogOa").dialog("open");
        var obatalkes_kode = '';
        $.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
            data: {
                "FAObatalkesM[obatalkes_kode]": obatalkes_kode,
            }
        });
    }
    function setDialogOAApi(obj, is_rowbaru) {
        var tindakan_untuk = $(obj).parent().parent().find('input').attr('id');
        $("#tindakan_untuk").val(tindakan_untuk);
        $("#is_rowbaru").val(is_rowbaru);
        $("#dialogOaAPI").dialog("open");
        var obatalkes_kode = '';
        $.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
            data: {
                "FAObatalkesM[obatalkes_kode]": obatalkes_kode,
            }
        });
    }

    /**
     * jika dipilih dari dialogbox
     */
    //
    function pilihObatalkes(obatalkes_id, obatalkes_nama, stok, hargajual, harganetto, obatalkes_kode, sumberdana_id, sumberdana_nama, satuankecil_id, satuankecil_nama, baru) {
        console.log('ini jalan' + hargajual)
        var tindakan_untuk = $("#tindakan_untuk").val();
        var asd = $('#' + tindakan_untuk).parents('tr');
        $(asd).addClass("animation-loading-1");
        var qty = 1;
        var instalasi_id = $('#instalasi_id').val();
        var penjamin_id = $('#penjamin_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setObatAlkesPasien'); ?>',
            data: {
                obatalkes_id: obatalkes_id,
                jumlah: qty,
                therapiobat_id: null,
                instalasi_id: instalasi_id,
                penjamin_id: penjamin_id,
            }, //
            dataType: "json",
            success: function(data) {
                if (data.pesan !== "") {
                    myAlert(data.pesan);
                    var params = [];
                    params = {
                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                        modul_id: <?php echo Params::MODUL_ID_GUDANGFARMASI; ?>,
                        judulnotifikasi: 'Stok Obat Alkes Habis',
                        isinotifikasi: obatalkes_kode + ' ' + obatalkes_nama + '  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'
                    }; // 16
                    insert_notifikasi(params);
                    $(asd).removeClass("animation-loading-1");
                    return false;
                }

                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
                if (obatalkesyangsama.val()) { //jika ada obat sudah ada di table
                    myAlert("Obat sudah ada pada tabel obat alkes");
                    $(asd).removeClass("animation-loading-1");
                    return false;
                }

                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']");
                if (obatalkesyangsama.val()) { //jika ada obat sudah ada di table
                    myAlert("Obat sudah ada pada tabel obat alkes");
                    $(asd).removeClass("animation-loading-1");
                    return false;
                }
                console.log(obatalkes_nama);
                $("#" + tindakan_untuk).val(obatalkes_id);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[obatalkes_id]"]').val(data.modObatAlkesPasien.obatalkes_id);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[obatalkes_nama]"]').val(obatalkes_nama);
                // $("#"+tindakan_untuk).parents('tr').find('span[name$="[obatalkes_nama_label]"]').html(obatalkes_nama);
                $("#"+tindakan_untuk).parents('tr').find('span[name$="[obatalkes_nama_label_kosong]"]').html(obatalkes_nama);
                $("#"+tindakan_untuk).parents('tr').find('input[name$="[obatalkes_nama_api]"]').val(obatalkes_nama);
                $("#"+tindakan_untuk).parents('tr').find('span[name$="[obatalkes_nama_api_label]"]').html(obatalkes_nama);
                $("#"+tindakan_untuk).parents('tr').find('span[name$="[obatalkes_kode_kosong]"]').html(obatalkes_kode);
                // $("#"+tindakan_untuk).parents('tr').find('span[name$="[obatalkes_kode]"]').html(obatalkes_kode);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[qty_dilayani]"]').val(qty); //akan diperbaiki nanti
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[jmlstok]"]').val(stok);
                // $("#" + tindakan_untuk).parents('tr').find('input[name$="[hargasatuan_reseptur]"]').val(data.modObatAlkesPasien.hargasatuan_oa); //
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[hargasatuan_reseptur]"]').val(hargajual); //
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[biayaadministrasi]"]').val(data.modObatAlkesPasien.biayaadministrasi); //

                $("#" + tindakan_untuk).parents('tr').find('input[name$="[hargajual_reseptur]"]').val(hargajual);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[harganetto_reseptur]"]').val(harganetto);
                //			$("#"+tindakan_untuk).parents('tr').find('input[name$="[subtotal]"]').val(hargajual*qty);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[sumberdana_id]"]').val(sumberdana_id);
                $("#" + tindakan_untuk).parents('tr').find('span[name$="[sumberdana_nama]"]').html(sumberdana_nama);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[satuankecil_id]"]').val(satuankecil_id);
                $("#" + tindakan_untuk).parents('tr').find('span.satuan').html(satuankecil_nama);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[iter]"]').val(1);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[stokobatalkes_id]"]').val(data.otherdata.stokobatalkes_id);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[persenppnjual]"]').val(data.otherdata.ppnpersen);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[ppnpersen]"]').val(data.otherdata.ppnpersen);
                $("#" + tindakan_untuk).parents('tr').find('input[name$="[formulariumobat_id]"]').val(data.modObatAlkesPasien.formulariumobat_id);


                $("#"+tindakan_untuk).parents('tr').find('span[name$="[jenisobat]"]').html(sumberdana_nama);

                $("#" + tindakan_untuk).parents('tr').find('input[name$="[iter]"]').attr('readonly', false);
                set_tanggungan();
                                

                $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
				{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                );
                $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').unmaskMoney();
                $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney(
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
                );
                renameInputRowObatAlkes($("#table-obatalkespasien"));
                
                
                setRiwayat($("#"+tindakan_untuk));
                // formatNumberSemuaResep();

                // $("#table-obatalkespasien .qty").each(function() {
                //     hitungSubTotal($(this));
                // });

                hitungTotal();
                $(asd).removeClass("animation-loading-1");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }

    function tambahObatalkes(obj) {
        var table = $('#table-obatalkespasien');
        var racikan_id = <?php echo Params::RACIKAN_ID_NONRACIKAN; ?>;
        <?php $modDetail = new FAResepturDetailT(); ?>
        <?php $this->is_trracikan = false; ?>
        var row_tindakan = new String(<?php echo CJSON::encode($this->renderPartial('_rowDetailKosong', array('modResepturDetail' => $modDetail, 'modPendaftaran' => $modPendaftaran), true)); ?>);
        var rowJadwal = new String(<?= CJSON::encode($this->renderPartial('_rowCatatan',['i'=>0,'model'=>$modDetail], true)) ?>);
        $(table).children('tbody').append(row_tindakan.replace());     
        renameInputRowObatAlkes($(table));                           

        // menentukan default rke
        var rke_array = [];
        $('#table-obatalkespasien > tbody > tr').each(function(index) {
            rke_array[index] = $(this).find('input[name$="[rke]"]').val();
        });
        var rke_array_max = Math.max.apply(Math, rke_array);
        var rke = rke_array_max + 1;

        // masukin data ke tr baru sebelum autocomplite
        $(table).find('tr:last-child input[name$="[rke]"]').val(rke);
        $(table).find('tr:last-child input[name$="[rke]"]').focus();
        $(table).find('tr:last-child input[name$="[racikan_id]"]').val(racikan_id);
        $(table).find('tr:last-child input[name$="[obatalkes_biaya_r]"]').val('');
        //	$("#"+tindakan_untuk).parents('td').find('span > a').attr('onclick','setDialogOA(this,0);');
        jQuery('.exp_date:last').datepicker(
            jQuery.extend({showMonthAfterYear: false},
                jQuery.datepicker.regional['id'], {
                    'dateFormat': 'dd/mm/yy', 
                    'timeText': 'Waktu', 
                    'hourText': 'Jam',
                    'minuteText': 'Menit', 
                    'secondText': 'Detik', 
                    'showSecond': true, 
                    'timeOnlyTitle': 'Pilih   Waktu', 
                    'timeFormat': 'hh:mm:ss', 
                    'changeYear': true, 
                    'changeMonth': true, 
                    'showAnim': 'fold'
                }
            )
        );
        
        $("#riwayat-jadwal-pemberian > tbody ").append(rowJadwal);   
        renameInputRowObatAlkes($("#riwayat-jadwal-pemberian"));
        
        //masking input
        $("#table-obatalkespasien tbody tr:last-child .qty").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": "",
            "precision": 0
        });
        $("#table-obatalkespasien tbody tr:last-child .integer-decimal").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": ".",
            "precision": 2
        });


        $(table).find('tr:last-child input[name$="[obatalkes_nama]"]').autocomplete({
            'showAnim': 'fold',
            'minLength': 2,
            'focus': function(event, ui) {
                $(this).val("");
                return false;
            },
            'select': function(event, ui) {
                $(this).val(ui.item.label);
                //$(this).parents("tr").find("input[name$='[obatalkes_id]']").val(ui.item.obatalkes_id);
                $("#tindakan_untuk").val($(this).prop('id'));
                pilihObatalkes(
                    ui.item.obatalkes_id,
                    ui.item.obatalkes_nama,
                    ui.item.qtyStok,
                    ui.item.hargajual,
                    ui.item.harganetto,
                    ui.item.obatalkes_kode,
                    ui.item.sumberdana_id,
                    ui.item.sumberdana_nama,
                    ui.item.satuankecil_id,
                    ui.item.satuankecil,
                    1
                );
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('autocompleteObatFarmasi'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                        penjamin_id: <?php echo $modPendaftaran->penjamin_id ?>,
                    },
                    success: function(data) {
                        response(data);
                    }
                })
            }
        });
        $(table).find('tr:last-child input[name$="[obatalkes_nama_api]"]').autocomplete({
            'showAnim': 'fold',
            'minLength': 2,
            'focus': function(event, ui) {
                $(this).val("");
                return false;
            },
            'select': function(event, ui) {
                $(this).val(ui.item.label);
                //$(this).parents("tr").find("input[name$='[obatalkes_id]']").val(ui.item.obatalkes_id);
                $("#tindakan_untuk").val($(this).prop('id'));
                console.log(ui.item)
                setObatDariApiUntukAutoComplete(ui.item.kode, ui.item.jenis, ui.item.jmlStok, ui.item.HJual, ui.item.stFornas, ui.item.satuan, ui.item.nama, ui.item.HPP);
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('/rawatJalan/reseptur/AutocompleteObatApi'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                        ruangantujuan_id: <?php echo $modReseptur->ruangan_id ?>,
                        stokdepo:1
                    },
                    success: function(data) {
                        response(data);
                    }
                })
            }
        });

        $(table).find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
            "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
        });

        set_tanggungan();
    }



    function tambahObatalkesRacikan(obj, new_r) {
        var table = $('#table-obatalkespasien');
        var rke_old = $(obj).parents('tr').find('input[name$="[rke]"]').val();
        var racikan_id = <?php echo Params::RACIKAN_ID_RACIKAN; ?>;
        <?php $modDetail = new FAResepturDetailT(); ?>
        <?php $this->is_trracikan = true; ?>
        var row_tindakan = <?php echo CJSON::encode(array("html" => $this->renderPartial('_rowDetailKosong', array('modResepturDetail' => $modDetail, 'modPendaftaran' => $modPendaftaran), true))); ?>;
        var rowJadwal = <?= CJSON::encode(array("html" => $this->renderPartial('_rowCatatan',['i'=>0,'model'=>$modDetail], true))) ?>;
        var asd = $(obj).parents('tr');

        // menentukan default rke
        var rke_array = [];
        $('#table-obatalkespasien > tbody > tr').each(function(index) {
            rke_array[index] = $(this).find('input[name$="[rke]"]').val();
        });
        var rke_array_max = Math.max.apply(Math, rke_array);
        var rke = rke_array_max + 1;

        if (new_r == 1) {
            $(table).children('tbody').append(row_tindakan.html);
            renameInputRowObatAlkes($(table));

            // masukin data ke tr baru sebelum autocomplite
            $(table).find('tr:last-child input[name$="[rke]"]').val(rke);
            $(table).find('tr:last-child input[name$="[rke]"]').focus();
            $(table).find('tr:last-child input[name$="[racikan_id]"]').val(racikan_id);
        } else {
            $(row_tindakan.html).insertAfter(asd);
            renameInputRowObatAlkes($(table));
            // masukin data ke tr baru sebelum autocomplite
            $(obj).parents('tr').next('tr').find('input[name$="[rke]"]').val(rke_old);
            $(obj).parents('tr').next('tr').find('input[name$="[rke]"]').focus();
            $(obj).parents('tr').next('tr').find('input[name$="[racikan_id]"]').val(racikan_id);
        }

        jQuery('.exp_date:last').datepicker(
            jQuery.extend({showMonthAfterYear: false},
                jQuery.datepicker.regional['id'], {
                    'dateFormat': 'dd/mm/yy', 
                    'timeText': 'Waktu', 
                    'hourText': 'Jam',
                    'minuteText': 'Menit', 
                    'secondText': 'Detik', 
                    'showSecond': true, 
                    'timeOnlyTitle': 'Pilih   Waktu', 
                    'timeFormat': 'hh:mm:ss', 
                    'changeYear': true, 
                    'changeMonth': true, 
                    'showAnim': 'fold'
                }
            )
        );


        $("#riwayat-jadwal-pemberian > tbody ").append(rowJadwal.html);       
        renameInputRowObatAlkes($("#riwayat-jadwal-pemberian"));

        //masking input
        $("#table-obatalkespasien tbody tr:last-child .qty").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": "",
            "precision": 2
        });

        $(table).find('tr:last-child input[name$="[obatalkes_nama]"]').autocomplete({
            'showAnim': 'fold',
            'minLength': 2,
            'focus': function(event, ui) {
                $(this).val("");
                return false;
            },
            'select': function(event, ui) {
                $(this).val(ui.item.label);
                //$(this).parents("tr").find("input[name$='[obatalkes_id]']").val(ui.item.obatalkes_id);
                $("#tindakan_untuk").val($(this).prop('id'));
                pilihObatalkes(
                    ui.item.obatalkes_id,
                    ui.item.obatalkes_nama,
                    ui.item.qtyStok,
                    ui.item.hargajual,
                    ui.item.harganetto,
                    ui.item.obatalkes_kode,
                    ui.item.sumberdana_id,
                    ui.item.sumberdana_nama,
                    ui.item.satuankecil_id,
                    ui.item.satuankecil,
                    1
                );
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('autocompleteObatFarmasi'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    success: function(data) {
                        response(data);
                    }
                })
            }
        });

        $(table).find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
            "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
        });
    }


    function cekValiditas() {
        if (requiredCheck($("form"))) {


            var is_cukup = true;
            var is_stok = true;

            var kadaluarsa = true;
            var pesan = '';

            var stokplus = true;

            var is_verif = true;

            $("#table-obatalkespasien tbody tr").each(function() {

                $(this).removeClass("yellow");

                var qty = parseFloat(unformatNumber($(this).find(".stok").val()));

                // console.log(qty, stok);

                if (qty < 0) {
                    stokplus = false;
                    $(this).addClass("yellow");
                }
            });

            if (!stokplus) {
                myAlert("Jumlah Stok tidak boleh minus.");
                return false;
            }

            $("#table-obatalkespasien tbody tr").each(function() {
                if($(this).find(".statusVerifikasi").val() == '') {
                    is_verif = false;
                    $(this).addClass("yellow");
                }
            })

            if (!is_verif) {
                myAlert("Obat Belum Dilakukan Verifikasi. Lakukan Verifikasi terlebih dahulu");
                return false;
            }


            // $("#table-obatalkespasien tbody tr").each(function() {

            //     $(this).removeClass("yellow");

            //     var tglkadaluarsa = $(this).find(".tglkadaluarsa").val();
            //     var tglkadalprev = $(this).find(".tglkadalprev").val();

            //     var namaobat = $(this).find(".namaobat").html();
            //     if (tglkadaluarsa == '') {
            //         pesan += "<br/><b>" + namaobat + "</b> kadaluarsa pada tanggal <b>" + tglkadalprev + "</b>";
            //         kadaluarsa = false;
            //         $(this).addClass("yellow");
            //     }
            // });


            // $("#table-obatalkespasien tbody tr").each(function() {

            //     $(this).removeClass("yellow");

            //     var qty = parseFloat(unformatNumber($(this).find(".qty").val()));
            //     var stok = parseFloat(unformatNumber($(this).find(".stok").val()));

            //     // console.log(qty, stok);

            //     if (qty > stok) {
            //         is_cukup = false;
            //         $(this).addClass("yellow");
            //     }
            // });

            // if (!is_cukup) {
            //     myAlert("Stok tidak mencukupi.");
            //     return false;
            // }

            // $("#table-obatalkespasien tbody tr").each(function() {

            //     $(this).removeClass("yellow");

            //     var qty = parseFloat(unformatNumber($(this).find(".qty").val()));

            //     // console.log(qty, stok);

            //     if (qty == 0) {
            //         is_stok = false;
            //         $(this).addClass("yellow");
            //     }
            // });

            // if (!is_stok) {
            //     alert("Jumlah Melayani tidak boleh 0.");
            //     return false;
            // }


            $(".animation-loading").removeClass("animation-loading");
            //        $("form").find('.float2').each(function(){
            //            $(this).val(formatFloat($(this).val()));
            //        });
            $("form").find('.integer-decimal').each(function() {
                $(this).val(unformatNumber($(this).val()));

                console.log($(this).val());
            });

            console.log('Proses simpan VErif')
            $("#btn_submit").prop("disabled", true);
            $('#penjualanresep-form').submit();
            
            disableOnSubmit($('#btn_submit'));
        }
        return false;

    }

    function ubahTakaranResep(obj) {
        var takaran = $(obj).val();
        var takarantext = $(obj).find("[value='" + takaran + "']").text();
        myConfirm('Apakah anda ingin mengubah takaran semua obat menjadi ' + takarantext + ' dari resep?', 'Perhatian!', function(r) {
            if (r) {
                proporsiTakaranResep(takaran);
                $(obj).click(function() {
                    $('#<?php echo CHtml::activeId($modReseptur, "totalhargajual") ?>').focus();
                });
            } else {
                $(obj).val(1);
            }
        });
    }

    /**
     * menghitung proporsi semua obat berdasarkan takaran
     * @returns {undefined}
     */
    function proporsiTakaranResep(takaran) {
        $('#table-obatalkespasien > tbody').addClass("animation-loading");
        var pendaftaran_id = $('#pendaftaran_id').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetProporsiTakaranResep'); ?>',
            data: {
                takaran: takaran,
                pendaftaran_id: pendaftaran_id,
                data: $("input[name*='FAResepturDetailT']").serialize()
            }, //
            dataType: "json",
            success: function(data) {
                if (data.pesan == '') {
                    $('#table-obatalkespasien > tbody tr').detach();
                    $('#table-obatalkespasien > tbody').append(data.form);
                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                    $('#table-obatalkespasien > tbody > tr').each(function() {
                        var harga = parseInt($(this).find('input[name$="[hargajual_reseptur]"]').val());
                        var qty = parseInt($(this).find('input[name$="[qty_dilayani]"]').val());
                        var subtotal = (harga * qty);
                        var obj_subtotal = $(this).find('input[name$="[subtotal]"]');
                        obj_subtotal.val(subtotal);
                        hitungTotal();
                    });
                } else {
                    myAlert(data.pesan);
                }

                $('#table-obatalkespasien > tbody').removeClass("animation-loading");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function cekKadaluarsa() {
        var kadaluarsa = true;
        var pesan = '';
        $("#table-obatalkespasien tbody tr").each(function() {

            $(this).removeClass("yellow");

            var tglkadaluarsa = $(this).find(".tglkadaluarsa").val();
            var tglkadalprev = $(this).find(".tglkadalprev").val();

            var namaobat = $(this).find(".namaobat").html();
            if (tglkadaluarsa == '') {
                pesan += "<br/><b>" + namaobat + "</b> kadaluarsa pada tanggal <b>" + tglkadalprev + "</b>";
                kadaluarsa = false;
              
            }
        });

      
        return false;
    }

    function ceklist(obj) {
        var qty = $(obj).parents('tr').find('.qty').val();
        var formularium = $(obj).parents('tr').find('.formulaobatkronis_id');

        if ($(obj).parents('tr').find('.is_obatkronis').is(':checked')) {
            formularium.attr('readonly', false);
            formularium.attr('disabled', false);
            $.post('<?php echo $this->createUrl('GetJumlahObat') ?>', {
                qty: qty,
            }, function(data) {
                if (data.formulaobatkronis_id != "") {
                    formularium.val(data.formulaobatkronis_id);
                    $(obj).parents('tr').find('.jml_min').val(data.jml_min);
                    $(obj).parents('tr').find('.jml_max').val(data.jml_max);
                    hitungTotal();
                } else {
                    formularium.val('');
                    $(obj).parents('tr').find('.jml_min').val(0);
                    $(obj).parents('tr').find('.jml_max').val(0);
                    formularium.attr('readonly', true);
                    formularium.attr('disabled', true);
                    $(obj).parents('tr').find('.is_obatkronis').prop('checked', false);
                    hitungTotal();
                }
                cek_tarif(obj);
            }, 'json');
        } else {
            formularium.attr('readonly', true);
            formularium.attr('disabled', true);
            formularium.val('');
            hitungTotal();

        }

    }

    function setMinMax(obj) {

        // unformatNumberSemuaResep();
        $(obj).closest('tr').find('.subtotal_kronis, .subtotal_inacbg').each(function() {
            $(this).val(parseFloat(unformatNumber($(this).val())));
        });
        
        var jml_min = 0;
        var jml_max = 0;
        if ($(obj).closest('tr').find('.is_obatkronis').is(':checked')) {
            var jml_min = parseFloat($(obj).closest('tr').find('input[name*="[jml_min]"]').val());
            var jml_max = parseFloat($(obj).closest('tr').find('input[name*="[jml_max]"]').val());
        }

        var minmax = $(obj).val();

        var mmval = $(obj).find('option[value="' + minmax + '"]').html();

        if(mmval !== '-- Pilih --') {
            mm = mmval.split(" / ");
            $(obj).closest('tr').find('input[name*="[jml_min]"]').val(mm[0]);
            $(obj).closest('tr').find('input[name*="[jml_val]"]').val(mm[1]);
        } else {
            mm = [];
            mm[0] = 0;
            mm[1] = 1;
            $(obj).closest('tr').find('input[name*="[jml_min]"]').val(0);
            $(obj).closest('tr').find('input[name*="[jml_val]"]').val(1);
        }

        var min =  mm[0];
        var max =  mm[1];

        var tm = parseFloat(min) + parseFloat(max);

        hitungTotal();

        var sub = $(obj).closest('tr').find('.subtotal').val();
        var sub_f = unformatNumber(sub);
        var sub_uf = parseFloat(sub_f.toFixed(2));

        var sub_kro = (sub_f * max) / tm;
        var sub_ina = (sub_f * min) / tm;

        console.log("sub kro = (" + sub_f + " * " + min + ") / (" + tm + ")");
        console.log("sub ina = (" + sub_f + " * " + max + ") / (" + tm + ")");

        

        console.log('subtot: ' + sub);
        console.log('subtot f: ' + sub_f);
        console.log('subtot uf: ' + sub_uf);

        console.log('jml min: ' + mm[0]);
        console.log('jml max: ' + mm[1]);

        console.log('sub kro: ' + sub_kro.toFixed(2));
        console.log('sub ina: ' + sub_ina.toFixed(2));

        $(obj).closest('tr').find('.subtotal_kronis').val(sub_kro.toFixed(2));
        $(obj).closest('tr').find('.subtotal_inacbg').val(sub_ina.toFixed(2));

        // $(obj).closest('tr').find('.subtotal_kronis, .subtotal_inacbg').unmaskMoney();

        $(obj).closest('tr').find('.subtotal_kronis, .subtotal_inacbg').each(function() {
            $(this).val(formatThousandDecimal(parseFloat($(this).val())));
        });

        setTotalMinMax();

        // formatNumberSemuaResep();

    }

    function setTotalMinMax() {

        var kro = 0;
        var ina = 0;
        
        $('.subtotal_kronis').each(function() {
            kro += parseFloat(unformatNumber($(this).val()));
        });

        $('.subtotal_inacbg').each(function() {
            ina += parseFloat(unformatNumber($(this).val()));
        });

        // formatThousandDecimal(parseFloat($(this).val()))
        $('#FAPenjualanResepT_totalinacbg').val(formatThousandDecimal(parseFloat(ina)));
        $('#FAPenjualanResepT_totalkronis').val(formatThousandDecimal(parseFloat(kro)));


    }

    const cek_tanggungan = (obj) => {
        var no = $(obj).parents('tr').attr('row-data');
        var obatalkes_id = $("#table-obatalkespasien > tbody > tr[row-data='" + no + "']").find(".obatalkes_id").val();

        if ($(obj).prop('checked') == true) {
            $(obj).parents('tr').find('.is_tanggungan').val(1);
        } else {
            $(obj).parents('tr').find('.is_tanggungan').val(0);
        }

        if (obatalkes_id !== "") {
            cek_tarif(obj);
        }
    }

    const cek_tarif = (obj) => {
        var obatalkes_id = $(obj).parents('tr').find('.obatalkes_id').val();
        var is_tanggungan = $(obj).parents('tr').find('.is_tanggungan').val();
        var penjamin_id = '<?php echo $modPendaftaran->penjamin_id ?>';

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setMarginObat'); ?>',
            data: {
                obatalkes_id: obatalkes_id,
                is_tanggungan: is_tanggungan,
                penjamin_id: penjamin_id,
            }, //
            dataType: "json",
            success: function(data) {
                $(obj).parents('tr').find('.formulariumobat_id').val(data.formulariumobat_id);

                $(obj).parents('tr').find('.hargasatuan_reseptur').val(data.harga_satuan);

                console.log('data= '+data.harga_satuan);
                if (is_tanggungan == 1) {
                    $(obj).parents('tr').find('.row-kronis').hide();
                    $(obj).parents('tr').find('.row-kronis').find('select').val("");
                    $(obj).parents('tr').find('.row-kronis').find('input:checkbox').prop('checked', false);
                    $(obj).parents('tr').find('.jml_min').val(0);
                    $(obj).parents('tr').find('.jml_max').val(0);
                } else {
                    $(obj).parents('tr').find('.row-kronis').show();
                }

                hitungTotal();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    const set_tanggungan = () => {
        $("#table-obatalkespasien > tbody > tr").each(function() {
            $(this).find(".is_tanggungan_radio").prop("checked", false);
            var index = $(this).attr('row-data');
            var nilai = $(this).find('.is_tanggungan').val();
            $(this).find(".is_tanggungan_radio[nilai='" + nilai + "']").prop("checked", true);
        });
    }

    const set_aucotomplete = (obj_table) => {
        $(obj_table).find("tbody").find('tr:last-child input[name$="[obatalkes_nama]"]').autocomplete({
            'showAnim': 'fold',
            'minLength': 2,
            'focus': function(event, ui) {
                $(this).val("");
                return false;
            },
            'select': function(event, ui) {
                $(this).val(ui.item.label);
                //$(this).parents("tr").find("input[name$='[obatalkes_id]']").val(ui.item.obatalkes_id);
                $("#tindakan_untuk").val($(this).prop('id'));
                pilihObatalkes(
                    ui.item.obatalkes_id,
                    ui.item.obatalkes_nama,
                    ui.item.qtyStok,
                    ui.item.hargajual,
                    ui.item.harganetto,
                    ui.item.obatalkes_kode,
                    ui.item.sumberdana_id,
                    ui.item.sumberdana_nama,
                    ui.item.satuankecil_id,
                    ui.item.satuankecil,
                    0
                );
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('autocompleteObatFarmasi'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                        penjamin_id: <?php echo $modPendaftaran->penjamin_id ?>,
                    },
                    success: function(data) {
                        response(data);
                    }
                })
            }
        });
        $(obj_table).find("tbody").find('tr input[name$="[obatalkes_nama_api]"]').each(function () { 
            $(this).autocomplete({
                'showAnim': 'fold',
                'minLength': 2,
                'focus': function(event, ui) {
                    $(this).val("");
                    return false;
                },
                'select': function(event, ui) {
                    $(this).val(ui.item.label);
                    //$(this).parents("tr").find("input[name$='[obatalkes_id]']").val(ui.item.obatalkes_id);
                    $("#tindakan_untuk").val($(this).prop('id'));
                    console.log(ui.item)
                    setObatDariApiUntukAutoComplete(ui.item.kode, ui.item.jenis, ui.item.jmlStok, ui.item.HJual, ui.item.stFornas, ui.item.satuan, ui.item.nama, ui.item.HPP);
                    return false;
                },
                'source': function(request, response) {
                    $.ajax({
                        url: "<?php echo $this->createUrl('/rawatJalan/reseptur/AutocompleteObatApi'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term,
                            ruangantujuan_id: <?php echo $modReseptur->ruangan_id ?>,
                            stokdepo:1
                        },
                        success: function(data) {
                            response(data);
                        }
                    })
                }
            });
         })
        $(obj_table).find("tbody").find('tr:last-child input[name$="[obatalkes_nama_api]"]').autocomplete({
            'showAnim': 'fold',
            'minLength': 2,
            'focus': function(event, ui) {
                $(this).val("");
                return false;
            },
            'select': function(event, ui) {
                $(this).val(ui.item.label);
                //$(this).parents("tr").find("input[name$='[obatalkes_id]']").val(ui.item.obatalkes_id);
                $("#tindakan_untuk").val($(this).prop('id'));
                console.log(ui.item)
                setObatDariApiUntukAutoComplete(ui.item.kode, ui.item.jenis, ui.item.jmlStok, ui.item.HJual, ui.item.stFornas, ui.item.satuan, ui.item.nama, ui.item.HPP);
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('/rawatJalan/reseptur/AutocompleteObatApi'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                        ruangantujuan_id: <?php echo $modReseptur->ruangan_id ?>,
                        stokdepo:1
                    },
                    success: function(data) {
                        response(data);
                    }
                })
            }
        });
    }


    const set_rke = (r) => {
        $("#table-obatalkespasien > tbody > tr").each(function() {
            var rke = $(this).find('input[name*="[rke]"]').val();
            if (rke > r) {
                r_now = rke - 1;
                console.log('r_now :' + r_now);
                $(this).find('input[name*="[rke]"]').val(r_now);
                $(this).find('.resep_ke').html(r_now);
            }
        });
    }

    /**
     * function ini harus tetap berada di bawah
     */
    $(document).ready(function() {
        renameInputRowObatAlkes($("#table-obatalkespasien"));

        <?php if (isset($_GET['reseptur_id'])) { ?>
            hitungJumlahEmbalase();
        <?php } ?>


        $("#table-obatalkespasien .racikan").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": "",
            "precision": 2
        });
        $("#table-obatalkespasien .nonracikan").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": "",
            "precision": 0
        });

        hitungTotal();
        set_tanggungan();
        cekKadaluarsa();


        jQuery('.exp_date').datepicker(
                jQuery.extend({showMonthAfterYear: false},
                    jQuery.datepicker.regional['id'], {
                        'dateFormat': 'dd/mm/yy', 
                        'timeText': 'Waktu', 
                        'hourText': 'Jam',
                        'minuteText': 'Menit', 
                        'secondText': 'Detik', 
                        'showSecond': true, 
                        'timeOnlyTitle': 'Pilih   Waktu', 
                        'timeFormat': 'hh:mm:ss', 
                        'changeYear': true, 
                        'changeMonth': true, 
                        'showAnim': 'fold'
                    }
                )
            );

        var currentBoxNumber = 0;

        $(".username").keyup(function(event) {
            if (event.keyCode == 13) {
                textboxes = $("input.username");
                currentBoxNumber = textboxes.index(this);
                console.log(textboxes.index(this));
                if (textboxes[currentBoxNumber + 1] != null) {
                    nextBox = textboxes[currentBoxNumber + 1];
                    nextBox.focus();
                    nextBox.select();
                    event.preventDefault();
                    return false;
                }
            }
        });

        <?php if (!$this->ada_penjualan) { ?>
            var seconds = 0;
            setInterval(function() {
                seconds++;
                if (seconds >= 999999) {
                    seconds = 0;
                }
                $('#<?php echo CHtml::activeId($modPenjualan, "lamapelayanan") ?>').val(seconds);
            }, 1000);
        <?php } ?>

        <?php if (isset($_GET['reseptur_id'])) {

            $ruanganReseptur = RuanganM::model()->findByPk($modReseptur->ruanganreseptur_id);

        ?>
            var reseptur_id = <?php echo isset($_GET['reseptur_id']) ? $_GET['reseptur_id'] : '' ?>;
            var pendaftaran_id = <?php echo isset($modReseptur->pendaftaran_id) ? $modReseptur->pendaftaran_id : '' ?>;
            var no_pendaftaran = '<?php echo isset($modReseptur->pendaftaran_id) ? $modReseptur->pendaftaran->no_pendaftaran : '' ?>';
            var no_rekam_medik = '<?php echo isset($modReseptur->pendaftaran_id) ? $modReseptur->pendaftaran->pasien->no_rekam_medik : '' ?>';
            var instalasi_id = <?php echo (!empty($modReseptur->pendaftaran_id) && !empty($ruanganReseptur)) ? $ruanganReseptur->instalasi_id : '' ?>;
            $('#instalasi_id').val(instalasi_id);

            $("#table-obatalkespasien .qty").each(function() {
                hitungSubTotal($(this));
            });

            if (reseptur_id != '') {
                if (pendaftaran_id != '') {
                    setInfoPasien(pendaftaran_id, no_pendaftaran, no_rekam_medik, '');
                    //			formatNumberSemuaResep();\
                }
            }
        <?php } ?>


        jQuery(".signaoa").autocomplete({
            'showAnim': 'fold',
            'minLength': 3,
            'focus': function(event, ui) {
                $(this).val("");
                return false;
            },
            'select': function(event, ui) {
                toastr.info(ui.item.lookup_value);
                $(this).val(ui.item.lookup_value);
                $(this).parents("td").find(".signaoa").val(ui.item.lookup_value);
                // $("#alamatpasien").blur();
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: "<?php echo $this->createUrl('AutocompleteSigna'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            }
        });

        var inv_petugas  = jQuery('#kodepetugas');
        var inv_jenis_layanan = jQuery('.jenislayanan_inv');
        var inv_tempat_layanan = jQuery('.tempatlayanan_inv');
        var inv_kodedokter = jQuery(".kodedokter_inventory");

        jQuery(inv_petugas).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(inv_jenis_layanan).multiselect({
                includeSelectAllOption: false,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true,
                onChange: function(element, checked) {
                    var jenis_kode = $(element).val();

                    $.post('<?php echo $this->createUrl('ajaxAPITempatLayanan'); ?>', {
                        jenis_kode: jenis_kode
                    }, function(data) {
                        $(inv_tempat_layanan).html(data).multiselect('rebuild');
                    });

                    //console.log("Dipilih", jenis_kode);
                }
        }).hide();

        jQuery(inv_tempat_layanan).multiselect({
                includeSelectAllOption: false,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(inv_kodedokter).multiselect({
                includeSelectAllOption: false,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
        }).hide();

    });
    
    const setRiwayat = (obj) => {
        const formtabel = $(obj).parents("tr");
        const no = formtabel.attr("row-data");

        const tabelriwayat = $("#riwayat-jadwal-pemberian > tbody > tr[row-data='"+no+"']");

        const namaobat = formtabel.find("span[name$='[racikan_nama]']").html()+"<br/>"+formtabel.find("span[name$='[obatalkes_nama_label]']").html()+"<br/>"+formtabel.find("input[name$='[subjenis_nama]']").val();
        const signa = formtabel.find("input[name$='[signa_reseptur]']").val();
        const etiket = formtabel.find("input[name$='[etiket]']").val();
        const satuan = formtabel.find(".nama-satuan").html();

        let aturan = '';
        let cekPenggunaan = '';
        // formtabel.find(".ket_penggunaan").each(function(){
        //     cekPenggunaan = $(this).val();

        //     if (cekPenggunaan != '' && cekPenggunaan != null){
        //         aturan += (aturan != '')?' - '+cekPenggunaan:cekPenggunaan;
        //     }
        // });        
        const qty = formtabel.find("input[name$='[qty_dilayani]']").val();
        const subjenis_id = formtabel.find("input[name$='[subjenis_id]']").val();
        console.log('ini juga jalan', no, subjenis_id, signa)
        console.log('jalan', obj)

        tabelriwayat.find(".riwayat-nama-obat").html(namaobat);
        tabelriwayat.find(".riwayat-signa").html(signa);
        tabelriwayat.find(".riwayat-etiket").html(etiket);
        tabelriwayat.find(".riwayat-qty").html(qty+' '+satuan);    

        tabelriwayat.find("input[name$='[obatalkes_id]']").val(formtabel.find("input[name$='[obatalkes_id]']").val());
        tabelriwayat.find("input[name$='[dosisobat]']").val(formtabel.find("input[name$='[signa_reseptur]']").val());
        tabelriwayat.find("input[name$='[aturanpakaiobat]']").val(formtabel.find("input[name$='[etiket]']").val());
        tabelriwayat.find("input[name$='[jenisinfus]']").val(formtabel.find("input[name$='[subjenis_nama]']").val());
        tabelriwayat.find("input[name$='[penerimaan_status]']").val("Belum Diterima");
        tabelriwayat.find("input[name$='[resepturdetail_id]']").val(formtabel.find("input[name$='[resepturdetail_id]']").val());

        let jadwal = '-';

        $.ajax({
            type:'GET',
            url:'<?= $this->createUrl('loadJadwalPemberian'); ?>',
            data: {
                signa:signa,
                subjenis_id:subjenis_id,
                no:no
            },
            dataType: "json",
            success:function(data){
                jadwal = data.listJadwal;

                tabelriwayat.find(".riwayat-jadwal-pemberian").html(jadwal);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }
</script>