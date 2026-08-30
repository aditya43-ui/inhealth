<?php
// echo '<pre>';var_dump($jenis);die;
if (empty($jenis)){
    for($i = 1; $i < ($jml_input+1); $i++){
        if (count($modKantongDarah) > 0) {
            for ($i = 0; $i < count($modKantongDarah) + 2; $i++) {
                $nourut = preg_replace("/[^0-9]/", "", $modKantongDarah[0]->no_kantongdarah);
                $no_kantongpabrik = $modKantongDarah[0]->no_kantongpabrik;
                $gol_darah = $modKantongDarah[0]->pendonor->gol_darah;
                $nourut =  substr($nourut, -5);
                if(isset($modKantongDarah[$i])) {
                    $exp = explode(' ', $modKantongDarah[$i]->tglpencatatan);
                    $nobarcode = date("ymd", strtotime($exp[0]));
                    $nobarcode .= $nourut;
                    $jenis = JeniskomponendarahM::model()->findByAttributes(['jeniskantongdarah_singkatan' => $modKantongDarah[$i]->komponendarah->singkatan_komp], 'jeniskantongdarah_kode is not null');
                    if(!empty($jenis)) {
                        $nobarcode .= $jenis->jeniskantongdarah_kode;
                    }
                  
                } else {
                    $exp = explode(' ', $modKantongDarah[0]->tglpencatatan);
                    $nobarcode = date("ymd", strtotime($exp[0]));
                    $nobarcode .= $nourut;
                    if($i == count($modKantongDarah) + 1) {
                        $nobarcode .= 'S4';
                    } else {
                        $nobarcode .= 'S5';
                    }

                }
                ?>

                    <div class="container-box" style="display: inline-block;">
                        <div class="column column1" style="white-space: nowrap;width: 6%;height: 100%;display: inline-block;float: left;">
                            <table rotate="-90" style="page-break-inside: avoid; padding-right: 13px;">
                            <tr><td><span style="font-size: 6pt;"><?= $nobarcode ?></span></td></tr>
                            </table>
                        </div>
                        <div class="column column2" style="width: 90%;display: inline-block;padding-top: 5px;">
                            
                            <div style="font-size: 6pt; text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $no_kantongpabrik ?></div>
                            <barcode code="<?php echo $nobarcode; ?>" type="EAN128B" size="0.65" height="2.5"></barcode>
                            <table width="100%" style="font-size: 6pt;">
                                <tr>
                                    <td width="50%" style="padding-left: 9px;">
                                        <?php 
                                            if($i >= count($modKantongDarah)) {
                                                if($i == count($modKantongDarah) + 1) {
                                                    echo 'SD-EDTA';
                                                } else {
                                                    echo 'SD-SKRINING';
                                                }
                                            } else {
                                                echo $modKantongDarah[$i]->komponendarah->singkatan_komp;
                                                echo ' - CPDA';
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align: right;padding-right: 20px;">
                                        <?= $gol_darah ?>
                                    </td>
                                </tr>
                            </table>
                           
                        </div>
                    </div>
                   
                    <?php
                
            }
        }
    }
}else{
    if ($jenis == 'tanggalcetak'){        
        foreach ($modKantongDarah as $data) {
            if ($data['nomorbarcode_utama'] == $data['no_kantongdarah']){
                $tot = 17;
            }else{
                $tot = 19;
            }
            ?>
            <?php for ($i = 1; $i < $tot; $i++) { ?>
                <div style="text-align: center">
                    <span style="font-size: 15px;font-weight: bold;">ITD. RS. SAIFUL ANWAR</span><br>
                    <barcode code="<?php echo $data->no_kantongdarah; ?>" type="EAN128B"></barcode>
                    <span style="font-size: 25px;font-weight: bold;"><?php echo $data->no_kantongdarah; ?></span><br>
                </div>
                <?php
            }

        }
    }else{
        foreach ($modKantongDarah as $data) {
            ?>

                <div style="text-align: center">
                    <span style="font-size: 15px;font-weight: bold;">ITD. RS. SAIFUL ANWAR</span><br>
                    <barcode code="<?php echo $data->no_kantongdarah; ?>" type="EAN128B"></barcode>
                    <span style="font-size: 25px;font-weight: bold;"><?php echo $data->no_kantongdarah; ?></span><br>
                </div>
                <?php

        }
    }
}
?>