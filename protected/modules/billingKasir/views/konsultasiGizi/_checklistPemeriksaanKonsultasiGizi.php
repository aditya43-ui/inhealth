<?php
/**
 * supply @modPemeriksaanKonsultasiGizis
 */
?>
<fieldset class="box">
    <div class="checkboxlist-tile">
        <?php
        
        $jenispemeriksaansebelum = "";
        foreach($modPemeriksaanKonsultasiGizis as $x=>$pemeriksaanKonsultasiGizi){ 
            $jenispemeriksaansetelah = (isset($modPemeriksaanKonsultasiGizis[$x+1]) ? $modPemeriksaanKonsultasiGizis[$x+1]->kategoritindakan_id : $modPemeriksaanKonsultasiGizis[$x]->kategoritindakan_id);
        ?>
            <?php
            if($pemeriksaanKonsultasiGizi->kategoritindakan_id != $jenispemeriksaansebelum){
                echo "<div class='boxtindakan'><h6>".$modPemeriksaanKonsultasiGizis[$x]->kategoritindakan_nama."</h6>"; 
            }
            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanKonsultasiGizi,'['.$pemeriksaanKonsultasiGizi->daftartindakan_id.']is_pilih', array('value'=>$pemeriksaanKonsultasiGizi->daftartindakan_id,
              'onclick' => "pilihPemeriksaanIni(this)"));
            echo '<span>'.$pemeriksaanKonsultasiGizi->daftartindakan_nama.'</span>';
            echo CHtml::activeHiddenField($pemeriksaanKonsultasiGizi,'['.$pemeriksaanKonsultasiGizi->daftartindakan_id.']kategoritindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanKonsultasiGizi,'['.$pemeriksaanKonsultasiGizi->daftartindakan_id.']daftartindakan_nama',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanKonsultasiGizi,'['.$pemeriksaanKonsultasiGizi->daftartindakan_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanKonsultasiGizi,'['.$pemeriksaanKonsultasiGizi->daftartindakan_id.']harga_tariftindakan',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanKonsultasiGizi,'['.$pemeriksaanKonsultasiGizi->daftartindakan_id.']jenistarif_id',array('readonly'=>true,'class'=>'span1'));
            echo "</label><br>";

            if($pemeriksaanKonsultasiGizi->kategoritindakan_id != $jenispemeriksaansetelah){
                echo "</div>"; 
            }
            $jenispemeriksaansebelum = $pemeriksaanKonsultasiGizi->kategoritindakan_id;
        }
        ?>
    </div>
</fieldset>

        
