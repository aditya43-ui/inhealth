<?php
/**
* - digunakan untuk melakukan inputan data asesmen triase
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<table class="table border">
    <tr>
        <th>&nbsp;</th>
        <th class="triase-merah"><?php echo $form->checkBox($modAsesTriase,'ismerah') ?> Merah</th>
        <th class="triase-kuning"><?php echo $form->checkBox($modAsesTriase,'iskuning') ?> Kuning</th>
        <th class="triase-hijau"><?php echo $form->checkBox($modAsesTriase,'ishijau') ?> Hijau</th>
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
                <td><?php echo $look->lookup_name ?></td>
                <td class="triase-merah">
                    <?php  
                        if (isset($dataTriase["$look->lookup_value"]["$merah"])){

                            foreach ($dataTriase["$look->lookup_value"]["$merah"] as $tri){
                                $modAsesTriDet->ispilih = $tri['value'];
                                echo '<label class="checkbox inline" id="triase_id_'.$tri["triase_id"].'">'.$form->CheckBox($modAsesTriDet,'['.$tri["triase_id"].']ispilih', array('value'=>$tri['triase_id'],
                                'onclick' => "pilihTriaseIni(this)"));
                                //echo $form->hiddenField($modAsesTriDet,'[]triase_id');
                                echo '<span>'.$tri['keterangan_triase'].'</span>';
                                echo '</label><br>';
                            }
                        }
                    ?>
                </td>
                <td class="triase-kuning">
                    <?php  
                        if (isset($dataTriase["$look->lookup_value"]["$kuning"])){

                            foreach ($dataTriase["$look->lookup_value"]["$kuning"] as $tri){
                                $modAsesTriDet->ispilih = $tri['value'];
                                echo '<label class="checkbox inline" id="triase_id_'.$tri["triase_id"].'">'.$form->CheckBox($modAsesTriDet,'['.$tri["triase_id"].']ispilih', array('value'=>$tri['triase_id'],
                                'onclick' => "pilihTriaseIni(this)"));
                                //echo $form->hiddenField($modAsesTriDet,'[]triase_id');
                                echo '<span>'.$tri['keterangan_triase'].'</span>';
                                echo '</label><br>';
                            }
                        }
                    ?>
                </td>
                <td class="triase-hijau">
                    <?php  
                        if (isset($dataTriase["$look->lookup_value"]["$hijau"])){

                            foreach ($dataTriase["$look->lookup_value"]["$hijau"] as $tri){
                                $modAsesTriDet->ispilih = $tri['value'];
                                
                                echo '<label class="checkbox inline" id="triase_id_'.$tri["triase_id"].'">'.$form->CheckBox($modAsesTriDet,'['.$tri["triase_id"].']ispilih', array('value'=>$tri['triase_id'],
                                'onclick' => "pilihTriaseIni(this)"));
                                //echo $form->hiddenField($modAsesTriDet,'[]triase_id');
                                echo '<span>'.$tri['keterangan_triase'].'</span>';
                                echo '</label><br>';
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
                    <?php echo $form->checkBox($modAsesTriase,'ishitam') ?> Hitam diteruskan ke instalasi Pemulasaran Jenazah setelah observasi 2 jam
                </td>                    
            </tr>
			
			<tr>				
				<td colspan="4">
					<?php echo $this->renderPartial($this->path_view.'form._formGCS',array('modAsesTriase'=>$modAsesTriase,'form'=>$form),true); ?>                                                    				
				</td>
			</tr>
</table>

<table id="tampung-triase" hidden>
    <tbody>
        <?php
            if (count((array)$getTriase)>0){
                $i = 0;
                foreach ($getTriase as $set){
                    echo $this->renderPartial($this->path_view.'form._formGetTriase',array('modAsesTriDet'=>$set,'form'=>$form,'i'=>$i));
                    $i++;
                }
            }
        ?>
    </tbody>
</table>
