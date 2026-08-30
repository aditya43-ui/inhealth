<script type="text/javascript">

function print(id)
{
    window.open('<?php echo $this->createUrl('print'); ?>&kriteriamasukicu_id='+id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
}

function hapusRiwayat(id) {
    myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('hapusRiwayat'); ?>', {id: id}, function(data) {
                if (data.sukses == 1) {
                    myAlert(data.msg);
                    window.location.replace('<?php echo $this->createUrl('index', array('pendaftaran_id'=>$model->pendaftaran_id)); ?>');
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        }
    });
}
</script>
