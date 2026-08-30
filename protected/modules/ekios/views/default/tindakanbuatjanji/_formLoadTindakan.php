<?php
$tarif = (!empty($modtariftindakan->harga_tariftindakan)) ? $modtariftindakan->harga_tariftindakan : 0 ;

// var_dump($modtariftindakan);die;
?>
<tr id="daftartindakan_<?php echo $modtariftindakan->daftartindakan_id; ?>">

      <td>
        <?php 
        
             
            $moddaftartindakan= DaftartindakanM::model()->findByPk($modtariftindakan->daftartindakan_id);
            echo  isset($moddaftartindakan->daftartindakan_nama)? $moddaftartindakan->daftartindakan_nama:"-";
            
            // if($moddaftartindakan->kelompoktindakan_id == Params::DEFAULT_KELOMPOKTINDAKAN_ORTHO){
            //     $modBuatjanji->is_kontrol = true;
            // }

            // $arr[] = $moddaftartindakan;
        ?>
        <?php echo CHtml::hiddenField("JanjipolitindakanT[".$modtariftindakan->daftartindakan_id."][daftartindakan_id]", $moddaftartindakan->daftartindakan_id,array('class'=>'inputFormTabel','readonly'=>true)); ?>
    </td>
    <td>
        <?php 
        echo MyFormatter::formatNumberForPrint($modtariftindakan->harga_tariftindakan); 
        
        ?>
        <?php echo CHtml::HiddenField("JanjipolitindakanT[".$modtariftindakan->daftartindakan_id."][tarif_tindakan]", $modtariftindakan->harga_tariftindakan,array('class'=>'inputFormTabel gty','readonly'=>true)); ?>
        <?php echo CHtml::hiddenField("JanjipolitindakanT[".$modtariftindakan->daftartindakan_id."][total]", $tarif,array('class'=>'inputFormTabel lebar3 integer tarif_satuan','readonly'=>true)); ?>
    </td>
    <td>
        <span class="btn btn-sm btn-danger" onClick="hapus('<?php echo $modtariftindakan->daftartindakan_id; ?>')"><i class="fa fa-minus"></i></span>
    </td>
    

</tr>


