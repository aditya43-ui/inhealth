
<table class="items table table-striped table-bordered table-condensed" id="tblInputTindakan">
    <thead>
        <tr>
            <th>Tanggal Resep</th>
            <th>No. Resep</th>
            <th>Nama Dokter</th>
            <th>Lihat Detail</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <?php foreach ($modRiwayatResep as $i => $resep) { ?>
    <tr>
        <td><?php echo $resep->tglreseptur ?></td>
        <td><?php echo $resep->noresep ?></td>
	<?php $pegawai = PegawaiM::model()->findByPk($resep->pegawai_id) ?>
        <td><?php echo  $pegawai->nama_pegawai ?></td>
        <td><p style="margin: 0; text-align: center;"><?php echo CHtml::link("<i class='icon-eye-open'></i>", '#', array('onclick'=>'viewDetailResep("'.$resep->reseptur_id.'","'.$_GET["pendaftaran_id"].'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail rujukan')); ?></p></td>
	<td><p style="margin: 0; text-align: center;"><a onclick="hapusresep('<?php echo $resep->reseptur_id; ?>',this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Reseptur"><i class="icon-trash"></i></a></p></td>
    </tr>
    <?php } ?>
</table>
<script type="text/javascript">
    function hapusresep(reseptur_id,obj)
    {
        tabel = obj;
        myConfirm('Apakah Anda akan menghapus Reseptur ini?', 'Perhatian!', function(r)
        {
            if(r){
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('hapusRiwayatReseptur'); ?>',
                    data: {reseptur_id:reseptur_id},
                    dataType: "json",
                    success:function(data){
                        if(data.sukses){
                            var delete_row = $(tabel).parents('tr');
                            delete_row.detach();
                        }
                        myAlert(data.pesan);
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });

            }
        });
    }
</script>

