<?php

$row = empty($row) ? "ii" : $row;

$modDekontaminasi = DekontaminasiT::model()->findByPk($modPembersihan->dekontaminasi_id);
$dekon = DekontaminasidetailT::model()->findAllByAttributes(array(
    'dekontaminasi_id'=>$modPembersihan->dekontaminasi_id,
));

// var_dump($dekon->attributes); die;
?>

<tr>
    <?php /*
    <td>
	<?php echo CHtml::activeCheckBox($modPembersihan,'['.$row.']checklist', array('class'=>'checklist','onclick'=>'setNol(this);')); ?>
    </td>
     * 
     */ ?>
    
    <td>
        <span><?php echo (!empty($modPembersihan->tgl_pembersihan) ? MyFormatter::formatDateTimeForUser($modPembersihan['tgl_pembersihan']) : "") ?></span>
    </td>
    
    <td>
       <?php echo $modPembersihan->no_pembersihan; ?>
    </td>
        
    <td>
        <?php 
        if (count((array)$dekon) == 0) {
            echo "-";
            $terima = new PenerimaansterilisasidetT;
        } else {
            $terima = PenerimaansterilisasidetT::model()->findByPk($dekon[0]->penerimaansterilisasidet_id);
            $terima_base = PenerimaansterilisasiT::model()->findByPk($terima->penerimaansterilisasi_id);
            $pengajuan = PengajuansterlilisasiT::model()->findByPk($terima_base->pengajuansterlilisasi_id);
            
            if (!empty($pengajuan)) {
                $r = RuanganM::model()->findByPk($pengajuan->ruangan_id);
                echo $r->ruangan_nama;
            } else {
                echo "-";
            }
        }
        ?>
        
    </td>
    
    <td>
        <?php 
        if (count((array)$dekon) == 0) {
            echo "-";
        } else {
            echo "<ul>";
                                                    
            foreach ($dekon as $item) {
                $det = PenerimaansterilisasidetT::model()->findByPk($item->penerimaansterilisasidet_id);

                if (empty($det)) continue;

                $peralatan = PeralatansterilisasiM::model()->findByPk($det->peralatansterilisasi_id);
                
                echo "<li>" . $peralatan->peralatansterilisasi_nama . " (x" . $item->dekontaminasidetail_jml . ")</li>";
            }

            echo "</ul>";
        }
        ?>
        
    </td>
    
    
    <td>
        <?php 
            echo $terima->keadaanperalatan;
        ?>
    </td>
    
    <td>
    
        <?php 
        if (count((array)$dekon) == 0) {
            echo "-";
        } else {
            echo $dekon[0]->dekontaminasidetail_ket;
        }
        ?>
                                                    
    </td>
    <td>
        <span><?php echo (!empty($modPembersihan->statuspembersihan) ? $modPembersihan->statuspembersihan : ' ') ?></span>
    </td>
	
</tr>