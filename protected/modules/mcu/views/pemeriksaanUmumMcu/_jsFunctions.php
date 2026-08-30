<script>
    function nama(nama)
    {
        document.getElementById('McuPemeriksaanumumT_diagnosis').value = nama.value.toUpperCase();
    }
    function tambahbaru(obj){
	window.parent.myConfirm("Apakah Anda ingin menambah data baru?","Perhatian!",function(r){if(r) window.location = $(obj).attr("href");});
	return false;
    }
   function jumlah(){
        var beratBadan = parseFloat($("#McuPemeriksaanumumT_beratbadan").val());
        var tinggiBadan = parseFloat($("#McuPemeriksaanumumT_tinggibadan").val());
        if($("#McuPemeriksaanumumT_tinggibadan").val() != ""){
            var tinggiBadanMeter = tinggiBadan/100;
            var hasil = Math.round(beratBadan/(tinggiBadanMeter*tinggiBadanMeter));
        }else{
            var tinggiBadanMeter = 0;
            var hasil = 0;
        }
        $("#McuPemeriksaanumumT_nilai_bmi").val(hasil);
         if (jQuery.isNumeric(hasil)){
            $.post('<?php echo Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText'); ?>', {bmi:hasil}, function(data){
                $('#McuPemeriksaanumumT_bmi_kategori').val(data.text);
            },'json');
        }
       
    }
    function setdelete(id) {
         var id = id;
          window.parent.myConfirm('Apa Anda akan menghapus data ini?','Perhatian!',function(r){
            if (r){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('setDelete'); ?>',
                data: {id:id},
                dataType: "json",
                    success:function(data){
                        if(data.status == true){
                            myAlert(data.pesan);	
                            window.location.reload();                        
                        }else{
                            myAlert(data.pesan);	
                        }	
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	    }); 
            }
            });
    }
    
    function pilihNormal(obj){        
        $(".pemeriksaanumum-normal").find('input:checkbox').each(function(){            
            
            if ($(obj).prop("checked") == true){
                $(this).prop("checked",false);
                if ($(this).hasClass('pilih-normal')){
                    $(this).prop("checked",true);
                }
                                
            }else{
                $(this).prop("checked",false);                
            }
        });  
        $(".pemeriksaanumum-normal2").find('input:checkbox').each(function(){            
            
            if ($(obj).prop("checked") == true){
                $(this).prop("checked",false);
                if ($(this).hasClass('pilih-normal')){
                    $(this).prop("checked",true);
                }
                                
            }else{
                $(this).prop("checked",false);                
            }
        });  
        
        $(".pemeriksaanumum-normal").find('input:checkbox.lainlain').each(function(){               
                if ($(this).prop("checked") == true){
                    $(this).parents('.control-group').find('.laintext').removeAttr('readonly');
                    $(this).parents('.control-group').find('.laintext').val('');
                }else{
                    $(this).parents('.control-group').find('.laintext').attr('readonly',true);
                    $(this).parents('.control-group').find('.laintext').val('');
                }
               
            });
    }
    
 $(document).ready(function(){
     
    $(".anemia").find('input:checkbox').click(function() {
           var cek_lis = $(this).prop('checked');
            $(".anemia").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }
    });
    
    $(".ikterus").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".ikterus").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }    
     });
     
    $(".kepala").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".kepala").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }    
    });
    
    $(".jantung").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".jantung").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }    
    });
     $(".hepar").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".hepar").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
        if (cek_lis == true){
                $(this).prop("checked",true);                                
            }    
        });
     $(".limpa").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".limpa").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
        if (cek_lis == true){
                $(this).prop("checked",true);                                
            }    
        });
     $(".extremitas").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".extremitas").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
        if (cek_lis == true){
                $(this).prop("checked",true);                                
            }    
        });
        
      $(".gizi").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".gizi").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
        if (cek_lis == true){
                $(this).prop("checked",true);                                
            }    
        });
        
      $(".sesak").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".sesak").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
        if (cek_lis == true){
                $(this).prop("checked",true);                                
            }    
        });
        
      $(".sembab").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".sembab").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }    
        });
      $(".leher").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".leher").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }    
        });
        
      $(".paru").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".paru").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }   
        });
        
      $(".abdomen").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".abdomen").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }   
        });
        
      $(".tulang").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".tulang").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }   
        });
        
      $(".fotothorax").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".fotothorax").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }   
        });
    
      $(".anti-hbe").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".anti-hbe").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }   
        });
      $(".hbeag").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".hbeag").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }   
        });
      $(".foses").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".foses").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }  
        });
       $(".urine").find('input:checkbox').click(function() {
            var cek_lis = $(this).prop('checked');
            $(".urine").find('input:checkbox').each(function() {
            $(this).prop("checked",false);
            });
            if (cek_lis == true){
                $(this).prop("checked",true);                                
            }   
        });
    
     if($("#McuPemeriksaanumumT_is_konsul").is(':checked')){
         $('#KonsulpoliT_tglkonsulpoli').attr('disabled',false);
         $('#KonsulpoliT_ruangan_id').attr('disabled',false);
         $('#KonsulpoliT_pegawai_id').attr('disabled',false);
         $('#KonsulpoliT_catatan_dokter_konsul').attr('disabled',false);
     }else{
         $('#KonsulpoliT_tglkonsulpoli').attr('disabled',true);
         $("#KonsulpoliT_tglkonsulpoli").find(".add-on").hide();
         $('#KonsulpoliT_ruangan_id').attr('disabled',true);
         $('#KonsulpoliT_pegawai_id').attr('disabled',true);
         $('#KonsulpoliT_catatan_dokter_konsul').attr('disabled',true);
     }
     $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
 });

</script>
