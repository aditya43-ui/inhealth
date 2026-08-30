<fieldset>
    <div class="checkboxlist-tile">
        <?php
        
        $jenispemeriksaansebelum = "";
        foreach($modPemeriksaanBedahs as $x=>$pemeriksaanBedah){ 
            $jenispemeriksaansetelah = (isset($modPemeriksaanBedahs[$x+1]) ? $modPemeriksaanBedahs[$x+1]->kegiatanoperasi_id : $modPemeriksaanBedahs[$x]->kegiatanoperasi_id);
        ?>
            <?php
            if($pemeriksaanBedah->kegiatanoperasi_id != $jenispemeriksaansebelum){
                echo "<div class='boxtindakan'><h6>".$modPemeriksaanBedahs[$x]->kegiatanoperasi_nama."</h6>"; 
            }
            echo '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']is_pilih', array('value'=>$pemeriksaanBedah->operasi_id,
              'onclick' => "pilihPemeriksaanIni(this),setTindakan($(this),$('#RJTarifoperasiruanganV_".$pemeriksaanBedah->operasi_id."_operasi_nama').val())",'disabled'=>$disabled));
            echo '<span>'.$pemeriksaanBedah->operasi_nama.'</span>';
            echo CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']kegiatanoperasi_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']operasi_nama',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']hargaoperasi',array('readonly'=>true,'class'=>'span1'));
            echo CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']jenistarif_id',array('readonly'=>true,'class'=>'span1'));
            echo "</label><br>";

            if($pemeriksaanBedah->kegiatanoperasi_id != $jenispemeriksaansetelah){
                echo "</div>"; 
            }
            $jenispemeriksaansebelum = $pemeriksaanBedah->kegiatanoperasi_id;
        }
        ?>
    </div>
</fieldset>

        
