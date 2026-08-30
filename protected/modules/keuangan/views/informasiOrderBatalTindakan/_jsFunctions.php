<script>
    function verifOrderBatalTindakan(pendaftaran_id, petugasbatal_id) {

        console.log('masuk verif');

        myConfirm('Yakin Ingin Verifikasi?', 'Perhatian !', function(r) {
            if(r) {
                $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('verifBatalTindakan'); ?>',
                data: {pendaftaran_id:pendaftaran_id, petugasbatal_id:petugasbatal_id},
                dataType: "json",
                success:function(data){
                    console.log(data);
                    if(data.sukses == 1) {
                        toastr.success(data.pesan);
                    } else {
                        toastr.error(data.pesan)
                    }
                    $.fn.yiiGridView.update('pencarianverifikasi-grid', {
                        data: $('#tabelverifikasi-search').serialize()
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log(errorThrown);
                }
                });
               
            }
        });

        
    }
</script>