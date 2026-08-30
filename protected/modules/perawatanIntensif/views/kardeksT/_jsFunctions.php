<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
    $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
?>

<script>
    var is_neonatus = <?php echo $pendaftaran->masihBayi ? 1 : 0; ?>;
    
    
    function hitungBalanceCairan() {
        
        var allpanel = $(".balance_panel");
        var panel = $(".balance_panel:visible");
        var panel_id = "#" + panel.prop("id");
        
        // hitung IWL #1
        var konstanta = parseFloat(unformatNumber(panel.find(".balance_konstanta").val()));
        var berat_badan = parseFloat(unformatNumber(panel.find(".balance_beratbadan").val()));
        var jam = parseFloat(unformatNumber(panel.find(".balance_jam").val()));
        var usia = parseFloat(unformatNumber(panel.find(".balance_usia").val()));
        var jmlcairan = parseFloat(unformatNumber(panel.find(".balance_jmlcairan").val()));
        var iwl_jam = 0;
        var iwl1 = 0;
        var diresis = 0;
        
        switch (panel.prop("id")) {
            case "balance_dewasa":
                iwl_jam = konstanta * berat_badan / 24;
                iwl1 = iwl_jam * jam;
                break;
            case "balance_anak":
                iwl1 = 30 - (usia * jmlcairan); break;
            case "balance_neonatus":
                iwl1 = berat_badan * konstanta / 3; 
                diresis = iwl1 / (berat_badan / 8);
                
                if (!isNaN(berat_badan)) {
                    if (berat_badan >= 0.750 && berat_badan <= 1.000) {
                        konstanta = 64;
                    } else if (berat_badan >= 1.001 && berat_badan <= 1.250) {
                        konstanta = 56;
                    } else if (berat_badan >= 1.251 && berat_badan <= 1.500) {
                        konstanta = 38;
                    } else if (berat_badan >= 1.501 && berat_badan <= 1.750) {
                        konstanta = 23;
                    } else if (berat_badan >= 1.751 && berat_badan <= 3.500) {
                        konstanta = 20;
                    } 
                }
                
                panel.find(".balance_konstanta").val(formatNumber(konstanta));
                
                break;
        }
        
        panel.find(".balance_iwl_jam").val(formatFloat2(iwl_jam));
        panel.find(".balance_iwl").val(formatFloat2(iwl1));
        panel.find(".balance_diuresis").val(formatFloat2(diresis));
        
        
        
        // hitung intake
        allpanel.find(".balance_total_intake").val(panel.find(".balance_total_intake").val());
        allpanel.find(".balance_total_output").val(panel.find(".balance_total_output").val());
        allpanel.find(".balance_total_sebelum").val(panel.find(".balance_total_sebelum").val());
        
        var total_intake = unformatNumber(parseFloat(panel.find(".balance_total_intake").val()));
        var total_output = unformatNumber(parseFloat(panel.find(".balance_total_output").val()));
        var total_sebelum = unformatNumber(parseFloat(panel.find(".balance_total_sebelum").val()));
        var hasil = 0;
        
        if (!isNaN(total_intake) && !isNaN(total_output)) {
            allpanel.find(".balance_total_sekarang").val(formatFloat2(total_intake - (total_output + iwl1)));
            hasil = total_intake - (total_output + iwl1);
        } else {
            allpanel.find(".balance_total_sekarang").val(0);
        }
        
        if (!isNaN(total_sebelum)) {
            allpanel.find(".balance_total_komulatif").val(formatFloat2(total_sebelum + hasil));
        } else {
            allpanel.find(".balance_total_komulatif").val(formatFloat2(hasil));
        }
        
        
        // hitung IWL #2
        var cairan_masuk = parseFloat(unformatNumber(panel.find(".balance_cairanmasuk").val()));
        var konstanta_suhu = unformatNumber(parseFloat(panel.find(".balance_konstanta_suhu").val()));
        var kenaikan_suhu = unformatNumber(parseFloat(panel.find(".balance_kenaikan_suhu").val()));
        var iwl2 = 0;
        
        switch (panel.prop("id")) {
            case "balance_anak":
            case "balance_dewasa":
                iwl2 = ((konstanta_suhu * cairan_masuk / 100) * (kenaikan_suhu / 24)) + iwl1;
                console.log("Kick1");
                break;
            case "balance_neonatus":
                console.log(konstanta_suhu, total_intake, kenaikan_suhu, iwl1);
                iwl2 = ((konstanta_suhu * total_intake) * (kenaikan_suhu/24)) + iwl1;
                console.log("Kick2");
                break;
        }
        
        
        
        panel.find(".balance_iwl_kenaikan_suhu").val(formatFloat2(iwl2));
        
    }
    
    function disableInputHemodinamik() {
        $(".hemo_panel")
                .hide()
                .find(":input")
                .prop("disabled", true);
        $(".balance_panel")
                .hide()
                .find(":input")
                .prop("disabled", true);
        $(".gcs_panel")
                .hide()
                .find(":input")
                .prop("disabled", true);
        
    }
    function pilihFormHemo() {
        var is_dewasa = $(".cb_pilih_hemo:checked").val();
        
        disableInputHemodinamik();
        
        if (is_dewasa == 1) {
            $("#balance_dewasa").show().find(":input").prop("disabled", false);
            $(".gcs_dewasa").show().find(":input").prop("disabled", false);
            $("#judul_panel_balance").html($("#balance_dewasa").data('judul'));
        } else {
            $("#balance_neonatus").show().find(":input").prop("disabled", false);
            $(".gcs_bayi").show().find(":input").prop("disabled", false);
            $("#judul_panel_balance").html($("#balance_neonatus").data('judul'));
        }
        
        hitungSkorSedasi();
    }
    
    function hitungSkorSedasi() {
        var total = 0;
        $(".input_gcs:not(:disabled)").each(function(data) {
                if (!isNaN(parseInt($(this).val()))) {
                total += parseInt($(this).val());
            }
        });
        
        var textval = "Coma";
        if(total==3){
            var textval = "Coma";
        }else if(total==4){
            var textval = "Semi-Coma";
        }else if(total>=5 && total<=6){
            var textval = "Sopor";
        }else if(total>=7 && total<=9){
            var textval = "Somnolen";
        }else if(total>=10 && total<=11){
            var textval = "Delirium";
        }else if(total>=12 && total<=13){
            var textval = "Apatis";
        }else if(total>=14){
            var textval = "Composmentis";
        }
        
        
        $(".ssp_kesadaran").val(textval);
    }
    
    function susunMMHG() {
        var hasil = new Array();
        $(".txt_mmhg").each(function() {
            hasil.push($(this).val());
        });
        
        $(".hemo_map").val(hasil.join("/"));
        
        getText();
    }
    
    function getText(){
        var sys = parseFloat($('.hemo_dewasa_sistol').val());
        var dias = parseFloat($('.hemo_dewasa_diastol').val());
        var arteri = ((sys+(2*dias))/3);

        if (jQuery.isNumeric(dias)){
            if (jQuery.isNumeric(sys)){
                $.post('<?php echo $this->createUrl('/rawatJalan/pemeriksaanFisik/GetTextTekananDarah'); ?>', {diastolic:dias, systolic:sys}, function(data){
                    if (data.text == null){
                        $('.tekandarah').val('Tekanan Darah Tidak Ditemukan');
                    } else {
                        $('.tekandarah').val(data.text);
                    }
                },'json');
                $('.hemo_map2').val(arteri.toFixed(2));
            }
        }
        
    }
    
    
    $(document).ready(function() {
        pilihFormHemo();
        susunMMHG();
        $(".cb_pilih_hemo").on("click", pilihFormHemo);
        $(".txt_mmhg").on("keyup", susunMMHG);
        $(".balance_panel :input").on("blur", hitungBalanceCairan);
        $(".balance_panel :input").on("change", hitungBalanceCairan);
        $(".input_gcs").on("change", hitungSkorSedasi);
        hitungBalanceCairan();
    });
    
    function hapusRiwayat(kardeks_id, pendaftaran_id) {
        myConfirm('Yakin Ingin Menghapus Data?','Perhatian !', function (y) { 
            if(y) {
                $.post('<?= $this->createUrl('delete') ?>', {
                    kardeks_id:kardeks_id,
                    pendaftaran_id:pendaftaran_id
                }, function(data) {
                    if(data.sukses == 1) {
                        <?php if(isset($_GET['kardeks_id'])) { ?>
                            window.parent.toastr.success('Data Berhasil Dihapus');
                            location.href = '<?= $this->createUrl('create') ?>' + '&pendaftaran_id=' +pendaftaran_id;
                        <?php } else { ?>
                            window.parent.toastr.success('Data Berhasil Dihapus');
                            $.fn.yiiGridView.update('daftarPasien-grid');
                        <?php } ?>
                    } else {
                        myAlert('Data gagal dihapus');
                    }
                }, 'json');
            }
        });
    }
    
</script>