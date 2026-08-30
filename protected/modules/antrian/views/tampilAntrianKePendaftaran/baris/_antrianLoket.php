<?php
    $maks = 15;
    
    for($a = 0;$a < $maks;$a++){                        
?>
        <div class="col-sm-2 col-nopadding" style="padding:5px;">
            <div id="loket_utama" class="" data-antrian="<?php echo $a; ?>" style='background-color:#0c0;'>
                <div style="height:2.25vw;padding:1px;<?php echo empty($i) ? "background-color:#0c0;" : "background-color:#0c0;"; ?>" class="col-xs-4 ruangan1" id="ruangan_<?php echo $i; ?>">
                    <div class="col-sm-12" style="font-size:1.6vw;">NO. ANTRIAN</div>
                </div>
                <div class="col-xs-4 " id="pantriantengah">
                    <div class="col-sm-12 no-antrian"  style="font-size:1.75vw;"><?= !empty($list[$a])?$list[$a]->noantrian:'0-000' ?></div>
                </div>
                <div style="display:none;" class="col-xs-4 ruangan_loket loket-nama" id="pasien-deskripsi_<?php echo $a; ?>">
                    <div class="col-sm-12">LOKET <?php echo $loket->loket_singkatan; ?></div>
                </div>
            </div>
        </div>
<?php
    }
?>    
