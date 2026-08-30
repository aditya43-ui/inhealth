<style>
    #table-ujicocok th, td{
        text-align: center;
    }
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Tabel Pemeriksaan <b>Uji Cocok Serasi</b>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed" width="100" id="table-ujicocok">
            <thead>
                <tr>
                    <th colspan="13">PEMERIKSAAN UJI COCOK SERASI</th>
                </tr>
                <tr>
                    <th rowspan="2">Medium</th>
                    <th colspan="4">Mayor</th>
                    <th colspan="4">Minor</th>
                    <th rowspan="2">AUTO CONTROL</th>
                    <th rowspan="2">POOL I</th>
                    <th rowspan="2">POOL II</th>
                    <th rowspan="2">JAM</th>
                </tr>
                <tr>
                    <th>I</th>
                    <th>II</th>
                    <th>III</th>
                    <th>IV</th>

                    <th>I</th>
                    <th>II</th>
                    <th>III</th>
                    <th>IV</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="2"><?= $modPasien->nama_pasien ?></td>

                    <!-- mayor baris 1 -->
                    <td>
                        25 uL <br>
                        Serum <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'mayor1_serum') ?>
                    </td>
                    <td>
                        25 uL <br>
                        Serum <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'mayor2_serum') ?>
                    </td>
                    <td>
                        25 uL <br>
                        Serum <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'mayor3_serum') ?>
                    </td>
                    <td>
                        25 uL <br>
                        Serum <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'mayor4_serum') ?>
                    </td>

                    <!-- minor baris 1 -->
                    <td>
                        25 uL Plasma<br>
                        Donor I <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'minor1_plasma') ?>
                    </td>
                    <td>
                        25 uL Plasma<br>
                        Donor II <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'minor2_plasma') ?>
                    </td>
                    <td>
                        25 uL Plasma<br>
                        Donor III <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'minor3_plasma') ?>
                    </td>
                    <td>
                        25 uL Plasma<br>
                        Donor IV <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'minor4_plasma') ?>
                    </td>

                    <!-- auto control baris 1 -->
                    <td>
                        25 uL <br>
                        Serum Pasien <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'ac_serum') ?>
                    </td>

                    <!-- pool 1 baris 1 -->
                    <td>
                        25 uL <br>
                        Plasma Dn I + II <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'pool1_plasma') ?>
                    </td>

                    <!-- pool 2 baris 1 -->
                    <td>
                        25 uL <br>
                        Plasma Dn III+ <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'pool2_plasma') ?>
                    </td>

                    <!-- jam -->
                    <td rowspan="2">
                        <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modHasilUjiCocok,
                                'attribute' => 'jam_pemeriksaancocokserasi',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'dtPicker3 readonly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                                ),
                            ));
                        ?>
                    </td>
                </tr>

                <tr>
                    <!-- mayor baris 2 -->
                    <td>
                        50 uL <br>
                        Sel Dnr I <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'mayor1_sel') ?>
                    </td>
                    <td>
                        50 uL <br>
                        Sel Dnr II <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'mayor2_sel') ?>
                    </td>
                    <td>
                        50 uL <br>
                        Sel Dnr III <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'mayor3_sel') ?>
                    </td>
                    <td>
                        50 uL <br>
                        Sel Dnr IV <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'mayor4_sel') ?>
                    </td>

                    <!-- minor baris 2 -->
                    <td>
                        50 uL <br>
                        Sel Pasien <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'minor1_sel') ?>
                    </td>
                    <td>
                        50 uL <br>
                        Sel Pasien <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'minor2_sel') ?>
                    </td>
                    <td>
                        50 uL <br>
                        Sel Pasien <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'minor3_sel') ?>
                    </td>
                    <td>
                        50 uL <br>
                        Sel Pasien <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'minor4_sel') ?>
                    </td>

                    <!-- auto control baris 2 -->
                    <td>
                        50 uL <br>
                        Sel Pasien <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'ac_sel') ?>
                    </td>

                    <!-- pool 1 baris 2 -->
                    <td>
                        50 uL <br>
                        Sel Dn I + II <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'pool1_sel') ?>
                    </td>

                    <!-- pool 2 baris 2 -->
                    <td>
                        50 uL <br>
                        Sel Dn I + II <br>
                        0.8% - 1% <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'pool2_sel') ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>