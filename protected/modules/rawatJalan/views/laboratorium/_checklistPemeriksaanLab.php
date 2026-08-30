<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>

<div class="white tab-pane" id="tab1-klinik">
                            <!--<legend class="rim">PATOLOGI KLINIK</legend>-->

                            <table class="cek-klinik">
                                <tr>
                                    <td class="td-klinik">
                                        <div id="formPeriksaLabShow" class="">

                                        </div>
                                        <div id="formPeriksaLab" class="show" style="margin-left: -30px;">
                                            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                            <?php
                                            foreach ($modJenisPeriksaLab as $i => $jenisPeriksa) {
                                                $ceklist = false;
                                                $patologi = $jenisPeriksa->jenispemeriksaanlab_kelompok;
                                                if ($patologi == Params::PATOLOGI_KLINIK) {
                                                    ?>
                                                    <div class="col-sm-4">
                                                        <div class="boxtindakan" style="width: 180px; margin-bottom: 17px;">
                                                            
                                                                <div class="panel-body">
                                                                    <?php

                                                                    parse_str($_POST['data'], $post);

                                                                    $pasienkirimkeunitlain_id = isset($_GET['pasienkirimkeunitlain_id']) ? ' = ' . $_GET['pasienkirimkeunitlain_id'] : ' is null ';

                                                                    $critpl = new CDbCriteria;
                                                                    $critpl->select = 't.pemeriksaanlab_id, t.jenispemeriksaanlab_id';
                                                                    $critpl->join = " JOIN permintaankepenunjang_t p on p.pemeriksaanlab_id = t.pemeriksaanlab_id
                                                                                      JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                                                                                      JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                                                                                      JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id";
                                                                    
                                                                    if(!empty($post['RJPendaftaranT']['kelaspelayanan_id'])) {
                                                                      $critpl->addCondition('k.kelaspelayanan_id = ' . $post['RJPendaftaranT']['kelaspelayanan_id']);
                                                                    }
                                                                    
                                                                    $critpl->addCondition('p.pasienkirimkeunitlain_id' . $pasienkirimkeunitlain_id);

                                                                    $modPl = PemeriksaanlabM::model()->findAll($critpl);

                                                                    // var_dump(count($modPl)); die;

                                                                    $arr_jns = [];
                                                                    $arr_pl = [];

                                                                    if(!empty($modPl)) {
                                                                        foreach($modPl as $pl) {
                                                                            array_push($arr_jns, $pl->jenispemeriksaanlab_id);
                                                                            array_push($arr_pl, $pl->pemeriksaanlab_id);
                                                                        }
                                                                    }

                                                                    $cekperiksa = '';

                                                                    $nama_subjenis = array();
                                                                    // echo '<pre>';
                                                                    foreach ($modPeriksaLab as $j => $pemeriksaan) {

                                                                        $nama_pemeriksaan = $pemeriksaan->pemeriksaanlab_nama;
                                                                        $sub = '';

                                                                        $input_sub_hidden = "";

                                                                        if(!empty($pemeriksaan->subjenis_pemeriksaanlab_id)) {

                                                                            if (in_array($pemeriksaan->subjenis_pemeriksaanlab_id, $nama_subjenis)) {
                                                                                $input_sub_hidden = 'style="display:none !important;"';
                                                                            }

                                                                            $nama_pemeriksaan = $pemeriksaan->subjenis->subjenis_pl_nama;
                                                                            $sub = ", "  . $pemeriksaan->subjenis_pemeriksaanlab_id;
                                                                            $nama_subjenis[$pemeriksaan->subjenis_pemeriksaanlab_id] = $pemeriksaan->subjenis_pemeriksaanlab_id;
                                                                        }


                                                                        // $tarif = TarifpemeriksaanlabruanganV::model()->find("pemeriksaanlab_id = $pemeriksaan->pemeriksaanlab_id and " . 'kelaspelayanan_id = ' . $post['RJPendaftaranT']['kelaspelayanan_id']);
                                                                        $tarif = 1;
                                                                        
                                                                        if ($jenisPeriksa->jenispemeriksaanlab_id == $pemeriksaan->jenispemeriksaanlab_id && !empty($tarif)) {
                                                                            $cekperiksa .= '<label class="checkbox inline sub-' . $pemeriksaan->subjenis_pemeriksaanlab_id . '" '.$input_sub_hidden.'>' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                                                                'value' => $pemeriksaan->pemeriksaanlab_id,
                                                                                'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_KLINIK . $sub . ");",
                                                                                'class' => 'input_ceklis',
                                                                                // 'class' => $pemeriksaan->subjenis_pemeriksaanlab_id
                                                                            ));

                                                                            // var_dump($nama_pemeriksaan . " --- " . $pemeriksaan->pemeriksaanlab_id);

                                                                            $cekperiksa .= "<span>" . $nama_pemeriksaan . "</span></label>";
                                                                            if ($input_sub_hidden == "") {
                                                                               $cekperiksa .= "<br>"; 
                                                                            }
                                                                        }
                                                                    } 
                                                                    // die;

                                                                    // $adajenis = 

                                                                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                                                        'id' => 'tabel-riwayatanamnesa-' . $i . '-' . $j,
                                                                        'content' => array(
                                                                            'content-detailanamnesa-' . $i . '-' . $j => array(
                                                                                'header' => '<h6>' . $jenisPeriksa->jenispemeriksaanlab_nama .  '</h6>',
                                                                                'isi' => $cekperiksa,
                                                                                'active' => false, //in_array($jenisPeriksa->jenispemeriksaanlab_id, $arr_jns),
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
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="white tab-pane" id="tab1-anatomi">
                            <!--<legend class="rim">PATOLOGI ANATOMI</legend>-->
                            <table>
                                <tr>
                                    <td>
                                        <div id="formPeriksaLab2">
                                            <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                                            <?php
                                            foreach ($modJenisPeriksaLab as $i => $jenisPeriksa) {
                                                $ceklist = false;
                                                $patologi = $jenisPeriksa->jenispemeriksaanlab_kelompok;
                                                if ($patologi != Params::PATOLOGI_KLINIK) {
                                                    ?>
                                                    <div class="boxtindakan" style="margin-bottom: 17px;">
                                                        <div class="panel panel-success">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    <h6><?php echo $jenisPeriksa->jenispemeriksaanlab_nama; ?></h6>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <?php
                                                                foreach ($modPeriksaLab as $j => $pemeriksaan) {
                                                                    if ($jenisPeriksa->jenispemeriksaanlab_id == $pemeriksaan->jenispemeriksaanlab_id) {
                                                                        echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                                                            'value' => $pemeriksaan->pemeriksaanlab_id,
                                                                            'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_ANATOMI . ");",
                                                                            'class' => 'input_ceklis',
                                                                        ));
                                                                        echo "<span>" . $pemeriksaan->pemeriksaanlab_nama . " - " . $pemeriksaan->pemeriksaanlab_kode ?? ''."</span></label><br>";
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>



<script>


// $(document).ready(function () {

    $('#formPeriksaLab').tile({
        widths: [300]
    });

    $('.accordion-toggle').attr('style', 'width: 250px;');
    $('.glyphicon-chevron-down').attr('style', 'font-size:16px; margin-top: -30px;');
    $('.accordion-inner').attr('style', 'width: 250px;');

// }

$(document).ready(function () {

<?php /* if(!empty($arr_pl)) {?>
<?php foreach($arr_pl as $pl) {?>
    $('.td-klinik').find('input[value="' + <?= $pl ?> + '"]').click();
<?php  }
} */ ?>


});




</script>