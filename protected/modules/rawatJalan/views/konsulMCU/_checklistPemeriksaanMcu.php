<?php
/**
 * supply $modPemeriksaanmcus
 */
?>
<fieldset class="box">
    <div class="checkboxlist-tile">
        <?php
        
        $tipepaketsebelumnya = "";
		$totaltarif = 0;
        foreach($modPemeriksaanmcus as $x=>$pemeriksaanMCU){ 
            $tipepaketsetelahnya = (isset($modPemeriksaanmcus[$x+1]) ? $modPemeriksaanmcus[$x+1]->tipepaket_id : $modPemeriksaanmcus[$x]->tipepaket_id);
			
        ?>
            <?php
            if($pemeriksaanMCU->tipepaket_id != $tipepaketsebelumnya){
				$totaltarif = $totaltarif + $pemeriksaanMCU->tarifpaketpel;
                echo "<div class='boxtindakan'><h6><label class='checkbox inline'>".CHtml::CheckBox('pilihSemua','', array('value'=>$modPemeriksaanmcus[$x]->tipepaket_id,
              //'onclick' => "pilihPemeriksaanSemua(this)")).' '.$modPemeriksaanmcus[$x]->tipepaket->tipepaket_nama.' - '.  MyFormatter::formatNumberForPrint($totaltarif)."</h6>"; 
                    'onclick' => "pilihPemeriksaanSemua(this)")).' '.$modPemeriksaanmcus[$x]->tipepaket->tipepaket_nama."</h6>"; 
            }
            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanMCU,'['.$pemeriksaanMCU->paketpelayanan_id.']is_pilih', array('value'=>$pemeriksaanMCU->paketpelayanan_id,
              'onclick' => "pilihPemeriksaanIni(this)"));
            //echo '<span>'.$pemeriksaanMCU->namatindakan.' - '.MyFormatter::formatNumberForPrint($pemeriksaanMCU->tarifpaketpel).'</span>';
            echo '<span>'.$pemeriksaanMCU->namatindakan.'</span>';
            echo CHtml::activeHiddenField($pemeriksaanMCU,'['.$pemeriksaanMCU->paketpelayanan_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanMCU,'['.$pemeriksaanMCU->paketpelayanan_id.']namatindakan',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanMCU,'['.$pemeriksaanMCU->paketpelayanan_id.']tipepaket_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanMCU,'['.$pemeriksaanMCU->paketpelayanan_id.']ruangan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanMCU,'['.$pemeriksaanMCU->paketpelayanan_id.']tarifpaketpel',array('readonly'=>true,'class'=>'span1'));
            echo "</label><br>";

            if($pemeriksaanMCU->tipepaket_id != $tipepaketsetelahnya){
                echo "</div>"; 
            }
            $tipepaketsebelumnya = $pemeriksaanMCU->tipepaket_id;
        }
        ?>
    </div>
</fieldset>

        
