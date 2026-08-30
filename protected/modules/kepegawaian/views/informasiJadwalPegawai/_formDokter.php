<div id="jadwal_<?php echo $data->pegawai_id; ?>">
    <?php echo CHtml::link('<i class="icon-pencil"></i> '.$data->pegawai->nama_pegawai, 'javascript:void(0)', array('onclick'=>'ubahDokter('.$data->pegawai_id.')','rel'=>"tooltip", 'data-original-title'=>"Klik untuk Merubah Dokter"))?>
</div>
<div id="ubahjadwal_<?php echo $data->pegawai_id; ?>" class="hide">
    <?php echo CHtml::dropDownList('idDokter_'.$data->pegawai_id, $data->pegawai_id, CHtml::listData(DokterV::model()->findAll(),'pegawai_id','nama_pegawai'), array('class'=>'span2')) ?>
    <?php echo CHtml::link('OK', 'javascript:void(0)', array('onclick'=>'prosesUbah('.$data->pegawai_id.')','class'=>'btn'));?>
    <?php echo CHtml::link('Batal', 'javascript:void(0)', array('onclick'=>'batalUbah('.$data->pegawai_id.')','class'=>'btn'));?>
</div>

<script type="text/javascript">
function ubahDokter(idDokter)
{
    $('#jadwal_'+idDokter).addClass('hide');
    $('#ubahjadwal_'+idDokter).removeClass('hide');
}

function batalUbah(idDokter)
{
    $('#idDokter_'+idDokter).val(idDokter);
    $('#ubahjadwal_'+idDokter).addClass('hide');
    $('#jadwal_'+idDokter).removeClass('hide');
}

function prosesUbah(dokterSebelumnya)
{
    var idDokter = $('#idDokter_'+dokterSebelumnya).val();
    $.post('<?php echo $this->createUrl('ubahDokterJadwal') ?>', {idDokter:idDokter, dokterSebelumnya:dokterSebelumnya}, 
        function(data){
            if(data.status=='OK')
                $.fn.yiiGridView.update('pencarianjadwal-grid');
            else
                myAlert('Gagal merubah Dokter');
    }, 'json');
}
</script>