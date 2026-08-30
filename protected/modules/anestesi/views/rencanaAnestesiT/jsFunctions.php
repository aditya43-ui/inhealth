<script type="text/javascript">
    function setPramedikasi(obj){
        var pra =  $('#RencanaanestesiT_premedikasi');
        if(pra.is(" :checked")){
            $("#<?php echo CHtml::activeId($model, 'premedikasi_midazolam') ?>").attr('disabled',false);  
            $("#<?php echo CHtml::activeId($model, 'premedikasi_morphine') ?>").attr('disabled',false);  
            $("#<?php echo CHtml::activeId($model, 'premedikasi_pethidine') ?>").attr('disabled',false); 
            $("#<?php echo CHtml::activeId($model, 'premedikasi_ssulfasatropin') ?>").attr('disabled',false);     
        } else {
            $("#<?php echo CHtml::activeId($model, 'premedikasi_midazolam') ?>").attr('disabled',true); 
            $("#<?php echo CHtml::activeId($model, 'premedikasi_morphine') ?>").attr('disabled',true); 
            $("#<?php echo CHtml::activeId($model, 'premedikasi_pethidine') ?>").attr('disabled',true); 
            $("#<?php echo CHtml::activeId($model, 'premedikasi_ssulfasatropin') ?>").attr('disabled',true); 
        }
    }
    function setSedatif(obj){
        var sed = $('#RencanaanestesiT_induksi_sedatif');
        if (sed.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'induksi_sedatif_midazolam') ?>").attr('disabled',false);  
            $("#<?php echo CHtml::activeId($model, 'induksi_sedatif_propofol') ?>").attr('disabled',false);  
            $("#<?php echo CHtml::activeId($model, 'induksi_sedatif_ketamine') ?>").attr('disabled',false);  
        } else {
            $("#<?php echo CHtml::activeId($model, 'induksi_sedatif_midazolam') ?>").attr('disabled',true); 
            $("#<?php echo CHtml::activeId($model, 'induksi_sedatif_propofol') ?>").attr('disabled',true); 
            $("#<?php echo CHtml::activeId($model, 'induksi_sedatif_ketamine') ?>").attr('disabled',true); 
        }
    }
    
    function setAnalgetik(obj){
        var an = $('#RencanaanestesiT_induksi_analgetik');
        if (an.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'induksi_analgetik_morphine') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'induksi_analgetik_pethidine') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'induksi_analgetik_fentanyl') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'induksi_analgetik_ketamine') ?>").attr('disabled',false); 
        } else {
            $("#<?php echo CHtml::activeId($model, 'induksi_analgetik_morphine') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'induksi_analgetik_pethidine') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'induksi_analgetik_fentanyl') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'induksi_analgetik_ketamine') ?>").attr('disabled',true);
        }
    }
    
    function setPelumpuhOtak(obj){
        var pl = $('#RencanaanestesiT_induksi_pelumpuhotak');
        if (pl.is(" :checked")) {
             $("#<?php echo CHtml::activeId($model, 'induksi_pelumpuhotak_atracurium') ?>").attr('disabled',false);
             $("#<?php echo CHtml::activeId($model, 'induksi_pelumpuhotak_vecuronium') ?>").attr('disabled',false); 
             $("#<?php echo CHtml::activeId($model, 'induksi_pelumpuhotak_rocuronium') ?>").attr('disabled',false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'induksi_pelumpuhotak_atracurium') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'induksi_pelumpuhotak_vecuronium') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'induksi_pelumpuhotak_rocuronium') ?>").attr('disabled',true);
        }
    }
    function setInhalasi(obj){
        var pl = $('#RencanaanestesiT_inhalasi');
        if (pl.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'inhalasi_o2') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'inhalasi_halothan') ?>").attr('disabled',false); 
            $("#<?php echo CHtml::activeId($model, 'inhalasi_isofluran') ?>").attr('disabled',false); 
            $("#<?php echo CHtml::activeId($model, 'inhalasi_sevofluran') ?>").attr('disabled',false); 
            $("#<?php echo CHtml::activeId($model, 'inhalasi_enfluran') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'inhalasi_desflurane') ?>").attr('disabled',false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'inhalasi_o2') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'inhalasi_halothan') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'inhalasi_isofluran') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'inhalasi_sevofluran') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'inhalasi_enfluran') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'inhalasi_desflurane') ?>").attr('disabled',true);
        }
    }
    
    function setIntravena(obj){
        var inv = $('#RencanaanestesiT_intravena'); 
        if(inv.is(" :checked")){
            $("#<?php echo CHtml::activeId($model, 'intravena_propofol') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'intravena_morphien') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'intravena_pethidine') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'intravena_fentanyl') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'intravena_atracurium') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'intravena_vecuronium') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'intravena_recoronium') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'intravena_lainnya_cek') ?>").attr('disabled',false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'intravena_propofol') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'intravena_morphien') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'intravena_pethidine') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'intravena_fentanyl') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'intravena_atracurium') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'intravena_vecuronium') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'intravena_recoronium') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'intravena_lainnya_cek') ?>").attr('disabled',true);
        }
    }
    
    function cekIntravenaLain(obj){
        var ad = $("#RencanaanestesiT_intravena_lainnya_cek");
        if (ad.is(":checked")) {
            $("#<?php echo CHtml::activeId($model, 'intravena_lainnya') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'intravena_lainnya_dosis') ?>").attr('disabled',false);
        } else{
            $("#<?php echo CHtml::activeId($model, 'intravena_lainnya') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'intravena_lainnya_dosis') ?>").attr('disabled',true);
        }
    }
    
    function setAdditif(obj){
        var ad = $("#RencanaanestesiT_additif");
        if (ad.is(":checked")) {
            $("#<?php echo CHtml::activeId($model, 'additif_keterangan1') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'additif_dosis1') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'additif_keterangan2') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'additif_dosis2') ?>").attr('disabled',false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'additif_keterangan1') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'additif_dosis1') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'additif_keterangan2') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'additif_dosis2') ?>").attr('disabled',true);
        }
    }
    
    function setAnestesi(obj){
        var lokal = $("#RencanaanestesiT_anestesi_lokal");
        if(lokal.is(":checked")) {
            $("#<?php echo CHtml::activeId($model, 'anestesi_lokal_lidocaine') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'anestesi_lokal_bupivacaine') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'anestesi_lokal_rapivacaine') ?>").attr('disabled',false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'anestesi_lokal_lidocaine') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'anestesi_lokal_bupivacaine') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'anestesi_lokal_rapivacaine') ?>").attr('disabled',true);
        }
    }
    
    function setRegional(obj){
        var reg = $("#RencanaanestesiT_regional_anestesi");
        if (reg.is(":checked")) {
             $("#<?php echo CHtml::activeId($model, 'sab') ?>").attr('disabled',false);
             $("#<?php echo CHtml::activeId($model, 'epidural') ?>").attr('disabled',false);
             $("#<?php echo CHtml::activeId($model, 'pnb') ?>").attr('disabled',false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'sab') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'epidural') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'pnb') ?>").attr('disabled',true);
        }
    }
    
    function setGeneral(obj){
        var gen = $("#RencanaanestesiT_general_anestesi");
        if (gen.is(" :checked")) {
            $("#<?php echo CHtml::activeId($model, 'general_masker') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'general_tiva') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'general_intubasi') ?>").attr('disabled',false);
            $("#<?php echo CHtml::activeId($model, 'general_lma') ?>").attr('disabled',false);
        } else {
            $("#<?php echo CHtml::activeId($model, 'general_masker') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'general_tiva') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'general_intubasi') ?>").attr('disabled',true);
            $("#<?php echo CHtml::activeId($model, 'general_lma') ?>").attr('disabled',true);
        }
    }
    
    function setInsfluasi(obj){
        var inf = $("#RencanaanestesiT_induksi_insfluasidengan");
        if (inf.is(":checked")) {
             $("#<?php echo CHtml::activeId($model, 'induksi_insfluasi') ?>").attr('disabled',false);
             $("#<?php echo CHtml::activeId($model, 'induksi_insfluasi') ?>").attr('class', 'required');
        } else {
             $("#<?php echo CHtml::activeId($model, 'induksi_insfluasi') ?>").attr('disabled',true);
        }
    }
    
    $(document).ready(function(){
        setPramedikasi();
        setSedatif();
        setAnalgetik();
        setInhalasi();
        setIntravena();
        setAdditif();
        setAnestesi();
        setRegional();
        setPelumpuhOtak();
        setGeneral();
        setInsfluasi();
        cekIntravenaLain();
    });
</script>