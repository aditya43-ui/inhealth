<script type="text/javascript">
    function pernafasanDbn(obj) {
        var pernafasan = $('#EvaluasianestesiPraT_pernafasan_dbn');
        if (pernafasan.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'pernafasan_asma') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_bronkitis') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_ppok') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_dyspnea') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_orthopnea') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_pneumonia') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_ispa') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_sop') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_batukproduktif') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_tuberkulosis') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_efusipleura') ?>").attr('disabled', true);
            console.log("ok");
        } else {
            $("#<?php echo CHtml::activeId($model, 'pernafasan_asma') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_bronkitis') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_ppok') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_dyspnea') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_orthopnea') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_pneumonia') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_ispa') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_sop') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_batukproduktif') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_tuberkulosis') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'pernafasan_efusipleura') ?>").attr('disabled', false);
        }
    }

    function neuraDbn(obj) {
        var neura = $('#EvaluasianestesiPraT_neura_dbn');
        if (neura.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'neura_arthritis') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'neura_backproblem') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'neura_stoke') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'neura_nyerikepala') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'neura_penurunankesadaran') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'neura_kejang') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'neura_paralis') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'neura_kelemahanotot') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'neura_neuromuscular') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'neura_parestesia') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'neura_pingsan') ?>").attr('disabled', true);
        } else {
            $("#<?php echo CHtml::activeId($model, 'neura_arthritis') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'neura_backproblem') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'neura_stoke') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'neura_nyerikepala') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'neura_paralis') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'neura_penurunankesadaran') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'neura_kejang') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'neura_kelemahanotot') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'neura_neuromuscular') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'neura_parestesia') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'neura_pingsan') ?>").attr('disabled', false);
        }
    }

    function hepatoDbn(obj) {
        var hepato = $('#EvaluasianestesiPraT_hepato_dbn');
        if (hepato.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'hepato_obstruksiusus') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'hepato_hepatitis') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'hepato_sirosis') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'hepato_haitalhernia') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'hepato_mualmuntah') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'hepato_tukakpeptik') ?>").attr('disabled', true);
        } else {
            $("#<?php echo CHtml::activeId($model, 'hepato_obstruksiusus') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'hepato_hepatitis') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'hepato_sirosis') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'hepato_haitalhernia') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'hepato_mualmuntah') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'hepato_tukakpeptik') ?>").attr('disabled', false);
        }
    }

    function kardiovaskularDbn(obj) {
        var kardio = $('#EvaluasianestesiPraT_kardiovaskular_dbn');

        if (kardio.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_ekgabnormal') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_angina') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_artero_shd') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_gagaljantungkongesif') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_disritmia') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_limitasiaktifitas') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_hipertensi') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_infarkmyokard') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_murmur') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_pacemaker') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_dememrheuma') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_penyakitkatub') ?>").attr('disabled', true);
        } else {
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_ekgabnormal') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_angina') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_artero_shd') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_gagaljantungkongesif') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_disritmia') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_limitasiaktifitas') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_hipertensi') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_infarkmyokard') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_murmur') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_pacemaker') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_dememrheuma') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'kardiovaskular_penyakitkatub') ?>").attr('disabled', false);
        }
    }

    function renalDbn(obj) {
        var renal = $('#EvaluasianestesiPraT_renal_dbn');

        if (renal.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'renal_diebetmelitus') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'renal_gagalginjal') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'renal_penyakitthyroid') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'renal_retensiurine') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'renal_isk') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'renal_bb_turun') ?>").attr('disabled', true);
        } else {
            $("#<?php echo CHtml::activeId($model, 'renal_diebetmelitus') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'renal_gagalginjal') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'renal_penyakitthyroid') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'renal_retensiurine') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'renal_isk') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'renal_bb_turun') ?>").attr('disabled', false);
        }
    }

    function lainDbn(obj) {
        var lain = $('#EvaluasianestesiPraT_lainlain_dbn');
        if (lain.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'lainlain_anemia') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lainlain_bleeding') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lainlain_kanker') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lainlain_dehidrasi') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lainlain_hemofilia') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lainlain_immunosupresan') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lainlain_kehamilan') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lainlain_sicklescelldis') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lainlain_antikogulan') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lainlain_riwayattransfusi') ?>").attr('disabled', true);
        } else {
            $("#<?php echo CHtml::activeId($model, 'lainlain_anemia') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lainlain_bleeding') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lainlain_kanker') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lainlain_dehidrasi') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lainlain_hemofilia') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lainlain_immunosupresan') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lainlain_kehamilan') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lainlain_sicklescelldis') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lainlain_antikogulan') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lainlain_riwayattransfusi') ?>").attr('disabled', false);
        }
    }

    $("#<?php echo CHtml::activeId($model, 'anamnesadari_lainnya_keterangan') ?>").attr('disabled', true);
    $("#<?php echo CHtml::activeId($model, 'riwayatanestesi_keterangan') ?>").attr('disabled', true);
    $("#<?php echo CHtml::activeId($model, 'komplikasi_keterangan') ?>").attr('disabled', true);
    $("#<?php echo CHtml::activeId($model, 'riwayatalergi_keterangan') ?>").attr('disabled', true);
    $("#<?php echo CHtml::activeId($model, 'jumlahrokok') ?>").attr('disabled', true);
    $("#<?php echo CHtml::activeId($model, 'lamamerokok') ?>").attr('disabled', true);
    $("#<?php echo CHtml::activeId($model, 'lamaminumalkohol') ?>").attr('disabled', true);
    function setAnamnesa(obj) {
        var an = $('#EvaluasianestesiPraT_anamnesadari_pasien_2');
        if (an.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'anamnesadari_lainnya_keterangan') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'anamnesadari_lainnya_keterangan') ?>").attr('class', 'required');
        } else {
            $("#<?php echo CHtml::activeId($model, 'anamnesadari_lainnya_keterangan') ?>").val("").attr('disabled', true);
        }
    }

    function setRiwayat(obj) {
        var ada = $('#EvaluasianestesiPraT_riwayatanestesi_ada_1');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'riwayatanestesi_keterangan') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'riwayatanestesi_keterangan') ?>").attr('class', 'required');
        } else {
            $("#<?php echo CHtml::activeId($model, 'riwayatanestesi_keterangan') ?>").val("").attr('disabled', true);
        }
    }

    function setKomplikasi(obj) {
        var ada = $('#EvaluasianestesiPraT_komplikasi_ada_1');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'komplikasi_keterangan') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'komplikasi_keterangan') ?>").attr('class', 'required');
        } else {
            $("#<?php echo CHtml::activeId($model, 'komplikasi_keterangan') ?>").val("").attr('disabled', true);
        }
    }

    function setAlergi(obj) {
        var ada = $('#EvaluasianestesiPraT_riwayatalergi_ada_1');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'riwayatalergi_keterangan') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'riwayatalergi_keterangan') ?>").attr('class', 'required');
        } else {
            $("#<?php echo CHtml::activeId($model, 'riwayatalergi_keterangan') ?>").val("").attr('disabled', true);
        }
    }

    function setMerokok(obj) {
        var ada = $('#EvaluasianestesiPraT_merokok_ya_0');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'jumlahrokok') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lamamerokok') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'jumlahrokok') ?>").attr('class', 'required');
            $("#<?php echo CHtml::activeId($model, 'lamamerokok') ?>").attr('class', 'required');
        } else {
            $("#<?php echo CHtml::activeId($model, 'jumlahrokok') ?>").val("").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lamamerokok') ?>").val("").attr('disabled', true);
        }
    }
    
    function setBukaMulut(obj) {
        var ada = $('#EvaluasianestesiPraT_evaluasijalannafas_bukamulut3jari_ya');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'jumlahrokok') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lamamerokok') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'jumlahrokok') ?>").attr('class', 'required');
            $("#<?php echo CHtml::activeId($model, 'lamamerokok') ?>").attr('class', 'required');
        } else {
            $("#<?php echo CHtml::activeId($model, 'jumlahrokok') ?>").attr('disabled', true);
            $("#<?php echo CHtml::activeId($model, 'lamamerokok') ?>").attr('disabled', true);
        }
    }

    function setAlkohol(obj) {
        var ada = $('#EvaluasianestesiPraT_alkohol_ya_0');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'lamaminumalkohol') ?>").attr('disabled', false);
            $("#<?php echo CHtml::activeId($model, 'lamaminumalkohol') ?>").attr('class', 'required');
        } else {
            $("#<?php echo CHtml::activeId($model, 'lamaminumalkohol') ?>").val("").attr('disabled', true);
        }
    }

    function setBMI(obj) {
        var BB = $('#EvaluasianestesiPraT_beratbadan').val();
        var TB = $('#EvaluasianestesiPraT_tinggibadan').val();
        var tinggi = TB / 100;
        var t = tinggi * tinggi;
        var bmi = "";
        bmi = BB / t;
        if (BB != "" && TB != "") {
            $('#EvaluasianestesiPraT_bodymassindex').val(bmi.toFixed(2));
        }
        console.log(t);
        console.log(BB);
        console.log(TB);
        console.log(bmi);
    }
    $(document).ready(function () {
        setBMI();
        lainDbn();
        setAlkohol();
        setMerokok();
        pernafasanDbn();
        neuraDbn();
        hepatoDbn();
        kardiovaskularDbn();
        renalDbn();
        setAnamnesa();
        setRiwayat();
        setKomplikasi();
        setAlergi();
    });
</script>