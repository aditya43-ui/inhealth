<script type='text/javascript'>
  
    function cekForm(){                                          
        if (requiredCheck($("#notadinasppk-t-form"))){
            
            $('#notadinasppk-t-form').submit();
            disableOnSubmit($("#btn_submit"));
        }

       return false;
    }        
        
        
    function setDialog(jenis,dlg){        
        $("#jenisdialog").val(jenis);
        
        if (jenis == 'pengawaspekerjaan'){
            $(".judul-dialog-petugas").html('Pengawas Pekerjaan');
        }else if(jenis == 'ka_unit'){
            $(".judul-dialog-petugas").html('Ka. Unit Kerja');
        }
        
        $("#"+dlg).dialog('open');
    }
    
    function setPegawai(data,jenis){    
        console.log(jenis);
        if (typeof jenis === 'undefined'){
            var jenis = $("#jenisdialog").val();
        }
        
        if (jenis == 'pengawaspekerjaan'){
            $("#<?php echo CHtml::activeId($model, 'pegpengawas_id') ?>").val(data.pegpengawas_id);
            $("#<?php echo CHtml::activeId($model, 'pegpengawas_nama') ?>").val(data.namaLengkap);            
        }else if (jenis == 'ka_unit'){
            $("#<?php echo CHtml::activeId($model, 'ka_unit_id') ?>").val(data.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'ka_unit_nama') ?>").val(data.namaLengkap);
        }
        
        $("#dialogPetugas").dialog('close');
    }
      
    function refreshRiwayatDPA(data){
        $.fn.yiiGridView.update('rinciandpa-grid', {
            data: {                
                "AGDokumenpelaksanaananggarandetT[subprogramkerja_id]":data.subprogramkerja_id,                
                "AGDokumenpelaksanaananggarandetT[periodeanggaran_id]":data.periodeanggaran_id,                
                "AGDokumenpelaksanaananggarandetT[unitkerja_id]":data.unitkerja_id,                
                "AGDokumenpelaksanaananggarandetT[default]":data.def,
            }
        });
    }
   
   $(document).ready(function(){    
       
        setTimeout(function(){
            $(".wysihtml1").wysihtml5();
            formatNumberSemua();
        },300);
        
        $(".dataradio").on("click","input:radio",function(){
            
            var cek = $(this).prop("checked");
            
            $('#<?php echo CHtml::activeId($model, 'jumlah_uangmuka') ?>').attr('readonly',true);
            if (cek == true){
                if ($(this).attr('value') == true){
                    $('#<?php echo CHtml::activeId($model, 'jumlah_uangmuka') ?>').removeAttr('readonly');
                }
            }
        });
   });
</script>
