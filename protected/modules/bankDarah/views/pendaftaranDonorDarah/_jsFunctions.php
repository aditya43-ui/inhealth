<script type="text/javascript">
    function setRuanganRekrutmen(obj) {
        <?php 
            $ruanganUTDRS = RuanganM::model()->findByPk(Params::RUANGAN_ID_BANK_DARAH); 
            $ruangan_id = '';
            $ruangan_nama = '';
            if(!empty($ruanganUTDRS)) {
                $ruangan_id = $ruanganUTDRS->ruangan_id;
                $ruangan_nama = $ruanganUTDRS->ruangan_nama;
            }
        ?>

        if($(obj).is(':checked')) {
            $('#ruangan_rekruitmen_id').val(<?= $ruangan_id ?>);
            $('#lokasi_rekruitmen').val("<?= $ruangan_nama ?>");
        } else {
            $('#ruangan_rekruitmen_id').val('');
            $('#lokasi_rekruitmen').val("");
        }


    }

    function setRuangan(data){
        $("#<?php echo CHtml::activeId($modDaftarDonasi, 'ruangan_rekruitmen_id') ?>").val(data.ruangan_id);
        $("#<?php echo CHtml::activeId($modDaftarDonasi, 'ruangan_rekruitmen_nama') ?>").val(data.ruangan_nama);
                        
        $("#dialogRuangan").dialog('close');
        
        $("#<?php echo CHtml::activeId($modDaftarDonasi, 'dialogRuangan') ?>").blur();
    }


    function setPendonorLama(pendonor_id) {


    }
    function setJenisKelamin(jk) {
        $('input[name$="[jenis_kelamin]"][type="radio"]').each(function () {
            if ($(this).val() == $.trim(jk)) {
                $(this).attr('checked', true);
            }
        });
    }
    function setGolonganDarah(jk) {
        $('input[name$="[gol_darah]"][type="radio"]').each(function () {
            if ($(this).val() == $.trim(jk)) {
                $(this).attr('checked', true);
            }
        });
    }
    function setRhesus(jk) {
        if (jk == 'RH+') {
            var a = 'Positif';
            var rh = $.trim(a);
        } else if (jk == 'RH-') {
            var a = 'Negatif';
            var rh = $.trim(a);
        } else {
            var rh = $.trim(jk);
        }

        if (rh == '') {
            $('input[name$="[rhesus]"][type="radio"]').each(function () {
                $(this).attr('checked', false);
            });
            return false;
        }

        $('input[name$="[rhesus]"][type="radio"]').each(function () {
            var data = $(this).val();


            if (data.toLowerCase() == rh.toLowerCase()) {
                $(this).attr('checked', true);
            }
        });
    }
    
    function setPernah_donor(jk) {
        $('input[name$="[is_pernah_donor]"][type="radio"]').each(function () {
            if ($(this).val() == $.trim(jk)) {
                $(this).attr('checked', true);
            }
        });
    }
    
    function cekPernahDonor(obj) {
        var status = $(obj).val();

        if (status == 0) {
            $('#BDPendonorM_donasi_ke').attr('disabled', true);
            $('#BDPendonorM_tempat_donor_terakhir').attr('disabled', true);
            $('#BDPendonorM_tgl_donor_terakhir').attr('disabled', true);
            $("#tgl_terkahir").find(".add-on").hide();
            $("#BDPendonorM_is_pernahdonor1").val('tidak');

        } else {
            $('#BDPendonorM_donasi_ke').removeAttr('disabled', true);
            $('#BDPendonorM_tempat_donor_terakhir').removeAttr('disabled', true);
            $('#BDPendonorM_tgl_donor_terakhir').removeAttr('disabled', true);
            $("#tgl_terkahir").find(".add-on").show();
            $("#BDPendonorM_is_pernahdonor1").val('pernah');
        }
    }
    
    /* set Tanggal*/
    function setTglLahir(tgl)
    {
        var tgl = tgl;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetTanggalLahir'); ?>',
            data: {tgl: tgl},
            dataType: "json",
            success: function (data) {
                $("#BDPendonorM_tgllahir").val(data.tgllahir);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setTgl(tgl)
    {
        var tgl = tgl;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetTanggalTerakhirDonor'); ?>',
            data: {tgl: tgl},
            dataType: "json",
            success: function (data) {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

   /**
    * 
    * @param {type} obj
    * @returns {change attribute maxlength}
    */
    function cekLength(obj){
       var cek = $(obj).val();

       $("#<?php echo CHtml::activeId($modPendonor, 'no_identitas') ?>").attr('onkeyup','setNumbersOnly(this);return $(this).focusNextInputField(event);');    
       if (cek == '<?php echo Params::JENIS_IDENTITAS_KTP ?>'){
           $("#<?php echo CHtml::activeId($modPendonor, 'no_identitas') ?>").attr('maxlength',16);
           $("#<?php echo CHtml::activeId($modPendonor, 'no_identitas') ?>").keyup();
       }else{
           $("#<?php echo CHtml::activeId($modPendonor, 'no_identitas') ?>").attr('maxlength',30);        

           if (cek == '<?php echo Params::JENIS_IDENTITAS_PASPOR ?>'){                                                
               $("#<?php echo CHtml::activeId($modPendonor, 'no_identitas') ?>").attr('onkeyup','setAlphaNumericOnly(this);return $(this).focusNextInputField(event);');                                    
           }
           $("#<?php echo CHtml::activeId($modPendonor, 'no_identitas') ?>").keyup();
       }
    }

    /**
     * set propinsi, kabupaten, kecamatan, dan kelurahan
     * @param {type} propinsi_id
     * @param {type} kabupaten_id
     * @param {type} kecamatan_id
     * @param {type} kalurahan_id
     * @returns {undefined}
     */
    function setDaerah(propinsi_id, kabupaten_id, kecamatan_id, kelurahan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownDaerahPegawai'); ?>',
            data: {propinsi_id: propinsi_id, kabupaten_id: kabupaten_id, kecamatan_id: kecamatan_id, kelurahan_id: kelurahan_id},
            dataType: "json",
            success: function (data) {
                $("#<?php echo CHtml::activeId($modPendonor, "propinsi_id"); ?>").html(data.listPropinsi);
                $("#<?php echo CHtml::activeId($modPendonor, "kabupaten_id"); ?>").html(data.listKabupaten);
                $("#<?php echo CHtml::activeId($modPendonor, "kecamatan_id"); ?>").html(data.listKecamatan);
                $("#<?php echo CHtml::activeId($modPendonor, "kelurahan_id"); ?>").html(data.listKelurahan);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function cekForm() {
        if (requiredCheck($("#pendaftaranDonorDarah-t-form"))) {
            var cek = $("#BDPendonorM_is_pernah_donor_0").prop("checked");
            var donasi_itd = $('#BDPendonorM_donor_itd_ke').val();
            $("#BDPendonorM_donasi_ke").attr('style', '');
            // if (cek == true && donasi_itd == '') {
            //     if ($("#BDPendonorM_donasi_ke").val() == 0) {
            //         $("#BDPendonorM_donasi_ke").attr('style', 'border:red 1px solid');
            //         myAlert("Data Donasi Terakhir wajib diisi");
            //         return false;
            //     }
            // } 
            if($('#BDDaftardonasiT_ruangan_rekruitmen_id').val() == 0){
                myAlert("Lokasi Rekrutmen harus diisi!");
                return false;
            }else{
                $("#pendaftaranDonorDarah-t-form").submit();
            }
        }
        return false;
    }

    /**
     * set propinsi, kabupaten, kecamatan, dan kelurahan
     * @param {type} propinsi_id
     * @param {type} kabupaten_id
     * @param {type} kecamatan_id
     * @param {type} kalurahan_id
     * @returns {undefined}
     */
    function setDaerahPasien(propinsi_id, kabupaten_id, kecamatan_id, kelurahan_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownDaerahPasien'); ?>',
            data: {propinsi_id: propinsi_id, kabupaten_id: kabupaten_id, kecamatan_id: kecamatan_id, kelurahan_id: kelurahan_id},
            dataType: "json",
            success: function (data) {
                $("#<?php echo CHtml::activeId($modPendonor, "propinsi_id"); ?>").html(data.listPropinsi);
                $("#<?php echo CHtml::activeId($modPendonor, "kabupaten_id"); ?>").html(data.listKabupaten);
                $("#<?php echo CHtml::activeId($modPendonor, "kecamatan_id"); ?>").html(data.listKecamatan);
                $("#<?php echo CHtml::activeId($modPendonor, "kelurahan_id"); ?>").html(data.listKelurahan);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    var input_propinsi = $("<?php echo "#" . CHtml::activeId($modPendonor, 'propinsi_id'); ?>");
    var input_kabupaten = $("<?php echo "#" . CHtml::activeId($modPendonor, 'kabupaten_id'); ?>");
    var input_kecamatan = $("<?php echo "#" . CHtml::activeId($modPendonor, 'kecamatan_id'); ?>");
    var input_kelurahan = $("<?php echo "#" . CHtml::activeId($modPendonor, 'kelurahan_id'); ?>");
    $(document).ready(function () {
        <?php if (isset($_GET['sukses'])) { ?>
            $("input, select, textarea").attr("readonly", true);
            $('#BDPendonorM_donasi_ke').attr('disabled', true);
            $('#BDPendonorM_tempat_donor_terakhir').attr('disabled', true);
            $('#BDPendonorM_tgl_donor_terakhir').attr('disabled', true);
            $("#tgl_terkahir").find(".add-on").hide();
        <?php } ?>
        $("#BDPendonorM_is_pernahdonor1").val('pernah');

        jQuery(input_propinsi).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                $.post('<?php echo $this->createUrl('/ActionDynamic/GetKabupaten', array('encode' => false, 'model_nama' => get_class($modPendonor))) ?>', {
                    "BDPendonorM": {
                        propinsi_id: $(input_propinsi).val()
                    }
                }, function(data) {
                    $(input_kabupaten).html(data);
                    $(input_kabupaten).multiselect("rebuild");
                });
            }
        }).hide();

        jQuery(input_kabupaten).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                $.post('<?php echo $this->createUrl('/ActionDynamic/GetKecamatan', array('encode' => false, 'model_nama' => get_class($modPendonor))) ?>', {
                    "BDPendonorM": {
                        kabupaten_id: $(input_kabupaten).val()
                    }
                }, function(data) {
                    $(input_kecamatan).html(data);
                    $(input_kecamatan).multiselect("rebuild");
                });
            }
        }).hide();

        jQuery(input_kecamatan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                $.post('<?php echo $this->createUrl('/ActionDynamic/GetKelurahan', array('encode' => false, 'model_nama' => get_class($modPendonor))) ?>', {
                    "BDPendonorM": {
                        kecamatan_id: $(input_kecamatan).val()
                    }
                }, function(data) {
                    $(input_kelurahan).html(data);
                    $(input_kelurahan).multiselect("rebuild");
                });
            }
        }).hide();

        jQuery(input_kelurahan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
    });
</script>

