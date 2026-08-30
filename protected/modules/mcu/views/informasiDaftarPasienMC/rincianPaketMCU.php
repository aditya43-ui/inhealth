<?php

$res = array();
foreach ($modTindakanPelayanan as $item) {
    if (empty($res[$item->tipepaket_id])) {
        
        $tipepaket = TipepaketM::model()->findByPk($item->tipepaket_id);
        
        $res[$item->tipepaket_id] = array(
            'nama'=>$tipepaket->tipepaket_nama,
            'detail'=>array()
        );
        
    }
    array_push($res[$item->tipepaket_id]['detail'], $item);
}

foreach ($res as $paket) { ?>
<div class="panel panel-dark">
            <span class="group-title">
                <b><?php echo $paket['nama']; ?></b>
            </span>
            <div class="panel-body">
<table class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>Daftar Pemeriksaan</th>
            <th>Ruangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
         foreach ($paket['detail'] as $data) { ?>
        <?php
        
         $nama_paket = TipepaketM::model()->findByPk($data->tipepaket_id);
         $modDaftarTindakan = DaftartindakanM::model()->findByPk($data->daftartindakan_id);
         $tipepaket = $modDaftarTindakan->daftartindakan_nama;     
         ?>
        <tr>
            <td><?php echo $tipepaket; ?></td>
            <td><?php echo empty($data->ruangan) ? "-" : $data->ruangan->ruangan_nama; ?></td>
        </tr>
        <?php
         
         } ?>      
    </tbody>
</table>
            </div> 
</div><br>
<div class="clear"></div>
<?php }


