<?php
/**
 * supply @$modPemeriksaanAnestesis
 */
?>
<fieldset class="box">
    <div class="checkboxlist-tile">
        <?php
        
        $jenispemeriksaansebelum = "";
        foreach($modPemeriksaanAnestesis as $x=>$pemeriksaanAnestesi){ 
            $jenispemeriksaansetelah = (isset($modPemeriksaanAnestesis[$x+1]) ? $modPemeriksaanAnestesis[$x+1]->jenisanastesi_id : $modPemeriksaanAnestesis[$x]->jenisanastesi_id);
        ?>
            <?php
            if($pemeriksaanAnestesi->jenisanastesi_id != $jenispemeriksaansebelum){
                echo "<div class='boxtindakan'><h6>".$modPemeriksaanAnestesis[$x]->jenisanastesi_nama."</h6>"; 
            }
            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanAnestesi,'['.$pemeriksaanAnestesi->anastesi_id.']is_pilih', array('value'=>$pemeriksaanAnestesi->anastesi_id,
              'onclick' => "pilihPemeriksaanIni(this)"));
            echo '<span>'.$pemeriksaanAnestesi->anastesi_nama.'</span>';
            echo CHtml::activeHiddenField($pemeriksaanAnestesi,'['.$pemeriksaanAnestesi->anastesi_id.']jenisanastesi_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanAnestesi,'['.$pemeriksaanAnestesi->anastesi_id.']anastesi_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanAnestesi,'['.$pemeriksaanAnestesi->anastesi_id.']anastesi_nama',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanAnestesi,'['.$pemeriksaanAnestesi->anastesi_id.']jenisanastesi_nama',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanAnestesi,'['.$pemeriksaanAnestesi->anastesi_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanAnestesi,'['.$pemeriksaanAnestesi->anastesi_id.']hargaanestesi',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanAnestesi,'['.$pemeriksaanAnestesi->anastesi_id.']jenistarif_id',array('readonly'=>true,'class'=>'span1'));
            echo "</label><br/>";

            if($pemeriksaanAnestesi->jenisanastesi_id != $jenispemeriksaansetelah){
                echo "</div>"; 
            }
            $jenispemeriksaansebelum = $pemeriksaanAnestesi->jenisanastesi_id;
        }
        ?>
    </div>
</fieldset>

        
