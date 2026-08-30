<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); ?>

<div class="biru tab-content">
                        <div class="white tab-pane" id="tab1-klinik">
                            <!--<fieldset class="box" class="tab-pane" id="tab1-klinik">-->
                            <!--<legend class="rim">PATOLOGI KLINIK</legend>-->
                            <table style="width: 100%; border: none;">
                                <tr>
                                    <td>
                                        <div id="formPeriksaLab">
                                            <?php foreach ($modJenisPeriksaLab as $i => $jenisPeriksa) {
                                                $ceklist = false;
                                                $patologi = $jenisPeriksa->jenispemeriksaanlab_kelompok;
                                                if ($patologi == Params::PATOLOGI_KLINIK) {
                                            ?>
                                                    <div class="col-sm-3">
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
                                            <?php }
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <!--</fieldset>-->
                        </div>
                        <div class="tab-pane" id="tab1-anatomi">
                            <!--<legend class="rim">PATOLOGI ANATOMI</legend>-->
                            <div class="white">
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td>
                                            <div id="formPeriksaLab">
                                                <?php foreach ($modJenisPeriksaLab as $i => $jenisPeriksa) {
                                                    $ceklist = false;
                                                    $patologi = $jenisPeriksa->jenispemeriksaanlab_kelompok;
                                                    if ($patologi != Params::PATOLOGI_KLINIK) {
                                                ?>
                                                        <div class="col-sm-4" style="margin-bottom: 17px;">
                                                            <div class="panel panel-success">
                                                                <div class="panel-heading">
                                                                    <div class="panel-title"><?php echo $jenisPeriksa->jenispemeriksaanlab_nama; ?></div>
                                                                </div>
                                                                <div class="panel-body boxtindakan">
                                                                    <?php foreach ($modPeriksaLab as $j => $pemeriksaan) {
                                                                        if ($jenisPeriksa->jenispemeriksaanlab_id == $pemeriksaan->jenispemeriksaanlab_id) {
                                                                            echo '<label class="checkbox inline">' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                                                                'value' => $pemeriksaan->pemeriksaanlab_id,
                                                                                'onclick' => "inputperiksa(this,".Params::RUANGAN_ID_LAB_ANATOMI.");"));
                                                                                
                                                                            echo "<span>" . $pemeriksaan->pemeriksaanlab_nama . "</span></label><br>";
                                                                        }
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php }
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>


                    <script>

$('#formPeriksaLab').tile({
        widths: [300]
    });

    $('.accordion-toggle').attr('style', 'width: 250px;');
    $('.glyphicon-chevron-down').attr('style', 'font-size:16px; margin-top: -30px;');
    $('.accordion-inner').attr('style', 'width: 250px;');

                    </script>