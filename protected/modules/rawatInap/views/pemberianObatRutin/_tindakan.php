<style>
    .text td{
        background-color:#D3D3DC !important;
    }
</style>
<div class="block-tabel">
    <table class="table table-bordered table-striped" id="riwayat-obatalkespasien-t">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jenis Obat</th>
                <th style="text-align:center;">Aturan</th>
                <th style="text-align:left;">Cara Pemberian</th>
                <th style="text-align:center;">Pemberian Obat Detail</th>
                <!-- <th style="text-align:center;">Aksi</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            foreach ($modPemberianObatRutin2 as $i => $mod) { 
                $no++;
            ?>
                <?php if($mod->penerimaan_status == 'Diterima'){?>
                    <tr class="text">
                        <td >
                            <?php echo $no; ?>
                        </td>
                        <td >
                            <?php echo $mod->obatalkes_nama; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $mod->subjenis_nama; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $mod->aturanpakaiobat; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo !empty($mod->carapemberian) ? $mod->carapemberian : "-"; ?>
                        </td>
                        <td style="text-align: left;">                                
                            <?php echo !empty($mod->jadwal) ? $mod->jadwal:'-'.'<br>'; ?>
                            <?php echo '<br>' ?>
                            <?php echo 'Status :'.$mod->tanda; ;?>
                            <?php echo '<br>' ?>
                            <?php echo 'Tanggal : ' . $mod->tanggal_pemberian; ;?>
                            <?php echo '<br>' ?>
                            <?php echo 'Petugas : ' . $mod->initial; ;?>
                        </td>
                        <!-- <td style="text-align: center;"> -->
                            <!-- <a onclick="hapusOaPasien('<?php //echo $bmhp->tindakanpelayanan_id; ?>',this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat / Alat Kesehatan"><i class="icon-trash"></i></a> -->
                        <!-- </td> -->
                    </tr>
                <?php }else{ ?>
                    <tr>
                        <td >
                            <?php echo $no; ?>
                        </td>
                        <td >
                            <?php echo $mod->obatalkes_nama; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $mod->subjenis_nama; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $mod->aturanpakaiobat; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo !empty($mod->carapemberian) ? $mod->carapemberian : "-"; ?>
                        </td>
                        <td style="text-align: left;">                                
                            <?php echo !empty($mod->jadwal) ? $mod->jadwal:'-'.'<br>'; ?>
                            <?php echo '<br>' ?>
                            <?php echo 'Status :'.$mod->tanda; ;?>
                            <?php echo '<br>' ?>
                            <?php echo 'Tanggal : ' . $mod->tanggal_pemberian; ;?>
                            <?php echo '<br>' ?>
                            <?php echo 'Petugas : ' . $mod->initial; ;?>
                        </td>
                        <!-- <td style="text-align: center;">
                            <a onclick="hapusOaPasien('<?php //echo $bmhp->tindakanpelayanan_id; ?>',this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat / Alat Kesehatan"><i class="icon-trash"></i></a>
                        </td> -->
                    </tr>
                <?php }?>
            <?php } ?>
        
        </tbody>
    </table>
</div>
<?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
    'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'buttons' => array(
        array('label' => 'Print', 'icon' => 'entypo-print', 'url' => '#', 'htmlOptions' => array('onclick' => 'printRiwayat(\'PRINT\')')),
        array('label' => '', 'items' => array(
            array('label' => 'PDF', 'icon' => 'icon-book', 'url' => '', 'itemOptions' => array('onclick' => 'printRiwayat(\'PDF\')')),
            array('label' => 'Excel', 'icon' => 'icon-pdf', 'url' => '', 'itemOptions' => array('onclick' => 'printRiwayat(\'EXCEL\')')),

        )),
    ),
    'htmlOptions' => array('style' => 'float:right')
    //        'htmlOptions'=>array('class'=>'btn')
)); ?>

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