<script>
    function hitungTotal(){
        var tot_terima = 0;
        var tot_permintaan = 0;
        $("#tab_terimadarah > tr").each(function(){
           var terima = parseInt($(this).find('.jumlah_terima') .val());
           var permintaan = parseInt($(this).find('.jumlah_permintaan_label').html());
           
           tot_terima += terima;
           tot_permintaan += permintaan;           
        });
        
        $(".total_permintaan").html(tot_permintaan);
        $(".total_penerimaan").html(tot_terima);
        $("#<?php echo CHtml::activeId($model, 'jumlah_terima') ?>").val(tot_terima);
    }
    
    var row = <?php echo CJSON::encode(array(
        'html'=>$this->renderPartial($this->path_view."form/_rowDarah", array(
            'item'=>new PermintaandarahpmidetT,
            'cnt'=>0,
            'jenis'=>new JeniskomponendarahM()
        ), true),
    )); ?>
        
    function tambahItem() {
        
        var jenis = $("#PenerimaandarahpmidetT_jeniskomponendarah_id").val();
        var golongan = $("#PenerimaandarahpmidetT_golongandarah").val();
        var rhesus = $(".form_rhesus:checked").val();
        
        // validasi
        if ($("#PenerimaandarahpmidetT_jeniskomponendarah_id").val() == "") {
            myAlert("Jenis Komponen Darah harus diisi");
            
            return false;
        }
        if ($("#PenerimaandarahpmidetT_golongandarah").val() == "") {
            myAlert("Golongan Darah harus diisi");
            
            return false;
        }
        if ($("#PenerimaandarahpmidetT_jumlah_terima").val() == "") {
            myAlert("Jumlah terima Darah harus diisi");

            return false;
        }
        
        if ($(".form_rhesus:checked").length == 0) {
            myAlert("Rhesus harus diisi");
            return false;
        }
        
        var sudah_ada = false;
        $("#tab_terimadarah tr").each(function() {
            if ($(this).find(".jeniskomponendarah_id").val() == jenis
                    && $(this).find(".golongandarah").val() == golongan
                    && $(this).find(".rhesus").val() == rhesus) {
                sudah_ada = true;
            }
        });
        
        
        if (sudah_ada) {
            myAlert("Jenis, Golongan, dan Rhesus sudah ditambahkan sebelumnya.");
            return false;
        }
        
        
        // set data item
        $("#tab_terimadarah").append(row.html);
        
        var akhir = $("#tab_terimadarah tr:last-child");
        
        $(akhir).find(".jeniskantongdarah_singkatan").html($("#PenerimaandarahpmidetT_jeniskomponendarah_id :selected").data('singkatan'));
        $(akhir).find(".jeniskomponendarah_id").val($("#PenerimaandarahpmidetT_jeniskomponendarah_id").val());
        $(akhir).find(".golongandarah_label").html($("#PenerimaandarahpmidetT_golongandarah").val());
        $(akhir).find(".golongandarah").val($("#PenerimaandarahpmidetT_golongandarah").val());
        $(akhir).find(".rhesus_label").html($(".form_rhesus:checked").val());
        $(akhir).find(".rhesus").val($(".form_rhesus:checked").val());
        $(akhir).find(".jumlah_terima")
                .val($("#PenerimaandarahpmidetT_jumlah_terima").val())
                .maskMoney(
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0}
                );
        $(akhir).find(".keterangan_det").val($("#PenerimaandarahpmidetT_keterangan_det").val());
        
        $("#subform_detail :input").not(".form_rhesus").val(null);
        $(".form_rhesus:checked").prop("checked", false);
        
        renameBaris();
        hitungTotal();
        $("#petugas_penerima_nama").blur();
    }
    
    function setPermintaan(id) {
        $.post('<?php echo $this->createUrl('setLoadPermintaan'); ?>', {id: id}, function(data) {
            console.log(data);
            
            // form
            $(".no_permintaan").val(data.no_permintaan);
            $(".permintaandarahpmi_id").val(data.permintaandarahpmi_id);
            $("#PermintaandarahpmiT_petugas_nama").val(data.nama_petugas);
            $("#PermintaandarahpmiT_instalasi_nama").val(data.instalasi_nama);
            $("#PermintaandarahpmiT_ruangan_nama").val(data.ruangan_nama);
            $("#PermintaandarahpmiT_tgl_permintaan").val(data.tgl_permintaan);
            $("#PermintaandarahpmiT_keterangan_permintaan").val(data.keterangan_permintaan);
            
            // tabel
            $("#tab_terimadarah").html(data.row);
            $("#tab_terimadarah .jumlah_terima").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0}
            );
            renameBaris();
            hitungTotal();
            $("#petugas_penerima_nama").blur();
            
        }, 'json');
    }
    
    function renameBaris() {
        var cnt = 0;
        $("#tab_terimadarah tr").each(function() {
            $(this).find(".nomor").html(cnt + 1);
            $(this).find(".jeniskomponendarah_id").prop("name","detail[" + cnt + "][jeniskomponendarah_id]");
            $(this).find(".golongandarah").prop("name","detail[" + cnt + "][golongandarah]");
            $(this).find(".rhesus").prop("name","detail[" + cnt + "][rhesus]");
            $(this).find(".jumlah_permintaan").prop("name","detail[" + cnt + "][jumlah_permintaan]");
            $(this).find(".jumlah_terima").prop("name","detail[" + cnt + "][jumlah_terima]");
            $(this).find(".keterangan_det").prop("name","detail[" + cnt + "][keterangan_det]");
            $(this).find(".penerimaandarahpmidet_id").prop("name","detail[" + cnt + "][penerimaandarahpmidet_id]");            
            cnt++;
        });
        
        $("#PenerimaandarahpmiT_keterangan_penerimaan").blur();
    }
    
    $(document).ready(function() {
        setValidasiCekDisabled($("#penerimaandarah-form"), function() {
            if ($("#tab_terimadarah > tr").length == 0) {
                return false;
            }
            
            
//            var is_nol = false;
//            $("#tab_terimadarah .jumlah_terima").each(function() {
//                if ($(this).val() == 0) {
//                    is_nol = true;
//                }
//            });
//            
//            if (is_nol) {
//                return false;
//            }
            
            return true;
        });
        
        <?php if (!empty($permintaandarahpmi_id) && empty($model->penerimaandarahpmi_id)): ?>
        setPermintaan(<?php echo $permintaandarahpmi_id; ?>);
        <?php endif; ?>
        
        
          unformatNumberSemua();
          formatNumberSemua();
    });
    
</script>