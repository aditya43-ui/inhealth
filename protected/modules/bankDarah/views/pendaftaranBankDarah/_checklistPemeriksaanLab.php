<?php
/**
 * supply @modPemeriksaanLabs
 */
?>
<fieldset class="box">
    <div class="checkboxlist-tile">
        <?php
        
        $jenispemeriksaansebelum = "";
        foreach($modPemeriksaanlabs as $x=>$pemeriksaanLab){ 
            $jenispemeriksaansetelah = (isset($modPemeriksaanlabs[$x+1]) ? $modPemeriksaanlabs[$x+1]->jenispemeriksaanlab_id : $modPemeriksaanlabs[$x]->jenispemeriksaanlab_id);
			$modTarifTindakan = BDTariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$pemeriksaanLab->daftartindakan_id));
        ?>
            <?php
            if($pemeriksaanLab->jenispemeriksaanlab_id != $jenispemeriksaansebelum){
                echo "<div class='boxtindakan'><h6>".$modPemeriksaanlabs[$x]->jenispemeriksaanlab_nama."</h6>"; 
            }
            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']is_pilih', array('value'=>$pemeriksaanLab->pemeriksaanlab_id,
              'onclick' => "pilihPemeriksaanIni(this)"));
            echo '<span>'.$pemeriksaanLab->pemeriksaanlab_nama.'</span>';
            echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']jenispemeriksaanlab_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']pemeriksaanlab_nama',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']harga_tariftindakan',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']jenistarif_id',array('readonly'=>true,'class'=>'span1'));
			echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']persencyto_tind',array('readonly'=>true,'class'=>'span1','value'=>$modTarifTindakan->persencyto_tind));
            echo "</label><br>";

            if($pemeriksaanLab->jenispemeriksaanlab_id != $jenispemeriksaansetelah){
                echo "</div>"; 
            }
            $jenispemeriksaansebelum = $pemeriksaanLab->jenispemeriksaanlab_id;
        }
        ?>
    </div>
</fieldset>

        
