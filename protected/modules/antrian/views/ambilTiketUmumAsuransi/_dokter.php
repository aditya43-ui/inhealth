<?php
if (count($modDokters) > 0) {
    $i = 1;
    foreach ($modDokters as $key => $dok) {
        $cri = new CDbCriteria();
        $cri->addCondition('t.pegawai_id =' . $dok->pegawai_id);
        $cri->addCondition('DATE(t.tglantrian) =' . "'" . date('Y-m-d') . "'");
        $cri->join = 'left join modelantrian_m m on m.modelantrian_id = t.modelantrian_id';
        // $total =
        $antrian = AntrianT::model()->findAll($cri);
        
        $cru = clone $cri;
        $cru->addCondition("m.modelantrian_kode = 'U'");
        $antrian_u = AntrianT::model()->count($cru);
        
        $crb = clone $cri;
        $crb->addCondition("m.modelantrian_kode = '".Params::MODELANTRIAN_BPJS."'");
        $antrian_b = AntrianT::model()->count($crb);
        

        if (!empty($kode)) {
            if (count($antrian) >= ($dok->maximumbpjsantrian + $dok->maximumantrian)) {
                continue;
            }
            if ($kode == Params::MODELANTRIAN_BPJS && $antrian_b >= $dok->maximumbpjsantrian) {
                continue;
            }
            if ($kode == 'U' && $antrian_u >= $dok->maximumantrian) {
                continue;
            }
        }



?>
        <?php $k = "k" . $i ?>
        <?php
        $input = array("#448074");
        $card_color = array_rand($input);
        ?>
        <div class="item-a" style="flex: 1 1 10%;height: fit-content;">
            <div class="tombol" onclick="setDokter(<?php echo $dok->pegawai_id; ?>,'')" style="background-color:#448074; height: auto;">
                <div class="tombolheader">
                    <div class="tombolicon">
                        <i class="entypo-print"></i>
                    </div>
                </div>
                <div class="tombolbody2">
                    <hr>
                    <div class="labeltiket3" style="font-size:1.3vw;">
                        <!-- DOKTER <br> -->
                        Dr. <br>
                        <?php echo isset($dok->pegawai) ? strtoupper($dok->pegawai->nama_pegawai) : ""; ?>
                        <br>
                        <span class="total_tiket"><?php echo count($antrian) ?></span> / <?php echo $dok->maximumantrian + $dok->maximumbpjsantrian; ?><br/>
                        U : <span class="total_tiket_u"><?php echo $antrian_u; ?></span> / <?php echo $dok->maximumantrian; ?><br/>
                        <?php echo Params::MODELANTRIAN_BPJS; ?> : <span class="total_tiket_b"><?php echo $antrian_b; ?></span> / <?php echo $dok->maximumbpjsantrian; ?>
                    </div>
                </div>
            </div>
            <?php
            $i++;
            ?>
        </div>
<?php
    }
} else {
    echo '<p class="maaf">Maaf, belum ada dokter.</p>';
}
?>