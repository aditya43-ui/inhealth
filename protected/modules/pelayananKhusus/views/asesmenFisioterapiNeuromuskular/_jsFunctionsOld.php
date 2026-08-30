<?php
  
?>
<script type='text/javascript'>
    function cekPolaLain(obj){
        var dinamis = $(obj).val();
        
        if (dinamis == '<?php echo Params::NEURO_INSPEKSI_DINAMIS_POLA_LAIN ?>'){
            $("#<?php echo CHtml::activeId($model, 'inspeksi_dinamis_polalain') ?>").removeAttr('readonly');
        }else{
            $("#<?php echo CHtml::activeId($model, 'inspeksi_dinamis_polalain') ?>").attr('readonly',true);
        }
    }
   
   
    $(document).ready(function(){
        $("#satu-check").on('click','input:checkbox',function(){            
            var cek = $(this).prop("checked");
            $(this).parents(".control-group").find('input:checkbox').each(function(){
                $(this).prop("checked",false);
            });
            
            if (cek == true){
                $(this).prop("checked",true);
            }
        });
    });
</script>
