<div class="col-sm-12 col-md-3 ">
    <div class="tile-stats tile-purple datadaftin" style="background-color:#c31884;">
        <div class="icon"><i class="entypo-gauge"></i></div>
        <div class="num" style="font-size:16pt"><?php echo $modtindakan->daftartindakan_nama ?></div>
        <?php $modtarif =  TariftindakanM::model()->find("daftartindakan_id =" . $modtindakan->daftartindakan_id) ?>
        <h3 style="font-size:20pt">Rp <?php echo isset($modtarif->harga_tariftindakan) ? number_format($modtarif->harga_tariftindakan, 2) : 0 ?></h3>
    </div>
</div>