
<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
?>

<div class="panel_main">
    <div class="panel_judul">
        III. FAKTOR PREDISPOSISI
    </div>
    <div class="panel_body">
        <table class="tab_info">
            <tbody>
                <tr>
                    <td>c. Genogram</td>
                    <td>:</td>
                    <td>
                        <?php
                        if (!empty($model->genogram_gambar)) {
                            $data = CJSON::decode($model->genogram_gambar);
                            echo $data['svgout'];
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Jelaskan</td>
                    <td>:</td>
                    <td><?php echo $model->genogram_penjelasan; ?></td>
                </tr>
                <?php
                echo $this->renderPartial($this->path_view . "detailView._checkBoxDiagnosaJiwaPrint", array(
                    'diagnosa' => $diagnosa,
                    'label_diagnosa' => 'Diagnosa Gangguan',
                    'jenisdiagnosa' => 'diagnosa_gangguan',
                    'kelompokdiagnosa' => 'genogram',
                ));
                ?>
            </tbody>
        </table>
        <br/>
        <strong>3. Pengambilan Keputusan : <?php echo $model->pengambilankeputusan ?></strong><br/>
        <br/>
        <strong>4. Pola Komunikasi : <?php echo $model->polakomunikasi ?></strong><br/>
        <br/>
    </div>
</div>

<div class="panel_main">
    <div class="panel_judul">
        IV. FAKTOR PRESIPITASI
    </div>
    <div class="panel_body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <ol style="list-style: decimal">
                    <li>
                        <div>
                            Peristiwa yang dialami dalam waktu dekan<br/>
                            <?php echo $model->presipitasi_peristiwabrdialami ?>
                        </div>
                    </li>
                    <li>
                        <div>
                            Perubahan aktivitas hidup sehari-hari<br/>
                            <?php echo $model->presipitasi_perubahanadl ?>
                        </div>
                    </li>
                    <li>
                        <div>
                            Perubahan Fisik<br/>
                            <?php echo $model->presipitasi_perubahanfisik ?>
                        </div>
                    </li>
                    <li>
                        <div>
                            Lingkungan penuh kritik<br/>
                            <?php echo $model->presipitasi_lingkunganpenuhkritik ?>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="col-sm-6">
                <table class="tab_info">
                    <tbody>
                        <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwaPrint", array(
                            'diagnosa'=>$diagnosa,
                            'label_diagnosa'=>'Diagnosa Gangguan',
                            'jenisdiagnosa'=>'diagnosa_gangguan',
                            'kelompokdiagnosa'=>'faktorpersipitasi',
                        )); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

