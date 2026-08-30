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
            <?php //echo $modDetail->pemeriksaandetail->pemeriksaanlabdet_nourut.'-'.$modDetail->pemeriksaanlab->pemeriksaanlab_urutan;?>
            <?php echo CHtml::textField('no_urut',0,array('class'=>'span1 integer','style'=>'width:24px;')) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']detailhasilpemeriksaanlab_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']hasilpemeriksaanlab_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']tindakanpelayanan_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']pemeriksaanlab_id',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']pemeriksaanlabdet_id',array('readonly'=>true)) ?>
        </td>
        <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->kelompokdet ?></td>
        <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->namapemeriksaandet ?></td>
        <td><?php echo CHtml::activeTextArea($modDetail,'['.$i.']hasilpemeriksaan',array('placeholder'=>'Hasil Pemeriksaan','class'=>'autogrow','onkeyup'=>"return $(this).focusNextInputField(event)")) ?></td>
        <td><?php echo $modDetail->NilaiRujukan ?></td>
        <td><?php echo $modDetail->HasilPemeriksaanSatuan ?></td>
        <td><?php echo $modDetail->HasilPemeriksaanMetode ?></td>
        <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->nilairujukan_keterangan ?></td>
    </tr>
<?php        
    }
}
?>

