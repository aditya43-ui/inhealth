<div class="box-antrian stretch" data-loket-ke="<?= $i ?>" data-loket-id="<?= $loketId ?>" style="margin-bottom:1vw;margin-top:0.8vw;">        
    <div class="container">
        <div class="loket"><font color ="white">LOKET <?= $loket ?></font></div>
        <br/>
        <div style="width:100%"></div>

        <?php
            $maks = 18;
            
            $class =  'odd';
            for($a = 0;$a < $maks;$a++){                
                if ($a % 4 == 0){
                    $class = ($class == 'odd')?'odd':'odd';
                }
        ?>
                <div data- class="item stretch odd bg-<?= $i ?>" style="border-radius: 0px;">
                    
                        <?php   if(empty($model[$a])){
                                    echo '&nbsp';
                                } else {
                                    if($model[$a]->modelantrian_id == Params::MODELANTRIAN_UMUM_ANTRIAN) {
                                        $panjangkata = $model[$a]->modelantrian_singkatan.'-'. str_pad($model[$a]->noantrian, 3, '0', STR_PAD_LEFT);
                                        if(strlen($panjangkata) >= 5) {
                                            $noantrian = '<span class="text-antrian-6kata">';
                                            $noantrian .= $panjangkata;
                                            $noantrian .= '</span>';
                                        } else {
                                            $noantrian = '<span class="text-antrian-5katakebawah">';
                                            $noantrian .= $panjangkata;
                                            $noantrian .= '</span>';
                                        }
                                        echo $noantrian;
                                    } else {
                                        $panjangkata =  $model[$a]->ruangan_singkatan.'-'.str_pad($model[$a]->noantrian, 3, '0', STR_PAD_LEFT);
                                        if(strlen($panjangkata) >= 5) {
                                            $noantrian = '<span class="text-antrian-6kata">';
                                            $noantrian .= $panjangkata;
                                            $noantrian .= '</span>';
                                        } else {
                                            $noantrian = '<span class="text-antrian-5katakebawah">';
                                            $noantrian .= $panjangkata;
                                            $noantrian .= '</span>';
                                        }
                                        echo $noantrian;
                                    }
                                }
                        ?>
                   
                </div>            
        <?php
            }
        ?>      
    </div>
</div>