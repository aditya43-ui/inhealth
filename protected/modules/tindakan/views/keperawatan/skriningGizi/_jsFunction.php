<?php echo CHtml::hiddenField('pendaftaran_id', $_GET['pendaftaran_id']); ?>
<script>
    function hitungScore(obj){
        var nilai = $(obj).attr('datavalue');
        var id = $(obj).attr('skrining');
        
        $(obj).parents('tr').find('input[name*="[skriningmst_jawaban]"]').val(nilai);
        $(obj).parents('tr').find('input[name*="[jawabanskrininggizimst_id]"]').val(id);
        hitungTotal();
    }

    function hitungTotal(){
        var total = 0;
        $('#skrining-gizi > tbody > tr').each(function() {
            var nilai = parseInt($(this).find('input[name*="[skriningmst_jawaban]"]').val());
            if (isNaN(nilai)) {
                nilai = 0;
            }
            total += nilai;
        });

        $('#RJSkrininggiziT_total_skor').val(total);
    }

    function viewDetail(skrininggizi_id) {

        $.post('<?php echo $this->createUrl('AjaxDetail') ?>', {
            skrininggizi_id: skrininggizi_id,
        }, function(data) {
            $('#contentDetailGizi').html(data.result);
        }, 'json');
        $('#dialogDetailGizi').dialog('open');
    }

    function hapusresep(skrininggizi_id, pendaftaran_id, obj)
    {
        tabel = obj;
        var is_pendaftaran = $('#pendaftaran_id').val();
        if(is_pendaftaran == pendaftaran_id){
            window.parent.parent.myAlert('Data sedang ditampilkan, tidak dapat dihapus!');
        }else{
            window.parent.parent.myConfirm('Apakah anda akan menghapus pemeriksaan ini?', 'Perhatian!', function(r)
            {
                if(r){
                    $.ajax({
                        type:'POST',
                        url:'<?php echo $this->createUrl('hapusRiwayatReseptur'); ?>',
                        data: {reseptur_id:reseptur_id},
                        dataType: "json",
                        success:function(data){
                            if(data.sukses){
                                $.fn.yiiGridView.update('daftarriwayat-v-grid', {
                                    data:{
                                        "RJSkrininggiziT[pasien_id]":data.pasien_id,
                                    }
                                });
                            }
                            window.parent.parent.myAlert(data.pesan);
                        },
                        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                    });

                }
            });
        }
    }
    
    $(document).ready(function() {
    });
</script>