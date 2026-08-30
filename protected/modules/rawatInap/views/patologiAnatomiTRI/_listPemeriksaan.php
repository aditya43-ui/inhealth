<?php 

        if (!empty($tarif_gen)){
        foreach($tarif_gen as $i => $jns){
        $ceklist = false;
        $patologi = $jns['jenispemeriksaanlab_kelompok'];
        if($patologi==Params::PATOLOGI_ANATOMI){
        $cekperiksa = '';
                                                    ?>
<div class="col-sm-2">
    <div class="boxtindakan">

        <div class="panel-body">
            <?php   foreach ($jns['det'] as $j => $pr) {                                                                                                                            
                        $cekperiksa .= '<label class="checkbox inline">'.CHtml::checkBox("pemeriksaanLab[]", $ceklist, array('value'=>$pr['pemeriksaanlab_id'],
                        'onclick' => "inputperiksa(this,".$pr['ruangan_id'].");",'id'=>'pemeriksaanlabid','ruanganid'=>$pr['ruangan_id']));
                        $cekperiksa .= "<span>".$pr['pemeriksaanlab_nama']. " - " . $pr['pemeriksaanlab_kode']."</span></label><br/>";                                                                                                                            
                    } ?>

                <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'tabel-riwayatanamnesa-' . $i . '-' . $j,
                        'content' => array(
                            'content-detailanamnesa-' . $i . '-' . $j => array(
                                'header' => '<h6>' . strtoupper($jns['jenispemeriksaanlab_nama']) .  '</h6>',
                                'isi' => $cekperiksa,
                                'active' => false,
                            ),
                        ),
                    ));
                
                ?>
        </div>
    </div>
</div>
<?php
            }                                                                                
        }
    }
?>