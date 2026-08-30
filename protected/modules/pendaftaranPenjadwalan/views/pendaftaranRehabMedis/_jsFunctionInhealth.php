<script type="text/javascript">
    
    function EligibilitasPeserta(nokainhealth)
    {
        if (<?php echo (Yii::app()->user->getState('bridging_inhealth') == TRUE) ? 1 : 0; ?>) {
        } else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        
        var aksi = 1; // 1 untuk cek eligibilitas pesertas
        var tglpelayanan = '<?=$modSepInhealthT->tglsep?>';
        var jenispelayanan = '<?=$modSepInhealthT->jnspelayanan?>';
        var poli = $("#<?php echo CHtml::activeId($model,'ruangan_id');?>").val();
        if(poli == undefined){
            var poli = $("#PPPasienAdmisiT_ruangan_id").val();
        }
        
        if (nokainhealth == "") {
            myAlert('Isi data no kartu terlebih dahulu!');
            return false;
        }
        if (poli == "") {
            myAlert('Isi data poli/ruangan terlebih dahulu!');
            return false;
        }

        var setting = {
            url: "<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/inhealthInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&nokainhealth=' +nokainhealth+ '&tglpelayanan=' +tglpelayanan+ '&jenispelayanan=' +jenispelayanan+ '&poli=' +poli,
            beforeSend: function () {
                $("#content-inhealth").addClass("animation-loading");
            },
            success: function (data) {
                $("#content-inhealth").removeClass("animation-loading");
                var peserta = JSON.parse(data);
                if(peserta.ERRORCODE!='00'){
                    myAlert(peserta.ERRORDESC);
                }else{
                    $("#<?php echo CHtml::activeId($modAsuransiPasienInhealth, 'nopeserta') ?>").val(peserta.NOKAPST);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienInhealth, 'nokartuasuransi') ?>").val(peserta.NOKAPST);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienInhealth, 'namapemilikasuransi') ?>").val(peserta.NMPST);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienInhealth, 'kelastanggunganasuransi_id') ?>").val(peserta.KODEKELASRAWAT);
                    $("#<?php echo CHtml::activeId($modAsuransiPasienInhealth, 'kelastanggunganasuransi_nama') ?>").val(peserta.NAMAKELASRAWAT);
                    $("#<?php echo CHtml::activeId($modSepInhealthT, 'ppkrujukan') ?>").val(peserta.KODEPROVIDER);
                    $("#<?php echo CHtml::activeId($modRujukanInhealth, 'nama_perujuk') ?>").val(peserta.NAMAPROVIDER);

                    getRujukanDari(peserta.KODEPROVIDER);
                    $("#<?php echo CHtml::activeId($modRujukanInhealth, 'no_rujukan') ?>").val('-');
                    $("#<?php echo CHtml::activeId($modSepInhealthT, 'catatansep') ?>").val('-');
                }
            },
            error: function (data) {
                $("#content-inhealth").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }
    
    function setNamaPerujukInhealth(){
        var rujukandari_id = $("#<?php echo CHtml::activeId($modRujukanInhealth, 'rujukandari_id')?>").val();
        var nama_perujuk = $("#<?php echo CHtml::activeId($modRujukanInhealth, 'rujukandari_id')?>").find('option[value="'+rujukandari_id+'"]').text();
        $("#<?php echo CHtml::activeId($modRujukanInhealth, 'nama_perujuk')?>").val(nama_perujuk);
    }

    function getPPKInhealth(obj) {
        var id = $(obj).val();
        $("#<?php echo CHtml::activeId($modSepInhealthT, 'ppkrujukan')?>").val("");
        if(id != ''){
            $.post('<?php echo $this->createUrl('getPPKRujukan'); ?>', {rujukan_id: id}, function(data) {
                $("#<?php echo CHtml::activeId($modSepInhealthT, 'ppkrujukan')?>").val(data);
            });
        }
    }
    
    function verifikasiSjp(obj,ket){
        if (<?php echo (Yii::app()->user->getState('bridging_inhealth') == TRUE) ? 1 : 0; ?>) {
        } else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }
        
        var tanggalpelayanan = $("#<?php echo CHtml::activeId($model,'tgl_pendaftaran');?>").val();
        var nokainhealth = $("#<?php echo CHtml::activeId($modAsuransiPasienInhealth,'nopeserta');?>").val();
        var jenispelayanan = <?=$modSepInhealthT->jnspelayanan?>;
        var nomormedicalreport = $("#cari_no_rekam_medik").val();
        var nomorasalrujukan = $("#<?php echo CHtml::activeId($modRujukanInhealth,'no_rujukan');?>").val();
        var kodeproviderasalrujukan = $("#<?php echo CHtml::activeId($modSepInhealthT,'ppkrujukan');?>").val();
        var tanggalasalrujukan = $("#<?php echo CHtml::activeId($modRujukanInhealth,'tanggal_rujukan');?>").val();
        var kodediagnosautama = $("#<?php echo CHtml::activeId($modSepInhealthT,'diagnosaawal');?>").val();
        var poli = $("#<?php echo CHtml::activeId($model,'ruangan_id');?>").val();
        var informasitambahan = $("#<?php echo CHtml::activeId($modSepInhealthT,'catatansep');?>").val();
        var kodediagnosatambahan = $("#<?php echo CHtml::activeId($modSepInhealthT,'kodediagnosatambahan');?>").val();
        var kecelakaankerja = $("#<?php echo CHtml::activeId($modSepInhealthT,'lakalantas');?>").val();
        var klsrawat = $("#<?php echo CHtml::activeId($modAsuransiPasienInhealth,'kelastanggunganasuransi_id');?>").val();
        
        var kelaspelayanan_id = $("#PPPendaftaranT_kelaspelayanan_id").val();
        if(kelaspelayanan_id == undefined){
            var kelaspelayanan_id = $("#PPPasienAdmisiT_kelaspelayanan_id").val();
            if(kelaspelayanan_id == undefined){
                var kelaspelayanan_id = null;
            }
        }
        
        if(tanggalpelayanan == undefined){
            tanggalpelayanan = $("#PPPasienAdmisiT_tgladmisi").val();
            if(tanggalpelayanan == undefined){
                tanggalpelayanan = $("#<?php echo CHtml::activeId($modSepInhealthT,'tglsep');?>").val();
            }
        }
        if(nomormedicalreport == undefined){
            nomormedicalreport = $("#<?php echo CHtml::activeId($modPasien, 'no_rekam_medik') ?>").val();
        }
        if(poli == ""){
            myAlert("Pilih Ruangan untuk syarat SEP");
            return false;
        }
        if(poli == undefined){
            var poli = $("#PPPasienAdmisiT_ruangan_id").val();
        }
        
        var aksi = 2; // 2 create SJP
        var setting = {
            url : "<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/InhealthInterface'); ?>",
            type : 'GET',
            dataType : 'html',
            data : 'param='+aksi+'&tanggalpelayanan='+tanggalpelayanan+'&nokainhealth='+nokainhealth+'&jenispelayanan='+jenispelayanan+'&nomormedicalreport='+nomormedicalreport+
                '&nomorasalrujukan='+nomorasalrujukan+'&kodeproviderasalrujukan='+kodeproviderasalrujukan+'&tanggalasalrujukan='+tanggalasalrujukan+
                '&kodediagnosautama='+kodediagnosautama+'&poli='+poli+'&informasitambahan='+informasitambahan+'&kodediagnosatambahan='+kodediagnosatambahan+
                '&kecelakaankerja='+kecelakaankerja+'&klsrawat='+klsrawat+'&kelaspelayanan_id='+kelaspelayanan_id,
            beforeSend: function(){
                $("#content-inhealth").addClass("animation-loading");
            },
            success: function(data){
                $("#content-inhealth").removeClass("animation-loading");
                var sjp = JSON.parse(data);
                if(sjp.ERRORCODE=='00'){
                    var noSep = sjp.NOSJP;
                    myAlert(sjp.ERRORDESC);
                    $("#<?php echo CHtml::activeId($modSepInhealthT,'nosep') ?>").val(noSep);
                    $(obj).hide();
                    
                    if(ket=='baru'){
                        $("#ppsep-t-form").submit();
                    }
                    
                    $("#PPPasienM_alamat_pasien").blur();
                }else{
                    myAlert(sjp.ERRORDESC);
                }
            },
            error: function(data){
                $("#content-inhealth").removeClass("animation-loading");
            }
        }

        if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
        ajax_request = $.ajax(setting);
        
    }
    
    function cekAsuransiInhealth(){
        var penjamin_id = $("#<?php echo CHtml::activeId($model,'penjamin_id') ?>").val();
        var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();

        if(pasien_id==""){
          myAlert('Masukan terlebih dahulu data pasien!');
        }else if(penjamin_id==""){
          myAlert('Masukan terlebih dahulu penjamin!');
        }else{
          $.fn.yiiGridView.update('asuransiinhealth-m-grid', {
              data: {
                  "<?php echo get_class($modAsuransiPasienInhealth); ?>[pasien_id]":pasien_id,
                  "<?php echo get_class($modAsuransiPasienInhealth); ?>[penjamin_id]":penjamin_id,
              }
          });
          $("#dialogAsuransiInhealth").dialog('open');
        }
        return false;
    }
    
    function clearRujukanBpjs()
    {
        $('#<?php echo CHtml::activeId($modRujukanInhealth, 'rujukandari_id')?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        $('#<?php echo CHtml::activeId($modRujukanInhealth, 'nama_perujuk')?>').val('');
    }
    
    function printSJPInhealth(tkp, sep_id){
        $("#content-inhealth").addClass("animation-loading");
        $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('InhealthInterface'); ?>',
            data: {param: 3, sep_id: sep_id, tkp: tkp},
            dataType: "json",
            success:function(data){
                var objbuilder = '';
                objbuilder += ('<object width="100%" height="100%"      data="data:application/pdf;base64,');
                objbuilder += (data.BYTEDATA);
                objbuilder += ('" type="application/pdf" class="internal">');
                objbuilder += ('<embed src="data:application/pdf;base64,');
                objbuilder += (data.BYTEDATA);
                objbuilder += ('" type="application/pdf" />');
                objbuilder += ('</object>');

                var win = window.open("","_blank","titlebar=yes");
                win.document.write(objbuilder);
                layer = jQuery(win.document);
                $("#content-inhealth").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $("#content-inhealth").removeClass("animation-loading"); }
        });
    }

    $(document).ready(function () {

    });
</script>