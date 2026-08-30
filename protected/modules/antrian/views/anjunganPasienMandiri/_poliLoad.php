<?php
$ruangan = RuanganM::model()->findAllByAttributes(array(
    'instalasi_id'=>Params::INSTALASI_ID_RJ,
    'ruangan_aktif'=>true,
), array(
    'order'=>'ruangan_nama'
));

foreach ($ruangan as $item):
    
    $hari = strtoupper(MyFormatter::getDayUser(date('w')));

    $jadwal = JadwalbukapoliM::model()->findByAttributes(array(
        'ruangan_id'=>$item->ruangan_id,
        'hari'=>$hari,
    ));

    $ada = false;
    $txt_tidakada = "";

    if (empty($jadwal)) {
        $ada = false;
    } else {
        $sekarang = strtotime(date('H:i:s'));
        $buka = strtotime($jadwal->jammulai);
        $tutup = strtotime($jadwal->jamtutup);

        if ($sekarang < $buka) {
            //$ada = true;
            //$txt_tidakada = "Poliklinik belum dibuka";
        } else if ($sekarang > $tutup) {
            $ada = false;
            $txt_tidakada = "Poliklinik sudah ditutup";
        } else {
            $ada = true;
        }

    }


?>
<a href="#" class="btn_poli" id="btn_poli_<?php echo $item->ruangan_id; ?>" onclick="pilihPoli(<?php echo $item->ruangan_id; ?>, <?php echo $ada ? 1 : 0; ?>); return false;">
    <div class="btn_poli_judul">
        <?php echo $item->ruangan_nama; ?>
    </div>
    <div class="btn_poli_desc">
        <?php echo empty($jadwal) ? "Tidak ada Jadwal" : ("Jam Buka Poli : ".$jadwal->jmabuka.(empty($txt_tidakada) ? "" : ("<br/>".$txt_tidakada))); ?>
    </div>
</a>
<?php

endforeach;

?>
<div class="clear"></div>


