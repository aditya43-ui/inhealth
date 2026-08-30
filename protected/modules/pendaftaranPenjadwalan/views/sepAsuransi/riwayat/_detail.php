<div class="row-fluid">
    <div class="col-sm-3" style="height: 400px; overflow-y: auto;">
        <?php foreach ($data as $item): ?>
        <div class="riwayat_sep">
            <?php 
            $onclick = "setDetailSep(".CJSON::encode($item)."); return false;";
            if (!$item['adaDetail']) {
                $onclick = "myAlert('Detail tidak ditemukan dikarenakan SEP dri Rumah Sakit Lain.'); return false;";
            }
            echo CHtml::link("<strong><u>".$item['noSep']."</u></strong>", '#', array(
                'onclick'=>$onclick,
            )); ?><br/>
            <?php echo $item['jnsPelayanan'] == 2 ? "Rawat Jalan" : "Rawat Inap"; ?><br/>
            <?php echo $item['poli']; ?></br>
            Tgl SEP. <?php echo $item['tglSep']; ?><br/>
            <?php echo $item['noRujukan']; ?><br/>
            <?php echo $item['diagnosa_nama']; ?><br/>
            <?php echo $item['ppkPelayanan']; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="col-sm-9">
        <div class="riwayat_sep_detail">

        </div>
</div>