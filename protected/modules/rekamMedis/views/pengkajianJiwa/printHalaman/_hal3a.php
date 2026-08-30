
<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
?>

<div class="panel_main">
    <div class="panel_judul">
        VI. SOSIAL-KULTUR-SPIRITUAL
    </div>
    <div class="panel_body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <ol style="list-style: decimal" start="2">
                    <li>
                        Hubungan Sosial
                        <ol style="list-style: lower-alpha">
                            <li>
                                Orang Terdekat :<br/>
                                <?php echo empty($model->hubsosial_orangterdekat) ? "-" : $model->hubsosial_orangterdekat; ?>
                            </li>
                            <li>
                                Peran serta dalam kegiatan kelompok/masyarakat :<br/>
                                <?php echo empty($model->hubsosial_peransertadlmkegiatan) ? "-" : $model->hubsosial_peransertadlmkegiatan; ?>
                            </li>
                            <li>
                                Hambatan dalam berhubungan dengan orang lain :<br/>
                                <?php echo empty($model->hubsosial_hambatandlmhubdgnoranglain) ? "-" : $model->hubsosial_hambatandlmhubdgnoranglain; ?>
                            </li>
                        </ol>
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
                            'kelompokdiagnosa' => 'hubungan_sosial',
                        ));
                        ?>
                        <?php
                        echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                            'diagnosa' => $diagnosa,
                            'label_diagnosa' => 'Diagnosa Psikososial',
                            'jenisdiagnosa' => 'diagnosa_psikososial',
                            'kelompokdiagnosa' => 'hubungan_sosial',
                        ));
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-sm-6">
                <ol style="list-style: decimal" start="3">
                    <li>
                        Spiritual
                        <ol style="list-style: lower-alpha">
                            <li>
                                Nilai dan keyakinan :<br/>
                                <?php echo empty($model->spiritual_nilaikeyakinan) ? "-" : $model->spiritual_nilaikeyakinan; ?>
                            </li>
                            <li>
                                Kegiatan ibadah :<br/>
                                <?php echo empty($model->spiritual_kegiatanibadah) ? "-" : $model->spiritual_kegiatanibadah; ?>
                            </li>
                            <li>
                                Pengaruh spiritual terhadap koping individu :<br/>
                                <?php echo empty($model->spiritual_pengaruhterhadapkoping) ? "-" : $model->spiritual_pengaruhterhadapkoping; ?>
                            </li>
                        </ol>
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
                            'kelompokdiagnosa' => 'spiritual',
                        ));
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="panel_main">
    <div class="panel_judul">
        VII. STATUS MENTAL
    </div>
    <div class="panel_body">
        <ol style="list-style: decimal">
            <li>
                Deskripsi Umum
                <ol style="list-style: lower-alpha">
                    <li>
                        Penampilan

                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <table class="tab_info">
                                    <tbody>
                                        <tr>
                                            <td>Cara Berpakaian</td>
                                            <td>:</td>
                                            <td>
                                                <?php
                                                $data_list = LookupM::getItemsUrutan('askepjiwa_caraberpakaian');
                                                $caraberpakaian = empty($model->caraberpakaian) ? array() : CJSON::decode($model->caraberpakaian);

                                                foreach ($data_list as $val => $label) :
                                                    ?>
                                                    <div>
                                                        <?php echo!empty($caraberpakaian) && is_array($caraberpakaian) && in_array($val, $caraberpakaian) ? $ceklis : $unceklis; ?>
                                                        <?php echo $label; ?>
                                                    </div>
                                                <?php endforeach; ?><br/>
                                                <br/>
                                                Jelaskan : <?php echo empty($model->caraberpakaian_penjelasan) ? "-" : $model->caraberpakaian_penjelasan; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Cara Berjalan dan Sikap Tubuh</td>
                                            <td>:</td>
                                            <td><?php echo empty($model->caraberjalan_sikaptubuh) ? "-" : $model->caraberjalan_sikaptubuh; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kebersihan</td>
                                            <td>:</td>
                                            <td><?php echo empty($model->kebersihan) ? "-" : $model->kebersihan; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Skpresi Wajah dan Kontak Mata</td>
                                            <td>:</td>
                                            <td><?php echo empty($model->ekspresiwajah) ? "-" : $model->ekspresiwajah; ?></td>
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
                                            'kelompokdiagnosa' => 'penampilan',
                                        ));
                                        ?>
                                        <?php
                                        echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                                            'diagnosa' => $diagnosa,
                                            'label_diagnosa' => 'Diagnosa Psikososial',
                                            'jenisdiagnosa' => 'diagnosa_psikososial',
                                            'kelompokdiagnosa' => 'penampilan',
                                        ));
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </li>
                    <li>
                        Pembicaraan
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <table class="tab_info">
                                    <tbody>
                                        <tr>
                                            <td>Frekuensi</td>
                                            <td>:</td>
                                            <td>
                                                <?php 
                                                $data_frek = array('Cepat'=>'Cepat', 'Lambat'=>'Lambat');

                                                foreach ($data_frek as $val => $label): 
                                                    echo '<div class="radio_d">';
                                                    echo $model->pembicaraan_frekuensi == $val ? $ceklis : $unceklis;
                                                    echo " ".$label."  ";
                                                    echo '</div>';
                                                endforeach; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Volume</td>
                                            <td>:</td>
                                            <td>
                                                <?php 
                                                $data_volume = array('Keras'=>'Keras', 'Lembut'=>'Lembut');

                                                foreach ($data_volume as $val => $label): 
                                                    echo '<div class="radio_d">';
                                                    echo $model->pembicaraan_volume == $val ? $ceklis : $unceklis;
                                                    echo " ".$label."  ";
                                                    echo '</div>';
                                                endforeach; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Karakteristik</td>
                                            <td>:</td>
                                            <td>
                                                <?php 
                                                $data_karakteristik = LookupM::getItemsUrutan('askepjiwa_karakteristipembicaraan');

                                                foreach ($data_karakteristik as $val => $label): 
                                                    echo '<div class="radio_d">';
                                                    echo $model->pembicaraan_karakteristik == $val ? $ceklis : $unceklis;
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
                                            'kelompokdiagnosa' => 'pembicaraan',
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