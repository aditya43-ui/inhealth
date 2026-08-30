<?php
/**
 * supply $modPemeriksaan
 */
?>
<!--<fieldset class="box">-->
    <div class="checkboxlist-tile-diluar-paket">
        <?php

		$tindakansebelumnya = '';
        $tindakansetelahnya = null;
		$totaltarif = 0;
        foreach($modPemeriksaan as $x=>$pemeriksaan){
            if (!empty($modPemeriksaan[$x+1]->ruangan_id)) {
                $tindakansetelahnya = (isset($modPemeriksaan[$x+1]) ? $modPemeriksaan[$x+1]->ruangan_id : $modPemeriksaan[$x]->ruangan_id);
            }

        ?>
		<?php
			if(!empty($pemeriksaan->ruangan_id) && $pemeriksaan->ruangan_id != $tindakansebelumnya){
				$totaltarif = $totaltarif + $pemeriksaan->harga_tariftindakan;
                echo "<div class='panel panel-default' style='width:300px;'>"
                . "<div class='panel-heading'>"
                        . "<div class='panel-title'>".$modPemeriksaan[$x]->ruangan_nama."</div>"
                . "</div>"
                . "<div class='panel-body'>";
            }
            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']is_pilih', array('value'=>$pemeriksaan->daftartindakan_id,
              'onclick' => "pilihPemeriksaanDiluarPaket(this)"));
            echo '<span>'.$pemeriksaan->daftartindakan_nama.' - '.MyFormatter::formatNumberForPrint($pemeriksaan->harga_tariftindakan,2).'</span>';
            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']daftartindakan_nama',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']tipepaket_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']harga_tariftindakan',array('readonly'=>true,'class'=>'span1'));

            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']ruangan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaan,'['.$pemeriksaan->daftartindakan_id.']ruangan_nama',array('readonly'=>true,'value'=>$pemeriksaan->ruangan_nama, 'class'=>'span1'));

            echo "</label>";

			if(!empty($pemeriksaan->ruangan_id) && $pemeriksaan->ruangan_id != $tindakansetelahnya){
                echo "</div></div>";
            }
            $tindakansebelumnya = $pemeriksaan->ruangan_id;
        }
        ?>
    </div>
<!--</fieldset>-->
