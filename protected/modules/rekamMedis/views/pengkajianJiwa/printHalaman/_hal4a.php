
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
                <ol style="list-style: lower-alpha" start="2">
                    <li>Afek
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <table class="tab_info">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" style="text-align: left; font-weight: normal;">
                                                <?php 
                                                $afek = LookupM::getItemsUrutan('askepjiwa_afek');
                                                $data_afek = empty($model->afek) ? array() : CJSON::decode($model->afek);

                                                foreach ($afek as $val => $label): 
                                                    echo '<div class="radio_d">';
                                                    echo in_array($val, $afek) ? $ceklis : $unceklis;
                                                    echo " ".$label."  ";
                                                    echo '</div>';
                                                endforeach; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jelaskan</td>
                                            <td>:</td>
                                            <td><?php echo empty($model->afek_penjelasan) ? "-" : $model->afek_penjelasan; ?></td>
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
                                            'kelompokdiagnosa' => 'afek',
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
        <ol style="list-style: decimal" start="3">
            <li>Persepsi
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <ol style="list-style: lower-alpha">
                            <li>Halusinasi :<br/>
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
                                <br/>
                                <div>
                                    Jelaskan : 
                                    <?php echo empty($model->halusinasi_penjelasan) ? "-" : $model->halusinasi_penjelasan; ?>
                                </div>

                            </li>
                            <li>
                                Ilusi : 
                                <?php echo empty($model->ilusi) ? "-" : $model->ilusi; ?>
                            </li>
                            <li>
                                Depersonalisasi : 
                                <?php echo empty($model->depersonalisasi) ? "-" : $model->depersonalisasi; ?>
                            </li>
                            <li>
                                Derealisasi : 
                                <?php echo empty($model->derelisasi) ? "-" : $model->derelisasi; ?>
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
                                    'kelompokdiagnosa' => 'persepsi',
                                ));
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </li>
            <li>Proses Pikir
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <ol style="list-style: lower-alpha">
                            <li>Bentuk Pikir :<br/>
                                <?php 
                                $halu = LookupM::getItemsUrutan('askepjiwa_bentukpikir');
                                $data_halu = empty($model->bentukpikir) ? array() : CJSON::decode($model->bentukpikir);

                                foreach ($halu as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                                <br/><br/>
                                <div>
                                    Jelaskan :
                                    <?php echo empty($model->bentukpikir_jelaskan) ? "-" : $model->bentukpikir_jelaskan; ?>
                                </div>
                            </li>
                            <li>Arus Pikir :<br/>
                                <?php 
                                $halu = LookupM::getItemsUrutan('askepjiwa_aruspikir');
                                $data_halu = empty($model->aruspikir) ? array() : CJSON::decode($model->aruspikir);

                                foreach ($halu as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                                <br/><br/>
                                <div>
                                    Jelaskan :
                                    <?php echo empty($model->aruspikir_jelaskan) ? "-" : $model->aruspikir_jelaskan; ?>
                                </div>
                            </li>
                            <li>Isi Pikir :<br/>
                                <?php 
                                $halu = LookupM::getItemsUrutan('askepjiwa_isipikir');
                                $data_halu = empty($model->isipikir) ? array() : CJSON::decode($model->isipikir);

                                foreach ($halu as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                            </li>
                            <li>Waham :<br/>
                                <?php 
                                $halu = LookupM::getItemsUrutan('askepjiwa_waham');
                                $data_halu = empty($model->waham) ? array() : CJSON::decode($model->waham);

                                foreach ($halu as $val => $label): 
                                    echo '<div class="radio_d">';
                                    echo in_array($val, $data_halu) ? $ceklis : $unceklis;
                                    echo " ".$label."  ";
                                    echo '</div>';
                                endforeach; ?>
                                <br/><br/>
                                <div>
                                    Jelaskan :
                                    <?php echo empty($model->waham_penjelasan) ? "-" : $model->waham_penjelasan; ?>
                                </div>
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
                                    'kelompokdiagnosa' => 'prosespikir',
                                ));
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </li>
    </div>
</div>