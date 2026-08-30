<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
?>

<div class="panel_main">
    <div class="panel_judul">
        VII. STATUS MENTAL
    </div>
    <div class="panel_body">
        <ol style="list-style: decimal" start="5">
            <li>Sensori dan Kognisi
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <ol style="list-style: lower-alpha">
                            <li>Tingkat Kesadaran : <br/>
                                <?php 
                                $halu = LookupM::getItemsUrutan('askepjiwa_tingkatkesadaran');
                                $data_halu = empty($model->tingkatkesaradaran) ? array() : CJSON::decode($model->tingkatkesaradaran);

                                foreach ($halu as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                                <br/><br/>
                                <div>
                                    Jelaskan :
                                    <?php echo empty($model->tingakkesadaran_penjelasan) ? "-" : $model->tingakkesadaran_penjelasan; ?>
                                </div>
                            </li>
                            <li>Daya Ingat (Memory) : <br/>
                                <?php 
                                $halu = LookupM::getItemsUrutan('askepjiwa_dayaingat');
                                $data_halu = empty($model->dayaingat) ? array() : CJSON::decode($model->dayaingat);

                                foreach ($halu as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                                <br/><br/>
                                <div>
                                    Jelaskan :
                                    <?php echo empty($model->dayaingat_penjelasan) ? "-" : $model->dayaingat_penjelasan; ?>
                                </div>
                            </li>
                            <li>Tingkat Konsentrasi dan Berhitung : <br/>
                                <?php 
                                $halu = LookupM::getItemsUrutan('askepjiwa_konsentrasihitung');
                                $data_halu = empty($model->konsentasidanhitung) ? array() : CJSON::decode($model->konsentasidanhitung);

                                foreach ($halu as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                                <br/><br/>
                                <div>
                                    Jelaskan :
                                    <?php echo empty($model->konsentasidanhitung_penjelasan) ? "-" : $model->konsentasidanhitung_penjelasan; ?>
                                </div>
                            </li>
                            <li>Insight : <br/>
                                <?php 
                                $halu = array(
                                    'Menerima Sakitnya' => 'Menerima Sakitnya',
                                    'Mengingkari gangguan penyakit yang dideritanya' => 'Mengingkari gangguan penyakit yang dideritanya',
                                    'Menyalahkan hal-hal luar lainnya' => 'Menyalahkan hal-hal luar lainnya',
                                );
                                $data_halu = empty($model->insight) ? array() : CJSON::decode($model->insight);

                                foreach ($halu as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                                <br/><br/>
                                <div>
                                    Jelaskan :
                                    <?php echo empty($model->insgiht_penjelasan) ? "-" : $model->insgiht_penjelasan; ?>
                                </div>
                            </li>
                            <li>Pengambilan Keputusan (Judgement) : <br/>
                                <?php echo empty($model->pengambilankeputusan) ? "-" : $model->pengambilankeputusan; ?>
                            </li>
                        </ol>
                        
                    </div>
                    <div class="col-sm-6">
                        <table class="tab_info">
                            <tbody>
                                <?php
                                echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                                    'diagnosa' => $diagnosa,
                                    'label_diagnosa' => 'Diagnosa Gangguan',
                                    'jenisdiagnosa' => 'diagnosa_gangguan',
                                    'kelompokdiagnosa' => 'sensorikognisi',
                                ));
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </li>
        </ol>
    </div>
</div>