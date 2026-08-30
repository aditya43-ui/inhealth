<script>
    function hitungCGS(){
        var gcs_eye =  $('#<?php echo CHtml::activeId($model, 'persarafan_gcs_eye') ?>').val();
        var gcs_motorik =  $('#<?php echo CHtml::activeId($model, 'persarafan_gcs_motorik') ?>').val();
        var gcs_verbal =  $('#<?php echo CHtml::activeId($model, 'persarafan_gcs_verb') ?>').val();  
        
        if (gcs_eye == ''){
            gcs_eye = 0;
        }
        
        if (gcs_motorik == ''){
            gcs_motorik = 0;
        }
        
        if (gcs_verbal == ''){
            gcs_verbal = 0;
        }
            

        $('#<?php echo CHtml::activeId($model, 'persarafan_total_gcs') ?>').val(parseInt(gcs_eye)+parseInt(gcs_motorik)+parseInt(gcs_verbal));                
    }   
    
    function setPerawat(nama,id){
        $("#<?php echo CHtml::activeId($model, 'perawat_nama') ?>").val(nama);
        $("#<?php echo CHtml::activeId($model, 'perawat_id') ?>").val(id);
        $('#dialogPPJP').dialog('close');
    }
    
    function setDokter(nama,id){
        $("#<?php echo CHtml::activeId($model, 'dpjp_nama') ?>").val(nama);
        $("#<?php echo CHtml::activeId($model, 'dpjp_id') ?>").val(id);
        $('#dialogDPJP').dialog('close');
    }
    
    function setDialogDiagnosaMasuk(obj){
        $('#dialogDiagnosaMasuk').dialog('open');
        $("#judul").html($(obj).attr('judul_id'));

        var data_id = $(obj).attr('data_id');

        $("#tampungDiagnosa").val(data_id);
    }
    
    /*-Eliminasi-*/
    function validasiEliminasiAda(klik){
        eliminasi_ada = $("#<?php echo CHtml::activeId($model, 'eliminasi_ada') ?>");
        if(eliminasi_ada.is(":checked")){
            if(klik=='1'){
                $(".kemih_tidak").removeAttr('checked');
            }
            $('input.kemih_tidak:text').val('');
            $(".kemih_tidak").hide();
            $(".eliminasi_ada").show();
        }else{
            $(".kemih_tidak").show();
            $(".eliminasi_ada").hide();
            if(klik=='1'){
                $(".eliminasi_ada").removeAttr('checked');
            }
            $('input.eliminasi_ada:text').val('');
        }    
    }
    function validasiEliminasiTidak(klik){
        eliminasi_tidakada = $("#<?php echo CHtml::activeId($model, 'eliminasi_tidakada') ?>");
        if(eliminasi_tidakada.is(":checked")){
            if(klik=='1'){
                $(".eliminasi_ada").removeAttr('checked');
            }
            $(".kemih_ada").hide();
        }else{
            $(".kemih_ada").show();
            if(klik=='1'){
                $(".kemih_tidak").removeAttr('checked');
            }
            $('input.kemih_tidak:text').val('');
        }    
    }
    
    /*-Defekasi-*/
    function validasiDefekasiAda(klik){
        nutrisi_defekasi_ada = $("#<?php echo CHtml::activeId($model, 'nutrisi_defekasi_ada') ?>");
        if(nutrisi_defekasi_ada.is(":checked")){
            $(".defekasi_tidakada").hide();
            $(".defekasi_tidakada").removeAttr('checked');
            $(".nutrisi_defekasi_ada").show();
            if(klik=='1'){
                $(".defekasi_ada").removeAttr('checked');
            }
            $(".defekasi_ada").show();
        }else{
            $(".defekasi_tidakada").show();
            $(".nutrisi_defekasi_ada").show();
            $(".nutrisi_defekasi_ada").removeAttr('checked');
            if(klik=='1'){
                $(".defekasi_ada").removeAttr('checked');
            }
            $(".defekasi_ada").hide();
            $('input.defekasi_ada:text').val('');
        }    
    }
    function validasiDefekasiTidak(klik){
        nutrisi_defekasi_tidakada = $("#<?php echo CHtml::activeId($model, 'nutrisi_defekasi_tidakada') ?>");
        if(nutrisi_defekasi_tidakada.is(":checked")){
            $(".defekasi_tidakada").show();
            $(".nutrisi_defekasi_ada").hide();
            $(".nutrisi_defekasi_ada").removeAttr('checked');
            if(klik=='1'){
                $(".defekasi_ada").removeAttr('checked');
            }
            $(".defekasi_ada").hide();
            $('input.defekasi_ada:text').val('');
        }else{
            $(".defekasi_tidakada").show();
            $(".nutrisi_defekasi_ada").show();
            $(".defekasi_tidakada").removeAttr('checked');
            $(".defekasi_ada").removeAttr('checked');
            $(".defekasi_ada").hide();
            $('input.defekasi_ada:text').val('');
        }    
    }
    
    /*-Defekasi-*/
    function validasiAlatBantuAda(klik){
        alatbantu_ada = $("#<?php echo CHtml::activeId($model, 'alatbantu_ada') ?>");
        if(alatbantu_ada.is(":checked")){
            $(".alatbantu_tidakada").hide();
            $(".alatbantu_tidakada").removeAttr('checked');
            $(".alatbantu_ada").show();
           if(klik=='1'){
                $(".alatbantu").removeAttr('checked');
            }
            $(".alatbantu").show();
        }else{
            $(".alatbantu_tidakada").show();
            $(".alatbantu_ada").show();
            $(".alatbantu_ada").removeAttr('checked');
            if(klik=='1'){
                $(".alatbantu").removeAttr('checked');
            }
            $(".alatbantu").hide();
            $('input.alatbantu:text').val('');
        }    
    }
    function validasiAlatBantuTidak(klik){
        alatbantu_tidakada = $("#<?php echo CHtml::activeId($model, 'alatbantu_tidakada') ?>");
        if(alatbantu_tidakada.is(":checked")){
            $(".alatbantu_tidakada").show();
            $(".alatbantu_ada").hide();
            $(".alatbantu_ada").removeAttr('checked');
            $(".alatbantu").removeAttr('checked');
            $(".alatbantu").hide();
            $('input.alatbantu:text').val('');
        }else{
            $(".alatbantu_tidakada").show();
            $(".alatbantu_ada").show();
            $(".alatbantu_tidakada").removeAttr('checked');
            $(".alatbantu").removeAttr('checked');
            $(".alatbantu").hide();
            $('input.alatbantu:text').val('');
        }    
    }
    
    function cekNutrisiStatus(){
        ya = 0;
        $('.nutrisi_status').each(
            function () {
                if($(this).is(":checked")){
                    ya++;
                }
            }
        );
        if(ya > 1){
           $("#notif_nutrisi").show();
        }else{
            $("#notif_nutrisi").hide();
        }
    }

    function setPakaiO2(obj){
        var ada = $('#EvaluasiPrainduksiT_perubahanrencanaanestesi_ada_0');
        if (ada.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'perubahanrencanaanestesi_ada_keterangan') ?>").attr('readonly',false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'perubahanrencanaanestesi_ada_keterangan') ?>").attr('readonly',true);
        }
    }

    $(document).ready(function(){
        
        /*register fungsi on load*/
        $(".eliminasi_ada").hide();
        $(".defekasi_ada").hide();
        $(".alatbantu").hide();
        validasiEliminasiAda('0');
        validasiDefekasiAda('0');
        validasiAlatBantuAda('0');
        hitungCGS();
        
        /*Untuk load dan cek skoring jatuh*/
        <?php 
        if(!empty($modResikoJatuh->totalskor)){ 
            if($modResikoJatuh->totalskor >= 45 && $modResikoJatuh->totalskor >= 25){
        ?>
                $("#<?php echo CHtml::activeId($model, 'resikojatuh_ada') ?>").attr('checked',true);
                $("#<?php echo CHtml::activeId($model, 'resikojatuh_tidakada') ?>").removeAttr('checked');
        <?php 
            }else{
        ?>
                $("#<?php echo CHtml::activeId($model, 'resikojatuh_tidakada') ?>").attr('checked',true);
                $("#<?php echo CHtml::activeId($model, 'resikojatuh_ada') ?>").removeAttr('checked');
        <?php
            }
        } 
        ?>
              
        /*untuk load dan cek skor nyeri*/
        <?php if(!empty($modAsesmenNyeri->score_skalanyeri)){?>
                $("#<?php echo CHtml::activeId($model, 'skor_nyeri') ?>").val(<?=$modAsesmenNyeri->score_skalanyeri?>);
        <?php   if($modAsesmenNyeri->score_skalanyeri > 0){ ?>
                    $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_ada') ?>").attr('checked',true);
                    $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_tidakada') ?>").removeAttr('checked');
        <?php   }else{ ?>
                    $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_tidakada') ?>").attr('checked',true);
                    $("#<?php echo CHtml::activeId($model, 'skrining_nyeri_ada') ?>").removeAttr('checked');
        <?php   } ?>
        <?php }  ?>
        cekNutrisiStatus();
        $("form").find('.float2').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        
        <?php if($model->memakai_narkotika_ya) { ?>
            $("#narkotikaShow").show();
            $("#<?php echo CHtml::activeId($model, 'memakai_narkotika_ya_ket') ?>").attr('class', 'required');
        <?php } else {?>
            $("#narkotikaShow").hide();
            $("#<?php echo CHtml::activeId($model, 'memakai_narkotika_ya_ket') ?>").removeClass("required");
        <?php } ?>
        
        if($('#RIAsesmenAwalKeperawatanT_pernafasan_pakai_o2_tidak').is(":checked")){
            $("#'.CHtml::activeId($model, 'pernafasan_pakai_o2_ya').'").removeAttr("checked");
            $("#'.CHtml::activeId($model, 'pernafasan_pakai_sangkup').'").removeAttr("checked");
            $("#'.CHtml::activeId($model, 'pernafasan_pakai_casalcanul').'").removeAttr("checked");
            $("#'.CHtml::activeId($model, 'pernafasan_pakai_nonbreathing').'").removeAttr("checked");
            $("#'.CHtml::activeId($model, 'pernafasan_pakai_o2').'").val("");
            $("#pakai_o2").hide();
        }
    });
</script>