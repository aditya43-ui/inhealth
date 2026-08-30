<script type="text/javascript">
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
        var rh = $.trim(jk);

        if (rh == '') {
            $('input[name$="[rhesus]"][type="radio"]').each(function () {
                $(this).attr('checked', false);
            });
            return false;
        }
        alert(rh);
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

    function cekLength(obj) {
        var cek = $(obj).val();

        if (cek == '<?php echo Params::JENIS_IDENTITAS_KTP ?>') {
            $("#<?php echo CHtml::activeId($modPendonor, 'no_identitas') ?>").attr('maxlength', 16);
        } else {
            $("#<?php echo CHtml::activeId($modPendonor, 'no_identitas') ?>").attr('maxlength', 30);
        }
    }
</script>

