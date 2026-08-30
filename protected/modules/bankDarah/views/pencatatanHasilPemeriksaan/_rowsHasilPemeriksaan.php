<?php
if(count((array)$modDetailHasilPemeriksaans) > 0){
    foreach($modDetailHasilPemeriksaans AS $i => $modDetail){
        $trpemeriksaan = false;
        if($i == 0){
            echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
        }else if(($i) < count((array)$modDetailHasilPemeriksaans)){
            if($modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id != $modDetailHasilPemeriksaans[$i-1]->pemeriksaanlab_id){
                echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
            }
        }
?>   
    <tr>
        <td>
            <?php echo CHtml::textField('no_urut',0,array('class'=>'span1 integer','style'=>'width:24px;','readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']detailhasilpemeriksaanlab_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']hasilpemeriksaanlab_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']tindakanpelayanan_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']pemeriksaanlab_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']pemeriksaanlabdet_id',array('readonly'=>true)) ?>
        </td>
        <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->kelompokdet ?></td>
        <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->namapemeriksaandet ?></td>
        <td><?php echo CHtml::activeTextField($modDetail,'['.$i.']hasilpemeriksaan',array('placeholder'=>'Hasil Pemeriksaan','class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo $modDetail->NilaiRujukan ?></td>
        <td><?php echo $modDetail->HasilPemeriksaanSatuan ?></td>
        <td><?php echo $modDetail->HasilPemeriksaanMetode ?></td>
        <td><?php echo !empty($modDetail->hasil_laboratorium) ? $modDetail->hasil_laboratorium : CHtml::activeTextField($modDetail,'['.$i.']hasil_laboratorium',array('placeholder'=>'Hasil Bank Darah','class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event)"))?></td>
    </tr>
<?php        
    }
}
?>

