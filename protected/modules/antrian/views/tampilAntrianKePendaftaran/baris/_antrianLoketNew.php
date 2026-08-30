<?php
    $maks = 36;
    // echo '<pre>';
    // var_dump($list);
    


    $listfasttrack = array();
    $listAntrianBiasa = array();
    for($a = 0;$a < $maks;$a++){
        if(!empty($list[$a])) {
            if($list[$a]->jenis_kunjungan == 'Fast Track' || strtolower($list[$a]->jenis_kunjungan) == 'fast track')   {       
                $listfasttrack[] = $list[$a];
            } else {
                $listAntrianBiasa[] = $list[$a];
            }
        }
    }

    for($i=0;$i<count($listfasttrack);$i++){


?> 
        <div class="col-sm-2 col-nopadding" style="padding:5px;">
            <div id="loket_utama" class="" data-antrian="<?php echo $i; ?>" style='background-color:#0c0;'>
                <div style="height:2.25vw;padding:1px;<?php echo empty($i) ? "background-color:#c00;" : "background-color:#c00;"; ?>" class="col-xs-4 ruangan1" id="ruangan_<?php echo $i; ?>">
                    <div class="col-sm-12" style="font-size:1.6vw;">NO. ANTRIAN</div>
                </div>
                <div class="col-xs-4 " id="pantriantengah">
                    <div class="col-sm-12 no-antrian"  style="font-size:1.75vw;">
                        <?php 
                            if(!empty($listfasttrack[$i])) {
                                if($listfasttrack[$i]->modelantrian_id == 1) {
                                    echo $listfasttrack[$i]->modelantrian_singkatan . '-' . str_pad($listfasttrack[$i]->noantrian, 3, '0', STR_PAD_LEFT);
                                } else {
                                    echo $listfasttrack[$i]->ruangan_singkatan . '-' . str_pad($listfasttrack[$i]->noantrian, 3, '0', STR_PAD_LEFT);
                                }
                            } else {
                                echo '0-000';
                            }
                        ?>
                    </div>
                </div>
                <div style="display:none;" class="col-xs-4 ruangan_loket loket-nama" id="pasien-deskripsi_<?php echo $i; ?>">
                    <div class="col-sm-12">LOKET <?php echo $loket->loket_singkatan; ?></div>
                </div>
            </div>
        </div>

<?php 
    }
// echo '<pre>';
// var_dump($listfasttrack);
if(count($listfasttrack) < 18) {
    $maksAntrianBiasa = 18 - count($listfasttrack);
    if($maksAntrianBiasa <= 18 && count($listfasttrack) == 0) {
        $maksAntrianBiasa = count($listAntrianBiasa);
    }
    for($c=0;$c<$maksAntrianBiasa;$c++){
        if(!empty($listAntrianBiasa[$c])) {
?>
    <div class="col-sm-2 col-nopadding" style="padding:5px;">
        <div id="loket_utama" class="" data-antrian="<?php echo $c; ?>" style='background-color:#0c0;'>
            <div style="height:2.25vw;padding:1px;<?php echo empty($c) ? "background-color:#0c0;" : "background-color:#0c0;"; ?>" class="col-xs-4 ruangan1" id="ruangan_<?php echo $c; ?>">
                <div class="col-sm-12" style="font-size:1.6vw;">NO. ANTRIAN</div>
            </div>
            <div class="col-xs-4 " id="pantriantengah">
                <div class="col-sm-12 no-antrian"  style="font-size:1.75vw;">
                    <?php
                        if(!empty($listAntrianBiasa[$c])) {
                            if($listAntrianBiasa[$c]->modelantrian_id == 1) {
                                echo $listAntrianBiasa[$c]->modelantrian_singkatan . '-' . str_pad($listAntrianBiasa[$c]->noantrian, 3, '0', STR_PAD_LEFT);
                            } else {
                                echo $listAntrianBiasa[$c]->ruangan_singkatan . '-' . str_pad($listAntrianBiasa[$c]->noantrian, 3, '0', STR_PAD_LEFT);
                            }
                        } else {
                            echo '0-000';
                        }
                        // !empty($listAntrianBiasa[$c])?$listAntrianBiasa[$c]->noantrian:'0-000' 
                    ?>
                </div>
            </div>
            <div style="display:none;" class="col-xs-4 ruangan_loket loket-nama" id="pasien-deskripsi_<?php echo $c; ?>">
                <div class="col-sm-12">LOKET <?php echo $loket->loket_singkatan; ?></div>
            </div>
        </div>
    </div>

<?php 
        }
    } 
}
?>