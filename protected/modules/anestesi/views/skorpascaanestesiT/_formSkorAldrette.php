<div class="row-fluid" style='overflow-x: scroll;'>
    <div class="col-sm-12">
        <table id="table-anggota" class="table table-striped table-bordered table-condensed" width='100%'>
            <thead>
                <tr>
                    <th colspan="14" style='text-align: center;'>SKOR ALDRETTE PASCA ANESTESI / SEDASI</th>
                </tr>
                <tr>
                    <th colspan="2">TD Pra Anestesi : <?php
                            echo $form->textField($modAldrette,'sistolik', array('class' => 'span2 numbers-only','placeholder'=>'sistolik'));
                        ?> / <?php
                            echo $form->textField($modAldrette,'diastolik', array('class' => 'span2  numbers-only','placeholder'=>'diastolik'));
                        ?> mmHg</th>
                    <th style="text-align:center;">Nilai</th>
                    <th style="text-align:center;">Jam</th>
                    <th style="text-align:center;">0"</th>
                    <th style="text-align:center;">5"</th>
                    <th style="text-align:center;">15"</th>
                    <th style="text-align:center;">30"</th>
                    <th style="text-align:center;">45"</th>
                    <th style="text-align:center;">1'</th>
                    <th style="text-align:center;">2'</th>
                    <th style="text-align:center;">3'</th>
                    <th style="text-align:center;">4'</th>
                    <th style="text-align:center;">Keluar</th>
                </tr>
            </thead>
            <tbody>
                <!-- Baris Sirkulasi-->
                <tr>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">Sirkulasi</td>
                    <td>TD +/- 20 mmHg dari normal</td>
                    <td>2</td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center; width: 170px;">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modAldrette,
                            'attribute' => 'aldrette_sirkulasi_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class'=>'span2', 'style' => 'float:left',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_sirkulasi_0', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(0);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_sirkulasi_5', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(5);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_sirkulasi_15', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(15);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_sirkulasi_30', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(30);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_sirkulasi_45', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(45);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_sirkulasi_1', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(1);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_sirkulasi_2', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(2);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_sirkulasi_3', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(3);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_sirkulasi_4', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(4);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_sirkulasi_keluar', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungKeluar();'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>TD +/- 20-50 mmHg dari normal</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>TD +/- >50 mmHg dari normal</td>
                    <td>0</td>
                </tr>
                <!-- End Baris Sirkulasi-->
                
                <!-- Baris Kesadaran-->
                <tr>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">Kesadaran</td>
                    <td>Sadar Penuh</td>
                    <td>2</td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center; width: 170px;">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modAldrette,
                            'attribute' => 'aldrette_kesadaran_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class'=>'span2', 'style' => 'float:left',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_kesadaran_0', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(0);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_kesadaran_5', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(5);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_kesadaran_15', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(15);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_kesadaran_30', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(30);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_kesadaran_45', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(45);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_kesadaran_1', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(1);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_kesadaran_2', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(2);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_kesadaran_3', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(3);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_kesadaran_4', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(4);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_kesadaran_keluar', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotalKeluar();'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Respon terhadap panggilan</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Tidak ada respon</td>
                    <td>0</td>
                </tr>
                <!-- End Baris Kesadaran-->
                
                <!-- Baris Oksigenasi-->
                <tr>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">Oksigenasi</td>
                    <td>SpO2 > 92% (dengan udara bebas)</td>
                    <td>2</td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center; width: 170px;">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modAldrette,
                            'attribute' => 'aldrette_oksigensi_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class'=>'span2', 'style' => 'float:left',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_oksigensi_0', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(0);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_oksigensi_5', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(5);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_oksigensi_15', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(15);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_oksigensi_30', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(30);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_oksigensi_45', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(45);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_oksigensi_1', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(1);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_oksigensi_2', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(2);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_oksigensi_3', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(3);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_oksigensi_4', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(4);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_oksigensi_keluar', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotalKeluar();'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>SpO2 > 90% (dengan suplemen O2)</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>SpO2 < 90% (dengan suplemen O2)</td>
                    <td>0</td>
                </tr>
                <!-- End Baris Oksigenasi-->
                
                <!-- Baris Pernapasan-->
                <tr>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">Pernafasan</td>
                    <td>Bisa menarik nafas dalam dan batuk bebas</td>
                    <td>2</td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center; width: 170px;">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modAldrette,
                            'attribute' => 'aldrette_pernafasan_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class'=>'span2', 'style' => 'float:left',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_pernafasan_0', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(0);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_pernafasan_5', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(5);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_pernafasan_15', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(15);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_pernafasan_30', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(30);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_pernafasan_45', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(45);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_pernafasan_1', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(1);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_pernafasan_2', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(2);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_pernafasan_3', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(3);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_pernafasan_4', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(4);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_pernafasan_keluar', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotalKeluar();'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Dispneu atau limitasi bernapas</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Apnea / tidak bernapas</td>
                    <td>0</td>
                </tr>
                <!-- End Baris Pernapasan-->
                
                <!-- Baris Aktifitas-->
                <tr>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">Aktifitas</td>
                    <td>Menggerakkan 4 ekstremitas</td>
                    <td>2</td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center; width: 170px;">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modAldrette,
                            'attribute' => 'aldrette_aktifitas_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class'=>'span2', 'style' => 'float:left',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_aktifitas_0', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(0);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_aktifitas_5', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(5);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_aktifitas_15', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(15);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_aktifitas_30', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(30);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_aktifitas_45', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(45);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_aktifitas_1', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(1);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_aktifitas_2', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(2);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_aktifitas_3', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(3);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_aktifitas_4', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotal(4);'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->dropDownList($modAldrette,'aldrette_aktifitas_keluar', CHtml::listData($nilaiAldrette,'lookup_value','lookup_name'), array('class' => 'span1','empty'=>'-- Pilih--','onChange'=>'hitungTotalKeluar();'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Menggerakkan 2 ekstremitas</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Tidak mampu menggerakkan ekstremitas</td>
                    <td>0</td>
                </tr>
                <!-- End Baris Aktifitas-->
                <tr>
                    <td colspan="2" style="vertical-align: middle;text-align: center;">Catatan</td>
                    <td style="vertical-align: middle;text-align: center;">Total</td>
                    <td ></td>
                    <td style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->textField($modAldrette,'aldrette_total_0',array('class' => 'span1','readonly'=>true));
                        ?>
                    </td>
                    <td style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->textField($modAldrette,'aldrette_total_5',array('class' => 'span1','readonly'=>true));
                        ?>
                    </td>
                    <td style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->textField($modAldrette,'aldrette_total_15',array('class' => 'span1','readonly'=>true));
                        ?>
                    </td>
                    <td style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->textField($modAldrette,'aldrette_total_30',array('class' => 'span1','readonly'=>true));
                        ?>
                    </td>
                    <td style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->textField($modAldrette,'aldrette_total_45',array('class' => 'span1','readonly'=>true));
                        ?>
                    </td>
                    <td style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->textField($modAldrette,'aldrette_total_1',array('class' => 'span1','readonly'=>true));
                        ?>
                    </td>
                    <td style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->textField($modAldrette,'aldrette_total_2',array('class' => 'span1','readonly'=>true));
                        ?>
                    </td>
                    <td style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->textField($modAldrette,'aldrette_total_3',array('class' => 'span1','readonly'=>true));
                        ?>
                    </td>
                    <td style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->textField($modAldrette,'aldrette_total_4',array('class' => 'span1','readonly'=>true));
                        ?>
                    </td>
                    <td style="vertical-align: middle;text-align: center;">
                        <?php
                            echo $form->textField($modAldrette,'aldrette_total_keluar',array('class' => 'span1','readonly'=>true));
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>