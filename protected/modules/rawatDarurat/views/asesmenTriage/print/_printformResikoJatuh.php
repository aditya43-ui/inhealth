<?php
/**
* - digunakan untuk menginput data asesmen nyeri
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<table class="table border" id="resikoJatuh">
    <thead>
        <tr>
            <th colspan="4">Data Skrining Resiko Jatuh (MORSE FALLS SCALE)</th>
        </tr>
        <tr>
            <th>No.</th>
            <th>Resiko</th>
            <th>Penilaian</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: right;vertical-align: middle;">1</td>
            <td style="text-align: right;vertical-align: middle;">                 
                Resiko Jatuh, yang baru atau dalam bulan terakhir
            </td>
            <td>                 
                <?php
                    //echo $form->dropDownList($modFisik, 'riwayatjatuh_penilaian', Params::getPilihanJawaban(),array('onchange'=>'hitRiwayatJatuh(this)','empty' => '-- Pilih --'));
                    echo $modFisik->riwayatjatuh_penilaian;
                ?>                        
            </td>
            <td>
                <?php
                    //echo $form->textField($modFisik,'riwayatjatuh_skor',array('style'=>'text-align:right;','class'=>'col-sm-3 score', 'readonly'=>true))
                    echo $modFisik->riwayatjatuh_skor;
                ?>
            </td>
        </tr>   
        <tr>
            <td style="text-align: right;vertical-align: middle;">                 2</td>
            <td style="text-align: right;vertical-align: middle;">                 
                Diagnisis Medis Sekunder > 1
            </td>
            <td>                 
                <?php
                    //echo $form->dropDownList($modFisik, 'diagnosismedis_penilaian',Params::getPilihanJawaban(),array('onchange'=>'hitDiagnosisMedis(this);','empty' => '-- Pilih --'));
                    echo $modFisik->diagnosismedis_penilaian;
                ?>                        
            </td>
            <td>
                <?php
                    //echo $form->textField($modFisik,'diagnosismedis_skor',array('style'=>'text-align:right;','class'=>'col-sm-3 score', 'readonly'=>true))
                
                    echo $modFisik->diagnosismedis_skor;
                ?>
                    
            </td>
        </tr>   
        <tr>
            <td style="text-align: right;vertical-align: middle;">                 3</td>
            <td style="text-align: right;vertical-align: middle;">                 
                Alat Bantu Jalan
            </td>
            <td>                 
                <?php
                    //echo $form->dropDownList($modFisik, 'alatbantujalan_penilaian', Params::getAlatBantu(),array('onchange'=>'hitAlatBantu(this);','empty' => '-- Pilih --'));
                    echo $modFisik->alatbantujalan_penilaian;
                ?>                        
            </td>
            <td>
                <?php
                    //echo $form->textField($modFisik,'alatbantujalan_skor',array('style'=>'text-align:right;','class'=>'col-sm-3 score', 'readonly'=>true))
                    echo $modFisik->alatbantujalan_skor;
                ?>
            </td>
        </tr>   
        <tr>
            <td style="text-align: right;vertical-align: middle;">                 4</td>
            <td style="text-align: right;vertical-align: middle;">                 
                Memakai Terapi Heparin Lock/IV
            </td>
            <td>                 
                <?php
                    //echo $form->dropDownList($modFisik, 'memakaiterapiheparin_penilaian', Params::getPilihanJawaban(),array('onchange'=>'hitHeparin(this);','empty' => '-- Pilih --'));
                    echo $modFisik->memakaiterapiheparin_penilaian;
                ?>                        
            </td>
            <td>
                <?php
                    //echo $form->textField($modFisik,'memakaiterapiheparin_skor',array('style'=>'text-align:right;','class'=>'col-sm-3 score', 'readonly'=>true))
                    echo $modFisik->memakaiterapiheparin_skor;
                ?>
            </td>
        </tr>   
        <tr>
            <td style="text-align: right;vertical-align: middle;">                 5</td>
            <td style="text-align: right;vertical-align: middle;">                 
                Cara Berjalan/Berpindah
            </td>
            <td>                 
                <?php
                    //echo $form->dropDownList($modFisik, 'caraberjalan_penilaian', Params::getCara(),array('onchange'=>'hitCaraBerjalan(this);','empty' => '-- Pilih --'));
                    echo $modFisik->caraberjalan_penilaian;
                ?>                        
            </td>
            <td>
                <?php
                    //echo $form->textField($modFisik,'caraberjalan_skor',array('style'=>'text-align:right;','class'=>'col-sm-3 score', 'readonly'=>true))
                    echo $modFisik->caraberjalan_skor;
                ?>
            </td>
        </tr> 
        <tr>
            <td style="text-align: right;vertical-align: middle;">                 6</td>
            <td style="text-align: right;vertical-align: middle;">                 
                Status Mental
            </td>
            <td>                 
                <?php
                    //echo $form->dropDownList($modFisik, 'statusmental_penilaian', Params::getStatusMental(),array('onchange'=>'hitStatusMental(this);','empty' => '-- Pilih --'));
                    echo $modFisik->statusmental_penilaian;
                ?>                        
            </td>
            <td>
                <?php
                    //echo $form->textField($modFisik,'statusmental_skor',array('style'=>'text-align:right;','class'=>'col-sm-3 score', 'readonly'=>true))
                    echo $modFisik->statusmental_skor;
                ?>
            </td>
        </tr> 
    </tbody>
    <tfoot>
    <tr>
      <td colspan="2"></td>
        
        <td style="text-align: right;vertical-align: middle;">                 
            Total Score                       
        </td>
        <td>
            <?php
                //echo $form->textField($modFisik,'resikojatuh_skor',array('style'=>'text-align:right;','class'=>'col-sm-3', 'readonly'=>true))
                echo $modFisik->resikojatuh_skor;
            ?>
        </td>
    </tr> 
    <tr>
        <td colspan="2"></td>
        
        <td style="text-align: right;vertical-align: middle;">                 
            Hasil Resiko Jatuh                   
        </td>
        <td><?php
            //var_dump($modFisik->resikojatuh_keterangan);
            $pisah = explode("{{pisah}}", $modFisik->resikojatuh_keterangan);
            ?>
            <div class="control-group">                
                <div class="controls">
                    <?php 
                        $modFisik->resikojatuh_keterangan = isset($pisah[0])?$pisah[0]:null;
                        //echo $form->textArea($modFisik,'[0]resikojatuh_keterangan',array('class'=>'autogrow')); 
                        echo 'Resiko :'.$modFisik->resikojatuh_keterangan;
                        ?>
                </div>
            </div>
            <div class="control-group">
                
                <div class="controls">
                    <?php 
                        $modFisik->resikojatuh_keterangan = isset($pisah[1])?$pisah[1]:null;
                        //echo $form->textArea($modFisik,'[1]resikojatuh_keterangan',array('class'=>'autogrow')); 
                        echo 'Tindakan :'.$modFisik->resikojatuh_keterangan;
                        ?>
                </div>
            </div>
            
        </td>
    </tr> 
    </tfoot>
</table>

