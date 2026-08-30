<script>
   /**
     * update (refresh) checklist pemeriksaan lab
     * harus include /js/jquery.tiler.js
     * @param {obj} form_checklist
     */
    function updateChecklistPemeriksaanRad() {
        var form_index = $('#form_index').val();
        var cek = [];

        $('#tblFormPemeriksaanRad tbody tr').each(function() {

            var id = $(this).attr('id');
            cek.push(parseInt(id.replace('periksarad_', '')));
            // cek.push('');

        });

        $('.daftar-pemeriksaan').addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatJalan/radiologi/SetChecklistPemeriksaanRad'); ?>',
            data: {
                data: $("#form-caripemeriksaan :input").serialize()
            },
            dataType: "json",
            success: function(data) {
                $('.daftar-pemeriksaan').html(data.content);
                // $('.checkboxlist-tile').tile({widths : [ 190 ]});
                $('.daftar-pemeriksaan').removeClass("animation-loading");
                // setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"+form_index),$('.daftar-pemeriksaan'));

                var cekc = [];
                $.each(cek, function(key, val) {

                    $('#formPeriksaRad').find('input[type="checkbox"][value="' + val + '"]').prop("checked", "checked");
                    cekc.push(val);

                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

  /**
     * set checked pemeriksaan yang sudah ada di daftar
     */
    function setCheckedPemeriksaan(obj_table, obj_dialog) {
        var form_index = $('#form_index').val();
        $(obj_table).find('input[name$="[pemeriksaanrad_id]"]').each(function() {
            var pemeriksaanrad_id = $(this).val();
            $(obj_dialog).find('input[name$="[is_pilih]"][value=' + pemeriksaanrad_id + ']').attr('checked', true);
        });

    }

    function inputperiksa(obj) {
        if ($(obj).is(':checked')) {
            var pemeriksaanrad_id = obj.value;
            var kelaspelayanan_id = $('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id') ?>').val();
            var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
            if (kelaspelayanan_id == '') {
                myAlert("Silakan pilih kelas pelayanan terlebih dahulu!");
                $(obj).attr('checked', false);
                return false;
            }

            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl('rawatJalan/radiologi/loadFormPemeriksaanRad') ?>',
                'data': {
                    pemeriksaanrad_id: pemeriksaanrad_id,
                    kelaspelayanan_id: kelaspelayanan_id,
                    pendaftaran_id: pendaftaran_id
                },
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if ($.trim(data.form) == '') {
                        $(obj).removeAttr('checked');
                        alert('Pemeriksaan belum memiliki tarif');
                    }

                    $('#tblFormPemeriksaanRad #trPeriksaRadKosong').detach();
                    $('#tblFormPemeriksaanRad > tbody').append(data.form);
                    $("#tblFormPemeriksaanRad > tbody > tr:last .integer").maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ".",
                        "thousands": ",",
                        "precision": 0
                    });
                    $('.integer').each(function() {
                        this.value = formatNumber(this.value)
                    });
                    hitungTotal();
                },
                'cache': false
            });
        } else {
            myConfirm("Apakah Anda akan membatalkan pemeriksaan ini?", "Perhatian!", function(r) {
                if (r) {
                    batalPeriksa(obj.value);
                    hitungTotal();
                } else {
                    $(obj).attr('checked', 'checked');
                }
            });
        }
    }

    function batalPeriksa(idPemeriksaanrad) {
        $('#tblFormPemeriksaanRad #periksarad_' + idPemeriksaanrad).detach();
        if ($('#tblFormPemeriksaanRad tr').length == 1)
            $('#tblFormPemeriksaanRad').append('<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>');
    }

    function batalKirim(pasienkirimkeunitlain_id, pendaftaran_id) {
        myConfirm("Apakah Anda akan membatalkan kirim pasien ke Radiologi?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {
                    pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
                    pendaftaran_id: pendaftaran_id
                }, function(data) {
                    $('#tblListPemeriksaanRad').html(data.result);
                    myAlert(data.pesan);
                }, 'json');
            }
        });
    }

    function hitungTotal() {
        var total = 0;
        $('.tarif_satuan').each(
            function() {
                qty = $(this).parents('tr').find('.qty').val();
                total += unformatNumber(this.value) * qty;
            }
        );
        $('#periksaTotal').val(formatNumber(total));
    }

    function cekInput() {
        if (requiredCheck($("#rjpasien-radiologi-t-form"))) {
            //var deposit = $('#deposit').val();
            var periksaTotal = unformatNumber($('#periksaTotal').val());
            var tr = $("#tblFormPemeriksaanRad > tbody > tr").length;
            if (tr > 0) {
                $('#rjpasien-radiologi-t-form').submit();
            } else {
                alert("Tindakan Radiologi belum dipilih");
                return false;
            }
        }
        return false;
    }


    $(document).ready(function() {
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
                    isinotifikasi: 'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>

        <?php
        if (isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Params::MODUL_ID_RAD ?>,
                judulnotifikasi: 'Pasien Rujukan',
                isinotifikasi: '<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'
            }; // 16 
            insert_notifikasi(params);
        <?php
        }
        ?>
    });

</script>