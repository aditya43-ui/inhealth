<script type="text/javascript">
    /**
     * set form kunjungan
     * @param {type} pendaftaran_id
     * @returns {undefined}
     */

    function cekValidasi() {
        is_diagnosa = false;
        $('#table-diagnosakeluar tbody tr').each(function() {
            var selected = $(this).find('.selectedDiagnosa').val();
            var kelompokdiagnosa_id = $(this).find('.kelompokdiganosa_id').val();
            if(selected == 1 && kelompokdiagnosa_id == 2) {
                is_diagnosa = true;
            }
        });

        if(is_diagnosa) {
            $('#pemakaianbahp-form').submit();
        } else {
            window.parent.myAlert('Diagnosa keluar belum dipilih');
            return false;
        }

    }

    function setColorPilihDiagnosa() {
        $('#table-diagnosakeluar tbody tr').each(function() {
            var selected = $(this).find('.selectedDiagnosa').val();
            if(selected == 1) {
                $(this).addClass('tr_pilih');
            } else {
                $(this).removeClass('tr_pilih');
            }
        });

        $('#table-diagnosatindakan tbody tr').each(function() {
            var selected = $(this).find('.selectedDiagnosaTindakan').val();
            if(selected == 1) {
                $(this).addClass('tr_pilih');
            } else {
                $(this).removeClass('tr_pilih');
            }
        });

    }

    $(function(){
        setColorPilihDiagnosa();
    });


    function pilihDiagnosaKeluar(obj) {
        var selected = $(obj).parents('tr').find('.selectedDiagnosa').val();
        var selectedKelompokDiagnosa = $(obj).parents('tr').find('.kelompokdiganosa_id').val();

        var is_diganosaUtama = false;
        // cekdiagnosautama yang dipilih
        $('#table-diagnosakeluar tbody tr').each(function() {
            var is_pilih = $(this).find('.selectedDiagnosa').val();
            var kelompokdiagnosa_id = $(this).find('.kelompokdiganosa_id').val();

            if(is_pilih == 1 && kelompokdiagnosa_id == 2) {
                is_diganosaUtama = true;
            }
        });

        if(selectedKelompokDiagnosa == 2 && is_diganosaUtama && selected == 0) {
            window.parent.myAlert('Diagnosa utama sudah tersedia');
            return false;
        }


        if(selected == 0) {
            $(obj).parents('tr').find('.selectedDiagnosa').val(1);
        } else {
            $(obj).parents('tr').find('.selectedDiagnosa').val(0);
        }
        setColorPilihDiagnosa();
    }

    function pilihDiagnosaTindakan(obj) {
        var selected = $(obj).parents('tr').find('.selectedDiagnosaTindakan').val();

        if(selected == 0) {
            $(obj).parents('tr').find('.selectedDiagnosaTindakan').val(1);
        } else {
            $(obj).parents('tr').find('.selectedDiagnosaTindakan').val(0);
        }        
        setColorPilihDiagnosa();
    }

    function setKondisiKeluar(obj) {
        var carakeluar_id = $(obj).val();
        $.post('<?= $this->createUrl('setKondisiKeluar') ?>', {
            carakeluar_id:carakeluar_id
        }, function(data){
            $('.kondisikeluar_id').html(data.option);
        }, 'json');
    }
    function setKunjungan(pendaftaran_id) {
        $("#form-datakunjungan > div").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDataKunjungan'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id
            },
            dataType: "json",
            success: function(data) {
                if (data.pesan != "") {
                    myAlert(data.pesan);
                    setKunjunganReset();
                } else { 
                    $("#pendaftaran_id").val(data.pendaftaran_id);
                    $("#pasien_id").val(data.pasien_id);
                    $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                    $("#carabayar_id").val(data.carabayar_id);
                    $("#penjamin_id").val(data.penjamin_id);
                    $("#penanggungjawab_id").val(data.penanggungjawab_id);
                    $("#instalasi_id").val(data.instalasi_id);
                    $("#ruangan_id").val(data.ruangan_id);
                    $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                    $("#no_pendaftaran").val(data.no_pendaftaran);
                    $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
                    $("#instalasi_nama").val(data.instalasi_nama);
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
                    // $("#alamat_pasien").val(data.alamat_pasien);
                    $("#dokterpenanggungjawab_nama").val(data.dokterpenanggungjawab_nama);
                    $("#pegawaipenanggung_nama").val(data.pegawaipenanggung_nama);
                    $("#pegawaipenanggung_id").val(data.pegawaipenanggung_id);
                    $("#tglpasienpulang").val(data.tglpasienpulang);

                    LoadAllPemeriksaan();
                    // if(data.photopasien === null || data.photopasien === ""){ //set photo
                    //     $('#photo-preview').attr('src','<?php //echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"
                                                            ?>');
                    // }else{
                    //     $('#photo-preview').attr('src','<?php //echo Params::urlPasienTumbsDirectory()."kecil_"
                                                            ?>'+data.photopasien);
                    // }

                    // $("#judul-form-datakunjungan  > .judul").html('<b>Data Kunjungan</b> "'+data.no_pendaftaran+'" ');
                    // $("#judul-form-datakunjungan > .tombol").attr('style','display:true;');
                }
                $("#form-datakunjungan > div").removeClass("animation-loading");
                $("#no_pendaftaran").focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert("Data kunjungan tidak ditemukan !");
                console.log(errorThrown);
                setKunjunganReset();
                $("#form-datakunjungan > div").removeClass("animation-loading");
                $("#no_pendaftaran").focus();
            }
        });

    }

    

    function loadDiagnosa() {
        var pendaftaran_id = '<?php echo (!empty($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : ''); ?>';
        if (pendaftaran_id != '') {
            var diagnosa_awal = '<?= (empty($dataDiagnosa['diagnosaawal']) ? "" : $dataDiagnosa['diagnosaawal']); ?>';
            var diagnosa_akhir = '<?= (empty($dataDiagnosa['diagnosautama']) ? "" : $dataDiagnosa['diagnosautama']); ?>';
            $('#diagnosasementara-label').val(diagnosa_awal);
            $('#diagnosautama-label').val(diagnosa_akhir);
        }
    }

    /**
     * untuk mereset form kunjungan
     * @returns {undefined} */
    function setKunjunganReset() {
        $("#form-datakunjungan input,textarea").each(function() {
            $(this).val("");
        });
        $("#form-dataresume input,textarea").each(function() {
            $(this).val("");
        });
        $('#<?php echo CHtml::activeId($modResume, 'ikhtisarkliniksingkat'); ?>').parent().find('iframe').contents().find('#page').html("");
        $('#<?php echo CHtml::activeId($modResume, 'ikhtisarkliniksingkat'); ?>').val("");
        $('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanfisik'); ?>').parent().find('iframe').contents().find('#page').html("");
        $('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanfisik'); ?>').val("");
        $('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanlab'); ?>').parent().find('iframe').contents().find('#page').html("");
        $('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanlab'); ?>').val("");
        $('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanrad'); ?>').parent().find('iframe').contents().find('#page').html("");
        $('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanrad'); ?>').val("");
        $('#<?php echo CHtml::activeId($modResume, 'terapiperawatan'); ?>').parent().find('iframe').contents().find('#page').html("");
        $('#<?php echo CHtml::activeId($modResume, 'terapiperawatan'); ?>').val("");
        $('#<?php echo CHtml::activeId($modResume, 'terapisaatpulang'); ?>').parent().find('iframe').contents().find('#page').html("");
        $('#<?php echo CHtml::activeId($modResume, 'terapisaatpulang'); ?>').val("");

        $("#ruangan_id").val(<?php echo $modKunjungan->ruangan_id; ?>);
        $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
        $("#judul-form-datakunjungan > .judul").html("<b>Data Kunjungan</b>");
        $("#judul-form-datakunjungan > .tombol").attr("style", "display:none;");
    }

    function print() {
        var pendaftaran_id = $("#pendaftaran_id").val();
        if (pendaftaran_id != null) {
            window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=480,height=640');
        } else {
            myAlert("Transaksi belum disimpan !");
        }
    }

    const LoadAllPemeriksaan = () => {
        const id = $("#pendaftaran_id").val();

        $.get('<?php echo $this->createUrl('loadAllPemeriksaan'); ?>', {
            id
        }, function(data) {
            console.log(data.keluhanutama);
            
            const diagnosamasuk = $('#<?php echo CHtml::activeId($modResume, 'diagnosamasuk'); ?>');
            diagnosamasuk.val(data.diagnosamasuk);

            const keluhanutama = $('#<?php echo CHtml::activeId($modResume, 'keluhanutama'); ?>')
            keluhanutama.parent().find('iframe').contents().find('#page').html(data.keluhanutama);
            keluhanutama.val(data.keluhanutama);

            const anamnesa = $('#<?php echo CHtml::activeId($modResume, 'anamnesa'); ?>')
            anamnesa.parent().find('iframe').contents().find('#page').html(data.anamnesa);
            anamnesa.val(data.anamnesa);

            const riwayatalergi = $('#<?php echo CHtml::activeId($modResume, 'riwayatalergi'); ?>')
            riwayatalergi.parent().find('iframe').contents().find('#page').html(data.riwayatalergi);
            riwayatalergi.val(data.riwayatalergi);

            const diagnosaakhir = $('#<?php echo CHtml::activeId($modResume, 'diagnosa_akhir'); ?>')
            diagnosaakhir.parent().find('iframe').contents().find('#page').html(data.diagnosa);
            diagnosaakhir.val(data.diagnosa);

            const planningdanterapi = $('#<?php echo CHtml::activeId($modResume, 'planningdanterapi'); ?>')
            planningdanterapi.parent().find('iframe').contents().find('#page').html(data.planning);
            planningdanterapi.val(data.planning);

            const terapiyangberjalan = $('#<?php echo CHtml::activeId($modResume, 'terapiyangberjalan'); ?>')
            terapiyangberjalan.parent().find('iframe').contents().find('#page').html(data.terapiberjalan);
            terapiyangberjalan.val(data.terapiberjalan);

            // const riwayatbedah = $('#<?php echo CHtml::activeId($modResume, 'riwayatbedah'); ?>')
            // riwayatbedah.parent().find('iframe').contents().find('#page').html(data.tindakanbedah);
            // riwayatbedah.val(data.tindakanbedah);

            const riwayatpenyakitterdahulu = $('#<?php echo CHtml::activeId($modResume, 'riwayatpenyakitterdahulu'); ?>')
            riwayatpenyakitterdahulu.parent().find('iframe').contents().find('#page').html(data.riwayatpenyakitterdahulu);
            riwayatpenyakitterdahulu.val(data.riwayatpenyakitterdahulu);

            const riwayatobat = $('#<?php echo CHtml::activeId($modResume, 'riwayatobat'); ?>')
            riwayatobat.parent().find('iframe').contents().find('#page').html(data.riwayatpengobatan);
            riwayatobat.val(data.riwayatpengobatan);

            const pemeriksaanpenunjang = $('#<?php echo CHtml::activeId($modResume, 'pemeriksaanpenunjang'); ?>')
            pemeriksaanpenunjang.parent().find('iframe').contents().find('#page').html(data.pemeriksaanpenunjang);
            pemeriksaanpenunjang.val(data.pemeriksaanpenunjang);

            const tandavital = $('#<?php echo CHtml::activeId($modResume, 'tandavital'); ?>')
            tandavital.parent().find('iframe').contents().find('#page').html(data.pemeriksaanfisik);
            tandavital.val(data.pemeriksaanfisik);

            // if(data.diagnosakeluar.length > 0) {
            //     var i = 0;
            //     $('#table-diagnosakeluar tbody tr').each(function() {
            //         var pasienmorbiditas_id = $(this).find('.pasienmorbiditas_id').val();

            //         var arMorbi = data.diagnosakeluar;

            //         var foundItems = $.grep(arMorbi, function(item, index) {
            //             return item == pasienmorbiditas_id;
            //         });

            //         if (foundItems.length > 0) {
            //             $(this).find('.selectedDiagnosa').val(1);
            //         } 
                    
            //         i++;
            //     });
            //     setColorPilihDiagnosa();
            // }

            // if(data.diagnosatindakan.length > 0) {
            //     var i = 0;
            //     $('#table-diagnosatindakan tbody tr').each(function() {
            //         var pasienicd9cm_id = $(this).find('.pasienicd9cm_id').val();

            //         var arICD9 = data.diagnosatindakan;

            //         var foundItems = $.grep(arICD9, function(item, index) {
            //             return item == pasienicd9cm_id;
            //         });

            //         if (foundItems.length > 0) {
            //             $(this).find('.selectedDiagnosaTindakan').val(1);
            //         } 
                    
            //         i++;
            //     });
            //     setColorPilihDiagnosa();
            // }

            // refreshRiwayat();
        }, 'json');
    }

    const refreshRiwayat = () => {

        const pasien_id = $("#pasien_id").val();
        let def = 'kosong';

        if (pasien_id != '') {
            def = '';
        }

        $.fn.yiiGridView.update('daftar-riwayat-grid', {
            data: {
                'ResumemedisR[default]': def,
                'ResumemedisR[pasien_id]': pasien_id,
            }
        })
    }

    const hapus = (id) => {
        window.parent.myConfirm("Apakah Anda yakin ingin menghapus data ini ?", "Perhatian!", function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?= $this->createUrl('hapusRiwayat') ?>',
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses == '1') {
                            window.parent.Notiflix.Report.Success("Data berhasil dihapus", "Perhatian!", "OK");
                            if ('${action}' == 'detail') {
                                if (id == '${idCpis}') {
                                    location.href = "${urlUlang}";
                                    return false;
                                }
                            }
                            // refreshRiwayat();
                        } else {
                            window.parent.Notiflix.Report.Failure("Data gagal dihapus", "Perhatian!", "OK");
                        }
                        $.fn.yiiGridView.update('daftar-riwayat-grid');
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }

    const cetak = (id) => {
        window.open("<?= $this->createUrl('printR') ?>&id=" + id, "cetak-resume-medis-pasien", "width=860,height=480");
    }

    const detail = (id) => {
        window.open("<?= $this->createUrl('detail') ?>&id=" + id, "cetak-resume-medis-pasien", "width=860,height=480");
    }

    /**
     * function ini harus tetap berada di bawah
     */
    $(document).ready(function() {
        
        

        setTimeout(function() {
            // default disabled dari awal load
            const keluhanutama = $('#<?php echo CHtml::activeId($modResume, 'keluhanutama'); ?>');
            console.log(keluhanutama.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false'));

            const riwayatpenyakitterdahulu = $('#<?php echo CHtml::activeId($modResume, 'riwayatpenyakitterdahulu'); ?>')
            riwayatpenyakitterdahulu.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');

            const tandavital = $('#<?php echo CHtml::activeId($modResume, 'tandavital'); ?>')
            tandavital.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');

            const anamnesa = $('#<?php echo CHtml::activeId($modResume, 'anamnesa'); ?>')
            anamnesa.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');

            $("#no_pendaftaran").focus();
            <?php if (isset($_GET['pendaftaran_id']) && !isset($_GET['sukses'])) { ?>
                LoadAllPemeriksaan();
            <?php } ?>
            
                <?php if(Yii::app()->user->getState('ruangan_id') == 1260) { ?>
                   
                     disableEditor();
                
                <?php } ?>
        }, 1000);

       
    });

    function disableEditor() { 
       
    

        const riwayatalergi = $('#<?php echo CHtml::activeId($modResume, 'riwayatalergi'); ?>')
        riwayatalergi.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');
        

        const diagnosaakhir = $('#<?php echo CHtml::activeId($modResume, 'diagnosa_akhir'); ?>')
        diagnosaakhir.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');

        const planningdanterapi = $('#<?php echo CHtml::activeId($modResume, 'planningdanterapi'); ?>')
        planningdanterapi.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');

        const terapiyangberjalan = $('#<?php echo CHtml::activeId($modResume, 'terapiyangberjalan'); ?>')
        terapiyangberjalan.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');

        const riwayatbedah = $('#<?php echo CHtml::activeId($modResume, 'riwayatbedah'); ?>')
        riwayatbedah.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');

        const riwayatobat = $('#<?php echo CHtml::activeId($modResume, 'riwayatobat'); ?>')
        riwayatobat.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');

        const pemeriksaanpenunjang = $('#<?php echo CHtml::activeId($modResume, 'pemeriksaanpenunjang'); ?>')
        pemeriksaanpenunjang.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');

       

        const anjuran = $('#<?php echo CHtml::activeId($modResume, 'anjuran'); ?>')
        anjuran.parent().find('iframe').contents().find('#page').attr('contenteditable', 'false');
     }

</script>