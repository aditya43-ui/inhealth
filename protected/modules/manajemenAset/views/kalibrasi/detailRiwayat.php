 <?php if(!empty($modRiwayatKalibarasi)) {
            foreach($modRiwayatKalibarasi as $data) { 
        ?>   
<tr>
        <td><?php echo $data->nokalibrasi;  ?></td> 
        <td><?php echo $format->formatDateTimeForUser($data->tglkalibrasi); ?></td>
        <td><?php echo $format->formatDateTimeForUser($data->berlaku_sdtgl); ?></td>
        <td><?php echo isset($data->supplier_id) ? $data->supplier->supplier_nama : ' '; ?></td>
        <td>
            <?php  
                $load_det = MAInvkalibrasidetT::model()->findAll(" invkalibrasi_id = ".$data->invkalibrasi_id." ");
                
                if (!empty($load_det)){
                    echo "<ol>";
                    foreach($load_det as $det){
                        echo "<li>".$det->nama_pegawai."</li>";
                    }
                    echo "</ol>";
                }
            ?>
        </td>
        <td><?php echo $data->invkalibrasi_ket; ?></td>
        <td style="text-align: center"> <?php echo !empty($data->lampiran_berkas) ? CHtml::link($data->lampiran_berkas,$this->createUrl('Unduh',array('id'=>$data->invkalibrasi_id)),array('title'=>'Download document','rel'=>'tooltip'))."<br>" : ""; ?></td>

</tr>
  <?php
        }
 }
  ?>