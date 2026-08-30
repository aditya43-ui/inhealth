
<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
?>

<div class="panel_main">
    <div class="panel_judul">
        VII. STATUS MENTAL
    </div>
    <div class="panel_body">
        <ol style="list-style: none">
            <li>
                <ol style="list-style: lower-alpha" start="3">
                    <li>
                        Akivitas Motorik
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <table class="tab_info">
                                    <tbody>
                                        <tr>
                                            <td>Tingkat Aktifitas</td>
                                            <td>:</td>
                                            <td>
                                                <?php 
                                                $data_aktifitas = LookupM::getItemsUrutan('askepjiwa_tingkataktivitas');

                                                foreach ($data_aktifitas as $val => $label): 
                                                    echo '<div class="radio_d">';
                                                    echo $model->tingkataktivitas == $val ? $ceklis : $unceklis;
                                                    echo " ".$label."  ";
                                                    echo '</div>';
                                                endforeach; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Aktifitas</td>
                                            <td>:</td>
                                            <td>
                                                <?php 
                                                $data_jenis = LookupM::getItemsUrutan('askepjiwa_jenisaktivitas');
                                                $data_jenisaktifitas = empty($model->jenisaktivitas) ? array() : CJSON::decode($model->jenisaktivitas);

                                                foreach ($data_jenis as $val => $label): 
                                                    echo '<div class="radio_d">';
                                                    echo in_array($val, $data_jenisaktifitas) ? $ceklis : $unceklis;
                                                    echo " ".$label."  ";
                                                    echo '</div>';
                                                endforeach; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Isyarat Tubuh</td>
                                            <td>:</td>
                                            <td>
                                                <?php 
                                                $data_isyarat = LookupM::getItems('askepjiwa_isyarattubuh');

                                                foreach ($data_isyarat as $val => $label): 
                                                    echo '<div class="radio_d">';
                                                    echo $model->isyarattubuh == $val ? $ceklis : $unceklis;
                                                    echo " ".$label."  ";
                                                    echo '</div>';
                                                endforeach; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Interaksi Selama Wawancara</td>
                                            <td>:</td>
                                            <td>
                                                <?php 
                                                $interaksi = LookupM::getItemsUrutan('askepjiwa_interaksiselamawawancara');
                                                $data_interaksi = empty($model->interaksiselama_wawancara) ? array() : CJSON::decode($model->interaksiselama_wawancara);

                                                foreach ($interaksi as $val => $label): 
                                                    echo '<div class="radio_d">';
                                                    echo in_array($val, $data_interaksi) ? $ceklis : $unceklis;
                                                    echo " ".$label."  ";
                                                    echo '</div>';
                                                endforeach; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jelaskan</td>
                                            <td>:</td>
                                            <td><?php echo empty($model->aktivitasmotorik_penjelasan) ? "-" : $model->aktivitasmotorik_penjelasan; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <table class="tab_info">
                                    <tbody>
                                        <?php
                                        echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                                            'diagnosa' => $diagnosa,
                                            'label_diagnosa' => 'Diagnosa Gangguan',
                                            'jenisdiagnosa' => 'diagnosa_gangguan',
                                            'kelompokdiagnosa' => 'aktivitas_motorik',
                                        ));
                                        ?>
                                        <?php
                                        echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                                            'diagnosa' => $diagnosa,
                                            'label_diagnosa' => 'Diagnosa Psikososial',
                                            'jenisdiagnosa' => 'diagnosa_psikososial',
                                            'kelompokdiagnosa' => 'aktivitas_motorik',
                                        ));
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </li>
                </ol>
            </li>
        </ol>
        <ol style="list-style: decimal" start="2">
            <li>
                Status Emosi
                <ol style="list-style: lower-alpha">
                    <li>Alam Perasaan
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <table class="tab_info">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" style="text-align: left; font-weight: normal;">
                                                <?php 
                                                $alamperasaan = LookupM::getItemsUrutan('askepjiwa_alamperasaan');
                                                $data_alamperasaan = empty($model->alamperasaan) ? array() : CJSON::decode($model->alamperasaan);

                                                foreach ($alamperasaan as $val => $label): 
                                                    echo '<div class="radio_d">';
                                                    echo in_array($val, $data_alamperasaan) ? $ceklis : $unceklis;
                                                    echo " ".$label."  ";
                                                    echo '</div>';
                                                endforeach; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jelaskan</td>
                                            <td>:</td>
                                            <td><?php echo empty($model->pembicaraan_penjelasan) ? "-" : $model->pembicaraan_penjelasan; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <table class="tab_info">
                                    <tbody>
                                        <?php
                                        echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                                            'diagnosa' => $diagnosa,
                                            'label_diagnosa' => 'Diagnosa Gangguan',
                                            'jenisdiagnosa' => 'diagnosa_gangguan',
                                            'kelompokdiagnosa' => 'alamperasaan',
                                        ));
                                        ?>
                                        <?php
                                        echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                                            'diagnosa' => $diagnosa,
                                            'label_diagnosa' => 'Diagnosa Psikososial',
                                            'jenisdiagnosa' => 'diagnosa_psikososial',
                                            'kelompokdiagnosa' => 'alamperasaan',
                                        ));
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </li>
                </ol>
            </li>
        </ol>
    </div>
</div>

