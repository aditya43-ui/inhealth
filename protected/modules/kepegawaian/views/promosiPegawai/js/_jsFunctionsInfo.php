<?php
/**
*       - digunakan untuk menyimpan semua fungsi javascript agar mudah ditracking untuk di informasi
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/
?>
<script>
function cekSubmit(obj){    
    if (requiredCheck($(obj))){
        var pimpinan = $('#PegpromosiR_prom_pimpinan_nama').val();
        var pegpromosi_id = $('#PegpromosiR_pegpromosi_id').val();
        var alasan = $('#PegpromosiR_prom_alasan').val();
        var status = $('#PegpromosiR_prom_status').val();
        
        getApproved(pimpinan,pegpromosi_id,'',alasan,status);
        return false;
    }else{
        return false;
    }
}
    
    
function getApproved(pimpinan, pegpromosi_id,dialog,alasan,status){
    var pim = pimpinan;
    var pegpro_id = pegpromosi_id;
    
    if (dialog != ''){                
        $.ajax({
            type:'POST',
            url:"<?php echo $this->createUrl('/kepegawaian/PromosiPegawai/getApproved');?>",
            data: {pim:pim,pegpro_id:pegpro_id,dialog:dialog },
            dataType: "json",
            success:function(data){
                    if (data.sukses == 1){
                        jQuery("#dialogChangeSt").dialog('open');
                        $("#form-changest").html(data.tr);                        
                    }else{
                        jQuery("#dialogChangeSt").dialog('close');
                        myAlert(data.pesan);
                    }
            },
            error: function (jqXHR, textStatus, errorThrown) { 

            }
        });
    }else{                    
        $.ajax({
            type:'POST',
            url:"<?php echo $this->createUrl('/kepegawaian/PromosiPegawai/getApproved');?>",
            data: {pim:pim,pegpro_id:pegpro_id,alasan:alasan,status:status },
            dataType: "json",
            success:function(data){
                    if (data.sukses == 1){
                        jQuery("#dialogChangeSt").dialog('close');                          
                        $.fn.yiiGridView.update('pegmutasi-r-grid', {
                                data: $('#pegmutasi-r-search').serialize()
                        });
                          
                    }else{
                        myAlert(data.pesan);
                    }
            },
            error: function (jqXHR, textStatus, errorThrown) { 

            }
        });
    }
    
}
</script>