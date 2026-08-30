<script type='text/javascript'>
    function tambahModul(obj){
        if($(obj).is(':checked')){
            id = $(obj).val();
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('getTugas') ?>',
                    data: {id:id},
                    success:function(data){
                        $("#row_modul_"+$(obj).val()).html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
        }else{
            id = $(obj).val();
            $("#modul_"+id).detach();
        }

    }

    function setDataPemakai(id){
        cekPemakai(id);
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('getPemakai') ?>',
            data: {id:id},
            dataType: "json",
            success:function(data){
                $('#loginpemakai_id').val(data.id);
                $('#namaloginpemakai').val(data.nama_pemakai);
                $('#namapegawai').val(data.nama_pegawai);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }

    function cekPemakai(id){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('cekLoginPemakai') ?>',
            data: {pemakai:id},
            dataType: "json",
            success:function(data){
                if(data.success==1){
                     window.location="<?php echo $this->createUrl('update'); ?>&id="+data.id;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
</script>
