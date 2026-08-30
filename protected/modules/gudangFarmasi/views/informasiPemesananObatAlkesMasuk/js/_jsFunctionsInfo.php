<?php
/**
*       - digunakan untuk menyimpan semua fungsi javascript agar mudah ditracking untuk di informasi
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/
?>
<script>
function ubahStatus(status,pesanobatalkes_id){
    
    myConfirm("Apakah Anda yakin, ingin mengubah status menjadi <b>"+status+"</b>","Perhatian !",function(r){
        if (r){
           $.ajax({
                type:'POST',
                url:"<?php echo $this->createUrl('ubahStatus');?>",
                data: {status:status, pesanobatalkes_id:pesanobatalkes_id },
                dataType: "json",
                success:function(data){
                        if (data.sukses == 1){
                            refreshTabel();
                        }else{                       
                            myAlert(data.pesan);
                        }
                },
                error: function (jqXHR, textStatus, errorThrown) { 

                }
            }); 
            }
    });        
}

function refreshTabel(){
    $.fn.yiiGridView.update('pemesananobatalkesmasuk-m-grid', {
        data: $(this).serialize()
    });
    return false;
}
</script>