<script>
    function inputPasien(data, id) {
        $("#pasien_" + id + "_pasien_id").val(data.pasien_id);
        if (!cekInputRMTidakSama()) {
            $("#pasien_" + id + "_pasien_id").val(null);
            $("#pasien_" + id + "_no_rekam_medik").val(null);
            return false;
        }
        $("#pasien_" + id + "_nama_pasien").val(data.nama_pasien);
        $("#pasien_" + id + "_no_rekam_medik").val(data.no_rekam_medik);
        $("#pasien_" + id + "_alamat_pasien").val(data.alamat_pasien);
        $("#pasien_" + id + "_jeniskelamin").val(data.jeniskelamin);
        $("#pasien_" + id + "_tanggal_lahir").val(data.tanggal_lahir);
        $.post("<?php echo $this->createUrl("ajaxLoadKunjungan"); ?>", {
            id: data.pasien_id,
            tipe: id
        }, function(data2) {
            $("#list_kunjungan_" + id).html(data2.html);
            $("#list_medis_" + id).html(data2.html_medis);
            $("#list_tagihan_" + id).html(data2.html_tagihan);
            updateAlertWarning(id, data2.jml_tabel, data2.tab_list, data.no_rekam_medik);
        }, "json");
    }
    function cekInputRMTidakSama() {
        var rm1 = $("#pasien_1_pasien_id").val();
        var rm2 = $("#pasien_2_pasien_id").val();
        if (rm1 == null || rm2 == null) return true;
        if (rm1 == rm2) {
            myAlert("Nomor RM yang akan digabungkan tidak boleh sama.");
            return false;
        }
        return true;
    }
    function updateAlertWarning(tipe, jml_tabel, tabl_list, no_rm) {
        if (tipe == 1) {
            $("#alert_tab_info #jml_tabel").html(jml_tabel);
            $("#alert_tab_info #rm_lama").html(no_rm);
        } else if (tipe == 2) {
            $("#alert_tab_info #rm_baru").html(no_rm);
        }
        cekAlertWarning();
    }
    function cekAlertWarning() {
        if ($("#alert_tab_info #rm_lama").html().trim() != "" &&
            $("#alert_tab_info #rm_baru").html().trim() != "") {
            $("#alert_tab_info").show();
            $(".submit").prop("disabled", false);
        } else {
            $("#alert_tab_info").hide();
            $(".submit").prop("disabled", true);
        }
    }
    function verifikasiSubmit() {
        var pasien1_id = $("#pasien_1_pasien_id").val();
        var pasien2_id = $("#pasien_2_pasien_id").val();
        $("#dialogVerifikasi").dialog("open");
        $("#frame_verifikasi").addClass("animation-loading");
        $.post('<?php echo $this->createUrl('ajaxVerifikasi'); ?>', {
            pasien1_id: pasien1_id,
            pasien2_id: pasien2_id
        }, function(data) {
            $("#no_rekam_medik_ver").html(data.rm_hasil.no_rekam_medik);
            $("#nama_pasien_ver").html(data.rm_hasil.nama_pasien);
            $("#tanggal_lahir_ver").html(data.rm_hasil.tanggal_lahir);
            $("#jeniskelamin_ver").html(data.rm_hasil.jeniskelamin);
            $("#alamat_pasien_ver").html(data.rm_hasil.alamat_pasien);
            $("#list_kunjungan").html(data.html);
            $("#list_medis").html(data.html_medis);
            $("#list_tagihan").html(data.html_tagihan);
            $("#frame_verifikasi").removeClass("animation-loading");
        }, 'json');
    }
    function confirmSubmit() {
        var rm_lama = $("#pasien_1_no_rekam_medik").val();
        var rm_baru = $("#pasien_2_no_rekam_medik").val();
        myConfirm("Anda yakin untuk menggabungkan seluruh data pasien dari RM " + rm_lama + " ke " + rm_baru + "?\n" +
            "Jika yakin, maka proses ini tidak bisa dibatalkan.", "Peringatan",
            function(r) {
                if (r) {
                    submitPindahDataRM();
                }
                $("#dialogVerifikasi").dialog("close");
            });
    }
    function submitPindahDataRM() {
        var rm_lama_id = $("#pasien_1_pasien_id").val();
        var rm_baru_id = $("#pasien_2_pasien_id").val();
        $("#alert_tab_info").hide();
        $("#alert_progress_info").show();
        var rm_progress = setInterval(function() {
            $.getJSON('<?php echo Yii::app()->baseUrl . "/assets/temp_rm/rm_" ?>' + rm_lama_id + "_" + rm_baru_id + ".json", function(data) {
                if (data) {
                    $("#jml_progress").html(data.progress);
                    $("#jml_progress_total").html(data.total);
                    $("#rm_progress_bar .progress-bar").css("width", (data.progress * 100 / data.total) + "%");
                    // console.log(data.progress, data.total);
                }
            });
        }, 1000);
        $.post('<?php echo $this->createUrl('ajaxMergeNoRM'); ?>', {
            pasienlama_id: rm_lama_id,
            pasienbaru_id: rm_baru_id
        }, function(data) {
            if (data.ok == 1) {
                toastr.success(data.msg);
                clearInterval(rm_progress);
                $("#alert_progress_info").hide();
                $("#rm_progress_bar .progress-bar").css("width", (0) + "%");
                resetForm();
            } else {
                toastr.error(data.msg);
            }
        }, 'json');
    }
    function resetForm() {
        $("#sadokrekammedis-m-form").trigger("reset");
        $("#alert_tab_info #rm_lama").html("");
        $("#alert_tab_info #rm_baru").html("");
        $("#alert_tab_info #jml_tabel").html("");
        $("#alert_tab_info").hide();
        $("#list_kunjungan_1, #list_kunjungan_2").empty();
        $("#list_medis_1, #list_medis_2").empty();
        $("#list_tagihan_1, #list_tagihan_2").empty();
        $("#pasien_1_pasien_id").val("");
        $("#pasien_2_pasien_id").val("");
        cekAlertWarning();
    }
</script>