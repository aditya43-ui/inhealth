<div class="panel panel-success">
    <div class="panel-body" id="panel_form_cari_pasien_bpjs">
        <h4>Silahkan Masukkan No. BPJS atau NIK Anda</h4>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php echo CHtml::radioButtonList('jenis_no_bpjs', '', array(1 => 'No. Peserta', 2 => 'NIK'), array(
                    'template'=>'<div class="radio-inline">{input}{label} </div>', 'class'=>'jenis_no_bpjs',
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">&nbsp;</label>
            <div class="controls">
                <?php echo CHtml::textField('cari_no_peserta_bpjs', '', array(
                    'class'=>'span4',
                )); ?>
            </div>
        </div>
        <div class="row-fluid">
            <?php echo CHtml::htmlButton('<i class="entypo-search"></i> Cari', array(
                'class'=>'btn btn-success', 'onclick'=>'cariPasienBPJS();', 'id'=>'btn_cari_pasien_bpjs'
            )); ?>
        </div>
    </div>
</div>
<br/>
<div class="row-fluid" style="text-align: center">
    <?php echo CHtml::htmlButton("<i class='entypo-home'></i>Kembali ke Halaman Awal", array(
        'class'=>'btn btn-info', 'onclick'=>"kembaliKeHalamanAwal();"
    )); ?>
</div>



<script>
    function cariPasienBPJS() {
        var jenis = $(".jenis_no_bpjs:checked").val();
        var nomor = $("#cari_no_peserta_bpjs").val();

        if (nomor.trim() == "") {
            return false;
        }

        // $("#cari_nomor_pasien").addClass("animation-loading");

        if (jenis == 1) {
            loadNoPesertaBPJS(nomor);
        } else if (jenis == 2) {
            loadNIKBPJS(nomor);
        }
    }

    function loadNoPesertaBPJS(nomor) {
        $.ajax({
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=1&query=' + nomor,
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.response != null) {
                    console.log(obj);

                    var peserta = obj.response.peserta;

                    $.post('<?php echo $this->createUrl('cekPasienBerdasarkanNoAsuransi'); ?>', {
                        nomor: peserta.noKartu
                    }, function(data) {
                        if (data.ok == 1) {

                            $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                            $("#cari_tanggal_lahir").val(data.tgl_lahir);

                            cariPasien();
                            getAsuransiNoPeserta(nomor);
                        } else {
                            myAlert("Data Kepesertaan BPJS Tidak Ditemukan!<br/>Pastikan yang diinputkan benar atau hubungi petugas pendaftaran.");
                        }
                    }, 'json');

                } else {
                    myAlert(obj.metaData.message);
                    //$("#cari_nomor_pasien").removeClass("animation-loading").val("");
                }
            },
            error: function(data) {
                //$("#cari_nomor_pasien").removeClass("animation-loading");
            }
        });
    }

    function loadNIKBPJS(nomor) {
        $.ajax({
            url: "<?php echo $this->createUrl('bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=2&query=' + nomor,
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.response != null) {

                    var peserta = obj.response.peserta;

                    $.post('<?php echo $this->createUrl('cekPasienBerdasarkanNoAsuransi'); ?>', {
                        nomor: peserta.noKartu
                    }, function(data) {
                        if (data.ok == 1) {

                            $("#cari_no_rekam_medik").val(data.no_rekam_medik);
                            $("#cari_tanggal_lahir").val(data.tgl_lahir);


                            cariPasien();
                            getAsuransiNoPeserta(peserta.noKartu);
                        } else {
                            myAlert("Data Kepesertaan BPJS Tidak Ditemukan!<br/>Pastikan yang diinputkan benar atau hubungi petugas pendaftaran.");
                        }
                        // $("#cari_nomor_pasien").removeClass("animation-loading");
                    }, 'json');


                } else {
                    myAlert(obj.metaData.message);
                    // $("#cari_nomor_pasien").removeClass("animation-loading").val("");;
                }
            },
            error: function(data) {
                //$("#cari_nomor_pasien").removeClass("animation-loading");
            }
        });
    }

</script>

