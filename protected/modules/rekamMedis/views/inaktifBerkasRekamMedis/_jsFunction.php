<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$baseUrl = Yii::app()->createUrl("/");

?>
<script>        
    function cekSemua(obj){
        if ($(obj).prop("checked") == true){
            $("input:checkbox.pilihdata").each(function(){
               $(this).prop("checked", true);
            });
        }else{
            $("input:checkbox.pilihdata").each(function(){
               $(this).prop("checked", false);
            });
        }
    }
    
    function pilihCeklis(obj){
        var count = $("#retensidokrm-v-grid > table > tbody > tr").length;
        var checked = $("#retensidokrm-v-grid > table > tbody > tr").find("input:checkbox:checked.pilihdata").length;
                
        if (checked == count){
            $("input:checkbox#pilihSemua").each(function(){
               $(this).prop("checked", true);
            });
        }else{
            $("input:checkbox#pilihSemua").each(function(){
               $(this).prop("checked", false);
            });
        }
    }
    
    function setDialog(tipe){
        $("#tipe").val(tipe);
        
        if (tipe == 'pelaksana'){            
            $("#judul-petugas").html("Petugas Pelaksana");
        }else if(tipe == 'penanggungjawab'){
            $("#judul-petugas").html("Petugas Penanggung Jawab");
        }
        
        $("#dialogPegawai").dialog("open");                
    }
    
    function setPetugas(data, tipe){
        if (typeof tipe === 'undefined'){
            var tipe = $("#tipe").val();
        }
        
        
        if (tipe == 'pelaksana'){            
            $("#<?php echo CHtml::activeId($model, 'pegawai_pelaksana_id') ?>").val(data.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'pegawai_pelaksana_nama') ?>").val(data.namaLengkap);
        }else if(tipe == 'penanggungjawab'){
            $("#<?php echo CHtml::activeId($model, 'pegawai_penanggungjawab_id') ?>").val(data.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'pegawai_penanggungjawab_nama') ?>").val(data.namaLengkap);
        }
               
        $("#dialogPegawai").dialog("close");
    }
    
    function cekForm(){
        var checked = $("#retensidokrm-v-grid > table > tbody > tr").find("input:checkbox:checked.pilihdata").length;
    
        if (requiredCheck($("#transaksi-inaktif-form"))){
            if (checked > 0){
                $('#transaksi-inaktif-form').submit();
            }else{
                myAlert('Dokumen Rekam Medis, belum dipilih!');
            }
        }

       return false;
    }
</script>
