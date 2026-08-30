<?php
/**
 * supply @modPemeriksaanRads
 */
?>
<fieldset class="box">
    <div class="checkboxlist-tile">
        <?php
        
        $jenispemeriksaansebelum = "";
        foreach($modPemeriksaanRads as $x=>$pemeriksaanRad){ 
            $jenispemeriksaansetelah = (isset($modPemeriksaanRads[$x+1]) ? $modPemeriksaanRads[$x+1]->jenispemeriksaanrad_id : $modPemeriksaanRads[$x]->jenispemeriksaanrad_id);
        ?>
            <?php
            if($pemeriksaanRad->jenispemeriksaanrad_id != $jenispemeriksaansebelum){
                echo "<div class='boxtindakan'><h6>".$modPemeriksaanRads[$x]->jenispemeriksaanrad_nama."</h6>"; 
            }
            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']is_pilih', array('value'=>$pemeriksaanRad->pemeriksaanrad_id,
              'onclick' => "pilihPemeriksaanIni(this)"));
            echo '<span>'.$pemeriksaanRad->pemeriksaanrad_nama.'</span>';
            echo CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']jenispemeriksaanrad_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']pemeriksaanrad_nama',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']harga_tariftindakan',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']jenistarif_id',array('readonly'=>true,'class'=>'span1'));
            echo "</label><br>";

            if($pemeriksaanRad->jenispemeriksaanrad_id != $jenispemeriksaansetelah){
                echo "</div>"; 
            }
            $jenispemeriksaansebelum = $pemeriksaanRad->jenispemeriksaanrad_id;
        }
        ?>
    </div>
</fieldset>

        
