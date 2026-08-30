<script>
    function setValidasi(obj,kuesionerdonor_id){
        var gagal = 0;
        var gagal_wanita = 0;
        $(obj).parents('table').find('input:radio[class="kuesioner_wajib"]:checked').each(function(){
            if($(this).val()==0){
                gagal++;
            }
        });
        $(obj).parents('table').find('input:radio[class="wanita"]:checked').each(function(){
            if($(this).val()==1){
                gagal_wanita++;
            }
        });
        
        if(gagal_wanita > 0){
            /* RSST-1495- di coment terkait coment pada issue RSST-1495*/
            /* $('#<?php /* echo CHtml::activeId($model, 'is_gagalseleksi'); */?>').attr('checked',true); */
            /*  $('.gagal').attr('disabled',false); */
            /* end */
            $('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>').attr('checked',true);
            $('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>').attr('disabled',true);
            $('#<?php  echo CHtml::activeId($model, 'is_gagalseleksiawal'); ?>').val('gagal');
             $('#<?php  echo CHtml::activeId($model, 'gagal_seleksi_wanita'); ?>').val('gagal_seleksi');
            $('#BDSeleksipendonorT_lain_lain').attr('checked',true);
            $('.gagal').attr('disabled','disabled');
            $('.seleksi').attr('disabled','disabled');
            $('#label_status').html('<h3>Tidak Lolos Seleksi</h3>');
        }else{
            /*
            $('#<?php /*echo CHtml::activeId($model, 'is_gagalseleksi'); */?>').attr('checked',false);
            $('.gagal').attr('disabled','disabled'); */
            $('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>').attr('disabled',false);
            $('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>').attr('checked',false);
            $('#BDSeleksipendonorT_lain_lain').attr('checked',false);
            $('#<?php  echo CHtml::activeId($model, 'is_gagalseleksiawal'); ?>').val('lulus');
             $('#<?php  echo CHtml::activeId($model, 'gagal_seleksi_wanita'); ?>').val('lulus');
            $('.gagal').attr('disabled','disabled');
            $('.seleksi').attr('disabled',false);
            $('#label_status').html('');
        }
        cekLain2($('#<?php echo CHtml::activeId($model, 'medis_lain'); ?>'));
        cekPerilakuBeresiko(); 
        cekRiwayat(); 
        cekLain(); 
    }
    
    function gagalSeleksi(obj){
         if ($(obj).is(':checked')) {
            $('#<?php  echo CHtml::activeId($model, 'is_gagalseleksiawal'); ?>').val('gagal');
            $('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>').attr('checked',true);
            $('.gagal').attr('disabled',false);
            $('#label_status').html('<h3>Tidak Lolos Seleksi</h3>');
         }else{
            $('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>').attr('checked',false);
            $('#<?php  echo CHtml::activeId($model, 'is_gagalseleksiawal'); ?>').val('lulus');
            $('#tabelGagal').find('input:checkbox[class="gagal"]:checked').each(function(){
                $('.gagal').prop('checked',false);
                $('.lain2').prop('checked',false);
                $('.perilaku').prop('checked',false);
                $('.lain').prop('checked',false);
                $('.riw_bepergian').prop('checked',false);
            });
            
            $('.gagal').attr('disabled','disabled');
            $('#label_status').html('');
         }
         console.log('cek');
         cekLain2($('#<?php echo CHtml::activeId($model, 'medis_lain'); ?>'));
         cekPerilakuBeresiko();
         cekRiwayat();
         cekLain();
    }
    
    function cekLain2(obj){
        if ($(obj).is(':checked')) {
            $('.lain2').attr('disabled',false);
            $(obj).removeAttr('disabled');
         }else{
            $('.lain2').attr('disabled','disabled');
            $('.lain2').attr('checked',false);
         }
         
         if($('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>').is(':checked')){
         }else{
             $(obj).attr('checked', false);
             $(obj).attr('disabled', 'disabled');
             $('.lain2').attr('disabled','disabled');
             $('.lain2').attr('checked', false);
         }
    }
    
    function cekRadioMedis(obj){
        $(".lain2").removeAttr('checked');
        $(obj).attr('checked',true);
    }
    function cekRadioPerilaku(obj){
        $(".perilaku").removeAttr('checked');
        $(obj).attr('checked',true);
    }
    
    function cekRadioRiwayat(obj){
        $(".riw_bepergian").removeAttr('checked');
        $(obj).attr('checked',true);
    }
    
    function cekRadioLain(obj){
        $(".lain").removeAttr('checked');
        $(obj).attr('checked',true);
    }
    
        
    
    function cekPerilakuBeresiko(){
        var perilaku = $("#BDSeleksipendonorT_perilakuberesiko");
        if (perilaku.is(" :checked")) {
            console.log('a');
            $('.perilaku').attr('disabled',false);
            $("#BDSeleksipendonorT_perilakuberesiko").removeAttr('disabled');
        } else {
            console.log('b');
            $('.perilaku').attr('disabled','disabled');
            $('.perilaku').attr('checked', false);
        }
        
        if($('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>').is(':checked')){
        }else{
            $("#BDSeleksipendonorT_perilakuberesiko").attr('checked', false);
            $("#BDSeleksipendonorT_perilakuberesiko").attr('disabled', 'disabled');
             $('.perilaku').attr('disabled','disabled');
             $('.perilaku').attr('checked', false);
         }
    }
    
    function cekRiwayat(){
        var riwayat = $("#BDSeleksipendonorT_riwberpergian");
        if (riwayat.is(" :checked")) {
            $('.riw_bepergian').attr('disabled',false);
            $("#BDSeleksipendonorT_riwberpergian").removeAttr('disabled');
        } else {
            $('.riw_bepergian').attr('disabled','disabled');
            $('.riw_bepergian').attr('checked',false);
        }
        
        if($('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>').is(':checked')){
         }else{
             $("#BDSeleksipendonorT_riwberpergian").attr('checked', false);
             $("#BDSeleksipendonorT_riwberpergian").attr('disabled', 'disabled');
             $('.riw_bepergian').attr('disabled','disabled');
             $('.riw_bepergian').attr('checked',false);
         }
    }
    function cekLain(){
        var lain = $("#BDSeleksipendonorT_lain_lain");
        if (lain.is(" :checked")) {
            $('.lain').attr('disabled',false);
            $("#BDSeleksipendonorT_lain_lain").removeAttr('disabled');
        } else {
            $('.lain').attr('disabled','disabled');
            $('.lain').attr('checked',false);
        }
        
        if($('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>').is(':checked')){
         }else{
             $("#BDSeleksipendonorT_lain_lain").attr('checked', false);
             $("#BDSeleksipendonorT_lain_lain").attr('disabled', 'disabled');
             $('.lain').attr('disabled','disabled');
             $('.lain').attr('checked',false);
         }
    }
    
    function ubahDialog(){
        if($('#cek_ppds').is(':checked')){
            $("#petugaskoreksi").hide();
            $("#BDSeleksipendonorT_petugaskoreksi_id").val("");
            $("#BDSeleksipendonorT_petugaskoreksi_nama").val("");
            $("#BDSeleksipendonorT_petugaskoreksi_id").removeClass("required");
            $("#BDSeleksipendonorT_ppds_id").addClass("required");
            $("#ppds").show();
        }else{
            $("#ppds").hide();
            $("#BDSeleksipendonorT_ppds_id").val("");
            $("#BDSeleksipendonorT_ppds_nama").val("");
            $("#BDSeleksipendonorT_ppds_id").removeClass("required");
            $("#BDSeleksipendonorT_petugaskoreksi_id").addClass("required");
            $("#petugaskoreksi").show();
        }
    }
    
     function setPPDS(data) {
        $("#BDSeleksipendonorT_ppds_id").val(data.ppds_id);
        $("#BDSeleksipendonorT_ppds_nama").val(data.ppds_nama);
    }
    
    function ubahForm(){
        $(".kuesioner_wajib,.wanita,.default").removeAttr("readonly",false);
        $(".kuesioner_wajib,.wanita,.default").removeAttr("disabled",false);
        $("#btn_submit").removeAttr("disabled",false);
        setTanggalAktif('edit');
        setDPJPAktif('edit');
        setPetugasKoreksi('edit');
        $("#cek_ppds").prop("disabled",false);
        $("#cek_ppds").prop("readonly",false);
    }
    
    function setTanggalAktif(type){
        if(type == 'create' || type == 'edit'){
            $("#tanggal_edit").show();
            $("#tanggal").hide();
        }else{
            $("#tanggal_edit").hide();
            $("#tanggal").show();
        }
    }
    
    function setDPJPAktif(type){
        if(type == 'create' || type == 'edit'){
            $("#dpjp_edit").show();
            $("#dpjp").hide();
        }else{
            $("#dpjp_edit").hide();
            $("#dpjp").show();
        }
    }
    
    function setPetugasKoreksi(type){
        if(type=="create" || type== 'edit'){
            $("#panelpetugaskoreksi").hide();
            $("#panelpetugaskoreksi_edit").show();
            $("#panelppds").hide();
            $("#panelppds_edit").show();
        }else{
            $("#panelppds_edit").show();
            $("#panelpetugaskoreksi").show();
            $("#panelpetugaskoreksi_edit").hide();
            $("#panelppds").show();
            $("#panelppds_edit").hide();
        }
    }
    
    function cekBB(){
        var bb = $("#BDSeleksipendonorT_bb_rendah");
        var td_tinggi = $("#BDSeleksipendonorT_medis_tk_tinggi");
        var td_rendah = $("#BDSeleksipendonorT_medis_td_rendah");
        
        
        if (bb.is(" :checked")) {
            $("#BDSeleksipendonorT_td_systolic, #ytBDSeleksipendonorT_gol_darah, #ytBDSeleksipendonorT_rhesus").parents(".control-group").find('.control-label').find('span.required').remove();
            $("#BDSeleksipendonorT_td_systolic, #BDSeleksipendonorT_td_diastoliic").removeClass('required');
        } else if(bb.is(" :checked")){
            $("#BDSeleksipendonorT_td_systolic, #ytBDSeleksipendonorT_gol_darah, #ytBDSeleksipendonorT_rhesus").parents(".control-group").find('.control-label').find('span.required').remove();
            $("#BDSeleksipendonorT_td_systolic, #BDSeleksipendonorT_td_diastoliic").removeClass('required');
        } else {
            $("#BDSeleksipendonorT_td_systolic, #ytBDSeleksipendonorT_gol_darah, #ytBDSeleksipendonorT_rhesus").parents(".control-group").find('.control-label').append('<span class="required">*</span>');
            $("#BDSeleksipendonorT_td_systolic, #BDSeleksipendonorT_td_diastoliic").attr('class', 'required span2 numbers-only seleksi');
        }
    }
    
    function cekTekDarah(){
        var td_tinggi = $("#BDSeleksipendonorT_medis_tk_tinggi");
        var td_rendah = $("#BDSeleksipendonorT_medis_td_rendah");
        
        if (td_tinggi.is(" :checked") || td_rendah.is(" :checked")) {
            console.log('tekanan darah');
            $("#BDSeleksipendonorT_suhu_tubuh, #BDSeleksipendonorT_kadar_hb, #ytBDSeleksipendonorT_gol_darah, #ytBDSeleksipendonorT_rhesus").parents(".control-group").find('.control-label').find('span.required').remove();
            $("#BDSeleksipendonorT_suhu_tubuh, #BDSeleksipendonorT_kadar_hb").removeClass('required');
        } else {
            $("#BDSeleksipendonorT_suhu_tubuh, #BDSeleksipendonorT_kadar_hb, #ytBDSeleksipendonorT_gol_darah, #ytBDSeleksipendonorT_rhesus").parents(".control-group").find('.control-label').append('<span class="required">*</span>');
            console.log('normal');
            $("#BDSeleksipendonorT_suhu_tubuh, #BDSeleksipendonorT_kadar_hb").attr('class', 'required span4 float seleksi');

        }
    }
    
    $( document ).ready(function(){
        $('.gagal').attr('disabled','disabled');
        <?php if(!empty($model->seleksidonor_id)){ ?>
            cekLain2($('#<?php echo CHtml::activeId($model, 'medis_lain'); ?>'));
            setTanggalAktif('load');
            setPetugasKoreksi('load');
            setDPJPAktif('load');
            ubahDialog();
            gagalSeleksi($('#<?php echo CHtml::activeId($model, 'is_gagalseleksi'); ?>'));
            cekLain();
            cekRiwayat();
            cekPerilakuBeresiko();
        <?php }else{ ?>
            setTanggalAktif('create');
            setPetugasKoreksi('create');
            setDPJPAktif('create');
            ubahDialog();
        <?php }?>
        
        //cek apakah data yang tersimpan lolos seleksi atau tidak
        <?php
            if(!empty($cekSeleksi)){
                if($cekSeleksi->is_gagalseleksi == true){?>
              $('#label_status').html('<h3>Tidak Lolos Seleksi</h3>');
        <?php  }else{?>
               $('#label_status').html();
        <?php
                }
            }else{?>
               $('#label_status').html();
         <?php
            }
        ?>
    })
    
</script>