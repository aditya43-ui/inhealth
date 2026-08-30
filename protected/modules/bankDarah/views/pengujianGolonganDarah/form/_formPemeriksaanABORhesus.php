<style>
    #table-aborhesus th, td{
        text-align: center;
    }
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan <b>Golongan Darah ABO dan Rhesus</b>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered table-condensed" width="100" id="table-aborhesus">
            <thead>
                <tr>
                    <th colspan="11">PEMERIKSAAN GOLONGAN DARAH ABO DAN RHESUS</th>
                </tr>
                <tr>
                    <th colspan="2" rowspan="2"></th>
                    <th colspan="2">Sel Grouping</th>
                    <th colspan="3">Serum Grouping</th>
                    <th>Auto Control</th>
                    <th colspan="2">Rhesus Faktor</th>
                    <th colspan="2">Jam</th>
                </tr>
                <tr>
                    <th colspan="2">1 Tetes Sel 10%</th>
                    <th colspan="3">2 Tetes Serum</th>
                    <th>2 Tetes Serum</th>
                    <th colspan="2">1 Tetes Sel 40%</th>
                    <th colspan="2" rowspan="2"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><?= $modPasien->nama_pasien ?></td>
                    <td>
                        1 Tetes <br>
                        Anti - A <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'selgrouping_antia') ?>
                    </td>
                    <td>
                        1 Tetes <br>
                        Anti - B <br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'selgrouping_antib') ?>
                    </td>
                    <td>
                        1 Tetes <br>
                        Tes sel - <b>A</b> 10%<br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'serumgrouping_a') ?>
                    </td>
                    <td>
                        1 Tetes <br>
                        Tes sel - <b>B</b> 10%<br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'serumgrouping_b') ?>
                    </td>
                    <td>
                        1 Tetes <br>
                        Tes sel - <b>O</b> 10%<br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'serumgrouping_o') ?>
                    </td>
                    <td>
                        1 Tetes <br>
                        Sel 10%<br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'autocontrol') ?>
                    </td>
                    <td>
                        1 Tetes <br>
                        Anti - D<br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'rhesusfaktor_d') ?>
                    </td>
                    <td>
                        1 Tetes <br>
                        Bv. Albumin 6%<br>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'rhesusfaktor_albumin') ?>
                    </td>
                    <td colspan="2">
                        <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modHasilUjiCocok,
                                'attribute' => 'jam_pemeriksaangoldar',
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
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="10">Diaduk hingga tercampur rata <i class="entypo-right-bold"></i> LIHAT REAKSI / BACA HASIL </th>
                    <th>
                        <?php echo $form->checkBox($modHasilUjiCocok, 'bacahasil') ?>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>