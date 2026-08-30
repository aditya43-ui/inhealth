<?php
if(count((array)$modDetailHasilPemeriksaans) > 0){
    foreach($modDetailHasilPemeriksaans AS $i => $modDetail){
        $modDetail->nilairujukan_min = 0;
        $modDetail->nilairujukan_max = 0;
        if(!empty($modDetail->pemeriksaanlabdet_id)){
            $pemeriksaanlabdet = PemeriksaanlabdetM::model()->findByPk($modDetail->pemeriksaanlabdet_id);
            if(!empty($pemeriksaanlabdet)){
                $nilairujukan = NilairujukanM::model()->findByPk($pemeriksaanlabdet->nilairujukan_id);
                if(!empty($nilairujukan)){
                    $modDetail->nilairujukan_min = $nilairujukan->nilairujukan_min;
                    $modDetail->nilairujukan_max = $nilairujukan->nilairujukan_max;
                }
            }
        }
        $trpemeriksaan = false;
        if($i == 0){
            echo "<tr><td colspan='6' style='font-weight:bold; text-align:left;font-size:15px;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
        }else if(($i) < count((array)$modDetailHasilPemeriksaans)){
            if($modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id != $modDetailHasilPemeriksaans[$i-1]->pemeriksaanlab_id){
                echo "<tr><td colspan='6' style='font-weight:bold; text-align:left;font-size:15px;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
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
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']setHasilPemeriksa',array('readonly'=>true)) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']nilairujukan_min',array('readonly'=>true,'class'=>'nilairujukan_min')) ?>
            <?php echo CHtml::activeHiddenField($modDetail,'['.$i.']nilairujukan_max',array('readonly'=>true,'class'=>'nilairujukan_max')) ?>

        </td>
        <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->kelompokdet ?></td>
        <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->namapemeriksaandet ?></td>
        <!--<td><?php //echo CHtml::activeTextArea($modDetail,'['.$i.']hasilpemeriksaan',array('placeholder'=>'Hasil Pemeriksaan','class'=>'autogrow sethasil'.$i,'onblur'=>'setHasilPemeriksaan('.$i.',"'.$modDetail->NilaiRujukan.'")')) ?></td>-->
        <td><?php echo CHtml::activeTextArea($modDetail,'['.$i.']hasilpemeriksaan',array('placeholder'=>'Hasil Pemeriksaan','class'=>'autogrow','onkeyup'=>"setHasilPemeriksaan(this);")) ?></td>
        <td><?php echo $modDetail->NilaiRujukan ?></td>
        <td><?php echo $modDetail->HasilPemeriksaanSatuan ?></td>
        <td><?php echo $modDetail->HasilPemeriksaanMetode ?></td>
        <td><div style="text-align:center;" class="setHasilPeriksa<?php //echo $i ?>"></div><?php echo $modDetail->pemeriksaandetail->nilairujukan->nilairujukan_keterangan ?></td>
        <!--<td><div class="setHasilPeriksa<?php //echo $i ?>"></div></td>-->
        <!--<td><?php //echo CHtml::activeDropDownList($modDetail,'['.$i.']setHasilPemeriksa', LookupM::getItemsUrutan('statushasilpemeriksaanlab'),array('readonly'=>true,'empty'=>'-- Pilih --','disabled'=>false,'class'=>'statushasilpemeriksaan','onChange'=>'setHasilPemeriksaanDropdown();')) ?></td>-->
        <td><?php echo CHtml::activeDropDownList($modDetail,'['.$i.']statushasilpemeriksaan', LookupM::getItemsUrutan('statushasilpemeriksaanlab'),array('readonly'=>true,'empty'=>'-- Pilih --','disabled'=>false,'class'=>'statushasilpemeriksaan','onChange'=>'setHasilPemeriksaanDropdown();')) ?></td>

    </tr>
<?php        
    }
}
?>

