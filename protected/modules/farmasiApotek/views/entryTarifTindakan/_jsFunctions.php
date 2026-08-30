<script>
    function printUlangTindakan() {
        var pendaftaran_id = $('#FAPendaftaranT_pendaftaran_id').val();
        var url = '<?= Yii::app()->controller->createUrl(Yii::app()->controller->id . "/printUlangTindakanDialog&pendaftaran_id=") ?>' + pendaftaran_id;

        if(pendaftaran_id != '') {
            $("#dialogCetakUlang").dialog("open");
            $('#iframeCetakUlang').attr('src', url);
        } else {
            myAlert('Silahkan pilih pasien terlebih dahulu');
            return false;
        }
    }

    var carabayar_id = null;

    function refreshDialogPendaftaran() {
        console.log('jalan');
        var instalasiId = $("#instalasi_id").val();
        var instalasiNama = $("#instalasi_id option:selected").text();
        $.fn.yiiGridView.update('pendaftaran-t-grid', {
            data: {
                "FAPasienM[idInstalasi]": instalasiId,
            }
        });
    }

    function isiDataPasien(data) {
        console.log(data);

        $('#FAPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
        $('#FAPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
        $('#FAPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
        $('#FAPendaftaranT_umur').val(data.umur);
        $('#FAPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit);
        $('#FAPendaftaranT_instalasi_nama').val(data.namainstalasi);
        $('#FAPendaftaranT_ruangan_nama').val(data.namaruangan);
        $('#FAPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
        $('#FAPendaftaranT_pasien_id').val(data.pasien_id);
        $('#FAPendaftaranT_carabayar_id').val(data.carabayar_id);
        $('#FAPendaftaranT_penjamin_id').val(data.penjamin_id);
        $('#FAPendaftaranT_kelaspelayanan_id').val(data.kelaspelayanan_id);
        if (typeof data.norekammedik != 'undefined') {
            $('#FAPasienM_no_rekam_medik').val(data.norekammedik);
        }
        $('#FAPasienM_jeniskelamin').val(data.jeniskelamin);
        $('#FAPasienM_nama_pasien').val(data.namapasien);
        $('#FAPasienM_nama_bin').val(data.namabin);
        $('#FAPasienM_tanggal_lahir').val(data.tanggal_lahir);
        $('#FAPasienM_jeniskelamin').val(data.jeniskelamin);
        $('#FAPasienM_alamat_pasien').val(data.alamat_pasien);
        $('#FAPendaftaranT_carabayar_nama').val(data.carabayar_nama);
        $('#FAPendaftaranT_penjamin_nama').val(data.penjamin_nama);
        $('#FAPendaftaranT_nama_pj').val(data.nama_pj);

        carabayar_id = data.carabayar_id;

        if (data.kelastanggungan != '') {
            $("#grup_kelas_tanggungan").show();
            $('#FAPendaftaranT_kelastanggungan_nama').val(data.kelastanggungan);
        } else {
            $("#grup_kelas_tanggungan").hide();
        }

        if (data.dokterpenerima != '' || data.dpjp1 != '' || data.dpjp2 != '' || data.dpjp3 != '') {
            if (data.dokterpenerima != '') $("#dokterpenerima").val(data.dokterpenerima);
            if (data.dpjp1 != '') $("#dpjp1").val(data.dpjp1);
            if (data.dpjp2 != '') $("#dpjp2").val(data.dpjp2);
            if (data.dpjp3 != '') $("#dpjp3").val(data.dpjp3);
            $(".dpjp").show();
        } else {
            $(".dpjp :input").val("");
            $(".dpjp").hide();
        }
    }


    function resetDataPasien() {
        $('#FAPendaftaranT_tgl_pendaftaran').val("");
        $('#FAPendaftaranT_no_pendaftaran').val("");
        $('#FAPendaftaranT_umur').val("");
        $('#FAPendaftaranT_jeniskasuspenyakit_nama').val("");
        $('#FAPendaftaranT_instalasi_nama').val("");
        $('#FAPendaftaranT_ruangan_nama').val("");
        $('#FAPendaftaranT_pendaftaran_id').val("");
        $('#FAPendaftaranT_pasien_id').val("");
        $('#FAPendaftaranT_carabayar_id').val("");
        $('#FAPendaftaranT_penjamin_id').val("");
        $('#FAPendaftaranT_kelaspelayanan_id').val("");
        $('#FAPendaftaranT_kelastanggungan_nama').val("");
        $('#FAPasienM_no_rekam_medik').val("");
        $('#FAPasienM_jeniskelamin').val("");
        $('#FAPasienM_nama_pasien').val("");
        $('#FAPasienM_nama_bin').val("");
        $('#FAPasienM_tanggal_lahir').val("");
        $('#FAPasienM_jeniskelamin').val("");
        $('#FAPasienM_alamat_pasien').val("");
        $('#FAPendaftaranT_carabayar_nama').val("");
        $('#FAPendaftaranT_penjamin_nama').val("");
        $('#FAPendaftaranT_nama_pj').val("");

        $("#grup_kelas_tanggungan").hide();

        $(".dpjp :input").val("");
        $(".dpjp").hide();

        $("#tblBayarTind tbody, #tblBayarOA tbody").empty();

    }

    function batalTindakan(obj) {
        myConfirm("Apakah anda akan membatalkan ini?", "Perhatian!",
            function(r) {
                if(r) {
                    $(obj).parents("tr").remove();
                }
            });
    }

    function tambahKodeTarif(obj) {
        var daftartindakan_nama = $('#daftartindakan_nama').val();
        var daftartindakan_id = $('#daftartindakan_id').val();
        var daftartindakan_kode = $('#daftartindakan_kode').val();
        var jumlahtarif = $('#jumlahtarif').val();

        if(daftartindakan_id == '') {
            myAlert('Pilih Tindakan Terlebih Dahulu');
            return false;
        }
        

        $.post('<?= $this->createUrl('tambahDetail') ?>', {
            daftartindakan_id:daftartindakan_id,
            daftartindakan_kode:daftartindakan_kode,
            daftartindakan_nama:daftartindakan_nama,
            jumlahtarif:jumlahtarif
        }, function(data){
            $("#tabel-tarif > tbody").append(data.html);
            resetInput()
            renameInputRow($("#tabel-tarif"));
        }, 'json');
    }

            
    function resetInput() {
        $('#daftartindakan_nama').val('');
        $('#daftartindakan_id').val('');
        $('#daftartindakan_kode').val('');
        $('#jumlahtarif').val(0);
    }

    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find(".nourut").html(row + 1);
            // $(this).find('span').each(function() { //element <input>
            //     var old_name = $(this).attr("name").replace(/]/g, "");
            //     var old_name_arr = old_name.split("[");
            //     if (old_name_arr.length == 3) {
            //         $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
            //     }
            // });
            $(this).find('input,select,textarea').each(function() { //element <input>
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

    function print(){
        var tindakanpelayanan_id = '<?= isset($_GET["pendaftaran_id"]) ? $_GET["pendaftaran_id"] : null ?>';
        window.open('<?php echo $this->createUrl('/rawatJalan/tindakan/printTindakan'); ?>/&id=' + tindakanpelayanan_id + '&caraPrint=PRINT', '', 'location=_new, width=900px, scrollbars=1');
    }
</script>