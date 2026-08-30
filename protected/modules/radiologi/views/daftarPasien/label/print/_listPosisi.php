<div style="background:none;position: absolute;rotate: 90;width:100mm;height:50mm;top:<?= $top ?>mm;left:<?= $left ?>mm;right:2mm;bottom:2mm;">            
    <?php if ($halaman == $posisi){ ?>
        <div class="" style="margin-bottom: 5px;margin-left: 25px;margin-top:25px;">        
            <img src="<?php echo Params::urlProfilRSDirectory() . $profil->logo_rumahsakit ?>" width="130px">
        </div>
        <div class="" style="margin-left: 25px; margin-top: 10px;">
            <span style="color: blue; font-size: 12px;">
                <?php
                if (!empty($data->tglmasukpenunjang)) {
                    $tgl = MyFormatter::formatDateTimeForDb($data->tglmasukpenunjang);
                    $explode_spasi = explode(' ', $tgl);
                    $explode_dash = explode('-', $explode_spasi[0]);
                    echo $explode_dash[2] . " " . MyFormatter::getMonthUserGaji($explode_dash[1]) . " " . $explode_dash[0];
                } else {
                    echo "-";
                }
                ?>
            </span>
        </div>
        <div class="" style="margin-left: 25px;">
            <b style="font-size: 14px;">
                <?php echo $data->no_rekam_medik; ?>
            </b>
        </div>
        <div class="" style="margin-left: 25px;">
            <b style="font-size: 14px;">
                <?php echo $data->nama_pasien; ?>
            </b>
        </div>
        <div class="" style="font-size: 12px;margin-left: 25px;">
            <?php echo $format->formatDateTimeForUser($data->tanggal_lahir); ?>
            (<?php
                $explodeUmur =  explode(" ", $data->umur);
                echo $explodeUmur[0] . " " . $explodeUmur[1];
                ?>)
        </div>
        <div class="" style="font-size: 12px;margin-left: 25px;">
            <?php
            $peg = PasienkirimkeunitlainT::model()->findByPk($data->pasienkirimkeunitlain_id);
            echo empty($peg) ? '-' : $peg->pegawai->namaLengkap; ?>
        </div>
        <div class="" style="font-size: 12px;margin-left: 25px;">
            <?php echo $data->instalasiasal_nama; ?>
        </div>
        <div class="" style="margin-left: 25px;">
            <b style="font-size: 12px; color: blue;">
                <?php
                if (count((array) $hasil) == 0) {
                    echo "-";
                } else {
                    $jenis = array();
                    foreach ($hasil as $item) {
                        $pemeriksaan = PemeriksaanradM::model()->findByPk($item->pemeriksaanrad_id);
                        if (!empty($pemeriksaan)) {
                            array_push($jenis, $pemeriksaan->pemeriksaanrad_nama);
                        }
                    }
                    echo implode(',', $jenis);
                }
                ?>
            </b>
        </div>     
    <?php } ?>
</div>
