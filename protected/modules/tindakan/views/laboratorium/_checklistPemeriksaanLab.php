<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>

<div class="white tab-pane" id="tab1-klinik">
                            <!--<legend class="rim">PATOLOGI KLINIK</legend>-->

                            <table>
                                <tr>
                                    <td>
                                        <div id="formPeriksaLabShow" class="">

                                        </div>
                                        <div id="formPeriksaLab" class="show ">
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

                                                                    $cekperiksa = '';

                                                                    foreach ($modPeriksaLab as $j => $pemeriksaan) {
                                                                        if ($jenisPeriksa->jenispemeriksaanlab_id == $pemeriksaan->jenispemeriksaanlab_id) {
                                                                            $cekperiksa .= '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                                                                'value' => $pemeriksaan->pemeriksaanlab_id,
                                                                                'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_KLINIK . ");"
                                                                            ));
                                                                            $cekperiksa .= "<span>" . $pemeriksaan->pemeriksaanlab_nama . " - " . $pemeriksaan->pemeriksaanlab_kode ?? '' ."</span></label><br>";
                                                                        }
                                                                    }


                                                                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                                                        'id' => 'tabel-riwayatanamnesa-' . $i . '-' . $j,
                                                                        'content' => array(
                                                                            'content-detailanamnesa-' . $i . '-' . $j => array(
                                                                                'header' => '<h6>' . $jenisPeriksa->jenispemeriksaanlab_nama .  '</h6>',
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
                                                                            'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_ANATOMI . ");"
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


                        </script>