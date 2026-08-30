<?php
/**
 * supply @modPemeriksaanLabs
 */
?>

    <fieldset>
        <div class="checkboxlist-tile">
            <?php

            $jenispemeriksaansebelum = "";
            foreach($modPemeriksaanlabs as $x=>$pemeriksaanLab){ 
                $jenispemeriksaansetelah = (isset($modPemeriksaanlabs[$x+1]) ? $modPemeriksaanlabs[$x+1]->jenispemeriksaanlab_id : $modPemeriksaanlabs[$x]->jenispemeriksaanlab_id);
            ?>
                <?php
                if($pemeriksaanLab->jenispemeriksaanlab_id != $jenispemeriksaansebelum){
                    echo '<div class="panel panel-default boxtindakan">';
                    echo '<div class="panel-heading"><div class="panel-title">';
                    echo "<h6>".$modPemeriksaanlabs[$x]->jenispemeriksaanlab_nama."</h6>";
                    echo '</div></div>';
                    echo '<div class="panel-body">';
                }
                echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']is_pilih', array('value'=>$pemeriksaanLab->pemeriksaanlab_id,
                  'onclick' => "pilihPemeriksaanIni(this)"));
                echo '<span>'.$pemeriksaanLab->pemeriksaanlab_nama.'</span>';
                echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']jenispemeriksaanlab_id',array('readonly'=>true,'class'=>'span1'));
                echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']pemeriksaanlab_nama',array('readonly'=>true,'class'=>'span1'));
                echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
                echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']harga_tariftindakan',array('readonly'=>true,'class'=>'span1'));
                echo CHtml::activeHiddenField($pemeriksaanLab,'['.$pemeriksaanLab->pemeriksaanlab_id.']jenistarif_id',array('readonly'=>true,'class'=>'span1'));
                echo "</label><br/>";

                if($pemeriksaanLab->jenispemeriksaanlab_id != $jenispemeriksaansetelah) {
                    echo "</div>";
                    echo "</div>"; 
                }
                $jenispemeriksaansebelum = $pemeriksaanLab->jenispemeriksaanlab_id;
            }
            ?>
        </div>
    </fieldset>

        
