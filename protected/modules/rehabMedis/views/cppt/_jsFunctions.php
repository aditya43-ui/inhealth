<script type="text/javascript">
function changeJenisPPA(obj){
    var textvalue = $(obj).find('option:selected').text();
    var valuejenis = $(obj).val();

    if(valuejenis !== ''){
        $('#<?php echo CHtml::activeId($model, 'ppa_namajenis'); ?>').val(textvalue);
    }

    if(textvalue === "Ahli Gizi"){
        $('.soapahligizi').show();
        $('.soap').hide();
    }else{
        $('.soapahligizi').hide();
        $('.soap').show();
    }

    var ppa = $(obj).val();

    if(ppa == 1) {
        $('#PegawairuanganV_jabatan_id').val('29').change();
    } else if(ppa == 3) {
        $('#PegawairuanganV_jabatan_id').val('22').change();
    } else if(ppa == 6) {
        $('#PegawairuanganV_jabatan_id').val('42').change();
    } else if(ppa == 8) {
        $('#PegawairuanganV_jabatan_id').val('148').change();
    } else if(ppa == 9) {
        $('#PegawairuanganV_jabatan_id').val('147').change();
    } else if(ppa == 10) {
        $('#PegawairuanganV_jabatan_id').val('150').change();
    }

    console.log(ppa, 'ppa');
}

function hapusRiwayatCPPT(id, is_bisa) {

    if(is_bisa > 0) {
        window.parent.myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusRiwayatCPPT'); ?>', {id: id}, function(data) {
                    if (data.sukses === 1) {
                        window.parent.myAlert(data.msg);
                        $.fn.yiiGridView.update('riwayatcppt-t-grid', {
                            data: $('#searchriwayatcppt').serialize()
                        });
                    } else {
                        window.parent.myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }else {
        window.parent.myAlert('Anda tidak memiliki akses');
    }
}

function printRiwayat(pendaftaran_id,caraPrint)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint+'&'+$("#searchriwayatcppt :input").serialize(),'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
}

$(document).ready(function(){
    changeJenisPPA($('#<?php echo CHtml::activeId($model, 'ppa_jenis'); ?>'));

    var cek = $('.riwayat_ruangan_id').closest('.controls').find('input[type=checkbox][value="<?php echo $model->ruangan_id ?>"]').trigger('click');

    console.log('<?php echo 'ruangan_id: ' . $model->ruangan_id ?>');
    console.log('checked 1 : ' + cek);

    setTimeout(() => {
        $('.btn-cari').trigger('click');
    }, 1500);



});
</script>
