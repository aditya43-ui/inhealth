
<?php //  ?>
<!--
LNG-990
<tr>
    <td>
        <span name="[ii][jenispemeriksaan_nama]"><?php // echo $modDetailHasilPemeriksaan->jenispemeriksaanlab_nama; ?></span> / 
		<span name="[ii][namatindakan]"><?php // echo (!empty($modDetailHasilPemeriksaan->pemeriksaanlab_nama) ? $modDetailHasilPemeriksaan->pemeriksaanlab_nama : "-") ?></span>
		<?php // echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php // echo CHtml::activeHiddenField($modDetailHasilPemeriksaan,'[ii]detailhasilpemeriksaanlab_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php // echo CHtml::activeHiddenField($modDetailHasilPemeriksaan,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php // echo CHtml::activeHiddenField($modDetailHasilPemeriksaan,'[ii]pemeriksaanlabdet_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php // echo CHtml::activeHiddenField($modDetailHasilPemeriksaan,'[ii]pemeriksaanlab_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php // echo CHtml::activeHiddenField($modDetailHasilPemeriksaan,'[ii]hasilpemeriksaanlab_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
		<?php // echo CHtml::activeTextField($modDetailHasilPemeriksaan, '[ii]hasilpemeriksaan',array('readonly'=>$readonly,'class'=>'span3')); ?>
    </td>
	<td>
        <?php // echo $modDetailHasilPemeriksaan->nilairujukan; ?>
    </td>
	<td>
        <?php // echo $modDetailHasilPemeriksaan->hasilpemeriksaan_satuan; ?>
    </td>
	<td>
        <?php // echo $modDetailHasilPemeriksaan->hasilpemeriksaan_metode; ?>
    </td>
	<td >
		<?php // echo CHtml::activeTextField($modDetailHasilPemeriksaan, '[ii]hasil_laboratorium',array('readonly'=>$readonly,'class'=>'span3', 'maxlength' => 20)); ?>
    </td>
</tr>-->
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
            <?php echo CHtml::textField('no_urut',0,array('class'=>'span1 integer','style'=>'width:24px;')) ?>
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
        <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->nilairujukan_keterangan ?></td>
    </tr>
<?php        
    }
}
?>

