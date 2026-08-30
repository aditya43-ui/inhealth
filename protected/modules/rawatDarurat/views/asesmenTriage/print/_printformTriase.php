<?php
/**
* - digunakan untuk melakukan inputan data asesmen triase
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>

    <tr>
        <th colspan="4" style="text-align: center;">ASESMEN TRIAGE</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th class="triase-merah"><?php echo $form->checkBox($modAsesTriase,'ismerah',array('class'=>'form-check')) ?> <label> Merah</label></th>
        <th class="triase-kuning"><?php echo $form->checkBox($modAsesTriase,'iskuning') ?> <label> Kuning</label></th>
        <th class="triase-hijau"><?php echo $form->checkBox($modAsesTriase,'ishijau') ?> <label> Hijau</label></th>
    </tr>
    <?php
        if (count((array)$modLookup)>0){
            $merah = Params::TRIASE_WARNA_MERAH;
            $kuning = Params::TRIASE_WARNA_KUNING;
            $hijau = Params::TRIASE_WARNA_HIJAU;
            $hitam = Params::TRIASE_WARNA_HITAM;
            foreach($modLookup as $look){

    ?>
            <tr>
                <td width="10%"><?php echo $look->lookup_name ?></td>
                <td width='30%' class="triase-merah">
                    <?php  
                        if (isset($dataTriase["$look->lookup_value"]["$merah"])){

                            foreach ($dataTriase["$look->lookup_value"]["$merah"] as $tri){
                                $modAsesTriDet->ispilih = $tri['value'];
                                echo $form->CheckBox($modAsesTriDet,'['.$tri["triase_id"].']ispilih', array('value'=>$tri['triase_id'],
                                'onclick' => "pilihTriaseIni(this)"));
                                //echo $form->hiddenField($modAsesTriDet,'[]triase_id');
                                echo '<label> '.$tri['keterangan_triase'].'</label>';
                                echo '<br>';
                            }
                        }
                    ?>
                </td>
                <td width='30%' class="triase-kuning">
                    <?php  
                        if (isset($dataTriase["$look->lookup_value"]["$kuning"])){

                            foreach ($dataTriase["$look->lookup_value"]["$kuning"] as $tri){
                                $modAsesTriDet->ispilih = $tri['value'];
                                echo $form->CheckBox($modAsesTriDet,'['.$tri["triase_id"].']ispilih', array('value'=>$tri['triase_id'],
                                'onclick' => "pilihTriaseIni(this)"));
                                //echo $form->hiddenField($modAsesTriDet,'[]triase_id');
                                echo '<label> '.$tri['keterangan_triase'].'</label>';
                                echo '<br>';
                            }
                        }
                    ?>
                </td>
                <td width='30%' class="triase-hijau">
                    <?php  
                        if (isset($dataTriase["$look->lookup_value"]["$hijau"])){

                            foreach ($dataTriase["$look->lookup_value"]["$hijau"] as $tri){
                                $modAsesTriDet->ispilih = $tri['value'];
                                
                                echo $form->CheckBox($modAsesTriDet,'['.$tri["triase_id"].']ispilih', array('value'=>$tri['triase_id'],
                                'onclick' => "pilihTriaseIni(this)"));
                                //echo $form->hiddenField($modAsesTriDet,'[]triase_id');
                                echo '<label> '.$tri['keterangan_triase'].'</label>';
                                echo '<br>';
                            }
                        }
                    ?>
                </td>
            </tr>            
    <?php 
            }
        }
    ?>
            <tr>
                <td colspan="4">
                    <?php echo $form->checkBox($modAsesTriase,'ishitam') ?> <label> Hitam diteruskan ke instalasi Pemulasaran Jenazah setelah observasi 2 jam</label>
                </td>                    
            </tr>
