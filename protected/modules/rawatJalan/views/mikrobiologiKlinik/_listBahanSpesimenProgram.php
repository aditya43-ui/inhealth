<?php
/**
 * mengenerate daftar spesimen mikrobiologi klinik
 * 
 * @author Refi Fadholi <refifadholi@.com>
 */


if (!empty($bahan_gen)) {
    foreach ($bahan_gen as $i =>$gen) {
        $ceklist = false;

        $bahan = $pemeriksaan_data[$gen['jenispemeriksaanlab_id']] ?? array();

        /*
        if(!empty($periksabahan)) {
            $cri = new CDbCriteria();
            $cri->compare(" LOWER(t.pemeriksaanlab_nama) ", strtolower($periksabahan),true);
            $cri->addCondition("jenispemeriksaanlab_id=". $gen['jenispemeriksaanlab_id']);
            $bahan = PemeriksaanlabM::model()->findAll($cri);
        } else {
            $bahan = PemeriksaanlabM::model()->findAll('jenispemeriksaanlab_id =' . $gen['jenispemeriksaanlab_id']);
        }
        */


        ?>
        <div class="col-sm-3">
            <div class="boxtindakan">

                    <?php
                    $cekperiksa = '';

                    if(!empty($bahan)) {
                        $cekperiksa .=  '<label style="margin-left: 10px; font-weight: bold;">' . CHtml::checkBox('jenis_' . $gen['jenispemeriksaanlab_id'] , false, array("class"=>"cekList", "value" => '','onClick' => 'inputBahanJenis(this)' ,"onkeyup"=>"return $(this).focusNextInputField(event);")) . '<span> Pilih Semua </span></label><br><hr>';
                    }

                    foreach($bahan as $bhn){
                        // $modKirim->samplelab_id = $bhn->samplelab_id;
                    
                            $cekperiksa .= '<label class="checkbox inline base_input_ceklis">' .
                                CHtml::hiddenField("KirimspesimenlabT[".$bhn->samplelab_id."][samplelab_id]",$bhn->samplelab_id, array('class' => 'samplelab_id')).
                                CHtml::hiddenField("KirimspesimenlabT   [".$bhn->pemeriksaanlab_id."][kode_unik]",$bhn->kode_unik, array('class'=>'periksa_kode_unik')).
                                CHtml::checkBox("KirimspesimenlabT[".$bhn->pemeriksaanlab_id."][cekList]", false, array("class"=>"cekList cekPemeriksaan", "value" => $bhn->pemeriksaanlab_id,'onClick' => 'inputBahan(this, "' . $bhn->pemeriksaanlab_id . '", "' .  $bhn->samplelab_id . '")' ,"onkeyup"=>"return $(this).focusNextInputField(event);"));
                            $cekperiksa .= "<span>" . $bhn->pemeriksaanlab_nama . "</span></label><br/>";
                        
                    }?>

                    <?php

                    if(count($bahan) > 0) {
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'tabel-riwayatanamnesa-' . $i,
                        'content' => array(
                            'content-detailanamnesa-' . $i => array(
                                'header' => '<h5 style="font-weight: bold; color: white;"><span>' .   $gen['jenispemeriksaanlab_nama'] .  '</span></h6>',
                                'isi' => $cekperiksa,
                                'active' => false,
                            ),
                        ),
                    ));
                }
                    ?>
            </div>
        </div>
        <?php
    }
}
?>
