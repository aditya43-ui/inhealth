
<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
?>

<div class="panel_main">
    <div class="panel_judul">
        V. FISIK
    </div>
    <div class="panel_body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <ol style="list-style: decimal">
                    <li>
                        Tanda Vital
                        <table class="tab_info">
                            <tbody>
                                <tr>
                                    <td>Tekanan Darah</td>
                                    <td>:</td>
                                    <td><?php echo (empty($model->td_systolic) ? "-" : $model->td_systolic) . " / " . (empty($model->td_diastolic) ? "-" : $model->td_diastolic) ?> mmHg</td>
                                </tr>
                                <tr>
                                    <td>Nadi</td>
                                    <td>:</td>
                                    <td><?php echo (empty($model->nadi) ? "-" : $model->nadi); ?> x/meni</td>
                                </tr>
                                <tr>
                                    <td>Pernapasan</td>
                                    <td>:</td>
                                    <td><?php echo (empty($model->pernapasan) ? "-" : $model->pernapasan); ?> x/menit</td>
                                </tr>
                                <tr>
                                    <td>Suhu</td>
                                    <td>:</td>
                                    <td><?php echo (empty($model->suhutubuh) ? "-" : number_format($model->suhutubuh, 2, ",", "")); ?> &deg;C</td>
                                </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        Ukur
                        <table class="tab_info">
                            <tbody>
                                <tr>
                                    <td>Tinggi Badan/Panjang Badan</td>
                                    <td>:</td>
                                    <td><?php echo (empty($model->tinggibadan) ? "-" : number_format($model->tinggibadan, 2, ",", "")); ?> cm</td>
                                </tr>
                                <tr>
                                    <td>Berat Badan</td>
                                    <td>:</td>
                                    <td>
                                        <?php echo (empty($model->beratbadan) ? "-" : number_format($model->beratbadan, 2, ",", "")); ?> Kg<br/>
                                        <span><?php echo $model->hasilukur_bbtb == "Turun" ? $ceklis : $unceklis ?> Turun </span>
                                        <span><?php echo!$model->hasilukur_bbtb == "Naik" ? $ceklis : $unceklis ?> Naik </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </li>
                    <li>
                        Keluhan Fisik : 
                        <span><?php echo $model->keluhanfisik_status == "Ya" ? $ceklis : $unceklis ?> Ya </span>
                        <span><?php echo!$model->keluhanfisik_status == "Tidak" ? $ceklis : $unceklis ?> Tidak </span>
                        <br/>
                        <br/>
                        Jelaskan : <?php echo!empty($model->keluhanfisik_penjelasan) ? "" : $model->keluhanfisik_penjelasan; ?><br/>
                        Diagnosa Keperawatan : <?php echo empty($model->fisik_diagnosakeperawatan) ? "-" : $model->fisik_diagnosakeperawatan; ?><br/>
                    </li>
                </ol>
            </div>
            <div class="col-sm-6">
                <table class="tab_info">
                    <tbody>
                        <?php
                        echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                            'diagnosa' => $diagnosa,
                            'label_diagnosa' => 'Diagnosa Fisik',
                            'jenisdiagnosa' => 'diagnosa_fisik',
                            'kelompokdiagnosa' => 'diagnosa_fisik',
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
        VI. SOSIAL KULTUR SPIRITUAL
    </div>
    <div class="panel_body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <ol style="list-style: decimal">
                    <li>
                        Konsep Diri

                        <ol style="list-style: lower-alpha">
                            <li>
                                Citra Tubuh :<br/>
                                <?php echo empty($model->konsepdiri_citratubuh) ? "-" : $model->konsepdiri_citratubuh; ?>
                            </li>
                            <li>
                                Identitas :<br/>
                                <?php echo empty($model->konsepdiri_identitas) ? "-" : $model->konsepdiri_identitas; ?>
                            </li>
                            <li>
                                Peran :<br/>
                                <?php echo empty($model->konsepdiri_peran) ? "-" : $model->konsepdiri_peran; ?>
                            </li>
                            <li>
                                Ideal Diri :<br/>
                                <?php echo empty($model->konsepdiri_idealdiri) ? "-" : $model->konsepdiri_idealdiri; ?>
                            </li>
                            <li>
                                Harga Diri :<br/>
                                <?php echo empty($model->konsepdiri_hargadiri) ? "-" : $model->konsepdiri_hargadiri; ?>
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
                            'kelompokdiagnosa' => 'konsepdiri',
                        ));
                        ?>
                        <?php
                        echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                            'diagnosa' => $diagnosa,
                            'label_diagnosa' => 'Diagnosa Psikososial',
                            'jenisdiagnosa' => 'diagnosa_psikososial',
                            'kelompokdiagnosa' => 'konsepdiri',
                        ));
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>