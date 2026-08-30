<div class="clear"></div>
<?php
$col = array("#0c0", "#00a", "#ea0", "#0e0");
$cnt = 0;
if (count($nomor_loket) > 0) {
    foreach($nomor_loket as $ii => $d){
?>
    <div class="lis-antrian  <?php echo ($ii>0)?' hide':''; ?>" nolist = '<?php echo $ii; ?>'>
<?php
    foreach ($d AS $i => $loket) {
        ?>            
        <div   class=" col-md-12" style="
            width:calc((100%/<?php echo count($d); ?>) - 0.3vh); float: left;
            margin-top:  1vh;
            margin-left: 0.3vh;
            padding:0px;
            padding-right:1.2vh;
        ">
                 <?php
                 $subCnt = 0;
                 foreach ($loket['loket_id'] as $loket_id):

                     $modLoket = LoketM::model()->findByPk($loket_id);
                     $modAntrian = ModelantrianM::model()->findByPk($modLoket->modelantrian_id);
                     ?>
                <div 
                    id="loket_<?php echo $loket['loket_no']; ?>" 
                    class="antrian loketAntrian_<?php echo $loket['loket_no']; ?>"
                    data-loket-no="<?php echo $loket['loket_no']; ?>" 
                    data-antrian="<?php echo implode(",",$loket['det']);  ?>"
                    data-loket_id="<?php echo implode(",",$loket['det']);  ?>"
                    <?php echo $subCnt ? "" : "" ?>
                    >

                    <div>
                        <div class="col-md-8 bantrian" style="padding:0px;">
                            <?php // echo $modAntrian->modelantrian_singkatan; ?>
                            <p style="text-align:center; color:white;font-family:oswald; font-weight:bolder; padding-top:1vh; font-size:1.5vw;">NO. ANTRIAN</p>
                            <p class="no-antrian" style="text-align:center; color:white;font-family:oswald; font-weight:bolder; padding-top:1vh; font-size:1.5vw;">X - 000</p>
                        </div>
                        <div class="col-md-4 cantrian" style="color:white;padding:0px;">                            
                            <div style="text-align:center; font-size:1.5vw; font-family:oswald; font-weight:bolder;padding-top: 1vh;">
                                <?php
                                $data = array();
                                $data = (explode(" ", $loket['loket_nama']));
                                echo strtoupper($data[0]);
                                ?>
                            </div>
                            <div style="text-align:center; font-size:1.5vw; margin-top:-1vh; font-family:oswald; font-weight:bolder;">
                                <?php
                                echo strtoupper($data[1]);
                                ?>
                            </div>   
                        </div>
                    </div>
                    <?php echo $this->renderPartial($pathview . '/_formAntrian', array('model' => $model)); ?>
                </div>
                <?php
                $subCnt++;
            endforeach;
            ?>
        </div>            
            <?php
            $cnt++;
        }
        ?>
        </div>
<?php
    }
    }
    ?>