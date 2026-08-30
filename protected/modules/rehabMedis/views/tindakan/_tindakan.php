<div class="block-tabel">
    <table class="table table-bordered table-striped" id="riwayat-obatalkespasien-t">
        <thead>
            <tr>
                <th>Tanggal Tindakan</th>
                <th>Uraian Tindakan</th>
                <th style="text-align:center;">Jumlah</th>
                <th style="text-align:right;">Tarif</th>
                <th style="text-align:center;">Hapus</th>
            </tr>
        </thead>
        <tbody>
    <?php
    $total = 0; 
    foreach ($modViewTindakans as $i => $bmhp) { 
    $total += $bmhp->tarif_tindakan;
    ?>
    <tr>
        <td >
            <?php echo $bmhp->tgl_tindakan; ?>
        </td>
        <td >
            <?php echo $bmhp->daftartindakan->daftartindakan_nama; ?>
        </td>
        <td style="text-align: center;">
            <?php echo $bmhp->qty_tindakan; ?>
        </td>
        <td style="text-align: right;">
            <?php echo MyFormatter::formatNumberForPrint($bmhp->tarif_tindakan); ?>
        </td>
        <td style="text-align: center;">
            <a onclick="hapusOaPasien('<?php echo $bmhp->tindakanpelayanan_id; ?>',this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat / Alat Kesehatan"><i class="icon-trash"></i></a>
        </td>
    </tr>
    <?php } ?>
        
        </tbody>
        <!-- <tfooter>
            <tr>
                <td colspan="3" style="text-align: right;">
                    Subtotal
                </td>
                <td style="text-align: right;">
                    <?php //MyFormatter::formatNumberForPrint($total);?>
                </td>
            </tr>
        </tfooter> -->
    </table>
</div>
<script type="text/javascript">
    function hapusOaPasien(tindakanpelayanan_id,obj)
    {
        tabel = obj;
        myConfirm('Apakah Anda akan menghapus Tindakan ini?', 'Perhatian!', function(r)
        {
            if(r){
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('hapus'); ?>',
                    data: {tindakanpelayanan_id:tindakanpelayanan_id},
                    dataType: "json",
                    success:function(data){
                        if(data.sukses){
                            var delete_row = $(tabel).parents('tr');
                            delete_row.detach();
                        }
                        myAlert(data.pesan);
                        window.location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });

            }
        });
    }
</script>