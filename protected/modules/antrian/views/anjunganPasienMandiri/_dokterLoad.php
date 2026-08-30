<?php
foreach ($jadwal as $item):
    $ada = true;

    $sekarang = strtotime(date('H:i:s'));
    $buka = strtotime($item->jadwaldokter_mulai);
    $tutup = strtotime($item->jadwaldokter_tutup);

    //if ($sekarang > $tutup) {
    //    continue;
    //}


    $crd = new CDbCriteria();
    $crd->compare('ruangan_id', $item->ruangan_id);
    $crd->compare('pegawai_id', $item->pegawai_id);
    $crd->addCondition('tgl_pendaftaran::date = current_date');
    $total = PendaftaranT::model()->count($crd);

    $max = $item->maximumantrian ?? 0;
    $sisa = empty($max) ? 0 : ($max - $total);

    if ($sisa == 0) {
        $ada = false;
    }

    

?>
<a href="#" class="btn_dokter" id="btn_dokter_<?php echo $item->pegawai_id; ?>" onclick="pilihDokter(<?php echo $item->pegawai_id; ?>, <?php echo $ada ? 1 : 0; ?>); return false;">
    <div class="btn_dokter_judul">
        <?php echo $item->pegawai->namaLengkap; ?>
    </div>
    <div class="btn_dokter_desc">
        Jumlah Pasien yang Mendaftar : <?php echo $total; ?><br/>
        Sisa Kuota : <?php echo $sisa; ?>
    </div>
</a>
<?php

endforeach;
    
?>
<div class="clear"></div>