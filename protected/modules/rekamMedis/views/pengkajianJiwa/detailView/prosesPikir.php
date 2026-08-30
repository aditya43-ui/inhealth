<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>

<div class="panel panel-success panel_detail" id='panel_8'>
    <div class="panel-heading">
        <div class="panel-title">Status Mental : Persepsi, Proses Pikir & Sensori Kognisi</div>
    </div>
    <div class="panel-body">
        <ol style="list-style: decimal;" start="3">
            <li>
                Persepsi
                <ol style="list-style: lower-alpha">
                    <li>
                        <div class="label_l">Halusinasi</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php 
                            $halu = LookupM::getItemsUrutan('askepjiwa_halusinasi');
                            $data_halu = empty($model->halusinasi) ? array() : CJSON::decode($model->halusinasi);

                            foreach ($halu as $val => $label): 
                                echo '<div class="radio_d">';
                                echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                echo " ".$label."  ";
                                echo '</div>';
                            endforeach; ?>
                            <br/>
                            <div class="label_l">Penjelasan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->halusinasi_penjelasan) ? "-" : $model->halusinasi_penjelasan; ?>
                            </div>
                            
                        </div>
                    </li>
                    <li>
                        <div class="label_l">Ilusi</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php echo empty($model->ilusi) ? "-" : $model->ilusi; ?>
                        </div>
                    </li>
                    <li>
                        <div class="label_l">Depersonalisasi</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php echo empty($model->depersonalisasi) ? "-" : $model->depersonalisasi; ?>
                        </div>
                        
                    </li>
                    <li>
                        <div class="label_l">Derealisasi</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php echo empty($model->derelisasi) ? "-" : $model->derelisasi; ?>
                        </div>
                    </li>
                </ol>
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Gangguan',
                    'jenisdiagnosa'=>'diagnosa_gangguan',
                    'kelompokdiagnosa'=>'persepsi',
                )); ?>
            </li>
            <li>
                Proses Pikir
                <ol style="list-style: lower-alpha;">
                    <li>
                        <div class="label_l">Bentuk Pikir</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php 
                            $halu = LookupM::getItemsUrutan('askepjiwa_bentukpikir');
                            $data_halu = empty($model->bentukpikir) ? array() : CJSON::decode($model->bentukpikir);

                            foreach ($halu as $val => $label): 
                                echo '<div class="radio_d">';
                                echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                echo " ".$label."  ";
                                echo '</div>';
                            endforeach; ?>
                            <br/>
                            <div class="label_l">Penjelasan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->bentukpikir_jelaskan) ? "-" : $model->bentukpikir_jelaskan; ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="label_l">Arus Pikir</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php 
                            $halu = LookupM::getItemsUrutan('askepjiwa_aruspikir');
                            $data_halu = empty($model->aruspikir) ? array() : CJSON::decode($model->aruspikir);

                            foreach ($halu as $val => $label): 
                                echo '<div class="radio_d">';
                                echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                echo " ".$label."  ";
                                echo '</div>';
                            endforeach; ?>
                            <br/>
                            <div class="label_l">Penjelasan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->aruspikir_jelaskan) ? "-" : $model->aruspikir_jelaskan; ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="label_l">Isi Pikir (verbal maupun non verbal)</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php 
                            $halu = LookupM::getItemsUrutan('askepjiwa_isipikir');
                            $data_halu = empty($model->isipikir) ? array() : CJSON::decode($model->isipikir);

                            foreach ($halu as $val => $label): 
                                echo '<div class="radio_d">';
                                echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                echo " ".$label."  ";
                                echo '</div>';
                            endforeach; ?>
                        </div>
                    </li>
                    <li>
                        <div class="label_l">Waham</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php 
                            $halu = LookupM::getItemsUrutan('askepjiwa_waham');
                            $data_halu = empty($model->waham) ? array() : CJSON::decode($model->waham);

                            foreach ($halu as $val => $label): 
                                echo '<div class="radio_d">';
                                echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                echo " ".$label."  ";
                                echo '</div>';
                            endforeach; ?>
                            <br/>
                            <div class="label_l">Penjelasan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->waham_penjelasan) ? "-" : $model->waham_penjelasan; ?>
                            </div>
                        </div>
                    </li>
                </ol>
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Gangguan',
                    'jenisdiagnosa'=>'diagnosa_gangguan',
                    'kelompokdiagnosa'=>'prosespikir',
                )); ?>
                
            </li>
            <li>
                Sensori dan Kognisi
                <ol style="list-style: lower-alpha;">
                    <li>
                        <div class="label_l">Tingkat Kesadaran</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php 
                            $halu = LookupM::getItemsUrutan('askepjiwa_tingkatkesadaran');
                            $data_halu = empty($model->tingkatkesaradaran) ? array() : CJSON::decode($model->tingkatkesaradaran);

                            foreach ($halu as $val => $label): 
                                echo '<div class="radio_d">';
                                echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                echo " ".$label."  ";
                                echo '</div>';
                            endforeach; ?>
                            <br/>
                            <div class="label_l">Penjelasan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->tingakkesadaran_penjelasan) ? "-" : $model->tingakkesadaran_penjelasan; ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="label_l">Daya Ingat (Memory)</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php 
                            $halu = LookupM::getItemsUrutan('askepjiwa_dayaingat');
                            $data_halu = empty($model->dayaingat) ? array() : CJSON::decode($model->dayaingat);

                            foreach ($halu as $val => $label): 
                                echo '<div class="radio_d">';
                                echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                echo " ".$label."  ";
                                echo '</div>';
                            endforeach; ?>
                            <br/>
                            <div class="label_l">Penjelasan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->dayaingat_penjelasan) ? "-" : $model->dayaingat_penjelasan; ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="label_l">Tingkat Konsentrasi dan Berhitung</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php 
                            $halu = LookupM::getItemsUrutan('askepjiwa_konsentrasihitung');
                            $data_halu = empty($model->konsentasidanhitung) ? array() : CJSON::decode($model->konsentasidanhitung);

                            foreach ($halu as $val => $label): 
                                echo '<div class="radio_d">';
                                echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                echo " ".$label."  ";
                                echo '</div>';
                            endforeach; ?>
                            <br/>
                            <div class="label_l">Penjelasan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->konsentasidanhitung_penjelasan) ? "-" : $model->konsentasidanhitung_penjelasan; ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="label_l">Insight</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
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
                            <br/>
                            <div class="label_l">Penjelasan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php echo empty($model->insgiht_penjelasan) ? "-" : $model->insgiht_penjelasan; ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="label_l">Pengambilan Keputusan (Judgement)</div>
                        <div class="kolon_d">:</div>
                        <div class="body_d">
                            <?php echo empty($model->pengambilankeputusan) ? "-" : $model->pengambilankeputusan; ?>
                        </div>
                    </li>
                </ol>
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Gangguan',
                    'jenisdiagnosa'=>'diagnosa_gangguan',
                    'kelompokdiagnosa'=>'sensorikognisi',
                )); ?>
            </li>
        </ol>
    </div>
</div>