<?php
if(count((array)$dataHasilPemeriksaanPAs) > 0){
    foreach($dataHasilPemeriksaanPAs AS $i => $pemeriksaan){
//        $trpemeriksaan = false;
//        if($i == 0){
//            echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$dataHasilPemeriksaanPAs[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
//        }else if(($i) < count((array)$dataHasilPemeriksaanPAs)){
//            if($dataHasilPemeriksaanPAs[$i]->pemeriksaanlab_id != $dataHasilPemeriksaanPAs[$i-1]->pemeriksaanlab_id){
//                echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$dataHasilPemeriksaanPAs[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
//            }
//        }
        
    $pemeriksaan->tglperiksapa = $format->formatDateTimeForUser($pemeriksaan->tglperiksapa);
?>   
    <tr>
        <td>
            <?php echo CHtml::textField('no_urut',0,array('class'=>'span1 integer','style'=>'width:24px;','readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']hasilpemeriksaanpa_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']tindakanpelayanan_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($pemeriksaan,'['.$i.']pemeriksaanlab_id',array('readonly'=>true)) ?>
        </td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']nosediaanpa',array('placeholder'=>'Hasil Pemeriksaan','class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']tglperiksapa',array('readonly'=>true,'class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo $pemeriksaan->pemeriksaanlab->pemeriksaanlab_nama; ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']makroskopis',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']mikroskopis',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']kesimpulanpa',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']saranpa',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo CHtml::activeTextField($pemeriksaan,'['.$i.']catatanpa',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
    </tr>
<?php        
    }
}
?>

