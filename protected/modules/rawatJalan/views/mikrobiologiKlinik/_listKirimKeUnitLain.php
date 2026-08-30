<style>

    .btn-blue {
        background-color: #A9D5F1;
        border-color: #A9D5F1;
        font-weight: bold;
    }

    .btn-blue:hover {
        /* color: grey; */
        background-color: #8FBBD7;
        border-color: #8FBBD7;
        font-weight: bold;
    }

    hr {
        border-color: #acacac;
    }

</style>
<?php $visible = isset($_GET['lihat']) ? 'hidden' : ''; ?>
<table id="tblListPemeriksaanLab" class="table table-bordered table-striped table-condensed" >
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Mikrobiologi Klinik</th>
            <th>No. Permintaan</th>
            <!--<th>No. Antrian</th>-->
            <th>Permintaan Pemeriksaan</th>
            <th hidden>Jumlah</th>
            <th>Hasil</th>
            <th>Status</th>
            <th>Dokter Perujuk</th>
            <th>Operator</th>
            <th <?= $visible ?>>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
<?php
// var_dump($modRiwayatKirimKeUnitLain);die;
foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
    $modPermintaan = RJPermintaanPenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
    $modPermintaanSatu = RJPermintaanPenunjangT::model()->with('daftartindakan','pemeriksaanlab')->findByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id), array('condition'=>'t.pemeriksaanlab_id is not null'));
    ?>
    <tr>
        <td><?php echo MyFormatter::formatDateTimeForUser($riwayat->tgl_kirimpasien); ?></td>
        <td><?php echo $riwayat->pasienkirimkeunitlain_id;?> <a href='' onclick="printPermintaan('<?php echo $riwayat->pasienkirimkeunitlain_id; ?>')"><i class="icon-print"></i></a> </td>
        <!--<td><?php // echo $riwayat->nourut;?></td>-->
        <td>
            <?php

                $seb = '';
                if(!empty($modPermintaan)) {

                    foreach($modPermintaan as $per) {
                        $skr = !empty($per->pemeriksaanlab_id) ? $per->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama . '<hr>' : "";
                        if($seb != $skr) {
                            echo $skr;
                        }
                        $seb = $skr;
                    }
                }

            ?>
        </td>
<!--        <td>
            <?php
//            $temp_datartind = '';
//            foreach($modPermintaan as $j => $permintaan){
//                $daftartindakan_id = $permintaan->pemeriksaanlab->daftartindakan_id;
//                if($temp_datartind != $daftartindakan_id) {
//                    $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$riwayat->kelaspelayanan_id,
//                                                                                'daftartindakan_id'=>$daftartindakan_id,
//                                                                                'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
//                    echo (!empty($modTarif->harga_tariftindakan))? number_format($modTarif->harga_tariftindakan).'<br/>':'Belum ada tarif <br/>';
//                }
//                $temp_datartind = $daftartindakan_id;
//            } ?>
        </td>-->
        <td hidden>
            <?php
            foreach($modPermintaan as $j => $permintaan){
                echo $permintaan->qtypermintaan.'<br/>';
            } ?>
        </td>

        <td align="center">
            <?php

                if(!empty($riwayat->pasienmasukpenunjang_id)) {
                    $pemeriksaankultur = PemeriksaankulturT::model()->findAll("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id);
                    $pemeriksaanpewarnaan = PemeriksaanpewarnaanT::model()->findAll("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id);
                    $pemeriksaanpcr = PemeriksaanpcrT::model()->findAll("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id);

                    if(!empty($pemeriksaankultur)) {

                        foreach($pemeriksaankultur as $pemr) {
                            if(isset($pemr->pemeriksaankultur_id)) {

                                $kel = KelompokpemeriksaanmikroT::model()->find("pemeriksaankultur_id = ". $pemr->pemeriksaankultur_id . " and is_kirimhasil = true");
                                if(!empty($kel)) {
                                    echo "<center><a href='' onclick=\"printKultur('". $pemr->pemeriksaankultur_id . "')\"><i class=\"icon-print\"></i></a></center><hr>";
                                }
                                // echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => '', 'onclick' => "printKultur(' . $pemr->pemeriksaankultur_id . ');return false")) . "<br>";
                            }
                        }
                    }

                    if(!empty($pemeriksaanpewarnaan)) {

                        foreach($pemeriksaanpewarnaan as $pemr) {
                            if(isset($pemr->pemeriksaanpewarnaan_id)) {

                                $kel = KelompokpemeriksaanmikroT::model()->find("pemeriksaanpewarnaan_id = ". $pemr->pemeriksaanpewarnaan_id . " and is_kirimhasil = true");
                                if(!empty($kel)) {
                                    echo "<center><a href='' onclick=\"printPewarnaan('". $pemr->pemeriksaanpewarnaan_id . "')\"><i class=\"icon-print\"></i></a></center><hr>";
                                }
                                // echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => '', 'onclick' => "printKultur(' . $pemr->pemeriksaankultur_id . ');return false")) . "<br>";
                            }
                        }
                    }

                    if(!empty($pemeriksaanpcr)) {

                        foreach($pemeriksaanpcr as $pemr) {
                            if(isset($pemr->pemeriksaanpcr_id)) {

                                $kel = KelompokpemeriksaanmikroT::model()->find("pemeriksaanpcr_id = ". $pemr->pemeriksaanpcr_id . " and is_kirimhasil = true");
                                if(!empty($kel)) {
                                    echo "<center><a href='' onclick=\"printPcr('". $pemr->pemeriksaanpcr_id . "')\"><i class=\"icon-print\"></i></a></center><hr>";
                                }
                                // echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => '', 'onclick' => "printKultur(' . $pemr->pemeriksaankultur_id . ');return false")) . "<br>";
                            }
                        }
                    }

                }
                

            ?>
        </td>
        <td><?php

                $mintaulang = PermintaankepenunjangT::model()->find("pasienkirimkeunitlain_id = " . $riwayat->pasienkirimkeunitlain_id . " and mintaulang_samplelab_id is null");

                if(empty($mintaulang)) {

                    $tampil = CHtml::Link("MINTA ULANG SAMPEL", Yii::app()->controller->createUrl("/mikrobiologiKlinik/rujukanPenunjang/mintaSampelUlangOrder", array("pasienkirimkeunitlain_id" => $permintaan->pasienkirimkeunitlain_id)), array(
                        "class" => "btn btn-info",
                        "id" => "selectPasien",
                        "rel" => "tooltip",
                        "title" => "Klik untuk minta sampel ulang",
                        "target" => "frameMintaUlang",
                        "onclick" => "$('#dialogMintaUlang').dialog('open')",
                    ));

                    if(!empty($riwayat->pasienmasukpenunjang_id)) {

                        $kelompok = KelompokpemeriksaanmikroT::model()->find("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id . " and is_kirimhasil is null");
   
                        if(!empty($kelompok)) {
                            echo "SELESAI";
                        } else {
                            $pemeriksaankultur = PemeriksaankulturT::model()->findAll("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id);
                            $pemeriksaanpewarnaan = PemeriksaanpewarnaanT::model()->findAll("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id);
                            $pemeriksaanpcr = PemeriksaanpcrT::model()->findAll("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id);

                            if(!empty($pemeriksaankultur) || !empty($pemeriksaanpewarnaan) || !empty($pemeriksaanpcr)) {
                                echo 'SELESAI';
                            } else {
                                echo "SUDAH DITERIMA";
                            }
                        }
                    }

                    echo $tampil;

                } else {

                    if(empty($riwayat->pasienmasukpenunjang_id)) {
                        echo "BELUM DITERIMA";
                    } else {
                        $kelompok = KelompokpemeriksaanmikroT::model()->find("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id . " and is_kirimhasil is null");
                        // if(!empty($kelompok)) {
                            // echo "SUDAH DITERIMA";
                        // } else {
                        //     echo "SELESAI";
                        // }
                        if(!empty($kelompok)) {
                            echo "SELESAI";
                        } else {

                            $pemeriksaankultur = PemeriksaankulturT::model()->findAll("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id);
                            $pemeriksaanpewarnaan = PemeriksaanpewarnaanT::model()->findAll("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id);
                            $pemeriksaanpcr = PemeriksaanpcrT::model()->findAll("pasienmasukpenunjang_id = " . $riwayat->pasienmasukpenunjang_id);

                            if(!empty($pemeriksaankultur) || !empty($pemeriksaanpewarnaan) || !empty($pemeriksaanpcr)) {
                                echo 'SELESAI';
                            } else {
                                echo "SUDAH DITERIMA";
                            }
                        }

                



                    }
                }

                
            ?></td>
        <td>
            <?php
            $dokterRujuk = PegawaiM::model()->findByPk($riwayat->pegawai_id);
            echo $dokterRujuk->namaLengkap;
            ?>
        </td>
        <td>
            <?php
            $createLogin = LoginpemakaiK::model()->findByPk($riwayat->create_loginpemakai_id);
            if (!empty($createLogin->pegawai_id)) {
                $pegLogin = PegawaiM::model()->findByPk($createLogin->pegawai_id);
                echo $pegLogin->namaLengkap;
            } else {
                echo $createLogin->nama_pemakai;
            }
            ?>
        </td>
        <td <?= $visible ?>>
            <?php
                $onclick = 'window.parent.myAlert("Tidak bisa dihapus karena hak akses tidak sesuai")';

                $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $riwayat->create_ruangan, $riwayat->create_loginpemakai_id);

                if($bisa_hapus) {
                    $onclick = 'batalKirim('.$riwayat->pasienkirimkeunitlain_id.','.$riwayat->pendaftaran_id.');return false;';
                }

                echo CHtml::link("<i class='icon-remove'></i>", '#', array('onclick'=>$onclick,'rel'=>'tooltip','title'=>'Klik untuk membatalkan kirim pasien', 'data-placement'=>'left')); 
            ?>
        </td>
    </tr>
    <?php
}
?>
        <tr id="trListKosong"><td colspan="9" ><?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
            array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'printRiwayat(\'PRINT\')')),
            array('label'=>'', 'items'=>array(
                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat(\'PDF\')')),
                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat(\'EXCEL\')')),
               
            )),       
        ),
        'htmlOptions'=>array('style'=>'float:right')
//        'htmlOptions'=>array('class'=>'btn')
    )); ?></td></tr>
    </tbody>
    
</table>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMintaUlang',
    'options' => array(
        'title' => 'Permintaan Ulang Sampel',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 400,
        'resizable' => false,
    ),
));
?>

<iframe name='frameMintaUlang' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<script>

function printKultur(id) {
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printKultur', array()); ?>&pemeriksaankultur_id='+id,
        'printwin', 'left=100,top=100,width=640,height=480');
}

function printPewarnaan(id) {
    console.log('print pewarnaan');
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printPewarnaan', array()); ?>&pemeriksaanpewarnaan_id='+id,
        'printwin', 'left=100,top=100,width=640,height=480');
}

function printPcr(id) {
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printPcr'); ?>&pemeriksaanpcr_id=' + id,
        'printwin', 'left=100,top=100,width=640,height=480');
}



</script>