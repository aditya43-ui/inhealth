<style>

    .judul-acc {

        margin-top: 10px;
        margin-bottom: -20px;
        font-weight: bold;
        color: white;

    }

    .judul-acc .glyphicon-chevron-down {
        margin-bottom: -50px;
    }

</style>


<?php
/**
 * supply @modPemeriksaanRads
 */
?>
<fieldset>
    <div class="checkboxlist-tile">
        <?php
        
        $jenispemeriksaansebelum = "";
        $cekperiksa = '';

        foreach($modPemeriksaanRads as $x=>$pemeriksaanRad){ 
            $jenispemeriksaansetelah = (isset($modPemeriksaanRads[$x+1]) ? $modPemeriksaanRads[$x+1]->jenispemeriksaanrad_id : $modPemeriksaanRads[$x]->jenispemeriksaanrad_id);
        ?>
            <?php
             $pemeriksaanrad_kode = '';
             if(!empty($pemeriksaanRad->pemeriksaanrad_kode)) {
                 $pemeriksaanrad_kode = $pemeriksaanRad->pemeriksaanrad_kode;
             }

             $jenis = JenispemeriksaanradM::model()->findByPk($pemeriksaanRad->jenispemeriksaanrad_id);

             $pemeriksaanRad->jenispemeriksaanrad_nama = $jenis->jenispemeriksaanrad_nama;
            
            $cekperiksa .= '<label class="checkbox inline">'. CHtml::activeCheckBox($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']is_pilih', array('value'=>$pemeriksaanRad->pemeriksaanrad_id,
              'onclick' => "pilihPemeriksaanIni(this)"));
            $cekperiksa .= '<span>'.$pemeriksaanRad->pemeriksaanrad_nama. ' - ' . $pemeriksaanrad_kode .'</span>';
            $cekperiksa .= CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']jenispemeriksaanrad_id',array('readonly'=>true,'class'=>'span1'));
            $cekperiksa .= CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']pemeriksaanrad_nama',array('readonly'=>true,'class'=>'span1'));
            $cekperiksa .= CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
            $cekperiksa .= CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']daftartindakan_nama',array('readonly'=>true,'class'=>'span1'));
            $cekperiksa .= CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']harga_tariftindakan',array('readonly'=>true,'class'=>'span1'));
            $cekperiksa .= CHtml::activeHiddenField($pemeriksaanRad,'['.$pemeriksaanRad->pemeriksaanrad_id.']jenistarif_id',array('readonly'=>true,'class'=>'span1'));
            $cekperiksa .= "</label><br>";

            if($pemeriksaanRad->jenispemeriksaanrad_id != $jenispemeriksaansebelum){
                // echo '<div class="panel panel-default boxtindakan">';
                // echo '<div class="panel-heading"><div class="panel-title">';
                // echo "<h6><b>".$modPemeriksaanRads[$x]->jenispemeriksaanrad_nama."</b></h6>"; 
                // echo '</div></div>';
                // echo '<div class="panel-body">';
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'tabel-riwayatanamnesa-' . $x,
                    'content' => array(
                        'content-detailanamnesa-' . $x => array(
                            'header' => '<h6 class="judul-acc">' . $modPemeriksaanRads[$x]->jenispemeriksaanrad_nama .  '</h6>',
                            'isi' => $cekperiksa,
                            'active' => false,
                        ),
                    ),
                ));
                $cekperiksa = '';
            }

            if($pemeriksaanRad->jenispemeriksaanrad_id != $jenispemeriksaansetelah){
                // echo "</div>";
                // echo "</div>"; 
            }
            $jenispemeriksaansebelum = $pemeriksaanRad->jenispemeriksaanrad_id;
        }
        ?>
    </div>
</fieldset>

        
