<?php
$url_hapus = $this->createUrl('hapusData');
$js = <<< JS
    var hapus_data = (obj) => {
        var id = $(obj).data('id');
        
        myConfirm("Apakah Anda yakin ingin menghapus pengkajian keperawatan ini?","Perhatian!", function(r){            
            if (r){
                $.ajax({
                    type:'POST',
                    url:'${url_hapus}',
                    data: {
                        id: id,                
                    },
                    dataType: "json",
                    success:function(data){                
                        if (data.sukses == 1){
                            toastr.success("Data berhasil dihapus","Perhatian!");

                            $.fn.yiiGridView.update('informasiasuhankeperawatan-grid', {
                                data: $("#pengkajiankeperawatan-info-search").serialize()
                            });
                        }else{
                            toastr.error("Data gagal dihapus","Perhatian!");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
            }
        });
    }
JS;

Yii::app()->clientScript->registerScript('hapus-data', $js, CClientScript::POS_END);


?>

<script>
    $(document).ready(function(){
        var ru  = jQuery('.ruangan_id');
        jQuery(ru).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '240px',
                enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>