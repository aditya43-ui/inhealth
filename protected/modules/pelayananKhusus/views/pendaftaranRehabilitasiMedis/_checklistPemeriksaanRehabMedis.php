<?php
/**
 * supply @$modPemeriksaanRehabMediss
 */
?>
<fieldset class="box">
    <div class="checkboxlist-tile">
        <?php
        
        $jenistindakansebelumnya = "";
        foreach($modPemeriksaanRehabMediss as $x=>$pemeriksaanRehab){ 
            $jenistindakansetelah = (isset($modPemeriksaanRehabMediss[$x+1]) ? $modPemeriksaanRehabMediss[$x+1]->jenistindakanrm_id : $modPemeriksaanRehabMediss[$x]->jenistindakanrm_id);
        ?>
            <?php
            if($pemeriksaanRehab->jenistindakanrm_id != $jenistindakansebelumnya){
                echo "<div class='boxtindakan'><h6>".$modPemeriksaanRehabMediss[$x]->jenistindakanrm_nama."</h6>"; 
            }
            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanRehab,'['.$pemeriksaanRehab->tindakanrm_id.']is_pilih', array('value'=>$pemeriksaanRehab->tindakanrm_id,
              'onclick' => "pilihPemeriksaanIni(this)"));
            echo '<span>'.$pemeriksaanRehab->tindakanrm_nama.'</span>';
            echo CHtml::activeHiddenField($pemeriksaanRehab,'['.$pemeriksaanRehab->tindakanrm_id.']jenistindakanrm_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanRehab,'['.$pemeriksaanRehab->tindakanrm_id.']tindakanrm_nama',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanRehab,'['.$pemeriksaanRehab->tindakanrm_id.']tindakanrm_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanRehab,'['.$pemeriksaanRehab->tindakanrm_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanRehab,'['.$pemeriksaanRehab->tindakanrm_id.']harga_tariftindakan',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanRehab,'['.$pemeriksaanRehab->tindakanrm_id.']jenistarif_id',array('readonly'=>true,'class'=>'span1'));
            echo "</label><br/>";

            if($pemeriksaanRehab->jenistindakanrm_id != $jenistindakansetelah){
                echo "</div>"; 
            }
            $jenistindakansebelumnya = $pemeriksaanRehab->jenistindakanrm_id;
        }
        ?>
    </div>
</fieldset>

        
