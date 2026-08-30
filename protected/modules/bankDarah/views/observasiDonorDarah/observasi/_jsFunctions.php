<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai menampung semua js yang ada pada form asesmen awal kebidanan, untuk masing - masing tabulasi emenggunakan file _jsFunctions masing - masing
* RSST-1498
*/
?>
<script>
    function setPetugas(nama, id){        
        $("#<?php echo CHtml::activeId($model, 'petugas_id') ?>").val(id);
        $("#<?php echo CHtml::activeId($model, 'petugas_nama') ?>").val(nama);
        $("#dialogPetugas").dialog('close');        
    }
    
    function setPerubahan(obj){
        var adakeluhan = document.getElementById("adakeluhan");
        var fieldkeluhan = document.getElementById("fieldkeluhan");
        
        if (obj.value == 'Ada') {
            if (adakeluhan.style.display === "block") {
                adakeluhan.style.display = "block";
            } else {
                adakeluhan.style.display = "block";
            }
            if (fieldkeluhan.style.display === "block") {
                fieldkeluhan.style.display = "block";
            } else {
                fieldkeluhan.style.display = "block";
            }
        }else if (obj.value == 'Tidak Ada'){
            if (adakeluhan.style.display === "none") {
                adakeluhan.style.display = "none";
            } else {
                adakeluhan.style.display = "none";
            }
            if (fieldkeluhan.style.display === "none") {
                fieldkeluhan.style.display = "none";
            } else {
                fieldkeluhan.style.display = "none";
            }
        }
    }
    
    
    function cekBatal(obj){
                
        $("#message-batalsadap").html('');
        if ($(obj).prop("checked") == true){
               var count = 0;         
            $("#alasanbatal-sadap").find('input').each(function(){
               $(this).removeAttr('disabled') ;               
               if (($(this).hasClass('hasparent'))){                                              
                    if (($(this).parents('.control-group').find('.haschild').prop("checked")) != true){                                                
                        $(this).attr('disabled',true);                              
                    }
               }    
               
               if (($(this).hasClass('masuk'))){
                   if ($(this).prop("checked") == true){
                       count++;
                   }
               }
            });
            
            $("#alasanbatal-sadap").find('#textPilih').each(function(){
               if ($(this).val() == ""){
                   $(this).attr("disabled",true);
               }
            });
                    
            if (count == 0){
                $("#message-batalsadap").html('<span class="required">alasan gagal sadap, harus dipilih</span>');        
            }
        }else{
            $("#alasanbatal-sadap").find('input').each(function(){
                $(this).attr('disabled',true);               
                $(this).prop("checked",false);                
            });
            
            $("#<?php echo CHtml::activeId($model, 'ket_alasanbatal'); ?>").val("");
            
            $("#alasanbatal-sadap").find('#textPilih').each(function(){                        
                $(this).val("");              
                $(this).attr("disabled",true);                                        
            });
        }
    }
    
    function openChild(obj){        
        tambahCeklis(obj);
        
        if ($(obj).prop("checked") == true){
            $(obj).parents('.control-group').find('input:checkbox.hasparent').each(function(){
                $(this).removeAttr('disabled');
            });
        }else{
            $(obj).parents('.control-group').find('input:checkbox.hasparent').each(function(){
                $(this).attr('disabled',true);               
                $(this).prop("checked",false);
            });
            
        }
        
        
    }
    
    function cekParent(){                
        $("#alasanbatal-sadap").find('input:checkbox').each(function(){      
            if ($(this).hasClass('hasparent')){
                if ($(this).prop("checked") == true){
                    $(this).parents(".control-group").find('.haschild').prop("checked",true);
                }
            }                       
        });       
    }
    
    function tambahCeklis(obj){
                        
        $("#<?php echo CHtml::activeId($model, 'ket_alasanbatal'); ?>").val("");
        
        var count = 0;
        
        $("#alasanbatal-sadap").find('#textPilih').each(function(){                        
            $(this).val("");              
            $(this).attr("disabled",true);                                        
        });
        
        if ($(obj).prop("checked") == true){                                     
            $("#alasanbatal-sadap").find('input:checkbox').each(function(){                                    
                
                if ($(this).hasClass('masuk')){                    
                    $(this).prop("checked",false);                        
                }                       
                
                if ($(this).hasClass('tidakmasuk')){                                                            
                    if ($(this).prop("checked") == true){
                        $(this).parents(".control-group").find('.masuk').each(function(){
                            $(this).attr("disabled",true);                            
                        });                                               
                    }
                    $(this).prop("checked",false);                        
                }     
            });       
            
            $(obj).prop("checked",true);
            
            if ($(obj).hasClass('hasparent')){
                if ($(obj).prop("checked") == true){
                    $(obj).parents(".control-group").find('input:checkbox.masuk').each(function(){
                            $(this).removeAttr("disabled");                            
                    }); 
                    
                    $(obj).parents(".control-group").find('.tidakmasuk').prop("checked",true);
                    
                    $(obj).parents(".control-group").find('#textPilih').each(function(){                        
                        $(this).val("");   
                        if ($(this).attr('hasil') == $(obj).attr('value')){                            
                            $(this).removeAttr("disabled");                            
                        }
                    });
                    
                    
                }
            }
            
            
            //$("#tampungceklis > tbody").html('<tr><td><?php //echo CHtml::textField('detalasan[ii][alasanbatal_penyadapan]','',array('id'=>'detalasan_ii_alasanbatal_penyadapan','readonly'=>true,'class'=>'alasanbatal')) ?></td></tr>');
            if ($(obj).hasClass('masuk')){
                $("#tampungceklis > tbody").html('<tr><td><?php echo CHtml::activeHiddenField($model,'alasanbatal_penyadapan',array('readonly'=>true,'class'=>'alasanbatal')) ?></td></tr>');
                $("#tampungceklis > tbody").find('.alasanbatal:last').val($(obj).attr("value"));
                renameInput($("#tampungceklis"));
            }else if ($(obj).hasClass('tidakmasuk')){
                $("#tampungceklis > tbody").html('');
            }                                    
        }else{            
            $("#tampungceklis > tbody").find('.alasanbatal').each(function(){
                if ($(this).attr('value') == $(obj).attr("value")){
                    $(this).parents("tr").detach();
                }
            });
            renameInput($("#tampungceklis"));
        }
        
        $("#alasanbatal-sadap").find('input:checkbox.masuk').each(function(){
            if ($(this).prop("checked") == true){
                count++;
            }
        });
        
        if (count > 0){
            $("#message-batalsadap").html('<span class="required"></span>');        
        }else{
            $("#message-batalsadap").html('<span class="required">alasan gagal sadap, harus dipilih</span>');        
        }
    }
    
    function inputKeterangan(obj){
        $("#<?php echo CHtml::activeId($model, 'ket_alasanbatal'); ?>").val($(obj).val());
    }
    
    function renameInput(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){            
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
            });
            row++;
        });

    }
    
    function generateDurasi(tipe){
                
        var jamAwal = $("#<?php echo CHtml::activeId($model, 'jamawal'); ?>").val();
        var jamAkhir = $("#<?php echo CHtml::activeId($model, 'jamakhir'); ?>").val();                
        
        var jam_1 = parseInt(jamAwal.substring(0,2)) * 3600;
        var jam_2= parseInt(jamAkhir.substring(0,2)) * 3600;
        var menit_1= parseInt(jamAwal.substring(3,5)) * 60;
        var menit_2 = parseInt(jamAkhir.substring(3,5)) * 60;
        var detik_1 = parseInt(jamAwal.substring(6,8));
        var detik_2 = parseInt(jamAkhir.substring(6,8));
                        
        var hasil_1 = jam_1 + menit_1 + detik_1;
        var hasil_2 = jam_2 + menit_2 + detik_2;
        
        if (tipe == 'akhir'){
            if (hasil_1 > hasil_2){                        
                window.parent.myAlert("Waktu Mulai Penyadapan, tidak boleh lebih besar dari Waktu Selesai Penyadapan");
                $("#<?php echo CHtml::activeId($model, 'jamawal'); ?>").val(jamAkhir);
                var akhir = moment.utc(jamAkhir,'hh:mm:ss').add(5,'minutes').format('HH:mm:ss');            
                $("#<?php echo CHtml::activeId($model,'jamakhir'); ?>").val(akhir);                                   
            }else if (hasil_1 == hasil_2){                        
                window.parent.myAlert("Waktu Mulai Penyadapan, tidak boleh sama dengan Waktu Selesai Penyadapan");
                $("#<?php echo CHtml::activeId($model, 'jamawal'); ?>").val(jamAkhir);
                var akhir = moment.utc(jamAkhir,'hh:mm:ss').add(5,'minutes').format('HH:mm:ss');            
                $("#<?php echo CHtml::activeId($model,'jamakhir'); ?>").val(akhir);                                   
            }
        }else{
            var akhir = moment.utc(jamAwal,'hh:mm:ss').add(5,'minutes').format('HH:mm:ss');            
            $("#<?php echo CHtml::activeId($model,'jamakhir'); ?>").val(akhir);                                   
        }
        
        var jamAwal = $("#<?php echo CHtml::activeId($model, 'jamawal'); ?>").val();
        var jamAkhir = $("#<?php echo CHtml::activeId($model, 'jamakhir'); ?>").val();                
        
        var jam_1 = parseInt(jamAwal.substring(0,2)) * 3600;
        var jam_2= parseInt(jamAkhir.substring(0,2)) * 3600;
        var menit_1= parseInt(jamAwal.substring(3,5)) * 60;
        var menit_2 = parseInt(jamAkhir.substring(3,5)) * 60;
        var detik_1 = parseInt(jamAwal.substring(6,8));
        var detik_2 = parseInt(jamAkhir.substring(6,8));
                        
        var hasil_1 = jam_1 + menit_1 + detik_1;
        var hasil_2 = jam_2 + menit_2 + detik_2;
        
        var selisih = hasil_2 - hasil_1;
        var jam = Math.floor(selisih / 3600);
        var menit = Math.floor((selisih - (jam * 3600))/60);
        var detik = Math.floor((selisih - (jam * 3600))/3600);
       
        if (jam <= 9){
            jam = '0'+jam;
        }
        
        if (menit <= 9){
            menit = '0'+menit;
        }
        
        if (detik <= 9){
            detik = '0'+detik;
        }
       
       if (jam >= 1){
           if (menit > 0){
               myAlert(" Durasi Penyadapan sudah melebihi dari 1 jam ");
           }else if(detik > 0){
               myAlert(" Durasi Penyadapan sudah melebihi dari 1 jam ");
           }
       }
               
       
        $("#<?php echo CHtml::activeId($model,'durasi_penyadapan'); ?>").val(jam + ":" + menit + ":"+detik);
                
        
    }
    
    function cekForm(){
        if (requiredCheck($("#observasi-pendonor-form"))){         
            if ($("<?php echo CHtml::activeId($model, 'is_batalpenyadapan') ?>").val() == false){
                var tr = $("#alasanbatal-sadap").find("input:checkbox.masuk:checked").length;

                if (tr > 0){            
                        $('#observasi-pendonor-form').submit();

                }else{
                    window.parent.myAlert("Alasan Gagal Penyadapan Belum Dipilih","Perhatian !");
                    return false;
                }        
            }else{
                $('#observasi-pendonor-form').submit();
            }
        }


       return false;
    }
    
    
    
    $(document).ready(function(){        
                
        
        cekParent();
        cekBatal($('#<?php echo CHtml::activeId($model, 'is_batalpenyadapan') ?>'));
        
       
    });
</script>