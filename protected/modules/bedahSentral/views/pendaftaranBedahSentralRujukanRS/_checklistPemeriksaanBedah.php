<fieldset>
    <div class="row row-fluid">
        <?php
        $jenispemeriksaansebelum = "";
        
        foreach($kegiatanoperasi as $i => $ko) {

            $pemeriksaan = '';
            $cnt = 0;
            foreach($modPemeriksaanBedahs as $x=>$pemeriksaanBedah){ 

                if($ko->kegiatanoperasi_id == $pemeriksaanBedah->kegiatanoperasi_id) {

                    $pemeriksaan .= '<label class="checkbox inline">'.CHtml::activeCheckBox($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']is_pilih',
                                    array('value'=>$pemeriksaanBedah->operasi_id, 'onclick' => "pilihPemeriksaanIni(this)",'disabled'=>$disabled));
                    $pemeriksaan .= '<span>'.$pemeriksaanBedah->operasi_nama.'</span>';
                    $pemeriksaan .= CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']kegiatanoperasi_id',array('readonly'=>true,'class'=>'span1'));
                    $pemeriksaan .= CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']operasi_nama',array('readonly'=>true,'class'=>'span1'));
                    $pemeriksaan .= CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']daftartindakan_id',array('readonly'=>true,'class'=>'span1'));
                    $pemeriksaan .= CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']hargaoperasi',array('readonly'=>true,'class'=>'span1'));
                    $pemeriksaan .= CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']jenistarif_id',array('readonly'=>true,'class'=>'span1'));
                    $pemeriksaan .= CHtml::activeHiddenField($pemeriksaanBedah,'['.$pemeriksaanBedah->operasi_id.']persencyto_tind',array('readonly'=>true,'class'=>'span1'));

                    $cnt++;

                }

                if($cnt == 200) {
                    break;
                }

            }

            if($cnt > 0) {

                echo '<div class="col-sm-3">';
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-detail_' . $i,
                    'content' => array(
                        'content-detail_' . $i => array(
                            'header' => $ko->kegiatanoperasi_nama,
                            'isi' => $pemeriksaan,
                            'active' => false,
                        ),
                    ),
                ));
                echo '</div>';

            }

        }

        ?>
    </div>
</fieldset>



        
