<?php
/**
 * supply $modPemeriksaan
 */
?>
<fieldset class="box">
    <div class="checkboxlist-tile-diluar-paket">
        <?php
        
		$tindakansebelumnya = '';
		$totaltarif = 0;
        foreach($modPemeriksaan as $x=>$pemeriksaan){ 			
			$tindakansetelahnya = (isset($modPemeriksaan[$x+1]) ? $modPemeriksaan[$x+1]->ruangan_id : $modPemeriksaan[$x]->ruangan_id);
        ?>
		<?php
			if($pemeriksaan->ruangan_id != $tindakansebelumnya){
				$totaltarif = $totaltarif + $pemeriksaan->harga_tariftindakan;
                echo "<div class='boxtindakan' style='width:300px;'><h6><label class='checkbox inline'>".$modPemeriksaan[$x]->ruangan_nama."</h6>"; 
            }
            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']is_pilih', array('value'=>$pemeriksaan->daftartindakan_id,
              'onclick' => "pilihPemeriksaanDiluarPaket(this)"));
            //echo '<span>'.$pemeriksaan->daftartindakan_nama.' - '.MyFormatter::formatNumberForUser($pemeriksaan->harga_tariftindakan).'</span>';
            echo '<span>'.$pemeriksaan->daftartindakan_nama.'</span>';
            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']daftartindakan_nama',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']tipepaket_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']harga_tariftindakan',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']ruangan_id',array('readonly'=>true,'class'=>'span1'));
            echo "</label><br>";
			
			if($pemeriksaan->ruangan_id != $tindakansetelahnya){
                echo "</div>"; 
            }
            $tindakansebelumnya = $pemeriksaan->ruangan_id;
        }
        ?>
    </div>
</fieldset>

        
