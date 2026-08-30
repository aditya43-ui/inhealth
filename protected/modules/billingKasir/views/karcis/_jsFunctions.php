<script type="text/javascript">
/**
 * pilih karcis (check - uncheck)
 * harus pilih salah satu
 * @param {type} obj
 * @returns {undefined} */
function pilihKarcis(obj){
    console.log("Karcis Dipilih !", obj);
    var is_pilihtindakan = $(obj).parents('tr').find('input[name$="[is_pilihtindakan]"]');
    $(obj).parents('table').find('tr').each(function(){
        $(this).find('input[name$="[is_pilihtindakan]"]').val(0);
        $(this).removeClass('checked');
    });
    if(is_pilihtindakan.val() > 0){
        is_pilihtindakan.val(0);
        $(obj).parents('tr').removeClass('checked');
    }else{
        is_pilihtindakan.val(1);
        $(obj).parents('tr').addClass('checked');
    }
}

/**
 * print karcis
 */
function printKarcis()
{
    window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/PendaftaranRawatJalan/printKarcis',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

/**
 * hapus tindakan dari database
 */
function verifTindakan(obj){

    var tindakanpelayanan_id = $(obj).closest('tr').find('.tindakanpelayanan_id').val();
    
    if($(obj).is(':checked')) {
    
        $.ajax({
            type:'POST',
            url:'<?php echo Yii::app()->createUrl('billingKasir/tindakanRawatJalan/VerifikasiTindakan'); ?>',
            data: {tindakanpelayanan_id:tindakanpelayanan_id},
            dataType: "json",
            success:function(data){
                if(data.sukses){
                    $(obj).parents('tr').detach();
                }
                myAlert(data.pesan);
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log(errorThrown);
            }
        });
    
    }

}
</script>