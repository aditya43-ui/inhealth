<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>

<div class="panel panel-success panel_detail" id='panel_7'>
    <div class="panel-heading">
        <div class="panel-title">Status Mental : Deskripsi Umum & Status Emosi</div>
    </div>
    <div class="panel-body">
        <ol style="list-style: decimal">
            <li>
                Deskripsi Umum
                <ol style="list-style: lower-alpha">
                    <li>
                        Penampilan
                        <div>
                            <div class="label_d">Cara Berpakaian</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php
                                $data_list = LookupM::getItemsUrutan('askepjiwa_caraberpakaian');
                                $caraberpakaian = empty($model->caraberpakaian) ? array() : CJSON::decode($model->caraberpakaian);
                                
                                foreach ($data_list as $val => $label) : ?>
                                <div>
                                    <?php echo !empty($caraberpakaian) && is_array($caraberpakaian) && in_array($val, $caraberpakaian) ? $ceklis : $unceklis; ?>
                                    <?php echo $label; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Jelaskan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d"><?php echo empty($model->caraberpakaian_penjelasan) ? "-" : $model->caraberpakaian_penjelasan; ?></div>
                        </div>
                        <div>
                            <div class="label_d">Cara Berjalan dan Sikap Tubuh</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d"><?php echo empty($model->caraberjalan_sikaptubuh) ? "-" : $model->caraberjalan_sikaptubuh; ?></div>
                        </div>
                        <div>
                            <div class="label_d">Kebersihan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d"><?php echo empty($model->kebersihan) ? "-" : $model->kebersihan; ?></div>
                        </div>
                        <div>
                            <div class="label_d">Skpresi Wajah dan Kontak Mata</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d"><?php echo empty($model->ekspresiwajah) ? "-" : $model->ekspresiwajah; ?></div>
                        </div>
                        <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                            'diagnosa'=>$diagnosa,
                            'label_diagnosa'=>'Diagnosa Gangguan',
                            'jenisdiagnosa'=>'diagnosa_gangguan',
                            'kelompokdiagnosa'=>'penampilan',
                        )); ?>
                    </li>
                    <li>
                        Pembicaraan<br/>
                        <div>
                            <div class="label_d">Frekuensi</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php 
                                $data_frek = array('Cepat'=>'Cepat', 'Lambat'=>'Lambat');
                                
                                foreach ($data_frek as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo $model->pembicaraan_frekuensi == $val ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Volume</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php 
                                $data_volume = array('Keras'=>'Keras', 'Lembut'=>'Lembut');
                                
                                foreach ($data_volume as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo $model->pembicaraan_volume == $val ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Karakteristik</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php 
                                $data_karakteristik = LookupM::getItemsUrutan('askepjiwa_karakteristipembicaraan');
                                
                                foreach ($data_karakteristik as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo $model->pembicaraan_karakteristik == $val ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Jelaskan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d"><?php echo empty($model->pembicaraan_penjelasan) ? "-" : $model->pembicaraan_penjelasan; ?></div>
                        </div>
                        <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                            'diagnosa'=>$diagnosa,
                            'label_diagnosa'=>'Diagnosa Gangguan',
                            'jenisdiagnosa'=>'diagnosa_gangguan',
                            'kelompokdiagnosa'=>'pembicaraan',
                        )); ?>
                    </li>
                    <li>
                        Aktifitas Motorik<br/>
                        <div>
                            <div class="label_d">Tingkat Aktifitas</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php 
                                $data_aktifitas = LookupM::getItemsUrutan('askepjiwa_tingkataktivitas');
                                
                                foreach ($data_aktifitas as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo $model->tingkataktivitas == $val ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Jenis Aktifitas</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php 
                                $data_jenis = LookupM::getItemsUrutan('askepjiwa_jenisaktivitas');
                                $data_jenisaktifitas = empty($model->jenisaktivitas) ? array() : CJSON::decode($model->jenisaktivitas);
                                
                                foreach ($data_jenis as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_jenisaktifitas) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Isyarat Tubuh</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php 
                                $data_isyarat = LookupM::getItems('askepjiwa_isyarattubuh');
                                
                                foreach ($data_isyarat as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo $model->isyarattubuh == $val ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Interaksi Selama Wawancara</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php 
                                $interaksi = LookupM::getItemsUrutan('askepjiwa_interaksiselamawawancara');
                                $data_interaksi = empty($model->interaksiselama_wawancara) ? array() : CJSON::decode($model->interaksiselama_wawancara);
                                
                                foreach ($interaksi as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_interaksi) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <div class="label_d">Jelaskan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d"><?php echo empty($model->aktivitasmotorik_penjelasan) ? "-" : $model->aktivitasmotorik_penjelasan; ?></div>
                        </div>
                        <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                            'diagnosa'=>$diagnosa,
                            'label_diagnosa'=>'Diagnosa Gangguan',
                            'jenisdiagnosa'=>'diagnosa_gangguan',
                            'kelompokdiagnosa'=>'aktivitas_motorik',
                        )); ?>
                        <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                            'diagnosa'=>$diagnosa,
                            'label_diagnosa'=>'Diagnosa Psikososial',
                            'jenisdiagnosa'=>'diagnosa_psikososial',
                            'kelompokdiagnosa'=>'aktivitas_motorik',
                        )); ?>
                    </li>
                </ol>
                
            </li>
            <li>
                Status Emosi
                <ol style="list-style: lower-alpha">
                    <li>
                        <div>
                            <div class="label_l">Alam Perasaan</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php 
                                $alamperasaan = LookupM::getItemsUrutan('askepjiwa_alamperasaan');
                                $data_alamperasaan = empty($model->alamperasaan) ? array() : CJSON::decode($model->alamperasaan);
                                
                                foreach ($alamperasaan as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_alamperasaan) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                                <div>
                                    <div class="label_d">Jelaskan</div>
                                    <div class="kolon_d">:</div>
                                    <div class="body_d"><?php echo empty($model->pembicaraan_penjelasan) ? "-" : $model->pembicaraan_penjelasan; ?></div>
                                </div>
                                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                                    'diagnosa'=>$diagnosa,
                                    'label_diagnosa'=>'Diagnosa Gangguan',
                                    'jenisdiagnosa'=>'diagnosa_gangguan',
                                    'kelompokdiagnosa'=>'alamperasaan',
                                )); ?>
                                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                                    'diagnosa'=>$diagnosa,
                                    'label_diagnosa'=>'Diagnosa Psikososial',
                                    'jenisdiagnosa'=>'diagnosa_psikososial',
                                    'kelompokdiagnosa'=>'alamperasaan',
                                )); ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div>
                            <div class="label_l">Afek</div>
                            <div class="kolon_d">:</div>
                            <div class="body_d">
                                <?php 
                                $afek = LookupM::getItemsUrutan('askepjiwa_afek');
                                $data_afek = empty($model->afek) ? array() : CJSON::decode($model->afek);
                                
                                foreach ($afek as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $afek) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                                <div>
                                    <div class="label_d">Jelaskan</div>
                                    <div class="kolon_d">:</div>
                                    <div class="body_d"><?php echo empty($model->afek_penjelasan) ? "-" : $model->afek_penjelasan; ?></div>
                                </div>
                                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                                    'diagnosa'=>$diagnosa,
                                    'label_diagnosa'=>'Diagnosa Gangguan',
                                    'jenisdiagnosa'=>'diagnosa_gangguan',
                                    'kelompokdiagnosa'=>'afek',
                                )); ?>
                                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                                    'diagnosa'=>$diagnosa,
                                    'label_diagnosa'=>'Diagnosa Psikososial',
                                    'jenisdiagnosa'=>'diagnosa_psikososial',
                                    'kelompokdiagnosa'=>'afek',
                                )); ?>
                            </div>
                        </div>
                    </li>
                </ol>
            </li>
        </ol>
    </div>
</div>
