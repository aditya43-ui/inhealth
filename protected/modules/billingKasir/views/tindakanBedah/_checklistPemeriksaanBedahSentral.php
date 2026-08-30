<?php
/**
 * supply @modPemeriksaanBedahSentrals
 */
?>
<fieldset class="box">
    <div class="checkboxlist-tile">
        <?php
        
        $jenispemeriksaansebelum = "";
        foreach($modPemeriksaanBedahSentrals as $x=>$pemeriksaanBedahSentral){ 
            $jenispemeriksaansetelah = (isset($modPemeriksaanBedahSentrals[$x+1]) ? $modPemeriksaanBedahSentrals[$x+1]->kegiatanoperasi_id : $modPemeriksaanBedahSentrals[$x]->kegiatanoperasi_id);
        ?>
            <?php
            if($pemeriksaanBedahSentral->kegiatanoperasi_id != $jenispemeriksaansebelum){
                echo "<div class='boxtindakan'><h6>".$modPemeriksaanBedahSentrals[$x]->kegiatanoperasi_nama."</h6>"; 
            }
            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanBedahSentral,'['.$pemeriksaanBedahSentral->operasi_id.']is_pilih', array('value'=>$pemeriksaanBedahSentral->operasi_id,
              'onclick' => "pilihPemeriksaanIni(this)"));
            echo '<span>'.$pemeriksaanBedahSentral->operasi_nama.'</span>';
            echo CHtml::activeHiddenField($pemeriksaanBedahSentral,'['.$pemeriksaanBedahSentral->operasi_id.']kegiatanoperasi_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanBedahSentral,'['.$pemeriksaanBedahSentral->operasi_id.']operasi_nama',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanBedahSentral,'['.$pemeriksaanBedahSentral->operasi_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanBedahSentral,'['.$pemeriksaanBedahSentral->operasi_id.']harga_tariftindakan',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanBedahSentral,'['.$pemeriksaanBedahSentral->operasi_id.']jenistarif_id',array('readonly'=>true,'class'=>'span1'));
            echo "</label><br>";

            if($pemeriksaanBedahSentral->kegiatanoperasi_id != $jenispemeriksaansetelah){
                echo "</div>"; 
            }
            $jenispemeriksaansebelum = $pemeriksaanBedahSentral->kegiatanoperasi_id;
        }
        ?>
    </div>
</fieldset>

        
